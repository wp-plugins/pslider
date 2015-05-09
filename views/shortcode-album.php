<?php
   
    function display(){
         $html = null;
          
         $group_query = PL_DB::query( 'pslider_group' );
         if( !empty( $group_query ) ){
              
              $count = 1;
              
              foreach( $group_query as $group_query_keys => $group_query_vals ){
                
                    $gid = intval( $group_query_vals->id );
                    $gname = trim( $group_query_vals->name );
                    
                    $class = ( $count % 2 == 0 ) ? '' : 'first';
                        
                        $sql = PL_DB::query_id("pslider", $gid, 'g_position' );
                        if( !empty($sql)){
                            
                            $counter = 1;
                            
                            foreach( $sql as $sql_keys => $sql_vals ){
                                
                                $url = trim( $sql_vals->url );
   
                                if( $counter == 1 ){
                                    
                                    //var_dump( $counter );
                                    
                                    $html .= '<div class="about-us '.$class.'">';
                                    $html .= '<div class="about-us-img"><img src="'.$url.'" /></div>';
                                    $html .= '<div class="about-us-link"><a href="https://www.facebook.com/media/set/?set=a.158489340832631.43215.129903703691195&type=3" target="_blank">'.$gname.'</a></div>';
                                    $html .= '</div>';
                                
                                }
                                
                                $counter++;
                                
                            }
                        }
              
                  $count++;   
              }
         }
         
         return $html;
          
    }
   
 
?>
