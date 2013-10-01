<?php
namespace app\controllers;
use app\controllers\UpdatesController;
use MongoDate;
use app\models\Orders;
class APIController extends \lithium\action\Controller {
	public function index(){

		$title = "API";
		$keywords = "API, documentation, ibwt";
		$description = "API documentation for ibwt.co.uk";
		return compact('title','keywords','description');
	}
	public function trades(){
		$updates = new UpdatesController();
		$upBU = $updates->Rates('BTC','USD');
		$jdecBU = json_decode($upBU->body[0]);
//print_r($jdecBU)		;
		$upBG = $updates->Rates('BTC','GBP');
		$jdecBG = json_decode($upBG->body[1]);
//print_r($jdecBG)		;		
		$upBE = $updates->Rates('BTC','EUR');
		$jdecBE = json_decode($upBE->body[2]);
//print_r($jdecBE)		;
		return $this->render(array('json' => array('success'=>1,
			'now'=>gmdate(time()),
			'result'=>array(
				array(
					'Low'=> number_format($jdecBU->Low,2),
					'High' => number_format($jdecBU->High,2),
					'Last'=> number_format($jdecBU->LastPrice,2),			
					'FirstUnit'=> 'BTC',			
					'SecondUnit'=> 'USD',
				),
				array(
					'Low'=> number_format($jdecBG->Low,2),
					'High' => number_format($jdecBG->High,2),
					'Last'=> number_format($jdecBG->LastPrice,2),			
					'FirstUnit'=> 'BTC',			
					'SecondUnit'=> 'GBP',
				),
				array(
					'Low'=> number_format($jdecBE->Low,2),
					'High' => number_format($jdecBE->High,2),
					'Last'=> number_format($jdecBE->LastPrice,2),			
					'FirstUnit'=> 'BTC',			
					'SecondUnit'=> 'EUR',
				),
		))));	
	}
	public function tradesdate($date=null){
		if($date==null){
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time())))));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+24*60*60)));
		}else{
			$StartDate = new MongoDate(strtotime($date));
			$EndDate = new MongoDate(strtotime($date)+24*60*60);			
		}
		$orders = Orders::find('all',array(
			'conditions'=>array('DateTime'=>array( '$gte' => $StartDate, '$lt' => $EndDate )),
			'order'=>array('DateTime'=>-1)
		));
		$i = 0;$result = array();
		foreach($orders as $or){

			$result[$i]['DateTime'] = $or['DateTime']->sec;
			$result[$i]['Action'] = $or['Action'];			
			$result[$i]['FromCurrency'] = $or['FirstCurrency'];						
			$result[$i]['ToCurrency'] = $or['SecondCurrency'];									
			$result[$i]['BTC'] = $or['Amount'];									
			$result[$i]['PerPrice'] = $or['PerPrice'];									
			$result[$i]['FromCurrency'] = $or['FirstCurrency'];					
			$result[$i]['Completed'] = $or['Completed'];												
			$i++;
		}
		
			return $this->render(array('json' => array('success'=>1,
			'now'=>$StartDate->sec,
			'result'=>$result
			)));
	}
	
}
?>