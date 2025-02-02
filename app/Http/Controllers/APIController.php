<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use App\Mail\WebsiteLive;
use GuzzleHttp\Middleware;
use App\Models\Webcreation;
use Illuminate\Http\Request;
use App\Mail\ErrorCreatingSite;
use App\Mail\CronResponseMail;
use App\Models\AdminClientOrder;
use App\Mail\WebsiteCreationDone;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Handler\CurlHandler;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\MailInvoiceOnSuccesfulPayment;

class APIController extends Controller
{
    public function getPendingSites()
    {
        $DB = new Webcreation();
        $lastRecord = DB::table('last_updated_record_for_webcreations')->first();
        $lastRecordId = !empty($lastRecord) ? $lastRecord->lastID : 0;
        
        $data = $DB->where([['web_creation', '=', 'pending'], ['id', '>', $lastRecordId]])->take(100)->get();
        
        if(count($data) > 0) {
            foreach ($data as $key => $value) {
                $data = $this->registerDomain($value->customer_id);
                if ($data !== null) {
                    $decoded = !$data->content() ? $data : json_decode($data->content());
                    if ($decoded->status === 200) {
                        // Update DB web_creation to success
                        $DB->find($value->id)->update(['web_creation' => 'success']);
                    } else {
                        // Send email to admin
                        Mail::to('goziechukwu@gmail.com')->send(new ErrorCreatingSite($value));
                    }
                }
            }
            $lastUpdatedIndex = $DB->latest('updated_at')->value('id');

            !empty($lastRecord) ? DB::table('last_updated_record_for_webcreations')->where('id', 1)->update(['lastID' => $lastUpdatedIndex]) : DB::table('last_updated_record_for_webcreations')->insert(['lastID' => $lastUpdatedIndex]);
            
            // Send email to admin
            $msg = 'Website creation operations done.';
            Mail::to('goziechukwu@gmail.com')->send(new CronResponseMail($msg));
        } else {
            // Send email to admin
            $msg = 'No outstanding website to create!';
            // Mail::to('goziechukwu@gmail.com')->send(new CronResponseMail($msg));
            return response()->json(['status' => 404, 'message' => $msg]);
        }
    }
    // Makes request to other APIs

    public function registerDomain($stripeId)
    {
        $users = new User();
        $tenants = new Tenant();
        $user = $users->where('stripe_id', $stripeId)->first();
        if ($user) {
            $tenant = $tenants->where('user_id', $user->id)->first();
            $tenantPassTB = DB::table('tenant_password_tables')->where('tenant_id', $tenant->id)->first();
            if (!empty($tenant)) {
                $domain = $tenant->domainName;
                // TODO: At the completion of website creation send message to user that site is now live
                $detail = [
                    'email' => $user->email,
                    'password' => $tenantPassTB->password,
                    'domain' => $domain,
                    'names' => $user->firstname.' '.$user->lastname,
                ];
                $domainDotCom = $domain;
                $years = 1;
                $key = env('NAMESILO_API_KEY');
                $api = env('NAMESILO_API_URL');
                try {
                    // $URL = "{$api}/registerDomain?version=1&type=xml&key={$key}&domain={$domainDotCom}&years={$years}&private=1&auto_renew=1";
                    // $client = new \GuzzleHttp\Client();
    
                    // $response = $client->request('GET', $URL);
                    // $body = $response->getBody();
                    // $xml = simplexml_load_string($body);
                    // if (htmlentities((string)$xml->reply->code) == 300) { // && htmlentities((string)$xml->reply->detail) == 'success'
                        return $this->runAWSUtility($domainDotCom, $detail);
                    // } else {
                    //     return response()->json(['message' => htmlentities((string)$xml->reply->detail), 'status' => htmlentities((string) $xml->reply->code)]);
                    // }
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                    exit;
                }
            } else {
                return response()->json(['status' => 404, 'message' => 'Payment made against a physician that does not exist']);
            }
        }else {
            return response()->json(['message' => 'User with StripeId Not found', 'status' => 404 ]);
        }

    }
    
    public function runAWSUtility($domain, $detail)
    {
        try {
            $handler = new CurlHandler();
            $client = new \GuzzleHttp\Client();
            $tapMiddleware = Middleware::tap(function ($request) {});
            $data = ["DomainName" => $domain];
            $response = $client->request('POST', env('AWS_UTILITY_URL'), [
                'json' => $data,
                'handler' => $tapMiddleware($handler)
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
            if ($data['status'] === 200) {
                // Send mail and run the aws sendcommand api
                $this->sendMail($detail);
                $this->runEmailForwarding($domain, $detail['email']);
                return $this->runAWSUtilityCommand($domain);
            } else {
                echo 'Not available:'. $response->getStatusCode();
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function runAWSUtilityCommand($domain)
    {
        try {
            $handler = new CurlHandler();
            $client = new \GuzzleHttp\Client();
            $tapMiddleware = Middleware::tap(function ($request) {});
            $data = ["DomainName" => $domain];

            $response = $client->request('POST', env('AWS_UTILITY_URL_SENDCOMMAND'), [
                'json' => $data,
                'handler' => $tapMiddleware($handler)
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
            if ($data['status'] === 200) {
                // return response()->json(['message' => 'Success', 'status' => $data['status']]);
                return response()->json(['message' => 'Success', 'status' => $data['status'], 'commandID' => $data['commandID'] ]);
            } else {
                echo 'Not available:'. $response->getStatusCode();
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function runEmailForwarding($domain, $email)
    {
        try {
            $handler = new CurlHandler();
            $client = new \GuzzleHttp\Client();
            $tapMiddleware = Middleware::tap(function ($request) {});
            $data = ["DomainName" => $domain, "email" => $email];

            $response = $client->request('POST', env('AWS_UTILITY_URL_MAIL_FORWARDER'), [
                'json' => $data,
                'handler' => $tapMiddleware($handler)
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
            if ($response->getStatusCode() == 200) {
                return response()->json(['message' => 'Success', 'status' => $data]);
            } else {
                echo 'Not available:'. $response->getStatusCode();
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    private function sendMail($detail)
    {
        Mail::to($detail['email'])->send(new WebsiteCreationDone($detail));
    }
}
