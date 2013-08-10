<?php
namespace app\controllers;

use app\extensions\action\OAuth2;
use app\models\Users;
use app\models\Details;
use lithium\data\Connections;
use app\extensions\action\Functions;

use lithium\security\Auth;
use lithium\storage\Session;
use app\extensions\action\Smslane;
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
			$this->redirect('Users::email');	
			
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
			$message->setSubject("Verification of email from BitcoinVerified");
			$message->setFrom(array('no-reply@rbitco.in' => 'Verification email BitcoinVerified'));
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
	//				print_r(empty($details));exit;
				}else{
					return compact('id');				
	//				print_r(empty($details));exit;				
				}
				
			}else{return $this->redirect('Users::email');}

	}
	
	public function settings(){
		
	
	}
}
?>