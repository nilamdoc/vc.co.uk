<?php
namespace app\controllers;

class APIController extends \lithium\action\Controller {
	public function index(){
		$title = "";
		$keywords = "";
		$description = "";
		return compact('title','keywords','description');
	}
}
?>