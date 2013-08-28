<?php
namespace app\controllers;
use app\models\Queries;

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
	public function termsofservice(){
		$title = "Terms of service";
		return compact("title");
	}
	public function FAQ(){
		$title = "FAQ";
		return compact("title");
	}
	public function verification(){
		$title = "Verification";
		return compact("title");
	}
	public function aboutus(){
		$title = "About us";
		return compact("title");
	}
}
?>