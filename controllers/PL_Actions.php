<?php if( !class_exists('PL_Actions')){

    class PL_Actions{
        
        public static $tb = 'pslider';
        
        public static $tb_group = 'pslider_group';
        
        public static function save(){
           global $wpdb;
            
           $is_post = PL_BaseInput::post_is_object(); 
           $is_get = PL_BaseInput::get_is_object();
           
           $tb_name = $wpdb->prefix . PL_Actions::$tb;
           
           if( isset( $is_post->save ) ){
           
               $title = !empty($is_post->title) ? stripslashes_deep($is_post->title) : null;
               $desc  = !empty($is_post->desc) ? stripslashes_deep($is_post->desc) : null;
               $upload = !empty($is_post->single_values) ? serialize($is_post->single_values) : null;
               $gid = !empty($is_post->select_group) ? intval($is_post->select_group) : null;
               
           } else {
            
               if( isset( $is_post->update )){
                   
                   $title = !empty($is_post->title) ? stripslashes_deep($is_post->title) : null;
                   $desc  = !empty($is_post->desc) ? stripslashes_deep($is_post->desc) : null;
                   $upload = !empty($is_post->single_values) ? serialize($is_post->single_values) : null;
                   $gid = !empty($is_post->select_group) ? intval($is_post->select_group) : null;

               }
           } 
           if( isset( $is_post->save ) ){

               if(!empty($title)){
                   
                   $max_position_id = PL_DB::query_row_max_position($tb_name);
                   
                   $multi_text = !empty($is_post->multi_text_values) ? $is_post->multi_text_values: null;
                   if(!empty($multi_text)){
                       $serial_multi_text = serialize( $multi_text );
                   } else {
                       $serial_multi_text = serialize( array());
                   }
                   
                   $field = array( 'title' => $title, 'description' => $desc, 'url' => $upload, 'position' => $max_position_id, 'g_id' => $gid, 'multi_text' => $serial_multi_text );           
                   $field_format = array( '%s', '%s', '%s', '%s', '%d' );
                   
                   PL_DB::insert($tb_name, $field, $field_format);
                   
                   wp_redirect( 'admin.php?page=manage_slides', 301 ); 
                   exit; 
               }
               
           } else {
               
               if( isset( $is_post->update )){
      
                   $multi_text = !empty($is_post->multi_text_values) ? $is_post->multi_text_values: null;
                   if(!empty($multi_text)){
                       $serial_multi_text = serialize( $multi_text );
                   } else {
                       $serial_multi_text = serialize( array());
                   }
                   
                   $field = array( 'title' => $title,  'description' => $desc, 'url' => $upload, 'g_id' => $gid, 'multi_text' => $serial_multi_text );           
                   $field_format = array( '%s', '%s', '%s', '%d', '%s' );
                   
                   $field_id = array( 'id' => $is_get->psid );
                   $field_id_format = array(  '%d' );
                   
                   PL_DB::update($tb_name, $field, $field_id, $field_format, $field_id_format);
               }
                
           }
        }
        
        public static function delete(){
            global $wpdb;
             
            $is_post = PL_BaseInput::post_is_object(); 
            
            $tb_name = $wpdb->prefix . PL_Actions::$tb;
            
            if( isset( $is_post->delete ) ){
                
                $checked = $is_post->delete_checked;
                
                if( !empty($checked) ){
                    
                     foreach($checked as $checked_row => $checked_val){
                          
                          $int_id = intval($checked_val);
                          
                          $field = array( 'id' => $int_id );
                          
                          $field_format = array( '%d' );
                           
                          PL_DB::delete( $tb_name, $field, $field_format );

                     }
                     
                     wp_redirect( 'admin.php?page=manage_slides', 301 ); 
                     exit; 
                     
                }
                
            }
        }
        
        public static function add_load(){
            
            $is_post = PL_BaseInput::post_is_object(); 
            
            if( isset($is_post->add)){ 
                
                wp_redirect( 'admin.php?page=add_new_slide', 301 ); 
                exit; 
            }
             
        }
        
        public static function add_group_load(){
            
            $is_post = PL_BaseInput::post_is_object(); 
            
            if( isset($is_post->add_group)){ 
                
                wp_redirect( 'admin.php?page=add_new_group_slide', 301 ); 
                exit; 
            }
             
        }
        
        public static function update_position_ajax_sort(){
            global $wpdb;
            
            $is_post = PL_BaseInput::post_is_object(); 
            
            $tb_name = $wpdb->prefix . PL_Actions::$tb;
             
            if( isset($is_post->action )){
                
                /** xxxxxxxxxxxxxxxx join update status sort xxxxxxxxxxxxxxxxx **/
                
                $g_id_value = ( $is_post->g_id_value );
                $g_id_int = explode('.',$g_id_value);
                
                if(!empty($g_id_int)){
                    
                    foreach($g_id_int as $g_id_int_key => $g_id_int_val){
                        
                     if($g_id_int_val!=0){
                        if(!empty($g_id_int_val)){
                            
                            $int_val = explode('-',$g_id_int_val);
                            
                            if(!empty($int_val)){
                                
                                $key_val_id = intval($int_val[0]);
                                
                                foreach( $int_val as $int_val_row => $int_val_res ){
                                  if($int_val_row!=0){  
          
                                    if( intval($int_val_res) AND $int_val_res!=0){
      
                                        $field_val = array( 'g_position' => $int_val_row, 'g_id' => $key_val_id );           
                                        $field_val_format = array( '%d' );
                                            
                                        $field_val_id = array( 'id' => intval($int_val_res) ); 
                                        $field_val_id_format = array( '%d' );
                                                       
                                        PL_DB::update($tb_name, $field_val, $field_val_id, $field_val_format, $field_val_id_format );
                                        
                                    }
                                  }
                                }
                            }
                        }
                     }
                    }
                }
                
                /** xxxxxxxxxxxxxxxx join update status sort xxxxxxxxxxxxxxxxx **/
                
                $value = $is_post->id_value;
                $expl_val = explode(',', $value);
                
                if(is_array($expl_val)){
                    $count = 1;
                    foreach($expl_val as $expl_val_row => $expl_val_res){
                        
                        $val_id = intval($expl_val[$expl_val_row]);
        
                        $field = array( 'position' => $count );           
                        $field_format = array( '%d' );
                            
                        $field_id = array( 'id' => $val_id );
                        $field_id_format = array(  '%d' );

                        PL_DB::update( $tb_name, $field, $field_id, $field_format, $field_id_format );
                        
                        $count++;
                        
                    }
                }
                
            }
            
        }
        
        public static function change(){
            global $wpdb;
            
            $is_post = PL_BaseInput::post_is_object(); 
            
            if( isset($is_post->save_changes) ){ 
                
                $get_id_value = get_option("pslider_id"); 
                $get_time_value = get_option("time_pslider");
                $get_speed_value = get_option("speed_pslider");
                $get_image_limit_value = get_option("image_limit_pslider");
                
                if( !empty($get_id_value)){
                     $id_value = ($is_post->pslider_id);
                     update_option( 'id_pslider', $id_value );
                } else {
                     $id_value = ($is_post->pslider_id);
                     add_option( 'id_pslider', $id_value, '', 'yes' );
                }
                
                if( !empty($get_time_value)){
                     $time_value = intval($is_post->time);
                     update_option( 'time_pslider', $time_value );
                } else {
                     $time_value = intval($is_post->time);
                     add_option( 'time_pslider', $time_value, '', 'yes' );
                }
                
                if( !empty($get_speed_value)){
                     $speed_value = intval($is_post->speed);
                     update_option( 'speed_pslider', $speed_value );
                } else {
                     $speed_value = intval($is_post->speed);
                     add_option( 'speed_pslider', $speed_value, '', 'yes' );
                }
                
                if( !empty($get_image_limit_value)){
                     $image_limit_value = intval($is_post->image_limit );
                     update_option( 'image_limit_pslider', $image_limit_value );
                } else {
                     $image_limit_value = intval($is_post->image_limit );
                     add_option( 'image_limit_pslider', $image_limit_value , '', 'yes' );
                }
                        
            }
            
        }
        
        public static function save_group(){
            global $wpdb;
            
            $is_post = PL_BaseInput::post_is_object(); 
  
            $tb_name = $wpdb->prefix . PL_Actions::$tb_group;
            
            $tb_nm = $wpdb->prefix . PL_Actions::$tb;
            
            if( isset( $is_post->save_group ) ){
                
                if(!empty($is_post->group_name)){
                    
                    $group_name = stripslashes_deep($is_post->group_name );
                    $group_paginate = intval($is_post->paginate_group);
                    $group_desc  = stripslashes_deep($is_post->desc_group);
                    
                    if( intval($is_post->time_group) AND intval($is_post->speed_group) ){
                        $group_values = serialize( array( 'group_time' => intval($is_post->time_group), 'group_speed' => intval($is_post->speed_group), 'group_descr' => intval($is_post->descr_group), 
                                                          'group_width' => $is_post->group_width.$is_post->width_option_input, 'group_height' => $is_post->group_height.$is_post->height_option_input,
                                                          'group_effect' => $is_post->effect_option_select ) );
                    } else {
                        $group_values = array( 'group_time' => 5000, 'group_speed' => 3000, 'group_descr' => 2, 'group_width' => null, 'group_height' => null, 'group_effect' => null );
                    }   
    
                    $field = array( 'name' => $group_name, 'value' => $group_values, 'paginate' => $group_paginate, 'description' => $group_desc );           
                    $field_format = array( '%s', '%s', '%d', '%s' );
                               
                    PL_DB::insert($tb_name, $field, $field_format);
                    
                    wp_redirect( 'admin.php?page=p_slider', 301 ); 
                    exit;
                    
                 }  
            
            } else {
                
                if( isset( $is_post->update_group ) ){
                    
                    $is_get = PL_BaseInput::get_is_object();
                    
                    $group_name = stripslashes_deep($is_post->group_name );
                    $group_paginate = intval($is_post->paginate_group);
                    $group_desc  = stripslashes_deep($is_post->desc_group);
                    
                    if( intval($is_post->time_group) AND intval($is_post->speed_group) ){
                        $group_values = serialize( array( 'group_time' => intval($is_post->time_group), 'group_speed' => intval($is_post->speed_group), 'group_descr' => intval($is_post->descr_group),
                                                          'group_width' => $is_post->group_width.$is_post->width_option_input, 'group_height' => $is_post->group_height.$is_post->height_option_input,
                                                          'group_effect' => $is_post->effect_option_select ) );
                    } else {
                        $group_values = array( 'group_time' => 5000, 'group_speed' => 3000, 'group_descr' => 2, 'group_width' => null, 'group_height' => null, 'group_effect' => null );
                    }   
    
                    $field = array( 'name' => $group_name, 'value' => $group_values, 'paginate' => $group_paginate, 'description' => $group_desc );           
                    $field_format = array( '%s', '%s', '%d', '%s' );
                    
                    $field_id = array( 'id' => $is_get->psgid ); 
                    $field_id_format = array( '%d' );
                               
                    PL_DB::update($tb_name, $field, $field_id, $field_format, $field_id_format );
                    
                    /** group update slides multi **/

                }
                 
            }
        }
        
        public static function delete_group(){
            global $wpdb;
            
            $is_post = PL_BaseInput::post_is_object(); 
            
            $tb_name = $wpdb->prefix . PL_Actions::$tb_group;
            
            if( isset($is_post->delete_group) ){
                
                $delete_group_checked = $is_post->delete_group_checked;
                
                if(!empty($delete_group_checked)){
                    
                    foreach($delete_group_checked as $delete_group_checked_key => $delete_group_checked_key_val ){
                          
                          $int_id = intval($delete_group_checked_key_val);
                          
                          $field = array( 'id' => $int_id );
                          
                          $field_format = array( '%d' );
                           
                          PL_DB::delete( $tb_name, $field, $field_format );
                          
                          wp_redirect( 'admin.php?page=p_slider', 301 ); 
                          exit; 
                     }
                    
                }
                
            }
        }
        
        public static function group_option_update(){
            global $wpdb;
            
            $is_post = PL_BaseInput::post_is_object(); 
            
            $tb_name = $wpdb->prefix . PL_Actions::$tb_group;
            
            if( isset($is_post->action ) ){
                
                $time_var = intval($is_post->time_val);
                $speed_var = intval($is_post->speed_val);
                
                $descr = intval($is_post->descr_val);
                
                $id_var = intval($is_post->id_val);
                
                $group_values = serialize( array( 'group_time' => $time_var, 'group_speed' => $speed_var, 'group_descr' => $descr,
                                                  'group_width' => $is_post->width_val, 'group_height' => $is_post->height_val ) );
                
                $field = array( 'value' => $group_values );           
                $field_format = array( '%s' );
                    
                $field_id = array( 'id' => $id_var ); 
                $field_id_format = array( '%d' );
                               
                PL_DB::update($tb_name, $field, $field_id, $field_format, $field_id_format );
 
            }
            
        }
        
        public static function update_position_ajax_psg_sort(){
            global $wpdb;
            
            $is_post = PL_BaseInput::post_is_object(); 
            $is_get = PL_BaseInput::get_is_object();
            
            $tb_name = $wpdb->prefix . PL_Actions::$tb;
            $tb_group_name = $wpdb->prefix . PL_Actions::$tb_group;
            
            if( isset($is_post->action)){
                
                $id_value = $is_post->id_value;
                if(!empty($id_value)){
                    
                    $id_values = explode(',',$id_value);
                    $count = 1;
                    
                    if(!empty($id_values)){
                        foreach($id_values as $id_values_key => $id_values_val){
                             
                            $field = array( 'g_position' => $count++ );           
                            $field_format = array( '%d' );
                                
                            $field_id = array( 'id' => intval($id_values_val) ); 
                            $field_id_format = array( '%d' );
                                           
                            PL_DB::update($tb_name, $field, $field_id, $field_format, $field_id_format );
                             
                        }
                    }
                }
                 
            }
            
            die();
        }
        
        
        public static function save_photos(){
            global $wpdb;
            
            $is_post = PL_BaseInput::post_is_object(); 
            $is_get = PL_BaseInput::get_is_object();
            
            $tb_name = $wpdb->prefix . PL_Actions::$tb;
            
            if( isset($is_post->save_photos)){
                    
                    $photos = !empty($is_post->multi_text_values) ? $is_post->multi_text_values : null;
                    if( !empty($photos) ){
                         
                         $gid = intval($is_post->select_group);
                         
                         if( $gid != 0 ){
                         
                             foreach( $photos as $photos_row => $photos_val ){
                                  
                                  $last_url = substr( $photos_val, strrpos( $photos_val, '/' )+1 );
                                  $url_expl = explode('.',$last_url);
                                  
                                  $field = array( 'title' => $url_expl[0], 'description' => $url_expl[0], 'url' => $photos_val, 'g_id' => $gid );           
                                  $field_format = array( '%s', '%s', '%s', '%d' );
                                   
                                  PL_DB::insert($tb_name, $field, $field_format);
    
                             }
                         
                         }
                         
                         if( isset($is_get->psg_id) ){
                             wp_redirect( 'admin.php?page=add_new_group_slide&&psgid='.$is_get->psg_id, 301 ); 
                         } else {
                             wp_redirect( 'admin.php?page=manage_slides', 301 ); 
                         }   
                         
                         exit; 
                         
                    }  
                
            }
            
            if( isset($is_post->update_photos)){
                    
                    $photos = !empty($is_post->single_values) ? $is_post->single_values : null;
                    if( !empty($photos) ){
                         
                         $gid = intval($is_post->select_group);
                         
                         $title = stripslashes_deep($is_post->title);
                         $desc  = stripslashes_deep($is_post->desc);
                         
                         if( $gid != 0 ){
                            
                             $last_url = substr( $photos, strrpos( $photos, '/' )+1 );
                                  
                             $field = array( 'title' => $title,  'description' => $desc, 'url' => $photos, 'g_id' => $gid );           
                             $field_format = array( '%s', '%s', '%s', '%d', );
                               
                             $field_id = array( 'id' => $is_get->psid );
                             $field_id_format = array(  '%d' );
                               
                             PL_DB::update($tb_name, $field, $field_id, $field_format, $field_id_format);
    
                         }
                         
                    }
                    
                    wp_redirect( 'admin.php?page=add_new_photos&&psid='.$is_get->psid , 301 ); 
                    exit; 
                
            }
            
        }
        
        public static function ajax_group_slides_delete(){
            global $wpdb;
            
            $is_post = PL_BaseInput::post_is_object(); 
            $is_get  = PL_BaseInput::get_is_object();
            
            $tb_name = $wpdb->prefix . PL_Actions::$tb;
            
            if( isset($is_post->action ) ){
                
                if( !empty($is_post->id_value) ){
                    
                    $id_values = explode(',',$is_post->id_value);
                    
                    if(!empty($id_values)){
                        
                        foreach($id_values as $id_values_key => $id_values_val ){
                            
                            $field = array( 'id' => $id_values_val );
                              
                            $field_format = array( '%d' );
                               
                            PL_DB::delete( $tb_name, $field, $field_format );
                        
                        }
                        
                    }
                }
                    
            }
            
            die();
            
        }
        
        public static function ajax_group_selected_filter(){
            global $wpdb;
            
            $is_post  = PL_BaseInput::post_is_object(); 
            $is_get   = PL_BaseInput::get_is_object();
            $group_id = isset( $is_post->val_id ) ? intval( $is_post->val_id ) : null;
            $html     = null;
            
            $group_slides = PL_DB::query_id('pslider', $group_id, 'position' );
            if( !empty($group_slides) ){
                foreach( $group_slides as $group_slides_keys => $group_slides_vals ){
                     
                     $url       = trim( $group_slides_vals->url ); 
                     $parse_url = parse_url( $url );
                     $end_url   = end((explode('/', rtrim($url, '/'))));
                     
                     if( $parse_url['scheme'] == 'http' OR $parse_url['scheme'] == 'https' ){
                     
                         $html .= '<div class="upload_text_id_thumbnail" style="display:block;">';
                         $html .= '<img id="upload_text_id_img" src="'.$url.'">';
                         $html .= '<input type="hidden" name="multi_text_values[]" value="'.$url.'"/>';
                         $html .= '<span class="multi-removed" title="'.$end_url.'"></span>';
                         $html .= '<a class="multi-edit" title="'.$end_url.'" href="admin.php?page=add_new_photos&&psid='.intval( $group_slides_vals->id ) .'"></a>';
                         $html .= '</div>';
                         
                     }
                     
                     $count_id[] = intval( $group_slides_vals->id );
                }
            } else {
                $count_id = null; 
            }
             
            if( count( $count_id ) >= 1 AND !is_string($count_id) ){
                echo $html;
            } else {
                echo '<p>No Available images.</p>'; 
            }
            
            die();
        }
        
        public static function option_submit(){
            global $wpdb;
            
            $is_post  = PL_BaseInput::post_is_object(); 

            $get_domain = get_option( 'domain_option' );
            
            if( isset( $is_post->save_option ) ){
                
                $option_value = trim( $is_post->option_value );
                
                if( empty( $get_domain ) ){
                
                    add_option( 'domain_option', $option_value, '', 'yes' );
                
                } else {
                    
                    update_option( 'domain_option', $option_value );
                    
                }
                
            }
        } 
        
    }
}
?>