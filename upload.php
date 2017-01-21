<?php
/*
if($_GET['en']){
$encoded_data = $_GET['en'];
$binary_data = base64_decode( $encoded_data );

// save to server (beware of permissions)
$result = file_put_contents( 'image/webcam.jpg', $binary_data );
if (!$result) 
    die("Could not save image!  Check file permissions.");
else
    echo 1;
}
*/
echo $i = $_GET['i'];
//if(file_exists("image/webcam".$i-1.".jpg"))
//    delete("image/webcam".$i-1.".jpg");
move_uploaded_file($_FILES['webcam']['tmp_name'], 'image/webcam'.$i.'.jpg');
$j = $i-5;
$filename = 'image/webcam'.$j.'.jpg';

  
  if (file_exists($filename)) {
    unlink($filename);
    echo 'File '.$filename.' has been deleted';
  } else {
    echo 'Could not delete '.$filename.', file does not exist';
  }


?>