jQuery(function(){
    
    // slides
    /** jQuery('input.delete_checked').live('click',function(){
        var number_of_checked = jQuery('input.delete_checked:checked').length;
        if( number_of_checked !=0 ){
            jQuery('input#del_id').attr('value', 'Delete - ' + number_of_checked );
        } else {
            jQuery('input#del_id').attr('value', 'Delete' ); 
        }  
    });
    
    jQuery('input#delete_val').live('click',function(){
        if( jQuery(this).is(':checked') ){  
            jQuery('input.delete_checked').attr('checked', true);
            var num_check = jQuery('input.delete_checked:checked').length; 
            jQuery('input#del_id').attr('value', 'Delete - ' + num_check ); 
        } else {  
            jQuery('input.delete_checked').attr('checked', false); 
            jQuery('input#del_id').attr('value', 'Delete' );
        } 
    }); **/
    
    jQuery("input#delete_val").click(function(){
        
        var checked = jQuery(this).parent().parent().parent().parent().parent();
        
        if( jQuery(this).is(':checked') ){  
            
            if( checked ){
                
                checked.find('input.delete_checked').attr('checked', true);
                
                var num_check = jQuery('input.delete_checked:checked').length; 
                
                jQuery('input#del_id').attr('value', 'Delete - ' + num_check ); 
            }
            
        } else {
            
            checked.find('input.delete_checked').attr('checked', false); 
            
            var num_check = jQuery('input.delete_checked:checked').length; 
            
            if( num_check != 0 ){
                jQuery('input#del_id').attr('value', 'Delete - ' + num_check );
                
            } else {
                jQuery('input#del_id').attr('value', 'Delete' );
            }
            
        }   
    });
    
    jQuery('input.delete_checked').click(function(){
        
        var number_of_checked = jQuery('input.delete_checked:checked').length;
        
        if( number_of_checked !=0 ){
            jQuery('input#del_id').attr('value', 'Delete - ' + number_of_checked );
        } else {
            jQuery('input#del_id').attr('value', 'Delete' ); 
        }  
        
    });
            
    // slides group
    jQuery('input.delete_group_checked').live('click',function(){
        var del_group_val = 'Delete Group';
        var number_of_checked = jQuery('input.delete_group_checked:checked').length;
        if( number_of_checked !=0 ){
            jQuery('input#del_group_id').attr('value', del_group_val + ' - ' + number_of_checked );
        } else {
            jQuery('input#del_group_id').attr('value', del_group_val ); 
        }  
    });
    
    jQuery('input#delete_group_val').live('click',function(){
        var del_group_val = 'Delete Group';
        if( jQuery(this).is(':checked') ){  
            jQuery('input.delete_group_checked').attr('checked', true);
            var num_check = jQuery('input.delete_group_checked:checked').length; 
            jQuery('input#del_group_id').attr('value', del_group_val + ' - ' + num_check ); 
        } else {  
            jQuery('input.delete_group_checked').attr('checked', false); 
            jQuery('input#del_group_id').attr('value', del_group_val );
        } 
    }); 
    
    // slides group delete
    jQuery('input.delete_group_slides_checked').live('click',function(){
        var del_group_val = 'Delete';
        var number_of_checked = jQuery('input.delete_group_slides_checked:checked').length;
        if( number_of_checked !=0 ){
            jQuery('a#delete_group_slides').text( del_group_val + ' - ' + number_of_checked );
        } else {
            jQuery('a#delete_group_slides').text( del_group_val ); 
        }  
    });
    
    jQuery('input#delete_group_slides_val').live('click',function(){
        var del_group_val = 'Delete';
        if( jQuery(this).is(':checked') ){  
            jQuery('input.delete_group_slides_checked').attr('checked', true);
            var num_check = jQuery('input.delete_group_slides_checked:checked').length; 
            jQuery('a#delete_group_slides').text( del_group_val + ' - ' + num_check ); 
        } else {  
            jQuery('input.delete_group_slides_checked').attr('checked', false); 
            jQuery('a#delete_group_slides').text( del_group_val );
        } 
    }); 
      
    jQuery("a.thumb-icon").hover(function(){
        
         jQuery(this).prev().fadeIn(200);
          
    }, function(){
         
         jQuery(this).prev().fadeOut(200);
         
    });
    
    jQuery("input#upload_text_id").click(function(){
          
          jQuery("input#upload_submit_id").click();
          
    });
    
    jQuery("input#custom_time_submit_id").click(function(e){
         e.preventDefault();
         
         if( jQuery(this).next().is(":visible") == true ){
            
             jQuery(this).next().fadeOut(200);
             
         } else {
              
             jQuery(this).next().fadeIn(200);
            
         }
         
    });
    
    jQuery("span.upload_text_id_end_remove").click(function(){
         
         jQuery(this).parent().prev().parent().remove();
    });
    
    jQuery("span.option-icon").click(function(){

         if( jQuery(this).next().fadeIn(200) ){
             
             if( jQuery(this).hasClass('option-icon-save') ){
                
                 jQuery(this).removeClass("option-icon-save");
                 
             } else {
                 jQuery(this).addClass("option-icon-save");
             }
         } 
 
    });
    
    jQuery("div#browse_upload div").on('click', 'span', function(){
         jQuery(this).parent().remove();
    });
    
    jQuery("div#browse_upload div span").live('click', function(){
         jQuery(this).parent().remove();
    });
    
    /** jQuery("div#browse_upload div").hover( function(){

         jQuery(this).find('span').fadeIn(200);
        
    }, function(){
         
          jQuery(this).find('span').fadeOut(200);
    }); **/
    
    jQuery("div#browse_upload").on('hover', 'div', function(){
        
        var this_val = jQuery(this);
        
        if( this_val.find('span').is(":visible") == true ){
            
            this_val.find('span').fadeOut(200);
            this_val.find('a').fadeOut(200);
            
        } else {
            
            this_val.find('span').fadeIn(200);
            this_val.find('a').fadeIn(200);
            
        }
    });
    
    
    /** xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    
    // input type - accept only numeric values
    
    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx **/
    
    jQuery(".group_time").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
		} else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});
    
    jQuery(".group_speed").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
		} else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});
    
    jQuery(".group_limit").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
		} else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});
    
    jQuery(".group_limit_class").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
		} else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});
    
    jQuery(".width_class").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
		} else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});
    
    jQuery(".height_class").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
		} else {
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});
    
    jQuery("a#upload1-active").click(function(e){
         e.preventDefault();
         
         jQuery("div#upload1").show();
         jQuery("div#upload2").hide();
          
    });
    
    jQuery("a#upload2-active").click(function(e){
         e.preventDefault();
         
         jQuery("div#upload1").hide();
         jQuery("div#upload2").show();
          
    });
    
    /* filter by group for slides */
    
    /** jQuery("div#filter-group").on('click', 'a', function(e){
         e.preventDefault();
         
         var lastClass = jQuery(this).attr('class').split(' ').pop();
         
         if( lastClass ){

             jQuery("table#table_list tr.sort").hide(); 
             jQuery("table#table_list tr."+lastClass).show();
             
         }
    }); **/
    
    jQuery("input#text_multi").click(function(){
         jQuery("input#upload_multi").click();
    });
    
    jQuery("span.more-option-icon").click(function(e){
        e.preventDefault();
         
        var this_val = jQuery(this);

        if( this_val.next().is(":visible") == true ){
            
            this_val.next().fadeOut(200);
            
            jQuery(this).prev().prev().removeClass("option-icon-save");
            
            jQuery(this).prev().find("input.group_time").prop('disabled', true);
            jQuery(this).prev().find("input.group_speed").prop('disabled', true);
            
            
        } else {
            
            this_val.next().fadeIn(200);
            
            jQuery(this).prev().prev().addClass("option-icon-save");
            
            jQuery(this).prev().find("input.group_time").prop('disabled', false);
            jQuery(this).prev().find("input.group_speed").prop('disabled', false);
            
        } 
          
    });
    
    /** xxxxxxxxxxxxxxxx width and height option value xxxxxxxxxxxxxxx **/
    
    /** jQuery("span.width-option-select").click(function(){
         
           var text = jQuery(this).prev().text();
           var input_val = jQuery(this).find("input.width-option-input").attr('value');
         
           var Array = [ "Width(px)", "Width(%)", "px", "%" ];
           
           if( text == Array[0] ){
               
               jQuery(this).prev().text(Array[1]);

               jQuery(this).find("input.width-option-input").attr('value', Array[3]);
               
           }  else {
               
               jQuery(this).prev().text(Array[0]);
               
               jQuery(this).find("input.width-option-input").attr('value', Array[2]);
               
           }
           
    });
    
    jQuery("span.height-option-select").click(function(){
         
           var text = jQuery(this).prev().text();
           var input_val = jQuery(this).find("input.height-option-input").attr('value');
           
           var Array = [ "Height(px)", "Height(%)", "px", "%" ];
           
           if( text == Array[0] ){
               
               jQuery(this).prev().text(Array[1]);
               
               jQuery(this).find("input.height-option-input").attr('value', Array[3]);
               
           }  else {
               
               jQuery(this).prev().text(Array[0]);
               
               jQuery(this).find("input.height-option-input").attr('value', Array[2]);
           }
           
    }); **/
    
    /** xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx **/
    
});