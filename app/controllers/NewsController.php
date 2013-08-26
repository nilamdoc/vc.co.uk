<?php
namespace app\controllers;
use app\models\Queries;

class NewsController extends \lithium\action\Controller {

	public function index() {
		$title = "News";
		return compact("title");

	}
	public function launching() {
		$title = "Launching 1st September 2013";
		return compact("title");

	}
}
?>