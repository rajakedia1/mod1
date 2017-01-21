
<!doctype html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>WebcamJS Test Page - Large Capture</title>
    <link href="css/front.css" rel="stylesheet">
	<style type="text/css">
		body { font-family: Helvetica, sans-serif; }
		h2, h3 { margin-top:0; }
		form { margin-top: 15px; }
		form > input { margin-right: 15px; }
		#results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
	</style>
</head>
    
    
<body >
    
    <header>
        <a href="#"><b style="color:red;">P</b>Bee</a>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contribute</a></li>
            </ul>
        </nav>
    
    </header>
    
    <div class="wrapper">
        <div class="left">
            raj
        </div>
        <div class="right">
            <img src="img/im2.png" />
        </div>
    </div>
    
   
     
	<div id="results">My image</div>
	<div id="my_camera"></div>
	
	
	<form>
		<input type=button value="Take Large Snapshot" onclick="take_snapshot(1)"><br>
    </form>
    
    <input id="mydata" type="hidden" name="mydata" value=""/>
   
    <div> 
      <input id="grayscalebtn" value="Grayscale" type="button">
      <input id="invertbtn" value="Invert" type="button">
        <input id="prog" type="text"  value=""/>
    </div>
    
    <canvas id="canvas" width="640" height="480"></canvas>
    
    
    
    
    <script type="text/javascript" src="webcam.js"></script>

   
	<script language="JavaScript">
		Webcam.set({
			width: 80,
			height: 40,
			dest_width: 640,
			dest_height: 480,
			image_format: 'jpeg',
			jpeg_quality: 100
		});
		Webcam.attach( '#my_camera' );
	</script>
	<script language="JavaScript">
        function take_snapshot(i) {
			var dr = Webcam.snap( function(data_uri) {
				document.getElementById('results').innerHTML = 
					'<h2>Here is your large image:</h2>' + 
					'<img src="'+data_uri+'"/>'
                
                Webcam.upload( data_uri, 'upload.php?i='+i,function(){
                    document.getElementById("prog").value=1;
                });
			});
            
            i++;     
                         
            setTimeout(function(){take_snapshot(i);
                 var img = new Image();
                 var j=i-1;
                 img.src = "image/webcam"+j+".jpg";
                 img.onload = function() {
                     draw(img,j,0);
                 };    
                  
            },1000);
		}
        var __i=0;
        function draw(img,i,__i) {
               console.log(img.src);
              var canvas = document.getElementById('canvas');
              var ctx = canvas.getContext('2d');
              ctx.drawImage(img, 0, 0);
              img.style.display = 'none';
              var imageData = ctx.getImageData(0,0,canvas.width, canvas.height);
              var data = imageData.data;
                
              ctx.putImageData(imageData, 0, 0);
              ctx.save();
               
              var invert = function() {
                for (var i = 0; i < data.length; i += 4) {
                  data[i]     = 255 - data[i];     // red
                  data[i + 1] = 255 - data[i + 1]; // green
                  data[i + 2] = 255 - data[i + 2]; // blue
                }
                ctx.putImageData(imageData, 0, 0);
              };

              var grayscale = function() {
                for (var i = 0; i < data.length; i += 4) {
                  var avg = (data[i] + data[i +1] + data[i +2]) / 3;
                  data[i]     = avg; // red
                  data[i + 1] = avg; // green
                  data[i + 2] = avg; // blue
                }
                ctx.putImageData(imageData, 0, 0);
                  
              };

              var invertbtn = document.getElementById('invertbtn');
              invertbtn.addEventListener('click', invert);
              var grayscalebtn = document.getElementById('grayscalebtn');
              grayscalebtn.addEventListener('click', grayscale);
               
        }
	</script>
	
</body>
</html>
