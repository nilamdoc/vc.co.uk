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
//****************************************************************************************************************
	define('QR_CACHEABLE', true);       // use cache - more disk reads but less CPU power, 
										 // masks and format templates are stored there
    define('QR_CACHE_DIR', LITHIUM_APP_PATH.'/webroot/qrcode/cache/');       // used when QR_CACHEABLE === true
	define('QR_OUTPUT_DIR',LITHIUM_APP_PATH.'/webroot/qrcode/out/'); //used for outputting the file
	define('QR_OUTPUT_RELATIVE_DIR','/qrcode/out/'); // used for showing the file in the view
    
    define('QR_FIND_BEST_MASK', true);                                                          // if true, estimates best mask (spec. default, but extremally slow; set to false to significant performance boost but (propably) worst quality code
    define('QR_FIND_FROM_RANDOM', 2);                                                       // if false, checks all masks available, otherwise value tells count of masks need to be checked, mask id are got randomly
    define('QR_DEFAULT_MASK', 2);                                                               // when QR_FIND_BEST_MASK === false

    define('QR_LOG_DIR', false);         // default error logs dir 
	define('QR_PNG_MAXIMUM_SIZE',  1024);// maximum allowed png image width (in pixels), tune to make sure GD and 
										 // PHP can handle such big images
?>