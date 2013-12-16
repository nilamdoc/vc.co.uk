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

	public function paymentbtc(){
			$title = "Payment";
		$this->_render['layout'] = 'atm';
		$user = Session::read('default');
		$id = $user['user_id'];

		if($id==""){return $this->redirect('/ATM/index');}
		$details = Details::find('first',
			array('conditions'=>array('user_id'=> (string) $id))
		);

		
		if ($this->request->data) {
			$guid=BITCOIN_GUID;
			$firstpassword=BITCOIN_FIRST;
			$secondpassword=BITCOIN_SECOND;
			$amount = abs($this->request->data['Amount']);
			if($details['balance.BTC']<=$amount){return false;}			
			$fee = $$this->request->data['txFee'];
			$address = $$this->request->data['bitcoinaddress'];
			$satoshi = (float)$amount * 100000000;
			$fee_satoshi = (float)$fee * 100000000;
			$json_url = "http://blockchain.info/merchant/$guid/payment?password=$firstpassword&second_password=$secondpassword&to=$address&amount=$satoshi&fee=$fee_satoshi";
			$json_data = file_get_contents($json_url);
			$json_feed = json_decode($json_data);
			$txmessage = $json_feed->message;
			$txid = $json_feed->tx_hash;
			if($txid!=null){
				$data = array(
					'DateTime' => new \MongoDate(),
					'TransactionHash' => $txid,
					'Paid'=>'Yes',
					'Transfer'=>$message,
				);							
			$transaction = Transactions::find('first',array(
				'conditions'=>array(
					'verify.payment'=>$verify,
					'username'=>$username,
					'Paid'=>'No'
					)
			))->save($data);
			$transaction = Transactions::find('first',array(
				'conditions'=>array(
					'verify.payment'=>$verify,
					'username'=>$username,
					'Paid'=>'Yes'
					)
			));			
				$dataDetails = array(
						'balance.BTC' => (float)number_format($details['balance.BTC'] - (float)$amount - (float)$fee,8),
					);
				$details = Details::find('all',
					array(
							'conditions'=>array(
								'user_id'=> (string) $id
							)
						))->save($dataDetails);
			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$body = $view->render(
				'template',
				compact('transaction','details','txid'),
				array(
					'controller' => 'users',
					'template'=>'withdraw_btc_sent',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("BTC sent from ".COMPANY_URL);
			$message->setFrom(array(NOREPLY => 'BTC sent from '.COMPANY_URL));
			$message->setTo($email);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		

			$message->setBody($body,'text/html');
			
			$mailer->send($message);
			}
			return compact('txmessage','txid','json_url','json_feed','title');
		}
	}
}
?>