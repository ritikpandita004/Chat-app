<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Video Streams</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        body {
            background: #2C3546;
            background: -webkit-linear-gradient(to right, #2C3546, #203A43, #0F2027);
            background: linear-gradient(to right, #2C3546, #203A43, #0F2027);
            overflow: auto;
            margin: 10px;
            max-height: 100vh;
        }

        #linkurl, #linkname {
            width: 80%;
            max-width: 400px;
            font-size: 18px;
            padding: 10px 20px;
            margin: 20px auto;
            display: block;
        }

        #join-btn1, #join-btn2 {
            font-size: 18px;
            padding: 10px 20px;
            margin: 20px;
            display: block;
            width: 80%;
            max-width: 200px;
        }

        #video-streams {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
            height: 90vh;
            width: 1400px;
            margin: 0 auto;
        }

        .video-container {
            max-height: 100%;
            border: 2px solid black;
            background-color: #203A49;
        }

        .video-player {
            height: 100%;
            width: 100%;
        }

        button {
            border: none;
            background-color: cadetblue;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            margin: 2px;
            cursor: pointer;
        }

        #stream-controls {
            display: none;
            justify-content: center;
            margin-top: 0.5em;
        }

        @media screen and (max-width: 1400px) {
            #video-streams {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <input type="text" id="linkUrl" value="" placeholder="Enter Link">
    <button id="join-btn1" onclick="joinUserMeeting()">Join Meeting</button>
   <a href="{{url('createMeeting')}}"> <button id="join-btn2">Create Meeting</button></a>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>

<script>
    function joinUserMeeting() {

        var link = $('#linkUrl').val();

        if(link.trim() == '' || link.length<1) {
            alert('Please enter a valid link.');
            return;


    }

    else{
        window.location.href = link;
    }
}
</script>
</html>
