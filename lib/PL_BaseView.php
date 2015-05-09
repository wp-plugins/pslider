<?php

class PL_BaseView {
	
	public function __construct() {

	}

	public function render( $name, $echo = true ) {

		$path = PSKELETON_BASEPATH . '/views/';

		if( ! $echo ) {

			ob_start();

			require $path . $name . ".php";

			$html = ob_get_contents();

			ob_end_clean();

			return $html;

		} else {
			
			require $path . $name . ".php";
				
		}

	}

}