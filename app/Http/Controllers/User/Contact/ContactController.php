<?php

namespace App\Http\Controllers\User\Contact;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Contact\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Stevebauman\Location\Facades\Location;

class ContactController extends Controller
{
    public function show()
    {
        $location = Config::get('app.location') == 'Syria' ? 'sy' : 'others';
        $contact = Contact::query()->where('location', $location)->first();
        if(!$contact)
            $contact= config("footer_location.{$location}");

        return self::returnData('contact', ContactResource::make($contact));
    }
}
