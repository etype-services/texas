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
		if ((isset($querystring['usr'])) && (isset($querystring['pwd']))) {


			(isset($querystring['device'])) ? $device = $querystring['device'] : $device = '';
			$params['0'] = array(
				  $querystring['usr']
				, $querystring['pwd']
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

		$query = $this->getEntitlementsQuery2();
		$entitlements = $this->queryMSSQL('Etype', $query, $params);
		//echo "entitlements: ", count($entitlements), " results\n"; print_r($entitlements); echo "\n";

		// this result means the username/password did not return a record
		if ((isset($entitlements['0']['0'])) && ($entitlements['0']['0'] == '00000')) $return = $this->buildOutput("KO", "User or password invalid. Please try 

again");

		// username/password did return records from the db
		elseif (isset($entitlements['0']['subscriberid'])) {

			$expired = array(); // expired subscriptions
			$canView = array(); // active subscriptions
			$pubview =array();
			$outputStarter = "<key>output</key><array>";
			$outputBody = '';
			$outputEnder = "</array>";
			 $pubview= $entitlements['0']['PublicationID'];
			$pre= $entitlements['0']['Prefix'];
			foreach ($entitlements as $entitlement) {

				// see if the subscription is still valid
				if ($entitlement['SubscriptionExpiryDate'] > date('Y-m-d', strtotime("today"))) {
					if (!array_key_exists($entitlement['Prefix'], $canView)) $canView[strtolower($entitlement['Prefix'])] = true;

				}
				else {
					$expired[$entitlement['Title']][] = $entitlement['SubscriptionExpiryDate'];

				}

			}

			// check and see if there are current subscriptions -- if there is at least one, return that
			if (!empty($canView)) $return = $this->buildOutput("OK", "Success", $canView,$pubview,$pre);
			// otherwise, return a message saying their subscription expired
			else $return = $this->buildOutput("KO", "Your subscription to " . $entitlement['Title'] . " expired " . date('M j, Y', strtotime($expired

[$entitlement['Title']]['0'])) . ". Please contact the Helpdesk to renew your subscription", $canView,$pubview,$pre);

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

		

		 setcookie("etype[perms]",$encrypted_txt, time()+3600);
	//	echo "BUILD OUTPUT: ", $out, "\n";
		return $out;

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
