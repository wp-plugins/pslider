<?php

/**
 * TODO
 * 1. Library Dependency Loader
 * 2. removeAction
 * 3. removeFilter
 */

class PL_Bootstrap {

	protected $controllers;

	public function __construct() {}

	/**
	 * Custom add action which accepts the same arguments as the add_action of wordpress. 
	 * 1st Argument - @type string   Hook name
	 * 2nd Argument - @type array   Must be an array('Controller', 'function')
	 * 3rd Argument (optional) - @type int   Priority 
	 * 4th Argument (optional) - @type int   Number of parameters
	 */
	public function addAction() {

		$numArgs = func_num_args();
		

		if( $numArgs < 2 ) {
			throw new Exception("Action requires a hook and a function handler.");
		}

		$hook 	= func_get_arg(0);

		$param 	= func_get_arg(1);

		if( count( $param ) != 2 ) {
			throw new Exception("Second argument of the addAction() must be an array with 1st argument as the Controller and 2nd for the function.");
		}

		list( $controller, $function ) = $param;
		// equivalent to: $controller = $param[0]; $function = $param[1];

		$handler = array();

		// @TODO - passing the __CLASS__ as the controller will result to error
		if( is_string($controller) && ! is_subclass_of($controller, __CLASS__)) {
			$this->{$controller} = new $controller;
			$handler[0] = $this->{$controller};
		} else {
			$handler[0] = $controller;
		}	

		$handler[1] = $function;
		
		if( $numArgs == 2 ) {
			//add_action( $hook, array( $this->{$controller}, $function ) );
			add_action( $hook, $handler );
		} else if( $numArgs == 3 ) {
			//add_action( $hook, array( $this->{$controller}, $function ), func_get_arg(2) );
			add_action( $hook, $handler, func_get_arg(2) );
		} else if( $numArgs == 4 ) {
			//add_action( $hook, array( $this->{$controller}, $function ), func_get_arg(2), func_get_arg(3) );
			add_action( $hook, $handler, func_get_arg(2), func_get_arg(3) );
		}

	}


	/**
	 * Custom remove action which accepts the same arguments as the remove_action of wordpress
	 * 1st Argument - @type string   Hook name
	 * 2nd Argument - @type array   Must be an array('Controller', 'function')
	 * 3rd Argument (optional) - @type int   Priority 
	 * 4th Argument (optional) - @type int   Number of parameters	
	 */
	public function removeAction() {

		$numArgs = func_num_args();

		if( $numArgs < 2 ) {
			throw new Exception("Action requires a hook and a function handler.");
		}

		$hook 	= func_get_arg(0);
		$param 	= func_get_arg(1);


		list( $controller, $function ) = $param;

		$handler = array();


		if( is_string($controller) && $this->{$controller} ) {
			$handler[0] = $this->{$controller};
		} else {
			$handler[0] = $controller;
		}	

		$handler[1] = $function;

		if( $numArgs == 2 ) {
			remove_action( $hook, $handler );
		} else if( $numArgs == 3 ) {
			remove_action( $hook, $handler, func_get_arg(2) );
		} else if( $numArgs == 4 ) {
			remove_action( $hook, $handler, func_get_arg(2), func_get_arg(3) );
		}

	}

	/**
	 * Custom add action which accepts the same arguments as the add_action of wordpress. 
	 * 1st Argument - @type string   Hook name
	 * 2nd Argument - @type array   Must be an array('Controller', 'function')
	 * 3rd Argument (optional) - @type int   Priority 
	 * 4th Argument (optional) - @type int   Number of parameters
	 */
	public function addFilter() {
		$numArgs = func_num_args();

		if( $numArgs < 2 ) {
			throw new Exception("Action requires a hook and a function handler.");
		}

		$hook 	= func_get_arg(0);

		$param 	= func_get_arg(1);

		if( count( $param ) != 2 ) {
			throw new Exception("Second argument of the addAction() must be an array with 1st argument as the Controller and 2nd for the function.");
		}

		list( $controller, $function ) = $param;
		// equivalent to: $controller = $param[0]; $function = $param[1];

		$handler = array();

		if( is_string($controller) && ! is_subclass_of($controller, __CLASS__)) {
			$this->{$controller} = new $controller;
			$handler[0] = $this->{$controller};
		} else {
			$handler[0] = $controller;
		}	

		$handler[1] = $function;
		
		if( $numArgs == 2 ) {
			//add_filter( $hook, array( $this->{$controller}, $function ) );
			add_filter( $hook, $handler );
		} else if( $numArgs == 3 ) {
			//add_filter( $hook, array( $this->{$controller}, $function ), func_get_arg(2) );
			add_filter( $hook, $handler, func_get_arg(2) );
		} else if( $numArgs == 4 ) {
			//add_filter( $hook, array( $this->{$controller}, $function ), func_get_arg(2), func_get_arg(3) );
			add_filter( $hook, $handler, func_get_arg(2), func_get_arg(3) );
		}
	}


	/**
	 * Custom add shortcode which accepts the same arguments as the add_shortcode of wordpress.
	 * 1st Argument - @type string   Hook name
	 * 2nd Argument - @type array   Must be an array('Controller', 'function')
	 */
	public function addShortcode( $shortcode, $param ) {

		if( count( $param ) != 2 ) {
			throw new Exception("Action requires only two parameters.");
		}

		list( $controller, $function ) = $param;

		$handler = array();

		if( is_string($controller) && ! is_subclass_of($controller, __CLASS__)) {
			$this->{$controller} = new $controller;
			$handler[0] = $this->{$controller};
		} else {
			$handler[0] = $controller;
		}


		//add_shortcode( $shortcode, array( $this->{$controller}, $function ) );
		add_shortcode( $shortcode, $handler );
	}

	public function __set( $key, $value ) {

		$this->controllers[$key] = $value;

	}

	public function __get($key) {

		if( ! isset($this->controllers[$key] ) ) {
			throw new Exception("Undefine $key class member. ");
		}

		return $this->controllers[$key];

	}
	

	/**
	 * The Controller autoloader class
	 */
	public static function autoloadControllers( $class ) {

		$path = PSLIDER_BASEPATH . '/controllers/';

		$file = $path . $class . '.php';

		if( file_exists( $file ) ) {

			require $file;
		}

	}


}