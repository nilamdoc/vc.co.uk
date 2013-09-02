<?php
namespace app\extensions\action;
use lithium\action\DispatchException;

class Bitcoin extends \lithium\action\Controller{
// @var string
	private $username;
	// @var string
	private $password;
	// @var string
	private $url;
	// @var integer
	private $id;

/**
* Contructor
*
* @param string $url
* @param string $username
* @param string $password
* @param boolean $debug
*/
	public function __construct($url, $username, $password) {
	//connection details
	$this->url = $url;
	$this->username = $username;
	$this->password = $password;
	//request id
	$this->id = 1;
	}

	/**
	* Perform jsonRCP request and return results as array
	*
	* @param string $method
	* @param array $params
	* @return array
	*/
	public function __call($method,$params) {	
	// make params indexed array of values
		$params = array_values($params);
		
		// prepares the request
		$request = json_encode(array(
			'method' => strtolower($method),
			'params' => $params,
			'id' => $this->id
		));
		
		// performs the HTTP POST using curl
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_URL, $this->url);
		curl_setopt($curl, CURLOPT_USERPWD, $this->username.":".$this->password);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		$response = curl_exec($curl);
		curl_close($curl);
		
		// process response
		if (!$response) {
			return array('error'=>'Unable to connect to Bitcoin server.');
		}
		$response = json_decode($response,true);
		
		// check response id
		if ($response['id'] != $this->id) {
			return array('error'=>'Incorrect response id (request id: '.$this->id.', response id: '.$response['id'].')');
		}
		if (!is_null($response['error'])) {
			return array('error'=>$response['error']);
		}
		$this->id++;
		
		// return
		return $response['result'];
	}
}
?>