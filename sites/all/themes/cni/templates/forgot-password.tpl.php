<?php

if (isset($_POST['send'])) {
  $uname = $_POST['mail'];
  $param12 = array('UserName' => "$uname");
  $client12 = new soapclient('https://etypeservices.com/service_GetPublicationIDByUserName.asmx?WSDL');
  $response12 = $client12->GetPublicationID($param12);

  if ($response12->GetPublicationIDResult == -9) {
    $msg = "Invalid User Name.";
  }
  else {
    if ($response12->GetPublicationIDResult == 3193) {
      $param = array('UserName' => $uname);

      $client = new soapclient('https://etypeservices.com/service_ForgetPassword.asmx?WSDL');
      try {
        $response = $client->ForgetPassword($param);
        if ($response->ForgetPasswordResult == 1) {
          $msg = "Credentials have been sent to your registered email";
        }
        else {
          $msg = "User is Not Registered For This Publication.";
        }
      } catch (Exception $e) {
        echo '' . $e->getMessage();
      }
    }
    else {
      $msg = "User Does Not Exist.";
    }
  }
}
?>

<form action="" method="post">
    <p class="error"><?php echo $msg; ?></p>
    <p>Enter User Name <input type="text" name="mail" required="required">
    <input type="submit" name="send" value="Submit" /></p>
</form>
