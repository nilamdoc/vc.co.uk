<?php 
namespace app\extensions\command;

use app\models\Transactions;
use app\models\Details;
use app\models\Parameters;


use app\extensions\action\Litecoin;

class Walletltcnotify extends \lithium\console\Command {
    public function index($s=null) {
			$litecoin = new Litecoin('http://'.LITECOIN_WALLET_SERVER.':'.LITECOIN_WALLET_PORT,LITECOIN_WALLET_USERNAME,LITECOIN_WALLET_PASSWORD);
			$paytxfee = Parameters::find('first');
			$txfee = $paytxfee['paytxfee'];

		$getrawtransaction = $litecoin->getrawtransaction($s);
		$decoderawtransaction = $litecoin->decoderawtransaction($getrawtransaction);		

			foreach($decoderawtransaction['vout'] as $out){
				foreach($out['scriptPubKey']['addresses'] as $address){
					$Amount = (float)$out['value'];
					if($litecoin->getaccount($address)!=""){
						$details = Details::find('first',
							array(
									'conditions'=>array('username'=>$litecoin->getaccount($address))
								));
						$data = array(
							'DateTime' => new \MongoDate(),
							'TransactionHash' => $s,
							'username' => $details['username'],
							'address'=>$address,
							'Currency'=>'LTC',
							'Amount'=> $Amount,
							'Added'=>false
						);
						$Transactions = Transactions::find('first',array(
							'conditions'=>array('TransactionHash' => $s)
						));
						if($Transactions['_id']==""){
							$t = Transactions::create();
							$Amount = $Amount - (float)$txfee;
							$comment = "Move from User: ".$details['username']."; Address: ".$address."; Amount:".$Amount.";";
							$transfer = $litecoin->move($details['username'], "NilamDoctor", (float)$Amount,(int)0,$comment);

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
							'Currency'=>'LTC',							
							'Amount'=> $Amount,
							'Added'=>true,
							'Transfer'=>$error,
						);							
						$t->save($data);
							
						$dataDetails = array(
								'balance.LTC' => (float)$details['balance.LTC'] + $Amount,
							);
						
							$details = Details::find('all',
								array(
										'conditions'=>array('username'=>$litecoin->getaccount($address))
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