 <?php echo PL_BaseHTML::icon_logo('Settings', ''); ?> 
 
 <?php echo PL_BaseInput::form_open(array( 'method' => 'post')); ?>
 
 <table id="form" class="setting">
 <tbody>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'PSlider ID', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php
                   $get_ID_pslider_value = get_option("id_pslider");
                   
                   $pslider_ID = array( 
                                           'name' => 'pslider_id', 
                                           'value' => isset( PL_BaseInput::post_is_object()->pslider_id ) ? ( PL_BaseInput::post_is_object()->pslider_id ) : $get_ID_pslider_value,
                                           'id' => 'pslider_ID_id',
                                           'class' => 'pslider_ID_class',
                                           'maxlength' => 50,
                                        );
                                
                   echo PL_BaseInput::text( $pslider_ID );  

             ?>
        </td>
    </tr>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Change Image Time', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php
                   $get_time_value = get_option("time_pslider");
                   
                   $time_select = array( 1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000 );
                   
                   $time_value = isset( PL_BaseInput::post_is_object()->time ) ? intval( PL_BaseInput::post_is_object()->time ) : $get_time_value;
                    
                   echo PL_BaseHTML::select( array( 'name' => 'time', 'class' => 'time_class', 'id' => 'time_id' ), $time_select, $time_value );
                   
                   $custom_time_submit = array( 
                                                   'name' => 'custom_time_submit', 
                                                   'value' => '--',
                                                   'id' => 'custom_time_submit_id',
                                                   'class' => 'custom_time_submit_class',
                                            );
                              
                   echo PL_BaseInput::custom_submit( $custom_time_submit );    
                   
                   $custom_time_text = array( 
                                           'name' => 'custom_time_text', 
                                           'value' => isset( PL_BaseInput::post_is_object()->custom_time_text ) ? intval( PL_BaseInput::post_is_object()->custom_time_text ) : false,
                                           'id' => 'custom_time_text_id',
                                           'class' => 'custom_time_text_class',
                                           'maxlength' => 50,
                                        );
                                
                   echo PL_BaseInput::text( $custom_time_text );      
             ?>
        </td>
    </tr>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Transition Speed', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php 
                   $get_speed_value = get_option("speed_pslider");
                   
                   $speed_select = array( 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1200, 1500 );
                   
                   $speed_value = isset( PL_BaseInput::post_is_object()->speed ) ? intval( PL_BaseInput::post_is_object()->speed ) : $get_speed_value;
                    
                   echo PL_BaseHTML::select( array( 'name' => 'speed', 'class' => 'speed_class', 'id' => 'speed_id' ), $speed_select, $speed_value );
                   
             ?>
        </td>
    </tr>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Image Limit', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php
                   $get_image_limit_value = get_option("image_limit_pslider");
                   
                   $image_limit = array( 
                                           'name' => 'image_limit', 
                                           'value' => isset( PL_BaseInput::post_is_object()->image_limit ) ? intval( PL_BaseInput::post_is_object()->image_limit ) : $get_image_limit_value,
                                           'id' => 'image_limit_id',
                                           'class' => 'image_limit_class',
                                           'maxlength' => 50,
                                        );
                                
                   echo PL_BaseInput::text( $image_limit );      
             ?>
        </td>
    </tr>
    <tr class="form-field form-required">
      <th scope='row'>
         <?php
             
             $save_changes = array( 
                                       'name' => 'save_changes', 
                                       'value' => 'Save Changes',
                                       'id' => 'save_changes_id',
                                       'class' => 'save_changes_class',
                                );
                              
             echo PL_BaseInput::submit( $save_changes );
          ?>  
      </th>
      <td></td> 
    </tr>
 </tbody>
 </table>
 
 <?php echo PL_BaseInput::form_close(); ?>