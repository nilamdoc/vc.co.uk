<?php
namespace app\controllers;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Transactions;
use app\models\Reasons;
use app\models\File;
use app\models\Trades;
use app\models\Orders;
use app\models\Requests;
use lithium\data\Connections;
use app\extensions\action\Pagination;
use lithium\util\String;
use MongoID;
use MongoDate;
use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

class AdminController extends \lithium\action\Controller {

	public function index() {
		if($this->__init()==false){			$this->redirect('ex::dashboard');	}
		if($this->request->data){
					$StartDate = new MongoDate(strtotime($this->request->data['StartDate']));
					$EndDate = new MongoDate(strtotime($this->request->data['EndDate']));			
		}else{
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30)));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
		}
		$mongodb = Connections::get('default')->connection;

		$UserRegistrations = Users::connection()->connection->command(array(
			'aggregate' => 'users',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'created' => '$created',
				)),
				array( '$match' => array( 'created'=> array( '$gte' => $StartDate, '$lte' => $EndDate ) ) ),
				array('$group' => array( '_id' => array(
						'year'=>array('$year' => '$created'),
						'month'=>array('$month' => '$created'),						
						'day'=>array('$dayOfMonth' => '$created'),												
				),
						'count' => array('$sum' => 1), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
					'_id.day'=>-1,					
//					'_id.hour'=>-1,					
				)),
			)
		));
		$TotalUserRegistrations = Users::connection()->connection->command(array(
			'aggregate' => 'users',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'created' => '$created',
				)),
				array('$group' => array( '_id' => array(
						'year'=>array('$year' => '$created'),
				),
						'count' => array('$sum' => 1), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
				)),
			)
		));

		$TotalOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action'=>'$Action',					
					'Amount'=>'$Amount',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'DateTime' => '$DateTime',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),
				)),
				array( '$match' => array( 'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ) ) ),
				array('$group' => array( '_id' => array(
					'Action'=>'$Action',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'year'=>array('$year' => '$DateTime'),
					'month'=>array('$month' => '$DateTime'),						
					'day'=>array('$dayOfMonth' => '$DateTime'),											
					),
					'Amount' => array('$sum' => '$Amount'), 
					'TotalAmount' => array('$sum' => '$TotalAmount'), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
					'_id.day'=>-1,										
				)),
			)
		));

		$YearTotalOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action'=>'$Action',					
					'Amount'=>'$Amount',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'DateTime' => '$DateTime',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),
				)),
				array('$group' => array( '_id' => array(
					'Action'=>'$Action',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'year'=>array('$year' => '$DateTime'),
					),
					'Amount' => array('$sum' => '$Amount'), 
					'TotalAmount' => array('$sum' => '$TotalAmount'), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
				)),
			)
		));


		$newYear = array();
		for($i=0;$i<=5;$i++){
			$date = gmdate('Y',mktime(0,0,0,1,1,2013)+$i*60*60*24*365);
			$newYear[$date] = array();
		}

	
		$new = array();
		
  	$days = ($EndDate->sec - $StartDate->sec)/(60*60*24);
		for($i=0;$i<=$days;$i++){
			$date = gmdate('Y-m-d',($EndDate->sec)-$i*60*60*24);
			$new[$date] = array();
		}

			foreach($TotalUserRegistrations['result'] as $UR){
				$URdate = date_create($UR['_id']['year']."-01-01");			
				$urDate = date_format($URdate,"Y");
					$newYear[$urDate] = array(
						'Register'=> $UR['count']
					);
			}

 
			foreach($UserRegistrations['result'] as $UR){
				$URdate = date_create($UR['_id']['year']."-".$UR['_id']['month']."-".$UR['_id']['day']);			
				$urDate = date_format($URdate,"Y-m-d");
					$new[$urDate] = array(
						'Register'=> $UR['count']
					);
			}

			foreach ($YearTotalOrders['result'] as $TO){
				$TOdate = date_create($TO['_id']['year']."-01-01");			
				$toDate = date_format($TOdate,"Y");				

						$newYear[$toDate][$TO['_id']['Action']][$TO['_id']['SecondCurrency']][$TO['_id']['Completed']] = array(
										'FirstCurrency' => $TO['_id']['FirstCurrency'],										
										'Amount' => $TO['Amount'],
										'TotalAmount' => $TO['TotalAmount'],										
						);

			}

			foreach ($TotalOrders['result'] as $TO){
				$TOdate = date_create($TO['_id']['year']."-".$TO['_id']['month']."-".$TO['_id']['day']);			
				$toDate = date_format($TOdate,"Y-m-d");				

						$new[$toDate][$TO['_id']['Action']][$TO['_id']['SecondCurrency']][$TO['_id']['Completed']] = array(
										'FirstCurrency' => $TO['_id']['FirstCurrency'],										
										'Amount' => $TO['Amount'],
										'TotalAmount' => $TO['TotalAmount'],										
						);

			}
			$title = "Admin";
			$keywords = "Admin, Index";
			$description = "Administer the site";

	return compact('new','newYear','StartDate','EndDate','title','keywords','description');
	}
	
	public function Approval() {
		if($this->__init()==false){			$this->redirect('ex::dashboard');	}
		if($this->request->data){
			$UserApproval = $this->request->data['UserApproval']	;
			$EmailSearch = $this->request->data['EmailSearch']	;	
			$UserSearch = $this->request->data['UserSearch']	;							
			$usernames = array();		
			if($EmailSearch!="" || $UserSearch!="" ){
				$user = Users::find('all',array(
					'conditions'=>array(
						'username'=>array('$regex'=>$UserSearch),
						'email'=>array('$regex'=>$EmailSearch),					
					)
				));
				foreach($user as $u){
					array_push($usernames,$u['username']);
				}
			}else{
					$user = Users::find('all',array('limit'=>100));
					foreach($user as $u){
						array_push($usernames,$u['username']);
					}
			}
			switch ($UserApproval) {
				case "All":
					$details = Details::find('all',array(
						'conditions'=>array('username'=>array('$in'=>$usernames))
					));
	//			print_r($usernames);				
					break;
				case "VEmail":
					$details = Details::find('all',array(
						'conditions'=>array(
						'email.verified'=>'Yes',
						'username'=>array('$in'=>$usernames)					
						)
					));
	
					break;
				case "VPhone":
					$details = Details::find('all',array(
						'conditions'=>array(
						'phone.verified'=>'Yes',
						'username'=>array('$in'=>$usernames)
						)
					));
	
					break;
				case "VBank":
					$details = Details::find('all',array(
						'conditions'=>array(
						'bank.verified'=>'Yes',
						'username'=>array('$in'=>$usernames)
						)
					));
				
					break;
				case "VGovernment":
					$details = Details::find('all',array(
						'conditions'=>array(
						'government.verified'=>'Yes',
						'username'=>array('$in'=>$usernames)
						)
					));
				
					break;
				case "VUtility":
					$details = Details::find('all',array(
						'conditions'=>array(
						'utility.verified'=>'Yes',
						'username'=>array('$in'=>$usernames)
						)
					));			
					break;
					
				case "NVEmail":
					$details = Details::find('all',array(
						'conditions'=>array(
						'email.verify'=>'Yes',
						'username'=>array('$in'=>$usernames))
					));
	
					break;
				case "NVPhone":
					$details = Details::find('all',array(
						'conditions'=>array(
						'phone.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames)
						)
					));
	
					break;
				case "NVBank":
					$details = Details::find('all',array(
						'conditions'=>array(
						'bank.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames)
						)
					));
	
					break;
				case "NVGovernment":
					$details = Details::find('all',array(
						'conditions'=>array(
						'government.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames)
						)
					));
	
					break;
				case "NVUtility":
					$details = Details::find('all',array(
						'conditions'=>array(
						'utility.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames)
						)
					));
				
					break;
					
				case "WVEmail":
					$details = Details::find('all',array(
						'conditions'=>array(
						'email.verified'=>array('$exists'=>false),
						'username'=>array('$in'=>$usernames)
						)
					));
				
					break;
				case "WVPhone":
					$details = Details::find('all',array(
						'conditions'=>array(
						'phone.verified'=>'No',
						'username'=>array('$in'=>$usernames)
						)
					));
	
					break;
				case "WVBank":
					$details = Details::find('all',array(
						'conditions'=>array(
						'bank.verified'=>'No',
						'username'=>array('$in'=>$usernames)
						)
					));
	
					break;
				case "WVGovernment":
					$details = Details::find('all',array(
						'conditions'=>array(
						'government.verified'=>'No',
						'username'=>array('$in'=>$usernames)
						)
					));
	
					break;
				case "WVUtility":
					$details = Details::find('all',array(
						'conditions'=>array(
						'utility.verified'=>'No',
						'username'=>array('$in'=>$usernames)
						)
					));
					break;
			}
			}else{
				$details = Details::find('all',array(
				'conditions'=>array(
					'$or'=>array(
						array('utility.verified'=>'No'),
						array('government.verified'=>'No'),
						array('bank.verified'=>'No'),
						array('utility.verified'=>''),
						array('government.verified'=>''),
						array('bank.verified'=>'')	
					)
					
				)
				));
			}
//		print_r(count($details));
$title = "Admin Approval";
$keywords = "Admin, Approval";
$description = "Admin panel for approval";


		return compact('UserApproval','details','title','keywords','description');
		
	}
	
	public function __init(){
		$user = Session::read('member');
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
//		print_r($user);
		if(str_replace("@","",strstr($user['email'],"@"))==COMPANY_URL 
			&& $details['email.verified']=="Yes"
			&& $details['TOTP.Validate'] == 1
			&& $details['TOTP.Login'] == 1
			&& ( 
				 MAIL_1==$user['email'] 
			|| MAIL_2==$user['email'] 
			|| MAIL_3==$user['email'] 	
			|| MAIL_4==$user['email'] 	
				 )
		){
			return true;
		}else{
			return false;
		}
	}
	
	public function Approve($media=null,$id=null,$response=null){
			if($this->__init()==false){$this->redirect('ex::dashboard');	}
			if($response!=""){
				if($response=="Approve"){
					$data = array(
						$media.".verified" => "Yes"
					);
				}elseif($response=="Reject"){
					$data = array(
						$media.".verified" => "No"
					);
				}
				$details = Details::find('first',array(
					'conditions'=>array(
						'_id'=>$id
					)
				))->save($data);
			}
			
			$details = Details::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			));

		$image_utility = File::find('first',array(
			'conditions'=>array('details_'.$media.'_id'=>(string)$details['_id'])
		));
		if($image_utility['filename']!=""){
				$imagename_utility = $image_utility['_id'].'_'.$image_utility['filename'];
				$path = LITHIUM_APP_PATH . '/webroot/documents/'.$imagename_utility;
				file_put_contents($path, $image_utility->file->getBytes());
		}
			$this->_render['layout'] = 'image';
$title = "Approve";
$keywords = "Approve, documents";
$description = "Admin Approve documents ";


			return compact('imagename_utility','media','id','title','keywords','description');
	}
	
	public function transactions(){
		if($this->__init()==false){$this->redirect('ex::dashboard');	}

		$Fiattransactions = Transactions::find('all',array(
			'conditions'=>array(
				'Currency'=>array('$ne'=>'BTC'),
				'Approved'=>'No',
				'Added'=>true
			),
			'order'=>array('DateTime'=>-1)
		));
		
		$Details = array();$i=0;
		foreach ($Fiattransactions as $ft){
		/////////////////////////////////////////////////////////////////////////////////////////////				
		  // Verified Bank from details
			$bankverified = Details::find('first',array(
				'conditions'=>array('username'=>$ft['username'])
			));
			$Details[$i]['BankVerified'] = $bankverified['bank.verified'];
			$Details[$i]['UtilityVerified'] = $bankverified['utility.verified'];			
			$Details[$i]['GovtVerified'] = $bankverified['government.verified'];			
		/////////////////////////////////////////////////////////////////////////////////////////////			
		/////////////////////////////////////////////////////////////////////////////////////////////			
			//Summary of all deposits / withdrawals for a user
		$mongodb = Connections::get('default')->connection;
		$UserFundsDeposits = Users::connection()->connection->command(array(
			'aggregate' => 'transactions',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'username' => '$username',
					'AmountApproved' => '$AmountApproved',					
					'Currency' => '$Currency',					
					'Approved'=>'$Approved',
					'Added'=>'$Added'
				)),
				array('$match'=>array(
					'username'=>$ft['username'],					
					'Currency'=>array('$ne'=>'BTC'),
					'Approved'=>'Yes',
					'Added'=>(boolean)true
					)),
				array('$group' => array( '_id' => array(
					'username' => '$username',
					'Currency' => '$Currency',					
				),
						'TotalDeposit' => array('$sum' => '$AmountApproved'), 
				)),
			)
		));
		$UserFundsWithdrawals = Users::connection()->connection->command(array(
			'aggregate' => 'transactions',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'username' => '$username',
					'AmountApproved' => '$AmountApproved',					
					'Currency' => '$Currency',					
					'Approved'=>'$Approved',
					'Added'=>'$Added'
				)),
				array('$match'=>array(
					'username'=>$ft['username'],					
					'Currency'=>array('$ne'=>'BTC'),
					'Approved'=>'Yes',
					'Added'=>(boolean)false
					)),
				array('$group' => array( '_id' => array(
					'username' => '$username',
					'Currency' => '$Currency',					
				),
						'TotalDeposit' => array('$sum' => '$AmountApproved'), 
				)),
			)
		));


/////////////////////////////////////////////////////////////////////////////////////////////
		foreach($UserFundsDeposits['result'] as $uf){
			if($uf['_id']['Currency']=='USD'){
				$Details[$i]['Funds']['USD'] = $uf['TotalDeposit'];										
			}
			if($uf['_id']['Currency']=='EUR'){
				$Details[$i]['Funds']['EUR'] = $uf['TotalDeposit'];					
			}
			if($uf['_id']['Currency']=='GBP'){
				$Details[$i]['Funds']['GBP'] = $uf['TotalDeposit'];					
			}
		}
		foreach($UserFundsWithdrawals['result'] as $uf){
			if($uf['_id']['Currency']=='USD'){
				$Details[$i]['FundsOut']['USD'] = $uf['TotalDeposit'];										
			}
			if($uf['_id']['Currency']=='EUR'){
				$Details[$i]['FundsOut']['EUR'] = $uf['TotalDeposit'];					
			}
			if($uf['_id']['Currency']=='GBP'){
				$Details[$i]['FundsOut']['GBP'] = $uf['TotalDeposit'];					
			}
		}
		
			$Previoustransactions = Transactions::find('all',array(
				'conditions'=>array(
					'Currency'=>array('$ne'=>'BTC'),
					'username'=>$ft['username']
				),
				'order'=>array('DateTime'=>-1),
				'limit'=>3
			));
			
			$Details[$i]['DateTime'] = $ft['DateTime'];	
			$Details[$i]['username'] = $ft['username'];				
			$Details[$i]['Reference'] = $ft['Reference'];	
			$Details[$i]['Amount'] = $ft['Amount'];	
			$Details[$i]['Currency'] = $ft['Currency'];	
			$Details[$i]['Added'] = $ft['Added'];													
			$Details[$i]['Approved'] = $ft['Approved'];										
			$Details[$i]['_id'] = $ft['_id'];													
			$j = 0;
			foreach($Previoustransactions as $pt){
				$Details[$i]['Previous'][$j]['Approved']	=		$pt['Approved'];
				$Details[$i]['Previous'][$j]['Amount']	=		$pt['Amount'];				
				$Details[$i]['Previous'][$j]['Currency']	=		$pt['Currency'];				
				$Details[$i]['Previous'][$j]['DateTime']	=		$pt['DateTime'];				
				$j++;
			}
			$i++;
		}
		$reasons = Reasons::find('all',array(
			'conditions'=>array('type'=>'Deposit'),
			'order'=>array('code'=>1)
		));		
		$title = "Transactions";
$keywords = "Transactions";
$description = "Admin panel for transactions";


		return compact('Details','reasons','title','keywords','description');
	}
	public function withdrawals(){
		if($this->__init()==false){$this->redirect('ex::dashboard');	}
		$Fiattransactions = Transactions::find('all',array(
			'conditions'=>array(
				'Currency'=>array('$ne'=>'BTC'),
				'Approved'=>'No',
				'Added'=>false
			),
			'order'=>array('DateTime'=>-1)
		));
		$Details = array();$i=0;
		foreach($Fiattransactions as $ft){
			$details = Details::find('first',array(
				'conditions'=>array('username'=>$ft['username'])
			));
			$Previoustransactions = Transactions::find('all',array(
				'conditions'=>array(
					'Currency'=>array('$ne'=>'BTC'),
					'username'=>$ft['username']
				),
				'order'=>array('DateTime'=>-1),
				'limit'=>3
			));
			
			$Details[$i]['GBP'] = $details['balance.GBP'];
			$Details[$i]['EUR'] = $details['balance.EUR'];			
			$Details[$i]['USD'] = $details['balance.USD'];			
			$Details[$i]['username'] = $details['username'];						
			$Details[$i]['TranDate'] = $ft['DateTime'];						
			$Details[$i]['Reference'] = $ft['Reference'];									
			$Details[$i]['Amount'] = $ft['Amount'];									
			$Details[$i]['Currency'] = $ft['Currency'];									
			$Details[$i]['Added'] = (string)$ft['Added'];												
			$Details[$i]['Approved'] = $ft['Approved'];									
			$Details[$i]['WithdrawalMethod'] = $ft['WithdrawalMethod'];
			$Details[$i]['WithdrawalCharges'] = $ft['WithdrawalCharges'];
			$Details[$i]['_id'] = $ft['_id'];							
			$j = 0;
			foreach($Previoustransactions as $pt){
				$Details[$i]['Previous'][$j]['Approved']	=		$pt['Approved'];
				$Details[$i]['Previous'][$j]['Amount']	=		$pt['Amount'];				
				$Details[$i]['Previous'][$j]['Currency']	=		$pt['Currency'];				
				$Details[$i]['Previous'][$j]['DateTime']	=		$pt['DateTime'];				
				$j++;
			}
			$i++;

		}
		$reasons = Reasons::find('all',array(
			'conditions'=>array('type'=>'Withdrawal'),
			'order'=>array('code'=>1)
		));
		$title = "Withdrawals";
$keywords = "Withdrawals, admin";
$description = "Admin panel for withdrawal";


		return compact('Fiattransactions','Details','reasons','title','keywords','description');
	}
	
	
	public function approvetransaction(){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}
	if($this->request->data){
		$Amount = $this->request->data['Amount'];
		$id = $this->request->data['id'];	
		$Currency = $this->request->data['Currency'];			

		$Authuser = Session::read('member');
		$AuthBy = $Authuser['username'];

		$data = array(
			'AmountApproved' => (float)$Amount,
			'Approved' => 'Yes',
			'ApprovedBy'=> $AuthBy,
			
		);
		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			))->save($data);
		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			));
		$databank = array(
			'bank.verified' => 'Yes'
		);
		$details = Details::find('all',array(
			'conditions'=>array(
				'username'=>$Transactions['username']
			)
		))->save($databank);

		$details = Details::find('first',array(
			'conditions'=>array(
				'username'=>$Transactions['username']
			)
		));

		$OriginalAmount = $details['balance.'.$Currency];
		$dataDetails = array(
					'balance.'.$Currency => (float)$OriginalAmount + (float)$Amount,
		);

		$detailsAdd = Details::find('all',array(
			'conditions'=>array(
				'username'=>$Transactions['username']
			)
		))->save($dataDetails);
		$user = Users::find('first',array(
			'conditions'=>array('_id'=>	new MongoID ($details['user_id']))
		));

		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$body = $view->render(
			'template',
			compact('Transactions','details','user'),
			array(
				'controller' => 'admin',
				'template'=>'approvetransaction',
				'type' => 'mail',
				'layout' => false
			)
		);	

		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance();
		$message->setSubject("Deposit Approved ".COMPANY_URL);
		$message->setFrom(array(NOREPLY => 'Deposit Approved '.COMPANY_URL));
		$message->setTo($user['email']);
		$message->addBcc(MAIL_1);
		$message->addBcc(MAIL_2);			
		$message->addBcc(MAIL_3);		

		$message->setBody($body,'text/html');
		
		$mailer->send($message);
		

	}
		$this->redirect('Admin::transactions');	
	}
	public function deletetransaction($id=null){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$Transactions = Transactions::remove('all',array(
		'conditions'=>array(
			'_id'=>new MongoID ($id)
		)
	));
		$this->redirect('Admin::transactions');	

	}	

	public function rejecttransaction($id=null,$reason=null){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$Authuser = Session::read('member');
		$AuthBy = $Authuser['username'];

		$reason = Reasons::find('first',array(
			'conditions'=>array('code'=>$reason),
		));

		$data = array(
			'Reason'=>$reason['reason'],
			'Approved' => 'Rejected',
			'ApprovedBy' => $AuthBy,
		);
		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			))->save($data);

		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			));
		$details = Details::find('first',array(
			'conditions'=>array(
				'username'=>$Transactions['username']
			)
		));
			$user = Users::find('first',array(
			'conditions'=>array('_id'=>	new MongoID ($details['user_id']))
		));

		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$body = $view->render(
			'template',
			compact('Transactions','details','user'),
			array(
				'controller' => 'admin',
				'template'=>'rejecttransaction',
				'type' => 'mail',
				'layout' => false
			)
		);	

		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance();
		$message->setSubject("Deposit Rejected ".COMPANY_URL.": ".$reason['reason']);
		$message->setFrom(array(NOREPLY => 'Deposit Rejected '.COMPANY_URL.": ".$reason['reason']));
		$message->setTo($user['email']);
		$message->addBcc(MAIL_1);
		$message->addBcc(MAIL_2);			
		$message->addBcc(MAIL_3);		

		$message->setBody($body,'text/html');
		
		$mailer->send($message);
		$this->redirect('Admin::transactions');	
	}

	public function sendemailtransaction($id=null){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$Authuser = Session::read('member');
		$AuthBy = $Authuser['username'];

		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			));
		$details = Details::find('first',array(
			'conditions'=>array(
				'username'=>$Transactions['username']
			)
		));
		$user = Users::find('first',array(
			'conditions'=>array('_id'=>	new MongoID ($details['user_id']))
		));

		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$body = $view->render(
			'template',
			compact('Transactions','details','user'),
			array(
				'controller' => 'admin',
				'template'=>'sendemailtransaction',
				'type' => 'mail',
				'layout' => false
			)
		);	

		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance();
		$message->setSubject("Deposit Approved ".COMPANY_URL.": Deposit funds now!");
		$message->setFrom(array(NOREPLY => 'Deposit Approved '.COMPANY_URL.": Deposit funds now!"));
		$message->setTo($user['email']);
		$message->addBcc(MAIL_1);
		$message->addBcc(MAIL_2);			
		$message->addBcc(MAIL_3);		

		$message->setBody($body,'text/html');
		
		$mailer->send($message);
		$this->redirect('Admin::transactions');	
	}
	
		public function approvewithdrawal(){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}
	if($this->request->data){
		$Amount = $this->request->data['Amount'];
		$WithdrawalCharges = $this->request->data['WithdrawalCharges'];
		$FinalWithdrawalCharges = $this->request->data['FinalWithdrawalCharges'];		
		$WithdrawalMethod = $this->request->data['WithdrawalMethod'];
		$id = $this->request->data['id'];	
		$Currency = $this->request->data['Currency'];			

		$Authuser = Session::read('member');
		$AuthBy = $Authuser['username'];

		$data = array(
			'AmountApproved' => (float)$Amount,
			'Approved' => 'Yes',
			'WithdrawalCharges' => $WithdrawalCharges,
			'WithdrawalChargesFinal' => $FinalWithdrawalCharges,			
			'WithdrawalMethod' => $WithdrawalMethod,			
			'ApprovedBy'=> $AuthBy,
			
		);
		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			))->save($data);
		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			));
		$details = Details::find('first',array(
			'conditions'=>array(
				'username'=>$Transactions['username']
			)
		));

		$OriginalAmount = $details['balance.'.$Currency];
		$dataDetails = array(
					'balance.'.$Currency => (float)$OriginalAmount - (float)$Amount,
		);

		$detailsAdd = Details::find('all',array(
			'conditions'=>array(
				'username'=>$Transactions['username']
			)
		))->save($dataDetails);
		$user = Users::find('first',array(
			'conditions'=>array('_id'=>	new MongoID ($details['user_id']))
		));

		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$body = $view->render(
			'template',
			compact('Transactions','details','user'),
			array(
				'controller' => 'admin',
				'template'=>'approvewithdrawal',
				'type' => 'mail',
				'layout' => false
			)
		);	

		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance();
		$message->setSubject("Withdrawal Approved ".COMPANY_URL);
		$message->setFrom(array(NOREPLY => 'Withdrawal Approved '.COMPANY_URL));
		$message->setTo($user['email']);
		$message->addBcc(MAIL_1);
		$message->addBcc(MAIL_2);			
		$message->addBcc(MAIL_3);		

		$message->setBody($body,'text/html');
		
		$mailer->send($message);

	}
		$this->redirect('Admin::withdrawals');	
	}

		public function deletewithdrawal($id=null){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$Transactions = Transactions::remove('all',array(
		'conditions'=>array(
			'_id'=>new MongoID ($id)
		)
	));
		$this->redirect('Admin::withdrawals');	
	}	

		public function rejectwithdrawal($id=null,$reason=null){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$Authuser = Session::read('member');
		$AuthBy = $Authuser['username'];

		$reason = Reasons::find('first',array(
			'conditions'=>array('code'=>$reason),
		));

		$data = array(
			'Reason'=>$reason['reason'],
			'Approved' => 'Rejected',
			'ApprovedBy' => $AuthBy,
		);
		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			))->save($data);

		$Transactions = Transactions::find('first',array(
				'conditions'=>array(
					'_id'=>$id
				)
			));
		$details = Details::find('first',array(
			'conditions'=>array(
				'username'=>$Transactions['username']
			)
		));
			$user = Users::find('first',array(
			'conditions'=>array('_id'=>	new MongoID ($details['user_id']))
		));

		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$body = $view->render(
			'template',
			compact('Transactions','details','user'),
			array(
				'controller' => 'admin',
				'template'=>'rejectwithdrawal',
				'type' => 'mail',
				'layout' => false
			)
		);	

		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance();
		$message->setSubject("Withdrawal Rejected ".COMPANY_URL.": ".$reason['reason']);
		$message->setFrom(array(NOREPLY => 'Withdrawal Rejected '.COMPANY_URL.": ".$reason['reason']));
		$message->setTo($user['email']);
		$message->addBcc(MAIL_1);
		$message->addBcc(MAIL_2);			
		$message->addBcc(MAIL_3);		

		$message->setBody($body,'text/html');
		
		$mailer->send($message);
		$this->redirect('Admin::withdrawals');	
	}
	public function user($page=1,$pagelength=20){
		if($this->__init()==false){$this->redirect('ex::dashboard');	}	
			
		$mongodb = Connections::get('default')->connection;
	  $pagination = new Pagination($mongodb, '/Admin/user/{{PAGE}}/');
		if($this->request->data){
			$itemsPerPage = $this->request->data['pagelength'];
		}else{
			$itemsPerPage = $pagelength;
		}
		$currentPage    = $page;
		$pagination->setQuery(array(
			'#collection'	=>  'details',
			'#find'		=>  array(),
			'#sort'		=>  array(
				'balance.BTC'	=>  -1
			),
		), $currentPage, $itemsPerPage);
		$details = $pagination->Paginate();
		$Details = array();$i = 0;
		foreach($details['dataset'] as $dt){
			$user = Users::find('first',array(
				'conditions'=>array('username'=>$dt['username'])
			));
			
		$mongodb = Connections::get('default')->connection;
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
					'No' => array('$sum'=>1)					
				)),
				array('$sort'=>array(
					'_id.Action'=>1,
				))
			)
		));

		$trades = Trades::find('all',array(
			'fields'=>array('trade')
		));

		foreach($YourOrders['result'] as $YO){
			foreach($trades as $trade){
				$FC = substr($trade['trade'],0,3);
				$SC = substr($trade['trade'],4,3);
				$CGroup = $FC.'-'.$SC;
				if($YO['_id']['Action']=='Buy' && $YO['_id']['FirstCurrency'] == $FC && $YO['_id']['SecondCurrency']==$SC){
					$Details[$i]['Buy'][$CGroup]['Amount'] = $YO['Amount'];
					$Details[$i]['Buy'][$CGroup]['TotalAmount'] = $YO['TotalAmount'];
				}				
				if($YO['_id']['Action']=='Sell' && $YO['_id']['FirstCurrency'] == $FC && $YO['_id']['SecondCurrency']==$SC){
					$Details[$i]['Sell'][$CGroup]['Amount'] = $YO['Amount'];
					$Details[$i]['Sell'][$CGroup]['TotalAmount'] = $YO['TotalAmount'];
				}
			}
		}

			foreach($trades as $trade){
				$FC = substr($trade['trade'],0,3);
				$SC = substr($trade['trade'],4,3);
				$Details[$i][$FC] = $dt['balance'][$FC];
				$Details[$i][$SC] = $dt['balance'][$SC];				
			}
			$Details[$i]['username'] = $user['username'];							
			$Details[$i]['firstname'] = $user['firstname'];							
			$Details[$i]['lastname'] = $user['lastname'];										
			$Details[$i]['email'] = $user['email'];													
			$Details[$i]['ip'] = $user['ip'];													
			$Details[$i]['created'] = $user['created'];													

			$i++;
		}

		$page_links = $pagination->getPageLinks();

		$title = "User";
		$TotalUsers = Users::count();
		$title = "Users";
$keywords = "Admin, Users";
$description = "Admin panel for users";


		return compact('title','users','page_links','TotalUsers','Details','title','keywords','description','pagelength');
		
	}
	
	public function bitcoin(){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$title = "Bitcoins";
		if($this->request->data){
			$transactions = Transactions::find('all',array(
				'conditions' => array('TransactionHash'=>$this->request->data['transactionhash'])
			));
		}
		$title = "Bitcoin transaction";
$keywords = "Bitcoin, Admin";
$description = "Admin panel for bitcoin transaction";


		return compact('title','transactions','title','keywords','description');
	}
	public function reverse($txhash = null, $username = null, $amount = null){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$Transactions = Transactions::remove('all',array(
			'conditions'=>array(
				'TransactionHash'=>$txhash
			)
		));

		$details = Details::find('first',array(
			'conditions'=>array(
				'username'=>$username
			)
		));

		$OriginalAmount = $details['balance.BTC'];
		$dataDetails = array(
					'balance.BTC' => (float)$OriginalAmount - (float)$amount,
		);

		$detailsAdd = Details::find('all',array(
			'conditions'=>array(
				'username'=>$username
			)
		))->save($dataDetails);
		
		$this->redirect('Admin::bitcoin');	
	}
	
	public function detail($username=null){
		if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$transactions = Transactions::find('all',array(
				'conditions'=>array(
					'username'=>$username,
					'Currency'=>'BTC'					
				),
			'order' => array('DateTime'=>'DESC')				
			));
		$transactionsLTC = Transactions::find('all',array(
				'conditions'=>array(
					'username'=>$username,
					'Currency'=>'LTC'					
				),
			'order' => array('DateTime'=>'DESC')				
			));
		$Fiattransactions = Transactions::find('all',array(
			'conditions'=>array(
			'username'=>$username,
			'Currency'=>array('$nin'=>array('BTC','LTC'))
			),
			'order'=>array('DateTime'=>-1)
		));
			
		$details = Details::find('all',array(
			'conditions'=>array(
				'username'=>$username
			)
		));
			$user = Users::find('all',array(
			'conditions'=>array(
			'username'=>$username
			)
		));

		$UserOrders = Orders::find('all',array(
			'conditions'=>array(
				'username'=>$username,
				'Completed'=>'N',
				),
			'order' => array('DateTime'=>-1)
		));
		$UserCompleteOrders = Orders::find('all',array(
			'conditions'=>array(
				'username'=>$username,
				'Completed'=>'Y',
				),
			'order' => array('DateTime'=>-1)
		));
		$title = "Detail user";
$keywords = "Admin, Detail user";
$description = "Admin Panel for user";

		
			return compact('title','transactions','transactionsLTC','details','user','UserOrders','Fiattransactions','UserCompleteOrders','title','keywords','description');
	}
	public function bankapprove($username = null){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		$data = array(
			'bank.verified' => 'Yes'
		);
		$details = Details::find('all',array(
			'conditions'=>array(
				'username'=>$username
			)
		))->save($data);
		
		$this->redirect('Admin::user');	
	}
	
	public function commission(){
	if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		if($this->request->data){
			$StartDate = new MongoDate(strtotime($this->request->data['StartDate']));
			$EndDate = new MongoDate(strtotime($this->request->data['EndDate']));			
		}else{
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30)));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
		}
	
		$mongodb = Connections::get('default')->connection;
		$Commissions = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action'=>'$Action',					
					'Amount'=>'$Amount',
					'Completed'=>'$Completed',					
					'CommissionAmount'=>'$Commission.Amount',
					'CommissionCurrency'=>'$Commission.Currency',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'DateTime' => '$DateTime',					
				)),
				array( '$match' => array( 
					'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ),
					'Completed'=>'Y',
					'username'=>array('$in'=>array('$regex'=>array('IBWTUser')))
					 )),
				array('$group' => array( '_id' => array(
					'CommissionCurrency'=>'$CommissionCurrency',					
					'year'=>array('$year' => '$DateTime'),
					'month'=>array('$month' => '$DateTime'),						
					'day'=>array('$dayOfMonth' => '$DateTime'),											
					),
					'CommissionAmount' => array('$sum' => '$CommissionAmount'), 
					'Transactions' => array('$sum'=>1),
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
					'_id.day'=>-1,										
				)),
				array('$limit'=>30)
			)
		));
		$new = array();
  	$days = ($EndDate->sec - $StartDate->sec)/(60*60*24);
		for($i=0;$i<=$days+1;$i++){
			$date = gmdate('Y-m-d',($EndDate->sec)-$i*60*60*24);
			$new[$date] = array();
		}
		foreach($Commissions['result'] as $UR){
			$URdate = date_create($UR['_id']['year']."-".$UR['_id']['month']."-".$UR['_id']['day']);			
			$urDate = date_format($URdate,"Y-m-d");
				$new[$urDate]['Transactions'] = $UR['Transactions'];

				if($UR['_id']['CommissionCurrency']=='BTC'){
					$new[$urDate]['BTC'] = $UR['CommissionAmount'];
				}
				if($UR['_id']['CommissionCurrency']=='LTC'){
					$new[$urDate]['LTC'] = $UR['CommissionAmount'];
				}
				if($UR['_id']['CommissionCurrency']=='GBP'){
					$new[$urDate]['GBP'] = $UR['CommissionAmount'];				
				}
				if($UR['_id']['CommissionCurrency']=='EUR'){
					$new[$urDate]['EUR'] = $UR['CommissionAmount'];				
				}
				if($UR['_id']['CommissionCurrency']=='USD'){
					$new[$urDate]['USD'] = $UR['CommissionAmount'];				
				}
		}
		
$title = "Commission";
$keywords = "Admin Commission";
$description = "Admin panel for commission";


	return compact(	'new','StartDate','EndDate','title','keywords','description')	;
	}
	public function bitcointransaction(){
		if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		if($this->request->data){
			$StartDate = new MongoDate(strtotime($this->request->data['StartDate']));
			$EndDate = new MongoDate(strtotime($this->request->data['EndDate']));			
		}else{
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30)));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
		}
		
		$transactions = Transactions::find('all',array(
			'conditions'=>array(
				'Currency'=>'BTC',
				'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ) ,			
				),
			'order'=>array('DateTime'=>-1)
		));
$title = "Bitcoin Transactions";
$keywords = "Bitcoin Transactions";
$description = "Admin panel for bitcoin transactions";
		

		return compact(	'transactions','StartDate','EndDate','title','keywords','description')	;
		
	}
	public function litecointransaction(){
		if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		if($this->request->data){
			$StartDate = new MongoDate(strtotime($this->request->data['StartDate']));
			$EndDate = new MongoDate(strtotime($this->request->data['EndDate']));			
		}else{
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30)));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
		}
		
		$transactions = Transactions::find('all',array(
			'conditions'=>array(
				'Currency'=>'LTC',
				'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ) ,			
				),
			'order'=>array('DateTime'=>-1)
		));
$title = "Litecoin Transactions";
$keywords = "Litecoin Transactions";
$description = "Admin panel for Litecoin transactions";
		

		return compact(	'transactions','StartDate','EndDate','title','keywords','description')	;
		
	}
	
	public function orders(){
		if($this->__init()==false){$this->redirect('ex::dashboard');	}	
		if($this->request->data){
			$StartDate = new MongoDate(strtotime($this->request->data['StartDate']));
			$EndDate = new MongoDate(strtotime($this->request->data['EndDate']));			
		}else{
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30)));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
		}
		
		$Orders = Orders::find('all',array(
			'conditions'=>array(
				'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ) ,			
				),
			'order'=>array('DateTime'=>-1)
		));
$title = "Orders";
$keywords = "Orders";
$description = "Admin panel for Orders";
		

		return compact(	'Orders','StartDate','EndDate','title','keywords','description')	;
	
	}
	public function api(){
		if($this->__init()==false){$this->redirect('ex::dashboard');	}		
		if($this->request->data){
			$StartDate = new MongoDate(strtotime($this->request->data['StartDate']));
			$EndDate = new MongoDate(strtotime($this->request->data['EndDate']));			
		}else{
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*2)));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
		}
		$mongodb = Connections::get('default')->connection;

		$Requests = Requests::connection()->connection->command(array(
			'aggregate' => 'requests',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'DateTime' => '$DateTime',
					'API' => '$API',
					'username' => '$username',					
					'IP' => '$IP',					
					'nounce' => '$nounce',					
				)),
				array( '$match' => array( 'DateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate ) ) ),
				array('$group' => array( '_id' => array(
						'year'=>array('$year' => '$DateTime'),
						'month'=>array('$month' => '$DateTime'),						
						'day'=>array('$dayOfMonth' => '$DateTime'),												
						'username'=>'$username',
						'IP'=>'$IP',
						'API'=>'$API'
				),
						'count' => array('$sum' => 1), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
					'_id.day'=>-1,
					'_id.username'=>1,
					'_id.API'=>1
				)),
			)
		));
		$new = array();
		
  	$days = ($EndDate->sec - $StartDate->sec)/(60*60*24);
		for($i=0;$i<=$days;$i++){
			$date = gmdate('Y-m-d',($EndDate->sec)-$i*60*60*24);
			$new[$date] = array();
		}

		foreach($Requests['result'] as $rq){
				$RQdate = date_create($rq['_id']['year']."-".$rq['_id']['month']."-".$rq['_id']['day']);			
				$RQDate = date_format($RQdate,"Y-m-d");
					$new[$RQDate][$rq['_id']['username']][$rq['_id']['API']][$rq['_id']['IP']] = array(
						'Request'=>$rq['count'],
					);
		}
		return compact('new')		;		
	}
	public function play(){
		$details = Details::find('all',array(
			'conditions'=>array(
				'username'=>array('$regex'=>'IBWTUser'),
			)
		));
		$trades = Trades::find('all');
		return compact('details','trades');
	}
}
?>