<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UpdateCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command for updating currency value';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $access_key =env('EXCHANGE_RATE_KEY');
        $response = Http::get('http://data.fixer.io/api/latest?access_key='.$access_key);
    
        if($response->status() != 200) 
            return ;
        $data =  $response->json();

        $usd = $data['rates']['USD'];
        $syp = $data['rates']['SYP']  / $usd ;

        Currency::updateOrCreate(
            ['name'=>'SYP'],
            [
                'value' => $syp ,
                'symbol' => '£s'  
            ]
        );

        Cache::flush('dolar_price');
    }
}
