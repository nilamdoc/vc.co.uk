<?php
namespace app\controllers;
use app\models\Queries;
use app\models\Pages;
class CompanyController extends \lithium\action\Controller {

	public function index() {

	}
	public function privacy() {
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/privacy')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');

	}
	public function riskmanagement() {
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/riskmanagement')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function legal() {
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/legal')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function contact() {
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/contact')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function termsofservice(){
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/termsofservice')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function FAQ(){
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/FAQ')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function verification(){
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/verification')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function aboutus(){
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/aboutus')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function resources(){
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/resources')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}
	public function funding(){
		$page = Pages::find('first',array(
			'conditions'=>array('pagename'=>'company/funding')
		));

		$title = $page['title'];
		$keywords = $page['keywords'];
		$description = $page['description'];
		return compact('title','keywords','description');
	}

}
?>