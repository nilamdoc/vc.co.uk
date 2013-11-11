<?php
use \lithium\data\Connections;
use li3_show\extensions\data\Data;
use lithium\action\Dispatcher;

Dispatcher::applyFilter('_callable', function($self, $params, $chain) {

	$filter_start = microtime(true);
	Connections::get("default")->applyFilter("read", function($self, $params, $chain) use (&$MongoDb) { 

		$result = $chain->next($self, $params, $chain);

		if (method_exists($result, 'data')) {
			$query = array(
				'explain' => $result->result()->resource()->explain(),
				'query' => $result->result()->resource()->info()
			);
			Data::append('queries', array($query));
//			echo "<pre>";
//			$GLOBALS['Show_SQL'] = $query['query'];
//			print (SHOW_SQL);
//			echo "</pre>";			

		}
		$GLOBALS['Show_SQL'] = 	Data::get('queries');
		return $result;
	});
	
	Data::append('timers', array('_filter_for_queries' => microtime(true) - $filter_start));
	
	return $chain->next($self, $params, $chain);
});

?>