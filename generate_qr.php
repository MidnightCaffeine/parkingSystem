<?php 
  
// Include the qrlib file 
include 'assets/vendor/phpqrcode/qrlib.php'; 
  
$text = "ASCOT Parking System Logout"; 
  
// $path variable store the location where to  
// store image and $file creates directory name 
// of the QR code file by using 'uniqid' 
// uniqid creates unique id based on microtime 
$path = 'img/'; 
$file = $path.uniqid().".png"; 
  
// $ecc stores error correction capability('L') 
$ecc = 'L'; 
$pixel_Size = 10; 
$frame_Size = 10; 
  
// Generates QR Code and Stores it in directory given 
QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size); 
  
// Displaying the stored QR code from directory 
echo "<center><img src='".$file."'></center>"; 