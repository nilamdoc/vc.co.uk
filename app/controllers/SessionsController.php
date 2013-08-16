<?php
namespace app\controllers;

use lithium\security\Auth;
use lithium\util\String;
use app\models\Users;
use lithium\storage\Session;
use app\extensions\action\Functions;

class SessionsController extends \lithium\action\Controller {

    public function add() {
		   //assume there's no problem with authentication
			$noauth = false;
			//perform the authentication check and redirect on success

			Session::delete('default');				

			if (Auth::check('member', $this->request)){
				//Redirect on successful login
				Session::write('default',Auth::check('member', $this->request));

				
				// check transaction of the user and compare with points given.
				// if they match skip
				// if they do not match, add points based on transactions

				$user = Session::read('default');
				print_r("perfect");							
				return $this->redirect('ex::dashboard');
				print_r("LOG");							
			}
			//if theres still post data, and we weren't redirected above, then login failed

			if ($this->request->data){
				//Login failed, trigger the error message
				if(isset($this->request->query['check']) && $this->request->query['check']==SECURITY_CHECK){$check = $this->request->query['check'];}
				$noauth = true;
			}
			//Return noauth status
			return compact('noauth');
			print_r("NoAuth");			
			return $this->redirect('/');
			print_r("LOG");

        // Handle failed authentication attempts
    }
	 public function delete() {
        Auth::clear('member');
		print_r("logout");
		Session::delete('default');
		print_r("here");
        return $this->redirect('ex::dashboard');
		print_r("Out");		
    }
}
?>