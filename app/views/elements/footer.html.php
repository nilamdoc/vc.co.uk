<?php use lithium\core\Environment; 
if(substr(Environment::get('locale'),0,2)=="en"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<div id="footer" style="padding:1px 20px; margin-top:20px;border-top:1px solid gray;" class="navbar-inner navbar ">
	<ul class="nav" style="font-size:11px ">
		<li><a href="/<?=$locale?>/"><?=$t("Copyright ")?>&copy; IBWT JD LTD. <?=$t("All rights reserved.")?></a></li>
		<li><a href="/<?=$locale?>/company/contact"><?=$t("Contact")?></a></li>		
		<li><a href="/<?=$locale?>/company/aboutus"><?=$t("About")?></a></li>		
		<li><a href="/<?=$locale?>/company/riskmanagement"><?=$t("Risk")?></a></li>				
		<li><a href="/<?=$locale?>/company/verification"><?=$t("Verification")?></a></li>						
		<li><a href="/<?=$locale?>/company/privacy"><?=$t("Privacy")?></a></li>		
		<li><a href="/<?=$locale?>/company/termsofservice"><?=$t("Terms")?></a></li>				
		<li><a href="/<?=$locale?>/company/legal"><?=$t("Legal")?></a></li>		
		<li><a href="/<?=$locale?>/company/FAQ"><?=$t("FAQ")?></a></li>				
		<li><a href="/<?=$locale?>/company/funding"><?=$t("Funding")?></a></li>						
		<li><a href="/<?=$locale?>/news"><?=$t("News")?></a></li>						
		<li><a href="/<?=$locale?>/API"><?=$t("API")?></a></li>								
<!--		<li><a href="/<?=$locale?>/MAPI"><?=$t("Merchant API")?></a></li>										-->
		<li><a href="/<?=$locale?>/company/resources"><?=$t("Resources")?></a></li>								
	</ul>
	<p class="nav" style="font-size:11px;border-top:1px solid black ">
		<?=$t("IBWT is a trading name of ")?><strong>IBWT JD Ltd</strong>. <?=$t("Registered in England and Wales.")?> 
		<?=$t("Registered office: Plymouth, PL2 2AR. Company no: 8554667. 
		Registered VAT no: 165221136. 
		Registered Information Commissioner no: ZA007784.")?>
	</p>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-43128731-1', 'ibwt.co.uk');
  ga('send', 'pageview');
</script>