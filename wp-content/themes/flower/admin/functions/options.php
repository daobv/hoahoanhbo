<?php
/**
 * TFS Admin
 *
 * @package     WordPress
 * @subpackage  TFS
 * @since       1.4.0
 * @author      TFS
 */
 

/**
 * Add default options upon activation else DB does not exist
 *
 * DEPRECATED, Class_options_machine now does this on load to ensure all values are set
 *
 * @since 1.0.0
 */
function tfs_option_setup() {
	global $tfs_options, $options_machine;
	$options_machine = new Options_Machine($tfs_options);
		
	if (!tfs_get_options()) {
		tfs_save_options($options_machine->default);
	}
}

/**
 * Get options from the database and process them with the load filter hook.
 *
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @return array
 */
function tfs_get_options($key = null, $data = null) {

	if ($key != null) { // Get one specific value
		$data = get_theme_mod($key, $data);
	} else { // Get all values
		$data = get_theme_mods();		
	}
	$data = apply_filters('tfs_options_after_load', $data);

	return $data;

}

/**
 * Save options to the database after processing them
 *
 * @param $data Options array to save
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @uses update_option()
 * @return void
 */

function tfs_save_options( $data, $key = null ) {
	global $tfs_data;

    if ( empty( $data ) )
        return;	

	$data = apply_filters( 'tfs_options_before_save', $data );
	if ( $key != null ) { // Update one specific value
		if ( $key == BACKUPS ) {
			unset( $data['tfs_init'] ); // Don't want to change this.
		}
		set_theme_mod( $key, $data );
	} else { // Update all values in $data
		
		foreach ( $data as $k => $v ) {
			if ( !isset( $tfs_data[$k] ) || $tfs_data[$k] != $v ) { // Only write to the DB when we need to
				set_theme_mod( $k, $v );
			}
	  	}
	}
}


function tfs_media_uploader( $id, $std, $mod ){
    $data = tfs_get_options();
    $tfs_data = tfs_get_options();
	
	$uploader = '';
	$upload = $tfs_data[$id];
	$hide = '';
	
	if ($mod == "min") {$hide ='hide';}
	
    if ( $upload != "") { $val = $upload; } else {$val = $std;}
    
	$uploader .= '<input class="'.$hide.' upload tfs-input" name="'. $id .'" id="'. $id .'_upload" type="text" value="'. $val .'" />';	
	
	//Upload controls DIV
	$uploader .= '<div class="upload_button_div">';
	//If the user has WP3.5+ show upload/remove button
	if ( function_exists( 'wp_enqueue_media' ) ) {
		$uploader .= '<span class="button media_upload_button" id="'.$id.'">Upload</span>';
		
		if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
		$uploader .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
	} else {
		$output .= '<p class="upload-notice"><i>Upgrade your version of WordPress for full media support.</i></p>';
	}

	$uploader .='</div>' . "\n";

	//Preview
	$uploader .= '<div class="screenshot">';
	if(!empty($upload)){	
    	$uploader .= '<a class="tfs-uploaded-image" href="'. $upload . '">';
    	$uploader .= '<img class="tfs-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
    	$uploader .= '</a>';			
		}
	$uploader .= '</div>';
	$uploader .= '<div class="clear"></div>' . "\n"; 

	return $uploader;
}

function tfs_sanitize_option( $value ) {
	$defaults = array(
		"name" 		=> "",
		"desc" 		=> "",
		"id" 		=> "",
		"std" 		=> "",
		"mod"		=> "",
		"type" 		=> ""
	);

	$value = wp_parse_args( $value, $defaults );
	return $value;
}