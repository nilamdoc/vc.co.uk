<?php
namespace app\controllers;

use app\extensions\action\OAuth2;
use app\models\Users;
use app\models\Details;
use app\models\File;
use lithium\data\Connections;
use app\extensions\action\Functions;

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
			
			$oauth = new OAuth2();
			$key_secret = $oauth->request_token();

			$data = array(
				'user_id'=>(string)$user->_id,
				'username'=>(string)$user->username,
				'email.verify' => $verification,
				'key'=>$key_secret['key'],
				'secret'=>$key_secret['secret'],
				'friends'=>array(),
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
				$data = array(
					$option => $this->request->data['file'],
					$option.'title'=>$this->request->data['title']
				);
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
		if($TOTP!=1){
			$secret = $ga->createSecret(64);
			$data = array(
				'secret' => $secret
			);
			$details = Details::find('first',
				array('conditions'=>array('user_id'=> (string) $id))
			)->save($data);
			$details = Details::find('first',
				array('conditions'=>array('user_id'=> (string) $id))
			);		
		}else{
			$secret = $details['secret'];
		}
		$qrCodeUrl = $ga->getQRCodeGoogleUrl("IBWT-".$details['username'], $secret);
		return compact('details','user','title','qrCodeUrl','secret','option');
	}
	
	
	
	public function ga(){
		$ga = new GoogleAuthenticator();
		
		$secret = $ga->createSecret(64);
//		$secret = '547e9701d8fb7e6556fc8acbfa063811620af8d78';
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
				'TOTP.Validate'=>true,
				'TOTP.Login'=>$login,				
				'TOTP.Withdrawal'=>$withdrawal,				
				'TOTP.Security'=>$security,				
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
	
}
?>