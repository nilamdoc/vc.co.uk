<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
namespace app\controllers;
use app\models\Users;
use app\models\Details;
use app\models\Orders;
use app\models\Trades;
use lithium\data\Connections;
use MongoID;
use lithium\util\String;
use lithium\security\Auth;
use lithium\storage\Session;


class ExController extends \lithium\action\Controller {

	public function index() {

	}
	public function x($currency = null) {
		if($currency==null){$this->redirect(array('controller'=>'ex','action'=>'dashboard/'));}
		$user = Session::read('member');
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);

		if(($this->request->data)){
			$Action = $this->request->data['Action'];
			if($Action == "Buy"){
				$PendingAction = 'Sell';
				$FirstCurrency = $this->request->data['BuyFirstCurrency'];
				$SecondCurrency = $this->request->data['BuySecondCurrency'];
				$Commission = $this->request->data['BuyCommission'];
				$CommissionAmount = $this->request->data['BuyCommissionAmount'];				
				$CommissionCurrency = $this->request->data['BuyCommissionCurrency'];								
				$Amount = $this->request->data['BuyAmount'];
				$PerPrice = $this->request->data['BuyPriceper'];
				$BalanceAmount = $details['balance'][$SecondCurrency];
				$NewBalanceAmount = round($BalanceAmount - ($Amount * $PerPrice),8);
				$Currency = 'balance.'.$SecondCurrency;
				// Update balance of user with NewBalance Amount
				$data = array(
					'balance.'.$SecondCurrency => $NewBalanceAmount,
				);
				$details = Details::find('first',
					array('conditions'=>array('user_id'=>$id))
				)->save($data);
			}
			if($Action == "Sell"){
				$PendingAction = 'Buy';			
				$FirstCurrency = $this->request->data['SellFirstCurrency'];
				$SecondCurrency = $this->request->data['SellSecondCurrency'];
				$Commission = $this->request->data['SellCommission'];
				$CommissionAmount = $this->request->data['SellCommissionAmount'];				
				$CommissionCurrency = $this->request->data['SellCommissionCurrency'];								
				$Amount = $this->request->data['SellAmount'];
				$PerPrice = $this->request->data['SellPriceper'];				
				$BalanceAmount = $details['balance'][$FirstCurrency];
				$NewBalanceAmount = round($BalanceAmount - ($Amount),8);
				$Currency = 'balance.'.$FirstCurrency;
				// Update balance of user with NewBalance Amount				
				$data = array(
					'balance.'.$FirstCurrency => $NewBalanceAmount,
				);
				$details = Details::find('first',
					array('conditions'=>array('user_id'=>$id))
				)->save($data);
			}
			
						
			$data = array(
				'Action' => $Action,
				'FirstCurrency' => $FirstCurrency,
				'SecondCurrency' => $SecondCurrency,
				'CommissionPercent' => (float)($Commission),
				'Commission.Amount' => (float)($CommissionAmount),
				'Commission.Currency' => $CommissionCurrency,				
				'Amount' => (float)($Amount),
				'PerPrice' => (float)($PerPrice),
				'DateTime' => new \MongoDate(),
				'Completed' => 'N',
				'IP' => $_SERVER['REMOTE_ADDR'],
				'username' => $user['username'],
				'user_id' => $user['_id'],
			);
			// Create Order for the user
			$orders = Orders::create();			
			$orders->save($data);
			$order_id = $orders->_id;
			
			$PendingOrders = Orders::find('all',
				array(
					'conditions'=> array(
						'Action' => $PendingAction,
						'FirstCurrency' => $FirstCurrency,
						'SecondCurrency' => $SecondCurrency,
						'Completed' => 'N',
						'user_id' => array('$ne' => $user['_id']),
						'PerPrice' => (float)($PerPrice),
					),
					'order'=>array('DateTime'=>'ASC')
				));
				$i=0;
				foreach ($PendingOrders as $PO){
					if((float)$PO['Amount']==(float)($Amount)){
 						$data = array(
							'Completed' => 'Y',
							'Transact.id'=> $order_id,
							'Transact.username' => $user['username'],
							'Transact.user_id' => $user['_id'],
							'Transact.DateTime' => new \MongoDate(),
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$PO['_id']))
						)->save($data);
						
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$PO['_id']))
						);
						
						$data = array(
							'Completed' => 'Y',
							'Transact.id'=> $PO['_id'],
							'Transact.username' => $PO['username'],
							'Transact.user_id' => $PO['user_id'],
							'Transact.DateTime' => new \MongoDate(),														
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$order_id))
						)->save($data);

						$this->updateBalance($order_id);
						$this->updateBalance($PO['_id']);
						
						break;
					}
					
					if((float)$PO['Amount']>(float)($Amount)){
						$data = array(
							'Amount' => (float)($Amount),
							'Completed' => 'Y',
							'Transact.id'=> $order_id,
							'Transact.username' => $user['username'],
							'Transact.user_id' => $user['_id'],
							'Transact.DateTime' => new \MongoDate(),														
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$PO['_id']))
						)->save($data);
						print_r('Modified Past PO');						
						$data = array(
							'Amount' => (float)$PO['Amount'] - (float)($Amount),
							'Action' => $PO['Action'],
							'FirstCurrency' => $PO['FirstCurrency'],
							'SecondCurrency' => $PO['SecondCurrency'],
							'CommissionPercent' => (float)($PO['CommissionPercent']),
							'PerPrice' => (float)($PO['PerPrice']),
							'DateTime' => $PO['DateTime'],
							'Completed' => 'N',
							'IP' => $PO['IP'],
							'username' => $PO['username'],
							'user_id' => $PO['user_id'],
						);
						$orders = Orders::create();	
						$orders->save($data);
						$data = array(
							'Completed' => 'Y',
							'Transact.id'=> $PO['_id'],
							'Transact.username' => $PO['username'],
							'Transact.user_id' => $PO['user_id'],
							'Transact.DateTime' => new \MongoDate(),														
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$order_id))
						)->save($data);
						print_r('Modified New PO');
						//To update Balance						
						$this->updateBalance($order_id);
						$this->updateBalance($PO['_id']);

						break;
					}
					if((float)$PO['Amount']<(float)($Amount)){
						$data = array(
							'Completed' => 'Y',
							'Transact.id'=> $order_id,
							'Transact.username' => $user['username'],
							'Transact.user_id' => $user['_id'],
							'Transact.DateTime' => new \MongoDate(),														
							
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$PO['_id']))
						)->save($data);

						$data = array(
							'Amount' => (float)($Amount),
							'Completed' => 'Y',
							'Transact.id'=> $PO['_id'],
							'Transact.username' => $PO['username'],
							'Transact.user_id' => $PO['user_id'],
							'Transact.DateTime' => new \MongoDate(),														
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$order_id))
						)->save($data);

						$data = array(
							'Action' => $Action,
							'FirstCurrency' => $FirstCurrency,
							'SecondCurrency' => $SecondCurrency,
							'CommissionPercent' => (float)($Commission),
							'Amount' => (float)($Amount) - (float)$PO['Amount'],
							'PerPrice' => (float)($PerPrice),
							'DateTime' => new \MongoDate(),
							'Completed' => 'N',
							'IP' => $_SERVER['REMOTE_ADDR'],
							'username' => $user['username'],
							'user_id' => $user['_id'],
						);
						$orders = Orders::create();	
						$orders->save($data);
						$this->updateBalance($order_id);
						$this->updateBalance($PO['_id']);
						break;
					}
			}
			$this->redirect($this->request->params);			
		}
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		
		$first_curr = strtoupper(substr($currency,0,3));
		$second_curr = strtoupper(substr($currency,4,3));

		$mongodb = Connections::get('default')->connection;
		$TotalSellOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'Amount'=>'$Amount',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),
				)),
				array('$match'=>array(
					'Action'=>'Sell',
					'Completed'=>'N',					
					'FirstCurrency' => $first_curr,
					'SecondCurrency' => $second_curr,					
					)),
				array('$group' => array( '_id' => array(),
					'Amount' => array('$sum' => '$Amount'), 
					'TotalAmount' => array('$sum' => '$TotalAmount'), 
				)),
				array('$sort'=>array(
					'PerPrice'=>1,
				))
			)
		));
		$TotalBuyOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'Amount'=>'$Amount',
					'Completed'=>'$Completed',
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),					
				)),
				array('$match'=>array(
					'Action'=>'Buy',
					'Completed'=>'N',										
					'FirstCurrency' => $first_curr,
					'SecondCurrency' => $second_curr,					
					)),
				array('$group' => array( '_id' => array(),
					'Amount' => array('$sum' => '$Amount'),  
					'TotalAmount' => array('$sum' => '$TotalAmount'), 					
				)),
				array('$sort'=>array(
					'PerPrice'=>1,
				))
			)
		));

		$SellOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'Amount'=>'$Amount',
					'user_id' => '$user_id',
					'PerPrice'=>'$PerPrice',
					'Completed'=>'$Completed',
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
				)),
				array('$match'=>array(
					'Action'=>'Sell',
					'Completed'=>'N',										
					'FirstCurrency' => $first_curr,
					'SecondCurrency' => $second_curr,					
					)),
				array('$group' => array( '_id' => array(
						'PerPrice'=>'$PerPrice',
						),
					'Amount' => array('$sum' => '$Amount'),  
					'No' => array('$sum'=>1),
				)),
				array('$sort'=>array(
					'_id.PerPrice'=>1,
				))
			)
		));
		
		$BuyOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'user_id' => '$user_id',					
					'Amount'=>'$Amount',
					'PerPrice'=>'$PerPrice',
					'Completed'=>'$Completed',
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
				)),
				array('$match'=>array(
					'Action'=>'Buy',
					'Completed'=>'N',
					'FirstCurrency' => $first_curr,
					'SecondCurrency' => $second_curr,					
					)),
				array('$group' => array( '_id' => array(
						'PerPrice'=>'$PerPrice',
						),
					'Amount' => array('$sum' => '$Amount'),  
					'No' => array('$sum'=>1),

				)),
				array('$sort'=>array(
					'_id.PerPrice'=>-1,
				))
			)
		));
		$YourOrders = Orders::find('all',array(
			'conditions'=>array(
				'user_id'=>$id,
				'Completed'=>'N',
				'FirstCurrency' => $first_curr,
				'SecondCurrency' => $second_curr,					

				),
			'order' => array('DateTime'=>'DSEC')
		));
		$YourCompleteOrders = Orders::find('all',array(
			'conditions'=>array(
				'user_id'=>$id,
				'Completed'=>'Y',
				'FirstCurrency' => $first_curr,
				'SecondCurrency' => $second_curr,					
				),
			'order' => array('DateTime'=>'DSEC')
		));

		return compact('details','SellOrders','BuyOrders','TotalSellOrders','TotalBuyOrders','YourOrders','YourCompleteOrders');
	}
	public function dashboard() {
		$user = Session::read('member');
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);

		$trades = Trades::find('all');
		$YourOrders = array();
		foreach($trades as $t){
			$YourOrders['Buy'] = $this->YourOrders($id,'Buy',substr($t['trade'],0,3),substr($t['trade'],4,3));
			$YourOrders['Sell'] = $this->YourOrders($id,'Sell',substr($t['trade'],0,3),substr($t['trade'],4,3));			
			$YourCompleteOrders['Buy'] = $this->YourCompleteOrders($id,'Buy',substr($t['trade'],0,3),substr($t['trade'],4,3));
			$YourCompleteOrders['Sell'] = $this->YourCompleteOrders($id,'Sell',substr($t['trade'],0,3),substr($t['trade'],4,3));			
		}
		$Commissions = $this->TotalCommissions($id);
		$RequestFriends = $this->RequestFriend($id);
		return compact('details','YourOrders','Commissions','YourCompleteOrders','RequestFriends');
	}

	public function TotalCommissions($id){
		$mongodb = Connections::get('default')->connection;
		$Commissions = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Completed'=>'$Completed',
					'user_id'=>'$user_id',					
					'CommissionAmount'=>'$Commission.Amount',
					'CommissionCurrency'=>'$Commission.Currency',					
				)),
				array('$match'=>array(
					'Completed'=>'N',
					'user_id'=>$id
					)),
				array('$group' => array( '_id' => array(
						'CommissionCurrency'=>'$CommissionCurrency',						
						),
					'Commission' => array('$sum' => '$CommissionAmount'),  
					'No' => array('$sum'=>1)					
				)),
			)
		));
		return $Commissions;
	}

	public function YourOrders($id,$Action,$FirstCurrency,$SecondCurrency){
		$mongodb = Connections::get('default')->connection;
		$YourOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'user_id' => '$user_id',					
					'Amount'=>'$Amount',
					'PerPrice'=>'$PerPrice',
					'Completed'=>'$Completed',
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),					
				)),
				array('$match'=>array(
					'Completed'=>'N',
					'Action'=>$Action,										
					'user_id'=>$id
					)),
				array('$group' => array( '_id' => array(
						'Action'=>'$Action',				
						'FirstCurrency'=>'$FirstCurrency',
						'SecondCurrency'=>'$SecondCurrency',						
						),
					'Amount' => array('$sum' => '$Amount'),  
					'TotalAmount' => array('$sum' => '$TotalAmount'), 										
					'No' => array('$sum'=>1)					
				)),
				array('$sort'=>array(
					'_id.Action'=>1,
				))
			)
		));
	return $YourOrders;
	
	}
	public function YourCompleteOrders($id,$Action,$FirstCurrency,$SecondCurrency){
		$mongodb = Connections::get('default')->connection;
		$YourCompleteOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'user_id' => '$user_id',					
					'Amount'=>'$Amount',
					'PerPrice'=>'$PerPrice',
					'Completed'=>'$Completed',
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),					
				)),
				array('$match'=>array(
					'Completed'=>'Y',
					'Action'=>$Action,										
					'user_id'=>$id
					)),
				array('$group' => array( '_id' => array(
						'Action'=>'$Action',				
						'FirstCurrency'=>'$FirstCurrency',
						'SecondCurrency'=>'$SecondCurrency',						
						),
					'Amount' => array('$sum' => '$Amount'),  
					'TotalAmount' => array('$sum' => '$TotalAmount'), 										
					'No' => array('$sum'=>1)					
				)),
				array('$sort'=>array(
					'_id.Action'=>1,
				))
			)
		));
	return $YourCompleteOrders;
	}
	
	public function RemoveOrder($OrderID,$ID,$back){
		$Orders = Orders::find('first', array(
			'conditions' => array('_id' => new MongoID($ID))
		));
		$details = Details::find('first', array(
			'conditions' => array(
				'user_id'=>(string)$Orders['user_id'], 

				)
		));
		if($Orders['Action']=='Buy'){
			$balanceFirst = 'balance.'.$Orders['FirstCurrency'];
			$balanceSecond = 'balance.'.$Orders['SecondCurrency'];
			$data = array(
				$balanceSecond => $details[$balanceSecond] + $Orders['PerPrice']*$Orders['Amount']
			);
	
			$details = Details::find('all', array(
				'conditions' => array(
					'user_id'=>$Orders['user_id'], 
					'username'=>$Orders['username']
					)
			))->save($data);
		}
		if($Orders['Action']=='Sell'){
			$balanceFirst = 'balance.'.$Orders['FirstCurrency'];
			$balanceSecond = 'balance.'.$Orders['SecondCurrency'];
			$data = array(
				$balanceFirst => $details[$balanceFirst] + $Orders['Amount']
			);
	
			$details = Details::find('all', array(
				'conditions' => array(
					'user_id'=>$Orders['user_id'], 
					'username'=>$Orders['username']
					)
			))->save($data);
		}
		if(String::hash($Orders['_id'])==$OrderID){
			Orders::remove(array('_id'=>$ID));
		}
		$this->redirect(array('controller'=>'ex','action'=>"x/".$back,'locale'=>$locale));		
	}
	public function updateBalance($id){
		$Orders = Orders::find('first', array(
			'conditions' => array('_id' => new MongoID($id))
		));

		$details = Details::find('first', array(
			'conditions' => array(
				'user_id'=>(string)$Orders['user_id'], 
				)
		));
		$CommissionAmount = $Orders['Commission.Amount'];
		$CommissionCurrency = $Orders['Commission.Currency'];
		$Action = $Orders['Action'];
		
			$balance = 'balance.'.$CommissionCurrency;
			$data = array(
				$balance => (float)$details[$balance] - (float)$CommissionAmount,
			);
	
			$details = Details::find('all', array(
				'conditions' => array(
					'user_id'=>$Orders['user_id'], 
					)
			))->save($data);
			
 			if($Action=="Buy"){
				$Amount = (float)$Orders['Amount'];			
				$balance = 'balance.'.$Orders['FirstCurrency'];
				$details = Details::find('first', array(
					'conditions' => array(
						'user_id'=>(string)$Orders['user_id'], 
						)
				));
				
				$data = array(
					$balance => (float)$details[$balance] + (float)$Amount,
				);
				$details = Details::find('all', array(
					'conditions' => array(
						'user_id'=>$Orders['user_id'], 
						)
				))->save($data);
			}
			if($Action=="Sell"){
				$Amount = (float)$Orders['Amount'] * (float)$Orders['PerPrice'];			
				$balance = 'balance.'.$Orders['SecondCurrency'];
				$details = Details::find('first', array(
					'conditions' => array(
						'user_id'=>(string)$Orders['user_id'], 
						)
				));
				
				$data = array(
					$balance => (float)$details[$balance] + (float)$Amount,
				);
				$details = Details::find('all', array(
					'conditions' => array(
						'user_id'=>$Orders['user_id'], 
						)
				))->save($data);
			}
 	}
	public function RequestFriend($id){
	$mongodb = Connections::get('default')->connection;
		$RequestFriend = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'user_id' => '$user_id',					
					'TransactUsername'=>'$Transact.username',
					'TransactUser_id'=>'$Transact.user_id',
					'TransactDateTime'=>'$Transact.DateTime',
					'Completed'=>'$Completed',
				)),
				array('$match'=>array(
					'Completed'=>'Y',
					'user_id'=>$id
					)),
				array('$group' => array( '_id' => array(
						'TransactUsername'=>'$TransactUsername',						
						'TransactUser_id'=>'$TransactUser_id',						
						),
						)),
				array('$sort'=>array(
					'TransactUsername'=>1,
				))
			)
		));
	return $RequestFriend;
	
	}
}

?>