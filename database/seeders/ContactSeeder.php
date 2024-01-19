<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $syContact = Contact::query()->create([
            'phone' => '+963932474474',
            'location' => 'sy',
            'email' => 'info@azalea.com'
        ]);
        $otherContact = Contact::query()->create([
            'phone' => '+36704228484',
            'location' => 'others',
            'email' => 'info@azalea.com'
        ]);
        $syContact->translateOrNew('ar')->store_location = 'أبو رمانة';
        $syContact->translateOrNew('en')->store_location = 'Abou Rmaneh';
        $otherContact->translateOrNew('ar')->store_location = 'هنغاريا';
        $otherContact->translateOrNew('en')->store_location = '7-8 ERSZBET TER';
        $otherContact->translateOrNew('en')->postcode = '1051 Budapest, Hungary';
        $otherContact->translateOrNew('ar')->postcode = '1051 Budapest, Hungary';
        $syContact->save();
        $otherContact->save();
    }
}
