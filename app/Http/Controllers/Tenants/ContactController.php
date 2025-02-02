<?php

namespace App\Http\Controllers\Tenants;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Trait\ServiceNotifier;
use App\Models\Tenants\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    use ServiceNotifier;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $contact = Contact::latest()->first();
        return response()->json(['message' => 'Success', 'contact' => $contact]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $inputs = Validator::make($request->all(), [
            'phone' => 'nullable',
            'email' => 'nullable',
            'address' => 'nullable',
            'context' => 'nullable',
        ]);

        if ($inputs->fails()) {
            return response($inputs->errors()->all(), 400);
        } else {
            $input = $inputs->validated();
            $contact = Contact::create($input);
            if ($contact == true) {
                return response()->json(['message' => 'Success', 'contact' => $contact], 201);
            }
            else {
                return response()->json(['message' => 'Failed', 'contact' => $contact], 501);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Contact $contact
     * @return Response
     */
    public function update(Request $request, $contact)
    {
        $inputs = Validator::make($request->all(), [
            'phone' => 'nullable',
            'email' => 'nullable',
            'address' => 'nullable',
            'context' => 'nullable'
        ]);

        if ($inputs->fails()) {
            return response($inputs->errors()->all(), 501);
        } else {
            $input = $inputs->validated();
            $contacts = new Contact();
            $contact2Update = $contacts->find($contact);
            $contact2Update->update($input);
            if ($contact2Update == true) {
                $this->settingschangeNotify();
                return response()->json(['message' => 'Success', 'contact' => $contact2Update, 'status' => 200], 200);
            }
            else {
                return response()->json(['message' => 'Failed', 'contact' => $contact2Update], 501);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return Response
     */
    public function destroy($contact)
    {
        $contact2Delete = Contact::find($contact);
        $contact2Delete->delete();
        return response()->json([], 204);
    }
}
