<?php
namespace app\controllers;

use app\models\Users;
use app\models\Details;
use app\models\Transactions;
use app\models\Parameters;
use app\models\File;
use lithium\data\Connections;
use app\extensions\action\Functions;

use app\extensions\action\Bitcoin;
use app\extensions\action\Litecoin;
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

class DepositController extends \lithium\action\Controller {

	public function index(){
	}
	public function btc($email=null){
		$title = "Funding BTC";
		if($email==null){return $this->redirect('/login');}
		
		$user = Users::find('first',array(
			'conditions'=>array('email'=>$email)
		));
	if(count($user)==0){return $this->redirect('/login');}
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
		$laddress = 'LADDRESS';				
		$paytxfee = Parameters::find('first');
		$txfee = $paytxfee['paytxfee'];
		$transactions = Transactions::find('first',array(
				'conditions'=>array(
				'username'=>$user['username'],
				'Added'=>false,
				'Currency'=>'BTC',
				'Paid'=>'No'
				)
		));
			return compact('details','address','txfee','title','transactions','laddress')	;

	}
	public function ltc($email=null){
				$title = "Funding LTC";
		if($email==null){return $this->redirect('/login');}
		
		$user = Users::find('first',array(
			'conditions'=>array('email'=>$email)
		));
		if(count($user)==0){return $this->redirect('/login');}
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
		$transactions = Transactions::find('first',array(
				'conditions'=>array(
				'username'=>$user['username'],
				'Added'=>false,
				'Paid'=>'No',
				'Currency'=>'LTC'
				)
		));
			return compact('details','address','txfee','title','transactions')	;
	
	}
}
?>