<?php
/**
* li3_qrcode: QR Code for Lithium li3
*
* @copyright Copyright 2013, Nilam Doctor (https://github.com/nilamdoc)
* 
* @license http://opensource.org/licenses/bsd-license.php The BSD License
*/
/*
 * Uses: PHP QR Code encoder
 * http://sourceforge.net/projects/phpqrcode/
 *
 * Root library file, prepares environment and includes dependencies
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */


 /**
 * Usage: 
 * Libraries::add('li3_qrcode');
 * In your view:
 *   use li3_qrcode\extensions\action\Qrcode;
 *   $qrcode->png('This is a test QR code', QR_OUTPUT_DIR.'test.png', 'H', 7, 2);
 *   <img src="<?=QR_OUTPUT_RELATIVE_DIR;?>test.png">
 */

use li3_qrcode\extensions\action\Framefiller;
use li3_qrcode\extensions\action\QRbitstream;
use li3_qrcode\extensions\action\QRcode;
use li3_qrcode\extensions\action\QRconfig;
use li3_qrcode\extensions\action\QRconst;
use li3_qrcode\extensions\action\QRencode;
use li3_qrcode\extensions\action\QRimage;
use li3_qrcode\extensions\action\QRinput;
use li3_qrcode\extensions\action\QRinputitem;
use li3_qrcode\extensions\action\QRmask;
use li3_qrcode\extensions\action\QRrawcode;
use li3_qrcode\extensions\action\QRrs;
use li3_qrcode\extensions\action\QRrsblock;
use li3_qrcode\extensions\action\QRrsitem;
use li3_qrcode\extensions\action\QRspec;
use li3_qrcode\extensions\action\QRsplit;
use li3_qrcode\extensions\action\QRstr;
use li3_qrcode\extensions\action\QRtools;

	// Encoding modes
	 
	define('QR_MODE_NUL', -1);
	define('QR_MODE_NUM', 0);
	define('QR_MODE_AN', 1);
	define('QR_MODE_8', 2);
	define('QR_MODE_KANJI', 3);
	define('QR_MODE_STRUCTURE', 4);

	// Levels of error correction.

	define('QR_ECLEVEL_L', 0); // low resolution
	define('QR_ECLEVEL_M', 1); // medium resolution
	define('QR_ECLEVEL_Q', 2); // quality resolution
	define('QR_ECLEVEL_H', 3); // high resolution
	
	// Supported output formats
	
	define('QR_FORMAT_TEXT', 0);
	define('QR_FORMAT_PNG',  1);

    define('QRSPEC_VERSION_MAX', 40);
    define('QRSPEC_WIDTH_MAX',   177);

    define('QRCAP_WIDTH',        0);
    define('QRCAP_WORDS',        1);
    define('QRCAP_REMINDER',     2);
    define('QRCAP_EC',           3);
	include_once(LITHIUM_LIBRARY_PATH.'/li3_qrcode/extensions/action/QRconfig.php');
	
?>