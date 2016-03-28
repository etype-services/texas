<?php

	function createTable($title, $data, $headers, $widths, $isForm = false) {

	//	echo "widths<br />"; //print_r($widths); echo "<br />";
		$percent = (100 / count($headers)) . "%";
		$out = '';
		$out .= "<table id=\"table1\" class=\"tablesorter\" width=\"600px\" border=\"0\">";

		// add form tag if called for
		if ($isForm) $out .= "<form action=\"" . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "\" method=\"POST\">";

		$out .= "<tr><td class= \"header\" colspan = \"" . count($headers) . "\">" . $title . "</td></tr>";
		$out .= "<tbody>";

		for ($i = 0; $i < count($data); $i++) {

			$bg = "";
			if (!($i % 2)) $bg = " class=\"odd\" ";

			$out .= "<tr" . $bg . ">";
			foreach ($headers as $w) {

				if (isset($data[$i][$w])) {

					if ((is_array($data[$i][$w])) && (isset($data[$i][$w]['0'])) ) {
						$value = $data[$i][$w]['0'];
					} else {
						$value = $data[$i][$w];
					}

					$width = $percent;
					//if (!empty($widths)) 
					if (array_key_exists($w, $widths)) $width = $widths[$w];

					if (is_string($value)) $out .= "<td class= \"leftText\" width=\"" . $width . "\">&nbsp;" . stripslashes($value) . "&nbsp;</td>";
					else $out .= "<td class= \"leftText\" width=\"" . $width . "\">&nbsp;" . stripslashes($value) . "&nbsp;</td>";

				} else {
					$out .= "<td class= \"leftText\">&nbsp;&nbsp;</td>";
				}

			}
			$out .= "</tr>";

		}


		// if there's a form, add a submit button and the form end tags
		if ($isForm) {
			$out .="<tr><td class= \"leftText\">&nbsp;</td></tr>";
			$out .= "<tr><td colspan=\"" . count($headers) . "\" align=\"center\"><input type=\"submit\" name=\"delete\" value=\"Delete\"></td></tr>";
			$out .="</form>";
		}

		$out .= "</tbody>";
		$out .= "</table>";

		return $out;

	}

?>
