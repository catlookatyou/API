<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>

<p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p>

<script>
//var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        var option = {
                enableAcuracy:true, // 提高精確度
                maximumAge:0, // 設定上一次位置資訊的有效期限(毫秒)
                timeout:10000 // 逾時計時器(毫秒)
            };
        navigator.geolocation.getCurrentPosition(showPosition, error, option);
    } else { 
        console.log("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    var latlng = position.coords.latitude + "," + position.coords.longitude;
    //x.innerHTML = position.coords.latitude + "," + position.coords.longitude;
    console.log(latlng);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'GET',
        url: 'test2',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        data: {pos: latlng},
        success: function (response) {
            console.log(response);
        }
    });
}

function error() {
  alert("Sorry, no position available.");
}
</script>

</body>
</html>