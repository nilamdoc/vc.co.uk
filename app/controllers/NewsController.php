<?php
namespace app\controllers;
use app\models\Queries;
use app\models\Pages;
class NewsController extends \lithium\action\Controller {

	public function index() {
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'news')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function launching() {
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'news')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');

	}
}
?>