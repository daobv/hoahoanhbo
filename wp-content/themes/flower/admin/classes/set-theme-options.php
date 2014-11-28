<?php
class Tfs_Set_Theme_Options {

	function init() {
		// Add Options page
		add_action( 'admin_menu', array( get_class(), 'tfs_add_menu' ) );	

		// Add the script and style files
		add_action( 'admin_print_styles', array( get_class(), 'tfs_load_styles' ) );
		add_action( 'admin_print_scripts', array( get_class(), 'tfs_load_scripts' ) );

		add_action( 'admin_head', array( get_class(), 'tfs_message' ) );
		add_action( 'admin_init', array( get_class(), 'tfs_options' ) );
		add_action( 'admin_init', array( get_class(), 'tfs_options_machine' ) );

		add_filter( 'tfs_options_before_save', array( get_class(), 'tfs_filter_save_media_upload' ) );
		add_filter( 'tfs_options_after_load', array( get_class(), 'tfs_filter_load_media_upload' ) );

		add_action( 'wp_ajax_tfs_ajax_post_action', array( get_class(), 'tfs_ajax_callback' ) );
	}

	// Integrate the menu
	function tfs_add_menu() {
		add_theme_page( sprintf( '%s Options', THEMENAME ), 'Theme Options', 'edit_theme_options', 'theme-options', array( get_class(), 'tfs_show_menu' ) );
	}

	function tfs_show_menu(){
		if ( isset($_GET['page']) && $_GET['page'] == 'theme-options') {
			global $options_machine;
			include_once ADMIN_PATH . 'templates/theme-options.php';
		}
	}

	function tfs_load_styles() {
		if ( isset($_GET['page']) && $_GET['page'] == 'theme-options') {
			wp_enqueue_style('admin-style', ADMIN_TEMPLATES . 'css/admin-style.css');

			if ( !wp_style_is( 'wp-color-picker','registered' ) ) {
				wp_register_style( 'wp-color-picker', ADMIN_TEMPLATES . 'css/color-picker.min.css' );
			}
			wp_enqueue_style( 'wp-color-picker' );
			
		}
	}
	
	function tfs_load_scripts() {
		if ( isset($_GET['page']) && $_GET['page'] == 'theme-options') {
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('tfs', ADMIN_TEMPLATES .'js/tfs.js', array( 'jquery' ));

			// Enqueue colorpicker scripts for versions below 3.5 for compatibility
			if ( !wp_script_is( 'wp-color-picker', 'registered' ) ) {
				wp_register_script( 'iris', ADMIN_TEMPLATES .'js/iris.min.js', array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
				wp_register_script( 'wp-color-picker', ADMIN_TEMPLATES .'js/color-picker.min.js', array( 'jquery', 'iris' ) );
			}
			wp_enqueue_script( 'wp-color-picker' );

			if ( function_exists( 'wp_enqueue_media' ) )
				wp_enqueue_media();
		}		
	}

	function tfs_message() { 
		//Tweaked the message on theme activate
		?>
	    <script type="text/javascript">
	    jQuery(function(){
	        var message = '<p>This theme comes with an <a href="<?php echo admin_url('admin.php?page=theme-options'); ?>">options panel</a> to configure settings. This theme also supports widgets, please visit the <a href="<?php echo admin_url('widgets.php'); ?>">widgets settings page</a> to configure them.</p>';
	    	jQuery('.themes-php #message2').html(message);
	    });
	    </script>
	    <?php
	}

	function tfs_options() {
    	
		// Social Sharing	

		$tfs_options[] = array( "name" 		=> "Social Sharing",
								"type" 		=> "heading"
						); 

		$tfs_options[] = array( "name" 		=> "Enter URL to your Facebook Account",
								"desc" 		=> "",
								"id" 		=> "tfs-social-facebook",
								"std" 		=> "#",
								"type" 		=> "text"
						); 
		$tfs_options[] = array( "name" 		=> "Enter URL to your Googleplus Account",
								"desc" 		=> "",
								"id" 		=> "tfs-social-googleplus",
								"std" 		=> "#",
								"type" 		=> "text"
						); 
	}

	


	function tfs_options_machine() {
		// Rev up the Options Machine
		global $tfs_options, $options_machine;
		$options_machine = new Options_Machine( $tfs_options );
		$tfs_data = tfs_get_options();

		if ( empty( $tfs_data['tfs_init'] ) ) { // Let's set the values if the theme's already been active
			tfs_save_options( $options_machine->default );
			tfs_save_options(date('r'), 'tfs_init');
			$tfs_data = tfs_get_options();
			$options_machine = new Options_Machine($tfs_options);
		}
	}

	function tfs_filter_save_media_upload( $data ) {
		if ( !is_array( $data ) ) 
	    	return $data;

	    foreach ( $data as $key => $value ) {
	        if (is_string($value)) {
	            $data[$key] = str_replace(
	                array(
	                    site_url('', 'http'),
	                    site_url('', 'https'),
	                ),
	                array(
	                    '[site_url]',
	                    '[site_url_secure]',
	                ),
	                $value
	            );
	        }
	    }
	    return $data;
	}

	function tfs_filter_load_media_upload($data) {
	    if ( !is_array( $data ) ) 
	    	return;
	    foreach ($data as $key => $value) {
	        if (is_string($value)) {
	            $data[$key] = str_replace(
	                array(
	                    '[site_url]', 
	                    '[site_url_secure]',
	                ),
	                array(
	                    site_url('', 'http'),
	                    site_url('', 'https'),
	                ),
	                $value
	            );
	        }
	    }
	    return $data;
	}

	function tfs_ajax_callback() {
		global $options_machine, $tfs_options;

		$nonce = $_POST['security'];

		if ( ! wp_verify_nonce( $nonce, 'tfs-ajax-nonce' ) ) 
			die( '-1' ); 

		$save_type = $_POST['type'];
		
		if ( $save_type == 'save' ) {
			wp_parse_str( stripslashes( $_POST['data'] ), $tfs_data );
			tfs_save_options( $tfs_data );
			die( '1' );
		} elseif ( $save_type == 'reset' ) {
			tfs_save_options( $options_machine->default );
			$tmp_arr = $options_machine->default;
	        die( '1' ); //options reset
		}

	  	die();
	}

}