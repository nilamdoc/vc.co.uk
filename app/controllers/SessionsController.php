<?php
namespace app\controllers;

use lithium\security\Auth;
use lithium\util\String;
use app\models\Users;
use app\models\Details;
use lithium\storage\Session;
use app\extensions\action\Functions;
use app\extensions\action\GoogleAuthenticator;

class SessionsController extends \lithium\action\Controller {

    public function add() {
		   //assume there's no problem with authentication
			$noauth = false;
			//perform the authentication check and redirect on success

			Session::delete('default');				

			if (Auth::check('member', $this->request)){
				//Redirect on successful login
				$loginpassword = $this->request->data['loginpassword'];
				$default = Auth::check('member', $this->request);
				$details = Details::find('first',array(
					'conditions' => array(
						'username'=>$default['username'],
						'user_id'=>(string)$default['_id']
						)
				));
				if($details['oneCode']===$this->request->data['loginpassword']){
					if($details["TOTP.Validate"]==1 && $details["TOTP.Login"]==true){
						$totp = $this->request->data['totp'];
						$ga = new GoogleAuthenticator();
						if($totp==""){
							Auth::clear('member');
							Session::delete('default');
						}else{
							$checkResult = $ga->verifyCode($details['secret'], $totp, 2);		
							if ($checkResult==1) {
								Session::write('default',$default);
								$user = Session::read('default');
								return $this->redirect('ex::dashboard');
								exit;
							}else{
								Auth::clear('member');
								Session::delete('default');
							}
						}
					}else{
						Session::write('default',$default);
						$user = Session::read('default');
						return $this->redirect('ex::dashboard');
						exit;
					}
				}else{
					Auth::clear('member');
					Session::delete('default');
				}
			}
			//if theres still post data, and we weren't redirected above, then login failed

			if ($this->request->data){
				//Login failed, trigger the error message
				if(isset($this->request->query['check']) && $this->request->query['check']==SECURITY_CHECK){$check = $this->request->query['check'];}
				$noauth = true;
			}
			//Return noauth status
			return compact('noauth');
			return $this->redirect('/');
			exit;
        // Handle failed authentication attempts
    }
	 public function delete() {
        Auth::clear('member');
		Session::delete('default');
        return $this->redirect('/');
    }
}
?>