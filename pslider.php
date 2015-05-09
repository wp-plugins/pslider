<?php
/*
Plugin Name: WP PSlider
Description: This particular plugin has the ability to group, manage and upload mulitple image.
Version: 1.0.0
Author: Plonta Creative
Author URI: http://plontacreative.com/wp-plugins
*/

error_reporting(E_ALL);

// replace PSkeleton_Bootsrap with the name of your Bootstrap Class	
if( ! class_exists('PSkeleton_Bootstrap') ) {

	require 'config/constants.php';

	if(! class_exists('PL_BaseController') ) { 
		require PSlIDER_LIB . '/PL_BaseController.php';
	}

	if(! class_exists('PL_BaseModel') ) { 
		require PSlIDER_LIB . '/PL_BaseModel.php';
	}

	if(! class_exists('PL_BaseView') ) { 
		require PSlIDER_LIB . '/PL_BaseView.php';
	}
   
	if(! class_exists('PL_Bootstrap') ) { 
		require PSlIDER_LIB . '/PL_Bootstrap.php';
	}
    
    // new load classes
    
    if(! class_exists('PL_BaseLoad') ){
        require PSlIDER_LIB . '/PL_BaseLoad.php';
    }
    
    if(! class_exists('PL_BaseAdd') ){
        require PSlIDER_LIB . '/PL_BaseAdd.php';
    }
    
    if(! class_exists('PL_BaseHtml')){
        require PSlIDER_LIB . '/PL_BaseHtml.php';
    }
    
    if(! class_exists('PL_BaseInput')){
        require PSlIDER_LIB . '/PL_BaseInput.php';
    }
    
    if(! class_exists('PL_BaseUpload')){
        require PSlIDER_LIB . '/PL_BaseUpload.php';
    }
    
    // controller files
    PL_BaseLoad::control("PL_Actions");     
    
    // models files
    PL_BaseLoad::model("PL_DB");    
    
    // new load classes 
    
	// replace pskeelton-bootsrap.php with your bootstrap file name
	require 'pslider-load.php';
    
    register_activation_hook( __FILE__, 'jal_install_data' );
    
	// replace PSkeleton_Bootsrap with the name of your Bootstrap Class	
	spl_autoload_register( array('PSkeleton_Bootstrap', 'autoloadControllers') );

	$pskBootstrap = new PSkeleton_Bootstrap();

}