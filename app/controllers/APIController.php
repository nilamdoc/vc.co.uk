<?php
namespace app\controllers;
use app\controllers\UpdatesController;
use app\controllers\ExController;
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
use MongoID;
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
		if(gmdate(time())-$requests['nounce']<=1){
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
		$order = Orders::find('first',array(
			'conditions'=>array(
			'user_id'=> (string) $id,
			'Completed'=>'N'
			)
		));
		$title = "API";
		$keywords = "API, documentation, ibwt";
		$description = "API documentation for ibwt.co.uk";
		return compact('title','keywords','description','details','userInfo','order');
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
print_r($jdecBU)		;
		$upBG = $updates->Rates('BTC','GBP');
		$jdecBG = json_decode($upBG->body[1]);
print_r($jdecBG)		;		
		$upBE = $updates->Rates('BTC','EUR');
		$jdecBE = json_decode($upBE->body[2]);
print_r($jdecBE)		;
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
				$type = $this->request->data['type'];
				$pair = $this->request->data['pair'];				
				$amount = $this->request->data['amount'];				
				$price = $this->request->data['price'];				
				if(!($type=="Buy" || $type=="Sell")){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Type is incorrect! Should be 'Buy' or 'Sell'."
					)));
				}
				if(!($pair=='BTC_USD' || $pair=='BTC_GBP' || $pair=='BTC_EUR')){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Pair is incorrect! Should be 'BTC_USD' or 'BTC_GBP' or 'BTC_EUR'."
					)));
				}
				if((float)$amount<=0){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Amount less than or equal to ZERO! Should be greater than ZERO."
					)));
				}
				if((float)$price<=0){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Price less than or equal to ZERO! Should be greater than ZERO."
					)));
				}
				$first_curr = strtoupper(substr($pair,0,3));
				$second_curr = strtoupper(substr($pair,4,3));
		
//======================Trade========================================================

				$data = array(
				'page.refresh' => true
				);
				Details::find('all')->save($data);
				$details = Details::find('first',array(
				'conditions'=>array('key'=>$key)
				));
				$id = $details['user_id'];			
				$user = Users::find('first',array(
					'conditions'=>array('_id'=>$id)
				));
				$Action = $type;
				$commission = Parameters::find('first');
				$commissionRate = $commission['value'];

			if($Action == "Buy"){
				$PendingAction = 'Sell';
				$FirstCurrency = $first_curr;
				$SecondCurrency = $second_curr;
				$Commission = (float)$commissionRate;
				$CommissionAmount = number_format((float)$commissionRate * (float)$amount/100,8);				
				$CommissionCurrency = $first_curr;;								
				$Amount = number_format((float)$amount,8);
				$PerPrice = number_format((float)$price,8);
				$BalanceAmount = $details['balance'][$second_curr];
				if(($amount * $price)>=$BalanceAmount){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Amount exceeds your balance! Balance: ".$BalanceAmount,
					)));
				}
				$NewBalanceAmount = round($BalanceAmount - ($amount * $price),8);
				$Currency = 'balance.'.$second_curr;
				// Update balance of user with NewBalance Amount
				$data = array(
					'balance.'.$second_curr => (float)($NewBalanceAmount),
					);
				$details = Details::find('first',
					array('conditions'=>array('user_id'=>$id))
				)->save($data);
			}

			if($Action == "Sell"){
				$PendingAction = 'Buy';			
				$FirstCurrency = $first_curr;
				$SecondCurrency = $second_curr;
				$Commission = (float)$commissionRate;
				$CommissionAmount = number_format((float)$commissionRate * (float)$amount * (float)$price/100,8);				
				$CommissionCurrency = $second_curr;
				$Amount = number_format((float)$amount,8);
				$PerPrice = number_format((float)$price,8);
				$BalanceAmount = $details['balance'][$first_curr];
				if(($amount * $price)>=$BalanceAmount){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Amount exceeds your balance! Balance: ".$BalanceAmount,
					)));
				}
				$NewBalanceAmount = round($BalanceAmount - ($amount),8);
				$Currency = 'balance.'.$first_curr;
				// Update balance of user with NewBalance Amount				
				$data = array(
					'balance.'.$first_curr => (float)($NewBalanceAmount),
				);
				$details = Details::find('first',
					array('conditions'=>array('user_id'=>$id))
				)->save($data);
			}

			$data = array(
				'Action' => $Action,
				'FirstCurrency' => $first_curr,
				'SecondCurrency' => $second_curr,
				'CommissionPercent' => (float)($Commission),
				'Commission.Amount' => (float)($CommissionAmount),
				'Commission.Currency' => $CommissionCurrency,				
				'Amount' => (float)($Amount),
				'PerPrice' => (float)($PerPrice),
				'DateTime' => new \MongoDate(),
				'Completed' => 'N',
				'IP' => $_SERVER['REMOTE_ADDR'],
				'username' => $user['username'],
				'user_id' => (string)$user['_id'],
			);
					// Create Order for the user
			$orders = Orders::create();			
			$orders->save($data);
			$order_id = $orders->_id;

			$data = array(
				'refresh' => true
			);
			Trades::find('all',array(
				'conditions' => array('trade'=>$title)
			))->save($data);
			$ex = new ExController();

			$ex->SendEmails($order_id,$user['_id']);
//	=Pending Orders=================================================================================
$FirstCurrency = $first_currency;
$SecondCurrency = $second_currency;

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

						$ex->updateBalance($order_id);
						$ex->updateBalance($PO['_id']);
						$ex->SendOrderCompleteEmails($order_id,$user['_id']);
						$ex->SendOrderCompleteEmails($PO['_id'],$PO['user_id']);						
						break;
					}
					
					if((float)$PO['Amount']>(float)($Amount)){
						// Update Previous Order with New Order Amount and New Commission and Transact User 
						if($PO['Action']=="Buy"){
							$PrevCommAmount = round(($PO['CommissionPercent'] * ($Amount) )/100,8);
							$CurrCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount'] - $Amount) * $PO['PrePrice'])/100,8);							
							$PrevCommCurr = $PO['FirstCurrency'];
							$CurrCommCurr = $PO['SecondCurrency'];							
						}else{
							$PrevCommAmount = round((float)$PO['CommissionPercent'] * (float)($Amount) * (float)($PerPrice)/100,8);
							$CurrCommAmount = round(($PO['CommissionPercent'] * ($Amount) )/100,8);														
							$PrevCommCurr = $PO['SecondCurrency'];
							$CurrCommCurr = $PO['FirstCurrency'];														
						}

						$data = array(
							'Commission.Amount' => (float)$PrevCommAmount,
							'Amount' => (float)($Amount),
							'Completed' => 'Y',
							'Transact.id'=> $order_id,
							'Transact.username' => $user['username'],
							'Transact.user_id' => $user['_id'],
							'Transact.DateTime' => new \MongoDate(),														
							'Order'=>'P>C: Update Previous Commission and Amount and Complete Order'							
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$PO['_id']))
						)->save($data);
						// --------------------Complete
						// Create new Order for Previous Order so that the order tallies
						if($PO['Action']=="Buy"){
							$PrevCommAmount = round((float)(round((float)$PO['Amount'] - (float)($Amount),8)) * (float)($PO['CommissionPercent']) /100,8);
						}else{
							$PrevCommAmount = round((float)(round((float)$PO['Amount'] - (float)($Amount),8)) * (float)($PO['PerPrice']) * (float)($PO['CommissionPercent']) /100,8);						
						}
						$data = array(
							'Amount' => (float)(round((float)$PO['Amount'] - (float)($Amount),8)),
							'Action' => $PO['Action'],
							'FirstCurrency' => $PO['FirstCurrency'],
							'SecondCurrency' => $PO['SecondCurrency'],
							'CommissionPercent' => (float)($PO['CommissionPercent']),
/////////////////////////////////////////////////////////////////////////////////////////////
							'Commission.Amount' => (float)($PrevCommAmount),
							'Commission.Currency' => $PrevCommCurr,				
/////////////////////////////////////////////////////////////////////////////////////////////							
							'PerPrice' => (float)($PO['PerPrice']),
							'DateTime' => $PO['DateTime'],
							'Completed' => 'N',
							'IP' => $PO['IP'],
							'username' => $PO['username'],
							'user_id' => $PO['user_id'],
							'Order'=>'P>C: Create New Previous Order with Balance details'
						);
						$orders = Orders::create();	
						$orders->save($data);
						//-------------------Complete
						//Update New order with Transact User
						$data = array(
							'Completed' => 'Y',
							'Transact.id'=> $PO['_id'],
							'Transact.username' => $PO['username'],
							'Transact.user_id' => $PO['user_id'],
							'Transact.DateTime' => new \MongoDate(),														
							'Order'=>'P>C: Update current order no change in commission or amount'							
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$order_id))
						)->save($data);
						//---------------------Complete
						//To update Balance						
						$ex->updateBalance($order_id);
						$ex->updateBalance($PO['_id']);
						$ex->SendOrderCompleteEmails($order_id,$user['_id']);
						$ex->SendOrderCompleteEmails($PO['_id'],$PO['user_id']);						
						break;
					}
					if((float)$PO['Amount']<(float)($Amount)){
						// Update Previous Order with New Order Amount and New Commission and Transact User 
					
						if($PO['Action']=="Buy"){
							$PrevCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount'] - $Amount) )/100,8);
							$CurrCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount'] - $Amount) * $PO['PrePrice'])/100,8);							
							$PrevCommCurr = $PO['FirstCurrency'];
							$CurrCommCurr = $PO['SecondCurrency'];							
						}else{
							$PrevCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount'] - $Amount) * $PO['PerPrice'])/100,8);
							$CurrCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount'] - $Amount) )/100,8);														
							$PrevCommCurr = $PO['SecondCurrency'];
							$CurrCommCurr = $PO['FirstCurrency'];														
						}
						if($PO['Action']=="Buy"){
							$PrevCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount']) )/100,8);
						}else{
							$PrevCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount']) * $PO['PerPrice'])/100,8);
						}
						$data = array(
							'Commission.Amount' => (float)$PrevCommAmount,
							'Amount' => (float)($PO['Amount']),						
							'Completed' => 'Y',
							'Transact.id'=> $order_id,
							'Transact.username' => $user['username'],
							'Transact.user_id' => $user['_id'],
							'Transact.DateTime' => new \MongoDate(),														
							'Order'=>'P<C: Update Previous Record'
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$PO['_id']))
						)->save($data);
						//--------------------Complete
						// Update current order with new commission and amount
						if($PO['Action']=="Buy"){
							$CurrCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount']) * $PO['PerPrice'] /100 ),8);
						}else{
							$CurrCommAmount = round(($PO['CommissionPercent'] * ($PO['Amount']) /100 ),8);;
						}
						$data = array(
							'Commission.Amount' => (float)$CurrCommAmount,
							'Amount' => (float)($PO['Amount']),
							'Completed' => 'Y',
							'Transact.id'=> $PO['_id'],
							'Transact.username' => $PO['username'],
							'Transact.user_id' => $PO['user_id'],
							'Transact.DateTime' => new \MongoDate(),														
							'Order'=>'P<C: Update current record'							
						);
						$orders = Orders::find('first',
							array('conditions'=>array('_id'=>$order_id))
						)->save($data);
						//--------------------Complete
						//Create a new order of pending amount 
						if($PO['Action']=='Buy'){
							$CurrCommAmount = round(($PO['CommissionPercent'] * ((float)(round((float)($Amount) - (float)$PO['Amount'],8))) * $PerPrice /100 ),8);
						}else{
							$CurrCommAmount = round(($PO['CommissionPercent'] * ((float)(round((float)($Amount) - (float)$PO['Amount'],8)))/100 ),8);;
						}
						$data = array(
							'Action' => $Action,
							'FirstCurrency' => $FirstCurrency,
							'SecondCurrency' => $SecondCurrency,
							'CommissionPercent' => (float)($Commission),
///////////////////////////////////////////////////////////////////////////////////////////////////////
							'Commission.Amount' => (float)($CurrCommAmount),
							'Commission.Currency' => $CurrCommCurr,				
///////////////////////////////////////////////////////////////////////////////////////////////////////							
							'Amount' => (float)(round((float)($Amount) - (float)$PO['Amount'],8)),
							'PerPrice' => (float)($PerPrice),
							'DateTime' => new \MongoDate(),
							'Completed' => 'N',
							'IP' => $_SERVER['REMOTE_ADDR'],
							'username' => $user['username'],
							'user_id' => $user['_id'],
							'Order'=>'P<C: Create New Previous Order with Balance details'
						);
						$orders = Orders::create();	
						$orders->save($data);
						$ex->updateBalance($order_id);
						$ex->updateBalance($PO['_id']);
						$ex->SendOrderCompleteEmails($order_id,$user['_id']);
						$ex->SendOrderCompleteEmails($PO['_id'],$PO['user_id']);						
						break;
					}
			}

//  =Pending orders=================================================================================

//======================Trade========================================================
				$Order = Orders::find('first',array(
					'conditions'=>array('_id'=>$order_id)
				));
				$result = array(
					'Order_id' => String::hash($Order['_id']),
					'pair' => $pair,
					'type'=> $type,
					'Commission.Amount'=>$Order['Commission']['Amount'],
					'Commission.Currency'=>$Order['Commission']['Currency'],					
					'amount'=> $Order['Amount'],
					'price'=> $Order['PerPrice'],
					'time'=>$Order['DateTime']->sec,
					'Completed'=>$Order['Completed'],
					'username'=>$Order['username']
				);
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
				$ID = $this->request->data['order_id'];
				if($ID==""){
					return $this->render(array('json' => array('success'=>0,
					'now'=>time(),
					'error'=>"Order ID cannot be null."
					)));
				
				}
				$Orders = Orders::find('first', array(
					'conditions' => array('_id' => new MongoID($ID))
				));
//				print_r($Orders);
				if($Orders['Completed']=='N')		{
					$details = Details::find('first', array(
						'conditions' => array('user_id'=>(string)$Orders['user_id'])
					));
					if($Orders['Action']=='Buy'){
						$balanceFirst = 'balance.'.$Orders['FirstCurrency'];
						$balanceSecond = 'balance.'.$Orders['SecondCurrency'];
						$data = array(
							$balanceSecond => (float)($details[$balanceSecond] + $Orders['PerPrice']*$Orders['Amount'])
						);
		
						$details = Details::find('all', array(
							'conditions' => array(
								'user_id'=>$Orders['user_id'], 'username'=>$Orders['username']
								)
						))->save($data);
					}
					if($Orders['Action']=='Sell'){
						$balanceFirst = 'balance.'.$Orders['FirstCurrency'];
						$balanceSecond = 'balance.'.$Orders['SecondCurrency'];
						$data = array(
							$balanceFirst => (float)($details[$balanceFirst] + (float)$Orders['Amount'])
						);
				
						$details = Details::find('all', array(
							'conditions' => array(
								'user_id'=>$Orders['user_id'], 
								'username'=>$Orders['username']
								)
						))->save($data);
					}
					$Remove = Orders::remove(array('_id'=>$ID));
					$result = $Remove;
					
						$data = array(
						'page.refresh' => true
						);
						Details::find('all')->save($data);
			
						return $this->render(array('json' => array('success'=>1,
						'now'=>time(),
						'result'=>$result
						)));
					}
				}
			}	
	}

}
?>