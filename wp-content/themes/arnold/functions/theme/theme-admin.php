<?php
//define
define('arnold_THEME', get_template_directory_uri(). '/functions/theme' );
define('arnold_THEME_OPTIONS', get_template_directory_uri(). '/functions/theme/options' );
define('arnold_THEME_WIDGET', get_template_directory_uri(). '/functions/theme/widget' );
// define('arnold_THEME_SHORTCODES', get_template_directory_uri(). '/functions/theme/shortcodes' );
define('arnold_THEME_IMPORTER', get_template_directory_uri(). '/functions/theme/wordpress-importer' );
define('arnold_THEME_CUSTOMIZE', get_template_directory_uri(). '/functions/theme/customize' );

//theme scripts
function arnold_theme_options_enqueue_scripts(){
	global $post_type;
	
	// New Media Library
	if(function_exists('wp_enqueue_media')){ wp_enqueue_media(); }

	// Load default WP resources
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('wp-pointer');
	wp_enqueue_style('wp-pointer');
	wp_enqueue_script('json2');
	
	
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_script('jquery-ui-draggable');
	
	if(!wp_script_is('ux-admin-bootstrap', 'enqueued')){
		wp_enqueue_script('arnold-admin-bootstrap');
	}
	
	if(!wp_script_is('ux-admin-bootstrap-switch', 'enqueued')){
		wp_enqueue_script('arnold-admin-bootstrap-switch');
	}
	
	if(!wp_script_is('ux-admin-bootstrap-datetimepicker', 'enqueued')){
		wp_enqueue_script('arnold-admin-bootstrap-datetimepicker');
	}
	
	if(!wp_script_is('ux-admin-isotope', 'enqueued')){
		wp_enqueue_script('arnold-admin-isotope');
	}
	
	if(!wp_script_is('ux-admin-icheck', 'enqueued')){
		wp_enqueue_script('arnold-admin-icheck');
	}
	
	wp_enqueue_script('arnold-admin-minicolors');
	
	if($post_type == 'page'){
		wp_enqueue_script('jquery-ui-resizable');
		wp_enqueue_script('arnold-admin-gridstack');
		wp_enqueue_script('arnold-admin-gridstack-jquery-ui');
	}
	
	wp_enqueue_script('arnold-admin-theme-script');
	
	wp_enqueue_style('font-awesome');
	
	if(!wp_style_is('ux-admin-bootstrap', 'enqueued')){
		wp_enqueue_style('arnold-admin-bootstrap');
	}
	
	if(!wp_style_is('ux-admin-bootstrap-theme', 'enqueued')){
		wp_enqueue_style('arnold-admin-bootstrap-theme');
	}
	
	if(!wp_style_is('ux-admin-bootstrap-switch', 'enqueued')){
		wp_enqueue_style('arnold-admin-bootstrap-switch');
	}
	
	if(!wp_style_is('ux-admin-bootstrap-datetimepicker', 'enqueued')){
		wp_enqueue_style('arnold-admin-bootstrap-datetimepicker');
	}
	
	if(!wp_style_is('ux-admin-icheck', 'enqueued')){
		wp_enqueue_style('arnold-admin-icheck');
	}
	
	wp_enqueue_style('arnold-admin-minicolors');
	wp_enqueue_style('arnold-admin-theme-icons');
	
	if($post_type == 'page'){
		wp_enqueue_style('arnold-admin-gridstack');
	}
	
	wp_enqueue_style('arnold-admin-theme-style');
}
add_action('admin_enqueue_scripts','arnold_theme_options_enqueue_scripts', 10);



//theme post type support
function arnold_theme_support(){
	add_theme_support('title-tag');
	
	add_post_type_support('post', array('excerpt', 'comments'));
	add_post_type_support('page', 'excerpt');
	
	add_theme_support('post-formats', array('gallery', 'link', 'image', 'quote', 'audio', 'video'));
	add_theme_support('automatic-feed-links');
	add_theme_support('custom-header');
	add_theme_support('custom-background');
	add_theme_support('post-thumbnails');

	add_image_size('arnold-standard-thumb', 650, 9999);
	add_image_size('arnold-standard-thumb-medium', 1000, 9999);
	add_image_size('arnold-standard-thumb-big', 2000, 9999);
	add_image_size('arnold-thumb-169-normal', 800, 450, true);
	add_image_size('arnold-thumb-11-normal', 650, 650, true);
	add_image_size('arnold-thumb-43-big', 2000, 1500, true);
	add_image_size('arnold-thumb-43-medium', 1000, 750, true); 
	
	if(!isset($content_width)) $content_width = 1220;
}
add_action('init','arnold_theme_support');

//theme activated redirect
function arnold_theme_init($old_theme){
  global $pagenow;

  if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
    wp_redirect( admin_url( 'themes.php?page=theme-option' ) );
    exit;
  }
}
add_action('after_switch_theme', 'arnold_theme_init');

//require theme register
require_once get_template_directory() . '/functions/theme/theme-register.php';

//require theme options
require_once get_template_directory() . '/functions/theme/theme-options.php';

//require theme post
require_once get_template_directory() . '/functions/theme/theme-post.php';

//require theme widget
require_once get_template_directory() . '/functions/theme/theme-widget.php';

//require theme ajax
require_once get_template_directory() . '/functions/theme/theme-ajax.php';

//require theme import
require_once get_template_directory() . '/functions/theme/theme-import.php';

//require theme export
require_once get_template_directory() . '/functions/theme/theme-export.php';

//require theme customize
require_once get_template_directory() . '/functions/theme/customize/customize-options.php';

//Load wordpress importer
if(!function_exists('wordpress_importer_init')){
	require_once get_template_directory() . '/functions/theme/wordpress-importer/wordpress-importer.php';
}

//require theme nav menu
require_once get_template_directory() . '/functions/theme/theme-nav-menu.php';

?>