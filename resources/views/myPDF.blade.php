<!DOCTYPE html>
<html lang="en">
<header class="top-bar align-center">
    <div class="top-bar-title">
        <h1>Welcome To Azalea Store</h1>
    </div>

</header>
<style>
    body {
        font-family: "Montserrat", sans-serif;
        font-weight: 400;
        color: #322d28;
    }

    header.top-bar h1 {
        font-family: "Montserrat", sans-serif;
    }

    main {
        margin-top: 4rem;
        min-height: calc(100vh - 107px);
    }

    main .inner-container {
        max-width: 800px;
        margin: 0 auto;
    }

    table.invoice {
        background: #fff;
    }

    table.invoice .num {
        font-weight: 200;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.8em;
    }

    table.invoice tr, table.invoice td {
        background: #fff;
        text-align: left;
        font-weight: 400;
        color: #322d28;
    }

    table.invoice tr.header td img {
        max-width: 300px;
    }

    table.invoice tr.header td h2 {
        text-align: right;
        font-family: "Montserrat", sans-serif;
        font-weight: 200;
        font-size: 2rem;
        color: #1779ba;
    }

    table.invoice tr.intro td:nth-child(2) {
        text-align: right;
    }

    table.invoice tr.details > td {
        padding-top: 4rem;
        padding-bottom: 0;
    }

    table.invoice tr.details td.id, table.invoice tr.details td.qty, table.invoice tr.details th.id, table.invoice tr.details th.qty {
        text-align: center;
    }

    table.invoice tr.details td:last-child, table.invoice tr.details th:last-child {
        text-align: right;
    }

    table.invoice tr.details table thead, table.invoice tr.details table tbody {
        position: relative;
    }

    table.invoice tr.details table thead:after, table.invoice tr.details table tbody:after {
        content: "";
        height: 1px;
        position: absolute;
        width: 100%;
        left: 0;
        margin-top: -1px;
        background: #c8c3be;
    }

    table.invoice tr.totals td {
        padding-top: 0;
    }

    table.invoice tr.totals table tr td {
        padding-top: 0;
        padding-bottom: 0;
    }

    table.invoice tr.totals table tr td:nth-child(1) {
        font-weight: 500;
    }

    table.invoice tr.totals table tr td:nth-child(2) {
        text-align: right;
        font-weight: 200;
    }

    table.invoice tr.totals table tr:nth-last-child(2) td {
        padding-bottom: 0.5em;
    }

    table.invoice tr.totals table tr:nth-last-child(2) td:last-child {
        position: relative;
    }

    table.invoice tr.totals table tr:nth-last-child(2) td:last-child:after {
        content: "";
        height: 4px;
        width: 110%;
        border-top: 1px solid #1779ba;
        border-bottom: 1px solid #1779ba;
        position: relative;
        right: 0;
        bottom: -0.575rem;
        display: block;
    }

    table.invoice tr.totals table tr.total td {
        font-size: 1.2em;
        padding-top: 0.5em;
        font-weight: 700;
    }

    table.invoice tr.totals table tr.total td:last-child {
        font-weight: 700;
    }

    .additional-info h5 {
        font-size: 0.8em;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #1779ba;
    }
</style>

<div class="row expanded">
    <main class="columns">
        <div class="inner-container">
            <header class="row align-center">
                {{--                <a class="button hollow secondary"><i class="ion ion-chevron-left"></i> Go Back to Purchases</a>--}}
                {{--                &nbsp;&nbsp;<a class="button"><i class="ion ion-ios-printer-outline"></i> Print Invoice</a>--}}
            </header>
            <section class="row">
                <div class="callout large invoice-container">
                    <table class="invoice">
                        <tr class="header">
                            <td class="">
                                <img src="https://tools.nafezly.com/l/4eypA" alt="Azalea"/>
                            </td>
                            <td class="align-right">
                                <h2>Invoice</h2>
                            </td>
                        </tr>
                        <tr class="intro">
                            <td class="">
                                Hello, {{$user->first_name .' '.  $user->last_name}}.<br>
                                Thank you for your order.
                            </td>
                            <td class="text-right">
                                <span class="num">Order #{{$order->order_id}}</span><br>
                                {{date('m/d/Y')}}
                            </td>
                        </tr>
                        <tr class="details">
                            <td colspan="2">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="desc">Item</th>
                                        <th class="qty">Quantity</th>
                                        <th class="amt">Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order_products as $order_product)
                                        <tr class="item">
                                            <td class="desc">{{$order_product->product->name }}</td>
                                            <td class="qty">{{$order_product->quantity}}</td>
                                            <td class="amt">{{$order_product->price .' '. $invoice->currency}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr class="totals">
                            <td></td>
                            <td>
                                <table>
                                    <tr class="subtotal">
                                        <td class="num">Subtotal</td>
                                        <td class="num">{{$invoice->invoice_value }}</td>
                                    </tr>
                                    {{-- @if ($invoice->coupon_discount > 0 && $invoice->coupon_discount != null)
                                    <tr class="discount">
                                        <td class="num">Discount</td>
                                        <td class="num">{{$invoice->coupon_discount.'%'}}</td>
                                    </tr>
                                    @endif --}}
                                    <tr class="tax">
                                        <td class="num">Shipment Fees</td>
                                        <td class="num">{{$invoice->shipment_fees}}</td>
                                    </tr>
                                    <tr class="total">
                                        <td>Total</td>
                                        <td>{{$invoice->total . ' ' . $invoice->currency}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <section class="additional-info">
                        <div class="row">
                            <div class="columns">
                                <h5>Billing Information</h5>
                                <p>{{$order->address}}<br>
                                    {{$order->phone}}<br>
                                </p>
                            </div>
                            <div class="columns">
                                <h5>Payment Information</h5>
                                <p>Credit Card<br>
                                    Card Type: Visa<br>
                                    &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 1234
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </main>
</div>
</html>
