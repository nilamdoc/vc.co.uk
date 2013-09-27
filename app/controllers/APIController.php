<?php
namespace app\controllers;

class APIController extends \lithium\action\Controller {
	public function index(){
		$title = "";
		$keywords = "";
		$description = "";
		return compact('title','keywords','description');
	}
	public function trades(){
		
		return $this->render(array('result' => array(
			'Refresh'=> $Refresh,
			'URL'=> $URL,
			'Low'=> number_format($Low,2),
			'High' => number_format($High,2),
			'Last'=> number_format($LastPrice,2),			
			'VolumeFirst'=> number_format($TotalOrders['result'][0]['Amount'],4),
			'VolumeSecond'=> number_format($TotalOrders['result'][0]['TotalAmount'],0),
			'VolumeFirstUnit'=> $FirstCurrency,			
			'VolumeSecondUnit'=> $SecondCurrency,
		)));	
	
	}
}
?>