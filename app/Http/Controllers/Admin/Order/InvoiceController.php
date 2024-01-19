<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Admin\Order\InvoiceIndexResource;
use App\Http\Resources\Admin\Order\InvoiceResource;
use App\Models\Invoice;
use App\Repositories\Contracts\IInvoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(SearchRequest $request): \Illuminate\Http\Response
    {
        $query = Invoice::query();
        if ($request->value) {
            $query = $query->where(['invoice_id', $request->value]);
        }
        $invoices = $query->paginate($request->count);
        return self::returnData('invoices', InvoiceResource::collection($invoices), $invoices);
    }

    public function show($id)
    {
        $invoice = Invoice::query()->findOrFail($id);
        return self::returnData('invoice', InvoiceResource::make($invoice));
    }
}
