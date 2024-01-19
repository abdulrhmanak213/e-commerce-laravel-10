<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contact\ContactRequest;
use App\Http\Resources\Admin\Contact\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::query()->with('translations')->get();
        return self::returnData('contacts', ContactResource::collection($contacts));
    }

    public function store(ContactRequest $request)
    {
        $contact = Contact::query()->firstOrNew(['location' => $request->location]);
        $contact->forceFill($request->only('email', 'phone'));
        foreach ($this->languages as $language) {
            $contact->translateOrNew($language)->store_location = $request->input('store_location_' . $language);
            if ($request->filled('postcode_' . $language)) {
                $contact->translateOrNew($language)->postcode = $request->input('postcode_' . $language);
            }
        }
        $contact->save();
        return self::success('Success!');
    }

    public function show($id)
    {
        $contact = Contact::query()->findOrFail($id);
        return self::returnData('contact', ContactResource::make($contact));
    }
}
