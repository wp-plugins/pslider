<?php
    $atts_id = !empty($atts['id']) ? intval( $atts['id'] ) : null;
    $html    = null;
   
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

<?php if( empty($atts['type'] )){ ?>

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
    
    //var transition_speed  = speed_val.length !=0 ? speed_val : 300;
    
    jQuery.fx.speeds.xfast = 100;
    
    var transition_speed = 100;
       
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
    
    jQuery("li.<?php echo $get_ID_pslider_value; ?>-num").click(function(){
             
             var classes = jQuery(this).attr("class").split(/\s/);
             var class_val = jQuery(this).attr("class").split(" ").pop();
             
             /** if( class_val ){
                 if( jQuery( 'ul#<?php echo $get_ID_pslider_value; ?> li.'+class_val+"-selected").length !=0 ){
                     jQuery( 'ul#<?php echo $get_ID_pslider_value; ?> li.'+class_val+"-selected").show().prev().hide();
                 } else {
                     jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:visible").hide();
                     jQuery("ul#<?php echo $get_ID_pslider_value; ?> li:last").show();
                 } 
             } **/
             
             if( class_val ){
                
                 jQuery( 'ul#<?php echo $get_ID_pslider_value; ?> li').hide();
                 jQuery( 'ul#<?php echo $get_ID_pslider_value; ?> li.'+class_val+"-selected").show();
             }
            
    });
});
</script>

<style type="text/css">
div.content-slides img {width: 100%;}
#<?php echo $get_ID_pslider_value; ?> {max-height: 250px; overflow: hidden; list-style: none; padding: 0; margin: 0;}
#<?php echo $get_ID_pslider_value; ?>-container{ background: none repeat scroll 0 0 #FFFFFF; box-shadow: 2px 2px 5px 1px #808080; margin-bottom: 20px; margin-top: 20px; padding: 5px; width: 100%; }
#<?php echo $get_ID_pslider_value; ?>-number-paginate{ list-style:none; margin-left: 0; padding-left: 0; }
#<?php echo $get_ID_pslider_value; ?>-number-paginate li{ list-style:none; }
.<?php echo $get_ID_pslider_value; ?>-num{ cursor:pointer; }
#<?php echo $get_ID_pslider_value; ?>-number-paginate li{ 
    background: none repeat scroll 0 0 #FFFFFF;
    border-radius: 24px;
    box-shadow: 1px 1px 5px 1px #808080;
    float: left;
    margin-right: 10px;
    padding-left: 9px;
    width: 25px;
}
#<?php echo $get_ID_pslider_value; ?>-prev{
    float: left;
    width: 60px;
}
#<?php echo $get_ID_pslider_value; ?>-next{
    float: left;
    margin-left: 20px;
}
</style>

<div id="<?php echo $get_ID_pslider_value; ?>-container" class="content-slides">
    <ul id="<?php echo $get_ID_pslider_value; ?>">
        <?php
            if(!empty($query_slider)){
                
                if( is_array($query_slider)){
                    
                    $count = 1;
                    
                    foreach($query_slider as $query_row => $query_val){
                       if( is_string($query_val->url)){ 

                           if(!empty($query_val->url)){
                            
                               $url = trim($query_val->url);
                               ?>
                                   <li class="<?php echo $count; ?>-selected"><img src="<?php echo $url; ?>" alt="<?php echo $query_val->title; ?>"/></li>
                               <?php
                                   $count++;
                               }
                           }
                       }
                    } 
             }
        ?>
    </ul>
</div>

<?php if( !empty($query_row_slides->paginate)){ if($query_row_slides->paginate !=1 ){ ?>
   <div id="<?php echo $get_ID_pslider_value; ?>-prev"><span class="prev-slide">Prev</span></div>
<?php } } ?>
<ul id="<?php echo $get_ID_pslider_value; ?>-number-paginate">
     <?php
         if(!empty($query_slider)){
                if( is_array($query_slider)){
                    $count = 1;
                    foreach($query_slider as $query_row => $query_val){
                        
                      if(!empty($query_val->url)){ 
                        
                        $url = trim($query_val->url);
                        if(!empty($url)){
                            
                        ?>
                                <li class="<?php echo $get_ID_pslider_value; ?>-num <?php echo $count; ?>"><span><?php echo $count; ?></span></li>
                        <?php 
                            $count++; 
                        } 
                    }
                }
             }
         }
     ?>
</ul>
<?php if( !empty($query_row_slides->paginate)){ if($query_row_slides->paginate !=1 ){ ?>
   <div id="<?php echo $get_ID_pslider_value; ?>-next"><span class="next-slide">Next</span></div>
<?php } } ?>

<?php else: ?>
      <code><p>[pslider id="<?php echo $atts_id; ?>"] - id number is not exists from the data matching.</p></code>
<?php endif; ?>

<?php } else { ?>
       <code><p>[pslider id="int"] - Pls. fallow shortcode format</p></code>  
<?php } ?>

<?php } else { ?>
      
      <?php if( $atts['type'] =='pika' ): ?>

      <style type="text/css">
      <?php if( !empty($query_row_slides->paginate)){ if($query_row_slides->paginate !=1){ ?>
      .pika-textnav, .pika-imgnav {display:block;}
      <?php } else { ?> 
      .pika-textnav, .pika-imgnav {display:none;}
      <?php } 
      } ?>
      <?php $values_width = !empty($values->group_width) ? trim($values->group_width) : "100%"; ?>
      .pikachoose {width: <?php echo $values_width; ?>; margin: 0 auto;}
      <?php $values_height = !empty($values->group_height) ? trim($values->group_height) : '469px'; ?>
      .pika-stage {position: relative; width: <?php echo $values_width; ?>; height:<?php echo $values_height; ?>;}
      </style>
      
      <script language="javascript">
	  jQuery(document).ready(function (){ jQuery("#pikame").PikaChoose({autoPlay:true,transition:[1],speed:"<?php echo $values->group_time; ?>",animationSpeed:"<?php echo $values->group_speed; ?>" }); });
      </script>
     
      <div class="pikachoose">
    	<ul id="pikame">
            <?php $values_descr = !empty($values->group_descr) ? intval($values->group_descr) : 2; ?>
            <?php
            if(!empty($query_slider)){
                
                if( is_array($query_slider)){
                    
                    $count = 1;
                    
                    foreach($query_slider as $query_row => $query_val){
                       if( is_string($query_val->url)){ 

                           if(!empty($query_val->url)){
                            
                               $url = trim($query_val->url);
                               
                               $last_url = substr( $url, strrpos( $url, '/' )+1 );
                               
                               ?>
                                   <li class="<?php echo $count; ?>-selected">
                                       <img src="<?php echo $url; ?>" alt="<?php echo $query_val->title; ?>"/>
                                       <?php if( !empty($values_descr)){ ?> 
                                            <?php if( $values_descr !=1 ): ?> <span><?php echo $query_val->description; ?></span> <?php endif; ?>
                                       <?php } ?> 
                                   </li>
                               <?php

                                   $count++;
                               }
                           
                           }
                       }
                    } 
             }
        ?>
    	</ul>
    </div>
    
    <?php endif; ?>

    <?php if( $atts['type'] =='jcobb' OR $atts['type'] =='plonta' ): ?>
    
          <?php $values_width = !empty($values->group_width) ? trim($values->group_width) : "100%"; 
                $values_width_number = preg_replace('/[^0-9]/', '', $values_width);
          ?>
          <?php $values_height = !empty($values->group_height) ? trim($values->group_height) : '469px'; 
                $values_height_number = preg_replace('/[^0-9]/', '', $values_height);
          ?>
          <?php $values_descr = !empty($values->group_descr) ? intval($values->group_descr) : 2; ?>
          <?php
                if(!empty($values->group_effect)){
                    if( intval($values->group_effect) == 1 ){
                        $effect = 'slide';
                    } else {
                        $effect = 'fade';
                    }
                } else {
                    $effect = 'slide';
                }
          ?>
          <?php
                if( $query_row_slides->paginate == 1 ){
                    $paginate_option = 'false'; 
                } else {
                    $paginate_option = 'true';
                }
          ?>
          <script class="secret-source">
            jQuery(document).ready(function($) {
                  jQuery('#banner-slide').bjqs({ animtype : '<?php echo $effect; ?>', animduration : <?php echo $values->group_speed; ?>, animspeed : <?php echo $values->group_time; ?>, height : <?php echo intval($values_height_number); ?>, width : 620, responsive : true, randomstart : true, showmarkers : <?php echo $paginate_option; ?> });
            });
          </script>
          <style type="text/css">
            div#banner-slide ul li{ list-style: none outside none; margin: 0; }
            p.bjqs-caption{ margin: 0; }
            div#banner-slide{ max-width: <?php echo $values_width; ?> !important; }
            div#banner-slide div.bjqs-wrapper{ width: <?php echo $values_width; ?> !important; }
          </style>
          
          <div id="banner-slide">
                <ul class="bjqs">
                    <?php
                        if(!empty($query_slider)){
                            
                            if( is_array($query_slider)){
                                
                                $count = 1;
                                
                                foreach($query_slider as $query_row => $query_val){
                                    
                                   if( is_string($query_val->url)){ 
            
                                       if(!empty($query_val->url)){
                                        
                                           $url = trim($query_val->url);
                                           
                                           $last_url = substr( $url, strrpos( $url, '/' )+1 );
                                           
                                           ?>
                                               <li class="<?php echo $count; ?>-selected">
                                                   <img src="<?php echo $url; ?>" alt="<?php echo $query_val->title; ?>" <?php if( $values_descr !=1 ): ?> title="<?php echo $query_val->description; ?>" <?php endif; ?> />
                                               </li>
                                           <?php
            
                                               $count++;
                                           }
                                       
                                       }
                                   }
                                } 
                         }
                    ?>
                </ul>
          </div>
          
    <?php endif; ?>
    
    <?php if( $atts['type'] =='easy' ): ?>
    
     <?php
        if(!empty($values->group_effect)){
            if( intval($values->group_effect) == 1 ){
                $effect = 'slide';
            } else {
                $effect = 'fade';
            }
        } else {
            $effect = 'fade';
        }
     ?>
    
    <?php
         if( $query_row_slides->paginate == 1 ){
             $paginate_option = 'false';
             $paginate_option_btn = 'none'; 
         } else {
             $paginate_option = 'true';
             $paginate_option_btn = 'block';
         }
    ?>
    <script type="text/javascript">
		jQuery(document).ready(function(){	
			jQuery("#slider-easy").easySlider({ 
                                                loop: true,                           // Looping
                                        		orientation: '<?php echo $effect; ?>',                  // Fading
                                        		autoplayDuration: 2000,               // Autoplay with 1 second intervals
                                        		autogeneratePagination: true,         // Automatically generate pagination links
                                        		restartDuration: 2500,                // In case of user interaction, restart the autoplay after 2.5 seconds
                                        		nextId: 'next',
                                        		prevId: 'prev',
                                        		pauseable: true                       // Pause by hovering over the image!  Then restart after 2.5 seconds (see above)
                                             });
		});	
	</script>
    <style type="text/css">
        div#slider-easy ul li{ list-style: none outside none; margin: 0; }
        span#prev{ display:<?php echo $paginate_option_btn; ?> !important; }
        span#next{ display:<?php echo $paginate_option_btn; ?> !important; }
    </style>
    <?php
        function easySliderContent($atts_id=null){
            
            $query = PL_DB::query_id("pslider", $atts_id, 'g_position' );
            if( !empty($query)):
                $query_slider = $query;
            endif;
             
            $html .= '<div id="slider-easy">';
            
        	    $html .= '<ul>';				
                    if(!empty($query_slider)){
                        
                        if( is_array($query_slider)){
                            
                            $count = 1;
                            
                            foreach($query_slider as $query_row => $query_val){
                               if( is_string($query_val->url)){ 
        
                                   if(!empty($query_val->url)){
                                    
                                       $url      = trim($query_val->url);
                                       $last_url = substr( $url, strrpos( $url, '/' )+1 );
                                       
                                           $html .= '<li class="'.$count.'-selected"><img src="'.$url.'" alt="'.$query_val->title.'"/></li>';
                                           $count++;
                                       }
                                   
                                   }
                               }
                            } 
                     }	
                $html .= '</ul>';
                
            $html .= '</div>';
            
            return $html;
        }
    ?>      
    <?php endif; ?>
    
    <?php if( $atts['type'] =='showinstances' ): ?><?php endif; ?>
    
    <?php if( $atts['type'] =='mini' ): ?>
          
          <?php
               function miniSliderContent($atts_id=null){
                    
                    $query_row = PL_DB::query_row_id("pslider_group", $atts_id );
                    if( !empty($query_row) ):
                        $query_row_slides = $query_row;
                        $values = (object)unserialize( $query_row_slides->value );
                    endif;
                    
                    $paginate = $query_row_slides->paginate == 1 ? 'false' : 'true';
    
                    $group_speed = isset( $values->group_speed ) ? $values->group_speed : 900;
                    $descrip_filter = isset( $values->group_descr ) ? $values->group_descr : null;
                    
               ?>     
                    <style type="text/css">
                    <?php if( $descrip_filter == 1 ): ?> div.caption-container{ display:none; } <?php endif; ?>
                    </style>
                    <script type="text/javascript">
            			jQuery(document).ready(function() {
            				// We only want these styles applied when javascript is enabled
            				jQuery('div.navigation-cntr').css({'width' : '', 'float' : 'left'});
            				jQuery('div.content-gallery').css('display', 'block');
            
            				// Initially set opacity on thumbs and add
            				// additional styling for hover effect on thumbs
                            
                            var paginate_var = '<?php echo $paginate; ?>';
                            var paginate_var_filter = paginate_var == 'false' ? false : true;
                            
            				var onMouseOutOpacity = '';
            				jQuery('#thumbs ul.thumbs li').opacityrollover({
            					mouseOutOpacity:   onMouseOutOpacity,
            					mouseOverOpacity:  '',
            					fadeSpeed:         'fast',
            					exemptionSelector: '.selected'
            				});
            				
            				// Initialize Advanced Galleriffic Gallery
            				var gallery = jQuery('#thumbs').galleriffic({
            					delay:                     2500,
            					numThumbs:                 40,
            					preloadAhead:              10,
            					enableTopPager:            true,
            					enableBottomPager:         true,
            					maxPagesToShow:            7,
            					imageContainerSel:         '#slideshow',
            					controlsContainerSel:      '#controls',
            					captionContainerSel:       '#caption',
            					loadingContainerSel:       '#loading',
            					renderSSControls:          false,
            					renderNavControls:         paginate_var_filter,
            					playLinkText:              'Play Slideshow',
            					pauseLinkText:             'Pause Slideshow',
            					prevLinkText:              '&lt;',
            					nextLinkText:              '&gt;',
            					nextPageLinkText:          'Next &rsaquo;',
            					prevPageLinkText:          '&lsaquo; Prev',
            					enableHistory:             false,
            					autoStart:                 false,
            					syncTransitions:           true,
            					defaultTransitionDuration: '<?php echo $group_speed; ?>',
            					onSlideChange: function(prevIndex, nextIndex) {
            						// 'this' refers to the gallery, which is an extension of $('#thumbs')
            						this.find('ul.thumbs').children().eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end().eq(nextIndex).fadeTo('fast', 1.0);
            					},
            					onPageTransitionOut: function(callback) {
            						this.fadeTo('fast', 0.0, callback);
            					},
            					onPageTransitionIn: function() {
            						this.fadeTo('fast', 1.0);
            					}
            				});
            			});
            		</script>
                <?php    
                    $query = PL_DB::query_id("pslider", $atts_id, 'g_position' );
                    if( !empty($query)):
                        $query_slider = $query;
                    endif;
                    
                    if(!empty($query_slider)){
                        
                        $html .= '<div id="gallery" class="content-gallery">
                    		  			<div class="slideshow-container">
                    	  					<div id="loading" class="loader"></div>
                    	  					<div id="slideshow" class="slideshow"></div>
                    		  			</div>
                    			  		<div id="caption" class="caption-container"></div>
                    			  </div>';
                        
                        if( is_array($query_slider)){
                            
                            $count = 1;
                            
                            $html .= '<div id="thumbs" class="navigation-cntr"><ul class="thumbs noscript">';
                            
                            foreach($query_slider as $query_row => $query_val){
                                 
                                 $url      = trim($query_val->url);
                                 $last_url = substr( $url, strrpos( $url, '/' ) + 1 );
                                 $desc     = trim($query_val->description);
                        
      						     $html .= '<li>';
                                 
     							 $html .= '<a class="thumb" name="leaf" href="'.$url.'" title="Title #'.$count.'"><img src="'.$url.'" alt="Title #'.$count.'" /></a>';
                                 
     							 $html .= '<div class="caption">';
                                 
   								 $html .= '<div class="download"><a href="'.$url.'">Download Original</a></div>';
                                 
            					 $html .= '<div class="image-title">Title #'.$count.'</div>';
            					 $html .= '<div class="image-desc">'.$desc.'</div>';
                                     
            					 $html .= '</div>';
                                 
            				     $html .= '</li>';
                                 
                                 //$html .= '<div class="'.$count.'-selected mini-clip"><img src="'.$url.'" alt="'.$query_val->title.'" /></div>';
                                 
                                 $count++;
                                 
                            }
                            
                            $html .= '</ul></div>';
                            
                            $html .= '<div class="clear"></div>';
                            
                            $html .= '<div id="controls" class="controls"></div>';
                        
                        }
                    }
                    
                    return $html;
                    
             }
          ?> 
        
    <?php endif; ?>
    
    <?php if( $atts['type'] =='flexslider' ): ?>
          
          <?php 
              
              function flexSliderContent($atts_id=null){
                   global $post;
                   
                   $html .= '';
                   
                   $query_row = PL_DB::query_row_id("pslider_group", $atts_id );
                   if( !empty($query_row) ):
                        $query_row_slides = $query_row;
                        $values = (object)unserialize( $query_row_slides->value );
                   endif;
                   
                   $domain = get_option( 'domain_option' );
                   
                   if(!empty($values->group_effect)):
                      
                      if( intval($values->group_effect) == 1 ){
                        $effect = 'slide';
                      } else {
                        $effect = 'fade';
                      }
                      
                   else: $effect = 'fade'; endif;
                   
                   $paginate = $query_row_slides->paginate == 1 ? 'false' : 'true';
                   
                   $time  = !empty( $values->group_time ) ? intval($values->group_time) : 6000;
                   $speed = !empty( $values->group_speed ) ? intval($values->group_speed) : 3000;
                   
              ?>   
                   <style type="text/css">
                     div.flex-viewport{ height: 365px; }
                     #content .page div.single div.flex-viewport ul.slides li{ 
                        list-style-type: square;
                        margin: 0;
                        padding: 0;
                     }
                     div.single div.flexslider{
                        height: 415px;
                     }
                     
                     div.single div.flexslider ol.flex-control-nav{
                        bottom: 20px;
                        position: absolute;
                        text-align: center;
                        top: 380px;
                        width: 100%;
                     }
                     
                     #content .page ol.flex-control-nav li{   
                        margin: 0 0 6px 20px;
                        padding: 0;
                     }
                     
                     div.single div.flexslider .flex-control-paging li a.flex-active {
                        background: none repeat scroll 0 0 #17191B;
                     }
                   </style> 
               
                   <script type="text/javascript">
                      
                      jQuery(function(){
                          SyntaxHighlighter.all();
                      });
                      
                      jQuery(window).load(function(){
                          jQuery('.flexslider').flexslider({
                                animation: "<?php echo $effect; ?>",
                                controlNav: "thumbnails",
                                directionNav: <?php echo $paginate ?>,
                                contolNav: <?php echo $paginate; ?>,
                                animationSpeed: <?php echo $speed; ?>,
                                animationDuration: <?php echo $time; ?>,
                                prevText: "",    //String: Set the text for the "previous" directionNav item
                                nextText: "",   
                                start: function(slider){
                                  //jQuery('body').removeClass('loading');
                                }
                          });
                      });
                      
                   </script>
              <?php
                                      
                   $query = PL_DB::query_id("pslider", $atts_id, 'g_position' );
                    if( !empty($query)):
                        $query_slider = $query;
                    endif;
                    
                    if( $post->ID != 241 ){
                        $html .= '<div id="flexslider-back-button">';
                        $html .= '<a href="http://www.valleygeneralconstruction.com/about"> < Go Back</a>';
                        $html .= '</div>';
                    }
                    
                    $html .= '<div id="container" class="cf single">';
 	                $html .= '<div id="main" role="main">';
                    
                    $html .= '<section class="slider">';
                          
                    $html .= '<div class="flexslider">';
                               
                        $html .= '<ul class="slides">';
           
                            foreach($query_slider as $query_row => $query_val){
                                 
                                 $url      = trim($query_val->url);
                                 $last_url = substr( $url, strrpos( $url, '/' ) + 1 );
                                 $desc     = trim($query_val->description);
                                 
                                 $vowels = array( 'http://', '66.147.244.106/', '~plontade/', 'vgc' );
                                 
                                 $val_url = str_replace( $vowels, "", $url );
                                 $val_urlres = trim( $domain . $val_url ); 
                                      
                                 $html    .= '<li><img src="'.$val_urlres.'" /></li>';
                              	    	
                             }
                                    
                         $html .= '</ul>';    
                                   
                         $html .= '</div>';   
                         
                     $html .= '</section>';
                     
                     $html .= ' </div>';
                        
                     $html .= '</div>';
                    
                   return $html;
                   
              }
              
          ?>
           
    <?php endif; ?>
    
<?php } ?>