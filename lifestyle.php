<?php
$url = $_SERVER['HTTP_HOST'];
if($url=='ourtowntimes.com' || $url=='www.ourtowntimes.com')
{
 require_once('sites/ourtowntimes.com/rssfeed/lifestyle.inc');
}
else if($url == 'eastlandcountytoday.com' || $url == 'www.eastlandcountytoday.com')
{
 require_once('sites/eastlandcountytoday.com/rssfeed/lifestyle.inc');
}
?>
