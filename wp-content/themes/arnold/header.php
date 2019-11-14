<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    
    <?php //** Do Hook Web Head
	/**
	 * @hooked  arnold_interface_webhead_viewport - 10
	 * @hooked  arnold_interface_webhead_favicon - 15
	 */
	do_action('arnold_interface_webhead'); ?>
    
    <?php wp_head(); ?>
  </head>
  
  <body <?php arnold_interface_body_class(); ?>>
      
      <?php //** Do Hook Wrap before
	  /**
	   * @hooked  arnold_interface_page_loading - 15
	   * @hooked  arnold_interface_jplayer - 20
	   * @hooked  arnold_interface_wrap_outer_before - 25
	   */
	  do_action('arnold_interface_wrap_before'); ?>
      
      <?php //** Do Hook header
	  /**
	   * @hooked  arnold_interface_header - 10
	   */
	  do_action('arnold_interface_header'); 
	  //** Do Hook menu_hidden_panel
	  /**
	   * @hooked  arnold_interface_menu_hidden_panel - 10
	   */
	  do_action('arnold_interface_menu_hidden_panel'); ?>
		
	  <?php //** Do Hook Content before
      /**
       * @hooked  arnold_interface_content_before - 5
	   * @hooked  arnold_interface_single_feature_image - 10
	   * @hooked  arnold_interface_archive_titlewrap - 25
       */
      do_action('arnold_interface_content_before'); ?>