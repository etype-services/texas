<?php

if (isset($_POST['submit'])) {
  global $user;
  $username = $_POST['name'];
  $Password = $_POST['oldpassword'];
  $nPassword = $_POST['newpassword'];
  //require_once 'includes/password.inc';
  //$u=user_check_password('$Password', '$user->pass');
  //$p=user_hash_password('$Password');
  $param1 = array('UserName' => $username);
  $client1 = new soapclient('http://etypeservices.com/service_GetPasswordByUserName.asmx?WSDL');
  $resp = $client1->GetPasswordByUserName($param1);
  if ($Password == $resp->GetPasswordByUserNameResult) {
    $param = array('UserName' => $username, 'Password' => $nPassword);


    $client = new soapclient('http://etypeservices.com/Service_ChangePassword.asmx?WSDL');

    $response = $client->ChangePassword($param);
    //  echo "<pre>";
    //   print_r($response);
    //  echo "</pre>";
    $query = "select name, uid from users where name='" . $username . "'";
    $qu = db_query($query);
    $userexit = "";
    foreach ($qu as $qu) {
      $userexit = $qu->name;

    }
    if ($userexit != '') {
      $edit['pass'] = $Password;
      user_save($user, $edit);
      $msg = "Change Successful";
      //drupal_goto('custom-login-page');
    }

  }
  else {
    $msg = "Enter The Correct Old Password";
  }
}

?>

<body>
<section class="container">
  <div class="login">
    <h1>Change Password</h1>
    <form name="change password" method="POST" action="">
      <p style="color:red"><?php echo $msg; ?></p>
      <table>
        <tr>
          <td>UserName
          </td>
          <td><input type="text" name="name" value="<?php echo $user->name; ?>"
                     placeholder="User Name" readonly>
          </td>
        </tr>
        <td>Old Password
        </td>
        <td><input type="password" id="oldpassword" name="oldpassword"
                   placeholder="Old Password">
        </td>
        </tr>
        <td>New Password
        </td>
        <td><input type="password" id="newpassword" name="newpassword"
                   pattern=".{6,}" placeholder="Min. 6 Character">
        </td>
        </tr>
        <tr>
          <td>Confirm Password
          </td>
          <td><input type="password" id="confirmpassword" name="confirmpassword"
                     pattern=".{6,}" oninput="check(this)"
                     placeholder="Min. 6 Character">
          </td>
        </tr>
      </table>


      <p class="remember_me">
        <!-- <label>
           <input type="checkbox" name="remember_me" id="remember_me">
           Remember me on this computer
         </label> -->
      </p>
      <p class="submit">
        <input type="submit" name="submit"
               onClick="javascript:return validation();" value="Submit"
               style="background-color: gainsboro;border-radius: 4px;width: 93px;height: 28px;border: 1px solid #CCC;text-decoration: none;color: #000;text-shadow: white 0 1px 1px;padding: 2px;"/>
      </p>
    </form>
  </div>

  <div class="login-help" style="color:#000">
    <!-- <p style="color:#000">Forgot your password? <a href="#" style="color:#000">Click here</a>.</p> -->
  </div>
</section>
<script language='javascript' type='text/javascript'>
  function check(input) {
    if (input.value != document.getElementById('newpassword').value) {
      input.setCustomValidity('The two passwords must match.');
    } else {
      // input is valid -- reset the error message
      input.setCustomValidity('');
    }
  }

</script>
<script type="text/javascript">
  function validation() {
    var x = document.changepassword.newpassword.value.trim();
    var y = document.changepassword.confirmpassword.value.trim();
    if (document.changepassword.oldpassword.value.trim() == '') {
      $('#oldpassword').focus();
      $('#oldpassword').css('border', '2px solid #00D5FD');
      alert('Enter Old Password');
      return false;
    }
    if (document.changepassword.newpassword.value.trim() == '') {
      alert('Enter New Password');
      $('#newpassword').focus();
      $('#newpassword').css('border', '2px solid #00D5FD');
      return false;
    }
    if (document.changepassword.confirmpassword.value.trim() == '') {
      alert('Enter Confirm Password');
      $('#confirmpassword').focus();
      $('#confirmpassword').css('border', '2px solid #00D5FD');
      return false;
    }
    if (x != y) {
      alert("Password Mismatch");
      $('#newpassword').focus();
      $('#newpassword').css('border', '2px solid #00D5FD');
      return false;
    }
    return true;
  }
</script>
</body>
