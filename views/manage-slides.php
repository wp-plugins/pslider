 <?php echo PL_BaseHTML::icon_logo('Manage Photos', ''); ?> 
 
 <?php echo PL_BaseInput::form_open(array( 'method' => 'post')); ?>
 
 <?php
       $add = array( 'name' => 'add', 'value' => 'Add New Photos', 'id' => 'add_id', 'class' => 'add_class' );                  
       echo PL_BaseInput::submit( $add );
       
       $del = array( 'name' => 'delete', 'value' => 'Delete', 'id' => 'del_id', 'class' => 'del_class' );                  
       echo PL_BaseInput::submit( $del );
 ?>
 
 <script type="text/javascript"> 
       var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                   
       jQuery(function(){ 
                        
           var fixHelper = function(e,ui){
               ui.children().each(function() {
                  jQuery(this).width(jQuery(this).width());
               });
               return ui;
           };
                           
           jQuery('table.table_list').sortable({
               connectWith: 'table.table_list',
               items: 'tr.sort',
               helper: fixHelper,
               placeholder:'ui-state-highlight',
               stop: function(event, ui){

                 /* -- first array 1 */
                   
                 var id = []; 
                 jQuery('input.sort-input').each( function(key, value) {
                     if( jQuery(this) ){
                         var id_val = jQuery(this).attr('value');
                         id.push( id_val );
                     }
                 });
                 
                 var id_join = id.join(',');
  
                 /* -- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx second array 1 xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -- */
                 
                 /* -- second array 2 -- */
                 
                 var g_id = []; 
                 jQuery('input.sort-group-input, input.sort-input').each( function(i) {
                     if( jQuery(this) ){
                            var g_id_val = jQuery(this).attr('value');
                            g_id.push( g_id_val );
                     }
                 });
                 
                 g_id_join = g_id.join('-');
                 
                 /* -- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx second array 2 xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -- */
                 
                 jQuery.ajax ({
                      data: { action : 'ajax_sort',
                              id_value : id_join,
                              g_id_value : g_id_join,
                            },
                      type   : 'POST',
                      url    : ajaxurl,
                      success: function(html, data) { 
                           alert( 'Photos order saved. ' );
                      }
                 });
                                       
               }
           });          
       }); 
 </script>
 
 <?php
    $query_qroup = PL_DB::query( "pslider_group" ); 
 ?>
 <div id="filter-group">
 <?php
    if(!empty($query_qroup)){
        if( is_array($query_qroup)){

            foreach( $query_qroup as $query_qroup_key => $query_qroup_val ){

                  $slug_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $query_qroup_val->name)));
                  $group_id = intval($query_qroup_val->id);

                  echo '<div class="filter_slides_wrap"><span>'.$query_qroup_val->name.'</span>
                        <a href="admin.php?page=add_new_photos&psg_id='.$group_id.'" class="filter_slides_group '.$slug_name.'">Add New Photos</a>
                        <input type="hidden" value="0.'.$query_qroup_val->id.'" class="sort-group-input">
                        <div style="clear:both;"></div>
                        </div>'; 
                  
                  $group_slides = PL_DB::query_id('pslider', $group_id, 'position' );
                  if( !empty($group_slides) ){
                       
                       $field_array = array();
                       
                       $tab1_array = array( PL_BaseInput::checkbox( array( 'name' => 'delete_val[]', 'class' => 'delete_val', 'id' => 'delete_val' ) ), 'Name', 'Images', 'Sort', 'Action' );
                       
                       if(!empty($group_slides)){
                        
                            if( is_array($group_slides)){
                                foreach($group_slides as $query_row => $query_val){
                                    
                                    $int_id = intval($query_val->id);
                                    
                                    $end_url = substr( $query_val->url, strrpos( $query_val->url, '/' )+1 );
                                    $end_clear = '';
                                    
                                    $name_title = substr( $query_val->title, 0, 20);
                    
                                    $group_name = PL_DB::query_row_id('pslider_group', $query_val->g_id );
                                    $group_name_value = !empty($group_name->name) ? "<span class='group_name'>(".$group_name->name.")</span>" : null;
                                    
                                    $slug_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $group_name->name)));
                                    
                                    $field_array[] = array( 
                                                            'delete'           => PL_BaseInput::checkbox( array( 'value' => $int_id, 'name' => 'delete_checked[]', 'class' => 'delete_checked', 'id' => 'delete_checked' ) ),
                                                            'title'            => '<a href="admin.php?page=add_new_photos&&psid='.$int_id.'">'.$name_title.'</a>', 
                                                            'url'              => '<div class="thumbimage"><img src="'.$query_val->url.'"></div><a href="#" class="thumb-icon"></a><span class="thumb-url">' . $end_clear .'</span>', 
                                                            'sort '.$slug_name => '<span class="sort-icon"><input type="hidden" value="'.$int_id.'" class="sort-input"></span>',
                                                            'edit'             => '<a href="admin.php?page=add_new_photos&&psid='.$int_id.'" class="edit-icon"></a>',
                                                          );
                                } 
                            }
                       }
                       
                       $tab2_array = $field_array;
                       
                       echo PL_BaseHTML::table_list( array( 'id' => 'table_list', 'class' => 'table_list' ), $tab1_array, $tab2_array ); 
                
                } else {
                       
                ?>       

                    <p>No Photos.</p> 
                    
                <?php       
                }
            }
            
        }
    } else {
        
    ?>   
        <p>No Photos.</p> 
    <?php    
    }
 ?>
 </div>
 <?php
    /** $tab1_array = array( PL_BaseInput::checkbox( array( 'name' => 'delete_val[]', 'class' => 'delete_val', 'id' => 'delete_val' ) ), 'Name', 'Description', 'Images', 'Sort', 'Action' );
    
    $field_array = array();
    
    $query = PL_DB::query( "pslider" ); 
    
    if(!empty($query)){
        if( is_array($query)){
            foreach($query as $query_row => $query_val){
                
                $int_id = intval($query_val->id);
                
                $end_url = substr( $query_val->url, strrpos( $query_val->url, '/' )+1 );

                $group_name = PL_DB::query_row_id('pslider_group', $query_val->g_id );
                $group_name_value = !empty($group_name->name) ? "<span class='group_name'>(".$group_name->name.")</span>" : null;
                
                $slug_name = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $group_name->name)));
                
                $field_array[] = array( 'delete' => PL_BaseInput::checkbox( array( 'value' => $int_id, 'name' => 'delete_checked[]', 'class' => 'delete_checked', 'id' => 'delete_checked' ) ),
                                        'title' => '<a href="admin.php?page=add_new_photos&&psid='.$int_id.'">'.$query_val->title.'</a> '.$group_name_value, 
                                        'description' => $query_val->description, 
                                        'url' => '<div class="thumbimage"><img src="'.$query_val->url.'"></div><a href="#" class="thumb-icon"></a><span class="thumb-url">' . $end_url .'</span>', 
                                        'sort '.$slug_name => '<span class="sort-icon"><input type="hidden" value="'.$int_id.'" class="sort-input"></span>',
                                        'edit' => '<a href="admin.php?page=add_new_slide&&psid='.$int_id.'" class="edit-icon"></a>' );
            } 
        }
    }
        
    $tab2_array = $field_array;
    
    echo PL_BaseHTML::table_list( array( 'id' => 'table_list' ), $tab1_array, $tab2_array ); **/
 ?>
 
 <?php echo PL_BaseInput::form_close(); ?>