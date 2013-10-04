<?php
namespace app\extensions\command;
use \ZipArchive;
use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

class Backup extends \lithium\console\Command {
	public function run(){
			$files_to_zip = array(
			"/backup/VCCoUK/details.bson",
			"/backup/VCCoUK/details.metadata.json",
			"/backup/VCCoUK/orders.bson",
			"/backup/VCCoUK/orders.metadata.json",
			"/backup/VCCoUK/pages.bson",
			"/backup/VCCoUK/pages.metadata.json",
			"/backup/VCCoUK/parameters.bson",
			"/backup/VCCoUK/parameters.metadata.json",
			"/backup/VCCoUK/reasons.bson",
			"/backup/VCCoUK/reasons.metadata.json",
			"/backup/VCCoUK/system.indexes.bson",
			"/backup/VCCoUK/system.users.bson",
			"/backup/VCCoUK/system.users.metadata.json",
			"/backup/VCCoUK/trades.bson",
			"/backup/VCCoUK/trades.metadata.json",
			"/backup/VCCoUK/transactions.bson",
			"/backup/VCCoUK/transactions.metadata.json",
			"/backup/VCCoUK/users.bson",
			"/backup/VCCoUK/users.metadata.json",
		);
//if true, good; if false, zip creation failed
		$result = $this->create_zip($files_to_zip,BACKUP_DIR.'Backup.zip',true);

		$filename = BACKUP_DIR.'Backup.zip';

			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));

			$body = $view->render(
				'template',
				compact('filename'),
				array(
					'controller' => 'admin',
					'template'=>'backup',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("Data Backup: ".COMPANY_URL);
			$message->setFrom(array(NOREPLY => 'Data Backup: '.COMPANY_URL));
			$message->setTo("nilamdoc@gmail.com");
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		
			$message->attach(Swift_Attachment::fromPath($filename));
			$message->setBody($body,'text/html');
			
			$mailer->send($message);


	}

	function create_zip($files = array(),$destination = '',$overwrite = false) {
		//if the zip file already exists and overwrite is false, return false
		if(file_exists($destination) && !$overwrite) { return false; }
		//vars
		$valid_files = array();
		//if files were passed in...
		if(is_array($files)) {
			//cycle through each file
			foreach($files as $file) {
				//make sure the file exists
				if(file_exists($file)) {
					$valid_files[] = $file;
				}
			}
		}
		//if we have good files...
		if(count($valid_files)) {
			//create the archive
			$zip = new ZipArchive();
			if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			//add the files
			foreach($valid_files as $file) {
				$zip->addFile($file,$file);
			}
			//debug
			//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
			
			//close the zip -- done!
			$zip->close();
			
			//check to make sure the file exists
			return file_exists($destination);
		}
		else
		{
			return false;
		}
	}
}
?>