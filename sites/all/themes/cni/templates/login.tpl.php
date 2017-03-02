<?php
if (isset($_POST['submit'])) {
  $destination = $_GET['destination'];
  $username = $_POST['name'];
  $Password = $_POST['password'];
  $_SESSION['uname'] = $_POST['name'];
  $_SESSION['upass'] = $_POST['password'];
  $param12 = array('UserName' => "$username");
  $client12 = new soapclient('https://etypeservices.com/service_GetPublicationIDByUserName.asmx?WSDL');
  $response12 = $client12->GetPublicationID($param12);


  if ($response12->GetPublicationIDResult == -9) {
    $msg = "Invalid User Name or Password. ";
  }
  else {
    if ($response12->GetPublicationIDResult == 3191) {
      $param = array('UserName' => "$username", 'Password' => "$Password");
      $client = new soapclient('https://etypeservices.com/Service_SubscriberLogin.asmx?WSDL');

      $response = $client->ValidateSubscriber($param);

      $param1 = array('UserName' => "$username");
      $client1 = new soapclient('https://etypeservices.com/Get_EmailbyUserName.asmx?WSDL');

      $response1 = $client1->GetSubscriberEmail($param1);


      $query = "select name, uid from users where name='" . $username . "'";
      $qu = db_query($query);

      $userexit = "";
      $useruid = "";
      foreach ($qu as $qu) {
        $userexit = $qu->name;
        $useruid = $qu->uid;
      }


      if ($response->ValidateSubscriberResult == -1) {
        $msg = "Your Subscription has expired. <a href='https://www.etypeservices.com/Subscriber/SignIn.aspx?IssueID=103864&ReturnUrl=https://www.etypeservices.com/Subscriber/ReSubscribe.aspx?PubID=3191'>Click here</a>  to re-subscribe.";
      }
      else {
        global $user;
        if ($user->uid == 0) {
          if ($userexit != '') {
            if ($response->ValidateSubscriberResult == -5) {
              $msg = "Invalid UserName or Password";

            }

            else {
              global $user;
              $user = user_load($useruid);
              drupal_session_regenerate();
              drupal_goto($destination);
            }
          }
          else {
            if ($response->ValidateSubscriberResult == -5) {
              $msg = "Invalid UserName or Password.";
            }
            else {

              $param1 = array('UserName' => "$username");
              $client = new soapclient('https://etypeservices.com/Get_EmailbyUserName.asmx?WSDL');

              $response1 = $client->GetSubscriberEmail($param1);
              $fields = array(
                'name' => $username,
                'mail' => $response1->GetSubscriberEmailResult,
                'pass' => $Password,
                'status' => 1,
                'init' => $response1->GetSubscriberEmailResult,
                'roles' => array(
                  DRUPAL_AUTHENTICATED_RID => 'authenticated user',
                ),
              );


              $account = user_save('', $fields);

              $param = array('UserName' => "$username");

              $client1 = new soapclient('https://etypeservices.com/Service_GetExpiryDate.asmx?WSDL');

              $response = $client1->SubscriptionExpiryDate($param);

              $qu = $account->uid;

              $role = 6;
              $t = $response->SubscriptionExpiryDateResult;
              echo $t;
              $qu = db_query('SELECT MAX(uid) FROM {users}')->fetchField();

              $query = "select name, uid from users where name='" . $username . "'";
              $qu = db_query($query);
              $useruid = "";
              foreach ($qu as $qu) {
                $useruid = $qu->uid;
              }

              global $user;
              $user = user_load($useruid);
              drupal_session_regenerate();
              drupal_goto($destination);

            }
          }
        }
      }
    }
    else {
      $msg = "Invalid UserName or Password.";
    }
  }
}
?>

<div class="login">
    <form method="POST" action="">
        <p class="error"><?php echo $msg; ?></p>
        <p><input type="text" name="name" placeholder="User Name"
                  required="required"></p>
        <p><input type="password" name="password" placeholder="Password"
                  required="required"></p>
        <p class="remember_me">
            <!-- <label>
               <input type="checkbox" name="remember_me" id="remember_me">
               Remember me on this computer
             </label> -->
        </p>
        <p class="submit">
            <input type="submit" name="submit" value="Login" />
        </p>
    </form>
</div>

<div class="login-help">
    <p><a href="/forgot-password">Forgot your password?</a></p>
</div>