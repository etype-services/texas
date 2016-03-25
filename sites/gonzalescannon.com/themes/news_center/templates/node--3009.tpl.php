<!DOCTYPE html>
<html>
<head>

</head>

<style>

}
</style>
<?php
$PublisherID=93;
$UName="fbgstandard01";
$date = new DateTime(NOW);
$result = $date->format('m/d/Y H:i:s');

$param=array('PublisherID'=>$PublisherID,'LoginTime'=>$result,'UName' =>"$UName");

    $client= new soapclient('http://etype.sublimeitsolutions.com/AuthenticateClassifiedPublisher.asmx?WSDL');
    
    $response=$client->CheckPublisherAuthentication($param);
?>

<?php if($response->CheckPublisherAuthenticationResult==1) {
drupal_goto('http://www.fredericksburgstandard.com/adminpubliser.php'); ?>
<?php } else { ?>
<script type="text/javascript">


    window.location="http://www.fredericksburgstandard.com";

</script>
<?php } ?>
