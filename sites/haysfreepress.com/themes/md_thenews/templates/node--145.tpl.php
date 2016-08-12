<?php
if (isset($_POST['submit'])) {

  $email = $_SESSION['email'];
  $UserName = $_SESSION['username'];
  $Password = $_SESSION['password'];
  $firstname = $_SESSION['firstname'];
  $lastname = $_SESSION['lastname'];
  $address = $_SESSION['address'];
  $city = $_SESSION['city'];
  $state = $_SESSION['state'];
  $postal = $_SESSION['postalcode'];
  $phone = $_SESSION['phone'];
  $publicationid = $_SESSION['Publication_Id'];
  $planid = $_SESSION['planId'];
  $date = date("Y-m-d");
  $expdate = date('Y-m-d', strtotime("+" . $_SESSION['Period'] . " " . $_SESSION['PeriodType'] . ""));
  // $param=array('Email' =>"$email",'UserName' =>"$UserName",'Password' =>"$Password",'FirstName' =>"$firstname",'LastName'=>"$lastname",'StreetAddress'=>"$address",'City'=>"$city",'State'=>"$state",'PostalCode'=>"$postal",'Phone'=>"$phone",'ExpiryDate'=>"$expdate",'PublicationID'=>"$publicationid",'SubscriptionPlanID'=>"$planid");

  // $client3= new soapclient('http://etypeservices.com/Service_SubsciberRegistration.asmx?wsdl');

  //  $response3=$client3->SubscriberRegistration($param);


  $publicationid = $_SESSION['Publication_Id'];

  $client1 = new soapclient('http://etypeservices.com/Service_GetPublisherPaypalEmailID.asmx?WSDL');
  $param1 = array('PublicationID' => "$publicationid");

  $response1 = $client1->GetPublisherPaypalEmailID($param1);
  // $client2= new soapclient('http://etype.sublimeitsolutions.com/Service_GetTransfirstKeys.asmx?wsdl');
  //$response2=$client2->GetTranfirstMercKeys($param2);

}


?>
<style>
  #content {
    width: 100%;
  }
</style>

<h3 style="Background:gray;line-height: 2.0em;font-size:16px">
  <center>REVIEW ORDER</center>
</h3>
<div style="margin-left:30px">
  <p style="margin-top:10px">
    Your order is almost complete. Please Fill out the information below and
    click Pay and Continue.
  </p>
  <h4 style="Background:gray;line-height: 2.0em;font-size:14px">
    <center>Cart Content</center>
  </h4>
  <table style="width: 100%;">

    <tr>
      <td>Quantity
      </td>
      <td>Product
      </td>
      <td>Price
      </td>
    </tr>
    <tr>
      <td>1*
      </td>
      <td><?php echo $_SESSION['planTitle'];
        echo $_SESSION['Period'];
        echo $_SESSION['PeriodType']; ?>
      </td>
      <td>$<?php echo $_SESSION['planPrice'] ?>
      </td>
    </tr>
  </table>
  <h4>Welcome,<?php echo $_SESSION['firstname'];
    echo "&nbsp";
    echo $_SESSION['lastname']; ?></h4>

  <div class="main">

    <div class="maincontent">

      <div class="content" style="background: beige;border: 1px gray solid;">

        <div class="cont">
          <h3 style="margin-left: 23px;"><b> Make Payment</b></h3>

          <form action="/node/150" method="POST">
            <div style="min-height: 387px">
              <table cellpadding="0" cellspacing="0" style="margin-top: -118;"
                     width="85%" align="center">
                <tbody>

                <tr>
                  <td valign="top">

                    <table width="100%" border="0" cellpadding="4"
                           cellspacing="0"
                           style="background:#F4F4F4; border:1px gray solid ; border-radius:3px">
                      <tbody>
                      <tr valign="middle">
                        <td width="22%">
                          <div align="right">
                            <font color="#000000"><strong><font size="1"
                                                                face="Verdana, Arial, Helvetica, sans-serif">
                                  Card Number:</font></strong></font></div>
                        </td>
                        <td width="78%">
                          <input type="text" placeholder="Credit Card Number"
                                 name="ccnumber" required="required">

                          <input type="hidden" placeholder="name"
                                 value="9210236974" name="MerchantID"
                                 required="required">
                          <input type="hidden" placeholder="name"
                                 value="9THTAJTDT9P5X569" name="RegKey"
                                 required="required">
                        </td>
                      </tr>


                      <tr valign="middle">
                        <td>
                          <div align="right">
                            <font color="#000000"><font size="1"
                                                        face="Verdana, Arial, Helvetica, sans-serif">Expiry
                                Date :</font></font></div>
                        </td>
                        <td>
                          <select name="cc_exp_yr" required="required">
                            <option>YY</option>
                            <?php for ($i = 10; $i < 50; $i++) { ?>
                              <option
                                value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                          </select>
                          <select name="cc_exp_mo" required="required">
                            <option>MM</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                          </select>

                        </td>
                      </tr>

                      <tr valign="middle">
                        <td>
                          <div align="right">
                            <font size="1"
                                  face="Verdana, Arial, Helvetica, sans-serif"><strong>Amount:</strong></font>
                          </div>
                        </td>
                        <td id="am_type">
                          <?php $p = $_SESSION['planPrice'] * 100; ?>
                          <input type="text" placeholder="Total amount"
                                 name="amount" style="color:gray"
                                 value="<?php echo $_SESSION['planPrice']; ?>"
                                 maxlength="12" size="12" readonly="readonly"
                                 required="required">
                          <input type="hidden" value="<?php echo $p; ?>"
                                 name="hideamt">
                          <font size="1"
                                face="Verdana, Arial, Helvetica, sans-serif"><strong>USD </strong>
                          </font>

                        </td>
                      </tr>
                      <tr valign="middle">
                        <td>
                          <div align="right">
                            <font size="1"
                                  face="Verdana, Arial, Helvetica, sans-serif"><strong>CVV
                                Number:</strong></font></div>
                        </td>
                        <td>
                          <input type="text"
                                 placeholder="3- or 4-digit card verification code"
                                 name="cvv" required="required">

                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">

                          <img alt="card logo" class="style1"
                               src="image/card_icon.gif">
                        </td>
                      </tr>
                      <tr valign="top">
                        <td>

                        </td>
                        <td>

                          <div style="margin-left: -25px;">
                            <div
                              id="ctl00_ContentPlaceHolder1_ValidationSummary1"
                              style="color:Red;display:none;">

                            </div>
                          </div>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </td>
                  <td valign="top">
                    <table class="headerTable"
                           style="width: 514px;margin-left: 18px;background:#F4F4F4; border:1px gray solid ; border-radius:3px">
                      <tbody>
                      <tr>
                        <td>
                          First name :
                        </td>
                        <td>
                          <input type="text" placeholder="First Name"
                                 name="firstname"
                                 value="<?php echo $_SESSION['firstname']; ?>"
                                 required="required">
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>
                          last name :
                        </td>
                        <td>
                          <input type="text" placeholder="Last Name"
                                 name="lastname"
                                 value="<?php echo $_SESSION['lastname']; ?>"
                                 required="required">
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Billing address :
                        </td>
                        <td>
                          <input type="text" placeholder="Address"
                                 name="address1"
                                 value="<?php echo $_SESSION['address']; ?>">
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>

                      <tr>
                        <td>
                          City :
                        </td>
                        <td>
                          <input type="text" placeholder="City" name="city"
                                 value="<?php echo $_SESSION['city']; ?>">
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Country :
                        </td>
                        <td>
                          <select name="country" id="country">
                            <option selected="selected" value="US">US</option>

                          </select>
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>
                          State / Province :
                        </td>
                        <td>
                          <select name="state" id="state">
                            <option selected="selected" value="AK">AK</option>
                            <option value="AL">AL</option>
                            <option value="AR">AR</option>
                            <option value="AS">AS</option>
                            <option value="AZ">AZ</option>
                            <option value="CA">CA</option>
                            <option value="CO">CO</option>
                            <option value="CT">CT</option>
                            <option value="DC">DC</option>
                            <option value="DE">DE</option>
                            <option value="FL">FL</option>
                            <option value="FM">FM</option>
                            <option value="GA">GA</option>
                            <option value="GU">GU</option>
                            <option value="HI">HI</option>
                            <option value="IA">IA</option>
                            <option value="ID">ID</option>
                            <option value="IL">IL</option>
                            <option value="IN">IN</option>
                            <option value="KS">KS</option>
                            <option value="KY">KY</option>
                            <option value="LA">LA</option>
                            <option value="MA">MA</option>
                            <option value="MD">MD</option>
                            <option value="ME">ME</option>
                            <option value="MH">MH</option>
                            <option value="MI">MI</option>
                            <option value="MN">MN</option>
                            <option value="MO">MO</option>
                            <option value="MP">MP</option>
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="NC">NC</option>
                            <option value="ND">ND</option>
                            <option value="NE">NE</option>
                            <option value="NH">NH</option>
                            <option value="NM">NM</option>
                            <option value="NV">NV</option>
                            <option value="NY">NY</option>
                            <option value="OH">OH</option>
                            <option value="OK">OK</option>
                            <option value="OR">OR</option>
                            <option value="PA">PA</option>
                            <option value="PR">PR</option>
                            <option value="PW">PW</option>
                            <option value="SC">SC</option>
                            <option value="SD">SD</option>
                            <option value="TN">TN</option>
                            <option value="TX">TX</option>
                            <option value="UT">UT</option>
                            <option value="VA">VA</option>
                            <option value="VI">VI</option>
                            <option value="VT">VT</option>
                            <option value="WA">WA</option>
                            <option value="WV">WV</option>
                            <option value="WY">WY</option>
                            <option value="WI">WI</option>

                          </select>
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Zip / Postal code :
                        </td>
                        <td>
                          <input type="text" placeholder="Zip" name="zip"
                                 value="<?php echo $postal; ?>">
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Phone number :
                        </td>
                        <td>
                          <input type="text" placeholder="Phone" name="phone"
                                 value="<?php echo $phone; ?>">
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Email address :
                        </td>
                        <td>
                          <input type="email" placeholder="abc@email.com"
                                 name="email"
                                 value="<?php echo $_SESSION['email']; ?>"
                                 required="required">
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>

                      <tr>
                        <td>
                          &nbsp;
                        </td>
                        <td>
                          <input type="submit" name="pay"
                                 value="Pay and Continue">
                        </td>
                        <td>
                          &nbsp;
                        </td>
                      </tr>


                      </tbody>
                    </table>
                  </td>
                </tr>


                </tbody>
              </table>


              </td>
              </tr>
              </tbody></table>
            </div>
          </form>
        </div>


      </div>


    </div>
  </div>
</div>
