<?php
namespace app\controllers;

class WithdrawalsController extends \lithium\action\Controller {
	public function index(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('/login');}
		$id = $user['_id'];
		return compact('Withdrawal');
	}

}
?>