jQuery(function(){
   

      jQuery("select#select_group_id").change(function(){
            
            var ajaxurl = ajax_script.ajax_url;
            var value   = jQuery(this).val();
            
            if( value.length !=0 ){
                
                jQuery.ajax ({
                                  data: { 
                                     action  : 'ajax_group_selected', 
                                     val_id  : value,
                                  },
                                  type   : 'POST',
                                  url    : ajaxurl,
                                  beforeSend: function() {
                                       jQuery("span.ajax-photos-load").show();
                                  },
                                  error: function(xhr, status, err) {
                                       // Handle errors
                                  },
                                  success: function(html, data) {
                                       jQuery("div#browse_upload").html( html );
                                  }
                            }).done(function( html, data ) {
                                  jQuery("span.ajax-photos-load").hide();
                            });
                            
            }
    
      });
    
});