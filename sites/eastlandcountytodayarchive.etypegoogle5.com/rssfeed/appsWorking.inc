<?php

$do = new apps();
$do->process();


class apps{

	function __construct() {

		date_default_timezone_set('America/Chicago');

		error_reporting(E_ALL);
		ini_set ('display_errors', false);

	}

function process() {

		// parse the querystring
		// if username and password are set, process, otherwise generate an error
		// query the database to see which publications the subscrber has access to
		// return the list of publications, or an appropriate error message, e.g., subscription expired
		// $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
		(isset($_SERVER['QUERY_STRING'])) ? parse_str($_SERVER['QUERY_STRING'], $querystring) : $querystring = array();

	//	$_COOKIE['pubs'] = "ten";
	//	$_COOKIE['perm'] = "KO";
		$rsspath = '';
		if ((isset($_POST['usr'])) && (isset($_POST['pwd']))) {


			(isset($_POST['device'])) ? $device = $_POST['device'] : $device = '';
			$params['0'] = array(
				  $_POST['usr']
				, $_POST['pwd']
			//	, $device
			);

			if ((isset($querystring['do'])) && ($querystring['do'] == "0")) echo $this->getEntitlements($params);
			else echo $this->respondToSender($this->getEntitlements($params));

		}

	}

	function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}


	


	function getEntitlements($params) {

		//$query = $this->getEntitlementsQuery2();
		//$entitlements = $this->queryMSSQL('Etype', $query, $params);
		//echo "entitlements: ", count($entitlements), " results\n"; print_r($entitlements); echo "\n";
		
		$username= $params['0']['0'];
		$Password= $params['0']['1'];
		// this result means the username/password did not return a record
		$param=array('UserName' =>"$username",'Password' =>"$Password");
  $client= new soapclient('http://etypeservices.com/Service_SubscriberLogin.asmx?WSDL');
           
      $response=$client->ValidateSubscriber($param);

		if ($response->ValidateSubscriberResult== -5) $return = $this->buildOutput("KO", "User or password invalid. Please try again");

		// username/password did return records from the db
		elseif ($response->ValidateSubscriberResult == -1) {

			$expired = array(); // expired subscriptions
			$canView = array(); // active subscriptions
			//$pubview =array();
			$outputStarter = "<key>output</key><array>";
			$outputBody = '';
			$outputEnder = "</array>";
			 $pubview= "1213";
			 
			$pre="smr";
			$canView[strtolower($pre)] = true;
			
			 $return = $this->buildOutput("KO", "Your subscription to San Marcos Record expired . Please contact the Helpdesk to renew your subscription", $canView,$pubview,$pre);

		}
		else {
			$expired = array(); // expired subscriptions
			$canView = array(); // active subscriptions
			//$pubview =array();
			$outputStarter = "<key>output</key><array>";
			$outputBody = '';
			$outputEnder = "</array>";
			 $pubview= "1213";
			
			$pre="smr";
			$canView[strtolower($pre)] = true;
			$return = $this->buildOutput("OK", "Success", $canView,$pubview,$pre);
		}

		return $return;

	}


	function respondToSender($response) {

		header('Content-Type: application/xml');
		print $response;		

	}


	function buildOutput($code, $msg, $outputs= '',$pubview,$pre) {
		

		$pubs = '';
		$out = '';
		$out .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
		$out .= "<!DOCTYPE plist PUBLIC \"-//Apple Inc//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">";
		$out .= "<plist version=\"1.0\">";
		$out .= "<dict>";
		$out .= "<key>code</key>";
		$out .= "<string>" . trim($code) . "</string>";
		$out .= "<key>msg</key>";
		$out .= "<string>";
		$out .= trim($msg);
		$out .= "</string>";

		// take note of the pubs the user can see

		if (!empty($outputs)) {

			$out .= "<key>output</key><array>";
			foreach ($outputs as $outputKey => $outputValue) {
				$out .= "<string>" . strtolower($outputKey) . "</string>";
				// also keep track for the cookie
				$pubs .= $outputKey . ", ";
			}
			$out .= "</array>";

		}
		

		$out .= "</dict>";
		$out .= "</plist>";
		$publ=$pubview;
		
		// set a cookie for the RSS app
		// setcookie("etype[perm]", trim($code), time()+3600);
		// setcookie("etype[pubs]", trim($pre), time()+3600);
		$perms="".trim($code)."_".trim($publ)."";
		
		// $perms="".trim($code)."_".trim($publ)."";
		$encrypted_txt = $this->encrypt_decrypt('encrypt', $perms);

		

		 setcookie("etype[perms]",$encrypted_txt, time()+3600*24);
	//	echo "BUILD OUTPUT: ", $out, "\n";
		return $out;

	}




}
?>