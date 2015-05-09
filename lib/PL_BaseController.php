<?php

class PL_BaseController {

	public function __construct() {

		$this->view = new PL_BaseView();

	}

	public function loadModel( $model_name ) {

		$path = PSKELETON_BASEPATH . '/models/';

		$file = $path . strtolower($model_name) . "_model.php";

		require $file;

		if( file_exists( $file) ) {

			$modelName = $model_name . '_Model';

			$this->model = new $modelName();
		}

	}
	
}