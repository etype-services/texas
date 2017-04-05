<?php

$do = new busdir();

class busdir {

	var $dir = "../images/";
	var $dirthumbs = "../images/dirthumbs/";

	function __construct() {

		date_default_timezone_set('America/Chicago');

		error_reporting  (E_ALL);
		ini_set ('display_errors', false);
		ini_set ('memory_limit', '1024M');
		ini_set ('max_input_vars', '8000');
		ini_set ('max_execution_time', '300');
		ini_set('auto_detect_line_endings', true);

		(isset($_SERVER['QUERY_STRING'])) ? parse_str($_SERVER['QUERY_STRING'], $querystring) : $querystring = array();

		if (isset($_POST['delete'])) {

	//		echo "DELETE:<pre>"; print_r($_POST); echo "</pre>";
			foreach ($_POST['case'] as $deletethis) {

			//	echo "deletethis: ", $this->dir . $deletethis, "<br />";
			//	echo "deletethis: ", $this->dirthumbs . $deletethis, "<br />";
				unlink($this->dir . $deletethis);
				unlink($this->dirthumbs . $deletethis);

			}

		} 

		$this->scandir();

	}


	function scandir() {

		if (!is_dir($this->dirthumbs)) if (!mkdir($this->dirthumbs)) die("Unable to create thumbnail directory");
		$filetypes = array('jpg', 'png');
		$dh  = opendir($this->dir);
		$filecount = 0;
		while (false !== ($filename = readdir($dh))) {

			$pathinfo = pathinfo($filename);
			if ( (isset($pathinfo['extension'])) && (in_array($pathinfo['extension'], $filetypes)) ) {

				// check to see if there's a thumbnail -- if not, create one
				$outfile = $this->dirthumbs . "/" . $filename;
				$result = '';
		//		echo "outfile: ", $outfile, "<br />";
				if (!(is_file($outfile))) {
		//			echo "does not exist<br />";
				} else {
		//			echo "exists<br />";
				}

				$select = "<input type=\"checkbox\" name=\"case[]\" class=\"case\" value=\"" . $filename . "\">";

				if (is_file($this->dirthumbs . $filename)) $thumb = "<img src=\"" . $this->dirthumbs . $filename . "\" />";
				else $thumb = "<img src=\"" . $this->dir . $filename . "\" width=\"120\"/>";

				$files[$filecount][] = $filename;
				array_unshift($files[$filecount], $thumb);
				array_unshift($files[$filecount], $select);
				$filecount++;

			}

		}
		sort($files);

	//	echo "FILES:<pre>"; print_r($files); echo "</pre>";

		$title = "Files";
		$widths = array();
		$widths = array(
			  '0' => '15%'
			, '1' => '35%'
			, '2' => '50%'
		);
		$listFiles = $this->display_results($title, $files, $widths, true);
		include_once('businessdirlist.php');

	}


	function display_results($title, $data, $widths, $isForm = false) {

		include_once('createTable.inc');
		$headers = array_keys($data['0']);
		return createTable($title, $data, $headers, $widths, $isForm);

	}


}

?>
