<?php
         $icon_title = "Option";
         $icon_label = "";
?>

<?php echo PL_BaseHTML::icon_logo( $icon_title, $icon_label ); ?>

<?php echo PL_BaseInput::form_open(array( 'method' => 'post', 'id' => 'option_group' )); ?>

    <div id="add_group">
         <?php echo PL_BaseHTML::label(array( 'text' => 'Domain', 'for' => 'description' )); ?>
         <p>
            <?php
               
                $get_domain = get_option( 'domain_option' );
                 
            ?>
            
            <?php
                   $option_value = array( 
                                           'name' => 'option_value', 
                                           'value' => $get_domain,
                                           'id' => 'option_value_id',
                                           'class' => 'option_value_class',
                                           'maxlength' => '',
                                        );
                                
                   echo PL_BaseInput::text( $option_value );  
               ?>
         </p>
    </div>
    
    <div class="clear"></div>
    
    <div id="option-submit">
    
        <?php
    
                     $submit_option = array( 
                                               'name'  => 'save_option', 
                                               'value' => 'Change',
                                               'id'    => 'save_option_id',
                                               'class' => 'save_option_class',
                                            );
        
                     echo PL_BaseInput::submit( $submit_option );
    
        ?>

    </div>

<?php echo PL_BaseInput::form_close(); ?> 