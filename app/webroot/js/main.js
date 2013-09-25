// JS Document
function UpdateDetails(ex){
	GetDetails(ex);
	setInterval(function() {
		GetDetails(ex);
	},20000);
}
function GetDetails(ex){
	$.getJSON('/Updates/Rates/'+ex,
		function(ReturnValues){
			if(ReturnValues['Refresh']=="Yes"){
				window.location.assign(ReturnValues['URL']);								
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
			var Volume = ReturnValues['VolumeFirst'] + " " + ReturnValues['VolumeFirstUnit'] +
			" / " + ReturnValues['VolumeSecond'] + " " + ReturnValues['VolumeSecondUnit'];
			$("#Volume").html(Volume);					
		}
	);
}
function BuyFormCalculate (){
var	BalanceSecond = $('#BalanceSecond').html();
var	FirstCurrency = $('#BuyFirstCurrency').val();
var	SecondCurrency = $('#BuySecondCurrency').val();
var	BuyAmount = $('#BuyAmount').val();
var	BuyPriceper = $('#BuyPriceper').val();
	if(BuyAmount=="" || BuyAmount==0){return false;}
	if(BuyPriceper=="" || BuyPriceper==0){return false;}
var	TotalValue = BuyAmount * BuyPriceper;
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
var	GrandTotal = TotalValue;
	if(GrandTotal==0){
		BuySummary = "Amount cannot be Zero";
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning");
		return false;
	}
	if(parseFloat(BalanceSecond) <= parseFloat(GrandTotal)){
var		Excess = parseFloat(GrandTotal) - parseFloat(BalanceSecond);
		Excess = Excess.toFixed(5)		
var		BuySummary = "The transaction amount exceeds the balance by " + Excess + " " + SecondCurrency;
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").attr("disabled", "disabled");
		$("#BuySubmitButton").attr("class", "btn btn-warning");
	}else{
var		BuySummary = "The transaction amount " + GrandTotal  + " " + SecondCurrency;
		$("#BuySummary").html(BuySummary);
		$("#BuySubmitButton").removeAttr('disabled');
		$("#BuySubmitButton").attr("class", "btn btn-success");		
	}
	if(parseFloat(GrandTotal)===0){$("#BuySubmitButton").attr("disabled", "disabled");}
}
function SellFormCalculate (){
var	BalanceFirst = $('#BalanceFirst').html();
var	FirstCurrency = $('#SellFirstCurrency').val();
var	SecondCurrency = $('#SellSecondCurrency').val();
var	SellAmount = $('#SellAmount').val();
var	SellPriceper = $('#SellPriceper').val();
if(SellAmount=="" || SellAmount==0){return false;}
if(SellPriceper=="" || SellPriceper==0){return false;}

var	TotalValue = SellAmount * SellPriceper;
	TotalValue = TotalValue.toFixed(6);
	$("#SellTotal").html(TotalValue);
	
	$.getJSON('/Updates/Commission/',
		function(ReturnValues){
			$("#SellCommission").val(ReturnValues['Commission']);			
			Commission = $('#SellCommission').val();;	
var			Fees = TotalValue * Commission / 100;
			Fees = Fees.toFixed(5);
			$("#SellFee").html(Fees);	
			$('#SellCommissionAmount').val(Fees);
			$('#SellCommissionCurrency').val(SecondCurrency);						
		}
	);

var	GrandTotal = SellAmount;
	if(SellAmount==0){
var		SellSummary = "Amount cannot be Zero";
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning");		
		return false;
	}

	if(parseFloat(BalanceFirst) < parseFloat(GrandTotal)){
var		Excess =  parseFloat(GrandTotal) - parseFloat(BalanceFirst)  ;
		Excess = Excess.toFixed(5)
var		SellSummary = "The transaction amount exceeds the balance by " + Excess + " " + FirstCurrency;
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").attr("disabled", "disabled");
		$("#SellSubmitButton").attr("class", "btn btn-warning");				
	}else{
var		SellSummary = "The transaction amount " + GrandTotal  + " " + FirstCurrency;
		$("#SellSummary").html(SellSummary);
		$("#SellSubmitButton").removeAttr('disabled');
		$("#SellSubmitButton").attr("class", "btn btn-success");				
	}
	if(parseFloat(GrandTotal)===0){$("#SellSubmitButton").attr("disabled", "disabled");}
}
function SellOrderFill(SellOrderPrice,SellOrderAmount){
	$("#BuyAmount").val(SellOrderAmount)  ;
	$("#BuyPriceper").val(SellOrderPrice)  ;
}
function BuyOrderFill(BuyOrderPrice,BuyOrderAmount){
	$("#SellAmount").val(BuyOrderAmount)  ;
	$("#SellPriceper").val(BuyOrderPrice)  ;
}
function ConvertBalance(){
var	BTCRate = $("#BTCRate").val();
var	LTCRate = $("#LTCRate").val();	
var	USDRate = $("#USDRate").val();	
var	GBPRate = $("#GBPRate").val();	
var	EURRate = $("#EURRate").val();	
var	Currency = $("#Currency" ).val();		
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
var	address = $("#bitcoinaddress").val();
	if(address==""){return false;}
var	amount = $("#Amount").val();
	if(amount==""){return false;}
var	maxValue = $("#maxValue").val();
	if(amount>=maxValue){return false;}
	
	$("#SendFees").html($("#txFee").val());
	$("#SendAmount").html(amount);	
	$("#SendTotal").html(parseFloat(amount)+parseFloat($("#txFee").val()));	


	$.getJSON('/Updates/Address/'+address,
		function(ReturnValues){
			if(ReturnValues['verify']['isvalid']==true){
var			address = "<a href='http://blockchain.info/address/"+ address +"' target='_blank'>"+ address +"</a> <i class='icon-ok'></i>";
			$("#SendAddress").html(address); 	
			$("#SendSuccessButton").removeAttr('disabled');				
				}
		});
	return true;
	}
	
function BitCoinAddress(){
var	address = $("#bitcoinaddress").val();
  $("#SendAddress").html(address); 	
	SuccessButtonDisable();
	}
function SuccessButtonDisable(){
	$("#SendSuccessButton").attr("disabled", "disabled");
	}
function CheckDeposit(){
var	AmountFiat = $("#AmountFiat").val();
	if(AmountFiat==""){return false;}
	}
function CheckWithdrawal(){
var	AccountName = $("#AccountName").val();
	if(AccountName==""){return false;}
var	SortCode = $("#SortCode").val();
	if(SortCode==""){return false;}
var	AccountNumber = $("#AccountNumber").val();
	if(AccountNumber==""){return false;}
var	WithdrawAmountFiat = $("#WithdrawAmountFiat").val();
	if(WithdrawAmountFiat==""){return false;}
	if(parseInt(WithdrawAmountFiat)<=5){return false;}
	}
function RejectReason(value){
var	url = $("#RejectURL").attr('href');
	len = url.length-2;
var	nurl = url.substr(0,len)+value;
	$("#RejectURL").attr('href',nurl);
	}