<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>von2bis3</title>
</head>

<body onload="Init()" ;="" bgcolor="#b3c4c9">

<br>
<center>
  <!-- <h1 id='time_disp_elem'>02:00:00</h1> -->
  <canvas id="clock_canvas" width="686" height="686"></canvas>
</center>

<script>

// Manage private time via offset variables.
var min_offset = 0;
var sec_offset = 0;

var hour = 2;
var min = 0;
var sec = 0;

function updateTime() {
	setServerTime();
	getServerTime();
	update_time();
} 

function setServerTime() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
 //    document.getElementById("demo").innerHTML = "set time";
	}
  };
  xhttp.open("GET", "setTime.php", true);
  xhttp.send();
}

function getServerTime() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
//     document.getElementById("demo").innerHTML = this.responseText;
		var arr = this.responseText.split(" ");
		min_offset = arr[1];
		sec_offset = arr[2];
	}
  };
  xhttp.open("GET", "time.txt", true);
  xhttp.send();
}


var WallClock = {
size: parseInt(400,10),
imageClock: {},
imageHour: {},
imageMin: {},
imageSec: {},
srcClock: "",
srcHour: "",
srcMin: "",
srcSec: "",
canvasID: "",
intervalMS: parseInt(500,10),
start_action: function (canvasID, imgSrcClock, imgSrcHour, imgSrcMin, imgSrcSec) {
    WallClock.canvasID = canvasID;
    WallClock.srcClock = imgSrcClock;
    WallClock.srcHour = imgSrcHour;
    WallClock.srcMin = imgSrcMin;
    WallClock.srcSec = imgSrcSec;
    var canvas = document.getElementById(WallClock.canvasID);
    WallClock.size = canvas.width;

    var imageClock = new Image();
    imageClock.onload = function () {
        WallClock.imageClock = imageClock;
    };
    imageClock.src = WallClock.srcClock;

    var imageMin = new Image();
    imageMin.onload = function () {
        WallClock.imageMin = imageMin;
        // window.setInterval(WallClock.keepRotating, WallClock.intervalMS);
    };
    imageMin.src = WallClock.srcMin;

    var imageHour = new Image();
    imageHour.onload = function () {
        WallClock.imageHour = imageHour;
        // window.setInterval(WallClock.keepRotating, WallClock.intervalMS);
    };
    imageHour.src = WallClock.srcHour;

    var imageSec = new Image();
    imageSec.onload = function () {
        WallClock.imageSec = imageSec;
        // window.setInterval(WallClock.keepRotating, WallClock.intervalMS);
    };
    imageSec.src = WallClock.srcSec;

    window.setInterval(WallClock.keepRotating, WallClock.intervalMS);
},
keepRotating: function () {
    var angleHour = (hour%12+min/60+sec/60/60)/12*2*Math.PI;
    var angleMin = (min+sec/60)/60*2*Math.PI;
    var angleSec = sec/60*2*Math.PI;
    var scale = WallClock.size/WallClock.imageClock.width;
    var canvas = document.getElementById(WallClock.canvasID);
    var ctx = canvas.getContext("2d");
    var dx = WallClock.imageClock.width / 2;
    var dy = WallClock.imageClock.height / 2;
    ctx.save();
    ctx.scale(scale, scale)
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.translate(dx, dy);
    // ctx.rotate(- (WallClock.angleHour + WallClock.angleMin + WallClock.angleSec ));
    ctx.drawImage(WallClock.imageClock, -dx, -dy);
    ctx.rotate(angleHour);
    ctx.drawImage(WallClock.imageHour, -WallClock.imageHour.width / 2, -WallClock.imageHour.height / 2);
    ctx.rotate(angleMin - angleHour);
    ctx.drawImage(WallClock.imageMin, -WallClock.imageMin.width / 2, -WallClock.imageMin.height / 2);
    ctx.rotate(angleSec - angleMin);
    ctx.drawImage(WallClock.imageSec, -WallClock.imageSec.width / 2, -WallClock.imageSec.height / 2);
    ctx.restore();
}
}


var clock_canvas = document.getElementById("clock_canvas");
var baselength = window.innerWidth;
if (baselength > window.innerHeight) baselength = window.innerHeight;
baselength = 0.9*baselength;

var action;

function Init(){
  clock_canvas.width = baselength;
  clock_canvas.height = baselength;
  register_time_update();
  update_time();
  WallClock.start_action("clock_canvas", "img/Uhr.png", "img/Stundenzeiger.png", "img/Minutenzeiger.png", "img/Sekundenzeiger.png");
};

function update_time() {
  var d = new Date();
  min = Number(d.getMinutes());
  sec = Number(d.getSeconds());
  min = (min - min_offset + 60) % 60;
  sec = (sec - sec_offset + 60) % 60;
}

function pad(num, size) {
  return ('000000000' + num).substr(-size);
}

function show_time(h,m,s) {
  time_disp.innerHTML = pad(h,2) + ":"
                      + pad(m,2) + ":"
                      + pad(s,2);
}

function register_time_update() {
  clearInterval(action);
    action = setInterval(function(){update_time();}
                        , 500);
}

//function reset_nachtcafe_time() {
//  var d = new Date();
//  min_offset = Number(d.getMinutes());
//  sec_offset = Number(d.getSeconds());
//  update_time();
//}

// Register event for resetting the time to 02:00.
clock_canvas.addEventListener('click', function() {updateTime()}, false);

</script>



</body></html>