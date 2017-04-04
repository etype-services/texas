<?php                                                                                                                                                                    $addir = "./images";
	$exclude_list = array(".", "..");
	$ads = array_values(array_diff(scandir($addir), $exclude_list));
	//echo "ADS:<br />\n"; print_r($ads); echo "<br />\n";

//	$totalheight = 0;
	$out = '';
	foreach ($ads as $ad) {

		$file = $addir . "/" . $ad;
		$pdf = $addir . "/pdfs/" . $ad;
	//	list($width, $height) = getimagesize($file);
	//	$totalheight += $height;
	//	$out .= "<li><img src=\"images/" . $ad . "\" width=\"" . $width . "\" height=\"" . $height . "\" /></li>\n";
	//	$out .= "<li><img src=\"images/" . $ad . "\"  /></li>\n";

		$out .= "<div><li><a href=\"" . $file . "\" target=\"_blank\"><img src=\"images/" . $ad . "\" width=\"230px\" /></a></li></div>\n";

//		echo "AD: ", $ad, "<br />";
//		echo "width: ", $width, "<br />";
//		echo "height: ", $height, "<br />";
//		echo "<br />";

	}

//	echo "TOTAL COUNT: ", count($ads), "<br />";
//	echo "TOTAL HEIGHT: ", $totalheight, "<br />";
?>




	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">
<head>
<title>Ad-Scroller</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<!-- jQuery library -->
<script type="text/javascript" src="lib/jquery-1.9.1.min.js"></script>
<!-- jCarousel library -->
<script type="text/javascript" src="lib/jquery.jcarousel.min.js"></script>

<script type="text/javascript">

	jQuery(document).ready(function() {
	    jQuery('#mycarousel').jcarousel({
	        vertical: true,
	        scroll: 1,
	        auto: true,
	        visible: 3,
	        wrap: "circular",
			easing: "linear",
	    });
	});

</script>

<STYLE TYPE="text/css" MEDIA="screen">
<!--

	.jcarousel-skin-tango .jcarousel-container-vertical {
	    width: 230px;
	    height: 400px;
	}

	.jcarousel-skin-tango .jcarousel-clip-vertical {
	    width:  230px;
	    height: 400px;
	}

	.jcarousel-skin-tango .jcarousel-item {
	    width: 230px;
	}
-->
</STYLE>

</head>
<body>


  <ul id="mycarousel" class="jcarousel jcarousel-skin-tango">
		<?php echo $out; ?>
  </ul>

</body>
</html>
