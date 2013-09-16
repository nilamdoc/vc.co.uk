<?php 
namespace app\extensions\command;

use app\models\Transactions;
use app\models\Details;
use app\models\Parameters;

use app\extensions\action\Bitcoin;

class Walletnotify extends \lithium\console\Command {
    public function index($s=null) {
			$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
			$paytxfee = Parameters::find('first');
			$txfee = $paytxfee['paytxfee'];

		$getrawtransaction = $bitcoin->getrawtransaction($s);
		$decoderawtransaction = $bitcoin->decoderawtransaction($getrawtransaction);		

			foreach($decoderawtransaction['vout'] as $out){
				foreach($out['scriptPubKey']['addresses'] as $address){
					$Amount = (float)$out['value'];
					if($bitcoin->getaccount($address)!=""){
						$details = Details::find('first',
							array(
									'conditions'=>array('bitcoinaddress'=>$address)
								));
						$data = array(
							'DateTime' => new \MongoDate(),
							'TransactionHash' => $s,
							'username' => $details['username'],
							'address'=>$address,
							'Amount'=> $Amount - (float)$txfee,
							'Added'=>false
						);
						$Transactions = Transactions::find('first',array(
							'conditions'=>array('TransactionHash' => $s)
						));
						if($Transactions['_id']==""){
							$t = Transactions::create();
							$Amount = $Amount - (float)$txfee;
							$comment = "User: ".$details['username']."; Address: ".$address."; Amount:".$Amount.";";
							$transfer = $bitcoin->sendfrom($details['username'], BITCOIN_ADDRESS, (float)$Amount,(int)0,$comment);

							if(isset($transfer['error'])){
								$error = $transfer['error']; 
							}else{
								$error = $transfer;
							}
							
							$data = array(
								'DateTime' => new \MongoDate(),
								'TransactionHash' => $s,
								'username' => $details['username'],
								'address'=>$address,							
								'Amount'=> $Amount - (float)$txfee,
								'Added'=>true,
								'Transfer'=>$error,
							);							
							$t->save($data);
							
						$dataDetails = array(
								'balance.BTC' => (float)$details['balance.BTC'] + $Amount - (float)$txfee,
							);
						
							$details = Details::find('all',
								array(
										'conditions'=>array('bitcoinaddress'=>$address)
									))->save($dataDetails);

						}else{
							$Transactions = Transactions::find('first',array(
								'conditions'=>array('TransactionHash' => $s)
							))->save($data);
						}
					}
				}
			}
		}
} 
?>