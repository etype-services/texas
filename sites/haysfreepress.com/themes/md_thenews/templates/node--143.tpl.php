<?php
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $UserName = $_POST['name'];
  $Password = $_POST['password'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $postal = $_POST['postalcode'];
  $phone = $_POST['phone'];
  $publicationid = 200;

  $date = date("Y-m-d");// current date

  $expdate = date('Y-m-d', strtotime("+1 week"));

  $param = array(
    'Email' => "$email",
    'UserName' => "$UserName",
    'Password' => "$Password",
    'FirstName' => "$firstname",
    'LastName' => "$lastname",
    'StreetAddress' => "$address",
    'City' => "$city",
    'State' => "$state",
    'PostalCode' => "$postal",
    'Phone' => "$phone",
    'ExpiryDate' => "$expdate",
    'PublicationID' => "$publicationid"
  );

  $client = new soapclient('http://etypeservices.com/Service_PrintSubscription.asmx?wsdl');

  $response = $client->SubscriberRegistration($param);

  if ($response->SubscriberRegistrationResult == -1) {
    $msg = "UserName Already Exists";
  }
  else {
    if ($response->SubscriberRegistrationResult == -2) {
      $msg = "Some Error On Registration";
    }
    else {
      if ($response->SubscriberRegistrationResult == 1) {
        $msg = "User Name Already Exists or Email is Blank";
      }
      else {
        if ($response->SubscriberRegistrationResult == -3) {
          $msg = "Email Already Registered Against This Publication";
        }
        else {
          $custom = "Print_Subscriber";
          $planid = 0;
          $amount = 0;
          $planTitle = "";
          $sel = "select UserName from temp_user where UserName='" . $UserName . "'";
          $qu1 = db_query($sel);
          $userexit = "";
          foreach ($qu1 as $qu1) {
            $userexit = $qu1->UserName;

          }
          if ($userexit != '') {
            $up = "update temp_user set Email ='" . $email . "',UserName ='" . $UserName . "',Password ='" . $Password . "',FirstName ='" . $firstname . "',LastName='" .

              $lastname . "',StreetAddress='" . $address . "',City='" . $city . "',State='" . $state . "',PostalCode='" . $postal . "',Phone='" . $phone . "',ExpiryDate='" . $expdate . "',PublicationID='" .

              $publicationid . "',SubscriptionPlanID='" . $planid . "',custom='" . $custom . "',amount='" . $amount . "',planTitle='" . $planTitle . "',paymentnumber='" . $custom . "' where UserName='" .

              $UserName . "'";
            $qu = db_query($up);
          }
          else {
            $in = "insert into temp_user

(Email,UserName,Password,FirstName,LastName,StreetAddress,City,State,PostalCode,Phone,ExpiryDate,PublicationID,SubscriptionPlanID,custom,amount,planTitle,paymentnumber

) values ('" . $email . "','" . $UserName . "','" . $Password . "','" . $firstname . "','" . $lastname . "','" . $address . "','" . $city . "','" . $state . "','" . $postal . "','" . $phone . "','" .

              $expdate . "','" . $publicationid . "','" . $planid . "','" . $custom . "','" . $amount . "','" . $planTitle . "','" . $custom . "')";
            $qu = db_query($in);
          }
          drupal_goto('node/146');
        }
      }
    }
  }
}
?>

<?php


?>

<form name="form2" id="form2" method="POST" action=""
      enctype="multipart/form-data">

  <h4 style="background:gray;line-height: 2.0em;font-size: 16px;">
    <center>ACTIVATE YOUR DIGITAL SUBSCRIPTION</center>
  </h4>
  <p style="color:red"><?php echo $msg; ?></p>
  <p>
    <strong style="font-size:14px">Customer Information </strong>
  </p>
  <br/>
  <div style="margin-left:30px">
    <div>
      <label for="fullname">Email Address:</label>
      <input type="email" name="email" placeholder="Email" class="txt"
             required="required"/>
    </div>
    <p>This is where we will deliver the latest e-Edition of the newspaper.</p>
    <!--<p> New account details
<strong>Optional.</strong> New customers may supply custom account details.
We will create these for you if no values are entered.</p>-->

    <div>
      <label for="name">UserName:</label>
      <input type="text" name="name" id="username" placeholder="UserName"
             class="txt" required="required"/>

    </div>
    <div>
      <label for="password">Password:</label>

      <input type="password" name="password" id="password" pattern=".{6,}"
             class="txt" placeholder="Min. 6 character" required="required"/>
    </div>
    <div>
      <label for="cpassword">Confirm Password:</label>

      <input type="password" name="cpassword" id="cpassword" pattern=".{6,}"
             placeholder="Confirm Password" oninput="check(this)" class="txt"
             required="required"/>
    </div>
  </div>
  <br/>
  <br/>


  <div style="margin-left:80px">
    <p><strong>Billing information</strong><br\>
      Enter your billing address and information here.</p>
    <div>
      <label for="firstname">First Name:</label>

      <input type="text" name="firstname" class="txt" required="required"/>
    </div>

    <div>
      <label for="lastname">Last Name:</label>

      <input type="text" name="lastname" class="txt" required="required"/>
    </div>


    <div>
      <label for="lastname">Street Address:</label>

      <input type="text" name="address" class="txt" required="required"/>
    </div>

    <div>
      <label for="lastname">City:</label>

      <input type="text" name="city" class="txt" required="required"/>
    </div>

    <div>
      <label for="lastname">State:</label>

      <input type="text" name="state" class="txt" required="required"/>
    </div>

    <div>
      <label for="lastname">Country:</label>

      <input type="text" name="country" class="txt" required="required"/>
    </div>

    <div>
      <label for="lastname">Postal Code:</label>

      <input type="text" name="postalcode" class="txt" required="required"/>
    </div>

    <div>
      <label for="lastname">Phone number:</label>

      <input type="text" name="phone" class="txt" required="required"/>
    </div>


    <br/>
    <div>
      <input type="submit" name="submit"
             onClick="javascript:return validation();" value="Submit"
             style="float:left;background-color: gainsboro;border-radius: 4px;width: 93px;height: 28px;border: 1px solid #CCC;text-decoration: none;color: #000;text-shadow: white 0 1px 1px;padding: 2px;"/>

      <a href="javascript:history.back()"
         style="text-decoration: none;color: #000;font-weight: bold; float:right;">
        <div
          style="width: 93px;float: right;background-color: gainsboro;height: 25px;border: 1px solid #ccc;border-radius: 4px;text-shadow: white 0 1px 1px;">
          <p style="margin-left: 30px;margin-top: 4px;">Back</p></div>
      </a>
    </div>


  </div>
</form>
<script language='javascript' type='text/javascript'>
  function check(input) {
    if (input.value != document.getElementById('password').value) {
      input.setCustomValidity('The two passwords must match.');
    } else {
      // input is valid -- reset the error message
      input.setCustomValidity('');
    }
  }

</script>
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script
  src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<!-- jQuery Form Validation code -->
<script>
  $(function () {
    $("#username").keypress(function (e) {
      if (e.which == 38 || e.which == 63) {
        return false;
      } else {

      }
    });
  });
</script>
<script>

  // When the browser is ready...
  $(function () {

    // Setup form validation on the #register-form element
    $("#form2").validate({

      // Specify the validation rules
      rules: {
        firstname: "required",
        lastname: "required",
        name: "required",
        city: "required",
        state: "required",
        country: "required",
        postalcode: "required",
        phone: "required",
        address: "required",
        email: {
          required: true,
          email: true
        },

        password: {
          required: true,
          minlength: 6
        }
      },

      // Specify the validation error messages
      messages: {
        name: "Please enter your username",
        firstname: "Please enter your firstname",
        lastname: "Please enter your lastname",
        address: "Please enter your address",
        city: "Please enter your city",
        state: "Please enter your state",
        country: "Please enter your country",
        postalcode: "Please enter your postalcode",
        phone: "Please enter your phone",
        email: "Please enter a valid email address",
        username: "Please enter a valid username",
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 6 characters long"
        }
      },

      submitHandler: function (form) {
        form.submit();
      }
    });

  });

</script>

<script type="text/javascript">
  function validation() {
    var x = document.form2.password.value.trim();
    var y = document.form2.cpassword.value.trim();
    if (document.form2.password.value.length <= 6) {
      $('#password').focus();
      $('#password').css('border', '2px solid #00D5FD');
      alert('Password should be more than 6 digits');
      return false;
    }
    if (document.form2.cpassword.value.trim() == '') {
      alert('Enter New Password');
      $('#cpassword').focus();
      $('#cpassword').css('border', '2px solid #00D5FD');
      return false;
    }
    if (x != y) {
      alert("Password Mismatch");
      $('#cpassword').focus();
      $('#cpassword').css('border', '2px solid #00D5FD');
      return false;
    }
    return true;
  }
</script>  