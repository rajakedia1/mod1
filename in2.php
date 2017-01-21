
<!doctype html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>WebcamJS Test Page - Large Capture</title>
	<style type="text/css">
		body { font-family: Helvetica, sans-serif; }
		h2, h3 { margin-top:0; }
		form { margin-top: 15px; }
		form > input { margin-right: 15px; }
		#results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
	</style>
</head>
<body >
	<div id="results">My image</div>
	<div id="my_camera"></div>
	<script type="text/javascript" src="webcam.js"></script>
	<script language="JavaScript">
		Webcam.set({
			width: 20,
			height: 40,
			dest_width: 300,
			dest_height: 240,
			image_format: 'jpeg',
			jpeg_quality: 100
		});
		Webcam.attach( '#my_camera' );
	</script>
	
	<form>
		<input type=button value="Take Large Snapshot" onclick="take_snapshot(1)"><br>
    </form>
    
    
        <input id="mydata" type="hidden" name="mydata" value=""/>
   
    
        <div> <!-- change config -->
          <input id="grayscalebtn" value="Grayscale" type="button">
          <input id="invertbtn" value="Invert" type="button">
            <input id="prog" type="text"  value=""/>
        </div>
    
    <canvas id="canvas" width="300" height="240"></canvas>
    <br>
	<canvas id="canvas2" width="300" height="240"></canvas>
    
	<script language="JavaScript">
        
        
        
		function take_snapshot(i) {
			// take snapshot and get image data
			var dr = Webcam.snap( function(data_uri) {
				// display results in page
                //console.log(data_uri);
				document.getElementById('results').innerHTML = 
					'<h2>Here is your large image:</h2>' + 
					'<img src="'+data_uri+'"/>';
                //var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
    
                //document.getElementById('mydata').value = raw_image_data;
                //sendimg(raw_image_data);
                //document.getElementById('myform').submit();
                
            Webcam.upload( data_uri, 'upload.php?i='+i,function(){
                
                // Upload in progress
                document.getElementById("prog").value=1;
                // 'progress' will be between 0.0 and 1.0
            
            });
			} );
            
                    i++;     
                         
            setTimeout(function(){take_snapshot(i);},5000);
		}
        
        
        
        var img = new Image();
        img.src = "image/webcam1.jpg";
       
         
        console.log(img.src);
            window.onload = function() {
              draw(img,1);
            };
i=1;
            function draw(img,i) {
                 console.log(img.src);
              var canvas = document.getElementById('canvas');
              var ctx = canvas.getContext('2d');
              ctx.drawImage(img, 0, 0);
              img.style.display = 'none';
              var imageData = ctx.getImageData(0,0,canvas.width, canvas.height);
              var data = imageData.data;

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
                i++;
             setTimeout(function(){
                 var img = new Image();
        img.src = "image/webcam"+i+".jpg";
                   draw(img,i);},5000);
          }
	</script>
	
</body>
</html>
