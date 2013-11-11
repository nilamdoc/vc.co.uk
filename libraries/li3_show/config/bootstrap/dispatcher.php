<?php
use lithium\action\Dispatcher;
use lithium\template\View;
use lithium\core\Libraries;
use lithium\net\http\Router;

Dispatcher::applyFilter('_callable', function($self, $params, $chain) {
	$result = $chain->next($self, $params, $chain);
	return $result;
});
Dispatcher::applyFilter('_call', function($self, $params, $chain) {
	$result = $chain->next($self, $params, $chain);
	return $result;
});

Dispatcher::applyFilter('run', function($self, $params, $chain) {
		$result = $chain->next($self, $params, $chain);
		$li3_show = Libraries::get('li3_show');
		
		$View = new View(array(
			'paths' => array(
				'template' => $li3_show['path'].'/views/index.html.php',
				'layout'   => '{:library}/views/layouts/{:layout}.{:type}.php',
			)
		));
		$Show_SQL_View = $View->render('all', array($GLOBALS['Show_SQL']));
		if (!isset($result->body[0])) {
			$result = $Show_SQL_View . $result;
		}else{
			$result->body[0] = $Show_SQL_View . $result->body[0];
		}
	return $result;
});

?>