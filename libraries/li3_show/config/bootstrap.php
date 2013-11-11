<?php
use li3_show\extensions\data\Data;
// Get the queries
$GLOBALS['Show_SQL'] = '';
Data::set('queries', array());
require __DIR__ . '/bootstrap/libraries.php';
require __DIR__ . '/bootstrap/queries.php';
require __DIR__ . '/bootstrap/dispatcher.php';

?>