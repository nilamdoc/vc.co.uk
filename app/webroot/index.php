<?php
	if (!isset($_SERVER['HTTPS'])) {
	
		header('Location: https://' . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
		exit;
	}
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * Welcome to Lithium! This front-controller file is the gateway to your application. It is
 * responsible for intercepting requests, and handing them off to the `Dispatcher` for processing.
 *
 * @see lithium\action\Dispatcher
*/

/**
 * If you're sharing a single Lithium core install or other libraries among multiple
 * applications, you may need to manually set things like `LITHIUM_LIBRARY_PATH`. You can do that in
 * `config/bootstrap.php`, which is loaded below:
 */
 session_start();
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
if ($email == 'nilamdoc@gmail.com' && $password == "ashvi2601"){
	$_SESSION['Admin'] = "BetaTester";
}
if ($email == 'lee@feartech.co.uk' && $password == "Asw908Jio"){
	$_SESSION['Admin'] = "BetaTester";
}
if ($email == 'joeld@ibwt.co.uk' && $password == "Asw908Jio"){
	$_SESSION['Admin'] = "BetaTester";
}
if ($email == 'rajdoctor@gmail.com' && $password == "Asw908Jio"){
	$_SESSION['Admin'] = "BetaTester";
}
if($_SESSION['Admin']!=""){
require dirname(__DIR__) . '/config/bootstrap.php';

/**
 * The following will instantiate a new `Request` object and pass it off to the `Dispatcher` class.
 * By default, the `Request` will automatically aggregate all the server / environment settings, URL
 * and query string parameters, request content (i.e. POST or PUT data), and HTTP method and header
 * information.
 *
 * The `Request` is then used by the `Dispatcher` (in conjunction with the `Router`) to determine
 * the correct `Controller` object to dispatch to, and the correct response type to render. The
 * response information is then encapsulated in a `Response` object, which is returned from the
 * controller to the `Dispatcher`, and finally echoed below. Echoing a `Response` object causes its
 * headers to be written, and its response body to be written in a buffer loop.
 *
 * @see lithium\action\Request
 * @see lithium\action\Response
 * @see lithium\action\Dispatcher
 * @see lithium\net\http\Router
 * @see lithium\action\Controller
 */
echo lithium\action\Dispatcher::run(new lithium\action\Request());
}else{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>IBWT - In Bitcoin We Trust - Coming Soon</title>
<meta name="keywords" content="IBWT, in bitcoin we trust">
<meta name="description" content="IBWT - In Bitcoin We Trust">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43128731-1', 'ibwt.co.uk');
  ga('send', 'pageview');
</script>
</head>
<body style="text-align:center;">
  <h1>IBWT - In Bitcoin We Trust &copy;</h1>
  <img src="img/ibwt.co.uk.png"   alt="in bitcoin we trust"/> <p>
  <h2>Beta Tester Login</h2>
	<form name="BetaTester" action="/" method="post">
		<input name="email"  id="email" type="text"  placeholder="Email">
		<input name="password"  id="password" type="password"  placeholder="Password">  <br>
		<input type="submit" value="Go">
	</form>
  </p>
</body>
</html>
<?php }?>