<?php
namespace app\extensions\command;
use ZipArchive;
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
		$result = $this->create_zip($files_to_zip,BACKUP_DIR.'Backup.zip');
		print_r(BACKUP_DIR.'Backup.zip');
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