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
		ob_start();
		// parse the querystring
		// if username and password are set, process, otherwise generate an error
		// query the database to see which publications the subscrber has access to
		// return the list of publications, or an appropriate error message, e.g., subscription expired
		// $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
		(isset($_SERVER['QUERY_STRING'])) ? parse_str($_SERVER['QUERY_STRING'], $querystring) : $querystring = array();

	//	$_COOKIE['pubs'] = "ten";
	//	$_COOKIE['perm'] = "KO";
		$rsspath = '';
		
		$perms=explode(",", $_COOKIE['perms']);
			
			$pubs = explode(",", $_COOKIE['pubs']);
			foreach ($_COOKIE["etype"] as $name => $value)
   			 {
   				 $etyp[$name]=$value;
   			 }
			// echo $etyp['pubs'];
			$decrypted_txt = $this->encrypt_decrypt('decrypt', $etyp['perms']);
			 $pos = strrpos($decrypted_txt , '_');
   			 $pub = substr($decrypted_txt , 0, 2);
  			  $pubid = substr($decrypted_txt , $pos + 1);
			//$pub = $pubs['0'];
			//echo "pub: ", $pub, "<br />";
			//echo "pub: ", $pubid, "<br />";
			$siteurl ="eastlandcountytoday.com";
			
			// $rsspath = rtrim($siteurl, "/") . "/" . $querystring['feed'];
			$rsspath = rtrim($siteurl, "/") ;
			
			if ($pub == "OK" || $pub == "ok") 
			{	
			$rsspath .= "/";
			$rsspath.="obitlong";
			$rsspath .= ".xml";
			echo "rsspath: ", $rsspath, "<br />";
			header("Location:http://".$rsspath."");
}
else
{
$rsspath .= "/";
			$rsspath.="obitshort";
			$rsspath .= ".xml";
			echo "rsspath: ", $rsspath, "<br />";
			header("Location:http://".$rsspath."");
}

			$xml = simplexml_load_string($rsspath);
			return $xmnl;

			exit();

		

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




	function respondToSender($response) {

		header('Content-Type: application/xml');
		print $response;		

	}




}

?>