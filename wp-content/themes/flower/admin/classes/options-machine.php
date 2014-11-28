<?php 
class Options_Machine {

	var $output;
	var $menu;
	var $default;

	function __construct( $options ) {

		global $tfs_output;
	    $tfs_data = tfs_get_options();
		$data = $tfs_data;

		$default = array();   
	    $counter = 0;
		$menu = '';
		$output = '';

		$output .= $tfs_output;
		
		foreach ( $options as $value ) {
			
			$value = tfs_sanitize_option( $value );

			$counter++;
			$val = '';
			
			//create array of default		
			if ( $value['type'] == 'multicheck' ){
				if ( is_array( $value['std'] ) ) {
					foreach ( $value['std'] as $i=>$key ){
						$default[$value['id']][$key] = true;
					}
				} else {
					$default[$value['id']][$value['std']] = true;
				}
			} else {
				if ( isset( $value['id'] ) ) 
					$default[$value['id']] = $value['std'];
			}
            
            if ( $value['type'] == 'pagecheck' ){
				if ( is_array($value['std'] ) ) {
					foreach ( $value['std'] as $i => $key ){
						$default[$value['id']][$key] = true;
					}
				} else {
					$default[$value['id']][$value['std']] = true;
				}
			} else {
				if ( isset( $value['id'] ) )
					$default[$value['id']] = $value['std'];
			}
			
			/* condition start */
			if ( !empty( $tfs_data ) || !empty( $data ) ) {

				//Start Heading
				if ( $value['type'] != "heading" ) {
				 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
					
					//hide items in checkbox group
					$fold='';
					if ( array_key_exists( "fold", $value ) ) {
						if ( isset( $tfs_data[$value['fold']] ) && $tfs_data[$value['fold']] ) {
							$fold="f_".$value['fold']." ";
						} else {
							$fold="f_".$value['fold']." temphide ";
						}
					}
		
					$output .= '<div id="section-'.$value['id'].'" class="'.$fold.'section section-'.$value['type'].' '. $class .'">'."\n";
					
					//only show header if 'name' value exists
					//if($value['name']) $output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
					
					$output .= '<table class="tfs-table-op form-table"><tbody>'."\n";
		
				} 
				//End Heading
			 
				if ( !isset( $tfs_data[$value['id']] ) ) {
					$tfs_data[$value['id']] = $value['std'];
				}

				if ( !isset( $tfs_data[$value['id']] ) && $value['type'] != "heading" )
					continue;
			
				//switch statement to handle various options type                              
				switch ( $value['type'] ) {
					
					// Color picker
					case "color":
						$default_color = '';
						if ( isset($value['std']) ) {
							if ( $tfs_data[$value['id']] !=  $value['std'] )
							$default_color = ' data-default-color="' .$value['std'] . '" ';
						}
						$output .= '<tr class="form-field select_wrapper ' . $mini . '">';
						$output .= '<th scope="row">';
						$output .= '<span class="tfs-op-name">' . $value['name'] . '</span>';
						$output .= '<span class="tfs-op-desc">' . $value['desc'] . '</span>';
						$output .= '</th>';
						$output .= '<td>';
						$output .= '<input name="' . $value['id'] . '" id="' . $value['id'] . '" class="tfs-color"  type="text" value="' . $tfs_data[$value['id']] . '"' . $default_color .' />';
						$output .= '</td></tr>';
			 	
					break;

					//text input
					case 'text':
						$t_value = '';
						$t_value = stripslashes($tfs_data[$value['id']]);
						
						$mini ='';
						if(!isset($value['mod'])) $value['mod'] = '';
						if($value['mod'] == 'mini') { $mini = 'mini';}
						
						$output .= '<tr class="form-field select_wrapper ' . $mini . '">';
						$output .= '<th scope="row">';
						$output .= '<span class="tfs-op-name">' . $value['name'] . '</span>';
						$output .= '<span class="tfs-op-desc">' . $value['desc'] . '</span>';
						$output .= '</th>';
						$output .= '<td>';
						$output .= '<input class="tfs-input '.$mini.'" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $t_value .'" />';
						$output .= '</td></tr>';
					break;

					//tab heading
					case 'heading':
						if($counter >= 2){
						   $output .= '</div>'."\n";
						}
						$header_class = str_replace(' ','',strtolower($value['name']));
						$jquery_click_hook = str_replace(' ', '', strtolower($value['name']) );
						$jquery_click_hook = "tfs-option-" . $jquery_click_hook;
						
						$menu .= '<a id="'.  $jquery_click_hook  .'-tab"  class="nav-tab '. $header_class .'-tab"  title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a>';
						$output .= '<div class="group" id="'. $jquery_click_hook  .'">'."\n";
					break;
					
					// Uploader 3.5
					case "upload":
					case "media":

						if(!isset($value['mod'])) $value['mod'] = '';
						
						$u_val = '';
						if($tfs_data[$value['id']]){
							$u_val = stripslashes($tfs_data[$value['id']]);
						}
						$output .= '<tr class="form-field select_wrapper ' . $mini . '">';
						$output .= '<th scope="row">';
						$output .= '<span class="tfs-op-name">' . $value['name'] . '</span>';
						$output .= '<span class="tfs-op-desc">' . $value['desc'] . '</span>';
						$output .= '</th>';
						$output .= '<td>';
						$output .= tfs_media_uploader($value['id'],$u_val, $value['mod']);
						$output .= '</td></tr>';
					break;

					//select option
					case 'select':
						$mini ='';
						if(!isset($value['mod'])) $value['mod'] = '';
						if($value['mod'] == 'mini') { $mini = 'mini';}
						$output .= '<tr class="select_wrapper ' . $mini . '">';
						$output .= '<th scope="row">';
						$output .= '<span class="tfs-op-name">' . $value['name'] . '</span>';
						$output .= '<span class="tfs-op-desc">' . $value['desc'] . '</span>';
						$output .= '</th>';
						$output .= '<td>';
						$output .= '<select class="select" name="'.$value['id'].'" id="'. $value['id'] .'">';

						foreach ($value['options'] as $select_ID => $option) {
							$theValue = $option;
							if (!is_numeric($select_ID))
								$theValue = $select_ID;
							$output .= '<option id="' . $select_ID . '" value="'.$theValue.'" ' . selected($tfs_data[$value['id']], $theValue, false) . ' />'.$option.'</option>';	 
						 } 
						$output .= '</select></td></tr>';
					break;
					
				}

				$output .= $tfs_output;
			
				//description of each option
				if ( $value['type'] != 'heading' ) { 
					$output .= '</tbody></table>'."\n";
					$output .= '<div class="clear"> </div></div>'."\n";
				}
			
			} /* condition empty end */
		   
		}
		
	    $output .= '</div>';
		$output .= $tfs_output;
	    
	    $this->output = $output;
	    $this->menu = $menu;
	    $this->default = $default;
		
	}

}