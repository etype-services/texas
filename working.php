<?php 
if ((isset($_POST['usr'])) && (isset($_POST['pwd']))) {
// echo "hello";
//echo $_GET['usr'];
//echo $_GET['pwd'];
//die();
require_once('sites/ourtowntimes.com/rssfeed/login.inc');
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