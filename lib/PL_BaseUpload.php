<?php if( !class_exists('PL_BaseUpload')){
    
     class PL_BaseUpload{

           public static function form($is_text=array(),$is_submit=array()){
                $html = null;
                
                $media = array( 
                                  'title' => 'Type Image',
                                  'button' => 'Choose Image'     
                               );
                
                if( is_array($is_text) AND is_array($is_submit)){
                    
                if( count( $is_text)>=1 AND count($is_submit)>=1)    
                
           ?>
           <script type="text/javascript">
              jQuery(function(){
                
                    var custom_uploader;
    
                    jQuery('#<?php echo $is_submit['id']; ?>').click( function(e){
                            e.preventDefault();
                            
                            if (custom_uploader) { custom_uploader.open();
                                return;
                            }
                    
                            custom_uploader = wp.media.frames.file_frame = wp.media({
                                    title: '<?php echo $media['title']; ?>',
                                    button: {
                                        text: '<?php echo $media['button']; ?>'
                                    },
                                    multiple: false
                            });
                     
                            custom_uploader.on('select', function() {
                                    attachment = custom_uploader.state().get('selection').first().toJSON();
                                    jQuery('#<?php echo $is_text['id']; ?>').attr( 'value', attachment.url );
                                    
                                    var src_name = jQuery('#<?php echo $is_text['id']; ?>').attr('value').split('/');
                                    var file     = src_name[src_name.length - 1];
                                    
                                    if( attachment.url ){
                                        
                                        //jQuery("div#single-values").append("<div class='single-data'><div class='<?php echo $is_text['id']."_thumbnail"; ?>'><img src="+attachment.url+"><input type='hidden' name='single_values[]' value="+attachment.url+"></div><div class='<?php echo $is_text['id']."_end_wrap"; ?>'><span class='<?php echo $is_text['id']; ?>_end'>"+file+"</span><span class='<?php echo $is_text['id']; ?>_end_remove'>x</span></div><div style='clear:both;'></div></div>");
                                        
                                        jQuery("div#single-values").html("<div class='single-data'><div class='<?php echo $is_text['id']."_thumbnail"; ?>'><img src="+attachment.url+"><input type='hidden' name='single_values' value="+attachment.url+"></div><div class='<?php echo $is_text['id']."_end_wrap"; ?>'><span class='<?php echo $is_text['id']; ?>_end'>"+file+"</span><span class='<?php echo $is_text['id']; ?>_end_remove'>x</span></div><div style='clear:both;'></div></div>");
                                       
                                        jQuery("div.<?php echo $is_text['id']."_thumbnail"; ?>").fadeIn(200); 
                                        jQuery("div.<?php echo $is_text['id']."_end_wrap"; ?>").fadeIn(200);
                                    }
                                    
                                   
                            });
                    
                            custom_uploader.open();
                    
                    }); 
                    
               });   
           </script>
           <?php     
      
                    $html .= PL_BaseUpload::upload_text( $is_text );
                    $html .= PL_BaseUpload::upload_submit( $is_submit );
                    
                    /**
                    if( !empty($is_text['value']) ){
                        
                         $value_url = (object)parse_url($is_text['value']);
                         $last_url = substr( $is_text['value'], strrpos( $is_text['value'], '/' )+1 );

                         if( $value_url->scheme == 'http' OR $value_url->scheme == 'https' ){
                            
                             $inline_display = 'display:block;'; 
                             $inline_image = $is_text['value'];
                             $inline_end = $last_url;
                             
                         } else {
                            
                             $inline_display = 'display:none;'; 
                             $inline_image = null;
                             $inline_end = null;
                         }
                         
                    } else {
                        
                       $inline_display = 'display:none;';
                       $inline_image = null;   
                       $inline_end = null;
                       
                    }
                    
                    $html .= '<div id="'. $is_text['id']."_thumbnail".'" style="'.$inline_display.'"><img src="'.$inline_image.'" id="'. $is_text['id']."_img".'"/></div>';
                    $html .= '<div id="'.$is_text['id'].'_end_wrap" style="'.$inline_display.'"><span id="'.$is_text['id'].'_end">'.$inline_end.'</span><span id="'.$is_text['id'].'_end_remove">x</span></div>';
                    
                    **/   
                }
                
                return $html; 
               
           }
           
           // input(text)
           public static function upload_text($input=array()){
              $html = null; 
              $input_res = null; 
              
              if( is_array($input)){
                  if( count( $input)>=1){

                      foreach($input as $input_key => $input_var ){
                          if( !empty($input[$input_key])) $input_res .= $input_key."=".($input[$input_key]) . " ";
                      }

                      $html .= "<input type='text' ".__( $input_res ). " />";
                  }
              }
              
              return $html;
              
           }
           
           // input(submit)
           public static function upload_submit($input=array()){
              $html = null;
              $input_class = null;
              $input_res = null;
              if( is_array($input)){
                  if( count( $input)>=1){
                      
                      foreach($input as $input_key => $input_var ){
                           if( !empty($input[$input_key])) 
                           
                           if( $input_key == "class" ){
                               $input_class .= $input_key."='".($input[$input_key]) . " button' ";
                           }
                           
                           if( $input_key != "class" ){
                               $input_res .= $input_key."=".($input[$input_key]) . " ";
                           }
                      }

                      $html .= "<input type='submit' ".__( $input_res ) . $input_class . " />";
                  }
              }
              
              return $html;
          }
          
          public static function multi_form(){
          ?>
          <script type="text/javascript">
          jQuery(function(){
            
              var tgm_media_frame;
              
                jQuery('#upload_multi').click(function(e) {
                  e.preventDefault();
                  
                  if ( tgm_media_frame ) {
                        tgm_media_frame.open();
                        return;
                  }
                
                  tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
                        multiple: true,
                        library: {
                          type: 'image'
                        },
                  });
                
                  tgm_media_frame.on('select', function(){
                    
                    var selection = tgm_media_frame.state().get('selection');
                    
                    selection.map( function( attachment ) {
                        
                          attachment = attachment.toJSON();

                          console.log(attachment);
                          
                          var src_name = attachment.url.split('/');
                          var file     = src_name[src_name.length - 1];
                          
                          // Do something with attachment.id and/or attachment.url here
                          
                          jQuery("div#browse_upload").append("<div class='upload_text_id_thumbnail' style='display:block;'><img id='upload_text_id_img' src="+attachment.url+"><input type='hidden' value="+attachment.url+" name='multi_text_values[]'><span class='multi-removed'></span></div>");
                    });
                        
                  });
                
                  tgm_media_frame.open();
                
                });  
          });
          </script>
          <?php    
              echo "<input type='text' value='' id='text_multi'/><input type='submit' id='upload_multi' class='button' value='Browse' />";

          }    
     
     }
}
?>