<?php
/*
Title		: TFS
Description	: Tfs Options Framework
Version		: 1.0 
Author		: the Vietconex team
Author URI	: http://www.vietconex.com
Contributors: Mr Hiển - http://nguyenduyhien.com
			  Dương Khương - http://www.vietconex.com
*/

if ( function_exists( 'wp_get_theme' ) ) {
	if( is_child_theme() ) {
		$temp_obj = wp_get_theme();
		$theme_obj = wp_get_theme( $temp_obj->get('Template') );
	} else {
		$theme_obj = wp_get_theme();    
	}
	$theme_version = $theme_obj->get('Version');
	$theme_name = $theme_obj->get('Name');
	$theme_uri = $theme_obj->get('ThemeURI');
	$author_uri = $theme_obj->get('AuthorURI');
} else {
	$theme_data = wp_get_theme( get_template_directory().'/style.css' );
	$theme_version = $theme_data['Version'];
	$theme_name = $theme_data['Name'];
	$theme_uri = $theme_data['ThemeURI'];
	$author_uri = $theme_data['AuthorURI'];
}

define( 'TFS_VERSION', '1.0' );
if ( !defined( 'ADMIN_PATH' ) )
	define( 'ADMIN_PATH', get_template_directory() . '/admin/' );
if ( !defined( 'ADMIN_DIR' ) )
	define( 'ADMIN_DIR', get_template_directory_uri() . '/admin/' );
define( 'ADMIN_TEMPLATES', ADMIN_DIR . 'templates/' );
define( 'THEMENAME', $theme_name );
define( 'THEMEVERSION', $theme_version );
define( 'THEMEURI', $theme_uri );
define( 'THEMEAUTHORURI', $author_uri );

// Minimum supported version of WordPress
define( 'TFS_SUPPORTED_WP_VERSION', version_compare( get_bloginfo( 'version' ), '3.3', '>=' ) );

// Minimum supported version of PHP
define( 'TFS_SUPPORTED_PHP_VERSION', version_compare( phpversion(), '5.2.4', '>=' ) );

// Compatibility check
if ( TFS_SUPPORTED_WP_VERSION && TFS_SUPPORTED_PHP_VERSION ) {
	tfs_options_loader();
	do_action( 'tfs_options_loader' );
} else {
	// Disable WPG if compatibility check fails
	add_action( 'admin_head', 'tfs_fail_notices' );
	function tfs_fail_notices() {
		if ( !TFS_SUPPORTED_WP_VERSION ) {
			echo '<div class="error"><p><strong>Rostev Theme</strong> requires WordPress 3.3 or higher. Please upgrade WordPress and activate the Rostev theme again.</p></div>';
		}
		if ( !TFS_SUPPORTED_PHP_VERSION ) {
			echo '<div class="error"><p><strong>Rostev Theme</strong> requires PHP 5.2.4 or higher. Please upgrade PHP and activate the Rostev theme again.</p></div>';
		}
	}
}

// Load the WPG application
function tfs_options_loader() {
	// Functions
	require_once ADMIN_PATH . '/functions/options.php';

	// Classes
	require_once ADMIN_PATH . 'classes/set-theme-options.php';
	require_once ADMIN_PATH . 'classes/options-machine.php';

	// Initialize objects
	Tfs_Set_Theme_Options::init();
}

global $tfs_op_data;
$tfs_op_data = tfs_get_options();