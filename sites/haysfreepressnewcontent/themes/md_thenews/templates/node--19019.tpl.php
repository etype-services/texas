

<?php  

//read the post from PayPal system and add 'cmd' 
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) { 
    $value = urlencode(stripslashes($value)); 
     $req .= "&$key=$value"; 
  // echo $req;
} 

//post back to PayPal system to validate 
$header = "POST /cgi-bin/webscr HTTP/1.1\r\n"; 
$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
$header .= "Host: www.paypal.com\r\n"; 
$header .= "Connection: close\r\n"; 
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n"; 
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); 
// 
  $email=$_SESSION['email'];
      $UserName=$_SESSION['username'];
        $Password=$_SESSION['password'];
      $firstname=$_SESSION['firstname'];
      $lastname=$_SESSION['lastname'];
      $address=$_SESSION['address'];
      $city=$_SESSION['city'];
      $state=$_SESSION['state'];
      $postal=$_SESSION['postalcode'];
      $phone=$_SESSION['phone'];
      $publicationid=$_SESSION['Publication_Id'];
      $planid=$_SESSION['planId'];
      $date = date("Y-m-d");
$expdate = date('Y-m-d', strtotime("+".$_SESSION['Period']." ".$_SESSION['PeriodType'].""));
    $param=array('Email' =>"$email",'UserName' =>"$UserName",'Password' =>"$Password",'FirstName' =>"$firstname",'LastName'=>"$lastname",'StreetAddress'=>"$address",'City'=>"$city",'State'=>"$state",'PostalCode'=>"$postal",'Phone'=>"$phone",'ExpiryDate'=>"$expdate",'PublicationID'=>"$publicationid",'SubscriptionPlanID'=>"$planid");

    $client3= new soapclient('http://etypeservices.com/Service_SubsciberRegistration.asmx?wsdl');

      $response3=$client3->SubscriberRegistration($param);
   
//error connecting to paypal 
if (!$fp) { 
    // 
} 
     
//successful connection     
if ($fp) { 
    fputs ($fp, $header . $req); 
     
    while (!feof($fp)) { 
        $res = fgets ($fp, 1024); 
        $res = trim($res); //NEW & IMPORTANT 
           $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
      $pubid=$_SESSION['Publication_Id'];
      echo $pubid;
      $username=$_SESSION['username'];
      $para=array('UserName' =>"$username");
      $client4= new soapclient('http://etypeservices.com/Get_EmailbyUserName.asmx?WSDL');
           
      $response4=$client4->GetSubscriberEmail($para);
      $params1=array('PublicationID' =>"$pubid");
      $clients3= new soapclient('http://etypeservices.com/service_GetPublisherEmail.asmx?WSDL');
           
      $responses3=$clients3->GetPublisherEmail($params1);
     
      
    if($pubid==255)
      {
      $headers .= 'From: The Daily Review ' . "\r\n";
      $subject="New subscriber Registration - The Daily Review";
      $publname="The Daily Review ";
      }
      else
      {
        $headers .= 'From: Franklin Banner-Tribune ' . "\r\n";
        $subject="New subscriber Registration - Franklin Banner-Tribune";
        $publname="Franklin Banner-Tribune";
      }
        if (strcmp($res, "VERIFIED") == 0) { 
                   $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_type = $_POST['txn_type'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $responses3->GetPublisherEmailResult;
    $payer_email = $response4->GetSubscriberEmailResult;
    $order=10;
    $payment_date=$_POST['payment_date'];
    $d=1427846400;
     $username=$_SESSION['username'];
    $pubid=$_SESSION['Publication_Id'];
    $subid=$_SESSION['planId'];
    $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    if($pubid==255)
      {
      $headers .= 'From: The Daily Review ' . "\r\n";
      $subject="New subscriber Registration - The Daily Review";
      $publname="The Daily Review ";
      }
      else
      {
        $headers .= 'From: Franklin Banner-Tribune ' . "\r\n";
        $subject="New subscriber Registration - Franklin Banner-Tribune";
        $publname="Franklin Banner-Tribune";
      }
    if($payment_status== 'Completed')
    {
        $st='PD';
        $issuccess=TRUE;
             
    }
    else
    {
        $st='UN';
        $issuccess=FALSE;
    }
    $in="insert into orders(txn_id,txn_type,mc_gross,payer_email,status,receiver_email,received) values ('".$txn_id."','".$txn_type."','".$payment_amount."','".$payer_email."','".$payment_status."','".$receiver_email."','".$payment_date."')";
     $param=array('PublicationID'=> "$pubid",'UserName' =>"$username",'PaymentTxnID' =>"$txn_id",'amount' =>"$payment_amount",'PaymentStatus' =>"$st",'PaymentComment' =>"$res",'SubscriptionType' =>"$subid",'IsSuccess' =>"$issuccess");
            
                 
                $client = new soapclient('http://etypeservices.com/Service_UpdatePaymentDetails.asmx?WSDL');
                
         $response=$client->UpdatePaymentDetails($param);
        
    $qu=db_query($in);
    if($payment_status== 'Completed'){
      $torec=$receiver_email;
$param1=array('PublicationID'=> "$pubid",'UserName' =>"$username");
         $client1 = new soapclient('http://etypeservices.com/Service_SendMailForRegistration.asmx?WSDL');
        $response1=$client1->GetSubscriberInfoByUserName($param1);
        $message="<head>
    <title></title>
</head>
<body>
    <table border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;
                width: 170px;>
                Dear,
                
            </td>
        </tr>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                A new subscriber has just signed up for
                ".$publname.".
            </td>
        </tr>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Subscriber detail are as follows:
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Name:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Firstname."
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Lastname."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                User name:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Username."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Password:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Password."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Phone:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Phone."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Email:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Email."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                City:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->City."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Address:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Address."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                State:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->State."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Zip:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Zip."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Subscription Plan:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$_SESSION['planTitle']."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Amount Paid:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Amount."
            </td>
        </tr>
        
        <tr>
            <td colspan=2>
                <br />
                <br />
                <br />
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <br />
            </td>
        </tr>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Thank You
                <br />
                Etype Services
            </td>
        </tr>
    </table>
</body>
</html>";
$adminemail="admin@etypeservices.com";
$sentmailadmin1=mail($adminemail,$subject,$message,$headers);
$sentmail=mail($torec,$subject,$message,$headers);
$topay=$payer_email;
$message1="<head>
    <title>Untitled Page</title>
</head>
<body>
    
    <title>Mail Page</title>
    <table border=0 cellpadding=0 cellspacing=0 width=100%>
        <tr>
            <td style=padding-top: 2px; font-family: Verdana; font-size: 8.5pt; padding-left: 0px;>
            
                                <br />
                                <br />
                Dear&nbsp;Subscriber,<br />
                <br />
                Welcome to
                ".$publname.". Thank you for your registration..
                <br />
                <br />
                You have entered the following details for registration:<br />
                <br />
            </td>
        </tr>
    </table>
    <table border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;
                width: 170px;>
                User Name
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Username."
            </td>
        </tr>
        

         <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Subscription Plan
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               ".$_SESSION['planTitle']."
            </td>
        </tr>

         <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Amount Transferred
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Amount."
            </td>
        </tr>

        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Email
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Email."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                First Name
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Firstname."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Last Name
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Lastname."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Phone
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Phone."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                City
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->City."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Address
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Address."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                State
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->State."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Zip
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Zip."
            </td>
        </tr>
   <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Payment Status
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$payment_status."
            </td>
        </tr>
        
        <tr>
            <td colspan=2>
                <br />
                <br />
                <br />
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <br />
            </td>
        </tr>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Thanks
            </td>
        </tr>
    </table>
</body>
</html>";

$sentmail1=mail($topay,$subject,$message1,$headers);
    }
    else{
      $message2="<title>Mail Page</title>
    <table border=0 cellpadding=0 cellspacing=0 width=100%>
        <tr>
            <td style=padding-top: 2px; font-family: Verdana; font-size: 8.5pt; padding-left: 0px;>
                
                <br />
                <br />
                Dear&nbsp; Subscriber,<br />
                <br />
                Welcome to
                ".$publname.". Thanks for your registration..
                <br />
                <br />
                We are sorry your payment not succeeded:<br />
                <br />
                 ".$payment_status."
                <br />
            </td>
        </tr>
    </table>
    <table border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                <br />
                <br />
                <br />
                Thanks
            </td>
        </tr>
    </table>
</body>
</html>";
$myemail="pradeep@sublimeitsolutions.com";
$sentmailj=mail($myemail,$subject,$message,$headers);
$adminemail="admin@etypeservices.com";
$sentmail2=mail($adminemail,$subject,$message2,$headers);
    }

     foreach($_POST as $key => $value) {
      echo $key." = ". $value."<br>";
    }

   
        } 
     
        if (strcmp ($res, "INVALID") == 0) { 
              $item_name = $_POST['item_name'];
              $username=$_SESSION['username'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_type = $_POST['txn_type'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $response4->GetSubscriberEmailResult;
    $order=10;
    $payment_date=$_POST['payment_date'];
    $d=1427846400;
     $username=$_SESSION['username'];
    $pubid=$_SESSION['Publication_Id'];
    $subid=$_SESSION['planId'];
             $in="insert into orders(txn_id,txn_type,mc_gross,payer_email,status,receiver_email,received) values ('".$txn_id."','".$txn_type."','".$payment_amount."','".$payer_email."','".$payment_status."','".$receiver_email."','".$payment_date."')";
if($payment_status== 'Completed')
    {
        $st='PD';
        $issuccess='TRUE';
         
    }
    else
    {
        $st='UN';
        $issuccess='FALSE';
         
    }
    $param=array('PublicationID'=> "$pubid",'UserName' =>"$username",'PaymentTxnID' =>"$txn_id",'amount' =>"$payment_amount",'PaymentStatus' =>"$st",'PaymentComment' =>"$res",'SubscriptionType' =>"$subid",'IsSuccess' =>"$issuccess");
            
               
                $client = new soapclient('http://etypeservices.com/Service_UpdatePaymentDetails.asmx?WSDL');
                
         $response=$client->UpdatePaymentDetails($param);
         
    //$qu=db_query($in);
    // foreach($_POST as $key => $value) {
    //  echo $key." = ". $value."<br>";
   // }
         if($payment_status== 'Completed'){
      $torec=$receiver_email;
$param1=array('PublicationID'=> "$pubid",'UserName' =>"$username");
         $client1 = new soapclient('http://etypeservices.com/Service_SendMailForRegistration.asmx?WSDL');
        $response1=$client1->GetSubscriberInfoByUserName($param1);
        $message="<head>
    <title></title>
</head>
<body>
    <table border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;
                width: 170px;>
                Dear,
                
            </td>
        </tr>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                A new subscriber has just signed up for
                ".$publname.".
            </td>
        </tr>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Subscriber detail are as follows:
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Name:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Firstname."
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Lastname."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                User name:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Username."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Password:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Password."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Phone:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Phone."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Email:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Email."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                City:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->City."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Address:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Address."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                State:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->State."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Zip:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Zip."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Subscription Plan:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$_SESSION['planTitle']."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Amount Paid:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Amount."
            </td>
        </tr>
        
        <tr>
            <td colspan=2>
                <br />
                <br />
                <br />
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <br />
            </td>
        </tr>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Thank You
                <br />
                Etype Services
            </td>
        </tr>
    </table>
</body>
</html>";
$adminemail="admin@etypeservices.com";
$sentmailadmin1=mail($adminemail,$subject,$message,$headers);
$sentmail=mail($torec,$subject,$message,$headers);
$topay=$payer_email;
$message1="<head>
    <title>Untitled Page</title>
</head>
<body>
    
    <title>Mail Page</title>
    <table border=0 cellpadding=0 cellspacing=0 width=100%>
        <tr>
            <td style=padding-top: 2px; font-family: Verdana; font-size: 8.5pt; padding-left: 0px;>
            
                                <br />
                                <br />
                Dear&nbsp;Subscriber,<br />
                <br />
                Welcome to
                ".$publname.". Thank you for your registration..
                <br />
                <br />
                You have entered the following details for registration:<br />
                <br />
            </td>
        </tr>
    </table>
    <table border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;
                width: 170px;>
                User Name
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Username."
            </td>
        </tr>
        

         <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Subscription Plan
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               ".$_SESSION['planTitle']."
            </td>
        </tr>

         <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Amount Transferred
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Amount."
            </td>
        </tr>

        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Email
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Email."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                First Name
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Firstname."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Last Name
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Lastname."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Phone
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Phone."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                City
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->City."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Address
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Address."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                State
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->State."
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Zip
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$response1->GetSubscriberInfoByUserNameResult->PlanDetails->Zip."
            </td>
        </tr>
   <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Payment Status
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                ".$payment_status."
            </td>
        </tr>
        
        <tr>
            <td colspan=2>
                <br />
                <br />
                <br />
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <br />
            </td>
        </tr>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Thanks
            </td>
        </tr>
    </table>
</body>
</html>";

$sentmail1=mail($topay,$subject,$message1,$headers);
    }
    else{
      $message2="<title>Mail Page</title>
    <table border=0 cellpadding=0 cellspacing=0 width=100%>
        <tr>
            <td style=padding-top: 2px; font-family: Verdana; font-size: 8.5pt; padding-left: 0px;>
                
                <br />
                <br />
                Dear&nbsp; Subscriber,<br />
                <br />
                Welcome to
                ".$publname.". Thanks for your registration..
                <br />
                <br />
                We are sorry your payment not succeeded:<br />
                <br />
                 ".$payment_status."
                <br />
            </td>
        </tr>
    </table>
    <table border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td colspan=2 style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                <br />
                <br />
                <br />
                Thanks
            </td>
        </tr>
    </table>
</body>
</html>";
$myemail="pradeep@sublimeitsolutions.com";
$sentmailj=mail($myemail,$subject,$message,$headers);
$adminemail="admin@etypeservices.com";
$sentmail2=mail($adminemail,$subject,$message2,$headers);
    }
            echo "The response from IPN was: <b>" .$res ."</b>";
          
        } 
    } 
drupal_goto('custom-login-page');
    fclose($fp); 
} 

?> 
