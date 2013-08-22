<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;
use app\models\Parameters;
use app\models\Details;
use app\models\Orders;
use lithium\data\Connections;

class UpdatesController extends \lithium\action\Controller {

	public function index() {
		return $this->render(array('layout' => false));
	}

	public function to_string() {
		return "Hello World";
	}

	public function to_json() {
		return $this->render(array('json' => 'Hello World'));
	}
	public function Rates($FirstCurrency="BTC",$SecondCurrency="USD") {

		$mongodb = Connections::get('default')->connection;
		$Rates = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( 
				'$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'PerPrice'=>'$PerPrice',					
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TransactDateTime' => '$Transact.DateTime',
				)),
				array('$match'=>array(
					'Completed'=>'Y',					
					'FirstCurrency' => $FirstCurrency,
					'SecondCurrency' => $SecondCurrency,					
					)),
				array('$group' => array( '_id' => array(
						'year'=>array('$year' => '$TransactDateTime'),
						'month'=>array('$month' => '$TransactDateTime'),						
						'day'=>array('$dayOfMonth' => '$TransactDateTime'),												
//						'hour'=>array('$hour' => '$TransactDateTime'),
						),
					'min' => array('$min' => '$PerPrice'), 
					'max' => array('$max' => '$PerPrice'), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
					'_id.day'=>-1,					
//					'_id.hour'=>-1,					
				)),
				array('$limit'=>1)
			)
		));

//		print_r($Rates['result']);
		foreach($Rates['result'] as $r){
			$Low = $r['min'];
			$High = $r['max'];			
		}

		$Last = Orders::find('all',array(
			'conditions'=>array(
				'Completed'=>'Y',					
				'FirstCurrency' => $FirstCurrency,
				'SecondCurrency' => $SecondCurrency,					
				),
			'limit'=>1,
			'order'=>array('Transact.DateTime'=>'DESC')
		));
		foreach($Last as $l){
			$LastPrice = $l['PerPrice'];
		}
		
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
					'TransactDateTime' => '$Transact.DateTime',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),
				)),
				array('$match'=>array(
					'Completed'=>'Y',	
					'Action'=>'Buy',										
					'FirstCurrency' => $FirstCurrency,
					'SecondCurrency' => $SecondCurrency,					
					)),
				array('$group' => array( '_id' => array(
					'year'=>array('$year' => '$TransactDateTime'),
					'month'=>array('$month' => '$TransactDateTime'),						
					),
					'Amount' => array('$sum' => '$Amount'), 
					'TotalAmount' => array('$sum' => '$TotalAmount'), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
				)),
				array('$limit'=>1)
			)
		));
		return $this->render(array('json' => array(
			'Low'=> $Low,
			'High' => $High,
			'Last'=> $LastPrice,			
			'VolumeFirst'=> number_format($TotalOrders['result'][0]['Amount'],0),
			'VolumeSecond'=> number_format($TotalOrders['result'][0]['TotalAmount'],0),
			'VolumeFirstUnit'=> $FirstCurrency,			
			'VolumeSecondUnit'=> $SecondCurrency,
		)));
	}
	public function Commission(){
		$commission = Parameters::find('first',
			array('conditions'=>array('commission'=>true))
		);
		return $this->render(array('json' => array(
			'Commission' => $commission['value']
		)));
	}
	public function BuyFormSubmit($BuyAmount,$BuyPricePer,$Fees,$GrandTotal){
	print_r($BuyAmount);
	print_r($BuyPricePer);
	print_r($Fees);
	print_r($GrandTotal);		
	exit;
	}
}

?>