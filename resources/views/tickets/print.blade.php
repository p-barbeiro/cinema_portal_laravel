<!DOCTYPE html>
<html lang="">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <style>
        html {
            margin-top: 0.2in !important;
            margin-left: 0.2in !important;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.4em;
            font-weight: bold;
        }

        .ticket {
            width: 8in;
            height: 2.7in;
            background-size: cover;
            background-repeat: no-repeat;
            position: relative;
            margin-bottom: 0.2in;
        }

        .ticket-img {
            max-width: 100%;
            height: auto;
            position: relative;
        }

        #event-info {
            display: inline-block;
            position: absolute;
            left: 0.9in;
            top: 0.12in;
            width: 4.7in;
        }

        .label {
            color: #768690;
            display: block;
            text-transform: uppercase;
        }

        .value {
            display: block;
            color: #121212;
            text-transform: uppercase;
            overflow: hidden;
            font-size: 16px;
        }

        #title {
            height: 0.4in;
        }

        #location {
            height: 0.8in;
        }

        #stub-info {
            display: block;
            position: absolute;
            top: 0.06in;
            left: 6in;
            width: 1.9in;
            text-align: center;
        }

        #purchased-on {
            display: inline-block;
            color: #fff;
            text-transform: uppercase;
            font-size: 9px;
            text-align: center;
            width: 100%;
            position: relative;
        }

        #qrcode {
            height: auto;
            margin-top: 0.2in;

        }

        #ticket-num {
            display: block;
            text-transform: uppercase;
            text-align: center;
            width: 100%;
            position: relative;
            top: 0.05in;
            left: 0;
            font-weight: bold;
            font-size: 12px;
        }

        #customer-photo {
            position: absolute;
            top: 0.12in;
            left: 0.15in;
            text-align: left;
        }

        #customer-photo img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-bottom: 0.2em;
            display: block;
        }

        #attendee-info {
            text-align: left;
            font-size: 10px;
            position: absolute;
            left: 0.05in;
            line-height: 1.6em;
        }

        #attendee-info .value {
            font-size: 10px;
            display: block;
        }
    </style>
    <title></title>
</head>
<body>
<div class="ticket">
    <img class="ticket-img" src="https://verbb.imgix.net/plugins/events/ticket-trans-notext.jpg"/>

    <div id="event-info">
        <span class="label">MOVIE</span>
        <span id="title" class="value">{{ $ticket->screening->movie->title }}</span>

        <span class="label">THEATER</span>
        <span class="value">{{ $ticket->screening->theater->name }}</span>
        <br>
        <hr>
        <span class="label">DATE AND TIME</span>
        <span
            class="value">{{ $ticket->screening->date }} | {{ date('H:i', strtotime($ticket->screening->start_time)) }}</span>
        <br>
        <span class="label">SEAT</span>
        <span class="value">{{ $ticket->seat->row.$ticket->seat->seat_number }}</span>
    </div>

    <div id="stub-info">
        <span
            id="purchased-on">Purchased on {{ \Carbon\Carbon::parse($ticket->created_at)->format('M j, Y \\a\\t g:i A') }}</span>
        <img id="qrcode" src="data:image/png;base64, {!! $qrcode !!}">
        <span id="ticket-num" class="value">TICKET # {{ $ticket->id }}</span>

        <div id="attendee-info">
            <br> <br>
            @if($ticket->purchase?->customer)
                <span id="name" class="value">{{ $ticket->purchase->customer?->user->name }}</span>
                <span id="email" class="value">{{ $ticket->purchase->customer?->user->email }}</span>
            @else
                <span id="name" class="value">Guest</span>
                <span id="email" class="value">N/A</span>
            @endif
        </div>
    </div>
    @if($ticket->purchase?->customer)
        <div id="customer-photo">
            <img src="{{ $ticket->purchase->customer?->user->getPhotoFullUrlAttribute() }}" alt="Customer Photo">
        </div>
    @endif


</div>
</body>
</html>
