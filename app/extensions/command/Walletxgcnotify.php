<?php 
namespace app\extensions\command;

use app\models\Transactions;
use app\models\Details;
use app\models\Parameters;


use app\extensions\action\Greencoin;

class Walletxgcnotify extends \lithium\console\Command {
    public function index($s=null) {
			$greencoin = new Greencoin('http://'.GREENCOIN_WALLET_SERVER.':'.GREENCOIN_WALLET_PORT,GREENCOIN_WALLET_USERNAME,GREENCOIN_WALLET_PASSWORD);
			$paytxfee = Parameters::find('first');
			$txfee = $paytxfee['payxgctxfee'];

		$getrawtransaction = $greencoin->getrawtransaction($s);
		$decoderawtransaction = $greencoin->decoderawtransaction($getrawtransaction);		

			foreach($decoderawtransaction['vout'] as $out){
				foreach($out['scriptPubKey']['addresses'] as $address){
				
					$username = $greencoin->getaccount($address);
				
					$Amount = (float)$out['value'];
					if($greencoin->getaccount($address)!=""){
						$Transactions = Transactions::find('first',array(
							'conditions'=>array('TransactionHash' => $s)
						));
						if($Transactions['_id']==""){
							$t = Transactions::create();
							$Amount = $Amount;
							$comment = "Move from User: ".$username."; Address: ".$address."; Amount:".$Amount.";";
							$transfer = $greencoin->move($username, "NilamDoctor", (float)$Amount,(int)0,$comment);

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
							'Currency'=>'XGC',							
							'Amount'=> $Amount,
							'Added'=>true,
							'Transfer'=>$comment,
						);							
						$t->save($data);
		
						$details = Details::find('first',
							array('conditions'=>array('username'=> (string) $username))
						);

									
						$dataDetails = array(
								'balance.XGC' => (float)((float)$details['balance.XGC'] + (float)$Amount),
								'XGCnewaddress'=>'Yes'						
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