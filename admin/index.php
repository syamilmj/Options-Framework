<?php
/*
Title		: SMOF
Description	: Slightly Modified Options Framework
Version		: 1.4.0
Author		: Syamil MJ
Author URI	: http://aquagraphite.com
License		: WTFPL - http://sam.zoy.org/wtfpl/
Credits		: Thematic Options Panel - http://wptheming.com/2010/11/thematic-options-panel-v2/
		 	  KIA Thematic Options Panel - https://github.com/helgatheviking/thematic-options-KIA
		 	  Woo Themes - http://woothemes.com/
		 	  Option Tree - http://wordpress.org/extend/plugins/option-tree/
*/

/**
 * Definitions
 *
 * @since 1.4.0
 */
$themedata = get_theme_data( TEMPLATEPATH . '/style.css' );
$themename = str_replace( ' ','',strtolower($themedata['Name']) );
define( 'SMOF_VERSION', '1.4.0' );
define( 'ADMIN_PATH', TEMPLATEPATH . '/admin/' );
define( 'ADMIN_DIR', get_template_directory_uri() . '/admin/' );
define( 'LAYOUT_PATH', ADMIN_PATH . '/layouts/' );
define( 'THEMENAME', $themedata['Name'] );
define( 'OPTIONS', $themename.'_options' );
define( 'BACKUPS',$themename.'_backups' );

/**
 * Required action filters
 *
 * @uses add_action()
 *
 * @since 1.0.0
 */
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) add_action('admin_head','of_option_setup');
add_action('admin_head', 'optionsframework_admin_message');
add_action('admin_init','optionsframework_admin_init');
add_action('admin_menu', 'optionsframework_add_admin');

/**
 * Required Files
 *
 * @since 1.0.0
 */ 
require_once ( ADMIN_PATH . 'functions/functions.load.php' );
require_once ( ADMIN_PATH . 'classes/class.options_machine.php' );

/**
 * AJAX Saving Options
 *
 * @since 1.0.0
 */
add_action('wp_ajax_of_ajax_post_action', 'of_ajax_callback');

?>