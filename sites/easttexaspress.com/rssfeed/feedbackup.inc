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
		
		$perms=explode(",", $_COOKIE['perms']);
			
			$pubs = explode(",", $_COOKIE['pubs']);
			foreach ($_COOKIE["etype"] as $name => $value)
   			 {
   				 $etyp[$name]=$value;
   			 }
			// echo $etyp['pubs'];
			$decrypted_txt = $this->encrypt_decrypt('decrypt', $etyp['perms']);
			 $pos = strrpos($decrypted_txt , '_');
   			 $pub = substr($decrypted_txt , 0, $pos);
  			  $pubid = substr($decrypted_txt , $pos + 1);
			//$pub = $pubs['0'];
			echo "pub: ", $pub, "<br />";
			echo "pub: ", $pubid, "<br />";
			$siteurl = $this->getsiteurl($pubid);
			
			// $rsspath = rtrim($siteurl, "/") . "/" . $querystring['feed'];
			$rsspath = rtrim($siteurl, "/") ;
			
			if ($pub == "OK" || $pub == "ok") 
			{	
			$rsspath .= "/";
			$rsspath.="rssfull";
			$rsspath .= ".xml";
			echo "rsspath: ", $rsspath, "<br />";
			header("Location:http://".$rsspath."");
}
else
{
$rsspath .= "/";
			$rsspath.="rss";
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


	function getsiteurl($data) {


		$publicationid = $data;
		$params['0'] = array(
				  $publicationid
							);

	//	echo "publicationid:<pre>"; print_r($publicationid); echo "</pre>";

		$query = "
				SELECT  website as URL  from publication
				WHERE publicationid = ?
			";
		//$params = $publicationid['0']['PublicationID'];
		$siteurls = $this->queryMSSQL('Etype', $query, $params);
		//print_r($siteurls);
		$siteurl = $siteurls['0']['URL'];
		//echo $siteurl;
		return $siteurl;

	//	echo "publicationid: ", $publicationid['0']['PublicationID'], "<br />";
	//	echo "params:<pre>"; print_r($params); echo "</pre>";
	//	echo "siteurl:<pre>"; print_r($siteurls); echo "</pre>";
	//	echo "siteurl: ", $siteurl, "<br />";

	}


	function getpubid($params) {

		$query = "
				SELECT PublicationID
				FROM Publication
				WHERE Prefix = ?
			";
		$result = $this->queryMSSQL('Etype', $query, array(array($params)));
		return $result;

	}




	function respondToSender($response) {

		header('Content-Type: application/xml');
		print $response;		

	}



	function getEntitlementsQuery() {

		$query = "
				SELECT
						Subscriber.Subscriberid as subscriberid
					, Payment.SubscriptionExpiryDate
					, Payment.PublicationID
					, Publication.Prefix
					, Publication.Title
				FROM Subscriber 
					INNER JOIN Payment 
						ON Subscriber.SubscriberID = Payment.SubscriberID
					INNER JOIN Publication
						ON Payment.PublicationID = Publication.PublicationID
				WHERE Subscriber.Firstname = ?
				AND Subscriber.Lastname = ?
			";

		return $query;

	}



	function getEntitlementsQuery2() {

		$query = "
				SELECT
						Subscriber.Subscriberid as subscriberid
					, Payment.SubscriptionExpiryDate
					, Payment.PublicationID
					, Publication.Prefix
					, Publication.Title
					, Subscriber.Username
				FROM Subscriber 
					INNER JOIN Payment 
						ON Subscriber.SubscriberID = Payment.SubscriberID
					INNER JOIN Publication
						ON Payment.PublicationID = Publication.PublicationID
					LEFT JOIN aspnet_Membership memb
						ON Subscriber.Email = memb.Email
				WHERE Subscriber.Username = ?
				AND memb.Password = ?
			";

		return $query;

	}


	function queryMSSQL($server, $query, $params) {

		ob_start();
		include_once 'c.inc';
		ob_end_clean();

		if ($server == "metrics") {
			$server = METRICSSERVER;
			$db = METRICSDB;
			$user = METRICSUSER;
			$pass = METRICSPASS;
		} elseif ($server == "Etype") {
			$server = ETYPESERVER;
			$db = ETYPEDB;
			$user = ETYPEUSER;
			$pass = ETYPEPASS;
		}


		$conn = new PDO('sqlsrv:server=' . $server . ';Database=' . $db . '', $user, $pass);

		if( $conn === false ) {
			echo "Unable to connect.</br>";
			die( print_r( sqlsrv_errors(), true));
		}

		$stmt = $conn->prepare($query);
		$sqlstate = array();
		if (empty($params)) {

			$stmt->execute($params);
			$sqlstate[] = $stmt->errorInfo();

		}
		else {
			for ($i = 0; $i < count($params); $i++) {

			//	echo "executing query:\n"; print_r($params[$i]); echo "\n";
				$stmt->execute($params[$i]);
				$sqlstate[] = $stmt->errorInfo();

			}
		}

		$return = $stmt->fetchAll(PDO::FETCH_ASSOC);

	//	echo "<p>query: ", $query, "</p>";
	//	echo "<p>params: "; print_r($params); echo "</p>";
	//	echo "<p>sqlstate: "; print_r($return); echo "</p>";
		($return) ? $dataOut = $return : $dataOut = $sqlstate;

		return $dataOut;

	}

}  //  end class



?>
