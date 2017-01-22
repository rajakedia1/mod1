<?php
   
?>
<!doctype html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>PBee | Parking Solution</title>
    <link href="css/front.css" rel="stylesheet">
	<style type="text/css">
		body { font-family: Helvetica, sans-serif; }
		h2, h3 { margin-top:0; }
		form { margin-top: 15px; }
		form > input { margin-right: 15px; }
		#results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
	</style>
</head>
    
    
<body onload="getLocation();">
    <script type="text/javascript">
    
    </script>
    <header>
        <a href="#"><b style="color:red;">P</b>Bee (Parking Station)</a>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contribute</a></li>
            </ul>
        </nav>
    
    </header>
    
    <div class="wrapper">
        <div class="left"><br><br>
            <div id="loc"> </div><br>
            <h3 style="text-align:center;">Station Location: <i>Penman Auditorium</i></h3>
        </div>
        <div class="right">
            <canvas id="control" style="margin:0 calc(50% - 450px);" width="900px" height="500px" ></canvas>
        </div>
    </div>
    
   <div style="clear:both;"></div>
     
	<div style="display:none;" id="results">My image</div>
	<div style="display:none;"  id="my_camera"></div>
	
	
	<form class="mx">
		<input type=button value="Start Detection" onclick="take_snapshot(1)"><br>
    </form>
    
    <input id="mydata" type="hidden" name="mydata" value=""/>
   
    <div style="display:none;"> <!--
        <input id="partbtn" value="Part" type="button"> -->
        <input id="manibtn" value="Mani" type="button">
      <input id="grayscalebtn" value="Grayscale" type="button">
      <input id="invertbtn" value="Invert" type="button">
        <input id="prog" type="text"  value=""/>
    </div>
    
    <canvas style="display:none;" id="canvas" width="640" height="480"></canvas><br>
    
    <div style="display:none;" id="shows"> </div>
    
    
    
    <script type="text/javascript" src="webcam.js"></script>
    <script type="text/javascript" src="location.js"></script>
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtyd0-jWHuEPyxtCsVGJkU5PQSXGrYS6I">
    </script>
   
	<script language="JavaScript">
		Webcam.set({
			width: 10,
			height: 10,
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
                  
            },1500);
		}
        var __i=0;
        
        
        
        function draw(img,tx,__i) {
               //console.log(img.src);
              var canvas = document.getElementById('canvas');
              var ctx = canvas.getContext('2d');
              ctx.drawImage(img, 0, 0);
              img.style.display = 'none';
              var imageData = ctx.getImageData(0,0,canvas.width, canvas.height);
              var data = imageData.data;
                
              ctx.putImageData(imageData, 0, 0);
              ctx.save();
               
              var mani = function(){
                  var arr =[15,30,117,175,116,29,219,173,220,30,322,173,325,29,425,173,429,30,528,173,533,29,627,172,21,286,119,420,118,287,217,420,218,287,316,418,319,287,415,418,419,286,513,419,520,286,611,419];
                  var l =12;
                  var s=[];
                  var j=0;
                 // console.log("L = "+arr.length);
                  for(i=0;i<48;i+=4){
                      status = part(arr[i +0],arr[i +1],arr[i +2],arr[i +3],i +3);
                      s[j++]=status;
                  }
                  console.log(s);
                  show(s);
              };
              
              var show = function(s){
                  var img = new Image();
                 img.src = "img/car.png";
                 img.onload = function() {
                     
                     var img1 = new Image();
                     img1.src = "img/im2.png";
                     img1.onload = function() {
                          var canvas = document.getElementById('control');
                          var ctx = canvas.getContext('2d');
                          ctx.drawImage(img1, 0, 0);
                         for(i=0;i<6;i++){
                             if(s[i]=="Yes")
                                 ctx.drawImage(img, 105+100*i, 55,90,140);
                         }
                         for(i=0;i<6;i++){
                             if(s[i +6]=="Yes")
                                 ctx.drawImage(img, 105+100*i, 305,90,140);
                         }
                         
                          //img.style.display = 'none';
                          //var imageData2 = ctx.getImageData(x1,y1,x2, y2);
                          //var data2 = imageData2.data;
                          //console.log(data);
                          //ctx2.putImageData(imageData2, 0, 0);
                          //ctx2.save();
                      };
                 };
              };
            
            
              var part = function(x1,y1,x2,y2,r) {
                  //console.log(img.src);
                  //console.log(x1+" "+y1+" "+x2+" "+y2);
                  var canvas2 = document.getElementById('canvas');
                  var ctx2 = canvas2.getContext('2d');
                  //ctx2.drawImage(img, 0, 0);
                  //img.style.display = 'none';
                  var imageData2 = ctx.getImageData(x1,y1,100, 145);
                  var data2 = imageData2.data;
                  //console.log(data);
                  ctx2.putImageData(imageData2, 0, 0);
                  ctx2.save();
                  var count = 0;
                  for (var i = 0; i < data2.length; i += 4) {
                     var avg = (data2[i] + data2[i +1] + data2[i +2]) / 3;
                      if(Math.abs(avg-data2[i])>20||Math.abs(avg-data2[i+1])>20||Math.abs(avg-data2[i+2])>20){
                          count++;
                      }
                      
                    }
                  console.log(count);
                  //console.log(data2.length/4);
                  var status = "No";
                  if((count/12000)>0.2)
                      status = "Yes";
                  else
                      status = "No";
                  document.getElementById("shows").innerHTML = status;
                  return status;
                  /*
                        s=y1*canvas.width+x1-1;
                        s*=4;
                        for (var i = s; i < (x2-x1)*4; i += 4) {

                          data[i]     = 255 - data[i];     // red
                          data[i + 1] = 255 - data[i + 1]; // green
                          data[i + 2] = 255 - data[i + 2];} // blue
                        }
                    ctx.putImageData(imageData, 0, 0);*/
              };
              
            
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
               var manil = document.getElementById('manibtn');
              manil.addEventListener('click', mani());
              //var partb = document.getElementById('partbtn');
              //partb.addEventListener('click', part(385,293,451,374));
              var invertbtn = document.getElementById('invertbtn');
              invertbtn.addEventListener('click', invert);
              var grayscalebtn = document.getElementById('grayscalebtn');
              grayscalebtn.addEventListener('click', grayscale);
               
        }
	</script>
	
</body>
</html>
