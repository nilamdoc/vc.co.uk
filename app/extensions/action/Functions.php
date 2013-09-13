<?php
namespace app\extensions\action;

use lithium\storage\Session;
use app\extensions\action\Bitcoin;
use app\models\Users;
use app\models\Details;
use app\models\Payments;
use app\models\Points;
use app\models\Messages;
use app\models\Accounts;
use app\models\Interests;
use app\models\Transactions;
use lithium\data\Connections;

class Functions extends \lithium\action\Controller {

	public function roman($integer, $upcase = true){
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
		$return = '';
		while($integer > 0){
			foreach($table as $rom=>$arb){
				if($integer >= $arb){
					$integer -= $arb;
					$return .= $rom;
					break;
				}
			}
		}
		return $return;
	} 

	public function getBitAddress($account){
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$wallet['address'] = $bitcoin->getaddressesbyaccount($account);
		  $wallet['balance'] = $bitcoin->getbalance($account);
		  $wallet['key'] = $account; 
		return compact('wallet');
	}
	public function sendAmount($fromAccount, $toAddress, $amount, $flag = 1, $message){
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$sendAmount = $bitcoin->sendfrom($fromAccount, $toAddress, $amount, $flag, $message);
		return compact('sendAmount');
	}

	public function gettransactions($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://blockexplorer.com/q/mytransactions/'.$address, false, $context);
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, 'http://blockexplorer.com/q/mytransactions/'.$address);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);			
//			print_r($json);
			$jdec = json_decode($json);
//			print_r($jdec);
//			$rate = $jdec->{'ticker'}->{'avg'};
			return (array)$jdec;
	}

	public function addressfirstseen($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://blockexplorer.com/q/addressfirstseen/'.$address, false, $context);
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, 'http://blockexplorer.com/q/addressfirstseen/'.$address);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);			
			
			return $json;
	}

	public function addressbalance($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://blockchain.info/address/'.$address.'?format=json', false, $context);
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, 'http://blockchain.info/address/'.$address.'?format=json');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);			
$jdec = json_decode($json);
//print_r($jdec->final_balance);
// exit;
			return $jdec->final_balance/100000000;
	}

	public function addressTransactions($address=null){
//	http://blockchain.info/address/1BiTcoiNoF5bRg1bzxVZd3rMxNkdrZrvdU/?format=json
		if ( $address == "" ){return;}
		$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://blockchain.info/address/'.$address.'/?format=json', false, $context);
		$jdec = json_decode($json);
		return array($jdec);
	}


	function get_ip_address() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
	}

	public function ip_location($ip=null){
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://api.hostip.info/get_json.php?ip='.$ip.'&position=true', false, $context);
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, 'http://api.hostip.info/get_json.php?ip='.$ip.'&position=true');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);			
			
			$jdec = (array)json_decode($json);			
			return compact('jdec');
	}
	
	public function ip2location($ip=null){
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			//http://api.ipinfodb.com/v3/ip-city/?key=40b69b063becff17998e360d05f48a31814a8922db3f33f5337ceb45542e2b42&ip=74.125.45.100&format=json
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL, 'http://api.ipinfodb.com/v3/ip-city/?key='.IP_INFO_DB.'&ip='.$ip.'&format=json');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);
// display file
			$json = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key='.IP_INFO_DB.'&ip='.$ip.'&format=json', false, $context);
			$jdec = (array)json_decode($json);			
			return compact('jdec');
	}
		

	public function toFriendlyTime($seconds) {
	  $measures = array(
		'year'=>24*60*60*30*12,	  	  
		'month'=>24*60*60*30,	  
		'day'=>24*60*60,
		'hour'=>60*60,
		'minute'=>60,
		'second'=>1,
		);
	  foreach ($measures as $label=>$amount) {
		if ($seconds >= $amount) {  
		  $howMany = floor($seconds / $amount);
		  return $howMany." ".$label.($howMany > 1 ? "s" : "");
		}
	  } 
	  return "now";
	}   

	public function getChilds($user_id){
	#Retrieving a Full Tree
	/* 	SELECT node.user_id
	FROM details AS node,
			details AS parent
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
		   AND parent.user_id = 3
	ORDER BY node.lft;
	
	parent = db.details.findOne({user_id: ObjectId("50f19bc39d5d0ce409000012")});
	query = {left: {$gt: parent.left, $lt: parent.right}};
	select = {user_id: 1};
	db.details.find(query,select).sort({left: 1})
	 */
		$ParentDetails = Details::find('all',array(
			'conditions'=>array(
			'user_id' => $user_id
			)));

		foreach($ParentDetails as $pd){
			$left = $pd['left'];
			$right = $pd['right'];
		}
		$NodeDetails = Details::find('all',array(
			'conditions' => array(
				'left'=>array('$gt'=>$left),
				'right'=>array('$lt'=>$right)
			)),
			array('order'=>array('left'=>'ASC'))
		);
		return $NodeDetails;
	}
	
	public function countChilds($user_id){
	#Retrieving a Full Tree
	/* 	SELECT node.user_id
	FROM details AS node,
			details AS parent
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
		   AND parent.user_id = 3
	ORDER BY node.lft;
	
	parent = db.details.findOne({user_id: ObjectId("50e876e49d5d0cbc08000000")});
	query = {left: {$gt: parent.left, $lt: parent.right}};
	select = {user_id: 1};
	db.details.find(query,select).sort({left: 1})
	 */
		$ParentDetails = Details::find('all',array(
			'conditions'=>array(
			'user_id' => $user_id
			)));
		foreach($ParentDetails as $pd){
			$left = $pd['left'];
			$right = $pd['right'];
		}
		$NodeDetails = Details::count(array(
			'conditions' => array(
				'left'=>array('$gt'=>$left),
				'right'=>array('$lt'=>$right)
			))
		);
		return $NodeDetails;
	}
	
	public function getParents($user_id){
	#Retrieving a Single Path above a user
	/* SELECT parent.user_id
	FROM details AS node,
			details AS parent
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
			AND node.user_id = 10
	ORDER BY node.lft;
	
	node = db.details.findOne({user_id: ObjectId("50e876e49d5d0cbc08000000")});
	query = {left: {$gt: node.left, $lt: node.right}};
	select = {user_id: 1};
	db.details.find(query,select).sort({left: 1})
	 */
			$NodeDetails = Details::find('all',array(
				'conditions'=>array(
				'user_id' => $user_id
			)));
			foreach($NodeDetails as $pd){
				$left = $pd['left'];
				$right = $pd['right'];
			}
			$ParentDetails = Details::find('all',array(
				'conditions' => array(
					'left'=>array('$lt'=>$left),
					'right'=>array('$gt'=>$right)
				)),
				array('order'=>array('left'=>'ASC'))
			);
		return $ParentDetails;
	}	

	public function countParents($user_id){
	#Retrieving a Single Path above a user
	/* SELECT parent.user_id
	FROM details AS node,
			details AS parent
	WHERE node.lft BETWEEN parent.lft AND parent.rgt
			AND node.user_id = 10
	ORDER BY node.lft;
	
	node = db.details.findOne({user_id: ObjectId("50e876e49d5d0cbc08000000")});
	query = {left: {$gt: node.left, $lt: node.right}};
	select = {user_id: 1};
	db.details.find(query,select).sort({left: 1})
	 */
			$NodeDetails = Details::find('all',array(
				'conditions'=>array(
				'user_id' => $user_id
			)));
			foreach($NodeDetails as $pd){
				$left = $pd['left'];
				$right = $pd['right'];
			}
			$ParentDetails = Details::count(array(
				'conditions' => array(
					'left'=>array('$lt'=>$left),
					'right'=>array('$gt'=>$right)
				))
			);
		return $ParentDetails;
	}	

	public function returnName($refer_id){
		$refername = Users::find('first',array(
			'fields'=>array('firstname','lastname'),
			'conditions'=>array('_id'=>$refer_id)
		));
		return $refername['firstname'];
	}

	public function returnID($refer_username){
		$referid = Details::find('first',array(
			'fields'=>array('firstname','lastname', 'user_id'),
			'conditions'=>array('username'=>$refer_username)
		));
		return $referid['user_id'];
	}

	public function countMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$count = Messages::count(array(
			'conditions'=>array('refer_id'=>$id,
			'read'=>"0")
		));
		return compact('count');
	}
	public function countMailSentTodayUser($user_id = null,$refer_id = null){
		if($user_id =='' || $refer_id == ''){return false;}
		$countMessages = Messages::count(array(
			'conditions'=>array(
				'refer_id'=>$refer_id,
				'user_id'=>$user_id,
				'datetime.date'=> gmdate('Y-m-d',time())
			)
		));
		return compact('countMessages');
	}
	public function countReadMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$count = Messages::count(array(
			'conditions'=>array(
				'refer_id'=>$id,
				'read'=>1)
		));
		return compact('count');
	}
	public function countSendMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$count = Messages::count(array(
			'conditions'=>array(
				'user_id'=>$id,
				)
		));
		return compact('count');
	}

	public function getMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$getMails = Messages::find('all',array(
			'conditions'=>array('refer_id'=>$id,
			'read'=>"0")
		));
		return $getMails;
	}
	
	public function getSendMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$getSendMails = Messages::find('all',array(
			'conditions'=>array('user_id'=>$id)
		));
		return $getSendMails;
	}
	public function getSendMailsToday($refer_id){
		$user = Session::read('member');
		$id = $user['_id'];
		$getSendMails = Messages::find('all',array(
			'conditions'=>array('user_id'=>$id)
		));
		return $getSendMails;
	}	
	public function getReadMails(){
		$user = Session::read('member');
		$id = $user['_id'];
		$getReadMails = Messages::find('all',array(
			'conditions'=>array(
				'refer_id'=>$id,
				'read'=>1)
		));
		return $getReadMails;
	}

	public function addPoints($user_id=null,$type=null,$for=null, $reply=null,$txid=null,$address=null){
	if($user_id=="" || $type=="" || $for==""){return false;}
			$username= $this->returnName($user_id);
		$data = array(
			'user_id' => $user_id,
			'name' => $username,
			'type' => $type,
			'for' => $for,
			'points' =>$reply,
			'datetime.date'=> gmdate('Y-m-d',time()),
			'datetime.time'=> gmdate('h:i:s',time()),
			'txid'=>$txid,
			'address'=>$address,

		);
		Points::create()->save($data);
		return true;
	}
	
	public function countPoints($user_id=null, $type=null){
		if($user_id==null){return array('count'=>0);}
		
		$mongodb = Connections::get('default')->connection;
		$points = Points::connection()->connection->command(array(
      'aggregate' => 'points',
      'pipeline' => array( 
                        array( '$project' => array(
                            '_id'=>0,
                            'points' => '$points',
                            'type' => '$type',
							'user_id'=>'$user_id'
                        )),

						array('$match'=>array('user_id'=>$user_id,'type'=>$type)),							
						array('$group' => array( '_id' => array(
                                'type'=>'$type',
								'user_id'=>'$user_id'
                            ),
                            'points' => array('$sum' => '$points'),  

                        )),
                    )
    ));
		return compact('points'); 
	}

	public function countPointsAll(){
	
		$mongodb = Connections::get('default')->connection;
		$points = Points::connection()->connection->command(array(
			'aggregate' => 'points',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'points' => '$points',
					'type' => '$type',
					'user_id'=>'$user_id',
					'name'=>'$name'							
				)),

				array('$group' => array( '_id' => array(
						'type'=>'$type',
						'user_id'=>'$user_id',
						'name'=>'$name'															
						),
					'points' => array('$sum' => '$points'),  
				)),
				array('$sort'=>array(
					'points'=>-1,
				))
				
			)
		));
		return compact('points'); 
	}

	public function sumInterest($user_id){
		$mongodb = Connections::get('default')->connection;
		$interest = Interests::connection()->connection->command(array(
			'aggregate' => 'interests',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'interest' => '$interest',
					'user_id'=>'$user_id',
					'username'=>'$username'							
				)),
				array('$match'=>array('user_id'=>$user_id)),
				array('$group' => array( '_id' => array(
						'user_id'=>'$user_id',
						'username'=>'$username'															
						),
					'interest' => array('$sum' => '$interest'),  
				)),
			)
		));
		return compact('interest'); 
	}

	public function sumAccounts($user_id){

		$mongodb = Connections::get('default')->connection;
		$account = Accounts::connection()->connection->command(array(
			'aggregate' => 'accounts',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'amount' => '$amount',
					'user_id'=>'$user_id',
					'username'=>'$username'							
				)),
				array('$match'=>array('user_id'=>$user_id)),
				array('$group' => array( '_id' => array(
						'user_id'=>'$user_id',
						'username'=>'$username',
						),
					'amount' => array('$sum' => '$amount'),  
				)),
			)
		));
		return compact('account'); 
	}

	public function getBalance($username){
		$wallet = array();
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$wallet['address'] = $bitcoin->getaddressesbyaccount($username);	
		$wallet['balance'] = $bitcoin->getbalance($username);
		$wallet['key'] = $username; 
		return compact('wallet');
	}

	public function listTransactions($username,$address){
		$transactions = Transactions::find('all',array(
				'conditions'=>array('address'=>$address),
				'order'=> array('blocktime'=>'DESC'),
		));
		return compact('transactions');
	}
	public function array_sort($arr){
		if(empty($arr)) return $arr;
		foreach($arr as $k => $a){
			if(!is_array($a)){
				arsort($arr); // could be any kind of sort
				return $arr;
			}else{
				$arr[$k] = Functions::array_sort($a);
			}
		}
		return $arr;
	}

	public function listusers(){
		$ParentDetails = Details::find('all');
		$i =0;
		foreach($ParentDetails as $pd){

			$left = $pd['left'];
			$right = $pd['right'];

			$NDCount = Details::count( array(
					'left'=>array('$lt'=>$left),
					'right'=>array('$gt'=>$right)
				));

			$userlist[$i]['count'] = $NDCount;
			$username = Users::find('all',array(
				'conditions'=>array('_id'=>$pd['user_id'])
			));
			foreach($username as $u){
				$userlist[$i]['username'] = $u['username'];
			}
			$i++;
		}

/* 		
		$mongodb = Connections::get('default')->connection;
		$details = Details::connection()->connection->command(array(
			'aggregate' => 'details',
			'pipeline' => array( 
				array('$group' => array( 
						'_id' => array(
							'parent'=>array(
								'puser_id'=>'$user_id',
								'pleft'=>'$left',
								'pright'=>'$right',						
								),
							)
						),
					'$group' =>array(
						'_id' => '$user_id',
						'count' => array('$sum' => 1),
						'puser'=>'$parent.puser_id'
					),

				),
			)
		));

 */
		
			return array($userlist);			
	
	}
		public function number_to_words($number) {
	   
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);
	   
		if (!is_numeric($number)) {
			return false;
		}
	   
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . $this->number_to_words(abs($number));
		}
   
		$string = $fraction = null;
	   
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . $this->number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $this->number_to_words($remainder);
				}
				break;
		}
	   
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
	   
		return $string;
	}
	
	public function blockchain($url){
		$opts = array(
		  'http'=> array(
				'method'=> "GET",
				'user_agent'=> "MozillaXYZ/1.0"));
		$context = stream_context_create($opts);
		$json = file_get_contents($url, false, $context);
		$jdec = json_decode($json);
		return $jdec;
	}
	
	public function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map($this->objectToArray, $d);
		}
		else {
			// Return array
			return $d;
		}
	}
	
	public function arrayToObject($d) {
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return (object) array_map($this->arrayToObject, $d);
		}
		else {
			// Return object
			return $d;
		}
	}
	
	public function sumTransactions(){
		$mongodb = Connections::get('default')->connection;
		$transactions = Transactions::connection()->connection->command(array(
			'aggregate' => 'transactions',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'amount' => '$amount',
					'category'=>'$category',
					'account'=>'$account',
					'address'=>'$address'												
				)),
				array('$group' => array( '_id' => array(
						'account'=>'$account',
						'category'=>'$category',						
						'address'=>'$address',												
						),
					'amount' => array('$sum' => '$amount'),  
					'count' => array('$sum' => 1),  					
				)),
				array('$sort'=>array(
					'account'=>1,
					'category'=>1,					
				))
			)
		));
		return compact('transactions'); 
	
	}
	
		public function OnlineUsers(){
			$dataFile = LITHIUM_APP_PATH . '/webroot/qrcode/out/visitors.txt';
//			print_r($dataFile);
			$sessionTime = 30; //this is the time in **minutes** to consider someone online before removing them from our file

			if(!file_exists($dataFile)) {
				$fp = fopen($dataFile, "w+");
				fclose($fp);
			}
			$ip = $_SERVER['REMOTE_ADDR'];
			$users = array();
			$onusers = array();
			
			//getting
			$fp = fopen($dataFile, "r");
			flock($fp, LOCK_SH);
			while(!feof($fp)) {
				$users[] = rtrim(fgets($fp, 32));
			}
			flock($fp, LOCK_UN);
			fclose($fp);

			
			//cleaning
			$x = 0;
			$alreadyIn = FALSE;
			foreach($users as $key => $data) {
				list( , $lastvisit) = explode("|", $data);
				if(time() - $lastvisit >= $sessionTime * 60) {
					$users[$x] = "";
				} else {
					if(strpos($data, $ip) !== FALSE) {
						$alreadyIn = TRUE;
						$users[$x] = "$ip|" . time(); //updating
					}
				}
				$x++;
			}
			
			if($alreadyIn == FALSE) {
				$users[] = "$ip|" . time();
			}
			
			//writing
			$fp = fopen($dataFile, "w+");
			flock($fp, LOCK_EX);
			$i = 0;
			foreach($users as $single) {
				if($single != "") {
					fwrite($fp, $single . "\r\n");
					$i++;
				}
			}
			flock($fp, LOCK_UN);
			fclose($fp);
			
			if($uo_keepquiet != TRUE) {
				return $i;
			}
	
	}
}
?>