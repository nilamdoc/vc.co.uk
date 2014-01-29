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
			$txfee = $paytxfee['payltctxfee'];

		$getrawtransaction = $litecoin->getrawtransaction($s);
		$decoderawtransaction = $litecoin->decoderawtransaction($getrawtransaction);		

			foreach($decoderawtransaction['vout'] as $out){
				foreach($out['scriptPubKey']['addresses'] as $address){
				
					$username = $litecoin->getaccount($address);
				
					$Amount = (float)$out['value'];
					if($litecoin->getaccount($address)!=""){
						$Transactions = Transactions::find('first',array(
							'conditions'=>array('TransactionHash' => $s)
						));
						if($Transactions['_id']==""){
							$t = Transactions::create();
							$Amount = $Amount;
							$comment = "Move from User: ".$username."; Address: ".$address."; Amount:".$Amount.";";
							$transfer = $litecoin->move($username, "NilamDoctor", (float)$Amount,(int)0,$comment);

							if(isset($transfer['error'])){
								$error = $transfer['error']; 
							}else{
								$error = $transfer;
							}
						$data = array(
							'DateTime' => new \MongoDate(),
							'TransactionHash' => $s,
							'username' => $username,
							'address'=>$address,							
							'Currency'=>'LTC',							
							'Amount'=> $Amount,
							'Added'=>true,
							'Transfer'=>$comment,
						);							
						$t->save($data);
		
						$details = Details::find('first',
							array('conditions'=>array('username'=> (string) $username))
						);

									
						$dataDetails = array(
								'balance.LTC' => (float)((float)$details['balance.LTC'] + (float)$Amount),
							);
						
							$details = Details::find('all',
								array(
										'conditions'=>array('username'=>(string)$username)
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