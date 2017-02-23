<?php 

if(isset($_POST['send']))
{
$uname=$_POST['mail'];
$param12=array('UserName'=>"$uname");
		$client12= new soapclient('http://etypeservices.com/service_GetPublicationIDByUserName.asmx?WSDL');
		$response12=$client12->GetPublicationID($param12);
		//echo "<pre>";
		//print_r($response12);
		//echo "</pre>";
	
		 if($response12->GetPublicationIDResult== -9)
		{
		$msg="Invalid UserName ";
		}	 
		else if($response12->GetPublicationIDResult== 3364)
		{
$param=array('UserName'=>$uname);

$client=new soapclient('http://etypeservices.com/service_ForgetPassword.asmx?WSDL');
try
{
$response=$client->ForgetPassword($param);
if($response->ForgetPasswordResult == 1)
{
$msg="Credentials have been sent to your registered email";
}
else
{
  $msg="User is Not Registered For This Publication";
}
}
catch(Exception $e)
{
echo'' .$e->getMessage();
}
}
else
{
 $msg="User Not Exists";
}
}
?>

<form action="" method="post">
<p style="text-align:center;">

<h2 style="Background:gray;line-height: 2.0em;font-size:14px"><center>Forgot Password ? </center></h2>
<br />
<p style="color:red"><?php echo $msg; ?></p>
Enter User Name <input type="text" name="mail" required="required">
<input type="submit" name="send" value="Submit!" style="background-color: gainsboro;border-radius: 4px;width: 93px;height: 28px;border: 1px solid #CCC;text-decoration: none;color: #000;text-shadow: white 0 1px 1px;padding: 2px;">
</p>
</form>
