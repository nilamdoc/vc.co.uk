<?php
namespace app\controllers;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Transactions;
use app\models\Parameters;
use app\models\Reasons;
use app\models\File;
use app\models\Trades;
use app\models\Orders;
use app\models\Requests;
use lithium\security\Auth;
use lithium\data\Connections;
use app\extensions\action\GoogleAuthenticator;
use lithium\util\String;
use MongoID;
use MongoDate;
use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

class ATMController extends \lithium\action\Controller {
	public function index(){
		$noauth = false;
		Session::delete('default');				
		return $this->render(array('layout' => 'atm'));
	}
	public function CheckATM($mobile=null,$totp=null){
	
	$details = Details::find('first',array(
		'conditions' => array(
			'mobile.number' => $mobile
		)
	));
	$user = Users::find('first',array(
		'conditions' => array(
			'_id' => $details['user_id']
		)
	));

	$data = array(
		'username' => $user['username'],
		'firstname'=> $user['firstname'],
		'lastname'=> $user['lastname'],
		'email'=>$user['email'],
		'user_id'=>$user['_id']
	)	;

						if($details["TOTP.Validate"]==1 && $details["TOTP.Login"]==true){
							$ga = new GoogleAuthenticator();
							if($totp==""){
								Session::delete('default');
								return $this->render(array('json' => array("TOTP"=>false)));
								exit;
							}else{
								$checkResult = $ga->verifyCode($details['secret'], $totp, 2);		
								if ($checkResult==1) {
									Session::write('default',$data);
//									$user = Session::read('default');
									return $this->render(array('json' => array("TOTP"=>true)));
									exit;
								}else{
									Session::delete('default');
									return $this->render(array('json' => array("TOTP"=>false)));
									exit;
								}
							}
					}else{
						Session::delete('default');
						return $this->render(array('json' => array("TOTP"=>false)));
						exit;
					}
			return $this->render(array('json' => array("TOTP"=>false)));
	}
	public function dashboard(){
		$this->_render['layout'] = 'atm';
		$user = Session::read('default');
		$id = $user['user_id'];
		if ($user==""){		return $this->redirect('ATM/index');}		
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>(string)$id))
		);

		return compact('user','details');
	}
	
	public function deposit($currency=null){
			$this->_render['layout'] = 'atm';
		$this->_render['layout'] = 'atm';
		$user = Session::read('default');
		$id = $user['user_id'];
		if ($user==""){		return $this->redirect('ATM/index');}		
	}

	public function withdraw($currency=null){
			$this->_render['layout'] = 'atm';
		$this->_render['layout'] = 'atm';
		$user = Session::read('default');
		$id = $user['user_id'];
		if ($user==""){		return $this->redirect('ATM/index');}		
	
	}
}
?>