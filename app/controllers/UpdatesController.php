<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;
use app\models\Parameters;
use app\models\Details;
use app\models\Trades;
use app\models\Orders;
use MongoDate;
use lithium\data\Connections;
use lithium\storage\Session;
use app\extensions\action\Bitcoin;
use app\extensions\action\Litecoin;
use lithium\util\String;

class UpdatesController extends \lithium\action\Controller {

	public function index() {
		return $this->render(array('layout' => false));
	}

	public function to_string() {
		return "Hello World";
	}

	public function to_json() {
		return $this->render(array('json' => 'Hello World'));
	}

	public function Rates($FirstCurrency="BTC",$SecondCurrency="USD") {

		$title = $FirstCurrency . "/" . $SecondCurrency;
		$back = strtolower($FirstCurrency . "_" . $SecondCurrency);		

		$Refresh = "No";
		
		$user = Session::read('member');
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		if($details['page.refresh']==true || $details['page.refresh']==1){
				$data = array(
				'page.refresh' => false
				);
				Details::find('all',
				array('conditions'=>array('user_id'=>$id))				
				)->save($data);

			$Refresh = "Yes";
		}
		
			$URL = "/".$locale.'ex/x/'.$back;					
			$trades = Trades::find('first',array(
				'conditions' => array('trade'=>$title),
			));
			
			if($trades['refresh']==true || $trades['refresh']==1){
				$data = array(
				'refresh' => false
				);
				Trades::find('all',array(
					'conditions' => array('trade'=>$title)
				))->save($data);
				$Refresh = "Yes";
			}

		$mongodb = Connections::get('default')->connection;
		$Rates = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( 
				'$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'PerPrice'=>'$PerPrice',					
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TransactDateTime' => '$Transact.DateTime',
				)),
				array('$match'=>array(
					'Completed'=>'Y',					
					'FirstCurrency' => $FirstCurrency,
					'SecondCurrency' => $SecondCurrency,					
					)),
				array('$group' => array( '_id' => array(
							'year'=>array('$year' => '$TransactDateTime'),
							'month'=>array('$month' => '$TransactDateTime'),						
							'day'=>array('$dayOfMonth' => '$TransactDateTime'),												
//						'hour'=>array('$hour' => '$TransactDateTime'),
						),
					'min' => array('$min' => '$PerPrice'), 
					'max' => array('$max' => '$PerPrice'), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
					'_id.day'=>-1,					
//					'_id.hour'=>-1,					
				)),
				array('$limit'=>1)
			)
		));

//		print_r($Rates['result']);
		foreach($Rates['result'] as $r){
			$Low = $r['min'];
			$High = $r['max'];			
		}

		$Last = Orders::find('all',array(
			'conditions'=>array(
				'Completed'=>'Y',					
				'FirstCurrency' => $FirstCurrency,
				'SecondCurrency' => $SecondCurrency,					
				),
			'limit'=>1,
			'order'=>array('Transact.DateTime'=>'DESC')
		));
		foreach($Last as $l){
			$LastPrice = $l['PerPrice'];
		}
		
		$TotalOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action'=>'$Action',					
					'Amount'=>'$Amount',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TransactDateTime' => '$Transact.DateTime',					
					'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),
				)),
				array('$match'=>array(
					'Completed'=>'Y',	
					'Action'=>'Buy',										
					'FirstCurrency' => $FirstCurrency,
					'SecondCurrency' => $SecondCurrency,					
					)),
				array('$group' => array( '_id' => array(
					'year'=>array('$year' => '$TransactDateTime'),
					'month'=>array('$month' => '$TransactDateTime'),						
					),
					'Amount' => array('$sum' => '$Amount'), 
					'TotalAmount' => array('$sum' => '$TotalAmount'), 
				)),
				array('$sort'=>array(
					'_id.year'=>-1,
					'_id.month'=>-1,
				)),
				array('$limit'=>1)
			)
		));
//		print_r($SecondCurrency);
		return $this->render(array('json' => array(
			'Refresh'=> $Refresh,
			'URL'=> $URL,
			'Low'=> number_format($Low,2),
			'High' => number_format($High,2),
			'Last'=> number_format($LastPrice,2),			
			'VolumeFirst'=> number_format($TotalOrders['result'][0]['Amount'],4),
			'VolumeSecond'=> number_format($TotalOrders['result'][0]['TotalAmount'],0),
			'VolumeFirstUnit'=> $FirstCurrency,			
			'VolumeSecondUnit'=> $SecondCurrency,
		)));
	}
	public function Commission(){
		$commission = Parameters::find('first',
			array('conditions'=>array('commission'=>true))
		);
		return $this->render(array('json' => array(
			'Commission' => $commission['value']
		)));
	}
	public function BuyFormSubmit($BuyAmount,$BuyPricePer,$Fees,$GrandTotal){
	print_r($BuyAmount);
	print_r($BuyPricePer);
	print_r($Fees);
	print_r($GrandTotal);		
	exit;
	}
	
	public function Address($address = null){
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
			$verify = $bitcoin->validateaddress($address);
			return $this->render(array('json' => array(
			'verify'=> $verify,
		)));
	}

	public function LTCAddress($address = null){
		$litecoin = new Litecoin('http://'.LITECOIN_WALLET_SERVER.':'.LITECOIN_WALLET_PORT,LITECOIN_WALLET_USERNAME,LITECOIN_WALLET_PASSWORD);
			$verify = $litecoin->validateaddress($address);
			return $this->render(array('json' => array(
			'verify'=> $verify,
		)));
	}

	public function OHLC($FirstCurrency="BTC",$SecondCurrency="GBP"){
			$StartDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30)));
			$EndDate = new MongoDate(strtotime(gmdate('Y-m-d H:i:s',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))+60*60*24*1)));
	
		$mongodb = Connections::get('default')->connection;
		$Rates = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( 
				'$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'PerPrice'=>'$PerPrice',			
					'Amount' => '$Amount',
					'Completed'=>'$Completed',					
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',	
					'TransactDateTime' => '$Transact.DateTime',
				)),
				array('$match'=>array(
					'Completed'=>'Y',					
					'FirstCurrency'=>$FirstCurrency,
					'SecondCurrency'=>$SecondCurrency,							
					'TransactDateTime'=> array( '$gte' => $StartDate, '$lte' => $EndDate )
					)),
				array('$group' => array( '_id' => array(
							'year'=>array('$year' => '$TransactDateTime'),
							'month'=>array('$month' => '$TransactDateTime'),						
							'day'=>array('$dayOfMonth' => '$TransactDateTime'),												
  						'hour'=>array('$hour' => '$TransactDateTime'),
							'FirstCurrency'=>'$FirstCurrency',
							'SecondCurrency'=>'$SecondCurrency',							
						),
					'Open' => array('$first' => '$PerPrice'), 						
					'High' => array('$max' => '$PerPrice'), 
					'Low' => array('$min' => '$PerPrice'), 
					'Close' => array('$last' => '$PerPrice'), 					
					'Volume'=> array('$sum'=>'$Amount'),
				)),
				array('$sort'=>array(
					'_id.year'=>1,
					'_id.month'=>1,
					'_id.day'=>1,					
					'_id.hour'=>1,					
				)),
//				array('$limit'=>1)
			)
		));

			return $Rates;
	
	}
	public function Orders($FirstCurrency="BTC",$SecondCurrency="USD"){
		$mongodb = Connections::get('default')->connection;
		$TotalSellOrders = Orders::connection()->connection->command(array(
		'aggregate' => 'orders',
		'pipeline' => array( 
			array( '$project' => array(
				'_id'=>0,
				'Action' => '$Action',
				'Amount'=>'$Amount',
				'Completed'=>'$Completed',					
				'FirstCurrency'=>'$FirstCurrency',
				'SecondCurrency'=>'$SecondCurrency',	
				'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),
			)),
			array('$match'=>array(
				'Action'=>'Sell',
				'Completed'=>'N',					
				'FirstCurrency' => $FirstCurrency,
				'SecondCurrency' => $SecondCurrency,					
				)),
			array('$group' => array( '_id' => array(),
				'Amount' => array('$sum' => '$Amount'), 
				'TotalAmount' => array('$sum' => '$TotalAmount'), 
			)),
			array('$sort'=>array(
				'PerPrice'=>1,
			))
		)
	));
	$TotalBuyOrders = Orders::connection()->connection->command(array(
		'aggregate' => 'orders',
		'pipeline' => array( 
			array( '$project' => array(
				'_id'=>0,
				'Action' => '$Action',
				'Amount'=>'$Amount',
				'Completed'=>'$Completed',
				'FirstCurrency'=>'$FirstCurrency',
				'SecondCurrency'=>'$SecondCurrency',					
				'TotalAmount' => array('$multiply' => array('$Amount','$PerPrice')),					
			)),
			array('$match'=>array(
				'Action'=>'Buy',
				'Completed'=>'N',										
				'FirstCurrency' => $FirstCurrency,
				'SecondCurrency' => $SecondCurrency,					
				)),
			array('$group' => array( '_id' => array(),
				'Amount' => array('$sum' => '$Amount'),  
				'TotalAmount' => array('$sum' => '$TotalAmount'), 					
			)),
			array('$sort'=>array(
				'PerPrice'=>1,
			))
		)
	));
			$SellOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'Amount'=>'$Amount',
					'user_id' => '$user_id',
					'PerPrice'=>'$PerPrice',
					'Completed'=>'$Completed',
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
				)),
				array('$match'=>array(
					'Action'=>'Sell',
					'Completed'=>'N',										
					'FirstCurrency' => $FirstCurrency,
					'SecondCurrency' => $SecondCurrency,					
					)),
				array('$group' => array( '_id' => array(
						'PerPrice'=>'$PerPrice',
						),
					'Amount' => array('$sum' => '$Amount'),  
					'No' => array('$sum'=>1),
				)),
				array('$sort'=>array(
					'_id.PerPrice'=>1,
				))
			)
		));
		
		$BuyOrders = Orders::connection()->connection->command(array(
			'aggregate' => 'orders',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'Action' => '$Action',
					'user_id' => '$user_id',					
					'Amount'=>'$Amount',
					'PerPrice'=>'$PerPrice',
					'Completed'=>'$Completed',
					'FirstCurrency'=>'$FirstCurrency',
					'SecondCurrency'=>'$SecondCurrency',					
				)),
				array('$match'=>array(
					'Action'=>'Buy',
					'Completed'=>'N',
					'FirstCurrency' => $FirstCurrency,
					'SecondCurrency' => $SecondCurrency,					
					)),
				array('$group' => array( '_id' => array(
						'PerPrice'=>'$PerPrice',
						),
					'Amount' => array('$sum' => '$Amount'),  
					'No' => array('$sum'=>1),

				)),
				array('$sort'=>array(
					'_id.PerPrice'=>-1,
				))
			)
		));

	
	foreach($TotalBuyOrders['result'] as $TBO){
		$BuyAmount = $TBO['Amount'];
		$BuyTotalAmount = $TBO['TotalAmount'];
	}
$BuyOrdersHTML = '<table class="table table-condensed table-bordered table-hover"  style="font-size:12px ">
				<thead>
					<tr>
					<th style="text-align:center " rowspan="2">#</th>										
					<th style="text-align:center ">Price</th>
					<th style="text-align:center ">'.$FirstCurrency.'</th>
					<th style="text-align:center ">'.$SecondCurrency.'</th>					
					</tr>
					<tr>
					<th style="text-align:center " >Total &raquo;</th>
					<th style="text-align:right " >'.number_format($BuyAmount,8).'</th>
					<th style="text-align:right " >'.number_format($BuyTotalAmount,8).'</th>
					</tr>
				</thead>
				<tbody>';

					$BuyOrderAmount = 0;
					foreach($BuyOrders['result'] as $BO){
						$BuyOrderPrice = number_format(round($BO['_id']['PerPrice'],8),8);
						$BuyOrderAmount = number_format(round($BO['Amount'],8),8);

$BuyOrdersHTML = $BuyOrdersHTML .
					'<tr onClick="BuyOrderFill('.$BuyOrderPrice.','.$BuyOrderAmount.');" style="cursor:pointer" 
					 class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Sell '.$BuyOrderAmount.' '.$FirstCurrency.' at '.$BuyOrderPrice.' '.$SecondCurrency.'">
						<td style="text-align:right">'.$BO['No'].$BO['_id']['username'].'</td>											
						<td style="text-align:right">'.number_format(round($BO['_id']['PerPrice'],8),8).'</td>
						<td style="text-align:right">'.number_format(round($BO['Amount'],8),8).'</td>
						<td style="text-align:right">'.number_format(round($BO['_id']['PerPrice']*$BO['Amount'],8),8).'</td>																	
					</tr>';
						}
$BuyOrdersHTML = $BuyOrdersHTML .				'</tbody>
			</table>';
foreach($TotalSellOrders['result'] as $TSO){
	$SellAmount = $TSO['Amount'];
	$SellTotalAmount = $TSO['TotalAmount'];
}
$SellOrdersHTML = '<table class="table table-condensed table-bordered table-hover" style="font-size:12px ">
				<thead>
					<tr>
					<th style="text-align:center " rowspan="2">#</th>					
					<th style="text-align:center " >Price</th>
					<th style="text-align:center " >'.$FirstCurrency.'</th>
					<th style="text-align:center " >'.$SEcondCurrency.'</th>					
					</tr>
					<tr>
					<th style="text-align:center " >Total &raquo;</th>
					<th style="text-align:right " >'.number_format($SellAmount,8).'</th>
					<th style="text-align:right " >'.number_format($SellTotalAmount,8).'</th>
					</tr>
				</thead>
				<tbody>';

					$SellOrderAmount = 0;
					foreach($SellOrders['result'] as $SO){
						$SellOrderPrice = number_format(round($SO['_id']['PerPrice'],8),8);
						$SellOrderAmount = number_format(round($SO['Amount'],8),8);

$SellOrdersHTML = $SellOrdersHTML .
					'<tr onClick="SellOrderFill('.$SellOrderPrice.','.$SellOrderAmount.');"  style="cursor:pointer" 
					 class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Buy '.$SellOrderAmount.' '.$FirstCurrency.' at '.$SellOrderPrice.' '.$SecondCurrency.'">
						<td style="text-align:right">'.$SO['No'].$SO['_id']['user_id'].'</td>											
						<td style="text-align:right">'.number_format(round($SO['_id']['PerPrice'],8),8).'</td>						
						<td style="text-align:right">'.number_format(round($SO['Amount'],8),8).'</td>
						<td style="text-align:right">'.number_format(round($SO['Amount']*$SO['_id']['PerPrice'],8),8).'</td>
					</tr>';
					 }
$SellOrdersHTML = $SellOrdersHTML .	'			</tbody>
			</table>'			;
		return $this->render(array('json' => array(
			'BuyOrdersHTML'=> $BuyOrdersHTML,
			'SellOrdersHTML'=> $SellOrdersHTML,
		)));
	}

	public function YourOrders($FirstCurrency="BTC",$SecondCurrency="USD",$user_id = null){

		$YourOrders = Orders::find('all',array(
			'conditions'=>array(
				'user_id'=>$user_id,
				'Completed'=>'N',
				'FirstCurrency' => $FirstCurrency,
				'SecondCurrency' => $SecondCurrency,					

				),
			'order' => array('DateTime'=>-1)
		));

			$YourCompleteOrders = Orders::find('all',array(
			'conditions'=>array(
				'user_id'=>$user_id,
				'Completed'=>'Y',
				'FirstCurrency' => $FirstCurrency,
				'SecondCurrency' => $SecondCurrency,					
				),
			'order' => array('DateTime'=>-1)
		));

$YourOrdersHTML = '<table class="table table-condensed table-bordered table-hover" style="font-size:11px">
				<thead>
					<tr>
						<th style="text-align:center ">Exchange</th>
						<th style="text-align:center ">Price</th>
						<th style="text-align:center ">Amount</th>
					</tr>
				</thead>
				<tbody>';
				foreach($YourOrders as $YO){ 
$YourOrdersHTML = $YourOrdersHTML .'<tr>
							<td style="text-align:left ">
							<a href="/ex/RemoveOrder/'.String::hash($YO['_id']).'/'.$YO['_id'].'/'.$FirstCurrency.'_'.$SecondCurrency.'" title="Remove this order">
								<i class="icon-remove"></i></a> &nbsp; 
							'.$YO['Action'].' '.$YO['FirstCurrency'].'/'.$YO['SecondCurrency'].'</td>
						<td style="text-align:right ">'.number_format($YO['PerPrice'],3).'...</td>
						<td style="text-align:right ">'.number_format($YO['Amount'],3).'...</td>
					</tr>';
				 }					
$YourOrdersHTML = $YourOrdersHTML .'				</tbody>
			</table>';

		$YourCompleteOrdersHTML = '<table class="table table-condensed table-bordered table-hover" style="font-size:11px">
				<thead>
					<tr>
						<th style="text-align:center ">Exchange</th>
						<th style="text-align:center ">Price</th>
						<th style="text-align:center ">Amount</th>
					</tr>
				</thead>
				<tbody>';
				foreach($YourCompleteOrders as $YO){ 
		$YourCompleteOrdersHTML = 		$YourCompleteOrdersHTML .'<tr style="cursor:pointer" class=" tooltip-x" rel="tooltip-x" data-placement="top" title="'.$YO['Action'].' '.number_format($YO['Amount'],3).' at '.number_format($YO['PerPrice'],8).' on '.gmdate('Y-m-d H:i:s',$YO['DateTime']->sec).'">
						<td style="text-align:left ">
						'.$YO['Action'].' '.$YO['FirstCurrency'].'/'.$YO['SecondCurrency'].'</td>
						<td style="text-align:right ">'.number_format($YO['PerPrice'],3).'...</td>
						<td style="text-align:right ">'.number_format($YO['Amount'],3).'...</td>
					</tr>';
			 }
		$YourCompleteOrdersHTML = 		$YourCompleteOrdersHTML .'				</tbody>
			</table>';


		return $this->render(array('json' => array(
			'YourCompleteOrdersHTML'=> $YourCompleteOrdersHTML,
			'YourOrdersHTML'=> $YourOrdersHTML,			
		)));
	}

}

?>