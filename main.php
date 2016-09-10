<?php
$url = $_SERVER['HTTP_HOST'];
if($url == 'ourtowntimes.com' || $url == 'www.ourtowntimes.com' || $url == 'www.easttexaspress.com' || $url == 'easttexaspress.com')
{
 require_once('sites/easttexaspress.com/rssfeed/feed.inc');
}
else if($url == 'eastlandcountytoday.com' || $url == 'www.eastlandcountytoday.com')
{
 require_once('sites/eastlandcountytoday.com/rssfeed/feed.inc');
}
?>
