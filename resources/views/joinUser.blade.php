<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Video Stream</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/main.css') }}">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <body>
        <input type="text" id="linkurl" value="{{url('joinMeeting') }}/{{$meeting->url}}">

        {{-- <button id="join-btn" style="display: none;"></button> --}}
        {{-- <button id="join-btn2">Join Stream</button> --}}
        <button id="join-btn">Join Stream</button>
        <button id="join-btns" onclick="copyLink()">Copy Link</button>


        <!-- Meeting Instance -->

        <div id="stream-wrapper" style="height: 100%; display:block">
            <div id="video-streams"></div>
        </div>

        <div id="stream-controls">
            <button id="leave-btn">Leave Stream</button>
            <button id="mic-btn">Mic on</button>
            <button id="camera-btn">Camera on</button>
            <button id="rec-btn">Rec off</button>
        </div>

        <input id="appid" type="hidden" value="{{$meeting->app_id}}" readonly>
        <input id="token" type="hidden" value="{{$meeting->token}}" readonly>
        <input id="channel" type="hidden" value="{{$meeting->channel}}" readonly>
        <input id="urlId" type="hidden" value="{{$meeting->url}}" readonly>

        {{-- <input id="timer" type="hidden" value="0"> --}}
        <input id="user_meeting" type="hidden" value="0">
        <input id="user_permission" type="hidden" value="0">





        </body>

    <script src="https://cdn.agora.io/sdk/web/AgoraRTCSDK-4.1.0.js"></script>
    <script src="{{ asset('js/agorartc.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
