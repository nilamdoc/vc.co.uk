<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;
use app\models\Parameters;

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
	public function Rates() {
		return $this->render(array('json' => array(
			'Low'=> rand(0,100),
			'High' => rand(0,100),
			'Last'=> rand(0,100),			
			'VolumeBTC'=> rand(0,100),
			'VolumeOther'=> rand(0,100),
			'VolumeOtherUnit'=> 'USD',
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