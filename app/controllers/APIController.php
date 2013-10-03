<?php
namespace app\controllers;
use app\controllers\UpdatesController;
use MongoDate;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Transactions;

use app\models\Orders;

class APIController extends \lithium\action\Controller {
	public function index(){
		$user = Session::read('default');
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$userInfo = Users::find('first',
				array('conditions'=>array('_id'=> (string) $id))
		);
		$title = "API";
		$keywords = "API, documentation, ibwt";
		$description = "API documentation for ibwt.co.uk";
		return compact('title','keywords','description','details','userInfo');
	}
	public function trades(){
		$updates = new UpdatesController();
		$upBU = $updates->Rates('BTC','USD');
		$jdecBU = json_decode($upBU->body[0]);
//print_r($jdecBU)		;
		$upBG = $updates->Rates('BTC','GBP');
		$jdecBG = json_decode($upBG->body[1]);
//print_r($jdecBG)		;		
		$upBE = $updates->Rates('BTC','EUR');
		$jdecBE = json_decode($upBE->body[2]);
//print_r($jdecBE)		;
		return $this->render(array('json' => array('success'=>1,
			'now'=>gmdate(time()),
			'result'=>array(
				array(
					'Low'=> number_format($jdecBU->Low,2),
					'High' => number_format($jdecBU->High,2),
					'Last'=> number_format($jdecBU->LastPrice,2),			
					'FirstUnit'=> 'BTC',			
					'SecondUnit'=> 'USD',
				),
				array(
					'Low'=> number_format($jdecBG->Low,2),
					'High' => number_format($jdecBG->High,2),
					'Last'=> number_format($jdecBG->LastPrice,2),			
					'FirstUnit'=> 'BTC',			
					'SecondUnit'=> 'GBP',
				),
				array(
					'Low'=> number_format($jdecBE->Low,2),
					'High' => number_format($jdecBE->High,2),
					'Last'=> number_format($jdecBE->LastPrice,2),			
					'FirstUnit'=> 'BTC',			
					'SecondUnit'=> 'EUR',
				),
		))));	
	}
	public function tradesdate($date=null){
		if($date==null){
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time())))));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+24*60*60)));
		}else{
			$StartDate = new MongoDate(strtotime($date));
			$EndDate = new MongoDate(strtotime($date)+24*60*60);			
		}
		$orders = Orders::find('all',array(
			'conditions'=>array('DateTime'=>array( '$gte' => $StartDate, '$lt' => $EndDate )),
			'order'=>array('DateTime'=>-1)
		));
		$i = 0;$result = array();
		foreach($orders as $or){

			$result[$i]['DateTime'] = $or['DateTime']->sec;
			$result[$i]['Action'] = $or['Action'];			
			$result[$i]['FromCurrency'] = $or['FirstCurrency'];						
			$result[$i]['ToCurrency'] = $or['SecondCurrency'];									
			$result[$i]['BTC'] = $or['Amount'];									
			$result[$i]['PerPrice'] = $or['PerPrice'];									
			$result[$i]['FromCurrency'] = $or['FirstCurrency'];					
			$result[$i]['Completed'] = $or['Completed'];												
			$i++;
		}
		
			return $this->render(array('json' => array('success'=>1,
			'now'=>$StartDate->sec,
			'result'=>$result
			)));
	}
	public function Info($key = null){
   if(!$this->request->data){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Not submitted through POST."
			)));
	 }
	 if ($key==null){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Key not specified. Please get your key from your settings page under security."
			)));
	 }else{
	 	$details = Details::find('first',array(
			'conditions'=>array('key'=>$key)
		));
		if(count($details)==0){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Incorrect Key! Please get your key from your settings page under security."
			)));
		}else{
			$user = Users::find('first',array(
				'conditions'=>array('_id'=>$details['user_id'])
			));
			$ordersPending = Orders::count(array(
				'username'=>$details['username'],
				'Completed'=>'N'
				)
			);
			$ordersComplete = Orders::count(array(
				'username'=>$details['username'],
				'Completed'=>'Y'
				)
			);
			$ordersSell = Orders::count(array(
				'username'=>$details['username'],
				'Action'=>'Sell'
				)
			);
			$ordersBuy = Orders::count(array(
				'username'=>$details['username'],
				'Action'=>'Buy'
				)
			);
			$transactionsBTC = Transactions::count(array(
				'username'=>$details['username'],
				'Currency'=>'BTC'
			));
			$transactionsOther = Transactions::count(array(
				'username'=>$details['username'],
				'Currency'=>array('$ne'=>'BTC')
			));			
			$result = array(
				'TOTP'=>array(
					'Validate'=>$details['TOTP.Validate'],
					'Login'=>$details['TOTP.Login'],
					'Withdrawal'=>$details['TOTP.Withdrawal'],					
					'Security'=>$details['TOTP.Security'],					
				),
				'balance'=>array(
					'BTC'=>$details['balance.BTC'],
					'USD'=>$details['balance.USD'],					
					'GBP'=>$details['balance.GBP'],					
					'EUR'=>$details['balance.EUR']
				),
				'government'=>array(
					'name'=>$details['government.name'],
					'verified'=>$details['government.verified'],
				),
				'addressproof'=>array(
					'name'=>$details['utility.name'],				
					'verified'=>$details['utility.verified']
				),
				'bank'=>array(
					'name'=>$details['bank.bankname'],				
					'address'=>$details['bank.branchaddress'],					
					'account'=>$details['bank.accountname'],					
					'number'=>$details['bank.accountnumber'],					
					'sortcode'=>$details['bank.sortcode'],					
					'verified'=>$details['bank.verified'],
				),
				'email'=>array(
					'address'=>$user['email'],
					'verified'=>$details['email.verified']
				),
				'user'=>array(
					'first_name'=>$user['firstname'],
					'last_name'=>$user['lastname'],
					'username'=>$user['username'],
					'created'=>$user['created']->sec
				),
				'orders'=>array(
					'pending'=>$ordersPending,
					'complete'=>$ordersComplete,
					'sell'=>$ordersSell,
					'buy'=>$ordersBuy
				),
				'transactions'=>array(
					'BTC'=>$transactionsBTC,
					'Other'=>$transactionsOther
				)
			);
			return $this->render(array('json' => array('success'=>1,
			'now'=>time(),
			'result'=>$result
			)));
		}
	 }
	}
	
	public function Transactionhistory($key=null){
	 if(!$this->request->data){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Not submitted through POST."
			)));
	 }
	 if ($key==null){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Key not specified. Please get your key from your settings page under security."
			)));
	 }else{
			$details = Details::find('first',array(
				'conditions'=>array('key'=>$key)
			));
			if(count($details)==0){
				return $this->render(array('json' => array('success'=>0,
				'now'=>time(),
				'error'=>"Incorrect Key! Please get your key from your settings page under security."
				)));
			}else{
				$count = $this->request->data['count'];
				if($count==""){$count=1000;}
				$currency = $this->request->data['currency'];
				if($currency==""){$currency='All';}			
				$order = $this->request->data['order'];			
				if($order==""){$order='DESC';}			
				$start = $this->request->data['start'];			
				if($start==""){$start='2013-10-01';}			
				$end = $this->request->data['end'];			
				if($end==""){$currency=gmdate('Y-m-d',time());}						
				$type = $this->request->data['type'];			
				if($type==""){$type="All";}
				$StartDate = new MongoDate(strtotime($start));
				$EndDate = new MongoDate(strtotime($end));				
				if($type=="Deposit"){
					$typeofTran = array(true);
				}
				if($type=="Withdrawal"){
					$typeofTran = array(false);
				}
				if($type=="All"){
					$typeofTran = array('$in'=>array(true,false));
				}
				if($currency=="All"){
				
				}
				$conditions = array(
						'username'=>$details['username'],
						'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ),
						'Added'=>$typeofTran,
						'Currency' => 'GBP'
					);
				
				$transactions = Transactions::find('all',array(
					'conditions'=> $conditions,
					'order'=>array('Datetime'=>$order)
				));
				$i = 0;
				foreach ($transactions as $tx){
					$result[$i]['DateTime'] = $tx['DateTime']->sec;
				$i++;
				}
				return $this->render(array('json' => array('success'=>1,
				'now'=>time(),
				'result'=>$result
				)));
			}
		}
	}
	public function Orderhistory($key=null){
	 if(!$this->request->data){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Not submitted through POST."
			)));
	 }
	 if ($key==null){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Key not specified. Please get your key from your settings page under security."
			)));
	 }else{
			$details = Details::find('first',array(
				'conditions'=>array('key'=>$key)
			));
			if(count($details)==0){
				return $this->render(array('json' => array('success'=>0,
				'now'=>time(),
				'error'=>"Incorrect Key! Please get your key from your settings page under security."
				)));
			}else{
				$count = $this->request->data['count'];
				if($count==""){$count=1000;}
				return $this->render(array('json' => array('success'=>1,
				'now'=>time(),
				'result'=>$result
				)));
			}
		}
	}

}
?>