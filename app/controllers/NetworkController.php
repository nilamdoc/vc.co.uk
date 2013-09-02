<?php
namespace app\controllers;
use app\extensions\action\Bitcoin;
use app\extensions\action\Functions;

class NetworkController extends \lithium\action\Controller {

	public function index(){
      $bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
  	  $getblockcount = $bitcoin->getblockcount();

	  $getconnectioncount = $bitcoin->getconnectioncount();
	  $getblockhash = $bitcoin->getblockhash($getblockcount);
	  $getblock = $bitcoin->getblock($getblockhash);
 		$title = "Network connectivity ";		
	  return compact('getblockcount','getconnectioncount','getblock','title');
	}
	public function blocks($blockcount = null){
	$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
	  if (!isset($blockcount)){
	  	  $blockcount = $bitcoin->getblockcount();
	  }else{
	  	$blockcount = intval($blockcount);
	  }
	  if($blockcount<10){$blockcount = 10;}
	  $getblock = array();
	  $getblockhash = array();
	  $j = 0;
	  for($i=$blockcount;$i>$blockcount-10;$i--){
		$getblockhash[$j] = $bitcoin->getblockhash($i);
		$getblock[$j] = $bitcoin->getblock($getblockhash[$j]);
		$j++;
	  }
  		$title = "Blocks: ". $blockcount;		
		return compact('getblock','blockcount','title');
	}
	public function blockhash($blockhash = null){
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$blockcount = $bitcoin->getblockcount();
	if (!isset($blockhash)){
		$blockhash = $bitcoin->getblockhash($blockcount);		
		$prevblock = $blockcount - 1;
		$prevblockhash = $bitcoin->getblockhash($prevblock);		
	}else{
		$getblock = $bitcoin->getblock($blockhash);
		$prevblock = $getblock['height'] - 1;
		$prevblockhash = $bitcoin->getblockhash($prevblock);		
		if($getblock['height']<>$blockcount ){
			$nextblock = $getblock['height'] + 1;
			$nextblockhash = $bitcoin->getblockhash($nextblock);		
		
		}
		
	}
	
		$getblock = $bitcoin->getblock($blockhash);
		$title = "Block hash: ". $blockhash;		
		return compact('getblock','prevblockhash','nextblockhash','prevblock','nextblock','title');
	}
	
	public function transactionhash($transactionhash = null){
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$getrawtransaction = $bitcoin->getrawtransaction($transactionhash);
		$decoderawtransaction = $bitcoin->decoderawtransaction($getrawtransaction);
		$listsinceblock = $bitcoin->listsinceblock($transactionhash);
		$title = "Transactions hash: ". $transactionhash;		
		return compact('decoderawtransaction','listsinceblock','title');
	}
	
	public function address($address = null){
		$function = new Functions();
		$transactions = $function->gettransactions($address);
		$addressfirstseen = $function->addressfirstseen($address);
		$addressbalance = $function->addressbalance($address);
		$title = "Transactions done by ". $address;
		return compact('transactions','address','addressfirstseen','addressbalance','title');
	}

	public function transactions(){
		$title = "Transactions";
		return compact('title');
	
	}
	
	public function peer(){
		$title = "Peer connection infomration";
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$getpeerinfo = $bitcoin->getpeerinfo();
		$getconnectioncount = $bitcoin->getconnectioncount();
		return compact('title','getpeerinfo','getconnectioncount');
	
	}
	
}
?>