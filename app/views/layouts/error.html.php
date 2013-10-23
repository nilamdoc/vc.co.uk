<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * This layout is used to render error pages in both development and production. It is recommended
 * that you maintain a separate, simplified layout for rendering errors that does not involve any
 * complex logic or dynamic data, which could potentially trigger recursive errors.
 */
?><!doctype html>
<html>
<head>
	<?php echo $this->html->charset(); ?>
	<title>Unhandled exception</title>
	<?php echo $this->html->style(array('debug', 'lithium')); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body class="app">
	<div id="container">
		<div id="header">
			<h1>Some error!</h1>
			<h3>Check the URL you have entered!</h3>
		</div>
		<div id="content">
			<?php   echo $this->content(); ?>
		</div>
	</div>
</body>
</html>

<!doctype html>
<html>
<head></head>
<body>
<h4>In Bitcoin We Trust</h4>
<p>Please report the steps you did to to get to this page to support@ibwt.co.uk</p>
<a href="https://ibwt.co.uk">Go back to site!</a>
</body>
</html>