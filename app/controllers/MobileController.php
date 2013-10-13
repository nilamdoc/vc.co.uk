<?php
namespace app\controllers;
use MongoDate;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Transactions;
use app\models\Orders;
use app\models\Trades;
use app\models\Requests;
use app\models\Parameters;
use lithium\util\String;
use app\extensions\action\Functions;
use MongoID;
class MobileController extends \lithium\action\Controller {

	public function index(){
		$UsersRegistered = Details::count();
		$functions = new Functions();
		$OnlineUsers = 	$functions->OnlineUsers();
		$OrdersN = Orders::count(
			array('Completed'=>'N')
		);
		$OrdersC = Orders::count(
			array('Completed'=>'Y')
		);
		
			$DetailPendingOrders = Orders::connection()->connection->command(array(
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
					'Completed'=>'N',										
					)),
				array('$group' => array( '_id' => array(
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
					'Action' => '$Action',
				),
					'Amount' => array('$sum' => '$Amount'),  
					'TotalAmount' => array('$sum' => '$TotalAmount'), 					
					'count' => array('$sum'=>1)
				)),
				array('$sort'=>array(
					'PerPrice'=>1,
				))
			)
		));

			$DetailCompletedOrders = Orders::connection()->connection->command(array(
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
					'Completed'=>'Y',										
					)),
				array('$group' => array( '_id' => array(
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
					'Action' => '$Action',
				),
					'Amount' => array('$sum' => '$Amount'),  
					'TotalAmount' => array('$sum' => '$TotalAmount'), 					
					'count' => array('$sum'=>1)					
				)),
				array('$sort'=>array(
					'PerPrice'=>1,
				))
			)
		));
		
		$users = Details::find('all',array(
			'order'=>array('username'=>1)
		));
		$Details = array();$i = 0;
		foreach($users as $dt){
			$user = Users::find('first',array(
				'conditions'=>array('username'=>$dt['username'])
			));

				$Details[$i]['Buy']['BTC-USD']['Amount'] = 0;
				$Details[$i]['Buy']['BTC-USD']['TotalAmount'] = 0;
				$Details[$i]['Buy']['BTC-USD']['count'] = 0;				

				$Details[$i]['Sell']['BTC-USD']['Amount'] = 0;
				$Details[$i]['Sell']['BTC-USD']['TotalAmount'] = 0;
				$Details[$i]['Sell']['BTC-USD']['count'] = 0;								

				$Details[$i]['Buy']['BTC-GBP']['Amount'] = 0;
				$Details[$i]['Buy']['BTC-GBP']['TotalAmount'] = 0;
				$Details[$i]['Buy']['BTC-GBP']['count'] = 0;								

				$Details[$i]['Sell']['BTC-GBP']['Amount'] = 0;
				$Details[$i]['Sell']['BTC-GBP']['TotalAmount'] = 0;
				$Details[$i]['Sell']['BTC-GBP']['count'] = 0;								

				$Details[$i]['Buy']['BTC-EUR']['Amount'] = 0;
				$Details[$i]['Buy']['BTC-EUR']['TotalAmount'] = 0;
				$Details[$i]['Buy']['BTC-EUR']['count'] = 0;								

				$Details[$i]['Sell']['BTC-EUR']['Amount'] = 0;
				$Details[$i]['Sell']['BTC-EUR']['TotalAmount'] = 0;
				$Details[$i]['Sell']['BTC-EUR']['count'] = 0;								

		$YourOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'user_id' => '$user_id',					
					'username' => '$username',
					'Amount'=>'$Amount',
					'PerPrice'=>'$PerPrice',
					'Completed'=>'$Completed',
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),					
				)),
				array('$match'=>array(
					'Completed'=>'N',
					'username'=>$dt['username']
					)),
				array('$group' => array( '_id' => array(
						'Action'=>'$Action',				
						'FirstCurrency'=>'$FirstCurrency',
						'SecondCurrency'=>'$SecondCurrency',						
						),
					'Amount' => array('$sum' => '$Amount'),  
					'TotalAmount' => array('$sum' => '$TotalAmount'), 										
					'count' => array('$sum'=>1)					
				)),
				array('$sort'=>array(
					'_id.Action'=>1,
				))
			)
		));

		foreach($YourOrders['result'] as $YO){
			if($YO['_id']['Action']=='Buy' && $YO['_id']['FirstCurrency'] == 'BTC' && $YO['_id']['SecondCurrency']=='USD'){
				$Details[$i]['Buy']['BTC-USD']['Amount'] = $YO['Amount'];
				$Details[$i]['Buy']['BTC-USD']['TotalAmount'] = $YO['TotalAmount'];
				$Details[$i]['Buy']['BTC-USD']['count'] = $YO['count'];				
			}
			if($YO['_id']['Action']=='Sell' && $YO['_id']['FirstCurrency'] == 'BTC' && $YO['_id']['SecondCurrency']=='USD'){
				$Details[$i]['Sell']['BTC-USD']['Amount'] = $YO['Amount'];
				$Details[$i]['Sell']['BTC-USD']['TotalAmount'] = $YO['TotalAmount'];
				$Details[$i]['Sell']['BTC-USD']['count'] = $YO['count'];								
			}
			if($YO['_id']['Action']=='Buy' && $YO['_id']['FirstCurrency'] == 'BTC' && $YO['_id']['SecondCurrency']=='GBP'){
				$Details[$i]['Buy']['BTC-GBP']['Amount'] = $YO['Amount'];
				$Details[$i]['Buy']['BTC-GBP']['TotalAmount'] = $YO['TotalAmount'];
				$Details[$i]['Buy']['BTC-GBP']['count'] = $YO['count'];								
			}
			if($YO['_id']['Action']=='Sell' && $YO['_id']['FirstCurrency'] == 'BTC' && $YO['_id']['SecondCurrency']=='GBP'){
				$Details[$i]['Sell']['BTC-GBP']['Amount'] = $YO['Amount'];
				$Details[$i]['Sell']['BTC-GBP']['TotalAmount'] = $YO['TotalAmount'];
				$Details[$i]['Sell']['BTC-GBP']['count'] = $YO['count'];								
			}
			if($YO['_id']['Action']=='Buy' && $YO['_id']['FirstCurrency'] == 'BTC' && $YO['_id']['SecondCurrency']=='EUR'){
				$Details[$i]['Buy']['BTC-EUR']['Amount'] = $YO['Amount'];
				$Details[$i]['Buy']['BTC-EUR']['TotalAmount'] = $YO['TotalAmount'];
				$Details[$i]['Buy']['BTC-EUR']['count'] = $YO['count'];								
			}
			if($YO['_id']['Action']=='Sell' && $YO['_id']['FirstCurrency'] == 'BTC' && $YO['_id']['SecondCurrency']=='EUR'){
				$Details[$i]['Sell']['BTC-EUR']['Amount'] = $YO['Amount'];
				$Details[$i]['Sell']['BTC-EUR']['TotalAmount'] = $YO['TotalAmount'];
				$Details[$i]['Sell']['BTC-EUR']['count'] = $YO['count'];								
			}
		}
		
			$Details[$i]['username'] = $user['username'];							
			$Details[$i]['firstname'] = $user['firstname'];							
			$Details[$i]['lastname'] = $user['lastname'];										
			$Details[$i]['email'] = $user['email'];													
			$Details[$i]['ip'] = $user['ip'];													
			$Details[$i]['created'] = $user['created'];													
			$Details[$i]['BTC'] = $dt['balance']['BTC'];													
			$Details[$i]['USD'] = $dt['balance']['USD'];												
			$Details[$i]['EUR'] = $dt['balance']['EUR'];													
			$Details[$i]['GBP'] = $dt['balance']['GBP'];
			$Details[$i]['BankVerified'] = $dt['bank']['verified'];			
			$Details[$i]['GovtVerified'] = $dt['government']['verified'];						
			$Details[$i]['UtilVerified'] = $dt['utility']['verified'];			
			$Details[$i]['TOTPvalidate'] = $dt['TOTP']['Validate'];			
			$Details[$i]['TOTPlogin'] = $dt['TOTP']['Login'];			
			$Details[$i]['TOTPwithdrawal'] = $dt['TOTP']['Withdrawal'];			
			$Details[$i]['TOTPsecurity'] = $dt['TOTP']['Security'];												

			$i++;
		}



		
		$result = array(
			'users'=>$UsersRegistered,
			'online'=>$OnlineUsers,
			'PendingOrders'=>$OrdersN,
			'CompletedOrders'=>$OrdersC,			
			'DetailPendingOrders'=>$DetailPendingOrders,
			'DetailCompletedOrders'=>$DetailCompletedOrders,			
			'Details'=>$Details,
			
		);
	
					return $this->render(array('json' => array('success'=>1,
						'now'=>time(),
						'result'=>$result
						)));
	}

	public function user(){
				$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30)));
				$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
			
			$Transactions = Transactions::find('all',array(
				'conditions'=>array(
					'Currency'=>'BTC',
					'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ) ,			
					),
				'order'=>array('DateTime'=>-1)
			));
		foreach($Transactions as $tx)		{
			$Details[$i]['tx']['username'] = $user['username'];							
			$Details[$i]['tx']['DateTime'] = $tx['DateTime']->sec;							
			$Details[$i]['tx']['Amount'] = $tx['Amount'];									
			$Details[$i]['tx']['txFee'] = $tx['txFee'];									
			$Details[$i]['tx']['Added'] = $tx['Added'];									
		}
	
			$FiatDepositTransactions = Transactions::find('all',array(
				'conditions'=>array(
					'Currency'=>array('$ne'=>'BTC'),
					'Approved'=>'Yes',
					'Added'=>true
				),
				'order'=>array('DateTime'=>-1)
			));
		foreach($FiatDepositTransactions as $tx)		{
			$Details[$i]['FiatDeposit']['username'] = $user['username'];							
			$Details[$i]['FiatDeposit']['DateTime'] = $tx['DateTime']->sec;							
			$Details[$i]['FiatDeposit']['Amount'] = $tx['Amount'];									
			$Details[$i]['FiatDeposit']['Currency'] = $tx['Currency'];									
	
		}
			$FiatWithdrawalTransactions = Transactions::find('all',array(
				'conditions'=>array(
					'Currency'=>array('$ne'=>'BTC'),
					'Approved'=>'Yes',
					'Added'=>false
				),
				'order'=>array('DateTime'=>-1)
			));
		foreach($FiatWithdrawalTransactions as $tx)		{
			$Details[$i]['FiatWithdrawal']['username'] = $user['username'];							
			$Details[$i]['FiatWithdrawal']['DateTime'] = $tx['DateTime']->sec;							
			$Details[$i]['FiatWithdrawal']['Amount'] = $tx['Amount'];									
			$Details[$i]['FiatWithdrawal']['Currency'] = $tx['Currency'];									
		}
	
	
	}

}
?>