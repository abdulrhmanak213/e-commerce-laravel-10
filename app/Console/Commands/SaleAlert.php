<?php

namespace App\Console\Commands;

use App\Mail\SaleAlertMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SaleAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sale:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will send email for all subscribers in the newsletter';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscribers = Subscriber::query()->get();
        $categories = Category::query()->whereHas('products', function ($query) {
            $query->where('is_on_sale', true);
        })->get();
        $sale = Sale::query()->first();
        Mail::to($subscribers->pluck('email'))->send(new SaleALertMail([
            'year' => Carbon::now()->year,
            'categories' => $categories,
            'sale_value' => $sale->value,
        ]));
    }
}
