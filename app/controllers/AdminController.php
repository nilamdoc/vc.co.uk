<?php
namespace app\controllers;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\File;
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
				array('$limit'=>30)
			)
		));


		$newYear = array();
		for($i=0;$i<=5;$i++){
			$date = gmdate('Y',mktime(0,0,0,1,1,2013)+$i*60*60*24*365);
			$newYear[$date] = array();
		}

	
		$new = array();
		for($i=0;$i<=30;$i++){
			$date = gmdate('Y-m-d',time()-$i*60*60*24);
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

	return compact('new','newYear');
	}
	
	public function Approval() {
		if($this->__init()==false){			$this->redirect('ex::dashboard');	}
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
//		print_r(count($details));
		return compact('UserApproval','details');
		
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
//			&& $details['TOTP.Validate'] == 1
//			&& $details['TOTP.Login'] == 1
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
			return compact('imagename_utility','media','id');
	}
}
?>