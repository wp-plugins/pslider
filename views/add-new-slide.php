 
 <?php
     if( isset( PL_BaseInput::get_is_object()->psid )){ 
         
         $icon_title = "Edit Slide";
         $icon_label = "Update a slide and display them to this site.";
     } else {
         
         $icon_title = "Add New Slide";
         $icon_label = "Create a brand new slide and add them to this site.";
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
 
 <table id="form">
 <tbody>
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
        </td>
    </tr>
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
    <tr class="form-field form-required">
        <th scope='row'><?php echo PL_BaseHTML::label(array( 'text' => 'Upload', 'for' => 'description' )); ?></th>
        <td class="spaces">
             <?php
                 $ps_upload = !empty(PL_BaseInput::get_is_object()->ps_upload) ? PL_BaseInput::get_is_object()->ps_upload : null;
                 if( isset( $ps_upload ) ){
                     if( $ps_upload == 2 ){
                         $get_ps_upload = array( 'upload1' => 'display:none;', 'upload2' => 'display:block;' );
                     } else {
                         $get_ps_upload = array( 'upload1' => 'display:block;', 'upload2' => 'display:none;' );
                     }
                 } else {
                     $get_ps_upload = array( 'upload1' => 'display:block;', 'upload2' => 'display:none;' );;
                 }
             ?> 
             <div id="optional-uplaod">
                 <a href="" class="add_new_slides" id="upload1-active">Single Upload</a>
                 <a href="" class="add_new_slides" id="upload2-active">Multiple Upload</a>
             </div>
             <div id="upload1" style="<?php echo $get_ps_upload['upload1']; ?>">  
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
                 <div id="single-values">
                    <?php
                           $url_text = unserialize($query->url);
                           
                           if(!empty($url_text)){
                                                          
                               if( is_array($url_text) ){
                           
                                   foreach( $url_text as $url_text_key => $url_text_val ){
                                       $url_values = $url_text[$url_text_key];
                                       
                                       $last_url = substr( $url_values, strrpos( $url_values, '/' )+1 );
                                       
                                       echo '<div class="single-data">
                                                <div class="upload_text_id_thumbnail"><img src="'.$url_values.'"><input type="hidden" value="'.$url_values.'" name="single_values[]"></div>
                                                <div class="upload_text_id_end_wrap" style="display: block;"><span class="upload_text_id_end">'.$last_url.'</span><span class="upload_text_id_end_remove">x</span></div>
                                                <div style="clear:both;"></div>
                                             </div>';
                                   }  
                               
                               } else {
                                   
                                   $last_url = substr( $url_text, strrpos( $url_text, '/' )+1 );
                                       
                                       echo '<div class="single-data">
                                                <div class="upload_text_id_thumbnail"><img src="'.$url_text.'"><input type="hidden" value="'.$url_text.'" name="single_values[]"></div>
                                                <div class="upload_text_id_end_wrap" style="display: block;"><span class="upload_text_id_end">'.$last_url.'</span><span class="upload_text_id_end_remove">x</span></div>
                                                <div style="clear:both;"></div>
                                             </div>';
                                   
                               }  
                           }
                       ?>   
                 </div>
             </div> 
             <div id="upload2" style="<?php echo $get_ps_upload['upload2']; ?>">
                    <?php 
                       echo PL_BaseUpload::multi_form();
                    ?>
                    <div id='browse_upload'>
                        <?php
                           if(!empty($query->multi_text)){
                            
                               $multi_text = unserialize($query->multi_text);
                               
                               if(!empty($multi_text)){
                                                              
                                   sort( $multi_text );
                               
                                   foreach( $multi_text as $multi_text_key => $multi_text_val ){
                                       $browse_values = $multi_text[$multi_text_key];
                                       
                                       $last_url = substr( $browse_values, strrpos( $browse_values, '/' )+1 );
                                       
                                       echo "<div class='upload_text_id_thumbnail' style='display:block;'><img id='upload_text_id_img' src=".$browse_values." title=".$last_url."><input type='hidden' value=".$browse_values." name='multi_text_values[]'><span class='multi-removed'></span></div>";
                                   }
                               }
                           }
                       ?> 
                    </div> 
             </div>   
        </td>
    </tr>
    <tr class="form-field form-required">
      <th scope='row'><label></label></th>
      <td>
          <?php
             
            if( isset( PL_BaseInput::get_is_object()->psid )){
                
                 $submit = array( 
                                   'name' => 'update', 
                                   'value' => 'Update',
                                   'id' => 'update_id',
                                   'class' => 'update_class',
                                );
             } else {
                 
                 $submit = array( 
                                   'name' => 'save', 
                                   'value' => 'Save',
                                   'id' => 'save_id',
                                   'class' => 'save_class',
                                );
                  
             }
                            
             echo PL_BaseInput::submit( $submit );
          ?>
      </td> 
    </tr>
 </tbody>
 </table> 
 <?php echo PL_BaseInput::form_close(); ?>