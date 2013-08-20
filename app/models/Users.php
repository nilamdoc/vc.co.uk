<?php
namespace app\models;
use lithium\util\Validator;
use lithium\util\String;

class Users extends \lithium\data\Model {

	protected $_schema = array(
		'_id'	=>	array('type' => 'id'),
		'username'	=>	array('type' => 'string', 'null' => false),
		'password'	=>	array('type' => 'string', 'null' => false),
		'firstname'	=>	array('type' => 'string', 'null' => false),
		'lastname'	=>	array('type' => 'string', 'null' => false),
		'email'	=>	array('type' => 'string', 'null' => false),		
		'updated'	=>	array('type' => 'datetime', 'null' => false),
		'created'	=>	array('type' => 'datetime', 'null' => false),
		'verified'	=>	array('type' => 'string', 'null' => true),
		'ip'	=>	array('type' => 'string', 'null' => true),		
	);

	protected $_meta = array(
		'key' => '_id',
		'locked' => true
	);

	public $validates = array(
		'firstname' => 'Please enter your first name',
		'lastname' => 'Please enter your last name',		
		'email' => array(
			array('uniqueEmail', 'message' => 'This Email is already used'),
			array('notEmpty', 'message' => 'Please enter your email address'),			
			array('email', 'message' => 'Not a valid email address'),						
		),
		'password' => array(
			array('notEmpty', 'message' => 'Please enter a password'),
			array('alphaNumeric', 'message' => 'Please use only alphanumeric characters'),
			array('passwordVerification', 'message' => 'Passwords are not the same'),
		),
		'username' => array(
			array('uniqueUsername', 'message' => 'This username is already taken'),
			array('notEmpty', 'message' => 'Please enter a username'),
			array('alphaNumeric', 'message' => 'Please use only alphanumeric characters'),
			array('lengthBetween', 'message' => 'Too long!', 'max'=>20),
		)
		);
}


	Validator::add('passwordVerification', function($value, $rule, $options) {
		if(!isset($options['values']['password2']) || $value==$options['values']['password2']){ 
			return true;
		}else{
			return false;
		}
	});
	
	
	Validator::add('uniqueUsername', function($value, $rule, $options) {
		$conflicts = Users::count(array('username' => $value));
		if($conflicts) return false;
		return true;
	});

	Validator::add('uniqueEmail', function($value, $rule, $options) {
		$conflicts = Users::count(array('email' => $value));
		if($conflicts) return false;
		return true;
	});

	
	Users::applyFilter('save', function($self, $params, $chain) {
		if ($params['data']) {
			$params['entity']->set($params['data']);
			$params['data'] = array();
		}
		if (!$params['entity']->exists()) {
			$params['entity']->password = String::hash($params['entity']->password);
			$params['entity']->password2 = String::hash($params['entity']->password2);		
			$params['entity']->created = new \MongoDate();
			$params['entity']->updated = new \MongoDate();
			$params['entity']->ip = $_SERVER['REMOTE_ADDR'];
		}
		return $chain->next($self, $params, $chain);
	});
	
	
?>