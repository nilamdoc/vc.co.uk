<div class="row" style="margin:auto ">
	<div class="span9">
	
		<div class="row">
			<div class="span9" id="EnterMobile">
				<h2>Mobile number</h2>
				<input type="text" name="Mobile" id="Mobile" class="input-large" placeholder="7980919282" style="font-size:36px;height:46px;width:250px;padding:10px ">
			</div>
			<div class="span9" style="display:none" id="EnterTOTP">
				<h2>Time based One Time Password <br>
			(TOTP) Smartphone</h2>
				<input type="password" name="TOTPPassword" id="TOTPPassword" class="input-large"  style="font-size:36px;height:46px;width:150px;padding:10px ">
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<input type="button" value="1" class="btn btn-primary span2" style="font-size:36px" onclick="addMobile('1')">
			</div>
			<div class="span3">
				<input type="button" value="2" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('2')">
			</div>
			<div class="span3">
				<input type="button" value="3" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('3')">
			</div>		
		</div>
		<div class="row">
			<div class="span9">&nbsp;</div>
		</div>
		<div class="row">
			<div class="span3">
				<input type="button" value="4" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('4')">
			</div>
			<div class="span3">
				<input type="button" value="5" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('5')">
			</div>
			<div class="span3">
				<input type="button" value="6" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('6')">
			</div>		
		</div>
		<div class="row">
			<div class="span9">&nbsp;</div>
		</div>
		<div class="row">
			<div class="span3">
				<input type="button" value="7" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('7')">
			</div>
			<div class="span3">
				<input type="button" value="8" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('8')">
			</div>
			<div class="span3">
				<input type="button" value="9" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('9')">
			</div>		
		</div>
		<div class="row">
			<div class="span9">&nbsp;</div>
		</div>
		<div class="row">
			<div class="span3">
				<input type="button" value="Del" class="btn btn-danger span2" style="font-size:36px " onclick="delMobile()">
			</div>
			<div class="span3">
				<input type="button" value="0" class="btn btn-primary span2" style="font-size:36px " onclick="addMobile('0')">
			</div>
			<div class="span3">
				<input type="button" value="Cancel" class="btn btn-warning span2" style="font-size:36px " onClick="CancelEvent();">			
			</div>		
		</div>
		<div class="row">
			<div class="span9">&nbsp;</div>
		</div>
		
		<div class="row" id="SubmitMobile">
			<div class="span9">
						<input type="button" value="Confirm Mobile" class="btn btn-success span7" style="font-size:36px " onClick="SubmitMobile();">
			</div>
		</div>
		<div class="row" id="SubmitTOTP" style="display:none ">
			<div class="span9">
						<input type="button" value="Confirm TOTP" class="btn btn-success span7" style="font-size:36px " onClick="SubmitTOTP();">
			</div>
		</div>
		<div class="row">
			<div class="span9">&nbsp;</div>
		</div>
			<div class="offset1 span6 alert" style="display:none" id="ErrorMsg">
				<h2>Error</h2>
			</div>
	</div>
</div>
<script>
function addMobile(val){
	if( $('#Mobile').is(':visible') ) { 
		$("#Mobile").val($("#Mobile").val()+val);
	}
	if( $('#TOTPPassword').is(':visible') ) { 
		$("#TOTPPassword").val($("#TOTPPassword").val()+val);
	}
	
	$("#ErrorMsg").hide();
}
function delMobile(){
	if( $('#Mobile').is(':visible') ) { 
		mobile = $("#Mobile").val();
		toget = mobile.length-1;
		mobile = mobile.substr(0,toget);
		$("#Mobile").val(mobile);
		$("#ErrorMsg").hide();
	}
	if( $('#TOTPPassword').is(':visible') ) { 
		TOTPPassword = $("#TOTPPassword").val();
		toget = TOTPPassword.length-1;
		TOTPPassword = TOTPPassword.substr(0,toget);
		$("#TOTPPassword").val(TOTPPassword);
		$("#ErrorMsg").hide();
	}
}
function SubmitMobile(){
	mobile = $("#Mobile").val();
	if(mobile==""){
		$("#ErrorMsg").show();	
		$("#ErrorMsg").html("<h2>Incorrect Mobile</h2>");
		return false;
	}
	$("#EnterMobile").hide();	
	$("#SubmitMobile").hide();		
	$("#EnterTOTP").show();	
	$("#SubmitTOTP").show();		
}
function SubmitTOTP(){
	TOTP = $("#TOTPPassword").val();
	Mobile = $("#Mobile").val();	
	if(TOTP==""){
		$("#ErrorMsg").show();	
		$("#ErrorMsg").html("<h2>Incorrect TOTP</h2>");
		return false;
	}
	$.getJSON('/ATM/CheckATM/'+Mobile+'/'+TOTP,
		function(ReturnValues){
				if(ReturnValues['TOTP']===true){
					window.location="/ATM/dashboard";
				}else{
					window.location="/ATM/index";
				}
		});

}
function CancelEvent(){
	if( $('#TOTPPassword').is(':visible') ) { 
		$("#TOTPPassword").val("");
		$("#EnterMobile").show();	
		$("#SubmitMobile").show();		
		$("#EnterTOTP").hide();	
		$("#SubmitTOTP").hide();		
	}
	if( $('#Mobile').is(':visible') ) { 
		$("#Mobile").val("");
	}
}
</script>
