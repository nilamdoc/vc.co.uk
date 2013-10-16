<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\core\ErrorHandler;
use lithium\action\Response;
use lithium\net\http\Media;
use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

ErrorHandler::apply('lithium\action\Dispatcher::run', array(), function($info, $params) {
	$response = new Response(array(
		'request' => $params['request'],
		'status' => $info['exception']->getCode()
	));

	Media::render($response, compact('info', 'params'), array(
		'library' => true,
		'controller' => '_errors',
		'template' => 'development',
		'layout' => 'error',
		'request' => $params['request']
	));

	$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));
		$email = 'nilam@ibwt.co.uk';
			$body = $view->render(
				'template',
				compact('response'),
				array(
					'controller' => 'users',
					'template'=>'error',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("ERROR ".COMPANY_URL);
			$message->setFrom(array(NOREPLY => 'ERROR '.COMPANY_URL));
			$message->setTo($email);
			$message->setBody($body,'text/html');
			$mailer->send($message);

	return $response;
});

?>