<?php
if (isset($_POST['pay'])) {
  $email = $_SESSION['email'];
  $UserName = $_SESSION['username'];
  $Password = $_SESSION['password'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $address = $_SESSION['address'];
  $city = $_SESSION['city'];
  $state = $_SESSION['state'];
  $postal = $_SESSION['postalcode'];
  $phone = $_SESSION['phone'];
  $publicationid = $_SESSION['Publication_Id'];
  $planid = $_SESSION['planId'];
  $pubid = $_SESSION['Publication_Id'];
  $date = date("Y-m-d");
  $expdate = date('Y-m-d', strtotime("+" . $_SESSION['Period'] . " " . $_SESSION['PeriodType'] . ""));
  $param = array(
    'Email' => "$email",
    'UserName' => "$UserName",
    'Password' => "$Password",
    'FirstName' => "$firstname",
    'LastName' => "$lastname",
    'StreetAddress' => "$address",
    'City' => "$city",
    'State' => "$state",
    'PostalCode' => "$postal",
    'Phone' => "$phone",
    'ExpiryDate' => "$expdate",
    'PublicationID' => "$publicationid",
    'SubscriptionPlanID' => "$planid"
  );

  $client3 = new soapclient('http://etypeservices.com/Service_SubsciberRegistration.asmx?wsdl');

  $response1 = $client3->SubscriberRegistration($param);


  $xprD = $_POST['cc_exp_yr'] . $_POST['cc_exp_mo'];
  $fullname = $_POST['firstname'] . " " . $_POST['lastname'];
  $mercid = $_POST['MerchantID'];
  $cardnumber = $_POST['ccnumber'];
  $amt = $_POST['amount'];
  $pamt = $_POST['amount'];
  $merckey = $_POST['RegKey'];

  /* send request web service */
  $params = array(
    'PublicationID' => "$publicationid",
    'SubscriberID' => "$planid",
    'Mercid' => "$mercid",
    'MercregKey' => "$merckey",
    'MercinType' => "1",
    'tranCode' => "1",
    'CardNumber' => "$cardnumber",
    'xprDt' => "$xprD",
    'reqAmt' => "$amt",
    'fullName' => "$fullname",
    'addrLn1' => "$address",
    'city' => "$city",
    'state' => "$state",
    'zipCode' => "$postal",
    'country' => "$planid",
    'email' => "$email",
    'indCode' => "1",
    'prodType' => "5"
  );
  $clientss = new soapclient('http://etypeservices.com/Service_SaveTransfirstRequest.asmx?wsdl');

  $responsess = $clientss->SavePaymentRequest($params);


  $reqid = $responsess->SavePaymentRequestResult;

  /* end */
  $params1 = array('PublicationID' => "$pubid");
  $clients2 = new soapclient('http://etypeservices.com/service_GetPublisherEmail.asmx?WSDL');

  $responses3 = $clients2->GetPublisherEmail($params1);
  $receiver_email = $responses3->GetPublisherEmailResult;
  $torec = $receiver_email;
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
  $headers .= 'From: Hays Free Press ' . "\r\n";
  $subject = "New subscriber Registration - Hays Free Press ";
  $publname = "Hays Free Press  ";

  class merc {
    public $id;
    public $regKey;
    public $inType;
    public $prodType;

    function merc($id, $regKey, $inType, $prodType) {
      $this->id = $id;
      $this->regKey = $regKey;
      $this->inType = $inType;
      $this->prodType = $prodType;
    }
  }

  class card {
    public $pan;
    public $sec;
    public $xprDt;


    function card($pan, $sec, $xprDt) {
      $this->pan = $pan;
      $this->sec = $sec;
      $this->xprDt = $xprDt;

    }
  }

  class contact {

    public $fullName;
    public $addrLn1;
    public $city;
    public $state;
    public $zipCode;
    public $email;

    function contact($fullName, $addrLn1, $city, $state, $zipCode, $email) {
      $this->fullName = $fullName;
      $this->addrLn1 = $addrLn1;
      $this->city = $city;
      $this->state = $state;
      $this->zipCode = $zipCode;
      $this->email = $email;
    }
  }

  $fullname = $_POST['firstname'] . " " . $_POST['lastname'];
  $contact = new contact($fullname, $_POST['address1'], $_POST['city'], $_POST['state'], $_POST['zip'], $_POST['email']);
  $merc = new merc($_POST['MerchantID'], $_POST['RegKey'], 1, 5);
  $xprD = $_POST['cc_exp_yr'] . $_POST['cc_exp_mo'];
  $card = new card($_POST['ccnumber'], $_POST['cvv'], $xprD);
  $settleDataArray = array(
    'merc' => $merc,

    'tranCode' => "1",
    'card' => $card,
    'contact' => $contact,

    'reqAmt' => $_POST['hideamt']

  );


  //echo "<pre>";
  // print_r($settleDataArray);
  //  echo "</pre>";
  $client = new SoapClient('https://ws.processnow.com/portal/merchantframework/MerchantWebServices-v1?wsdl');


  $answer = $client->__soapCall('SendTran', array($settleDataArray));
  //echo "<pre>";
  //  print_r($answer);
  // echo "</pre>";


  $rscode = $answer->rspCode;
  $tranId = $answer->authRsp->tranId;
  $aci = $answer->authRsp->aci;
  $swchKey = $answer->tranData->swchKey;
  $dtTm = $answer->tranData->dtTm;
  $amt = $answer->tranData->amt;
  $stan = $answer->tranData->stan;
  $trannr = $answer->tranData->tranNr;
  $mapCaid = $answer->mapCaid;
  $cardtype = $answer->cardType;


  if ($answer->rspCode == "00") {
    $flag2 = TRUE;
    $paymentStatus = "PD";
    $paymentComment = "" . $tranId . " - Success";
    $savepayment = "insert into `order`(username,email,rscode,tranId,swchKey,dtTm,amount,stan,mapCaid,status,comment) value('" . $_SESSION['username'] . "','" . $_SESSION['email'] . "','$rscode','$tranId','$swchKey','$dtTm','$amt','$stan','$mapCaid','$paymentStatus','$paymentComment')";
    $qu = db_query($savepayment);

    /* send response */
    $paramr = array(
      'PublicationID' => "$publicationid",
      'UserName' => "$UserName",
      'SubscriptionType' => "$planid",
      'rspCode' => "$rscode",
      'aci' => "$aci",
      'swchKey' => "$swchKey",
      'tranNr' => "$trannr",
      'dtTm' => "$dtTm",
      'amt' => "$pamt",
      'stan' => "$stan",
      'auth' => "NULL",
      'cardType' => "$cardtype",
      'mapCaid' => "$mapCaid",
      'IsSuccess' => "$flag2",
      'PaymentStatus' => "$paymentStatus",
      'PaymentComment' => "$paymentComment",
      'SubscriptionText' => "Subscribe",
      'RequestID' => "$reqid"
    );
    $clientsr = new soapclient('http://etypeservices.com/Service_SaveTransfirstPayment.asmx?wsdl');

    $responsesr = $clientsr->SavePaymentResponse($paramr);
    echo "<pre>";
    print_r($responsesr);
    echo "</pre>";
    $message = "<head>
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
                " . $publname . ".
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
                " . $firstname . "
                " . $lastname . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                User name:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $UserName . "
            </td>
        </tr>
       
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Phone:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 " . $phone . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Email:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 " . $email . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                City:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 " . $city . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Address:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $address . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                State:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 " . $state . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Zip:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 " . $zip . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Subscription Plan:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $_SESSION['planTitle'] . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Amount Paid:
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                 " . $_SESSION['planPrice'] . "
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
    $adminemail = "admin@etypeservices.com";
    //$myemail="pradeep@sublimeitsolutions.com";
    //$sentmailj=mail($myemail,$subject,$message,$headers);
    $sentmailadmin = mail($adminemail, $subject, $message, $headers);
    $sentmail = mail($torec, $subject, $message, $headers);
    $topay = $payer_email;
    $message1 = "<head>
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
                " . $publname . ". Thank you for your registration..
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
                " . $UserName . "
            </td>
        </tr>
        

         <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Subscription Plan
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               " . $_SESSION['planTitle'] . "
            </td>
        </tr>

         <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Amount Transferred
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               " . $_SESSION['planPrice'] . "
            </td>
        </tr>

        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Email
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $email . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                First Name
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $firstname . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Last Name
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $lastname . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Phone
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $phone . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                City
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $city . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Address
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
               " . $address . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                State
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $state . "
            </td>
        </tr>
        <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Zip
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $zip . "
            </td>
        </tr>
   <tr>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left; font-weight: normal;>
                Payment Status
            </td>
            <td style=font-family: Tahoma; font-size: 11px; text-align: left;>
                " . $paymentstatus . "
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
    //$adminemail="admin@etypeservices.com";
    //$adminemail="jit1987@gmail.com";
    //$sentmailadmin2=mail($adminemail,$subject,$message1,$headers);
    $sentmail1 = mail($topay, $subject, $message1, $headers);
  }
  else {
    $flag2 = FALSE;
    $paymentStatus = "VU";
    $str9 = "VU";
    $paymentComment = "" . $tranId . "Error :INVALID Response";

    $savepayment = "insert into `order`(username,email,rscode,tranId,swchKey,dtTm,amount,stan,mapCaid,status,comment) value('" . $_SESSION['username'] . "','" . $_SESSION['email'] . "','$rscode','$tranId','$swchKey','$dtTm','$amt','$stan','$mapCaid','$paymentStatus','$paymentComment')";

    $qu = db_query($savepayment);

    $paramr = array(
      'PublicationID' => "$publicationid",
      'UserName' => "$UserName",
      'SubscriptionType' => "$planid",
      'rspCode' => "$rscode",
      'aci' => "$aci",
      'swchKey' => "$swchKey",
      'tranNr' => "$trannr",
      'dtTm' => "$dtTm",
      'amt' => "$pamt",
      'stan' => "$stan",
      'auth' => "NULL",
      'cardType' => "$cardtype",
      'mapCaid' => "$mapCaid",
      'IsSuccess' => "$flag2",
      'PaymentStatus' => "$paymentStatus",
      'PaymentComment' => "$paymentComment",
      'SubscriptionText' => "Subscribe",
      'RequestID' => "$reqid"
    );
    $clientsr = new soapclient('http://etypeservices.com/Service_SaveTransfirstPayment.asmx?wsdl');

    $responsesr = $clientsr->SavePaymentResponse($paramr);
    echo "<pre>";
    print_r($responsesr);
    echo "</pre>";

    $message2 = "<html><head></head><title>Mail Page</title>
                        <body>    
         <table border=0 cellpadding=0 cellspacing=0 width=100%>
        <tr>
            <td style=padding-top: 2px; font-family: Verdana; font-size: 8.5pt; padding-left: 0px;>
                
                <br />
                <br />
                Dear&nbsp; Subscriber,<br />
                <br />
                Welcome to
                <strong>" . $publname . "</strong> Thanks for your registration..
                <br />
                <br />
                We are sorry your payment was not successful:<br />
                <br />
                 <strong>" . $paymentstatus . "</strong>
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
    //$myemail="pradeep@sublimeitsolutions.com";
    //$sentmailj=mail($myemail,$subject,$message2,$headers);
    //$adminemail="admin@etypeservices.com";
    //$adminemail="jit1987@gmail.com";
    //$sentmail2=mail($adminemail,$subject,$message2,$headers);
  }
  drupal_goto('node/146');
}
?>