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
function ChangePrice(price){
 $("#FirstUserPerPriceBTC").val(price);
 $("#SecondUserPerPriceBTC").val(price); 
}
function ChangeAmount(amount){
	$("#FirstUseramountBTC").val(amount);
	$("#SecondUseramountBTC").val(amount);
}
function SubmitTrade(){
	document.FirstUserForm.submit();
	document.SecondUserForm.submit();		
	return false;
}

</script>
<div class="row">
	<div class="span5">
		<form action="/API/Trade/SOMEKEY" method="post" target="_blank">
		<input type="hidden" name="nounce" value="<?=time()?>"><br>
		First User:
		<select name="FirstUser" id="FirstUser" onChange="DisableUser(this.value);">
		<option value="">--Select User --</option>
	<?php
	foreach($details as $detail){
	?>
			<option value="<?=$detail['username']?>"><?=$detail['username']?></option>
	<?php }?>
		</select><br>
		Second User:
	<select name="SecondUser" id="SecondUser" onChange="SelectSecondUser(this.value)">
		<option value="">--Select User --</option>	
	<?php
	foreach($details as $detail){
	?>
	<option value="<?=$detail['username']?>"><?=$detail['username']?></option>
	<?php }?>
		</select><br>
		
		First User Type: <select name="typeFirst" id="typeFirst" class="span2" onChange="TypeSelect(this.value)">
		<option value="">--Select--</option>
		<option value="Buy">Buy</option>
		<option value="Sell">Sell</option>								
		</select><br>
		Second User Type: <select name="typeSecond" id="typeSecond" class="span2">
		<option value="">--Select--</option>	
		<option value="Buy">Buy</option>
		<option value="Sell">Sell</option>								
		</select><br>
		
		Pair: <select name="Mainpair" class="span2" id="MainPair" onChange="SelectPair(this.value)">
		<option value="">--Select--</option>
		<?php foreach($trades as $trade){
			$FC = substr($trade['trade'],0,3);
			$SC = substr($trade['trade'],4,3);
		?>
			<option value="<?=$FC?>_<?=$SC?>"><?=$FC?>_<?=$SC?></option>
		<?php }?>
		</select><br>
		Amount: <input type="text" name="amount" id="UseramountBTC" class="span2" onBlur="ChangeAmount(this.value)"><br>
		Price: <input type="text" name="price" id="UserPerPriceBTC" class="span2"  onBlur="ChangePrice(this.value)"><br>
		<input type="submit" value="Submit Trade" onclick="SubmitTrade()">
		</form>
	</div>
</div>
<div class="row">
	<div class="span5" style="border:1px solid black;padding:5px ">
		<form action="/API/Trade/SOMEKEY" method="post" target="_blank" id="FirstUserForm" name="FirstUserForm">
		<input type="hidden" name="nounce" value="<?=time()?>"><br>
		Username: <input type="text" name="FirstUserName" id="FirstUserName" disabled="disabled"><br>
		Type: <select name="type" class="span2" id="FirstUserType" disabled="disabled">
		<option value="Buy">Buy</option>
		<option value="Sell">Sell</option>								
		</select><br>
		Pair: <input type="text" name="pair" id="FirstUserPair" disabled="disabled"><br>
		Amount: <input type="text" name="amount" id="FirstUseramountBTC" class="span2"  disabled="disabled"><br>
		Price: <input type="text" name="price" id="FirstUserPerPriceBTC" class="span2"  disabled="disabled"><br>
		</form>
	</div>
	<div class="span5" style="border:1px solid black;padding:5px ">
		<form action="/API/Trade/SOMEKEY" method="post" target="_blank" id="FirstUserForm" name="SecondUserForm">
		<input type="hidden" name="nounce" value="<?=time()?>"><br>
		Username: <input type="text" name="SecondUserName" id="SecondUserName" disabled="disabled"><br>
		Type: <select name="type" class="span2" id="SecondUserType"  disabled="disabled">
		<option value="Buy">Buy</option>
		<option value="Sell">Sell</option>								
		</select><br>
		Pair: <input type="text" name="pair" id="SecondUserPair" disabled="disabled"><br>
		Amount: <input type="text" name="amount" id="SecondUseramountBTC" class="span2"  disabled="disabled"><br>
		Price: <input type="text" name="price" id="SecondUserPerPriceBTC" class="span2"  disabled="disabled"><br>
		</form>
	</div>

</div>