Chase Paymentech Payment Gateway

This module adds Chase Paymentech hosted checkout as a payment method to
Ubercart. This module is complete in its ability to function as a payment
interface between Ubercart and Chase Paymentech. Upon checkout the user is
sent to Chase's payment site for payment completion. When the customer
completes their payment, or their payment is declined, a response is sent
back to the user's site and their order is updated accordingly.

Notes:
 * This module works for Chase's Canadian implementation of Hosted Checkout.
   I am not sure if the American site offers this same integration.
 * Debit transactions can be used through this interface, however, at the moment
   there is no completion page to display to the user their debit transaction
   response as required by debit companies.
 * This module supports POST, LINK and REDI response methods, but does not
   currently support a RELAY response. REDI can be used to automatically
   redirect the customer back to your site once their transaction is completed.
   The POST and LINK methods require the customer to click the link to return to
   your site. In this case if the user does not click the link and instead
   chooses to browse elsewhere, the order will not be updated with the
   transaction information. This issue will be resolved once the RELAY response
   is implemented. For the time being choose REDI response to avoid this issue.

Module uses Hosted Checkout:
 * http://en.chasepaymentech.ca/hosted_checkout.html

E-xact Hosted Checkout:
 * https://hostedcheckout.zendesk.com/categories/1949-e-xact
 * https://hostedcheckout.zendesk.com/entries/196179 (Hosted Checkout Merchant Integration Primer)
 * https://hostedcheckout.zendesk.com/entries/207209 (Hosted Checkout Integration Manual)
 * https://hostedcheckout.zendesk.com/entries/305107
 * https://hostedcheckout.zendesk.com/entries/213740

Demo Account / Store Demo
 * https://rpm-demo.e-xact.com/payment 
 * https://checkout.e-xact.com/payment

Test Credit Card Numbers - https://hostedcheckout.zendesk.com/entries/231255
Visa  4111111111111111 expiry date: Any future date (e.g. 12/12)
MasterCard  5500000000000004 expiry date: Any future date (e.g. 12/12)
American Express 340000000000009 expiry date: Any future date (e.g. 12/12)
JCB  3088 0000 0000 0009 expiry date: Any future date (e.g. 12/12)
Discover 6011 0000 0000 0004 expiry date: Any future date (e.g. 12/12)

The "HCO-#####-##" format is for demo account while "WSP-#####-##" is for live account.
