<?php
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $_SESSION['email'] = $email;
  $UserName = $_POST['name'];
  $_SESSION['username'] = $UserName;
  $Password = $_POST['password'];
  $_SESSION['password'] = $Password;
  $firstname = $_POST['firstname'];
  $_SESSION['firstname'] = $firstname;
  $lastname = $_POST['lastname'];
  $_SESSION['lastname'] = $lastname;
  $address = $_POST['address'];
  $_SESSION['address'] = $address;
  $city = $_POST['city'];
  $_SESSION['city'] = $city;
  $state = $_POST['state'];
  $_SESSION['state'] = $state;
  $postal = $_POST['postalcode'];
  $_SESSION['postalcode'] = $postal;
  $phone = $_POST['phone'];
  $_SESSION['phone'] = $phone;
  $publicationid = $_POST['Publication_Id'];
  $planid = $_POST['planId'];
  $date = date("Y-m-d");// current date


  $param1 = array("SubscriberID" => $_SESSION['plandetail']);

  $client = new soapclient('http://etypeservices.com/Service_GetPublicationID.asmx?wsdl');

  $response1 = $client->GetPublicationID($param1);


  $param = array("PublicationId" => $response1->GetPublicationIDResult);


  $client = new soapclient('http://etypeservices.com/Service_GetSubsciptionPlan.asmx?wsdl');

  $response = $client->GetSubsciptionPlan($param);

  $expdate = date('Y-m-d', strtotime("+" . $_POST['Period'] . " " . $_POST['PeriodType'] . ""));
  $param = array(
    'UserName' => "$UserName",
    'Email' => "$email",
    'PublicationID' => "$publicationid"
  );
  //$param=array('Email' =>"$email",'UserName' =>"$UserName",'Password' =>"$Password",'FirstName' =>"$firstname",'LastName'=>"$lastname",'StreetAddress'=>"$address",'City'=>"$city",'State'=>"$state",'PostalCode'=>"$postal",'Phone'=>"$phone",'ExpiryDate'=>"$expdate",'PublicationID'=>"$publicationid",'SubscriptionPlanID'=>"$planid");
  // echo "<pre>";
  //   print_r($param);
  // echo "</pre>";

  // $client3= new soapclient('http://etypeservices.com/Service_SubsciberRegistration.asmx?wsdl');

  $client3 = new soapclient('http://etypeservices.com/Service_CheckUsernameAndEmail.asmx?WSDL');
  $response3 = $client3->CheckUserNameAndEmail($param);

  if ($response3->CheckUserNameAndEmailResult == -1) {
    $msg = "UserName Already Exists";

  }
  else {
    if ($response3->CheckUserNameAndEmailResult == -2) {
      $msg = "Email Already Registered against this publication";

    }
    else {
      if ($response3->CheckUserNameAndEmailResult == -3) {
        $msg = "You have recently attempted with similar username. please try with different username or try after 24 hours from your last attempt.";
      }
      else {
        drupal_goto('node/144');

      }
    }
  }
}
if (isset($_POST['submit'])) {

  $param1 = array("SubscriberID" => $_POST['plandetail']);
  $_SESSION['plandetail'] = $_POST['plandetail'];
  $client = new soapclient('http://etypeservices.com/Service_GetPublicationID.asmx?wsdl');

  $response1 = $client->GetPublicationID($param1);


  $param = array("PublicationId" => $response1->GetPublicationIDResult);


  $client = new soapclient('http://etypeservices.com/Service_GetSubsciptionPlan.asmx?wsdl');

  $response = $client->GetSubsciptionPlan($param);
  //echo "<pre>";
  //	 print_r($response);
  //	 echo "</pre>";
}

?>

<form name="form2" id="form2" method="POST" action=""
      enctype="multipart/form-data">

  <h3 style="background:gray;font-size:16px;line-height: 2.0em;">
    <center>Cart contents</center>
    </h4>
    <p style="color:red"><?php echo $msg; ?></p>
    <?php
    $i = 0;
    while ($response->GetSubsciptionPlanResult->PlanDetails[$i]->ID > 0) {
      if ($response->GetSubsciptionPlanResult->PlanDetails[$i]->ID == $_SESSION['plandetail']) {
        ?>
        <table style="width:100%">
          <tr>
            <th style="border: 2px solid gray;background: #ccc">
              <strong>Quantity</strong></th>
            <th style="border: 2px solid gray;background: #ccc">
              <strong>Product</strong></th>
            <th style="border: 2px solid gray;background: #ccc">
              <strong>Price</strong></th>
          </tr>
          <tr>
            <td>1*</td>
            <td> <?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Title;
              echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Period;
              echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->PeriodType; ?></td>
            <td>
              $ <?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Price; ?></td>
            <input type="hidden" name="Publication_Id"
                   value="<?php echo $_POST['Publication_Id'] ?>">
            <input type="hidden" name="planId"
                   value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->ID; ?>">
            <input type="hidden" name="Period"
                   value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Period; ?>">
            <input type="hidden" name="PeriodType"
                   value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->PeriodType; ?>">
            <input type="hidden" name="planTitle"
                   value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Title; ?>">
            <input type="hidden" name="planPrice"
                   value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Price; ?>">
            <?php $_SESSION['Publication_Id'] = $_POST['Publication_Id'];
            $_SESSION['planId'] = $response->GetSubsciptionPlanResult->PlanDetails[$i]->ID;
            $_SESSION['planTitle'] = $response->GetSubsciptionPlanResult->PlanDetails[$i]->Title;
            $_SESSION['Period'] = $response->GetSubsciptionPlanResult->PlanDetails[$i]->Period;
            $_SESSION['PeriodType'] = $response->GetSubsciptionPlanResult->PlanDetails[$i]->PeriodType;
            $_SESSION['planPrice'] = $response->GetSubsciptionPlanResult->PlanDetails[$i]->Price;
            ?>
          </tr>

        </table>
        <?php $i++;
      }
      else {
        $i++;
      }
    } ?>
    <br/>
    <p>
      <strong>Customer Information</strong>
    </p>
    <div style="margin-left:30px">
      <div>
        <label for="fullname">Email Address:</label>
        <input type="email" name="email" placeholder="Email" class="txt"
               required="required"/>
      </div>

      <p> This is where we will deliver the latest e-Edition of the
        newspaper.</p>

      <div>
        <label for="name">UserName:</label>
        <input type="text" name="name" id="username" class="txt"
               required="required"/>

      </div>
      <div>
        <label for="password">Password:</label>

        <input type="password" name="password" pattern=".{6,}" class="txt"
               placeholder="Min. 6 character" required="required"/>
      </div>
      <div>
        <label for="cpassword">Confirm Password:</label>

        <input type="password" name="cpassword" pattern=".{6,}"
               placeholder="Confirm Password" class="txt" oninput="check(this)"
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
        <a href="javascript:history.back()"
           style="text-decoration: none;color: #000;font-weight: bold; float:right;">
          <div
            style="width: 93px;float: right;background-color: gainsboro;height: 26px;border: 1px solid #ccc;border-radius: 4px;text-shadow: white 0 1px 1px;">
            <p style="margin-left: 30px;margin-top: 4px;">Back</p></div>
        </a>


        <!--  <input type="submit" name="login" value="Review Order!" /> -->
        <input type="submit" name="login" value="Review Order!"
               style="float:left;background-color: gainsboro;border-radius: 4px;width: 96px;height: 28px;border: 1px solid #CCC;text-decoration: none;color: #000;text-shadow: white 0 1px 1px;padding: 2px;">
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