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
		return compact("title");

	}

}
?>