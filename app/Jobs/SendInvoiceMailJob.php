<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class SendInvoiceMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;
    protected $order;
    protected $user;

    public function __construct($invoice, $order, $user)
    {
        $this->invoice = $invoice;
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'title' => 'Welcome To Azalea.com',
            'date' => date('m/d/Y')
        ];

        if ($this->user) {
            $data['user'] = $this->user;
        }

        else {
            $data['user'] = [
                'first_name' => $this->order['first_name'],
                'last_name' => $this->order['last_name'],
                'address' => $this->order['address'],
                'phone' => $this->order['phone'],
                'email' => $this->order['email'],
            ];
        }


        $data['order'] = $this->order;
        $data['order_products'] = $this->order->orderProducts;
        $data['invoice'] = $this->invoice;
        $pdf = PDF::loadView('myPDF', $data);
        $pdf = ($pdf->output());
        Mail::send('emails.SendInvoiceMail', [], function ($message) use ($pdf, $data) {
            $message->to($data['user']['email'])
                ->subject('Your Order (' . $this->order->order_id . ') Has Been Done Successfully!')
                ->attachData($pdf, 'invoice', [
                    'mime' => 'application/pdf'
                ]);
        });
    }
}
