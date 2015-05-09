 <?php echo PL_BaseHTML::icon_logo('PSlider', ''); ?> 
 
 <!-- <div>
 <h3>Shortcodes</h3>
 <p>Below is the lists of shortcodes available for the pslider's</p>
 <ol>
    <li>
        <strong><code>[pslider]</code></strong>
        <br/>- This shortcode <span id="x5k4ph_2" class="x5k4ph">displays</span> the pslider all images 
    </li>
 </ol>
 </div> -->
 
 <script type="text/javascript"> 
       var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
       
       jQuery(function(){ 
            
             jQuery("span.option-icon").click(function(){
                     
                     var time  = jQuery(this).next().find("input.group_time").val();
                     var speed = jQuery(this).next().find("input.group_speed").val();
                     var limit = jQuery(this).next().find("input.group_limit").val();
                     
                     var width = jQuery(this).next().next().next().find("input.group_width").val();
                     var height = jQuery(this).next().next().next().find("input.group_height").val();
                     var descr = jQuery(this).next().next().next().find("input.group_descr").val();
                     
                     if( jQuery(this).hasClass('option-icon-save') ){
                         
                         jQuery(this).next().find("input.group_time").prop('disabled', false);
                         jQuery(this).next().find("input.group_speed").prop('disabled', false);

                     } else {
                         
                         var id = jQuery(this).find("input.group_id").val();
                         
                         jQuery.ajax ({
                              data: { action : 'ajax_group_option_update',
                                      id_val : id,
                                      time_val : time,
                                      speed_val : speed,
                                      width_val : width,
                                      height_val : height,
                                      descr_val : descr
                                    },
                              type   : 'POST',
                              url    : ajaxurl,
                              success: function(html, data) { }
                         });
                         
                         jQuery(this).next().find("input.group_time").prop('disabled', true);
                         jQuery(this).next().find("input.group_speed").prop('disabled', true);
                         jQuery(this).next().find("input.group_limit").prop('disabled', true);
                           
                     } 
         
            });
                
       });
 </script>
 
 <?php echo PL_BaseInput::form_open(array( 'method' => 'post')); ?>
 
 <?php
       $add = array( 'name' => 'add_group', 'value' => 'Add New Group', 'id' => 'add_id', 'class' => 'add_class' );                  
       echo PL_BaseInput::submit( $add );
       
       $del = array( 'name' => 'delete_group', 'value' => 'Delete Group', 'id' => 'del_group_id', 'class' => 'del_group_class' );                  
       echo PL_BaseInput::submit( $del );
 ?>
 
 <?php 
       $value_res = null;
       $url = null;
       
       $tab1_array = array( PL_BaseInput::checkbox( array( 'name' => 'delete_group_val[]', 'class' => 'delete_group_val', 'id' => 'delete_group_val' ) ), 'Name', 'Option', 'Shortcode', 'Description', 'Photo Count', /** 'Slides(Name)', 'Slides(Images)', **/ 'Action' );
            
       $field_array = array();
            
       $query = PL_DB::query( "pslider_group" );
       if(!empty($query)){
        
            if( is_array($query)){
                
                foreach($query as $query_row => $query_val){
                    
                    $group_id = intval($query_val->id);
                    
                    $is_value = unserialize( $query_val->value );
                    
                    $option_value = '<span class="option-icon"><input type="hidden" class="group_id" value="'.$group_id.'"/></span>
                                     <div class="option_value">
                                           <span><input type="text" class="group_time" value="'.$is_value['group_time'].'" disabled="" title="Time('.$is_value['group_time'].')"/></span>
                                           <span><input type="text" class="group_speed" value="'.$is_value['group_speed'].'" disabled="" title="Speed('.$is_value['group_speed'].')"/></span>
                                     </div>
                                     <span class="more-option-icon">More Edit</span>
                                     <div class="more_option_value">
                                           <table class="more-option-table">
                                             <tr>
                                                   <td>'.PL_BaseHTML::label(array( 'text' => 'Width', 'for' => 'description' )).'</td>
                                                   <td>'.PL_BaseHTML::label(array( 'text' => 'Height', 'for' => 'description' )).'</td>
                                             </tr>
                                             <tr>
                                                   <td>
                                                      <input type="text" class="group_width" value="'.$is_value['group_width'].'" title="Width('.$is_value['group_width'].')"/>
                                                      <input type="hidden" class="group_descr" value="'.$is_value['group_descr'].'" title="Description('.$is_value['group_descr'].')"/>
                                                   </td>
                                                   <td>
                                                       <input type="text" class="group_height" value="'.$is_value['group_height'].'" title="Height('.$is_value['group_height'].')"/>
                                                   </td>
                                             </tr>
                                           </table>
                                     </div>';
                    
                    $url_html = PL_DB::query_is_url_html( "pslider", $group_id, 'g_position' );
                    $name_html = PL_DB::query_is_name_html( "pslider", $group_id, 'g_position' );
                    
                    $photo_count = PL_DB::query_is_photo_count('pslider', $group_id);

                    $field_array[] = array( 'delete' => PL_BaseInput::checkbox( array( 'value' => $group_id, 'name' => 'delete_group_checked[]', 'class' => 'delete_group_checked', 'id' => 'delete_group_checked' ) ),
                                            'name' => '<a href="admin.php?page=add_new_group_slide&&psgid='.$group_id.'">'.$query_val->name.'</a>', 
                                            'option' => $option_value,
                                            'shortcode' => '<span>[pslider id="'.$group_id.'" type="flexslider"]</span>',
                                            'description' => $query_val->description,

                                            /** 'slides_name' => !empty($name_html) ? $name_html : '', 
                                            'slides_image' => !empty($url_html) ? $url_html : '', **/
                                            
                                            'photos_count' => '<span class="photo_count">'.$photo_count.'</span>',
                                            
                                            'edit' => '<a href="admin.php?page=add_new_group_slide&&psgid='.$group_id.'" class="edit-icon"></a>' );
                } 
            }
       }
            
       $tab2_array = $field_array;
        
       echo PL_BaseHTML::table_list( array( 'id' => 'table_list' ), $tab1_array, $tab2_array );       
           
 ?>