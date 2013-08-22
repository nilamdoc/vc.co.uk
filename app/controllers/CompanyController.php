<?php
namespace app\controllers;

class CompanyController extends \lithium\action\Controller {

	public function index() {

	}
	public function privacy() {
		$title = "Privacy Policy";
		return compact("title");

	}
	public function riskmanagement() {
		$title = "Risk Management";
		return compact("title");
	}
	public function legal() {
		$title = "Legal";
		return compact("title");

	}
	public function contact() {
		$title = "Contact us";

		$query = Queries::create();
		if(($this->request->data) && $query->save($this->request->data)) {	
		}

		return compact("title");
	}

}
?>