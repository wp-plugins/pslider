 
 <?php
     if( isset( PL_BaseInput::get_is_object()->psid )){ 
         
         $icon_title = "Edit Photos";
         $icon_label = "Update a photos and display them to this site.";
     } else {
         
         $icon_title = "Add New Photos";
         $icon_label = "Create a brand new photos and add them to this site.";
     }
 ?>

 <?php echo PL_BaseHTML::icon_logo($icon_title, $icon_label); ?> 

 <?php echo PL_BaseInput::form_open(array( 'method' => 'post')); ?>
 
 <?php
       if( isset( PL_BaseInput::get_is_object()->psid )){ 
         
           $query = PL_DB::query_row_id( "pslider", intval( PL_BaseInput::get_is_object()->psid ) );
           
       } else {
           
           $query = (object) array( 'title' => null, 'description' => null, 'url' => null, 'g_id' => null );
           
       }
 ?>
 
<div id="add_photos"> 
 
 <table id="form">
 <tbody>
    <?php if( isset( PL_BaseInput::get_is_object()->psid )){ ?>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Title', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php
                   
                   $title = array( 
                                       'name' => 'title', 
                                       'value' => isset( PL_BaseInput::post_is_object()->title ) ? stripslashes_deep( PL_BaseInput::post_is_object()->title ) : $query->title,
                                       'id' => 'title_id',
                                       'class' => 'title_class',
                                       'maxlength' => 50,
                                    );
                                
                   echo PL_BaseInput::text( $title ); 
                   
             ?>
        </td>
    </tr>
    <?php } ?>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Group', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php
                   
                   $query_group = PL_DB::query( "pslider_group" );
                   if(!empty($query_group)){
                       foreach($query_group as $query_group_key => $query_group_val){
                            $name_array[$query_group[$query_group_key]->id] = ( $query_group[$query_group_key]->name );
                       } 
                   } else {
                       $name_array = array( 0 => 'No Group Added' );
                   }
                   
                   if(!empty($query->g_id)){
                       $g_id_val = $query->g_id;
                   } else {
                       if( isset(PL_BaseInput::get_is_object()->psg_id)){
                           $g_id_val = PL_BaseInput::get_is_object()->psg_id;
                       } else {
                           $g_id_val = null;
                       }
                   }

                   $gid_value = isset( PL_BaseInput::post_is_object()->select_group ) ? intval( PL_BaseInput::post_is_object()->select_group ) : $g_id_val;
                   
                   echo PL_BaseHTML::select( array( 'name' => 'select_group', 'class' => 'select_group_class', 'id' => 'select_group_id' ), $name_array, $gid_value, 'Group' );
             ?>
             <span class="ajax-photos-load"></span>
             <?php
                   if( isset( PL_BaseInput::post_is_object()->save_photos ) ){
                         $group_id = intval( PL_BaseInput::post_is_object()->select_group ) ? intval(PL_BaseInput::post_is_object()->select_group) : null;
                         if( $group_id == 0 AND is_null($group_id)){
             ?> 
                         <p class='error'>Required field.</p>  
             <?php               
                         } 
                    }
             ?>
        </td>
    </tr>
    <?php if( isset( PL_BaseInput::get_is_object()->psid )){ ?>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Description', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php
                   
                   $desc = array( 
                                       'name' => 'desc', 
                                       'text' => isset( PL_BaseInput::post_is_object()->desc ) ? stripslashes_deep( PL_BaseInput::post_is_object()->desc ) : $query->description,
                                       'id' => 'desc_id',
                                       'class' => 'desc_class',
                                    );
                                
                   echo PL_BaseHTML::textarea( $desc ); 
                   
             ?>
        </td>
    </tr>
    <?php } ?>
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Upload', 'for' => 'description' )); ?></th>
        <td class="spaces">
         <?php if( isset( PL_BaseInput::get_is_object()->psid )){ ?>
         <div id="upload-photos">
              <?php
                           
                        $upload_text =  array( 
                                                   'name' => 'upload_text', 
                                                   'value' => isset( PL_BaseInput::post_is_object()->upload_text ) ?  esc_url( PL_BaseInput::post_is_object()->upload_text ) : null,
                                                   'id' => 'upload_text_id',
                                                   'class' => 'upload_text_class',
                                                ); 
                                
                        $upload_submit = array( 
                                                   'name' => 'upload_submit', 
                                                   'value' => 'Browse',
                                                   'id' => 'upload_submit_id',
                                                   'class' => 'upload_submit_class',
                                                );
                         
                        echo PL_BaseUpload::form( $upload_text, $upload_submit);
                           
              ?>
         </div>
         <div id="single-values">
                    <?php
                           $url_text = trim($query->url);
                           
                           if(!empty($url_text)){
            
                               $last_url = substr( $url_text, strrpos( $url_text, '/' )+1 );
                                       
                               echo '<div class="single-data">
                                        <div class="upload_text_id_thumbnail"><img src="'.$url_text.'"><input type="hidden" value="'.$url_text.'" name="single_values"></div>
                                        <div class="upload_text_id_end_wrap" style="display: block;"><span class="upload_text_id_end">'.$last_url.'</span><span class="upload_text_id_end_remove">x</span></div>
                                        <div style="clear:both;"></div>
                                     </div>';
                         }  
                       ?>   
         </div> 
         <?php } else { ?>
             <div id="upload-photos">
                    <?php echo PL_BaseUpload::multi_form(); ?>
                    <div id='browse_upload'></div> 
             </div>   
         <?php } ?>
        </td>
    </tr>
    <tr class="form-field form-required">
      <th scope='row'><label></label></th>
      <td>
          <?php
             
            if( isset( PL_BaseInput::get_is_object()->psid )){
                
                 $submit = array( 
                                   'name' => 'update_photos', 
                                   'value' => 'Update',
                                   'id' => 'update_photos_id',
                                   'class' => 'update_photos_class',
                                );
             } else {
                 
                 $submit = array( 
                                   'name' => 'save_photos', 
                                   'value' => 'Save',
                                   'id' => 'save_photos_id',
                                   'class' => 'save_photos_class',
                                );
                  
             }
                            
             echo PL_BaseInput::submit( $submit );
          ?>
      </td> 
    </tr>
 </tbody>
 </table> 

</div>

 <?php echo PL_BaseInput::form_close(); ?>