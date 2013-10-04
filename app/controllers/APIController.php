<?php
namespace app\controllers;
use app\controllers\UpdatesController;
use MongoDate;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Transactions;
use app\models\Orders;
use app\models\Requests;

class APIController extends \lithium\action\Controller {

	public function requestAPI($API = null,$username=null){
			$data = array(
			'API' => $API,
			'IP' => $_SERVER['REMOTE_ADDR'],
			'username' => $username,
			'nounce' => gmdate(time()),
			'DateTime' => new \MongoDate()
		);	
		$requests = Requests::find('first',array(
			'conditions' => array(
				'IP'=>$_SERVER['REMOTE_ADDR'],
				'API'=>$API
			),
			'order'=> array('DateTime'=>-1)
		));
		Requests::create()->save($data);
		if(gmdate(time())-$requests['nounce']<=1000){
			return false;
		}
		return true;
	}

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
		if(!$this->requestAPI("trades","public")){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Too many requests from your IP. Try after some time."
			)));
		}

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

		if(!$this->requestAPI("tradesdate","public")){
			return $this->render(array('json' => array('success'=>0,
			'now'=>time(),
			'error'=>"Too many requests from your IP. Try after some time."
			)));
		}

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
				if(!$this->requestAPI("info",$details['username'])){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Too many requests from your IP. Try after some time."
					)));
				}
		
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

				if(!$this->requestAPI("transactionhistory",$details['username'])){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Too many requests from your IP. Try after some time."
					)));
				}

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
				}elseif($type=="Deposit"){
					$typeofTran = array('$in'=>array(true));
				}elseif($type=="Withdrawal"){
					$typeofTran = array('$in'=>array(false));
				}
				switch ($currency) {
						case "All":
								$currencyType = array('$in'=>array('BTC','USD','GBP','EUR'));
								break;
						case "BTC":
								$currencyType = array('$in'=>array('BTC'));
								break;
						case "Other":
								$currencyType = array('$in'=>array('USD','GBP','EUR'));
								break;
						case "USD":
								$currencyType = array('$in'=>array('USD'));
								break;
						case "GBP":
								$currencyType = array('$in'=>array('GBP'));
								break;
						case "EUR":
								$currencyType = array('$in'=>array('EUR'));
								break;
				}
				$conditions = array(
						'username'=>$details['username'],
						'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ),
						'Added'=>$typeofTran,
						'Currency' => $currencyType,
					);
				
				$transactions = Transactions::find('all',array(
					'conditions'=> $conditions,
					'limit'=> $count,
					'order'=>array('Datetime'=>$order),
				));
				$i = 0;
				foreach ($transactions as $tx){
					$result[$i]['DateTime'] = $tx['DateTime']->sec;
					$result[$i]['Amount'] = $tx['Amount'];					
					$result[$i]['Currency'] = $tx['Currency'];					
					if($tx['Added']==true){
						$result[$i]['Type'] = "Deposit";					
					}else{
						$result[$i]['Type'] = "Withdrawal";					
					}
					if($tx['Currency']!="BTC"){
						$result[$i]['Approved'] = $tx['Approved'];										
						$result[$i]['Reference'] = $tx['Reference'];														
						if($tx['Approved']=="Rejected")	{
							$result[$i]['Reason'] = $tx['Reason'];										
						}
						if($tx['Approved']=="Yes")	{
							$result[$i]['AmountApproved'] = $tx['AmountApproved'];										
						}
					}else{
						$result[$i]['TransactionHash'] = $tx['TransactionHash'];																				
						$result[$i]['Address'] = $tx['address'];																						
						if($tx['Added']==false){
							$result[$i]['txFee'] = $tx['txFee'];										
							$result[$i]['Transfer'] = $tx['Transfer'];										
						}
					}
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
				if(!$this->requestAPI("orderhistory",$details['username'])){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Too many requests from your IP. Try after some time."
					)));
				}
			
				$count = $this->request->data['count'];
				if($count==""){$count=1000;}
				$status = $this->request->data['status'];
				if($status==""){$status='All';}			
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
				
				if($type=="All"){
					$typeofTran = array('$in'=>array('Buy','Sell'));
				}elseif($type=="Buy"){
					$typeofTran = array('$in'=>array('Buy'));
				}elseif($type=="Sell"){
					$typeofTran = array('$in'=>array('Sell'));
				}

				if($status=="All"){
					$StatusType = array('$in'=>array('N','Y'));
				}elseif($type=="Complete"){
					$StatusType = array('$in'=>array('Y'));
				}elseif($type=="Pending"){
					$StatusType = array('$in'=>array('N'));
				}


				$conditions = array(
						'username'=>$details['username'],
						'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ),
						'Action'=>$typeofTran,
						'Completed' => $StatusType,
					);

				$orders = Orders::find('all',array(
					'conditions'=> $conditions,
					'limit'=> $count,
					'order'=>array('Datetime'=>$order),
				));
				
				$i = 0;
				foreach($orders as $or){
					$result[$i]['DateTime'] = $or['DateTime']->sec;		
					$result[$i]['type'] = $or['Action'];		
					$result[$i]['pair'] = $or['FirstCurrency']."_".$or['SecondCurrency'];		
					$result[$i]['CommissionAmount'] = $or['Commission']['Amount'];		
					$result[$i]['CommissionCurrency'] = $or['Commission']['Currency'];							
					$result[$i]['Amount'] = $or['Amount'];							
					$result[$i]['Price'] = $or['PerPrice'];							
					$result[$i]['TotalAmount'] = $or['Amount']*$or['PerPrice'];							
					$result[$i]['status'] = $or['Completed'];		
					$result[$i]['order_id'] = (string)$or['_id'];							
					$i++;
				}
				
				return $this->render(array('json' => array('success'=>1,
				'now'=>time(),
				'result'=>$result
				)));
			}
		}
	}

	public function Orderlist($key=null){
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

				if(!$this->requestAPI("orderlist",$details['username'])){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Too many requests from your IP. Try after some time."
					)));
				}
			
				$count = $this->request->data['count'];
				if($count==""){$count=1000;}
				$pair = $this->request->data['pair'];
				if($pair==""){$pair='All';}			
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
				
				if($type=="All"){
					$typeofTran = array('$in'=>array('Buy','Sell'));
				}elseif($type=="Buy"){
					$typeofTran = array('$in'=>array('Buy'));
				}elseif($type=="Sell"){
					$typeofTran = array('$in'=>array('Sell'));
				}
				switch ($pair) {
						case "All":
								$FirstCurrency = array('$in'=>array('BTC'));
								$SecondCurrency = array('$in'=>array('USD','GBP','EUR'));
								break;
						case "BTC_USD":
								$FirstCurrency = array('$in'=>array('BTC'));
								$SecondCurrency = array('$in'=>array('USD'));
								break;
						case "BTC_GBP":
								$FirstCurrency = array('$in'=>array('BTC'));
								$SecondCurrency = array('$in'=>array('GBP'));
								break;
						case "BTC_EUR":
								$FirstCurrency = array('$in'=>array('BTC'));
								$SecondCurrency = array('$in'=>array('EUR'));
								break;
								
				}

				$conditions = array(
						'username'=>$details['username'],
						'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ),
						'Action'=>$typeofTran,
						'Completed' => 'N',
						'FirstCurrency'=>$FirstCurrency,
						'SecondCurrency'=>$SecondCurrency,
					);

				$orders = Orders::find('all',array(
					'conditions'=> $conditions,
					'limit'=> $count,
					'order'=>array('Datetime'=>$order),
				));
				
				$i = 0;
				foreach($orders as $or){
					$result[$i]['DateTime'] = $or['DateTime']->sec;		
					$result[$i]['type'] = $or['Action'];		
					$result[$i]['pair'] = $or['FirstCurrency']."_".$or['SecondCurrency'];		
					$result[$i]['CommissionAmount'] = $or['Commission']['Amount'];		
					$result[$i]['CommissionCurrency'] = $or['Commission']['Currency'];							
					$result[$i]['Amount'] = $or['Amount'];							
					$result[$i]['Price'] = $or['PerPrice'];							
					$result[$i]['TotalAmount'] = $or['Amount']*$or['PerPrice'];							
					$result[$i]['status'] = $or['Completed'];		
					$result[$i]['order_id'] = (string)$or['_id'];							
					$i++;
				}
				
				return $this->render(array('json' => array('success'=>1,
				'now'=>time(),
				'result'=>$result
				)));
			}
		}
	}
	public function trade($key=null){
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
				if(!$this->requestAPI("trade",$details['username'])){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Too many requests from your IP. Try after some time."
					)));
				}
			
				return $this->render(array('json' => array('success'=>1,
				'now'=>time(),
				'result'=>$result
				)));
			}
		}
	
	}
	public function cancelorder($key=null){
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
				if(!$this->requestAPI("cancelorder",$details['username'])){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Too many requests from your IP. Try after some time."
					)));
				}
			
				return $this->render(array('json' => array('success'=>1,
				'now'=>time(),
				'result'=>$result
				)));
			}
		}
	
	}

}
?>