// JS Document
function UpdateDetails(ex){
	var delay = 5000;
	var now, before = new Date();
	GetDetails(ex);
	setInterval(function() {
    now = new Date();
    var elapsedTime = (now.getTime() - before.getTime());
    GetDetails(ex);
    before = new Date();    
}, 5000);
	
}
function GetDetails(ex){
	user_id = $("#User_ID").html();
	if(ex=="/EX/DASHBOARD"){ex = "BTC/GBP";}
	$.getJSON('/Updates/Rates/'+ex,
		function(ReturnValues){
			if(ReturnValues['Refresh']=="Yes"){
					$.getJSON('/Updates/Orders/'+ex,
						function(Orders){
							$('#BuyOrders').html(Orders['BuyOrdersHTML']);
							$('#SellOrders').html(Orders['SellOrdersHTML']);							
					});
					$.getJSON('/Updates/YourOrders/'+ex+'/'+user_id,
						function(Orders){
							$('#YourCompleteOrders').html(Orders['YourCompleteOrdersHTML']);
							$('#YourOrders').html(Orders['YourOrdersHTML']);							
					});
			}
			
			$("#LowPrice").html(ReturnValues['Low']);
			$("#HighPrice").html(ReturnValues['High']);					
			$("#LowestAskPrice").html(ReturnValues['High']);	
			if($("#BuyPriceper").val()=="" || $("#BuyPriceper").val()==0){
				$("#BuyPriceper").val(ReturnValues['High']);
			}
			$("#HighestBidPrice").html(ReturnValues['Low']);
			if($("#SellPriceper").val()=="" || $("#SellPriceper").val()==0){
				$("#SellPriceper").val(ReturnValues['Low']);
			}
			$("#LastPrice").html(ReturnValues['Last']);
			Volume = ReturnValues['VolumeFirst'] + " " + ReturnValues['VolumeFirstUnit'] +
			" / " + ReturnValues['VolumeSecond'] + " " + ReturnValues['VolumeSecondUnit'];
			$("#Volume").html(Volume);					
		});
}
function BuyFormCalculate (){
	BalanceSecond = $('#BalanceSecond').html();
	FirstCurrency = $('#BuyFirstCurrency').val();
	SecondCurrency = $('#BuySecondCurrency').val();
	BuyAmount = $('#BuyAmount').val();
	BuyPriceper = $('#BuyPriceper').val();
	if(BuyAmount=="" || BuyAmount==0){return false;}
	if(BuyPriceper=="" || BuyPriceper==0){return false;}
	TotalValue = BuyAmount * BuyPriceper;
	TotalValue = TotalValue.toFixed(6);
	$("#BuyTotal").html(TotalValue);
	
	$.getJSON('/Updates/Commission/',
		function(ReturnValues){
			$("#BuyCommission").val(ReturnValues['Commission']);			
			Commission = $('#BuyCommission').val();
			Fees = BuyAmount * Commission / 100;
			Fees = Fees.toFixed(5);
			$("#BuyFee").html(Fees);	
			$('#BuyCommissionAmount').val(Fees);
			$('#BuyCommissionCurrency').val(FirstCurrency);			
		}
	);
	GrandTotal = TotalValue;
	if(GrandTotal==0){
		BuySummary = "Amount cannot be Zero";
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning");
		return false;
	}
	if(parseFloat(BalanceSecond) <= parseFloat(GrandTotal)){
		Excess = parseFloat(GrandTotal) - parseFloat(BalanceSecond);
		Excess = Excess.toFixed(5)		
		BuySummary = "The transaction amount exceeds the balance by " + Excess + " " + SecondCurrency;
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning");
	}else{
		BuySummary = "The transaction amount " + GrandTotal  + " " + SecondCurrency;
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").removeAttr('disabled');
		$("#BuySubmitButton").attr("class", "btn btn-success");		
	}
	if(parseFloat(GrandTotal)===0){$("#BuySubmitButton").attr("disabled", "disabled");}
}
function SellFormCalculate (){
	BalanceFirst = $('#BalanceFirst').html();
	FirstCurrency = $('#SellFirstCurrency').val();
	SecondCurrency = $('#SellSecondCurrency').val();
	SellAmount = $('#SellAmount').val();
	SellPriceper = $('#SellPriceper').val();
if(SellAmount=="" || SellAmount==0){return false;}
if(SellPriceper=="" || SellPriceper==0){return false;}

	TotalValue = SellAmount * SellPriceper;
	TotalValue = TotalValue.toFixed(6);
	$("#SellTotal").html(TotalValue);
	
	$.getJSON('/Updates/Commission/',
		function(ReturnValues){
			$("#SellCommission").val(ReturnValues['Commission']);			
			Commission = $('#SellCommission').val();;	
			Fees = TotalValue * Commission / 100;
			Fees = Fees.toFixed(5);
			$("#SellFee").html(Fees);	
			$('#SellCommissionAmount').val(Fees);
			$('#SellCommissionCurrency').val(SecondCurrency);						
		}
	);

	GrandTotal = SellAmount;
	if(SellAmount==0){
	SellSummary = "Amount cannot be Zero";
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning");		
		return false;
	}

	if(parseFloat(BalanceFirst) < parseFloat(GrandTotal)){
		Excess =  parseFloat(GrandTotal) - parseFloat(BalanceFirst)  ;
		Excess = Excess.toFixed(5)
		SellSummary = "The transaction amount exceeds the balance by " + Excess + " " + FirstCurrency;
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning");				
	}else{
		SellSummary = "The transaction amount " + GrandTotal  + " " + FirstCurrency;
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").removeAttr('disabled');
		$("#SellSubmitButton").attr("class", "btn btn-success");				
	}
	if(parseFloat(GrandTotal)===0){$("#SellSubmitButton").attr("disabled", "disabled");}
}
function SellOrderFill(SellOrderPrice,SellOrderAmount){
	$("#BuyAmount").val(SellOrderAmount)  ;
	$("#BuyPriceper").val(SellOrderPrice)  ;
	$("#BuySubmitButton").attr("disabled", "disabled");	
	$("#BuySubmitButton").attr("class", "btn btn-warning");				
}
function BuyOrderFill(BuyOrderPrice,BuyOrderAmount){
	$("#SellAmount").val(BuyOrderAmount)  ;
	$("#SellPriceper").val(BuyOrderPrice)  ;
	$("#SellSubmitButton").attr("disabled", "disabled");	
	$("#SellSubmitButton").attr("class", "btn btn-warning");					
}
function ConvertBalance(){
	BTCRate = $("#BTCRate").val();
	LTCRate = $("#LTCRate").val();	
	USDRate = $("#USDRate").val();	
	GBPRate = $("#GBPRate").val();	
	EURRate = $("#EURRate").val();	
	Currency = $("#Currency" ).val();		
	switch(Currency){
		case "BTC":
		  break;
		case "LTC":
		  break;
		case "USD":
		  break;
		case "EUR":
		  break;
		case "GBP":
		  break;
	}
	
}
function SendPassword(){
	$.getJSON('/Users/SendPassword/'+$("#Username").val(),
		function(ReturnValues){
			$("#LoginEmailPassword").show();
			if(ReturnValues['TOTP']=="Yes"){
				$("#TOTPPassword").show();
				}
			}
	);
}

function SaveTOTP(){
	if($("#ScannedCode").val()==""){return false;}
	$.getJSON('/Users/SaveTOTP/',{
			  Login:$("#Login").is(':checked'),
			  Withdrawal:$("#Withdrawal").is(':checked'),			  
			  Security:$("#Security").is(':checked'),
			  ScannedCode:$("#ScannedCode").val()
			  },
		function(ReturnValues){
			if(ReturnValues){
				window.location.assign("/users/settings");				
			}			
		}
	);
}
function CheckTOTP(){
	if($("#CheckCode").val()==""){return false;}
	$.getJSON('/Users/CheckTOTP/',{
			  CheckCode:$("#CheckCode").val()
			  },
		function(ReturnValues){
			if(ReturnValues){
				window.location.assign("/users/settings");		
			}
		}
	);
}


function DeleteTOTP(){
	$.getJSON('/Users/DeleteTOTP/',
		function(ReturnValues){}
	);	
}
function CheckPayment(){
	address = $("#bitcoinaddress").val();
	if(address==""){return false;}
	amount = $("#Amount").val();
	if(amount==""){return false;}
	maxValue = $("#maxValue").val();
	if(parseFloat(amount)>parseFloat(maxValue)){return false;}
	
	$("#SendFees").html($("#txFee").val());

	$("#SendAmount").html(amount);	
	$("#SendTotal").html(parseFloat(amount)-parseFloat($("#txFee").val()));	
	$("#TransferAmount").val(parseFloat(amount)-parseFloat($("#txFee").val()));

	$.getJSON('/Updates/Address/'+address,
		function(ReturnValues){
			if(ReturnValues['verify']['isvalid']==true){
			address = "<a href='http://blockchain.info/address/"+ address +"' target='_blank'>"+ address +"</a> <i class='icon-ok'></i>";
			$("#SendAddress").html(address); 	
			$("#SendSuccessButton").removeAttr('disabled');				
				}
		});
	return true;
	}
	
function BitCoinAddress(){
	address = $("#bitcoinaddress").val();
  $("#SendAddress").html(address); 	
	SuccessButtonDisable();
	}
function SuccessButtonDisable(){
	$("#SendSuccessButton").attr("disabled", "disabled");
	}
function CheckDeposit(){
	AmountFiat = $("#AmountFiat").val();
	if(AmountFiat==""){return false;}
	}
function CheckWithdrawal(){
	
	if($("#WithdrawalMethod").val()=="bank"){
		AccountName = $("#AccountName").val();		
		if(AccountName==""){return false;}
		SortCode = $("#SortCode").val();
		if(SortCode==""){return false;}
		AccountNumber = $("#AccountNumber").val();
		if(AccountNumber==""){return false;}
	}
	if($("#WithdrawalMethod").val()=="post"){
		PostalName = $("#PostalName").val();
		if(PostalName==""){return false;}		
		PostalStreet = $("#PostalStreet").val();
		if(PostalStreet==""){return false;}		
		PostalAddress = $("#PostalAddress").val();
		if(PostalAddress==""){return false;}		
		PostalCity = $("#PostalCity").val();
		if(PostalCity==""){return false;}		
		PostalZip = $("#PostalZip").val();
		if(PostalZip==""){return false;}		
		PostalCountry = $("#PostalCountry").val();
		if(PostalCountry==""){return false;}		
	}
	WithdrawAmountFiat = $("#WithdrawAmountFiat").val();
	if(WithdrawAmountFiat==""){return false;}
	if(parseInt(WithdrawAmountFiat)<=5){return false;}
	}
function RejectReason(value){
	url = $("#RejectURL").attr('href');
	len = url.length-2;
	nurl = url.substr(0,len)+value;
	$("#RejectURL").attr('href',nurl);
}
function litecoinAddress(){
	address = $("#litecoinaddress").val();
  $("#SendLTCAddress").html(address); 	
	SuccessLTCButtonDisable();
	}
function SuccessLTCButtonDisable(){
	$("#SendLTCSuccessButton").attr("disabled", "disabled");
	}
function CheckLTCPayment(){
	address = $("#litecoinaddress").val();
	if(address==""){return false;}
	amount = $("#Amount").val();
	if(amount==""){return false;}
	maxValue = $("#maxValue").val();
	if(parseFloat(amount)>parseFloat(maxValue)){return false;}
	
	$("#SendLTCFees").html($("#txFee").val());

	$("#SendLTCAmount").html(amount);	
	$("#SendLTCTotal").html(parseFloat(amount)-parseFloat($("#txFee").val()));	
	$("#TransferAmount").val(parseFloat(amount)-parseFloat($("#txFee").val()));

	$.getJSON('/Updates/LTCAddress/'+address,
		function(ReturnValues){
			if(ReturnValues['verify']['isvalid']==true){
			address = "<a href='http://ltc.block-explorer.com/address/"+ address +"' target='_blank'>"+ address +"</a> <i class='icon-ok'></i>";
			$("#SendLTCAddress").html(address); 	
			$("#SendLTCSuccessButton").removeAttr('disabled');				
				}
		});
	return true;
	}
function PaymentMethod(value){
	if(value=="bank"){
		$("#WithdrawalBank").show();
		$("#WithdrawalPost").hide();
	}
	if(value=="post"){
		$("#WithdrawalBank").hide();
		$("#WithdrawalPost").show();
	}
	
	}