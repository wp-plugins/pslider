<?php if( !class_exists('PL_DB')){
     
     class PL_DB{
          
          // db::query(tbl);
          public static function query($tbl=null){ 
              global $wpdb;
              
              $tbl_name = $wpdb->prefix . $tbl;
              
              $sort = "ORDER BY `position` ASC";
              
              if( !is_null($tbl)){
                  
                  $sql = $wpdb->get_results("SELECT * FROM $tbl_name $sort");
     
                  if( is_array($sql) AND !empty($sql) ){
                      
                      if( count($sql) >=1 ){

                          return $sql;
                      }
                  } 
              }
              
          }   
          
          // db::query_prepare(tbl);
          public static function query_prepare($tbl=null){ 
              global $wpdb;
              
              $sort = "ORDER BY `position` ASC";
              
              if( !is_null($tbl)){
                  
                  $sql = $wpdb->query("SELECT * FROM $tbl $sort");
                  
                  if( is_array($sql) AND !empty($sql) ){
                      
                      if( count($sql) >=1 ){

                          return $sql;
                      }
                  } 
              }
          } 
          
          public static function query_id($tbl=null, $id=null, $pos=''){ 
              global $wpdb;
              
              $tbl_name = $wpdb->prefix . $tbl;
              
              $sort = "ORDER BY `$pos` ASC";
              
              if( !is_null($tbl)){
                  
                  $id_int = intval($id);
                  
                  $sql = $wpdb->get_results("SELECT * FROM $tbl_name WHERE g_id='".$id_int."' $sort");
     
                  if( is_array($sql) AND !empty($sql) ){
                      
                      if( count($sql) >=1 ){

                          return $sql;
                      }
                  } 
              }
              
          }    
          
          public static function query_is_url_html($tbl=null, $id=null, $pos=''){
              global $wpdb;
              
              $url = null;
              
              $tbl_name = $wpdb->prefix . $tbl;
              
              $sort = "ORDER BY `$pos` ASC";
              
              if( !is_null($tbl)){
                  
                  $id_int = intval($id);
                  
                  $sql = $wpdb->get_results("SELECT * FROM $tbl_name WHERE g_id='".$id_int."' $sort");
     
                  if( is_array($sql) AND !empty($sql) ){
                      
                      if( count($sql) >=1 ){

                          foreach($sql as $sql_key => $sql_val ){
                            
                                $last_url = substr( $sql[$sql_key]->url, strrpos( $sql[$sql_key]->url, '/' )+1 );
                                
                                $url .= '<div class="thumb-group-wrap">
                                             <div class="thumbimage group_thumb"><img src="'.$sql[$sql_key]->url.'"></div>
                                             <a href="#" class="thumb-icon"></a><span class="thumb-url">' . $last_url .'</span>
                                        </div>';
                      
                          }
                      }
                  } 
              }
              
              return $url;
          } 
          
          public static function query_is_name_html($tbl=null, $id=null, $pos=''){
              global $wpdb;
              
              $url = null;
              
              $tbl_name = $wpdb->prefix . $tbl;
              
              $sort = "ORDER BY `$pos` ASC";
              
              if( !is_null($tbl)){
                  
                  $id_int = intval($id);
                  
                  $sql = $wpdb->get_results("SELECT * FROM $tbl_name WHERE g_id='".$id_int."' $sort");
     
                  if( is_array($sql) AND !empty($sql) ){
                      
                      if( count($sql) >=1 ){

                          foreach($sql as $sql_key => $sql_val ){
                                
                                $id_val = intval($sql_val->id);
                                
                                $url .= '<div class="thumb-group-wrap">
                                             <a href="#" class="name-edit-icon"></a>
                                             <span class="thumb-url"><a href="admin.php?page=add_new_slide&&psid='.$id_val.'">' . $sql_val->title .'</a></span>
                                         </div>';
                      
                          }
                      }
                  } 
              }
              
              return $url;
          } 
          
           public static function query_is_photo_count($tbl=null, $id=null){
              global $wpdb;
              
              $url = null;
              
              $id_val = array();
              
              $tbl_name = $wpdb->prefix . $tbl;
              
              if( !is_null($tbl)){
                  
                  $id_int = intval($id);
                  
                  $sql = $wpdb->get_results("SELECT * FROM $tbl_name WHERE g_id='".$id_int."' ");
     
                  if( is_array($sql) AND !empty($sql) ){
                      
                      if( count($sql) >=1 ){

                          foreach($sql as $sql_key => $sql_val ){
                                
                                $id_val[] = intval($sql_val->id);
                                
                          }
                      }
                  } 
              }
              
              return count($id_val);
          } 
          
          public static function query_row_id($tbl=null, $id=null){
              global $wpdb;
              
              $tbl_name = $wpdb->prefix . $tbl;
              
              if( !is_null($tbl) AND !is_null($id)){
                  
                  if( intval($id)){
                       $sql = $wpdb->get_row("SELECT * FROM $tbl_name WHERE id=".intval($id)."");
                  }

                  if( is_object($sql) AND !empty($sql)){
                      
                      if( count($sql) >=1 ){

                          return $sql;
                      }
                  } 
              }
          }
          
          
          // db::query_row(tbl, string);
          public static function query_row($tbl=null, $field=null){
              global $wpdb;
              
              if( !is_null($tbl) AND !is_null($field)){
                  
                  if( is_string($field)) $sql = $wpdb->get_row("SELECT * FROM $tbl WHERE $field");
                  
                  if( is_array($sql) AND !empty($sql)){
                      
                      if( count($sql) >=1 ){

                          return $sql;
                      }
                  } 
              }
          }
          
          // db::query_row_max_id(tbl);
          public static function query_row_max_id($tbl){
              global $wpdb;
              
              if( !is_null($tbl) AND !is_null($field)){
                  
                  $sql = $wpdb->get_row("SELECT max(id) as max_id FROM $tbl");
                  
                  if( is_array($sql) AND !empty($sql)){
                      
                      if( count($sql) >=1 ){
                          
                          if( $sql->max_id == 0 ){
                              $return = 1;
                          } else {    
                              $return = $sql->max_id + 1;
                          }
                      }
                  } 
              }
              
              return $return;
          }
          
          public static function query_row_max_position($tbl){
              global $wpdb;
              
              $tbl_name = $wpdb->prefix . $tbl;
              
              if( !is_null($tbl)){
                  
                  $sql = $wpdb->get_row("SELECT max(position) as max_position FROM $tbl_name");
                  
                  if( is_array($sql) AND !empty($sql)){
                      
                      if( count($sql) >=1 ){

                              $return = $sql->max_position + 1;
                      }
                  } 
              }
              
              return $return;
          }
          
          // db::insert(tbl, array(), array());
          public static function insert($tbl=null, $field=array(), $field_format=array()){
              global $wpdb;
              
              if( !is_null($tbl)){
                  
                  if( is_array($field)){
                      
                      if( count($field)>=1){
                          $field_var = $field;
                      }
                  }
                  
                  if( is_array($field_format)){
                      
                      if( count($field_format)>=1){
                          $field_format_var = $field_format;
                      }
                  }
                  
                  $wpdb->insert($tbl, $field_var, $field_format_var);
                  
              }
          }
          
          // db::update(tbl, array(), array(), array(), array());
          public static function update($tbl=null, $field=array(), $field_id=array(), $field_format=array(), $field_id_format=array()){
              global $wpdb;
              
              if( !is_null($tbl)){
                  
                  if( is_array($field)){
                      
                      if( count($field) >= 1 AND !is_null($field) ){
                          $field_var = $field;
                      }

                  }
                  
                  if( is_array($field_id)){
                      
                      if( count($field_id) >= 1 AND !is_null($field_id) ){
                          $field_id_var = $field_id;
                      }

                  }
                  
                  if( is_array($field_format)){
                      
                      if( count($field_format) >= 1 AND !is_null($field_format) ){
                          $field_format_var = $field_format;
                      }

                  }
                  
                  if( is_array($field_id_format)){
                      
                      if( count($field_id_format) >= 1 AND !is_null($field_id_format) ){
                          $field_id_format_var = $field_id_format;
                      }

                  }
                  
                  $wpdb->update($tbl, $field_var, $field_id_var, $field_format_var, $field_id_format_var); 
                  
              }
          }
          
          // db::replace(tbl, array(), array());
          public static function replace($tbl=null, $field=array(), $field_format=array() ){
              global $wpdb;
              
              if( !is_null($tbl)){
                  
                  if( is_array($field)){
                      
                      if( count($field)>=1){
                          $field_var = $field;
                      }
                  }
                  
                  if( is_array($field_format)){
                      
                      if( count($field_format)>=1){
                          $field_format_var = $field_format;
                      }
                  }
                  
                  $wpdb->replace($tbl, $field_var, $field_format_var); 
                 
              }
          }
          
          // db::delete(tbl, array(), array());
          public static function delete($tbl, $field=array(), $field_format=array()){
              global $wpdb;
              
              if( !is_null($tbl)){
                  
                  if( is_array($field)){
                      
                      if( count($field) >= 1 AND !is_null($field) ){
                        
                          $field_var = $field;
                      }
                  }
                  
                  if( is_array($field_format)){
                      
                      if( count($field_format) >= 1 AND !is_null($field_format) ){
                        
                          $field_format_var = $field_format;
                      }
                  }
                
              }
                
              $wpdb->delete($tbl, $field_var, $field_format_var);
          }
          
          public static function delete_prepare($tbl=null, $id=null){
              global $wpdb;
              
              if( !is_null($tbl)){
                  
                  $id_var = intval( $id );
                  
                  $wpdb->query( $wpdb->prepare( "DELETE FROM $tbl WHERE id = %d", $id_var ) );
                              
              }
          }

     }
     
}
?>