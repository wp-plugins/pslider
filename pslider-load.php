<?php

class PSkeleton_Bootstrap extends PL_Bootstrap {

	protected $controllers;
    
    public static $icon = "/pslider/images/1390819074_kpresenter.png";
    
    public static $plugin_folder = 'pslider';
    
	public function __construct() {
	   
		// actions, filters, shortcodes here
        $tlr = false;
        
        // api
        PL_BaseAdd::wp_script('jQuery');
        PL_BaseAdd::wp_script('jquery-ui-sortable');
        PL_BaseAdd::wp_script('jquery-ui-draggable');
        PL_BaseAdd::wp_script('jquery-ui-droppable');
        
        // styles
        PL_BaseAdd::style(true, 'admin-style', self::$plugin_folder.'/css/admin-style.css' );
        PL_BaseAdd::style(false, 'front-style', self::$plugin_folder.'/css/front-style.css' );
        
        // scripts
        PL_BaseAdd::script(true, 'admin-script', self::$plugin_folder.'/js/admin-script.js' );
        PL_BaseAdd::script(false, 'front-script', self::$plugin_folder.'/js/front-script.js' );
        PL_BaseAdd::action(2, array( $this, 'media_scripts' ) );
        
        PL_BaseAdd::script(true, 'ajax_handler', self::$plugin_folder.'/js/ajax.js' );
        PL_BaseAdd::localize_script( true, 'ajax_handler', 'ajax_script', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        
        // shortcodes
        
        PL_BaseAdd::shortcode( 'pslider', array($this, 'pslider_function' ) );
        PL_BaseAdd::shortcode( 'pslider_album', array($this, 'pslider_album_function' ) );
        
        // filters
        PL_BaseAdd::filter('widget_text', 'do_shortcode');
        
        // actions
        PL_BaseAdd::action_loaded( array($this,'update_db_check') );
        
        PL_BaseAdd::action_submit(1, array($this, 'save_slides'));
        PL_BaseAdd::action_submit(1, array($this, 'delete_slides'));
        PL_BaseAdd::action_submit(1, array($this, 'add_slides'));
        
        PL_BaseAdd::action_submit(1, array($this, 'add_setting'));
        
        PL_BaseAdd::action_submit(1, array($this, 'option_action'));
        
        // actions group
        PL_BaseAdd::action_submit(1, array($this, 'save_group'));
        PL_BaseAdd::action_submit(1, array($this, 'delete_group'));
        PL_BaseAdd::action_submit(1, array($this, 'add_slides_group'));
        
        PL_BaseAdd::action_submit(1, array($this, 'save_photos'));
        
        // pages
        PL_BaseAdd::action_page( array($this, 'page'));
        
        // ajaxs
        PL_BaseAdd::action_ajax( array($this, 'ajax_sort') );
        PL_BaseAdd::action_ajax( array($this, 'ajax_group_option_update') );
        PL_BaseAdd::action_ajax( array($this, 'ajax_psg_sort') );
        PL_BaseAdd::action_ajax( array($this, 'ajax_psg_slides_delete') );
        PL_BaseAdd::action_ajax( array($this, 'ajax_group_selected') );
        
        if( $tlr == true ){
        
        // pika slider
        PL_BaseAdd::style(false, 'simple-style', self::$plugin_folder.'/styles/simple.css' );
        PL_BaseAdd::script(false, 'jcarousel-script', self::$plugin_folder.'/lib_js/jquery.jcarousel.min.js' );
        PL_BaseAdd::script(false, 'pikachoose-script', self::$plugin_folder.'/lib_js/jquery.pikachoose.min.js' );
        PL_BaseAdd::script(false, 'touchwipe-script', self::$plugin_folder.'/lib_js/jquery.touchwipe.min.js' );
        
        // easy slider
        PL_BaseAdd::script(false, 'easy-script', self::$plugin_folder.'/lib_js/easySlider1.7.js' );
        PL_BaseAdd::script(false, 'easy-script', self::$plugin_folder.'/lib_js/easySlider1.8.js' );
        
        // jcobb/bjqs slider
        PL_BaseAdd::style(false, 'bjqs-style', self::$plugin_folder.'/styles/bjqs.css' );
        PL_BaseAdd::style(false, 'demo-style', self::$plugin_folder.'/styles/demo.css' );
        PL_BaseAdd::script(false, 'bjqs-script', self::$plugin_folder.'/lib_js/bjqs-1.3.min.js' );
        
        // showInstances slider
        PL_BaseAdd::script(false, 'bjqs-script', self::$plugin_folder.'/lib_js/showInstances.js' );
        
        // gallerific js
        PL_BaseAdd::script(false, 'galleriffic-script', self::$plugin_folder.'/lib_js/galleriffic/jquery.galleriffic.js' );
        PL_BaseAdd::script(false, 'galleriffic-history', self::$plugin_folder.'/lib_js/galleriffic/jquery.history.js' );
        PL_BaseAdd::script(false, 'galleriffic-opacityrollover', self::$plugin_folder.'/lib_js/galleriffic/jquery.opacityrollover.js' );
        PL_BaseAdd::script(false, 'galleriffic-jush', self::$plugin_folder.'/lib_js/galleriffic/jush.js' );
        
        PL_BaseAdd::style(false, 'galleriffic-2', self::$plugin_folder.'/css/galleriffic/galleriffic-2.css' );
        
        }
        
        PL_BaseAdd::script(false, 'flexslide-demo', self::$plugin_folder.'/lib_js/flexs/demo.js' );
        PL_BaseAdd::script(false, 'flexslide-easy', self::$plugin_folder.'/lib_js/flexs/jquery.easing.js' );
        PL_BaseAdd::script(false, 'flexslide-flex', self::$plugin_folder.'/lib_js/flexs/jquery.flexslider.js' );
        PL_BaseAdd::script(false, 'flexslide-mousewheel', self::$plugin_folder.'/lib_js/flexs/jquery.mousewheel.js' );
        PL_BaseAdd::script(false, 'flexslide-shbrushjs', self::$plugin_folder.'/lib_js/flexs/shBrushJScript.js' );
        PL_BaseAdd::script(false, 'flexslide-shbrushxml', self::$plugin_folder.'/lib_js/flexs/shBrushXml.js' );
        PL_BaseAdd::script(false, 'flexslide-shcore', self::$plugin_folder.'/lib_js/flexs/shCore.js' );
        
        PL_BaseAdd::style(false, 'flexslide-demostyle', self::$plugin_folder.'/css/flexs/demo.css' );
        PL_BaseAdd::style(false, 'flexslide-flexstyle', self::$plugin_folder.'/css/flexs/flexslider.css' );
        
	}
    
    public function page(){
        
        $menu[] = array( 'PSlider', 'PSlider', 1, 'p_slider', array( $this, 'p_slider_function'), self::$icon );
        $menu[] = array( 'Add New Group', 'Add New Group', 1, 'p_slider', 'add_new_group_slide', array( $this, 'add_new_group_function' ) );
        $menu[] = array( 'Add New Photos', 'Add New Photos', 1, 'p_slider', 'add_new_photos', array( $this, 'add_new_photos_function' ) );
        $menu[] = array( 'Manage Photos', 'Manage Photos', 1, 'p_slider', 'manage_slides', array( $this, 'manage_slides_function' ) );
        
        $menu[] = array( 'Option', 'Option', 1, 'p_slider', 'option', array( $this, 'option_function' ) );
        //$menu[] = array( 'Settings', 'Settings', 1, 'p_slider', 'settings', array( $this, 'settings_function' ) );
        
        //$menu[] = array( 'Help?', 'Help?', 1, 'p_slider', 'documentation', array( $this, 'documentation_function' ) );
        if( is_array( $menu )){
            PL_BaseAdd::load_menu_page($menu);
        }
    }
    
    public function update_db_check() {
        global $db_version;
        if (get_site_option( 'db_version' ) != $db_version) {
            self::install();
        }
    }
    
    public static function install(){
        global $wpdb;
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        $table_pslider = $wpdb->prefix . "pslider"; 
        
        $sql1 = "CREATE TABLE $table_pslider (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          g_id int(9) NOT NULL,
          time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          title text NOT NULL,
          description text NOT NULL,
          position int(10) NOT NULL,
          g_position int(10) NOT NULL,
          url text NOT NULL,
          UNIQUE KEY id (id)
        );";
        
        dbDelta( $sql1 );
        
        $table_pgroup = $wpdb->prefix . "pslider_group"; 
        
        $sql2 = "CREATE TABLE $table_pgroup (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          name text NOT NULL,
          description text NOT NULL,
          paginate int(10) NOT NULL,
          position int(10) NOT NULL,
          value VARCHAR(2000) DEFAULT '' NOT NULL,
          UNIQUE KEY id (id)
        );";
        
        dbDelta( $sql2 );
    }
    
    public function media_scripts(){
        PL_BaseAdd::wp_media(); /** wp_enqueue_media(); **/
        PL_BaseAdd::wp_script( 'media-upload' );
        PL_BaseAdd::wp_script( 'thickbox' );
    }
    
    // pages
    
    public function p_slider_function(){
        PL_BaseLoad::view("pslider");
    }
    
    public function manage_slides_function(){
        PL_BaseLoad::view("manage-slides");
    }
    
    public function add_new_photos_function(){
        PL_BaseLoad::view("add-new-photos");
    }
    
    public function add_new_slide_function(){
        PL_BaseLoad::view("add-new-slide");
    }
    
    public function add_new_group_function(){
        PL_BaseLoad::view("add-new-group");
    }
    
    public function settings_function(){
        PL_BaseLoad::view("settings");
    }
    
    public function documentation_function(){
        PL_BaseLoad::view("documentation"); 
    }
    
    public function option_function(){
        PL_BaseLoad::view("option"); 
    }
    
    // actions
    
    public function save_slides(){
        PL_Actions::save();
    }
    
    public function delete_slides(){
        PL_Actions::delete();
    }
    
    public function add_slides(){
        PL_Actions::add_load();
    }
    
    public function add_setting(){
        PL_Actions::change();
    }
    
    public function option_action(){
        PL_Actions::option_submit();
    }
    
    // group action
    
    public function save_group(){
        PL_Actions::save_group();
    }
    
    public function delete_group(){
        PL_Actions::delete_group();
    }
    
    public function add_slides_group(){
        PL_Actions::add_group_load();
    }
    
    public function save_photos(){
        PL_Actions::save_photos();
    }
    
    // ajaxs
    public function ajax_sort(){
        PL_Actions::update_position_ajax_sort();
        die();
    }
    
    public function ajax_group_option_update(){
        PL_Actions::group_option_update();
        die();
    }
    
    public function ajax_psg_sort(){
        PL_Actions::update_position_ajax_psg_sort();
        die();
    }
    
    public function ajax_psg_slides_delete(){
        PL_Actions::ajax_group_slides_delete();
        die();
    }
    
    public function ajax_group_selected(){
        PL_Actions::ajax_group_selected_filter();
        die();
    }
    
    // shortcodes
    
    public function pslider_function($atts){
       extract(shortcode_atts(array('id' => '', 'type' => '' ), $atts)); 
 
       if( $atts['type'] == 'easy' ){
           PL_BaseLoad::view("shortcode", $atts);
           
       } else if( $atts['type'] == 'mini') { 
           
           $atts_id = !empty($atts['id']) ? intval( $atts['id'] ) : null;
           if( $atts_id == true ){
               PL_BaseLoad::view("shortcode", $atts);
               return miniSliderContent($atts_id);
           }
           
       } else if( $atts['type'] == 'flexslider' ){
        
           $atts_id = !empty($atts['id']) ? intval( $atts['id'] ) : null;
           if( $atts_id == true ){
               PL_BaseLoad::view("shortcode", $atts);
               return flexSliderContent($atts_id);
           }
  
       }else {
           $atts_id = !empty($atts['id']) ? intval( $atts['id'] ) : null;
           if( $atts_id == true ){
               PL_BaseLoad::view("shortcode", $atts);
               return easySliderContent($atts_id);
           }
       }
    }
    
    public function pslider_album_function(){
        PL_BaseLoad::view("shortcode-album", $atts);
        return display();
    }
    

}