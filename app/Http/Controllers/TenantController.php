<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stancl\Tenancy\Exceptions\DomainsOccupiedByOtherTenantException;
use App\Models\Tenant;
use App\Models\Template;
use Validator;
class TenantController extends Controller
{
    public function create(Request $request) {
        $inputs = Validator::make($request->all(), [
            'name' => 'required',
            'template_id' => ['nullable'],
            'user_id' => ['required'],
            'description' => ['required'],
        ]); 
        if ($inputs->fails()) {
            return response()->json(['errors' => $inputs->errors()->all()], 501);
        }
        try {
            $tenant = Tenant::find($request->name);
            if (empty($tenant)) {
                $tenant = Tenant::create([
                    'name' => $inputs->validated()['name'],
                    'description' => $inputs->validated()['description'],
                    'template_id' => $inputs->validated()['template_id'],
                    'id' => $inputs->validated()['name'],
                    'user_id' => $inputs->validated()['user_id'],
                ]);
                if ($tenant) {
                    $domain = $tenant->domains()->create(['domain' => $request->name .'.localhost']); //Determine how to handle domain
                    // TODO: add tenant.profession to $tenant before return
                    return response()->json(['message' => 'Your Website is created successfuly', 'tenant' => $tenant, 'domain' => $domain, 'status' => 200], 200);
                }
                else {
                    return response()->json(['message' => 'Problem creating your website, Please Try again', 'status' => 502], 502);
                }
            }
            else {
                return response()->json(['status' => 500, 'message' => 'The name has already been taken!'], 500);
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function update(Request $request) {
        $inputs = Validator::make($request->all(), [
            'template_id' => ['nullable'],
            'tenant_id' => ['required'],
            'domain' => ['nullable'],
            'domain_id' => ['nullable'],
        ]); 
        
        if ($inputs->fails()) {
            return response()->json(['errors' => $inputs->errors()->all()], 501);
        }
        
        $tenant = Tenant::find($inputs->validated()['tenant_id']);
        if ($tenant !== null) {
            if ($request->has('template_id')) {
                $tenant->template_id = $inputs->validated()['template_id'];
                $tenant->save();
            }
            if ($request->has('domain')) {
                $domain = $tenant->domains->find($inputs->validated()['domain_id']);
                $domain->domain = $inputs->validated()['domain'].'.localhost';
                $domain->save();
            }
            return response()->json(['message' => 'You have successfully changed your Template', 'status' => 200], 200);
        }
        else {
            return response()->json(['message' => 'Website not found!', 'status' => 404], 404);
        }
    }

    // Renders / of template
    public function template() {
        // Get the template_id and get its details
        
        // $templateTitle = $template['name'];
        // dd($template, 'when we have a template please comment off the 2 lines above and delete me.Thanks');
        // return view('templater');
        
        // get loggedIn User profession
        $profession = Tenant::find(tenant('id'))->template->profession->name;
        $professionId = Tenant::find(tenant('id'))->template->profession_id;
        $template = Tenant::find(tenant('id'))->template->title;
        
        if($profession === 'Physician'){
            return view('websites.physician', compact('template'));
        } else {
            dd($profession);
        }

    }

    public function tenancies() {
        // Get the authenticaed user
        // When coming from mobile request for user->id
        $user = auth()->user()->id;
        $tenancies = Tenant::where('user_id', $user)->with('domains', 'template', 'template.profession')->get();

        return response()->json(['message' => 'Tenants fetched', 'tenants' => $tenancies, 'status' => 200], 200);
    }

    public function delete ($id) {
        $tenant = Tenant::find($id);
        if ($tenant !== null) {
            $tenant->delete();
            if ($tenant == true) {
                return response()->json(['message' => 'Deleted', 'status' => 200], 404);
            }
        }
        else {
            return response()->json(['message' => 'Not found', 'status' => 404], 404);
        }
    }
}