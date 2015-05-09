<?php if( !class_exists('PL_BaseHtml')){
    
     class PL_BaseHtml{
         
         public static $text = "text";
         
         // html:table(array(), array());
         public static function table($elem=array(), $tab=array()){
            
               $html = null;
                
               if(is_array($elem) AND is_array($tab) ){
                
                    if(count($elem)>=1 AND count($tab)>=1){
                        
                          foreach($elem as $elem_key => $elem_var ){
                             if( !is_null($elem[$elem_key])) $elem_res .= $elem_key ."=". $elem[$elem_key] . " "; 
                          }
                          
                          $html .= '<table '.$elem_res.'>';
                          $html .= '<tbody>';

                          foreach($tab as $tab_key => $tab_var ){

                             if( is_string( $tab_var )) 
                                 $html .= '<tr class="form-field form-required">'; 
                                 
                                 $labl = array( 
                                                 'text' => $tab_key,
                                                 'class' => 'description',
                                               );
                                 
                                 $html .= "<th scope='row'>".self::label($labl)."</th><td>".$tab[$tab_key]."</td>"; 
                                 $html .= '</td>';
                          }
                          
                          $html .= '</tbody>';
                          $html .= '</table>';
                          
                    }
               }
               
               return $html;
         }
         
          // html:form_table(array(), array());
         public static function form_table($elem=array(), $tab=array()){
            
               $html = null;
                
               if(is_array($elem) AND is_array($tab) ){
                
                    if(count($elem)>=1 AND count($tab)>=1){
                        
                          foreach($elem as $elem_key => $elem_var ){
                             if( !is_null($elem[$elem_key])) $elem_res .= $elem_key ."=". $elem[$elem_key] . " "; 
                          }
                          
                          $html .= '<table '.$elem_res.'>';
                          $html .= '<tbody>';

                          foreach($tab as $tab_key => $tab_var ){

                             if( is_string( $tab_var )) 
                                 $html .= '<tr class="form-field form-required">'; 
                                 
                                 $labl = array( 
                                                 'text' => $tab_key,
                                                 'class' => 'description',
                                               );
                                 
                                 $html .= "<th scope='row'>".self::label($labl)."</th><td>".$tab[$tab_key]."</td>"; 
                                 $html .= '</td>';
                          }
                          
                          $html .= '</tbody>';
                          $html .= '</table>';
                          
                    }
               }
               
               return $html;
         }
         
         // html:table_list(array(), array(), array());
         public static function table_list($elem=array(), $tab1=array(), $tab2=array()){
            
               $html = null;
               $elem_res = null;
               
               $sort_value = null;
               
               if(is_array($elem) AND is_array($tab1) AND is_array($tab2)){
                
                    if(count($elem)>=1 AND count($tab1)>=1 AND count($tab2)>=1){
                          
                          foreach($elem as $elem_key => $elem_var ){
                             if( !is_null($elem[$elem_key])) $elem_res .= $elem_key ."=". $elem[$elem_key] . " "; 
                          }
                          
                          $html .= '<table '.$elem_res.'>';
                          $html .= '<tbody>';
                          
                          // exam = array( 1, 2, 3 );
                          
                          foreach($tab1 as $tab1_key => $tab1_var):
                                
                               $tab1_value = $tab1[$tab1_key];
                               
                               $label = array( 
                                               'text' => $tab1_value, 
                                               'for' => 'description' 
                                             );
                               
                               $label_class = 'class="label"';
                               
                               $html .= '<td '.$label_class.'>'.PL_BaseHtml::label( $label ).'</td>';
 
                          endforeach;
                          
                          // exam = array( array(1), array(2), array(3) )
                          
                          foreach($tab2 as $tab2_key => $tab2_var):
                                
                               $tab2_value = $tab2[$tab2_key];
                               
                               if( is_array($tab2_value) ){
                                
                                   if( count($tab2_value)>=1 ){
                                       
                                       $key_val = array_keys( $tab2_value );
                                       $value_sort_filter = !empty( $key_val[4] ) ? $key_val[4] : !empty($key_val[2]) ? $key_val[2] : $key_val[3];
                                       
                                       $html .= '<tr class="sort '.$value_sort_filter.'">';
                                       
                                       foreach( $tab2_value as $tab2_value_key => $tab2_value_result ){
                                           
                                               if( is_string($tab2_value[$tab2_value_key])) {
                                                
                                                    $html .= '<td class="result '.$tab2_value_key.'" >' . ( $tab2_value[$tab2_value_key] ) . '</td>';
                                                    
                                               }
                                                 
                                       }
                                       
                                       $html .= '</tr>';
                                       
                                   }
                                
                               }
                                
                          endforeach;
                          
                          foreach($tab1 as $tab1_key => $tab1_var):
                                
                               $tab1_value = $tab1[$tab1_key];
                               
                               $label = array( 
                                               'text' => $tab1_value, 
                                               'for' => 'description' 
                                             );
                               
                               $label_class = 'class="label"';
                               
                               $html .= '<td '.$label_class.'>'.PL_BaseHtml::label( $label ).'</td>';
 
                          endforeach;
                          
                          $html .= '</tbody>';
                          $html .= '</table>';
                    
                    }
            
               }
               
               return $html;
         }
         
         // html:label(array() );
         public static function label($label=array()){
            
            $label_result = null; 
            $label_text = null;
            
            if( is_array($label) AND !is_null($label)){
                
                if(count($label)>=1){
                    
                    foreach($label as $label_key => $label_var){
                        if( $label_key == self::$text ){
                            $label_text .= $label[$label_key];
                        }
                        
                        if( $label_key != self::$text ){ 
                            $label_result .= $label_key . "=" . $label[$label_key] . " ";
                        }  
                        
                    }
                    
                    return "<label ".$label_result.">".$label_text."</label>";   
                }  
            }
         }
         
         public static function textarea($label=array()){
               
            $label_result = null; 
            $label_text = null;
            
            if( is_array($label) AND !is_null($label)){
                
                if(count($label)>=1){
                    
                    foreach($label as $label_key => $label_var){
                        
                        if( $label_key == self::$text ){
                            $label_text .= $label[$label_key];
                        }
                        
                        if( $label_key != self::$text ){ 
                            $label_result .= $label_key . "=" . $label[$label_key] . " ";
                        }  
                        
                    }
                    
                    return "<textarea ".$label_result.">".$label_text."</textarea>";   
                }  
            } 
         }
         
         public static function fieldset($legend=null,$is_string=null){
            $html = null;

            if( !is_null( $is_string)){ 
             	$html .= "<fieldset>";
                
                if( !is_null($legend) AND is_string($legend) ): $html .= "<legend>$legend</legend>"; endif;
                
                if( is_string($is_string) ): $html .= $is_string; endif;
                
                $html .= "</fieldset>";
            }
            
            return $html;
             
         }
         
         public static function icon_logo($title=null, $details=null){
             if( !is_null($title) AND !is_null($details )){
                  
                  if( is_string($title) AND is_string($title)){
                    
                         return "<div id='icon-slider' class='icon-slider'><br /></div>
                                 <h2 class='title'>$title</h2>
                                 <p>$details</p>";  
                                 
                  }
             }
         }
         
         public static function select($elem=array(),$array=array(), $filter=null, $default=null){
             $html  = null;
             $label = null;
             $count = 0;
             
             if(!empty($array) AND !empty($elem)){
                 
                 if( is_array($elem)){
                     
                     foreach($elem as $elem_row => $elem_val ){
                         $label .= $elem_row . "='" . $elem[$elem_row] . "' ";
                     }
                     
                     $html .= '<select '.$label.'>';
                     
                     $select_defualt = !is_null($default) ? $default : "...";
                     
                     $html .= '<option>Select '.$select_defualt.'</option>';
                     
                     foreach( $array as $array_row => $array_val ){
                              
                              $array_key_val = $array_row == $count ? $array_val : $array_row;
  
                              $is_selected = $array_key_val == $filter ? "selected=''" : false; 
                              
                              $html .= '<option value="'.$array_key_val.'" '.$is_selected.'>' . trim( $array_val ) . '</option>';
                              
                              $count++;
                     }
                     
                     $html .= '</select>';
                 }
             }
             
             return $html;
             
         }
         
         public static function href($elem=array()){
             
             $html = null;
             
             if( !empty($elem)){
                 
                 if( is_array($elem)) {
                     
                     foreach($elem as $elem_keys => $elem_vals){
                         
                          $elem_vals_res[] = $elem_vals;
                         
                     }
                      
                 }
                 
                 $html .= '<a href=""></a>'; 
             }
               
         }
        
     }
     
}
?>