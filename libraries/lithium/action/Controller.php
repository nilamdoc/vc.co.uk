<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace lithium\action;

use lithium\util\Inflector;
use lithium\action\DispatchException;
use lithium\core\Libraries;

/**
 * The `Controller` class is the fundamental building block of your application's request/response
 * cycle. Controllers are organized around a single logical entity, usually one or more model
 * classes (i.e. `lithium\data\Model`) and are tasked with performing operations against that
 * entity.
 *
 * Each controller has a series of 'actions' which are defined as class methods of the `Controller`
 * classes. Each action has a specific responsibility, such as listing a set of objects, updating an
 * object, or deleting an object.
 *
 * A controller object is instantiated by the `Dispatcher` (`lithium\action\Dispatcher`), and is
 * given an instance of the `lithium\action\Request` class, which contains all necessary request
 * state, including routing information, `GET` & `POST` data, and server variables. The controller
 * is then invoked (using PHP's magic `__invoke()` syntax), and the proper action is called,
 * according to the routing information stored in the `Request` object.
 *
 * A controller then returns a response (i.e. using `redirect()` or `render()`) which includes HTTP
 * headers, and/or a serialized data response (JSON or XML, etc.) or HTML webpage.
 *
 * For more information on returning serialized data responses for web services, or manipulating
 * template rendering from within your controllers, see the settings in `$_render` and the
 * `lithium\net\http\Media` class.
 *
 * @see lithium\net\http\Media
 * @see lithium\action\Dispatcher
 * @see lithium\action\Controller::$_render
 */
class Controller extends \lithium\core\Object {

	/**
	 * Contains an instance of the `Request` object with all the details of the HTTP request that
	 * was dispatched to the controller object. Any parameters captured in routing, such as
	 * controller or action name are accessible as properties of this object, i.e.
	 * `$this->request->controller` or `$this->request->action`.
	 *
	 * @see lithium\action\Request
	 * @var object
	 */
	public $request = null;

	/**
	 * Contains an instance of the `Response` object which aggregates the headers and body content
	 * to be written back to the client (browser) when the result of the request is rendered.
	 *
	 * @see lithium\action\Response
	 * @var object
	 */
	public $response = null;

	/**
	 * Lists the rendering control options for responses generated by this controller.
	 *
	 * - The `'type'` key is the content type that will be rendered by default, unless another is
	 *   explicitly specified (defaults to `'html'`).
	 * - The `'data'` key contains an associative array of variables to be sent to the view,
	 *   including any variables created in `set()`, or if an action returns any variables (as an
	 *   associative array).
	 * - When an action is invoked, it will by default attempt to render a response, set the
	 *   `'auto'` key to `false` to prevent this behavior.
	 * - If you manually call `render()` within an action, the `'hasRendered'` key stores this
	 *   state, so that responses are not rendered multiple times, either manually or automatically.
	 * - The `'layout'` key specifies the name of the layout to be used (defaults to `'default'`).
	 *   Typically, layout files are looked up as
	 *   `<app-path>/views/layouts/<layout-name>.<type>.php`. Based on the default settings, the
	 *   actual path would be `path-to-app/views/layouts/default.html.php`.
	 * - Though typically introspected from the action that is executed, the `'template'` key can be
	 *   manually specified. This sets the template to be rendered, and is looked up (by default) as
	 *   `<app-path>/views/<controller>/<action>.<type>.php`, i.e.:
	 *   `path-to-app/views/posts/index.html.php`.
	 * - To enable automatic content-type negotiation (i.e. determining the content type of the
	 *   response based on the value of the
	 *   [HTTP Accept header](http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html)), set the
	 *   `'negotiate'` flag to `true`. Otherwise, the response will only be based on the `type`
	 *   parameter of the request object (defaulting to `'html'` if no type is present in the
	 *   `Request` parameters).
	 *
	 * Keep in mind that most of these settings may be passed to `Controller::render()` as well. To
	 * change how these settings operate (i.e. template paths, default render settings for
	 * individual media types), see the `Media` class.
	 *
	 * @var array
	 * @see lithium\action\Controller::render()
	 * @see lithium\net\http\Media::type()
	 * @see lithium\net\http\Media::render()
	 */
	protected $_render = array(
		'type'        => null,
		'data'        => array(),
		'auto'        => true,
		'layout'      => 'default',
		'template'    => null,
		'hasRendered' => false,
		'negotiate'   => false
	);

	/**
	 * Lists `Controller`'s class dependencies. For details on extending or replacing a class,
	 * please refer to that class's API.
	 *
	 * @var array
	 */
	protected $_classes = array(
		'media' => 'lithium\net\http\Media',
		'router' => 'lithium\net\http\Router',
		'response' => 'lithium\action\Response'
	);

	/**
	 * Auto configuration properties.
	 *
	 * @var array
	 */
	protected $_autoConfig = array('render' => 'merge', 'classes' => 'merge');

	public function __construct(array $config = array()) {
		$defaults = array(
			'request' => null, 'response' => array(), 'render' => array(), 'classes' => array()
		);
		parent::__construct($config + $defaults);
	}

	/**
	 * Populates the `$response` property with a new instance of the `Response` class passing it
	 * configuration, and sets some rendering options, depending on the incoming request.
	 *
	 * @return void
	 */
	protected function _init() {
		parent::_init();
		$this->request = $this->request ?: $this->_config['request'];
		$this->response = $this->_instance('response', $this->_config['response']);

		if (!$this->request || $this->_render['type']) {
			return;
		}
		if ($this->_render['negotiate']) {
			$this->_render['type'] = $this->request->accepts();
			return;
		}
		$this->_render['type'] = $this->request->get('params:type') ?: 'html';
	}

	/**
	 * Called by the Dispatcher class to invoke an action.
	 *
	 * @param object $request The request object with URL and HTTP info for dispatching this action.
	 * @param array $dispatchParams The array of parameters that will be passed to the action.
	 * @param array $options The dispatch options for this action.
	 * @return object Returns the response object associated with this controller.
	 * @filter This method can be filtered.
	 */
	public function __invoke($request, $dispatchParams, array $options = array()) {
		$render =& $this->_render;
		$params = compact('request', 'dispatchParams', 'options');

		return $this->_filter(__METHOD__, $params, function($self, $params) use (&$render) {
			$dispatchParams = $params['dispatchParams'];

			$action = isset($dispatchParams['action']) ? $dispatchParams['action'] : 'index';
			$args = isset($dispatchParams['args']) ? $dispatchParams['args'] : array();
			$result = null;

			if (substr($action, 0, 1) == '_' || method_exists(__CLASS__, $action)) {
				throw new DispatchException('Attempted to invoke a private method.');
			}
			if (!method_exists($self, $action)) {
				throw new DispatchException("Action `{$action}` not found.");
			}
			$render['template'] = $render['template'] ?: $action;

			if ($result = $self->invokeMethod($action, $args)) {
				if (is_string($result)) {
					$self->render(array('text' => $result));
					return $self->response;
				}
				if (is_array($result)) {
					$self->set($result);
				}
			}

			if (!$render['hasRendered'] && $render['auto']) {
				$self->render();
			}
			return $self->response;
		});
	}

	/**
	 * This method is used to pass along any data from the controller to the view and layout
	 *
	 * @param array $data sets of `<variable name> => <variable value>` to pass to view layer.
	 * @return void
	 */
	public function set($data = array()) {
		$this->_render['data'] = (array) $data + $this->_render['data'];
	}

	/**
	 * Uses results (typically coming from a controller action) to generate content and headers for
	 * a `Response` object.
	 *
	 * @see lithium\action\Controller::$_render
	 * @param array $options An array of options, as follows:
	 *        - `'data'`: An associative array of variables to be assigned to the template. These
	 *          are merged on top of any variables set in `Controller::set()`.
	 *        - `'head'`: If true, only renders the headers of the response, not the body. Defaults
	 *          to `false`.
	 *        - `'template'`: The name of a template, which usually matches the name of the action.
	 *          By default, this template is looked for in the views directory of the current
	 *          controller, i.e. given a `PostsController` object, if template is set to `'view'`,
	 *          the template path would be `views/posts/view.html.php`. Defaults to the name of the
	 *          action being rendered.
	 *
	 * The options specified here are merged with the values in the `Controller::$_render`
	 * property. You may refer to it for other options accepted by this method.
	 * @return object Returns the `Response` object associated with this `Controller` instance.
	 */
	public function render(array $options = array()) {
		$media = $this->_classes['media'];
		$class = get_class($this);
		$name = preg_replace('/Controller$/', '', substr($class, strrpos($class, '\\') + 1));
		$key = key($options);

		if (isset($options['data'])) {
			$this->set($options['data']);
			unset($options['data']);
		}
		$defaults = array(
			'status'     => null,
			'location'   => false,
			'data'       => null,
			'head'       => false,
			'controller' => Inflector::underscore($name),
			'library'    => Libraries::get($class)
		);

		$options += $this->_render + $defaults;

		if ($key && $media::type($key)) {
			$options['type'] = $key;
			$this->set($options[$key]);
			unset($options[$key]);
		}

		$this->_render['hasRendered'] = true;
		$this->response->type($options['type']);
		$this->response->status($options['status']);
		$this->response->headers('Location', $options['location']);

		if ($options['head']) {
			return;
		}
		$response = $media::render($this->response, $this->_render['data'], $options + array(
			'request' => $this->request
		));
		return ($this->response = $response ?: $this->response);
	}

	/**
	 * Creates a redirect response by calling `render()` and providing a `'location'` parameter.
	 *
	 * @see lithium\net\http\Router::match()
	 * @see lithium\action\Controller::$response
	 * @param mixed $url The location to redirect to, provided as a string relative to the root of
	 *              the application, a fully-qualified URL, or an array of routing parameters to be
	 *              resolved to a URL. Post-processed by `Router::match()`.
	 * @param array $options Options when performing the redirect. Available options include:
	 *              - `'status'` _integer_: The HTTP status code associated with the redirect.
	 *                Defaults to `302`.
	 *              - `'head'` _boolean_: Determines whether only headers are returned with the
	 *                response. Defaults to `true`, in which case only headers and no body are
	 *                returned. Set to `false` to render a body as well.
	 *              - `'exit'` _boolean_: Exit immediately after rendering. Defaults to `false`.
	 *                Because `redirect()` does not exit by default, you should always prefix calls
	 *                with a `return` statement, so that the action is always immediately exited.
	 * @return object Returns the instance of the `Response` object associated with this controller.
	 * @filter This method can be filtered.
	 */
	public function redirect($url, array $options = array()) {
		$router = $this->_classes['router'];
		$defaults = array('location' => null, 'status' => 302, 'head' => true, 'exit' => false);
		$options += $defaults;
		$params = compact('url', 'options');
print_r("1");
		$this->_filter(__METHOD__, $params, function($self, $params) use ($router) {
			$options = $params['options'];
			$location = $options['location'] ?: $router::match($params['url'], $self->request);
			$self->render(compact('location') + $options);
		});
print_r("2");
		if ($options['exit']) {
			$this->response->render();
print_r("3");			
			$this->_stop();
		}
print_r($this->response);		
		return $this->response;
//print_r("5");		
//exit;
	}
}

?>