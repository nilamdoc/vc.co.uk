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
use app\extensions\action\Bitcoin;
use app\extensions\action\Litecoin;

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
		$verified = false;
		if($details['email.verified']=='Yes'){$verified = true;}
		if($details['bank.verified']=='Yes'){$verified = true;}
		if($details['government.verified']=='Yes'){$verified = true;}		
		if($details['utility.verified']=='Yes'){$verified = true;}
		return compact('user','details','verified');
	}
	
	public function deposit_BTC($currency=null){
		$this->_render['layout'] = 'atm';
		$user = Session::read('default');
		$id = $user['user_id'];
		if ($user==""){		return $this->redirect('ATM/index');}		
		
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
		$laddress = 'LADDRESS';				
		$paytxfee = Parameters::find('first');
		$txfee = $paytxfee['paytxfee'];
		$transactions = Transactions::find('all',array(
				'conditions'=>array(
				'username'=>$user['username'],
				'Added'=>false,
				'Approved'=>'No'
				)
		));
			return compact('details','address','txfee','title','transactions','laddress')	;
	}

	public function withdraw_BTC($currency=null){
		$this->_render['layout'] = 'atm';
		$user = Session::read('default');
		$id = $user['user_id'];
		if ($user==""){		return $this->redirect('ATM/index');}		
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$paytxfee = Parameters::find('first');
		$txfee = $paytxfee['paytxfee'];
			return compact('details','txfee')	;
	
	}
	
	public function deposit_LTC(){
		$this->_render['layout'] = 'atm';
		$user = Session::read('default');
		$id = $user['user_id'];
		if ($user==""){		return $this->redirect('ATM/index');}		
		$id = $user['_id'];
		$litecoin = new Litecoin('http://'.LITECOIN_WALLET_SERVER.':'.LITECOIN_WALLET_PORT,LITECOIN_WALLET_USERNAME,LITECOIN_WALLET_PASSWORD);
		$address = $litecoin->getnewaddress($user['username']);

		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$secret = $details['secret'];
		$userid = $details['user_id'];		
		$paytxfee = Parameters::find('first');
		$txfee = $paytxfee['payltctxfee'];
		$transactions = Transactions::find('all',array(
				'conditions'=>array(
				'username'=>$user['username'],
				'Added'=>false,
				'Approved'=>'No'
				)
		));
			return compact('details','address','txfee','title','transactions')	;

	}

	public function withdraw_LTC(){
		$this->_render['layout'] = 'atm';
		$user = Session::read('default');
		$id = $user['user_id'];
		if ($user==""){		return $this->redirect('ATM/index');}		
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);
		$paytxfee = Parameters::find('first');
		$txfee = $paytxfee['paytxfee'];
			return compact('details','txfee')	;
	}
}
?>