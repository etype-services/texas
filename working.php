<?php 
if ((isset($_POST['usr'])) && (isset($_POST['pwd']))) {
// echo "hello";
//echo $_GET['usr'];
//echo $_GET['pwd'];
//die();

$url = $_SERVER['HTTP_HOST'];
if($url=='ourtowntimes.com' || $url=='www.ourtowntimes.com')
{
require_once('sites/easttexaspress.com/rssfeed/login.inc');
}
else if($url == 'eastlandcountytoday.com' || $url == 'www.eastlandcountytoday.com')
{
 require_once('sites/eastlandcountytoday.com/rssfeed/login.inc');
}

} else {
?>
<form action="" method="POST">
<table>
<tr>
<td>User name
</td>
<td><input type="text" name="usr">
</td>
</tr>
<tr>
<td>password
</td>
<td><input type="password" name="pwd">
</td>
</tr>
<tr>
<td>
</td>
<td><input type="submit" name="submit">
</td>
</tr>
</table>
</form>
<?php }  ?>
