<?php
$url = $_SERVER['HTTP_HOST'];
if($url == 'eastlandcountytoday.com' || $url == 'www.eastlandcountytoday.com')
{
 require_once('sites/eastlandcountytoday.com/rssfeed/lifestyle.inc');
}
?>
