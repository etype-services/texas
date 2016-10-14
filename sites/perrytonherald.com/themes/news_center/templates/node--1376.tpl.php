<?php 

	//$email=$row1['email'];
	$to="jit1987@gmail.com";
	
$headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
     $headers .= 'From: Hays Free Press ' . "\r\n";
      $subject="New subscriber Registration - Hays Free Press ";
      $publname="Hays Free Press  ";
$message="Hello choudhary \r\n";







$sentmail=mail($to,$subject,$message,$headers);
echo "<pre>";
print_r($sentmail);
echo "<pre>";
if($sentmail){
echo "jiten";
}
else
{
echo "jitenji";
}
?>