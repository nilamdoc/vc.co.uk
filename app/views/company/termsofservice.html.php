<?php
use app\models\Parameters;
$Comm = Parameters::find('first');
?>
<div class="container">
<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat">
<h3><?=$t("Terms of Service")?></h3>

<strong><?=$t("Please read these Terms carefully and do not use the Site or the Platform unless you accept them.")?></strong>
<p><a href="https://<?=COMPANY_URL?>/">https://<?=COMPANY_URL?>/</a> <?=$t("is a site operated by of IBWT JD LTD ")?>("<strong>IBWT</strong>"), <?=$t("a company incorporated under the laws of England and Wales. Registered address: 31 North Down Crescent, Keyham, Plymouth, Devon, United Kingdom, company number: 08854667. Our VAT number is 165221136. IBWT is regulated by the Information Commissioners Office, registered no: ZA007784.")?></p>
<p><?=$t("These Terms of Service ")?>("<strong><?=$t("Terms")?></strong>") <?=$t("set the conditions by which a customer, as a registered user ")?>("<strong><?=$t("Customer(s)")?></strong>")<?=$t(" can use our services for the purposes of becoming buyers ")?>("<strong>Buyers</strong>")<?=$t(" and sellers ")?>("<strong>Sellers</strong>"),<?=$t(" transferring the digital value asset known as  'Crypto-currency(s)', including, but not limited to 'Bitcoin(s)' and 'Litecoin(s)'.")?></p>
<p><?=$t("The services allow Customers to transfer funds into ('Deposit') or from ('Withdrawal') their IBWT account to their registered OKPAY account, or via limited Royal Mail Special Delivery Service (currently UK residents only). And to interact with other businesses or individuals who accept Crypto-currency.")?></p>
<p><?=$t("OKPAY is an international company and accepts bank wire transfers from all over the world.")?></p>

<p><?=$t("By submitting a request to open an account ('Account') customers confirm that they;")?>
<ul>
<li><?=$t('have the full capacity to wilfully accept these Terms of Service and enter into a transaction resulting on the Platform.')?></li>
<li><?=$t('have submitted a true representation of documents to verify their identity if required for higher customer status and all that it entails.')?></li>
<li><?=$t('and have accepted these Terms of Service.')?></li>
</ul>
</p>
<p><?=$t("IBWT reserves the right to amend, change, add or remove sections of these Terms at any time. Customers will be notified via a News Release on the IBWT site. It is Customers responsibility to review any such amendments.")?></p>
<p><?=$t("Customers agree that continued use of our Site signifies that they accept and agree to the changes and that all relations with us are subject to these Terms of Service and any amendments.")?></p>
<p><?=$t("IBWT grants its Customers non-exclusive, personal, non-transferable, non-sub licensable and limited right to enter and use the IBWT site and services.")?></p>

<h4><?=$t("DEFINITIONS")?></h4>

<p><strong><?=$t("Platform")?></strong>: <?=$t("means the software, technical and organisational structure managed by IBWT located at the")?> <a href="https://<?=COMPANY_URL?>/">https://<?=COMPANY_URL?>/</a> <?=$t("address")?>.</p>

<p><strong><?=$t("Bitcoin(s)")?></strong>: <?=$t("means the Peer-to-Peer digital transfer value asset (as described at ")?><a href="https://bitcoin.org/en/" target="_blank">https://bitcoin.org/en/</a>).</p>
<p><strong><?=$t("Litecoin(s)")?></strong>:<?=$t("means the Peer-to-Peer digital transfer value asset (as described at ")?><a href="https://litecoin.org/" target="_blank">https://litecoin.org/</a></p>
<p><strong><?=$t("Crypto-Currency(s)")?></strong>:<?=$t("means Crypto-currency and any alternative coin based upon the Bitcoin protocol.")?></p>
<p><strong><?=$t("Seller(s)")?></strong>: <?=$t("means Customers(s) that submit an offer to sell Crypto-currency(s) on the Platform.")?></p>

<p><strong><?=$t("Buyer(s)")?></strong>: <?=$t("means Customers(s) that submit an offer to buy Crypto-currency(s) on the Platform.")?></p>

<p><strong><?=$t("Customer(s)")?></strong>: <?=$t("Any holder of an account.")?></p>
<p><strong><?=$t("Price")?></strong>: <?=$t("means 'price per coin' for which Customers are willing to purchase or sell Crypto-currency, using the Platform in a Crypto-currency Purchase Transaction.")?></p>
<p><strong><?=$t("Commission")?></strong>: <?=$t("refers to the fee which is payable to IBWT on each Transaction. Fee's at this time are")?> <?=$Comm['value']?>% <?=$t("per transaction. For Purchases and Sales Transactions, commission is charged to each customer per transaction in the received denomination.")?></p>

<p><strong><?=$t("Transaction Price")?></strong>: <?=$t("means the total price paid by the Buyer in respect of each Transaction performed on the Platform.")?></p>
<p><strong><?=$t("Transaction")?></strong>: <?=$t("means;")?> 
<ul>
	<li><?=$t("The agreement between the Buyer and the Seller to exchange Crypto-currency on the Platform for currencies at a commonly agreed rate ('Crypto-currency Purchase Transaction'),")?> </li>
	<li><?=$t("The conversion of currencies deposited by Customers on their account ('Conversion Transaction'),")?> </li>
	<li><?=$t("The transfer of crypto-currency among Customers ('Crypto-currency Transfer Transaction'),")?> </li>
	<li><?=$t("The transfer of currencies among Customers ('Currency Transfer Transaction')")?> </li>
</ul>
</p>

<ol>
<li><strong><?=$t("CUSTOMER ACCOUNT")?></strong>

<p><?=$t("Customers agree to provide IBWT with complete and accurate information about themselves as required by the verification process. Customers accept it is their responsibility to update any relevant information and that it is their liability of any losses incurred, and that accounts may be frozen until relevant information is updated suitably.")?></p>
<p><?=$t("Customers are responsible for the security and confidentiality of their Account information, including but not limited to their password, transactions and other related matters. Customers accept it is their responsibility to contact IBWT immediately if they suspect any unauthorized use of their Account, or any other breach of security by email addressed to ")?> <a href="mailto:security@<?=COMPANY_URL?>">security@<?=COMPANY_URL?></a>. </p>
<p><?=$t("As OKPAY processes the bank wire transfers and customers fund their IBWT account via OKPAY, customers may have to provide verification details to OKPAY. Customers that deposit via OKPAY acknowledge that they have read and accepted the terms and conditions of OKPAY. ")?></p>
<p><?=$t("Any suspicious activity via OKPAY deposits and withdrawals will be reported to the relevant entity. ")?></p>
<p><?=$t("Customers agree that all Accounts are personal Accounts, in that any linked bank accounts must be in their name. And that no business Account will be linked unless requested via email to ")?><a href="mailto:support@<?=COMPANY_URL?>">support@<?=COMPANY_URL?></a>. </p>
<p><?=$t("IBWT may request identification information (such as invoices, Government issued photographic identification, utility bill, recognised e-bills, residential certificate, banking information, or similar) depending on the amounts deposited on the Accounts or the presence of suspicious activity which may indicate money-laundering or other illegal activity. Identification of the bank account from which funds are transferred to the Account may also be requested. In certain cases extra confirmation of certain documents may be requested from third parties. Transactions may be frozen until the identity check has been considered satisfactory by IBWT. IBWT may request additional identification information at any time at the request by application of any applicable law or regulation.")?></p>
<p><?=$t("Customers accept that a telephone call may be initiated by IBWT to verify any of the following, but not limited to: verifying identity, transactions, random security checks, or any other related activity.")?></p>
<p><?=$t("Accounts may be used strictly for the purposes defined in these Terms of Service.")?></p>
</li>
<li><strong><?=$t("TRANSACTIONS")?></strong>
<p><?=$t("Customers may use the Platform to place orders to buy or sell Crypto-currency, or they may buy or sell Bitcoin(s) at the current value that is offered by other Customers.")?></p>
<p><?=$t("Customers accept that once they submit offers to buy or sell Crypto-currency they enter into an Agreement with another Customer to transfer fiat for Crypto-currency or vice versa as soon as their offer matches the Price set in an offer submitted by another Customer. Buyer and Seller agree that once their offers match that their offers are binding and may not be reversed.")?></p>
<p><?=$t("Once the order is placed, IBWT automatically completes the transactions without prior notice to Buyer or Seller.")?></p>
<p><?=$t("The matching of offers and transfer of funds is a service provided by IBWT via the Platform. Under the Distance Selling Directive 97/7/EC, once Buyers and Sellers offers have been matched, Customers forfeit the ability to cancel any Crypto-currency Transaction.")?></p>
<p><?=$t("Customers accept that transferring Crypto-currencys to their IBWT account or to other addresses is reliant upon the protocol and any 'miner' fee they choose to pay and that IBWT has no influence in this. The average time for Crypto-currency transference can be 10 minutes to 24 hours, barring unforeseen or unavoidable network issues.")?></p>
<p><?=$t("Upon matching of the offers of Buyer and Seller, IBWT has the sole authority to permit the transfer of the amount corresponding to the Transaction Price minus the Commission from the Buyer's Account to the Seller.")?></p>
<p><?=$t("Customers may at any time transfer any amount of Crypto-currencys to any other Customer as well as any other Crypto-currency users even if they are not Customers (the 'Receiver').")?></p>
<p><?=$t("Customers can not transfer Fiat.")?></p>
<p><?=$t("Customers are solely responsible for ensuring that any Receiver of their Crypto-currencys shall be a valid and legal transaction not infringing any UK or International laws and regulations.")?></p>
<p><?=$t("The responsibility of IBWT is limited to providing the service to ensure the transference of the Crypto-currencys. When transferring to a non-Customer recipient, IBWT's responsibility shall also be limited to ensuring the transfer of funds through interacting with the Crypto-currency network by relating the necessary technical data.")?></p>
<p><?=$t("IBWT's responsibility shall be limited to using reasonable technical efforts to ensure the receipt of the Crypto-currencys transferred. When conducting Crypto-currency Transfer Transactions with a Crypto-currency user who is not a Member, IBWT's responsibility shall be further limited to ensuring the transfer of the necessary technical data to the Crypto-currency peer-to-peer network.")?></p>
<p><?=$t("No Commission of any kind will be charged by IBWT for Crypto-currency being moved as Crypto-currency, in, out, or around the Platform, a Crypto-currency Transfer Transaction.")?></p>
</li>
<li><strong><?=$t("DEPOSITS & WITHDRAWALS")?></strong>
<p><?=$t("Customers agree to submit a deposit request before transferring any funds to their IBWT account. And Customers agree to abide by the limits set by IBWT in deposit.")?></p>
<p><?=$t("Customers agree to submit a withdrawal request and to wait for their withdrawal request to be confirmed by IBWT before acknowledging the time for their withdrawal to take. Customers acknowledge that Royal Mail withdrawals may take from 1-3 days, depending upon the time the request is made and upon Royal Mail, and that IBWT is not liable for Royal Mail or any other postal or parcel services that are used.")?></p>
<p><?=$t("Customers accept that they are liable for compensation cover fees that Royal Mail or any other parcel or postal service may charge. And that these fee�s will be subtracted from their IBWT account.")?></p>
<p><?=$t("Customers acknowledge that if they do not have suitable funds in their IBWT account to cover the Royal Mail withdrawal compensation cover, that their withdrawal will be declined. And that they will be emailed as such.")?></p>
<p><?=$t("Customers acknowledge that Royal Mail deposits/withdrawals made after 17:00 on a Friday may not be processed until the following Monday.")?></p>
<p><?=$t("IBWT processes deposits/withdrawals via OKPAY 7 days a week.")?></p>
<p><?=$t("OKPAY deposits and withdrawals will be processed within 24 hours.   ")?></p>     
<p><?=$t("Customers acknowledge that they must send OKPAY deposits via deposit@ibwt.co.uk.")?></p>
<p><?=$t("Customers are liable for the OKPAY transfer fee, which will come out of their withdrawal as per terms and conditions of OKPAY.")?></p>
<p><?=$t("A withdrawal fee of 0.0001 is charged to all Crypto-currency withdrawals in their respective denomination. IBWT reserves the right to alter this depending upon the market. 100% of this fee goes towards the miners.")?></p>
<p> There is a &pound;1 fee for withdrawal via OKPAY and the equivalent in Euro or USD, taken at the market average via Google.</p>
</li>
<li><strong><?=$t("OBLIGATIONS")?></strong>
<p><u><?=$t("IBWT Obligations")?></u>
<ul>
<li><?=$t("The skills and expertise with all reasonable care to facilitate Customers transactions by matching offers of Customers via the Platform.")?></li>
<li><?=$t("That transactions will be conducted in an anonymous manner.")?></li>
<li><?=$t("That values of Crypto-currency(s) are determined by Customers initiating Buy or Sell orders.")?></li>
<li><?=$t("That once offers have been met, they cannot be withdrawn.")?></li>
<li><?=$t("It will hold all Fiat and Crypto-currencies deposited by each Customer in their Accounts or in suitable storage (if hard currency), in that Customers registered name and with relation to their details and on such Customers behalf.")?></li>
<li><?=$t("IBWT will ensure that it keeps itself updated with regards to the development of the Crypto-currency economy and any relevant regulation with regard to its Services it provides and the Platform it operates.")?></li>
<li><?=$t("IBWT reserves the right to suspend/freeze your account if you, as a Customer breaks these Terms of Service.")?></li>
<li><?=$t("IBWT will use suitable 3rd party storage facilities (safety deposit boxes and similar) to safeguard user funds.")?></li>
<li><?=$t("Customers understand and accept that IBWT may not be able to process Royal Mail requests made after 17:00 (GMT) Fridays until the following Monday, and that IBWT is not liable for any loss caused by delays of processing requests.")?></li>
<li><?=$t("Customers accept that IBWT is not liable for any loss caused by OKPAY services that IBWT had no control over.")?></li>
</ul>
</p>
<p><u><?=$t("Customers Obligations")?></u>
<ul>
<li><?=$t("Customers accept that they will only use the Platform for the Services as set out in these Terms of Service. Failure to do so or trying to circumvent the conditions held here ma5y result in their account suspended, investigated and possibly terminated.")?></li>
<li><?=$t("Customers acknowledge that buying and selling of Crypto-currency is done via Customer with Customer and IBWT only acts as an intermediary to facilitate such transactions, not as counterparty. That it is the Customers responsibility to comply with all laws and regulations relating to the transactions.")?></li>
<li><?=$t("Customers are solely responsible for their accounts activities which include, but are not limited to, Deposits, Withdrawals, transferring Crypto-currencies.")?></li>
<li><?=$t("Buyers and Sellers warrant to each other that the money type in either denomination is true to their value representation. Corresponding to either fiat or Crypto-currency.")?></li>
<li><?=$t("Customers agree not to use the Platform of any type of illegal activity, or for negatively affecting the performances of the Platform.")?></li>
<li><?=$t("Customers agree that IBWT conducts the technical side of their transactions, in their name and on their behalf.")?></li>
<li><?=$t("Customers accept and acknowledge that they are liable for any charges incurred by relevant entities if they do not confirm to these Terms and Services.")?></li>
<li><?=$t("Customers acknowledge that IBWT is regulated to the current standards with regards to the laws in England and Wales and as required by HM Treasury, HMRC and FCA (formerly FSA), and accept that IBWT requires whatever time necessary to adhere to any new regulations and laws.")?></li>
</ul>
</p>
</li>
<li><strong><?=$t("INTELLECTUAL PROPERTY RIGHTS")?></strong>
<p><?=$t("IBWT is the owner or the licensee of all intellectual property rights in our site and in the material published on it. Those works are protected by copyright laws and treaties around the world. All such rights are reserved.")?></p>
<p><?=$t("Customers may print off as many copies as they like, and may download extracts, of any page(s) from our site for Customers personal reference and Customers may draw the attention of others within their organisation to material posted on our site.")?></p>
<p><?=$t("You must not modify the paper or digital copies of any materials printed off or downloaded in any way, and must not use any illustrations, photographs, video or audio sequences or any graphics separately from any accompanying text.")?></p>
<p><?=$t("IBWT status (and that of any identified contributors) as the authors of material on our site must always be acknowledged.")?></p>
<p><?=$t("You must not use any part of the materials on our site for commercial purposes without obtaining a licence to do so from us or our licensors.")?></p>
<p><?=$t("If you print off, copy or download any part of our site in breach of these terms of use, your right to use our site will cease immediately and you must, at IBWT's option, return or destroy any copies of the materials you have made.")?></p>
<p><?=$t("Without IBWT express prior consent, other websites may only link to the Platform by using the following address:")?> https://<?=COMPANY_URL?>/ <?=$t("to the exclusion of any deep link.")?></p>
</li>
<li><strong><?=$t("VIRUSES, HACKING AND RELATED OFFENCES")?></strong>
<p><?=$t("You must not misuse our site by knowingly introducing viruses, trojans, worms, logic bombs or other material which is malicious or technologically harmful. You must not attempt to gain unauthorised access to our site, the server on which our site is stored or any server, computer or database connected to our site. You must not attack our site via a denial-of-service attack or a distributed denial-of service attack.")?></p>
<p><?=$t("By breaching this provision, you would commit a criminal offence under the Computer Misuse Act 1990. IBWT will report any such breach to the relevant law enforcement authorities and we will co-operate with those authorities by disclosing your identity to them. In the event of such a breach, your right to use our site will cease immediately.")?></p>
<p><?=$t("IBWT will not be liable for any loss or damage caused by a distributed denial-of-service attack, viruses or other technologically harmful material that may infect your computer equipment, computer programs, data or other proprietary material due to your use of our site or to your downloading of any material posted on it, or on any website linked to it.")?></p>
</li>
<li><strong><?=$t("LIABILITY")?></strong>
<p><u><?=$t("Limitation of Warranties")?></u>

<p><?=$t("By using our website, you understand and agree that all Resources IBWT provides are 'as is' and 'as available'. This means that IBWT do not represent or warrant to you that:")?>
<ol>
<li><?=$t("the use of our Resources will meet your needs or requirements.")?></li>
<li><?=$t("the use of our Resources will be uninterrupted, timely, secure or free from errors.")?></li>
<li><?=$t("the information obtained by using our Resources will be accurate or reliable, and")?></li>
<li><?=$t("any defects in the operation or functionality of any Resources IBWT provides will be repaired or corrected.")?></li>
<br>
<?=$t("Furthermore, you understand and agree that:")?>
<li><?=$t("any content downloaded or otherwise obtained through the use of our Resources is done at your own discretion and risk, and that you are solely responsible for any damage to your computer or other devices for any loss of data that may result from the download of such content.")?></li>
<li><?=$t("no information or advice, whether expressed, implied, oral or written, obtained by you from IBWT JD Ltd or through any Resources IBWT provides shall create any warranty, guarantee, or conditions of any kind, except for those expressly outlined in this User Agreement.")?></li>
</ol>
</p>
<p><u><?=$t("Limitation of Liability")?></u>

<p><?=$t("In conjunction with the Limitation of Warranties as explained above, you expressly understand and agree that any claim against us shall be limited to the amount you paid, if any, for use of products and/or services. IBWT JD Ltd will not be liable for any direct, indirect, incidental, consequential or exemplary loss or damages which may be incurred by you as a result of using our Resources, or as a result of any changes, data loss or corruption, cancellation, loss of access, or downtime to the full extent that applicable limitation of liability laws apply")?></p>
<p><?=$t("Customers will be held solely liable for losses incurred by IBWT or any other user of the Site due to someone else using their password or user account.")?></p>
<p><?=$t("Customers affirm and warrant that they are the legitimate owners of represented funds of any denomination used in relation to the Platform and the Services provided by IBWT.")?></p>
<p><?=$t("To the extent that a Customer operates and uses the Site and the Platform other than in the course of its business ('Consumer'), nothing in these Terms shall affect the statutory rights of such Customers.")?></p>
<p><?=$t("Nothing in these terms excludes or limits the liability of either party for fraud, death or personal injury caused by its negligence, breach of terms implied by operation of law, or any other liability which may not by law be limited or excluded.")?></p>
<p><?=$t("Subject to the foregoing, IBWT's aggregate liability in respect of claims based on events arising out of or in connection with a Customer's use of the Site, Platform and/or Services, whether in contract or tort (including negligence) or otherwise, shall in no circumstances exceed the greater of either (a) the total amount held on Account for the Member making a claim less any amount of Commission that may be due and payable in respect of such Account; or (b) 125% of the amount of the Transaction(s) that are the subject of the claim less any amount of Commission that may be due and payable in respect of such Transaction(s).")?></p>
</p>
<p><u><?=$t("Indemnity")?></u>
<p><?=$t("To the fullest extent permitted by applicable law,  customer hereby agree to indemnify IBWT and its affiliates against any action, liability, cost, claim, loss, damage, proceeding or expense suffered or incurred if direct or not directly arising from customers use of IBWT's Site, Platform, Services or from customers violation of these Terms of Service.")?></p>
</p>
</li>
<li><strong><?=$t("TERMINATION")?></strong>
<p><?=$t("Customers agrees that IBWT may, at our sole discretion, suspend or terminate a customers access to all or part of our website and Resources with or without notice and for any reason, including, without limitation, breach of this User Agreement. Any suspected illegal, fraudulent or abusive activity may be grounds for terminating customers relationship and may be referred to appropriate law enforcement authorities. Upon suspension or termination, customers right to use the Resources IBWT provides will immediately cease, and IBWT reserve the right to remove or delete any information that a customer may have on file with us, including any account or login information.")?></p>
<p><?=$t("Customers will be notified of such a termination via customers registered email and it shall not affect the obligations or rights of either party under these Terms which had accrued prior to the notice of termination, nor the Transactions and its related obligations and rights concluded before such termination was effective.")?></p>
<p><?=$t("IBWT may attempt to refund a customer�s account balance via one of the withdrawal methods available, dependent upon the issue at hand, and a customer will have 60 days within receiving such notice to notify IBWT via ")?><a href="mailto:support@<?=COMPANY_URL?>">support@<?=COMPANY_URL?></a><?=$t("  of a Crypto-currency withdrawal address if a customer had Crypto-currencys held on his/her account. Again under the assumption that such termination was not because of any fraud, criminal 8activity, or any other related matter.")?></p>
<p><?=$t("Should they wish to terminate their agreement with IBWT, Customers may close his/her Account at any time.")?></p>
<p><?=$t("IBWT also reserve the right to cancel unconfirmed Accounts or Accounts that have been inactive for a period of 4 months or more, or to modify or discontinue our Site or Platform. Customers agree that IBWT will not be liable to them or to any third party for termination of their Account or access to the Site.")?></p>
<p><?=$t("Customers agree and acknowledge that IBWT can suspend their Account at will until the relevant Customer provides IBWT with documents evidencing their identity and/or any other information IBWT deems as necessary to secure the Account, Transactions, Platform, or services IBWT provides.")?></p>
<p><?=$t("The suspension of an Account has consequences for the future and shall not affect the payment of the commissions due for past Transactions. Therefore, despite the Account having been suspended for whatever reason under these Terms, the Customer must still pay the Commission(s) which were due before the date of suspension.")?></p>
<p><?=$t("Customers acknowledge that suspension or termination of an Account can affect any business account they have with IBWT in a similar manner and will affect future applications to become a Customer of IBWT.")?></p>
<p><?=$t("IBWT reserve the right to refuse an Account and relevant services to any applicant or current Customer for, but not limited to, suspected fraud, criminal activity or abusive behaviour.")?></p>
<p><?=$t("In the case where Customers do not wish to make use of the functionalities of the Platform after having transferred currencies on their account, they may request that said currencies be returned to them. In this case, the same procedure as stipulated under the preceding paragraph shall apply.")?></p>
</li>
<li><strong><?=$t("GOVERNING LAW")?></strong>
<p><?=$t("This website is controlled by IBWT JD Ltd from our offices located in the county of Devon, England and Wales, and via trusted IBWT staff located globally. By accessing our website, customer agrees that the statutes and laws of the England and Wales, without regard to the conflict of laws and the United Nations Convention on the International Sales of Goods, will apply to all matters relating to the use of this website and the purchase of any products or services through this site.")?></p>
<p><?=$t("Furthermore, any action to enforce this User Agreement shall be brought in the courts located in England and Wales, Devon. Customer  hereby agree to personal jurisdiction by such courts, and waive any jurisdictional, venue, or inconvenient forum objections to such courts.")?></p>
</li>
<li><strong><?=$t("DATA PROTECTION ACT (1998)")?></strong>
<p><?=$t("When a customer opens an Account to use the Platform or otherwise use this Site IBWT may ask the customer to provide us with personal information. As IBWT is governed by the Data Protection Act (1998) any personal information that a customer provides to IBWT through this Site shall be subject to our ")?><a href="/company/privacy">Privacy Policy.</a></p>
</li>
<li><strong><?=$t("MISCELLANEOUS")?></strong>
<p><?=$t("In case of a force majeure event as defined by applicable law, the liabilities of the affected party to these Terms will be suspended pending resolution of such event.")?></p>
<p><?=$t("If a competent judicial authority deems any provision of the Terms unenforceable, that provision will be enforced to the maximum extent permissible, and all remaining provisions will remain in full force and effect.")?></p>
</li>
<li><strong><?=$t("CONTACT US")?></strong>

<blockquote><?=$t("If a customer  has any questions relating to these Terms of Service contact us at:")?>
<address><strong>IBWT JD Ltd</strong><br>
<a href="https://<?=COMPANY_URL?>">https://<?=COMPANY_URL?>/</a><br>
31 North Down Crescent<br>
Keyham, Plymouth, Devon,<br>
PL2 2AR, UK<br>
<abbr title="Phone">P:</abbr> +44 7914 446125<br>
<abbr title="Email">E:</abbr> <a href="mailto:<?=MAIL_3?>"><?=MAIL_3?></a><br>
</address>
</blockquote>
</ol>
<small class="pull-right">Last updated on 30rd January, 2014</small>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</div>
</div>