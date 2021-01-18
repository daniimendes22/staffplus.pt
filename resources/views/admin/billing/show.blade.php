<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>HRM Invoice</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
    {!! HTML::style("assets/quote-template/style.css") !!}
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="{{ URL::asset("assets/quote-template/longlogo.png") }}">
    </div>
    <table cellpadding="0" cellspacing="0" class="billing">
        <tr>
            <td>
                <div id="invoiced_to">
                    <small>Billed To:</small>
                    <h2 class="name">{{ $invoice->company->company_name }}</h2>
                    @if ($invoice->company->billing_address == "")
                        <div>{!! nl2br($invoice->company->address) !!}</div>
                        <div>{{ $invoice->company->country }}</div>
                    @else
                        <div>{!! nl2br($invoice->company->billing_address) !!}</div>
                    @endif
                </div>
            </td>
            <td>
               
            </td>
        </tr>
    </table>
</header>
<main>
    <div id="details" class="clearfix">

        <div id="invoice">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <div class="date">Date: {{ \Carbon\Carbon::now()->format("dS M Y") }}</div>
            <div class="status {{ strtolower($invoice->status) }}">{{ $invoice->status }}</div>
        </div>
        {{--<div id="client">--}}
            {{--<h2 class="name">Hi {{ $quote->contact_person }},</h2>--}}
            {{--<div>Thank you for contacting us. As per the requirements discussed during our initial conversation, we are pleased to quote you as follows:</div>--}}
        {{--</div>--}}
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="no">#</th>
                <th class="desc">Item</th>
                <th class="unit">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; ?>
            @foreach($invoice->items as $item)
                @if ($item->type == "Item")
                <tr style="page-break-inside: avoid;">
                    <td class="no">{{ ++$count }}</td>
                    <td class="desc"><h3>{{ $item->name }}</h3></td>
                    <td class="unit">{{ $invoice->currencySymbol }}{{ $item->amount }}</td>
                </tr>
                @elseif($item->type == "Tax")
                    <tr style="page-break-inside: avoid;" class="tax">
                        <td class="no">&nbsp;</td>
                        <td class="desc">{{ $item->name }}</td>
                        <td class="unit">{{ $invoice->currencySymbol }}{{ $item->amount }}</td>
                    </tr>
                @elseif($item->type == "Discount")
                        <tr style="page-break-inside: avoid;" class="discount">
                            <td class="no">&nbsp;</td>
                            <td class="desc">{{ $item->name }}</td>
                            <td class="unit">-{{ $invoice->currencySymbol }}{{ $item->amount }}</td>
                        </tr>
                @endif
                @if($count == 6)
        </tbody></table>
    <p style="page-break-before: always"></p>
    <table border="0" cellspacing="0" cellpadding="0">
        <tbody>
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr dontbreak="true">
                <td colspan="2">TOTAL</td>
                <td>{{ $invoice->currencySymbol }}{{ $invoice->amount }}</td>
            </tr>
        </tfoot>
    </table>
    <p>&nbsp;</p>
    <h2>Notes</h2>
    <div>
        {!! nl2br($invoice->notes) !!}
    </div>
</main>
</body>
</html>