@php
    use App\Models\Configuration;

    $full_price = Configuration::first()->ticket_price;
    if (auth()->check()) {
        $ticket_discount = Configuration::first()->registered_customer_ticket_discount;
        $ticket_price = $full_price - $ticket_discount;
    } else {
        $ticket_price = $full_price;
        $ticket_discount = 0;
    }

    $ticket_price = number_format($ticket_price, 2);
    $ticket_discount = number_format($ticket_discount, 2);
    $full_price = number_format($full_price, 2);
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cinemagic_Receipt_{{$purchase->id}}</title>
    <style>
        @import "https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700";

        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, total, time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline
        }

        article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
            display: block
        }

        body {
            line-height: 1
        }

        ol, ul {
            list-style: none
        }

        blockquote, q {
            quotes: none
        }

        blockquote:before, blockquote:after, q:before, q:after {
            content: '';
            content: none
        }

        table {
            border-collapse: collapse;
            border-spacing: 0
        }

        body {
            width: 794px;
            margin: auto;
            font-family: 'Open Sans', sans-serif;
            font-size: 12px
        }

        strong {
            font-weight: 700
        }

        #container {
            position: relative;
            padding: 4%
        }

        #header {
            height: 80px
        }

        #header > #reference {
            float: right;
            text-align: right
        }

        #header > #reference h3 {
            margin: 0
        }

        #header > #reference h4 {
            margin: 0;
            font-size: 85%;
            font-weight: 600
        }

        #header > #reference p {
            margin: 0;
            margin-top: 2%;
            font-size: 85%
        }

        #header > #logo {
            width: 50%;
            float: left
        }

        #fromto {
            height: 160px
        }

        #fromto > #from, #fromto > #to {
            width: 45%;
            min-height: 90px;
            margin-top: 30px;
            font-size: 85%;
            padding: 1.5%;
            line-height: 120%
        }

        #fromto > #from {
            float: left;
            width: 45%;
            background: #fafafa;
            margin-top: 30px;
            font-size: 85%;
            padding: 1.5%;
        }

        #fromto > #to {
            float: right;
            border: solid grey 1px
        }

        #items {
            margin-top: 10px
        }

        #items > p {
            font-weight: 700;
            text-align: right;
            margin-bottom: 1%;
            font-size: 65%
        }

        #items > table {
            width: 100%;
            font-size: 85%;
            border: solid grey 1px
        }

        #items > table th:first-child {
            text-align: left
        }

        #items > table th {
            font-weight: 400;
            padding: 1px 4px
        }

        #items > table td {
            padding: 1px 4px
        }

        #items > table th:nth-child(2), #items > table th:nth-child(4) {
            width: 45px
        }

        #items > table th:nth-child(3) {
            width: 45px
        }

        #items > table th:nth-child(5) {
            width: 45px
        }

        #items > table tr td:not(:first-child) {
            text-align: right;
            padding-right: 1%;
            vertical-align: middle;
        }

        #items table td {
            border-right: solid grey 1px
        }

        #items table tr td {
            padding-top: 3px;
            padding-bottom: 3px;
            height: 10px
        }

        #items table tr:nth-child(1) {
            border: solid grey 1px
        }

        #items table tr th {
            border-right: solid grey 1px;
            padding: 3px
        }

        #items table tr:nth-child(2) > td {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        #items table td:nth-child(2),
        #items table td:nth-child(3),
        #items table td:nth-child(4),
        #items table td:nth-child(5) {
            text-align: center;
        }

        #summary {
            height: 170px;
            margin-top: 30px
        }

        #summary #note {
            float: left
        }

        #summary #note h4 {
            font-size: 10px;
            font-weight: 600;
            font-style: italic;
            margin-bottom: 4px
        }

        #summary #note p {
            font-size: 10px;
            font-style: italic
        }

        #summary #total table {
            font-size: 85%;
            width: 260px;
            float: right
        }

        #summary #total table td {
            padding: 3px 4px
        }

        #summary #total table tr td:last-child {
            text-align: right
        }

        #summary #total table tr:nth-child(3) {
            background: #efefef;
            font-weight: 600
        }

        #footer {
            margin: auto;
            position: absolute;
            left: 4%;
            bottom: 4%;
            right: 4%;
            border-top: solid grey 1px
        }

        #footer p {
            margin-top: 1%;
            font-size: 65%;
            line-height: 140%;
            text-align: center
        }
    </style>

</head>
<body>

<div id="container">
    <div id="header">
        <div id="logo">
            <img src="{{isset($img) ? $img :'/img/receipt_logo.png'}}" alt="" style="max-height: 100px">
        </div>
        <div id="reference">
            <h3><strong>Payment Receipt</strong></h3>
            <h4>Ref : CM-{{$purchase->id}}</h4>
            <p>Date : {{date('Y-m-d', strtotime($purchase->date))}}</p>
        </div>
    </div>

    <div id="fromto">
        <div id="from">
            <p>
                <strong>Cinemagic</strong><br>
                Applications For Internet <br>
                2023/2024 2nd Semester <br>
                Email: cinemagic@cinemagic.com <br>
                Web: www.cinemagic.com
            </p>
        </div>
        <div id="to">
            <p>
                <strong>{{$purchase->customer_name}}</strong><br>
                {{$purchase->customer_email}}<br>
                {{$purchase->nif}}<br><br>
                Payment Method : {{$purchase->payment_type}} <br>
                @php
                    if ($purchase->payment_type == 'Credit Card') {
                        $payment_description = 'Credit Card Number: ';
                    } elseif ($purchase->payment_type == 'Paypal') {
                        $payment_description = 'Paypal Email: ';
                    } else {
                        $payment_description = 'Phone: ';
                    }
                @endphp
                {{$payment_description}}{{$purchase->payment_ref}}
            </p>
        </div>
    </div>

    <div id="items">
        <table>
            <tr>
                <th>Description</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Discount</th>
                <th>Total</th>
            </tr>
            @foreach($purchase->tickets as $ticket)
                <tr>
                    <td>{{$ticket->id}} | {{$ticket->screening->movie?->title ?? "Unknown Movie"}}
                        | {{$ticket->screening->date}} | {{date('H:i',strtotime($ticket->screening->start_time))}} |
                        Theater: {{$ticket->screening->theater?->name ?? "Unknown Theater"}} |
                        Seat: <b>{{ str_pad($ticket->seat->row.$ticket->seat->seat_number, 3, ' ', STR_PAD_RIGHT) }}</b>
                    </td>
                    <td>{{$full_price}} €</td>
                    <td>1</td>
                    <td>{{$ticket_discount}} €</td>
                    <td>{{$ticket->price}} €</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div id="summary">
        <div id="total">
            <table>
                <tr>
                    <td>Total</td>
                    <td>{{number_format($purchase->tickets()->count() * $full_price,2)}} €</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td>{{auth()->check()?'-' . number_format($ticket_discount * $purchase->tickets()->count(),2) . '€' : 'None'}}</td>
                </tr>
                <tr>
                    <td>Final Total</td>
                    <td>{{number_format($purchase->total_price,2)}} €</td>
                </tr>
            </table>
        </div>
    </div>

    <div id="footer">
        <p>Cinemagic | Applications for Internet | 2nd Semester 2023/2024 | Computer Science <br>
            Diogo Abegão, João Parreira, Pedro Barbeiro</p>
    </div>
</div>

</body>
</html>
