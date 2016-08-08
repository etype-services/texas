
<?php 
if(isset($_POST['submit']))
{
    $username=$_SESSION['uname'];
$Password=$_SESSION['upass'];
 $param1=array('UserName' =>"$username");
      $client= new soapclient('http://etypeservices.com/Get_EmailbyUserName.asmx?WSDL');
           
      $response1=$client->GetSubscriberEmail($param1);
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
   
 $param=array('UserName' =>"$username");

      $client1= new soapclient('http://etypeservices.com/Service_GetExpiryDate.asmx?WSDL');
           
      $response=$client1->SubscriptionExpiryDate($param);

       $qu=$account->uid;

$role=6;
$t=$response->SubscriptionExpiryDateResult;
echo $t;
$qu=db_query('SELECT MAX(uid) FROM {users}')->fetchField();

$q="insert into uc_roles_expirations(uid,rid,expiration) values('".$qu."','".$role."',UNIX_TIMESTAMP('$t'))";

$qu1=db_query($q);
$query="select name, uid from users where name='".$username."'";
$qu=db_query($query);
$useruid = "";
foreach($qu as $qu)
{
$useruid = $qu->uid;
}

global $user;
$user = user_load($useruid );
drupal_session_regenerate();
drupal_goto('user');

    }
?>

     
       <form method="POST" action="">
     	<div>
        <h2>Terms and Conditions</h2>
      
        <br/>
        <p style="text-align: justify;">
        	To continue to use this site please read the Terms & Conditions below, and complete the form to confirm your acceptance.<br/>
            <br/>
        	Terms and Conditions of Use<br/>
            <br/>
			Terms & Conditions <br/>
            <br/>
        </p>
        <div style="height:350px;overflow: scroll;border: 1px solid gray;text-align: justify;">
        	<p style="margin-left: 5px;margin-right: 5px;text-align: justify;margin-top: 5px;">
        	<strong>SUBSCRIBER AGREEMENT1.</strong> General Rules and Definitions<br />
1.1 This website (the "Site") is owned by Hays Free Press, Inc. (also referred to as "we" or "us"). By using the Site and the services, information, and materials provided on or through the Site (collectively, the "Service"), you agree to abide by all of the terms and conditions of this Agreement.<br />
1.2 We may change, add, or remove parts of this Agreement at any time. If we do so, we will post the changes on the Site, or send them to you by e-mail or postal mail. You will be responsible for reviewing this Agreement before each use of the Site and the Service, and by continuing to use the Site and the Service, you agree to any changes.<br />
1.3 IF ANY OF THE TERMS, CONDITIONS, OR RULES OF THIS AGREEMENT OR ANY FUTURE CHANGES TO THE AGREEMENT ARE UNACCEPTABLE TO YOU, YOU MAY CANCEL YOUR SUBSCRIPTION BY E-MAIL SENT TO: cancel@haysfreepress.com (ALSO SEE SECTION 10.1 REGARDING TERMINATION). YOUR CONTINUED USE OF THE SITE AND THE SERVICE NOW, OR FOLLOWING THE POSTING OF NOTICE OF ANY CHANGES IN THE TERMS, CONDITIONS, OR RULES OF THIS AGREEMENT, WILL INDICATE YOUR ACCEPTANCE OF ALL OF THE TERMS, CONDITIONS, AND RULES OF THIS AGREEMENT, AS MODIFIED.<br />
1.4 We may change the Site and change, suspend, or discontinue any aspect of the Service at any time, including the availability of any Service feature, database, or content. We may also impose limits on certain features and services or restrict your access to parts or all of the Site and the Service without notice or liability.2. Content and Subscriber Submissions<br />
2.1 The contents of the Site and the Service are intended solely for your personal, non-commercial use. All materials published on the Site (including, but not limited to news articles, photographs, images, illustrations, audio clips, and video clips, also known as the "Content") are protected by copyright, trademark, and other intellectual property laws, and are owned or controlled by us, or the party credited as the provider of the Content. You agree to abide by all additional copyright, trademark, intellectual property, and other notices, information, or restrictions contained in any Content accessed through the Service.<br />
2.2 The Site, Service, and Content are protected under U.S. and international copyright, trademark, and other intellectual property laws. You may not modify, publish, transmit, participate in the transfer or sale of, reproduce (except as provided in Section 2.3 of this Agreement), create new works from, distribute, perform, display, or in any way exploit, any of the Content or the Service (including software) in whole or in part.<br />
2.3 You may download or copy one copy of individual pages of the Site and other downloadable items displayed on the Site for personal use only, provided that you maintain all copyright and other notices contained therein. Copying or storing any Content for other than personal use is expressly prohibited without our prior written permission, or the prior written permission of the copyright holder identified in the copyright notice contained in the Content.<br />
2.4 Certain Content may be furnished by wire services, such as the Associated Press. Neither we nor the wire services will be liable for any delays, inaccuracies, errors, or omissions in any such Content, or in the transmission or delivery of all or any part thereof, or for any damages arising there from.3. Forums and Discussions<br />
3.1 You will not upload to, post, distribute or otherwise publish on the message boards (the "Forums") or otherwise on the Site any libelous, defamatory, obscene, pornographic, abusive, or otherwise illegal material.<br />
3.2 Please be courteous. You agree that you will not threaten or verbally abuse other Subscribers or other persons, use defamatory language, or deliberately disrupt discussions with repetitive messages, meaningless messages or "spam."<br />
3.3 Please use respectful language in addressing other Subscribers and other persons. You agree not to use language that abuses or discriminates on the basis of race, religion, nationality, gender, sexual preference, age, region, disability, etc. Hate speech of any kind is grounds for immediate and permanent suspension of access to all or part of the Site and the Service.<br />
3.4 Debate is encouraged, but personal attacks will not be allowed. We encourage active discussions and welcome heated debates in our Forums. But personal attacks are a direct violation of this Agreement and are grounds for immediate and permanent suspension of access to all or part of the Site and the Service.<br />
3.5 The Forums must be used only in a non-commercial manner. You will not, without our express prior written approval, distribute or otherwise publish any material containing any solicitation of funds, advertising, or solicitation for goods or services.<br />
3.6 You are solely responsible for the content of your messages. While we do not and cannot review every message posted by you or others on the Forums and we are not responsible for the content of the messages, we do reserve the right to delete, move, or edit messages that we, in our sole discretion, consider abusive, defamatory, obscene, in violation of copyright, trademark, or other intellectual property laws, or otherwise unacceptable.<br />
3.7 You acknowledge that any submissions you make to us on the Site or through the Service (e.g. letters to the editor, posts, reviews, commentaries, etc.) may be edited, removed, modified, published, transmitted, and displayed by us and you waive any moral or other rights that you may have in having the material altered or changed in a manner not agreeable to you. By posting or submitting any material (including, without limitation, photos and videos), to us on the Site or through the Service, you are representing that (i) you are the owner of the material, or are making your posting or submission with the express consent of the owner of the material, and (ii) you are 13 years of age or older. In addition, when you submit or post any material to the Site or through the Service, you are granting us, and anyone authorized by us, a royalty-free, perpetual, irrevocable, non-exclusive, unrestricted, worldwide license to use, publish, copy, modify, transmit, sell, exploit, create derivative works from, distribute, or publicly perform or display such material, in whole or in part, in any manner or medium, now known or hereafter developed, for any purpose. This grant will include the right to exploit any proprietary rights in the posting or submission, including, but not limited to, rights under copyright, trademark, service mark, patent laws, and other intellectual property laws of any relevant jurisdiction. Further, in connection with the exercise of these rights, you grant us, and anyone authorized by us, the right to identify you as the author of any of your postings or submissions by name, e-mail address, or screen name, as we deem appropriate.<br />
3.8 You may establish a hypertext link to the Site as long as the link does not state or imply any sponsorship of your website by us or by the Site. Without our prior express written permission, however, you may not frame or inline link any of the Content of the Site, or incorporate into another website or other service any of our Content, material, or intellectual property.4. Access and Availability of Service and Links<br />
4.1 The Site contains links to other related World Wide Web Internet sites, resources, and sponsors of the Site. Since we are not responsible for the availability of these outside resources, or their contents, you should direct any concerns regarding any external link to the site administrator or Webmaster of such site.5. Representations and Warranties<br />
5.1 You represent, warrant, covenant, and agree that (a) no materials of any kind submitted through your account will (i) violate, plagiarize, or infringe on the rights of any third party, including copyright, trademark, intellectual property, privacy, or other personal or proprietary rights; or (ii) contain libelous or otherwise unlawful material; and (b) you are at least 13 years old. You agree to indemnify, defend, and hold LouisianaStateNewspapers.com, Louisiana State Newspapers, Inc., and all of its and their parent companies, subsidiaries, affiliates, officers, directors, owners, agents, information providers, licensors and licensees (collectively, the "Indemnified Parties") from and against any and all liability and costs, including, without limitation, reasonable attorneys' fees, incurred by any of the Indemnified Parties in connection with any claim arising out of any breach of this Agreement or the foregoing representations, warranties and covenants by you or any user of your account. You agree to cooperate as fully as reasonably required in the defense of any such claim. We reserve the right, at our own expense, to assume the exclusive defense and control of any matter subject to indemnification by you.<br />
5.2 WE MAKE NO WARRANTIES, REPRESENTATIONS, OR ENDORSEMENTS, WHATSOEVER, REGARDING THE USE OR RESULTS OF THE USE OF THE SITE OR THE SERVICE OR ANY MATERIALS, INFORMATION, OR PRODUCTS ON THE SITE OR ON THIRD-PARTY WEBSITES IN REGARDS TO THEIR ACCURACY, RELIABILITY, TIMELINESS, OR OTHERWISE, OR AS TO THE ACCURACY OR RELIABILITY OF ANY ADVICE, OPINION, STATEMENT, OR OTHER INFORMATION DISPLAYED, UPLOADED, OR DISTRIBUTED ON THE SITE OR THROUGH THE SERVICE BY ANY USER, INFORMATION PROVIDER, OR ANY OTHER PERSON OR ENTITY. YOU ACKNOWLEDGE THAT YOUR USE OF THE SITE AND ANY MATERIALS, INFORMATION, OR PRODUCTS PROVIDED OR DISTRIBUTED ON OR THROUGH THE SITE OR ON OR THROUGH THIRD-PARTY WEBSITES AND ANY RELIANCE ON ANY SUCH MATERIALS, INFORMATION, OR PRODUCTS OR ANY ADVICE, OPINIONS, STATEMENTS, OR OTHER INFORMATION IN CONNECTION THEREWITH WILL BE AT YOUR SOLE RISK. THE SITE, SERVICE, ALL DOWNLOADABLE SOFTWARE, AND THE MATERIALS, INFORMATION, PRODUCTS, AND SERVICES PROVIDED OR DISTRIBUTED ON OR THROUGH THE SITE OR ANY THIRD-PARTY WEBSITES ARE OFFERED AND DISTRIBUTED ON AN "AS IS" BASIS WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING, WITHOUT LIMITATION, WARRANTIES OF TITLE OR IMPLIED WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE. YOU HEREBY ACKNOWLEDGE THAT YOUR USE OF THE SITE, SERVICE AND ALL MATERIALS, INFORMATION, PRODUCTS, AND SERVICES IS AT YOUR SOLE RISK.6. Registration and Security<br />
6.1 As part of the registration process, you will be required to select a password and a Subscriber ID. You will also be required to give us certain registration information, which may include personal demographic information (i.e., gender, date of birth, zip code, and country), all of which must be accurate and updated. You may not (i) select or use a Subscriber ID of another person with the intent to impersonate that person; (ii) use a Subscriber ID in which another person has rights without such person's authorization; or (iii) use a Subscriber ID that we, in our sole discretion, consider offensive or objectionable. Your failure to comply with the foregoing will constitute a breach of this Agreement, which may result in immediate termination of your account. You will be responsible for maintaining the confidentiality of your password, which you will not be required to reveal to any of our representatives or agents.<br />
6.2 You agree to notify help@haysfreepress.com of any known or suspected unauthorized use of your account, or any known or suspected breach of security, including loss, theft, or unauthorized disclosure of your password or credit card information.<br />
6.3 You must be 13 years or older to subscribe to the Service, although persons of all ages may use your subscription. Thus, you may share your password and Subscriber ID with others, subject to Section 6.4.<br />
6.4 You are responsible for all usage or activity on your account with us, including the use of the account by any third party authorized by you to use your Subscriber ID and password. Any fraudulent, abusive, or otherwise illegal activity may be grounds for termination of your account, at our sole discretion, and we may refer you to appropriate law enforcement agencies.7. Fees and Payments<br />
7.1. We reserve the right at any time to charge fees for access to portions of the Site or the Service or the Site and the Service as a whole. However, in no event will you be charged for access to the Site or the Service unless we obtain your prior agreement to pay the charges. Accordingly, if at any time we require a fee for portions of the Site or the Service that are now free (e.g., a domestic subscription fee), we will give you advance notice of the fees and the opportunity to cancel the account before the charges are imposed. All new fees, if any, will be posted in the Site Help area of our Subscriber Center and in other appropriate locations on the Site. You agree to pay all fees and charges incurred through your account at the rates in effect for the billing period in which the fees and charges are incurred, including, but not limited to charges for any products or services offered for sale on or through the Site or the Service by us or by any other vendor or service provider. All fees and charges will be billed to and paid for by you. You agree to pay all applicable taxes relating to use of the Service through your account.8. Communications with Subscribers<br />
8.1 If you indicate on your registration form that you want to receive such information, we and our owners and assigns will allow certain third-party vendors to provide you with information about products and services.<br />
8.2 We reserve the right to send electronic mail to you for the purpose of informing you of changes or additions to the Site and the Service.<br />
8.3 We reserve the right to disclose information about your usage and demographics, provided that it will not reveal your personal identity in connection with the disclosure of such information. Advertisers and/or licensees on the Site may collect and share information about you only if you indicate your acceptance. For more information please read our Privacy Policy at Privacy Policy .9. Software Licenses<br />
9.1 You will have no rights to the proprietary software and related documentation, or any enhancements or modifications thereto, provided to you in order to access the Site and the Service ("Access Software"). You may not sublicense, assign, or transfer any licenses or rights granted by us, and any attempt at such sublicense, assignment, or transfer will be null and void. You may make one copy of such software for archival purposes only. You may not otherwise copy, distribute, modify, reverse engineer, or create derivative works from Access Software.10. Termination<br />
10.1 You may terminate your account at any time by e-mail sent to: cancel@haysfreepress.com. Upon termination, you will receive an automated confirmation by e-mail that the request was received, and your access will be suspended within 24 hours. You are responsible for all charges incurred up to the time the account is deactivated.<br />
10.2 We may, in our sole discretion, terminate or suspend your access to all or part of the Site and the Service for any reason or for no reason, including, without limitation, breach or assignment of this Agreement.11. Limitation of Liability<br />
11.1 TO THE FULLEST EXTENT ALLOWED UNDER APPLICABLE LAW, UNDER NO CIRCUMSTANCES, INCLUDING BUT NOT LIMITED TO NEGLIGENCE, WILL WE OR OUR PARENT COMPANIES, SUBSIDIARIES, AFFILIATES, OFFICERS, DIRECTORS, OWNERS, OR AGENTS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, OR CONSEQUENTIAL DAMAGES THAT RESULT FROM THE USE OF, OR INABILITY TO USE, THE SITE OR THE SERVICE, INCLUDING ANY MATERIALS, INFORMATION, PRODUCTS, AND SERVICES PROVIDED OR DISTRIBUTED ON OR THROUGH THE SITE OR THE SERVICE, OR BY ANY THIRD-PARTY PROVIDERS. YOU ACKNOWLEDGE AND AGREE THAT WE ARE NOT LIABLE FOR ANY DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT BY YOU OR OF ANY SUBSCRIBER OR OTHER USER OF THE SITE OR THE SERVICE. IF YOU ARE DISSATISFIED WITH THE SITE OR THE SERVICE, OR ANY INFORMATION, MATERIALS, PRODUCTS, AND SERVICES PROVIDED OR DISTRIBUTED ON OR THROUGH THE SITE OR THE SERVICE, OR ANY OF THE TERMS OR CONDITIONS OF THE SITE, THE SERVICE, OR THIS AGREEMENT, YOUR SOLE AND EXCLUSIVE REMEDY IS TO DISCONTINUE USING THE SITE AND THE SERVICE AND TO TERMINATE THIS AGREEMENT.12. General<br />
12.1 This Agreement has been made in and will be construed and enforced in accordance with Louisiana law. Any action to enforce this agreement will be brought in the federal or state courts located in Lafayette, Louisiana.<br />
12.2 Notwithstanding any of the foregoing, nothing in this Agreement will serve to preempt the promises made in our Privacy Policy.<br />
12.3 Correspondence that you send to us should be sent to help@haysfreepress.com.<br />
12.4 You agree to report any copyright violations of this Agreement to us as soon as you become aware of them. If you have a claim of copyright infringement with respect to material that is contained on or in the Site or the Service, please notify help@haysfreepress.com. (Please direct all general questions to help@haysfreepress.com.)<br />
12.5 If any part of this Agreement is held to be indefinite, invalid, or otherwise unenforceable, the rest of the Agreement will continue in full force.<br />
12.6 This Agreement and any other agreement delivered in connection with this Agreement contain all the terms and conditions agreed on by the parties. Any previous agreements between the parties, whether written or oral, are replaced by this Agreement.<br /></p>

        </div>
        <br />
        <input type="checkbox" name="tandc" required> Accept Terms & Conditions of Use *
           </div>   
           <br />
          
		  <input type="submit" name="submit" value="Submit" style="background-color: gainsboro;border-radius: 4px;width: 93px;height: 28px;border: 1px solid #CCC;text-decoration: none;color: #000;text-shadow: white 0 1px 1px;padding: 2px;" />
          </form>
      
 
 
            
            


        