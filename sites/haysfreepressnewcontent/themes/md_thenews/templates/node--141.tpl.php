    <?php

        if(isset($_POST['submit']))
        {

        $param=array("PublicationId" => $_POST['publication']);
      
         
        $client= new soapclient('http://etypeservices.com/Service_GetSubsciptionPlan.asmx?wsdl');
        
     $response=$client->GetSubsciptionPlan($param);
        $_SESSION['Publication_Id'] =$_POST['publication'];
    // echo "<pre>";
      //print_r($response);
      // echo "</pre>";
      }
      ?>
       <form  name="planform" method="POST" action="/node/142" enctype="multipart/form-data">
<fieldset>
    <style>

.header1{width:100%;height:auto;margin-left: 15px;}
.headertop{width:100%;height:auto;}
.headerdown{width:100%;height:auto;}
.headerdl{width:50%;height:auto;float:left;margin-top: 20px;}
.headerdr{width:50%;height:auto;float:left;}

.content1{width:900px;margin-left: 0px !important;}
.left{width:100%;float:left;}
.right{width:50%;float:left;}
.footer1{width:100%; text-align:center;}
.container_12 .grid_8{width:100%;}
h3{font-size: 19px !important;}
</style>
              
<div class="header1" >
<div class="headertop">
<h1 style="background: gray;margin-right: 33px;"> <center>CHOOSE THE SUBSCRIPTION THAT'S RIGHT FOR YOU</center></h1></div>
<div class="headerdown">
<div class="headerdl" style="height:200px;">


<img src="http://www.haysfreepress.com/sites/default/files/logo.png"  style="width:95%; height:140px;">

</div></div>

          
<br/>
            <p style="text-align: justify;margin-right: 41px;margin-top: 13px;">
              Select the Subscription Term that is right for you, then click Submit!. You will be taken to a form where you will be asked to submit your customer and billing info.
<br/>
<br/>
Whether you’re a current subscriber or a new subscriber, all subscription plans include digital e-Edition (delivered to your email inbox) and website access.<br/>
<br/>
<strong>Already a print subscriber? <a href="http://etypeservices5.net/hays/node/143" style="color:red">Fill out this form</a> to activate your digital subscription. Once your print subscription is verified, your user account will be enabled.</strong>
             </p>
          
      <!--<input type="submit" name="alreadysub" value="Already Print Subscriber!" />-->
 
    
<div class="content1">
<div class="left">
<br /><br />
  <?php if($_POST['publication']==200) {?>

<strong><h3>Hays Free Press </h3></strong>
<?php } ?>
<br/>
<?php
                $i=0;
               while($response->GetSubsciptionPlanResult->PlanDetails[$i]->ID > 0) 
                {?>
              <input type="radio" name="plandetail" value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->ID ;?>" required>  <?php echo "&nbsp"; echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Title; echo "&nbsp";echo "-";echo "&nbsp";  echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Period; echo "&nbsp";echo "&nbsp"; echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->PeriodType; ?> Subscription for $ <?php echo "&nbsp"; echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Price ;?><br>
              <input type="hidden" name="Publication_Id" value="<?php echo $_SESSION['Publication_Id'];?>">

              <input type="hidden" name="planPeriod" value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Period;?>">
              <input type="hidden" name="planPeriodType" value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->PeriodType;?>">
              <input type="hidden" name="planPrice" value="<?php echo $response->GetSubsciptionPlanResult->PlanDetails[$i]->Price;?>">
              <?php $i++; } ?>



</div>

  
</div>

     
               </fieldset>
        <div style="text-align:center;margin-top:10px;"><!--<strong>CURRENT SUBSCRIBER?<br/>
Your subscription now include full access to our website and e-Edition.<br />
Clickhere to activate your digital access</strong>--><br/>
                
				<input type="submit" name="submit" value="Submit!" style="background-color: gainsboro;border-radius: 4px;width: 93px;height: 28px;border: 1px solid #CCC;text-decoration: none;color: #000;text-shadow: white 0 1px 1px;padding: 2px;" />
                </div>
        </form>