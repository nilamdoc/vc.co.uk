// JS Document
function UpdateDetails(){
	GetDetails();
	setInterval(function() {
		GetDetails();
	},20000);
}
function GetDetails(){
	$.getJSON('/Updates/Rates/',
		function(ReturnValues){
			$("#LowPrice").html(ReturnValues['Low']);
			$("#HighPrice").html(ReturnValues['High']);					
			$("#LastPrice").html(ReturnValues['Last']);
			var Volume = ReturnValues['VolumeBTC'] + " BTC / " + ReturnValues['VolumeOther'] + " " + ReturnValues['VolumeOtherUnit'];
			$("#Volume").html(Volume);					
		}
	);
}
function BuyFormCalculate (){
	BalanceSecond = $('#BalanceSecond').html();
	FirstCurrency = $('#BuyFirstCurrency').val();
	SecondCurrency = $('#BuySecondCurrency').val();
	BuyAmount = $('#BuyAmount').val();
	BuyPriceper = $('#BuyPriceper').val();

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
}
function BuyOrderFill(BuyOrderPrice,BuyOrderAmount){
	$("#SellAmount").val(BuyOrderAmount)  ;
	$("#SellPriceper").val(BuyOrderPrice)  ;
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