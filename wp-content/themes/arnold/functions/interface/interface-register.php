<?php
//register script
function arnold_theme_interface_register_script($script){
	
	$script['jquery-jplayer-min'] = array(
		'handle'    => 'jquery-jplayer-min',
		'src'       => arnold_LOCAL_URL. '/js/jquery.jplayer.min.js',
		'deps'      => array('jquery'),
		'ver'       => '2.2.0',
		'in_footer' => true
	);
	
	$script['arnold-interface-googlemap'] = array(
		'handle'    => 'arnold-interface-googlemap',
		'src'       => 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false',
		'deps'      => array('jquery'),
		'ver'       => '3.0.0',
		'in_footer' => false
	);
	
	$script['arnold-interface-jquery-ui'] = array(
		'handle'    => 'arnold-interface-jquery-ui',
		'src'       => arnold_LOCAL_URL. '/js/jquery-ui.min.js',
		'deps'      => array('jquery'),
		'ver'       => '1.11.4',
		'in_footer' => true,
	);
	
	$script['arnold-interface-main'] = array(
		'handle'    => 'arnold-interface-main',
		'src'       => arnold_LOCAL_URL. '/js/main.js',
		'deps'      => array('jquery'),
		'ver'       => '1.0.0',
		'in_footer' => true
	);

	$script['arnold-interface-gridstack'] = array(
		'handle'    => 'arnold-interface-gridstack',
		'src'       => arnold_LOCAL_URL. '/js/gridstack.min.js',
		'deps'      => array('jquery'),
		'ver'       => '1.0.0',
		'in_footer' => true
	);
	
	$script['arnold-interface-theme'] = array(
		'handle'    => 'arnold-interface-theme',
		'src'       => arnold_LOCAL_URL. '/js/custom.theme.js',
		'deps'      => array('jquery'),
		'ver'       => '1.0.0',
		'in_footer' => true
	);
	
	
	return $script;
}
add_filter('arnold_theme_register_script', 'arnold_theme_interface_register_script');

//register style
function arnold_theme_interface_register_style($style){
	$style['bootstrap'] = array(
		'handle' => 'bootstrap',
		'src'    => arnold_LOCAL_URL. '/styles/bootstrap.css',
		'deps'   => array(),
		'ver'    => '2.0.0',
		'media'  => 'screen'
	);
	
	$style['font-awesome'] = array(
		'handle' => 'font-awesome',
		'src'    => arnold_LOCAL_URL. '/functions/theme/css/font-awesome.min.css',
		'deps'   => array(),
		'ver'    => '4.6.1',
		'media'  => 'screen'
	);
	
	$style['owl-carousel'] = array(
		'handle' => 'owl-carousel',
		'src'    => arnold_LOCAL_URL. '/styles/owl.carousel.css',
		'deps'   => array(),
		'ver'    => '0.0.1',
		'media'  => 'screen'
	);

	$style['arnold-interface-style'] = array(
		'handle' => 'arnold-interface-style',
		'src'    => arnold_LOCAL_URL. '/style.css',
		'deps'   => array(),
		'ver'    => '1.0.0',
		'media'  => 'screen'
	);

	$style['google-fonts-Poppins'] = array(
		'handle' => 'google-fonts-Poppins',
		'src'    => 'https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700',
		'deps'   => array(),
		'ver'    => '1.0.0',
		'media'  => 'screen'
	);

	$style['google-fonts-satisfy'] = array(
		'handle' => 'google-fonts-satisfy',
		'src'    => 'https://fonts.googleapis.com/css?family=Satisfy',
		'deps'   => array(),
		'ver'    => '1.0.0',
		'media'  => 'screen'
	);

	$style['arnold-googlefont-lato'] = array(
		'handle' => 'arnold-googlefont-lato',
		'src'    => 'http://fonts.googleapis.com/css?family=Lato',
		'deps'   => array(),
		'ver'    => '1.0.0',
		'media'  => 'screen'
	);

	$style['arnold-interface-style-ie'] = array(
		'handle' => 'arnold-interface-style-ie',
		'src'    => arnold_LOCAL_URL. '/styles/ie.css',
		'deps'   => array(),
		'ver'    => '1.0.0',
		'media'  => 'screen'
	);
	
	$style['photoswipe'] = array(
		'handle' => 'photoswipe',
		'src'    => arnold_LOCAL_URL. '/styles/photoswipe.css',
		'deps'   => array(),
		'ver'    => '4.0.5',
		'media'  => 'screen',
	);
	
	$style['arnold-interface-gridstack'] =array(
		'handle' => 'arnold-interface-gridstack',
		'src'    => arnold_THEME. '/css/gridstack.min.css',
		'deps'   => array(),
		'ver'    => '0.3.0',
		'media'  => 'screen',
	);
	
	$style['photoswipe-default-skin'] = array(
		'handle' => 'photoswipe-default-skin',
		'src'    => arnold_LOCAL_URL. '/styles/skin/photoswipe/default/default-skin.css',
		'deps'   => array('photoswipe'),
		'ver'    => '4.0.5',
		'media'  => 'screen',
	);
	
	
	return $style;
}
add_filter('arnold_theme_register_style', 'arnold_theme_interface_register_style');
?>