<?php
    $atts_id = !empty($atts['id']) ? intval( $atts['id'] ) : null;
    
    if(!empty($atts_id)){
        
        $query = PL_DB::query_id("pslider", $atts_id, 'g_position' );
        if( !empty($query)):
            $query_slider = $query;
        endif;
        
        $query_row = PL_DB::query_row_id("pslider_group", $atts_id );
        if( !empty($query_row) ):
            $query_row_slides = $query_row;
            $values = (object)unserialize( $query_row_slides->value );
        endif;
    
    }
?>

<?php if( !empty($atts_id)){ ?>

<?php if(!empty($values) AND is_object($values)): ?>

<?php $get_ID_pslider_value = sanitize_title($query_row_slides->name); ?>

<script type="text/javascript">
jQuery(function () {
        
    /* SET PARAMETERS */
    
    var time_val = "<?php echo $values->group_time; ?>"; 
    var speed_val = "<?php echo $values->group_speed; ?>"; 
    var pslider_val = "<?php echo sanitize_title($query_row_slides->name); ?>";
    
    var change_img_time   = time_val.length !=0 ? time_val : 5000;	
    var transition_speed  = speed_val.length !=0 ? speed_val : 300;
        
    var slideshow	= jQuery("#"+pslider_val ),
        listItems 	= slideshow.children('li'),
        listLen		= listItems.length,
        i 			= 0,
    		
    changeList = function () {
    		
        listItems.eq(i).fadeOut(transition_speed, function () {
          i += 1; 
          if (i === listLen) { 
              i = 0; 
          }
          listItems.eq(i).fadeIn(transition_speed);
    	});
    
    };
    		
    listItems.not(':first').hide();
    setInterval(changeList, change_img_time);
    
    /* li count */
    
    var li_count = jQuery("ul#<?php echo $get_ID_pslider_value; ?> li").length;
    
    
    /* SET NEXT */
    
    <?php if( !empty($query_row_slides->paginate)){ if($query_row_slides->paginate !=1 ){ ?>
    
    jQuery("ul#<?php echo $get_ID_pslider_value; ?> li").each(function(e) {
        if (e != 0)
            jQuery(this).hide();
    });
    
    jQuery("#<?php echo $get_ID_pslider_value; ?>-next span").click(function(){
            
           if ( jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:visible").next().length != 0)
                jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:visible").next().show().prev().hide();
           else {
                jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:visible").hide();
                jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:first").show();
           }
            
           return false;
    });
    
    /* SET PREV */
    
    jQuery("#<?php echo $get_ID_pslider_value; ?>-prev span").click(function(){
        
        if ( jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:visible").prev().length != 0)
             jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:visible").prev().show().next().hide();
        else {
             jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:visible").hide();
             jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:last").show();
        }
        
        return false;
    });
    
    <?php } } ?>
    
    /* SET NUM */
    
    /** jQuery("li.<?php echo $get_ID_pslider_value; ?>-num").click(function(){
             
             var classes = jQuery(this).attr("class").split(/\s/);
             var class_val = jQuery(this).attr("class").split(" ").pop();
             
             if( class_val ){
                 if( jQuery( 'ul#<?php echo $get_ID_pslider_value; ?> li.'+class_val+"-selected").length !=0 ){
                     jQuery( 'ul#<?php echo $get_ID_pslider_value; ?> li.'+class_val+"-selected").show().prev().hide();
                 } else {
                     jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:visible").hide();
                     jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:last").show();
                 } 
             }
            
    });	**/
});
</script>

<style type="text/css">
div.content-slides img {width: 100%;}
#<?php echo $get_ID_pslider_value; ?> {max-height: 250px; overflow: hidden; list-style: none; padding: 0; margin: 0;}
#<?php echo $get_ID_pslider_value; ?>-container{ background: none repeat scroll 0 0 #FFFFFF; box-shadow: 2px 2px 5px 1px #808080; margin-bottom: 20px; margin-top: 20px; padding: 5px; width: 100%; }
#<?php echo $get_ID_pslider_value; ?>-number-paginate{ list-style:none; margin-left: 0; padding-left: 0; }
#<?php echo $get_ID_pslider_value; ?>-number-paginate li{ list-style:none;  }
.<?php echo $get_ID_pslider_value; ?>-num{ cursor:pointer;  }
</style>

<?php if( !empty($query_row_slides->paginate)){ if($query_row_slides->paginate !=1 ){ ?>
   <div id="<?php echo $get_ID_pslider_value; ?>-prev"><span class="prev-slide">Prev</span></div>
<?php } } ?>

<div id="<?php echo $get_ID_pslider_value; ?>-container" class="content-slides">

    <ul id="<?php echo $get_ID_pslider_value; ?>">
        <?php
            
            $get_limit = $values->group_limit;
            $get_image_limit_value = !empty($get_limit) ? $get_limit : 10;
  
            if(!empty($query_slider)){
                
                if( is_array($query_slider)){
                    
                    $count = 1;
                    
                    foreach($query_slider as $query_row => $query_val){
                       if( is_string($query_val->url)){ 

                           if(!empty($query_val->url)){
                            
                               $url = unserialize($query_val->url);
                               
                               if(!empty($url)){
                                   foreach($url as $url_key => $url){

                                       if( $count <= $get_image_limit_value ){
                                   ?>
                                          <li class="<?php echo $count; ?>-selected"><img src="<?php echo $url; ?>" alt="<?php echo $query_val->title; ?>"/></li>
                                   <?php
                                      
                                      } 
                                      
                                      $count++;
                                }     
                             }
                           
                           }
                       }
                       
                       if( !empty($query_val->multi_text) ){
                        
                            $multi_value = unserialize($query_val->multi_text);

                            if(is_array($multi_value)){
                                
                                foreach($multi_value as $multi_value_key => $multi_value_val){
                       
                        ?>
                                  <li class="<?php echo $count; ?>-selected"><img src="<?php echo $multi_value_val; ?>" alt="<?php echo $multi_value_val; ?>"/></li>   
                        <?php            
                                  $count++;
                                }
                                
                            }
                        }
                       
                    } 
                }
            }
            
        ?>
        <?php
           /** if(!empty($query_slider)){
                
                if( is_array($query_slider)){
                
                $count_val = end( $count_slide ) + 1;
                
                foreach($query_slider as $query_row => $query_val){
                
                    if( !empty($query_val->multi_text) ){
                        
                        $multi_value = unserialize($query_val->multi_text);
                        
        
                        if(is_array($multi_value)){

                            foreach($multi_value as $multi_value_key => $multi_value_val){
                   
                    ?>
                             <li class="<?php echo $count_val; ?>-selected"><img src="<?php echo $multi_value_val; ?>" alt="<?php echo $multi_value_val; ?>"/></li>   
                    <?php            
                              $count_val++;
                            }
                            
                        }
                    }
                
                }
              }          
           } **/
        ?>
    </ul>
</div>
<!--
<ul id="<?php echo $get_ID_pslider_value; ?>-number-paginate">
     <?php
         if(!empty($query_slider)){
                if( is_array($query_slider)){
                    $count = 1;
                    foreach($query_slider as $query_row => $query_val){
                        
                      if(!empty($query_val->url)){ 
                        
                        $url = unserialize($query_val->url);
                        if(!empty($url)){
                                   foreach($url as $url_key => $url){
                         
                                        $count_slide_val[] = $count;
                                    ?>
                                        <li class="<?php echo $get_ID_pslider_value; ?>-num <?php echo $count; ?>"><span><?php echo $count; ?></span></li>
                                    <?php 
                                        $count++; 
                                       }
                        } 
                    }
                }
             }
         }
     ?>
     <?php
         if(!empty($query_slider)){
                
                if( is_array($query_slider)){
                    
                 $count_val = end( $count_slide_val ) + 1;
                    
                 foreach($query_slider as $query_row => $query_val){
            
                    if( !empty($query_val->multi_text) ){
                        $multi_value = unserialize($query_val->multi_text);
                        
                        if(is_array($multi_value)){
                            foreach($multi_value as $multi_value_key => $multi_value_val){
                    ?>
                               <li class="<?php echo $get_ID_pslider_value; ?>-num <?php echo $count_val; ?>"><span><?php echo $count_val; ?></span></li>  
                    <?php            
                               $count_val++;
                            }
                            
                        }
                    }
                 }
           
              }
          } 
        ?>
</ul> -->

<?php if( !empty($query_row_slides->paginate)){ if($query_row_slides->paginate !=1 ){ ?>
   <div id="<?php echo $get_ID_pslider_value; ?>-next"><span class="next-slide">Next</span></div>
<?php } } ?>

<?php else: ?>
      <code><p>[pslider id="<?php echo $atts_id; ?>"] - id number is not exists from the data matching.</p></code>
<?php endif; ?>

<?php } else { ?>
      
       <code><p>[pslider id="int"] - Pls. fallow shortcode format</p></code>
        
<?php } ?>