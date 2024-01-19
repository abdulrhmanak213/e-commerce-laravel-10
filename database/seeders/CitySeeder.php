<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ar_countries = ['ابو ظبي', 'جدة', 'الدوحة', 'دمشق'];
        $en_countries = ['AB', 'JA', 'DU', 'DA'];
        $ids = DB::table('countries')->pluck('id')->toArray();
        foreach ($ids as $id) {
            $city = City::query()->create([
                'country_id' => $id,
                'shipment_fees'=>100,
            ]);
            $randomIndex = array_rand($ar_countries);
            $city->translateOrNew('en')->name = $en_countries[$randomIndex];
            $city->translateOrNew('ar')->name = $ar_countries[$randomIndex];
            $city->save();

        }
    }
}
