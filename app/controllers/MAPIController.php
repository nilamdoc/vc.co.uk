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
use li3_qrcode\extensions\action\QRcode;

class MAPIController extends \lithium\action\Controller {

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
		if($_SERVER['REMOTE_ADDR']=='198.50.222.223'){return true;}
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
		$order = Orders::find('first',array(
			'conditions'=>array(
			'user_id'=> (string) $id,
			'Completed'=>'N'
			)
		));
		$title = "Merchant API";
		$keywords = "Merchant API, documentation, ibwt";
		$description = "Merchant API documentation for ibwt.co.uk";
		return compact('title','keywords','description','details','userInfo','order');
	}
	
	public function BTC($key=null){
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
				$invoice = $this->request->data['invoice'];				
		$secret = $details['secret'];
		$userid = $details['user_id'];		
		$my_address = BITCOIN_ADDRESS;
		$callback_url = 'https://'.COMPANY_URL.'/users/receipt/?userid='.$userid.'&secret='.$secret.'&invoice='.$invoice;
		$root_url = 'https://blockchain.info/api/receive';
		$parameters = 'method=create&address=' . $my_address .'&shared=false&callback='. urlencode($callback_url);
		$response = file_get_contents($root_url . '?' . $parameters);
		$object = json_decode($response);
//		print_r($object);
		$address = $object->input_address;

		$qrcode = new QRcode();
		
		$qrcode->png($address, QR_OUTPUT_DIR.$address.'.png', 'H', 7, 2);
		
		$qrimage = "https://ibwt.co.uk".QR_OUTPUT_RELATIVE_DIR.$address.".png";
		$result = array(
			'address'=>$address,
			'QRimage' => $qrimage,
		);
				return $this->render(array('json' => array('success'=>1,
				'now'=>time(),
				'result'=>$result
				)));
			}		
		}	
	}
}
?>