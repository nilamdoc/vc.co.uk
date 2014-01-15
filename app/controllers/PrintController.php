<?php
namespace app\controllers;
use \lithium\template\View;
use app\extensions\action\Functions;
use app\extensions\action\Bitcoin;
use lithium\storage\Session;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;
use li3_qrcode\extensions\action\QRcode;

class PrintController extends \lithium\action\Controller {

	public function index() {
	}
	public function cold() {
		unlink(VANITY_OUTPUT_DIR."ibwt-Print.pdf");	
			$email = "support@ibwt.co.uk";
			$cmd = '/bin/vanitygen -i -o "'.VANITY_OUTPUT_DIR.$email.'_0.txt" 1';
			exec($cmd);
			$file = file_get_contents(VANITY_OUTPUT_DIR.$email.'_0.txt', FILE_USE_INCLUDE_PATH);
			$qrcode = new QRcode();			
			$fc = explode("\n", $file );
				foreach($fc as $key=>$value){
					if(stristr($value,"Address")){
						$addressp = str_replace(" ","",str_replace("\r","",str_replace("Address:","",$value)));
						$qrcode->png($addressp, QR_OUTPUT_DIR.$addressp.'.png', 'H', 7, 2);
					}
					if(stristr($value,"Privkey")){
						$privkey = str_replace(" ","",str_replace("\r","",str_replace("Privkey:","",$value)));
						$qrcode->png($privkey, QR_OUTPUT_DIR.$privkey.'.png', 'H', 7, 2);
					}
				}

				$data = array(
				'0'=>
				array(
					'address' => $addressp,
					'key' => $privkey,
					)
				);
				
		$view  = new View(array(
		'paths' => array(
			'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
			'layout'   => '{:library}/views/layouts/{:layout}.{:type}.php',
		)
		));
		echo $view->render(
		'all',
		compact('data'),
		array(
			'controller' => 'print',
			'template'=>'print',
			'type' => 'pdf',
			'layout' =>'print'
		)
		);	
		unlink(QR_OUTPUT_DIR.$addressp.'.png');
		unlink(QR_OUTPUT_DIR.$privkey.'.png');
		unlink(VANITY_OUTPUT_DIR.$email.'_0.txt');

		
		
		return compact('user');
	}

}
?>