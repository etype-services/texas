<?php

if (isset($_POST['submit'])) {


  $id = $_POST['sid'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $postal = $_POST['postalcode'];
  $phone = $_POST['phone'];
  $param = array(
    'FirstName' => "$firstname",
    'LastName' => "$lastname",
    'StreetAddress' => "$address",
    'City' => "$city",
    'State' => "$state",
    'PostalCode' => "$postal",
    'Phone' => "$phone",
    'SubscriberID' => "$id"
  );

  $client1 = new soapclient('http://etypeservices.com/Service_EditSubscriberProfile.asmx?wsdl');

  $response1 = $client1->SubscriberUpdateProfile($param);
  drupal_goto('user');
}
if (isset($_POST['change'])) {
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


    $client = new soapclient('https://etypeservices.com/Service_ChangePassword.asmx?WSDL');

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
      $msg = "Password Change Successful";
      //drupal_goto('custom-login-page');
    }

  }
  else {
    $msg = "Enter The Correct Old Password";
  }
}
?>

<?php


?>


<p style="color:red"><?php echo $msg; ?></p>
<!-- <h4  style="background:gray;line-height: 2.0em;font-size: 16px;"><center>My Account</center></h4>-->


<link rel="stylesheet"
      href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script>
    $(function () {
        $("#tabs").tabs();
    });
</script>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Personal Information</a></li>
        <li><a href="#tabs-2">Change Password</a></li>

    </ul>
    <div id="tabs-1">
        <p>
            <form name="form2" id="form2" method="POST" action=""
                  enctype="multipart/form-data">


                <div style="margin-left:80px">
                  <?php
                  global $user;
                  $uname = $user->name;
                  $param = array('UserName' => "$uname");

                  $client = new soapclient('https://etypeservices.com/Service_GetDetails_ByUserName.asmx?WSDL');

                  $response = $client->GetDetailsByUserName($param);
                  //echo "<pre>";
                  //print_r($response);
                  //echo "</pre>";

                  ?>
                    <input type="hidden" name="sid"
                           value="<?php echo $response->GetDetailsByUserNameResult->UserDetails->ID; ?>">
                    <table style="width:85%">
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>

                                <label><?php echo $response->GetDetailsByUserNameResult->UserDetails->Email; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>UserName:</strong></td>
                            <td>
                                <label><?php echo $response->GetDetailsByUserNameResult->UserDetails->UserName; ?></label>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>First Name:</strong></td>
                            <td>

                                <input type="text" name="firstname"
                                       value="<?php echo $response->GetDetailsByUserNameResult->UserDetails->FirstName; ?>"
                                       class="txt" required="required"/></td>
                        </tr>
                        <tr>
                            <td><strong>Last Name:</strong></td>
                            <td>

                                <input type="text" name="lastname"
                                       value="<?php echo $response->GetDetailsByUserNameResult->UserDetails->LastName; ?>"
                                       class="txt" required="required"/></td>
                        </tr>
                        <tr>
                            <td><strong>Street Address:</strong></td>
                            <td>

                                <input type="text"
                                       value="<?php echo $response->GetDetailsByUserNameResult->UserDetails->Address; ?>"
                                       name="address" class="txt"
                                       required="required"/></td>
                        </tr>
                        <tr>
                            <td><strong>City:</strong></td>
                            <td>

                                <input type="text"
                                       value="<?php echo $response->GetDetailsByUserNameResult->UserDetails->City; ?>"
                                       name="city" class="txt"
                                       required="required"/></td>
                        </tr>
                        <tr>
                            <td><strong>State:</strong></td>
                            <td>

                                <input type="text"
                                       value="<?php echo $response->GetDetailsByUserNameResult->UserDetails->State; ?>"
                                       name="state" class="txt"
                                       required="required"/></td>
                        </tr>
                        <tr>
                            <td><strong>Postal Code:</strong></td>
                            <td>

                                <input type="text"
                                       value="<?php echo $response->GetDetailsByUserNameResult->UserDetails->Zip; ?>"
                                       name="postalcode" class="txt"
                                       required="required"/></td>
                        </tr>
                        <tr>
                            <td><strong>Phone number:</strong></td>
                            <td>

                                <input type="text"
                                       value="<?php echo $response->GetDetailsByUserNameResult->UserDetails->Phone; ?>"
                                       name="phone" class="txt"
                                       required="required"/></td>
                        </tr>
                    </table>

                    <div style="margin-top: 22px; margin-bottom: 42px;">
                        <input type="submit" name="submit"
                               onClick="javascript:return validation();"
                               value="Submit"
                               style="float:left;background-color: gainsboro;border-radius: 4px;width: 93px;height: 28px;border: 1px solid #CCC;text-decoration: none;color: #000;text-shadow: white 0 1px 1px;padding: 2px;"/>

                        <a href="javascript:history.back()"
                           style="text-decoration: none;color: #000;font-weight: bold; float:right;">
                            <div
                                    style="width: 93px;float: right;background-color: gainsboro;height: 25px;border: 1px solid #ccc;border-radius: 4px;text-shadow: white 0 1px 1px;">
        <p style="margin-left: 30px;margin-top: 4px;">Back</p></div>
    </a>
</div>
</form></p>
</div>

</div>
<div id="tabs-2">
    <p>
        <div class="login">

            <form name="change password" method="POST" action="">
    <p style="color:red"><?php echo $msg; ?></p>
    <table>
        <tr>
            <td><strong>UserName</strong>
            </td>
            <td><label><?php echo $user->name; ?></label>
                <input type="hidden" name="name"
                       value="<?php echo $user->name; ?>">
            </td>
        </tr>
        <td><strong>Old Password</strong>
        </td>
        <td><input type="password" id="oldpassword" required name="oldpassword"
                   pattern=".{6,}" placeholder="Old Password">
        </td>
        </tr>
        <td><strong>New Password</strong>
        </td>
        <td><input type="password" id="newpassword" required name="newpassword"
                   pattern=".{6,}" placeholder="Min. 6 character">
        </td>
        </tr>
        <tr>
            <td><strong>Confirm Password</strong>
            </td>
            <td><input type="password" id="confirmpassword" required
                       name="confirmpassword" pattern=".{6,}"
                       oninput="check(this)"
                       placeholder="Confirm Password">
            </td>
        </tr>
    </table>


    <p class="submit">
        <input type="submit" name="change" value="Submit"
               style="background-color: gainsboro;border-radius: 4px;width: 93px;height: 28px;border: 1px solid #CCC;text-decoration: none;color: #000;text-shadow: white 0 1px 1px;padding: 2px;"/>
    </p>
    </form>
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
</div>
</p>
</div>


</div>
