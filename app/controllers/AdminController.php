<?php
namespace app\controllers;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Orders;
use lithium\data\Connections;

class AdminController extends \lithium\action\Controller {

	public function index() {
		if($this->__init()==false){			$this->redirect('ex::dashboard');	}
		$mongodb = Connections::get('default')->connection;
		$UserRegistrations = Users::connection()->connection->command(array(
			'aggregate' => 'users',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'created' => '$created',
				)),
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
				array('$limit'=>30)
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
				array('$limit'=>30)
			)
		));
	
		$new = array();
		for($i=0;$i<=30;$i++){
			$date = gmdate('Y-m-d',time()-$i*60*60*24);
			$new[$date] = array();

		}
 
			foreach($UserRegistrations['result'] as $UR){
				$URdate = date_create($UR['_id']['year']."-".$UR['_id']['month']."-".$UR['_id']['day']);			
				$urDate = date_format($URdate,"Y-m-d");
					$new[$urDate] = array(
						'Register'=> $UR['count']
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
	return compact('new');
	}
	public function reports() {
		if($this->__init()==false){			$this->redirect('ex::dashboard');	}
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
}
?>