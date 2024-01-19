<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ar_countries = ['السعودية', 'العراق', 'سوريا'];
        $en_countries = ['Iraq', 'KSA', 'SY'];
        foreach ($ar_countries as $key => $value) {
            $country = Country::query()->create();
            $country->translateOrNew('en')->name = $en_countries[$key];
            $country->translateOrNew('ar')->name = $value;
            $country->save();
        }
    }
}
