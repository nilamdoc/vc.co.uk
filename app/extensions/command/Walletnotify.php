<?php 
namespace app\extensions\command;

use app\models\Transactions;
use app\models\Details;
use app\extensions\action\Bitcoin;


class Walletnotify extends \lithium\console\Command {
    public function index($s=null) {
			$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);

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
							'Amount'=> $Amount,
							'Added'=>false
						);
						$Transactions = Transactions::find('first',array(
							'conditions'=>array('TransactionHash' => $s)
						));
						if($Transactions['_id']==""){
							$t = Transactions::create();
							$data = array(
								'DateTime' => new \MongoDate(),
								'TransactionHash' => $s,
								'username' => $details['username'],
								'address'=>$address,							
								'Amount'=> $Amount,
								'Added'=>true
							);							
							$t->save($data);
							
							$dataDetails = array(
									'balance.BTC' => (float)$details['balance.BTC'] + $Amount,
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