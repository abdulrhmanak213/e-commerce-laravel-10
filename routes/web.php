<?php

use App\Models\Category;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



route::get('test',function(){
    // $response = Http::get('http://data.fixer.io/api/latest?access_key=123bed5218a26a870cdde3b450b09f94');
    // $data =  $response->json();

    // $usd = $data['rates']['USD'];

    // return  $syp = $data['rates']['SYP']  / $usd ;


    $access_key =env('EXCHANGE_RATE_KEY');
    $response = Http::get('http://data.fixer.io/api/latest?access_key='.$access_key);
    if($response->status() != 200)
        return ;
    $data =  $response->json();
    dd($data);

});
