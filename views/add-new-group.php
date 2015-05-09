
<?php
     if( isset( PL_BaseInput::get_is_object()->psgid )){ 
         
         $icon_title = 'Edit Group <code>[pslider id="'.PL_BaseInput::get_is_object()->psgid.'" type="flexslider"]</code>';
         $icon_label = "Update a group and display them to this site.";
     } else {
         
         $icon_title = "Add New Group";
         $icon_label = "Create a brand new group and add them to this site.";
     }
?>

<?php echo PL_BaseHTML::icon_logo( $icon_title, $icon_label ); ?>

<?php echo PL_BaseInput::form_open(array( 'method' => 'post', 'id' => 'add_group' )); ?>

<?php
       if( isset( PL_BaseInput::get_is_object()->psgid )){ 
         
           $query = PL_DB::query_row_id( "pslider_group", intval( PL_BaseInput::get_is_object()->psgid ) );
           if(!empty($query)){
               $values = unserialize($query->value);
           }
           
       } else {
           
           $query = (object) array( 'name' => null, 'value' => null, 'paginate' => null, 'multi_text' => null, 'description' => null );
           if(!empty($query)){
               $values = array( 'group_time' => 5000, 'group_speed' => 300, 'group_limit' => 10 );
           }
       }
 ?>

<div id="add_group">

<table id="form">
 <tbody>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Name', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <script type="text/javascript"> 
                       var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                       
                       function convertToSlug1(Text){
                        
                            return Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
                       }
                       
                       function convertToSlug2(Text){
                        
                            return Text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                       }
                                   
                       jQuery(function(){ 
                            jQuery( "#title_id" ).keyup(function(event){
                                     var text = jQuery(this).val();

                                     text_val = convertToSlug1( text );
                                     
                                     jQuery('span.slug-group').text( text_val );
                                        
                            });
                       });
             </script>
             <?php
                   $group_name = array( 
                                           'name' => 'group_name', 
                                           'value' => isset( PL_BaseInput::post_is_object()->group_name ) ? stripslashes_deep( PL_BaseInput::post_is_object()->group_name ) : $query->name,
                                           'id' => 'title_id',
                                           'class' => 'title_class',
                                           'maxlength' => 50,
                                        );
                                
                   echo PL_BaseInput::text( $group_name );  
             ?>
             <?php if( isset( PL_BaseInput::post_is_object()->save_group ) ): ?>
                   <?php if( empty( PL_BaseInput::post_is_object()->group_name ) ){ ?>
                             <p class='error'>Required field.</p>
                   <?php } ?>
             <?php endif; ?>
             <?php 
                   $slug_val = !empty($query->name) ? strtolower( $query->name ) : null; 
                   $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug_val ); 
             ?>
             <span class="slug-group"><?php echo $slug; ?></span>
        </td>
    </tr>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Description', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php
                   $desc = array( 
                                       'name' => 'desc_group', 
                                       'text' => isset( PL_BaseInput::post_is_object()->desc_group ) ? stripslashes_deep( PL_BaseInput::post_is_object()->desc_group ) : $query->description,
                                       'id' => 'desc_group_id',
                                       'class' => 'desc_group_class',
                                    );
                                
                   echo PL_BaseHTML::textarea( $desc );  
             ?>
        </td>
    </tr>
    <?php if( isset( PL_BaseInput::get_is_object()->psgid ) ){ ?>
        <tr class="form-field form-required">
            <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Slides(Sort)', 'for' => 'description' )); ?></th>
            <td class="spaces">
                <script type="text/javascript"> 
                       var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                                   
                       jQuery(function(){ 
                                        
                           var fixHelper = function(e,ui){
                               ui.children().each(function() {
                                  jQuery(this).width(jQuery(this).width());
                               });
                               return ui;
                           };
                                           
                           jQuery('table#table_list').sortable({
                               items: 'tr.sort',
                               helper: fixHelper,
                               stop: function(event, ui){
                                 
                                 /* slides id input */
                                                          
                                 var id = [];
                                 jQuery('input.sort-input').each( function() {
                                     if( jQuery(this) ){
                                         var id_val = jQuery(this).attr('value');
                                         id.push( id_val );
                                     }
                                 });
                                 
                                 var id_join = id.join(',');
                                 
                                 jQuery.ajax ({
                                      data: { action : 'ajax_psg_sort',
                                              id_value : id_join,
                                              psgid : '<?php echo isset( PL_BaseInput::get_is_object()->psgid ) ? PL_BaseInput::get_is_object()->psgid : null; ?>',
                                            },
                                      type   : 'POST',
                                      url    : ajaxurl,
                                      success: function(html, data) { 
                                           alert( 'Photos order saved. ' + html );
                                      }
                                 });
                                                       
                               }
                           }); 
                           
                           jQuery("a#delete_group_slides").click(function(e){
                               e.preventDefault();
                               
                               var id = [];
                               jQuery('input.delete_group_slides_checked:checked').each( function() {
                                     if( jQuery(this) ){
                                         var id_val = jQuery(this).attr('value');
                                         id.push( id_val );
                                         
                                         jQuery('table#table_list tr.'+id_val ).hide();
                                     }
                               });
                               
                               var id_join = id.join(',');
                               
                               jQuery.ajax ({
                                      data: { action : 'ajax_psg_slides_delete',
                                              id_value : id_join,
                                            },
                                      type   : 'POST',
                                      url    : ajaxurl,
                                      success: function(html, data) {
                                        
                                           jQuery('input.delete_group_slides_checked').attr('checked', false);
                                           
                                           jQuery('a#delete_group_slides').text('Delete');
                                            
                                           alert( 'Deleted' );
                                      }
                               });
                               
                           });         
                       }); 
                </script>
                
                <div id="group-slids-manager">
                   <a href="admin.php?page=add_new_photos&psg_id=<?php echo PL_BaseInput::get_is_object()->psgid; ?>" id="add_new_slides" class="add_new_slides">Add New Photos</a>
                   <a href="#" id="delete_group_slides" class="delete_group_slides">Delete</a>
                </div>
                
                <div class="group-slide-sort">
                     <?php
                         
                         $psg_id = PL_BaseInput::get_is_object()->psgid;
                         
                         $group_name = isset( PL_BaseInput::post_is_object()->group_name ) ? stripslashes_deep( PL_BaseInput::post_is_object()->group_name ) : $query->name;
                         
                         $tab1_array = array( PL_BaseInput::checkbox( array( 'name' => 'delete_group_slides_val[]', 'class' => 'delete_group_slides_val', 'id' => 'delete_group_slides_val' ) ), 'Name', 'Image', 'Action', 'Sort' );
                         
                         $psg_sort = PL_DB::query_id('pslider', $psg_id, 'g_position' );
                         $tab2_array = array();
                         
                         if( !empty( $psg_sort )){
                              foreach($psg_sort as $psg_sort_key => $psg_sort_val ){
                                       
                                       $psg_slides_id = intval($psg_sort_val->id);
                                       $name_title = substr( $psg_sort_val->title, 0, 20);
                                        
                                       $tab2_array[] = array( 'delete' => PL_BaseInput::checkbox( array( 'value' => $psg_slides_id, 'name' => 'delete_group_slides_checked[]', 'class' => 'delete_group_slides_checked', 'id' => 'delete_group_slides_checked' ) ),
                                                              'name' => "<a href='admin.php?page=add_new_photos&&psid=".$psg_slides_id."' class='image-slides'>".$name_title."</a>", 
                                                              'url' => "<div class='image-slides'><img src='".$psg_sort_val->url."'/></div>", 
                                                              'manage_slides' => '<a class="edit-icon" href="admin.php?page=add_new_photos&&psid='.$psg_slides_id.'"></a>',
                                                              'sort '.$psg_slides_id => '<span class="sort-icon"><input class="sort-input" type="hidden" value="'.$psg_slides_id.'"></span>' );
                                       
                              }
                         }
                         
                         echo PL_BaseHTML::table_list( array( 'id' => 'table_list' ), $tab1_array, $tab2_array );       
                         
                     ?>
                </div>
                
            </td>
    </tr>
    <?php } ?>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Slider Dimension', 'for' => 'description' )); ?></th>
        <td class="spaces">
        
             <div class="form-option" id="form-option-width">
                <?php echo PL_BaseHTML::label(array( 'text' => 'Width', 'for' => 'description' )); ?><br/> 
                <?php
                   $group_width = array( 
                                           'name' => 'group_width', 
                                           'value' => isset( PL_BaseInput::post_is_object()->group_width ) ? preg_replace('/[^0-9]/', '', PL_BaseInput::post_is_object()->group_width ) : !empty($values) ? !empty($values['group_width']) ? preg_replace('/[^0-9]/', '',$values['group_width']) : 100 : 469,
                                           'id' => 'width_id',
                                           'class' => 'width_class',
                                           'maxlength' => 50,
                                        );
                                
                   echo PL_BaseInput::text( $group_width );  
                ?>
                <?php
                       
                       $width_value = !empty($values['group_width']) ? preg_replace("/[0-9]/", "", $values['group_width']) : '%';
                       
                       $width_option_select = array( '%' => '%', 'px' => 'px', 'am' => 'am' );
    
                       $width_option_value = isset( PL_BaseInput::post_is_object()->width_option_input ) ? trim( PL_BaseInput::post_is_object()->width_option_input ) : $width_value;
                       
                       echo PL_BaseHTML::select( array( 'name' => 'width_option_input', 'class' => 'width_option_input_class', 'id' => 'width_option_input_id' ), $width_option_select, $width_option_value, '' );
    
                 ?>
             </div>
    
             <div class="form-option" id="form-option-height">
                <?php echo PL_BaseHTML::label(array( 'text' => 'Height', 'for' => 'description' )); ?><br/>
                <?php
                   $group_height = array( 
                                           'name'      => 'group_height', 
                                           'value'     => isset( PL_BaseInput::post_is_object()->group_height ) ? preg_replace('/[^0-9]/', '', PL_BaseInput::post_is_object()->group_height ) : !empty($values) ? !empty($values['group_height']) ? preg_replace('/[^0-9]/', '',$values['group_height']) : 469 : 469,
                                           'id'        => 'height_id',
                                           'class'     => 'height_class',
                                           'maxlength' => 50,
                                        );
                                
                   echo PL_BaseInput::text( $group_height );  
                ?>
                <?php
                       $height_value = !empty($values['group_height']) ? preg_replace("/[0-9]/", "", $values['group_height']) : 'px';
                       
                       $height_option_select = array( '%' => '%', 'px' => 'px', 'am' => 'am' );
    
                       $height_option_value = isset( PL_BaseInput::post_is_object()->height_option_input ) ? trim( PL_BaseInput::post_is_object()->height_option_input ) : $height_value;
                       
                       echo PL_BaseHTML::select( array( 'name' => 'height_option_input', 'class' => 'height_option_input_class', 'id' => 'height_option_input_id' ), $height_option_select, $height_option_value, '' );
                 ?>
             </div>
        </td>
    </tr>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Options', 'for' => 'description' )); ?></th>
        <td class="spaces">

             <div class="form-option">   
                 <?php echo PL_BaseHTML::label(array( 'text' => 'Time', 'for' => 'description' )); ?>
                 <?php
                       $time_select = array( 1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000 );
    
                       $time_value = isset( PL_BaseInput::post_is_object()->time_group ) ? intval( PL_BaseInput::post_is_object()->time_group ) : $values['group_time'];
                       if(!empty($time_value)){
                           $time_is_value = $time_value;
                       } else {
                           $time_is_value = "";
                       } 
                       
                       echo PL_BaseHTML::select( array( 'name' => 'time_group', 'class' => 'time_class', 'id' => 'time_id' ), $time_select, $time_is_value, 'Time' );
                 ?>
             </div>   
             <div class="form-option">
                 <?php echo PL_BaseHTML::label(array( 'text' => 'Speed', 'for' => 'description' )); ?>   
                 <?php
                       $speed_select = array( 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1200, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000, 6000 );
                   
                       $speed_value = isset( PL_BaseInput::post_is_object()->speed_group ) ? intval( PL_BaseInput::post_is_object()->speed_group ) : $values['group_speed'];
                       if( !empty($speed_value)){
                            $speed_is_value = $speed_value;
                       } else {
                            $speed_is_value = ""; 
                       }
                       
                       echo PL_BaseHTML::select( array( 'name' => 'speed_group', 'class' => 'speed_class', 'id' => 'speed_id' ), $speed_select, $speed_is_value, 'Speed' );
                 ?>
             </div>
             <div class="form-option">
                 <?php echo PL_BaseHTML::label(array( 'text' => 'Paginate', 'for' => 'description' )); ?>
                 <?php 
                   $paginate_value = isset( PL_BaseInput::post_is_object()->paginate_group ) ? trim( PL_BaseInput::post_is_object()->paginate_group ) : !empty($query->paginate) ? trim($query->paginate) : 2;
                   
                   $paginate_select = array( 1 => 'False', 2 => 'True' );
                   
                   echo PL_BaseHTML::select( array( 'name' => 'paginate_group', 'class' => 'paginate_class', 'id' => 'paginate_id' ), $paginate_select, $paginate_value, '' ); 
                ?>
             </div>
             <div class="form-option">
                <?php echo PL_BaseHTML::label(array( 'text' => 'Description', 'for' => 'description' )); ?>
                <?php 
                   $descr_value = isset( PL_BaseInput::post_is_object()->descr_group ) ? trim( PL_BaseInput::post_is_object()->descr_group ) : !empty($values) ? !empty($values['group_descr'] ) ? $values['group_descr'] : 2 : 2;
                   
                   $descr_select = array( 1 => 'False', 2 => 'True' );
                   
                   echo PL_BaseHTML::select( array( 'name' => 'descr_group', 'class' => 'descr_class', 'id' => 'descr_id' ), $descr_select, $descr_value, '' ); 
                ?> 
             </div>    
        </td>
    </tr>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Slide Effect', 'for' => 'description' )); ?></th>
        <td>
            <div class="form-option" id="form-option-effect">
                <?php
                    $effect_option_select = array( 1 => 'slide', 2 => 'fade' );
            
                    $effect_option_value = isset( PL_BaseInput::post_is_object()->effect_option_select ) ? trim( PL_BaseInput::post_is_object()->effect_option_select ) : !empty($values) ? !empty($values['group_effect']) ? $values['group_effect'] : 1 : 1;
                               
                    echo PL_BaseHTML::select( array( 'name' => 'effect_option_select', 'class' => 'effect_option_select_class', 'id' => 'effect_option_select_id' ), $effect_option_select, $effect_option_value, '' );
            
                ?>
            </div>
        </td>
    </tr>
    <tr class="form-field form-required">
      <th scope='row'></th>
      <td>
         <?php
             if( isset( PL_BaseInput::get_is_object()->psgid )){
               
                 $update_group = array( 
                                           'name'  => 'update_group', 
                                           'value' => 'Save Changes',
                                           'id'    => 'update_group_id',
                                           'class' => 'update_group_class',
                                        );
    
                 echo PL_BaseInput::submit( $update_group );
                 
             } else {
                 
                 $submit_group = array( 
                                           'name'  => 'save_group', 
                                           'value' => 'Save',
                                           'id'    => 'save_group_id',
                                           'class' => 'save_group_class',
                                        );
    
                 echo PL_BaseInput::submit( $submit_group );
                 
             }
          ?>
      </td> 
    </tr>
 </tbody>
 </table>

</div>

<?php echo PL_BaseInput::form_close(); ?> 