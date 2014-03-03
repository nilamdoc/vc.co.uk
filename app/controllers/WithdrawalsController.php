<?php
namespace app\controllers;
use lithium\storage\Session;
use app\models\Parameters;

class WithdrawalsController extends \lithium\action\Controller {
	public function index(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];
		$Withdrawal = Parameters::find('first');
		
		return compact('Withdrawal');
	}

}
?>