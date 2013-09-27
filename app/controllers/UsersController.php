<?php
namespace app\controllers;

use app\extensions\action\OAuth2;
use app\models\Users;
use app\models\Details;
use app\models\Transactions;
use app\models\Parameters;
use app\models\File;
use lithium\data\Connections;
use app\extensions\action\Functions;

use app\extensions\action\Bitcoin;
use lithium\security\Auth;
use lithium\storage\Session;
use app\extensions\action\GoogleAuthenticator;
use lithium\util\String;
use MongoID;

use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

class UsersController extends \lithium\action\Controller {

	public function index(){
	}
	public function signup() {	
		$user = Users::create();
		if(($this->request->data) && $user->save($this->request->data)) {	
			$verification = sha1($user->_id);

			$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
			$bitcoinaddress = $bitcoin->getaccountaddress($this->request->data['username']);

			
//			$oauth = new OAuth2();
//			$key_secret = $oauth->request_token();
			$ga = new GoogleAuthenticator();
			
			$data = array(
				'user_id'=>(string)$user->_id,
				'username'=>(string)$user->username,
				'email.verify' => $verification,
				'mobile.verified' => "No",				
				'mobile.number' => "",								
				'key'=>$ga->createSecret(64),
				'secret'=>$ga->createSecret(64),
				'Friend'=>array(),
				'bitcoinaddress.0'=>$bitcoinaddress,
				'balance.BTC' => (float)0,
				'balance.LTC' => (float)0,				
				'balance.USD' => (float)0,				
				'balance.EUR' => (float)0,
				'balance.GBP' => (float)0,				
			);
			Details::create()->save($data);

			$email = $this->request->data['email'];
			$name = $this->request->data['firstname'];
			
			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$body = $view->render(
				'template',
				compact('email','verification','name'),
				array(
					'controller' => 'users',
					'template'=>'confirm',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("Verification of email from ".COMPANY_URL);
			$message->setFrom(array(NOREPLY => 'Verification email '.COMPANY_URL));
			$message->setTo($user->email);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		

			$message->setBody($body,'text/html');
			
			$mailer->send($message);
			$this->redirect('Users::email');	
			
		}
			
	}
	public function email(){
		$user = Session::read('member');
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);

		if(isset($details['email']['verified'])){
			$msg = "Your email is verified.";
		}else{
			$msg = "Your email is <strong>not</strong> verified. Please check your email to verify.";
			
		}
		$title = "Email verification";
		return compact('msg','title');
	}
	
	public function confirm($email=null,$verify=null){
		if($email == "" || $verify==""){
			if($this->request->data){
				if($this->request->data['email']=="" || $this->request->data['verified']==""){
					return $this->redirect('Users::email');
				}
				$email = $this->request->data['email'];
				$verify = $this->request->data['verified'];
			}else{return $this->redirect('Users::email');}
		}
		$finduser = Users::first(array(
			'conditions'=>array(
				'email' => $email,
			)
		));

		$id = (string) $finduser['_id'];
			if($id!=null){
				$data = array('email.verified'=>'Yes');
				Details::create();
				$details = Details::find('all',array(
					'conditions'=>array('user_id'=>$id,'email.verify'=>$verify)
				))->save($data);

				if(empty($details)==1){
					return $this->redirect('Users::email');
				}else{
					return $this->redirect('ex::dashboard');
				}
			}else{return $this->redirect('Users::email');}

	}
	
	public function mobile(){
		$title = "Mobile";
	
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];
		if ($this->request->data) {
			$data = array(
				"mobile.number" => $this->request->data['mobile'],
				"mobile.verified" =>	 "No",				
			);
			$details = Details::find('all',
				array('conditions'=>array('user_id'=> (string) $id))
			)->save($data);
		}
	return $this->redirect('Users::settings');
	}


	public function settings($option=null){
		
		$title = "User settings";
		$ga = new GoogleAuthenticator();
		
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		
		if ($this->request->data) {
				$option = $this->request->data['option'];
				$data = array(
					$option => $this->request->data['file'],
					$option.'.verified'=>'No',
				);
				$field = 'details_'.$option.'_id';
				$remove = File::remove('all',array(
					'conditions'=>array( $field => (string) $details->_id)
				));

				$fileData = array(
						'file' => $this->request->data['file'],
						'details_'.$option.'_id' => (string) $details->_id
				);
				
				$details = Details::find('first',
					array('conditions'=>array('user_id'=> (string) $id))
				)->save($data);
				$file = File::create();
				if ($file->save($fileData)) {
						$this->redirect('ex::dashboard');
				}
		}

		$TOTP = $details['TOTP.Validate'];
		$secret = $details['secret'];

		$qrCodeUrl = $ga->getQRCodeGoogleUrl("IBWT-".$details['username'], $secret);
		
		
		$image_utility = File::find('first',array(
			'conditions'=>array('details_utility_id'=>(string)$details['_id'])
		));
		if($image_utility['filename']!=""){
				$imagename_utility = $image_utility['_id'].'_'.$image_utility['filename'];
					$path = LITHIUM_APP_PATH . '/webroot/documents/'.$imagename_utility;
				file_put_contents($path, $image_utility->file->getBytes());
		}

		$image_government = File::find('first',array(
			'conditions'=>array('details_government_id'=>(string)$details['_id'])
		));

		if($image_government['filename']!=""){
				$imagename_government = $image_government['_id'].'_'.$image_government['filename'];
				$path = LITHIUM_APP_PATH . '/webroot/documents/'.$imagename_government;
				file_put_contents($path, $image_government->file->getBytes());
		}		

			$details = Details::find('first',
				array('conditions'=>array('user_id'=> (string) $id))
			);		

		return compact('details','user','title','qrCodeUrl','secret','option','imagename_utility','imagename_government');
	}
	
	
	
	public function ga(){
		$ga = new GoogleAuthenticator();
		
		$secret = $ga->createSecret(64);
		$secret = 'X6SWH7LNHWG3MBGNTWMJ53VPQ7IYWI6YSDYRZ6XYXWYS5KWZ4JFG7J6TM2P77AKX';
		echo "Secret is: ".$secret."\n\n";
		
		$qrCodeUrl = $ga->getQRCodeGoogleUrl("ABCD", $secret);
		echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."\n\n";
		
		
		$oneCode = $ga->getCode($secret);
		echo "Checking Code '$oneCode' and Secret '$secret':\n";
		
		$checkResult = $ga->verifyCode($secret, $oneCode, 2); // 2 = 2*30sec clock tolerance
		if ($checkResult) {
			echo 'OK';
		} else {
			echo 'FAILED';
		}
	}
	
	public function SendPassword($username=""){
		$users = Users::find('first',array(
					'conditions'=>array('username'=>$username)
				));
		$id = (string)$users['_id'];
		$ga = new GoogleAuthenticator();
		$secret = $ga->createSecret(64);
		$oneCode = $ga->getCode($secret);	
		$data = array(
			'oneCode' => $oneCode
		);
		$details = Details::find('first',array(
					'conditions'=>array('username'=>$username,'user_id'=>(string)$id)
		))->save($data);
		$details = Details::find('first',array(
					'conditions'=>array('username'=>$username,'user_id'=>(string)$id)
		));
		$totp = "No";

		if($details['TOTP.Validate']==true && $details['TOTP.Login']==true){
			$totp = "Yes";
		}
		
		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$email = $users['email'];
			$body = $view->render(
				'template',
				compact('users','oneCode','username'),
				array(
					'controller' => 'users',
					'template'=>'onecode',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("Sign in password for ".COMPANY_URL);
			$message->setFrom(array(NOREPLY => 'Sign in password from '.COMPANY_URL));
			$message->setTo($email);
			$message->setBody($body,'text/html');
			$mailer->send($message);
			return $this->render(array('json' => array("Password"=>"Password sent to email","TOTP"=>$totp)));
	}
	public function SaveTOTP(){
		$user = Session::read('default');
		if ($user==""){return $this->render(array('json' => false));}
		$id = $user['_id'];
	
		$login = $this->request->query['Login'];
		$withdrawal = $this->request->query['Withdrawal'];		
		$security = $this->request->query['Security'];		
		$ScannedCode = $this->request->query['ScannedCode'];		

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$ga = new GoogleAuthenticator();
		$checkResult = $ga->verifyCode($details['secret'], $ScannedCode, 2);

		if ($checkResult==1) {
			$data = array(
				'TOTP.Validate'=>(boolean)true,
				'TOTP.Login'=> (boolean)$login,				
				'TOTP.Withdrawal'=>(boolean)$withdrawal,				
				'TOTP.Security'=>(boolean)$security,				
			);
			$details = Details::find('first',
				array('conditions'=>array('user_id'=> (string) $id))
			)->save($data);
			return $this->render(array('json' => true));
		} else {
			return $this->render(array('json' => false));
		}
//		return $this->render(array('json' => false));
	}
	public function CheckTOTP(){
		$user = Session::read('default');
		if ($user==""){return $this->render(array('json' => false));}
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);

		$CheckCode = $this->request->query['CheckCode'];		
		$ga = new GoogleAuthenticator();
		$checkResult = $ga->verifyCode($details['secret'], $CheckCode, 2);		
		if ($checkResult) {
			$data = array(
				'TOTP.Validate'=>false,
				'TOTP.Security'=>false,				
			);
			$details = Details::find('first',
				array('conditions'=>array('user_id'=> (string) $id))
			)->save($data);
			return $this->render(array('json' => true));
		}else{
			return $this->render(array('json' => false));
		}
	}
	public function DeleteTOTP(){

		return $this->render(array('json' => ""));
	}
	public function forgotpassword(){
		if($this->request->data){
			$user = Users::find('first',array(
				'conditions' => array(
					'email' => $this->request->data['email']
				),
				'fields' => array('_id')
			));
//		print_r($user['_id']);
			$details = Details::find('first', array(
				'conditions' => array(
					'user_id' => (string)$user['_id']
				),
				'fields' => array('key')
			));
//					print_r($details['key']);exit;
		$key = $details['key'];
		if($key!=""){
		$email = $this->request->data['email'];
			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$body = $view->render(
				'template',
				compact('email','key'),
				array(
					'controller' => 'users',
					'template'=>'forgot',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("Password reset link from ".COMPANY_URL);
			$message->setFrom(array(NOREPLY => 'Password reset email '.COMPANY_URL));
			$message->setTo($user->email);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		

			$message->setBody($body,'text/html');
			$mailer->send($message);
			}
		}
	}

	public function addbank(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		$user_id = $user['_id'];
		$details = Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			));		
		$title = "Add bank";
			
		return compact('details','title');
	}
	public function changepassword($key=null){
		if($key==null){	return $this->redirect('login');}
		return compact('key');
	}
	public function password(){
		if($this->request->data){

			$details = Details::find('first', array(
				'conditions' => array(
					'key' => $this->request->data['key']
				),
				'fields' => array('user_id')
			));
			$msg = "Password Not Changed!";
//			print_r($details['user_id']);
			if($details['user_id']!=""){
						if($this->request->data['password'] == $this->request->data['password2']){
//					print_r($this->request->data['password']);
					$user = Users::find('first', array(
						'conditions' => array(
							'_id' => $details['user_id'],
							'password' => String::hash($this->request->data['oldpassword']),
						)
					));

					$data = array(
						'password' => String::hash($this->request->data['password']),
					);
//					print_r($data);
					$user = Users::find('all', array(
						'conditions' => array(
							'_id' => $details['user_id'],
							'password' => String::hash($this->request->data['oldpassword']),
						)
					))->save($data,array('validate' => false));
					
					if($user){
						$msg = "Password changed!";
					}

				}else{
					$msg = "New password does not match!";
				}
			}
		}

	return compact('msg');
	}
	public function funding(){
				$title = "Funding";

		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$secret = $details['secret'];
		$userid = $details['user_id'];		
		$my_address = BITCOIN_ADDRESS;
		$callback_url = 'https://'.COMPANY_URL.'/users/receipt/?userid='.$userid.'&secret='.$secret;
		$root_url = 'https://blockchain.info/api/receive';
		$parameters = 'method=create&address=' . $my_address .'&shared=false&callback='. urlencode($callback_url);
		$response = file_get_contents($root_url . '?' . $parameters);
		$object = json_decode($response);
//		print_r($object);
		$address = $object->input_address;
		$paytxfee = Parameters::find('first');
		$txfee = $paytxfee['paytxfee'];
		$transactions = Transactions::find('all',array(
				'conditions'=>array(
				'username'=>$user['username'],
				'Added'=>false,
				'Approved'=>'No'
				)
		));
			return compact('details','address','txfee','title','transactions')	;
	}
	public function receipt(){
		$secret = $_GET['secret'];;
		$userid = $_GET['userid']; //invoice_id is past back to the callback URL
		$transaction_hash = $_GET['transaction_hash'];
		$input_transaction_hash = $_GET['input_transaction_hash'];
		$input_address = $_GET['input_address'];
		$value_in_satoshi = $_GET['value'];
		$value_in_btc = $value_in_satoshi / 100000000;	
		$details = Details::find('first',
			array(
					'conditions'=>array(
						'user_id'=>$userid,
						'secret'=>$secret)
				));
				if(count($details)!=0){
					$tx = Transactions::create();
					$data = array(
						'DateTime' => new \MongoDate(),
						'TransactionHash' => $transaction_hash,
						'username' => $details['username'],
						'address'=>$input_address,							
						'Amount'=> (float)number_format($value_in_btc,8),
						'Currency'=> 'BTC',						
						'Added'=>true,
					);							
					$tx->save($data);
				
				$dataDetails = array(
						'balance.BTC' => (float)number_format((float)$details['balance.BTC'] + (float)$value_in_btc,8),
					);
							$details = Details::find('all',
								array(
										'conditions'=>array(
											'user_id'=>$userid,
											'secret'=>$secret
										)
									))->save($dataDetails);
				}
			return $this->render(array('layout' => false));	
	}
	
	public function payment(){
			$title = "Payment";

		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		
		if ($this->request->data) {
			$guid=BITCOIN_GUID;
			$firstpassword=BITCOIN_FIRST;
			$secondpassword=BITCOIN_SECOND;
			$amount = $this->request->data['amount'];
			$fee = $this->request->data['txFee'];
			$address = $this->request->data['bitcoinaddress'];
			$satoshi = (float)$amount * 100000000;
			$fee_satoshi = (float)$fee * 100000000;
			$json_url = "http://blockchain.info/merchant/$guid/payment?password=$firstpassword&second_password=$secondpassword&to=$address&amount=$satoshi&fee=$fee_satoshi";
			$json_data = file_get_contents($json_url);
			$json_feed = json_decode($json_data);
			$message = $json_feed->message;
			$txid = $json_feed->tx_hash;

			$tx = Transactions::create();
			$data = array(
					'DateTime' => new \MongoDate(),
					'TransactionHash' => $txid,
					'username' => $details['username'],
					'address'=>$address,							
					'Amount'=> (float) -$amount,
					'Currency'=> 'BTC',					
					'txFee' => (float) -$fee,
					'Added'=>false,
					'Transfer'=>$message,
				);							
				$tx->save($data);
				$dataDetails = array(
						'balance.BTC' => (float)number_format($details['balance.BTC'] - (float)$amount - (float)$fee,8),
					);
						
				$details = Details::find('all',
					array(
							'conditions'=>array(
								'user_id'=> (string) $id
							)
						))->save($dataDetails);

			return compact('message','txid','json_url','json_feed','title');
		
		}
	}
	
	public function transactions(){
		$title = "Transactions";

		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$transactions = Transactions::find('all',array(
			'conditions'=>array(
			'username'=>$details['username'],
			'Currency'=>'BTC'
			),
			'order'=>array('DateTime'=>-1)
		));
		$Fiattransactions = Transactions::find('all',array(
			'conditions'=>array(
			'username'=>$details['username'],
			'Currency'=>array('$ne'=>'BTC')
			),
			'order'=>array('DateTime'=>-1)
		));
		return compact('title','details','transactions','Fiattransactions');			
	}
	
	public function deposit(){
		$title = "Deposit";
	
		$user = Session::read('default');

		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$amountFiat = $this->request->data['AmountFiat'];
		$Currency = $this->request->data['Currency']; 
		$Reference = $this->request->data['Reference']; 		
		$data = array(
				'DateTime' => new \MongoDate(),
				'username' => $details['username'],
				'Amount'=> (float)$amountFiat,
				'Currency'=> $Currency,					
				'Added'=>true,
				'Reference'=>$Reference,
				'Approved'=>'No'
		);
		$tx = Transactions::create();
		$tx->save($data);

		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$body = $view->render(
			'template',
			compact('details','data','user'),
			array(
				'controller' => 'users',
				'template'=>'deposit',
				'type' => 'mail',
				'layout' => false
			)
		);	

		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance();
		$message->setSubject("Deposit to ".COMPANY_URL);
		$message->setFrom(array(NOREPLY => 'Deposit to '.COMPANY_URL));
		$message->setTo($user['email']);
		$message->addBcc(MAIL_1);
		$message->addBcc(MAIL_2);			
		$message->addBcc(MAIL_3);		

		$message->setBody($body,'text/html');
		
		$mailer->send($message);



		return compact('title','details','data','user');			
	}
	
	public function withdraw(){
		$title = "Withdraw";
	
		$user = Session::read('default');

		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$AccountName = $this->request->data['AccountName'];
		$SortCode = $this->request->data['SortCode'];
		$AccountNumber = $this->request->data['AccountNumber'];		
		$amountFiat = $this->request->data['WithdrawAmountFiat'];
		$Currency = $this->request->data['WithdrawCurrency']; 
		$Reference = $this->request->data['WithdrawReference']; 		
		$data = array(
				'DateTime' => new \MongoDate(),
				'username' => $details['username'],
				'Amount'=> (float)$amountFiat,
				'Currency'=> $Currency,					
				'Added'=>false,
				'Reference'=>$Reference,
				'AccountName'=>$AccountName,
				'SortCode'=>$SortCode,
				'AccountNumber'=>$AccountNumber,
				'Approved'=>'No'
		);
		$tx = Transactions::create();
		$tx->save($data);

		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$body = $view->render(
			'template',
			compact('details','data','user'),
			array(
				'controller' => 'users',
				'template'=>'withdraw',
				'type' => 'mail',
				'layout' => false
			)
		);	

		$transport = Swift_MailTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance();
		$message->setSubject("Withdraw from ".COMPANY_URL);
		$message->setFrom(array(NOREPLY => 'Withdraw from '.COMPANY_URL));
		$message->setTo($user['email']);
		$message->addBcc(MAIL_1);
		$message->addBcc(MAIL_2);			
		$message->addBcc(MAIL_3);		

		$message->setBody($body,'text/html');
		
		$mailer->send($message);

		return compact('title','details','data','user');			
	
	}
	
		public function addbankdetails(){
		$user = Session::read('default');
		$user_id = $user['_id'];
		$data = array();
		if($this->request->data) {	
			$data['bank'] = $this->request->data;
			$data['bank']['id'] = new MongoID;
			$data['bank']['verified'] = 'No';
			Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			))->save($data);
		}
		return $this->redirect('Users::settings');
	}

	public function deleteaccount(){}
}
?>