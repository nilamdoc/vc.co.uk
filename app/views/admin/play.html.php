<script>
<?php 
foreach($details as $detail){
?>
var <?=$detail['username']?> = "<?=$detail['key']?>";
<?php }
?>
function DisableUser(username){
	$("#SecondUser option[value='IBWTUserA']").attr('disabled',false);
	$("#SecondUser option[value='IBWTUserB']").attr('disabled',false);	
	$("#SecondUser option[value='IBWTUserC']").attr('disabled',false);	
	$("#SecondUser option[value='IBWTUserD']").attr('disabled',false);
	$("#SecondUser option[value='"+username+"']").attr('disabled','disabled');
	$("#SecondUser option[value='"+username+"']").attr('selected',false);	
	$("#FirstUserForm").attr('action','/API/Trade/'+eval(username));
	$("#FirstUserName").val(username);	
}
function SelectSecondUser(username){
	$("#SecondUserForm").attr('action','/API/Trade/'+eval(username));
	$("#SecondUserName").val(username);		
}
function TypeSelect(type){
	if(type=="Sell"){
		$("#typeSecond option[value='Buy']").attr("selected","selected");
		$("#FirstUserType option[value='Sell']").attr("selected","selected");		
		$("#SecondUserType option[value='Buy']").attr("selected","selected");				
	}else{
		$("#typeSecond option[value='Sell']").attr("selected","selected");
		$("#FirstUserType option[value='Buy']").attr("selected","selected");		
		$("#SecondUserType option[value='Sell']").attr("selected","selected");				
	}
}
function SelectPair(pair){
	$("#FirstUserPair").val(pair);		
	$("#SecondUserPair").val(pair);			
}
</script>
<div class="row">
<div class="span5">
	<form action="/API/Trade/<?=$detail['key']?>" method="post" target="_blank">
	<input type="hidden" name="nounce" value="<?=time()?>"><br>
	<select name="FirstUser" id="FirstUser" onChange="DisableUser(this.value);">
	<option value="">--Select User --</option>
<?php
foreach($details as $detail){
?>
		<option value="<?=$detail['username']?>"><?=$detail['username']?></option>
<?php }?>
	</select><br>
	Type: <select name="typeFirst" id="typeFirst" class="span2" onChange="TypeSelect(this.value)">
	<option value="">--Select--</option>
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
	</select><br>
	
	Pair: <select name="Mainpair" class="span2" id="MainPair" onChange="SelectPair(this.value)">
	<?php foreach($trades as $trade){
		$FC = substr($trade['trade'],0,3);
		$SC = substr($trade['trade'],4,3);
	?>
		<option value="<?=$FC?>_<?=$SC?>"><?=$FC?>_<?=$SC?></option>
	<?php }?>
	</select><br>
	
	
	</form>
</div>
<div class="span5">
<form action="/API/Trade/<?=$detail['key']?>" method="post" target="_blank">
	<input type="hidden" name="nounce" value="<?=time()?>"><br>
	<select name="SecondUser" id="SecondUser" onChange="SelectSecondUser(this.value)">
	<option value="">--Select User --</option>	
<?php
foreach($details as $detail){
?>
<option value="<?=$detail['username']?>"><?=$detail['username']?></option>
<?php }?>
	</select><br>
	Type: <select name="typeSecond" id="typeSecond" class="span2">
	<option value="">--Select--</option>	
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
	</select><br>
	
	</form>
</div>
<div class="span5" style="border:1px solid black;padding:5px ">
	<form action="/API/Trade/<?=$detail['key']?>" method="post" target="_blank" id="FirstUserForm" name="FirstUserForm">
	<input type="hidden" name="nounce" value="<?=time()?>"><br>
	Username: <input type="text" name="FirstUserName" id="FirstUserName" disabled="disabled"><br>
	Type: <select name="type" class="span2" id="FirstUserType">
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
	</select><br>
	Pair: <input type="text" name="pair" id="FirstUserPair" disabled="disabled"><br>


	Amount: <input type="text" value="" placeholder="1.0" min="0.000001" max="9999" name="amount" id="FirstUseramountBTC" class="span2" value="0.1"><br>
	Price: <input type="text" value="" placeholder="100.0" min="1" max="99999" name="price" id="FirstUserPerPriceBTC" class="span2" ><br>
	</form>
</div>
<div class="span5" style="border:1px solid black;padding:5px ">
	<form action="/API/Trade/<?=$detail['key']?>" method="post" target="_blank" id="FirstUserForm" name="SecondUserForm">
	<input type="hidden" name="nounce" value="<?=time()?>"><br>
	Username: <input type="text" name="SecondUserName" id="SecondUserName" disabled="disabled"><br>
	Type: <select name="type" class="span2" id="SecondUserType">
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
	</select><br>
	Pair: <input type="text" name="pair" id="SecondUserPair" disabled="disabled"><br>


	Amount: <input type="text" value="" placeholder="1.0" min="0.000001" max="9999" name="amount" id="SecondUseramountBTC" class="span2" value="0.1"><br>
	Price: <input type="text" value="" placeholder="100.0" min="1" max="99999" name="price" id="SecondUserPerPriceBTC" class="span2" ><br>
	</form>
</div>

</div>