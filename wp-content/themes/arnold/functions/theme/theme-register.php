<?php
//register script
function arnold_theme_register_script(){
	$arnold_theme_register_script = array(
		array(
			'handle'    => 'arnold-admin-bootstrap',
			'src'       => arnold_THEME. '/js/bootstrap.min.js',
			'deps'      => array('jquery'),
			'ver'       => '3.0.2',
			'in_footer' => true,
		),
		array(
			'handle'    => 'arnold-admin-bootstrap-switch',
			'src'       => arnold_THEME. '/js/bootstrap-switch.min.js',
			'deps'      => array('jquery'),
			'ver'       => '1.8',
			'in_footer' => true,
		),
		array(
			'handle'    => 'arnold-admin-minicolors',
			'src'       => arnold_THEME. '/js/jquery.minicolors.min.js',
			'deps'      => array('jquery'),
			'ver'       => '2.1',
			'in_footer' => true,
		),
		array(
			'handle'    => 'arnold-admin-icheck',
			'src'       => arnold_THEME. '/js/jquery.icheck.min.js',
			'deps'      => array('jquery'),
			'ver'       => '0.9.1',
			'in_footer' => true,
		),
		array(
			'handle'    => 'arnold-admin-isotope',
			'src'       => arnold_THEME. '/js/jquery.isotope.min.js',
			'deps'      => array('jquery'),
			'ver'       => '1.5.25',
			'in_footer' => true,
		),
		array(
			'handle'    => 'arnold-admin-bootstrap-datetimepicker',
			'src'       => arnold_THEME. '/js/bootstrap-datetimepicker.js',
			'deps'      => array('jquery'),
			'ver'       => '0.0.1',
			'in_footer' => true,
		),
		array(
			'handle'    => 'arnold-admin-gridstack',
			'src'       => arnold_THEME. '/js/gridstack.min.js',
			'deps'      => array('jquery'),
			'ver'       => '0.3.0',
			'in_footer' => true,
		),
		array(
			'handle'    => 'arnold-admin-gridstack-jquery-ui',
			'src'       => arnold_THEME. '/js/gridstack.jQueryUI.min.js',
			'deps'      => array('jquery'),
			'ver'       => '0.3.0',
			'in_footer' => true,
		),
		array(
			'handle'    => 'arnold-admin-theme-script',
			'src'       => arnold_THEME. '/js/theme.js',
			'deps'      => array('jquery'),
			'ver'       => '0.0.1',
			'in_footer' => false,
		),
		array(
			'handle'    => 'arnold-admin-customize-controls',
			'src'       => arnold_THEME. '/js/customize-controls.js',
			'deps'      => array('jquery'),
			'ver'       => '0.0.1',
			'in_footer' => true,
		)
	);
	$arnold_theme_register_script = apply_filters('arnold_theme_register_script', $arnold_theme_register_script);
	
	foreach($arnold_theme_register_script as $script){
		wp_register_script($script['handle'], $script['src'], $script['deps'], $script['ver'], $script['in_footer'] ); 
	}
}
add_action('init', 'arnold_theme_register_script');

//register style
function arnold_theme_register_style(){
	$arnold_theme_register_style = array(
		array(
			'handle' => 'arnold-admin-bootstrap',
			'src'    => arnold_THEME. '/css/bootstrap.css',
			'deps'   => array(),
			'ver'    => '3.0.2',
			'media'  => 'screen',
		),
		array(
			'handle' => 'arnold-admin-bootstrap-theme',
			'src'    => arnold_THEME. '/css/bootstrap-theme.css',
			'deps'   => array('arnold-admin-bootstrap'),
			'ver'    => '3.0.2',
			'media'  => 'screen',
		),
		array(
			'handle' => 'font-awesome',
			'src'    => arnold_THEME. '/css/font-awesome.min.css',
			'deps'   => array(),
			'ver'    => '4.6.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'arnold-admin-bootstrap-switch',
			'src'    => arnold_THEME. '/css/bootstrap-switch.css',
			'deps'   => array(),
			'ver'    => '1.8',
			'media'  => 'screen',
		),
		array(
			'handle' => 'arnold-pb-bootstrap-datetimepicker',
			'src'    => arnold_THEME. '/css/bootstrap-datetimepicker.min.css',
			'deps'   => array(),
			'ver'    => '0.0.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'arnold-admin-minicolors',
			'src'    => arnold_THEME. '/css/jquery.minicolors.css',
			'deps'   => array(),
			'ver'    => '2.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'arnold-admin-theme-icons',
			'src'    => arnold_THEME. '/css/icons.css',
			'deps'   => array(),
			'ver'    => '0.0.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'arnold-admin-icheck',
			'src'    => arnold_THEME. '/css/icheck/all.css',
			'deps'   => array(),
			'ver'    => '0.9.1',
			'media'  => 'screen',
		),
		array(
			'handle' => 'arnold-admin-gridstack',
			'src'    => arnold_THEME. '/css/gridstack.min.css',
			'deps'   => array(),
			'ver'    => '0.3.0',
			'media'  => 'screen',
		),
		array(
			'handle' => 'arnold-admin-theme-style',
			'src'    => arnold_THEME. '/css/theme.css',
			'deps'   => array(),
			'ver'    => '0.0.1',
			'media'  => 'screen',
		)
	);
	$arnold_theme_register_style = apply_filters('arnold_theme_register_style', $arnold_theme_register_style);
	
	foreach($arnold_theme_register_style as $style){
		wp_register_style($style['handle'], $style['src'], $style['deps'], $style['ver'], $style['media'] );
	}
}
add_action('init', 'arnold_theme_register_style');

//theme register google fonts
function arnold_theme_register_google_fonts(){
	$json = get_option('ux_theme_googlefont');
	if($json){
		$fonts_object = json_decode($json);
		if($fonts_object && is_object($fonts_object)){
			if($fonts_object->items && is_array($fonts_object->items)){
				$fonts = $fonts_object->items;
				foreach($fonts as $item){
					$family_val = str_replace(' ', '+', $item->family);
					$separator = '%2C';
					$output = '';
					if(count($item->variants)){
						foreach($item->variants as $num => $variant){
							$output .= $variant . $separator;
						}
					}
					wp_register_style('google-fonts-' . $family_val, 'http://fonts.googleapis.com/css?family=' . $family_val . ':' . trim($output, $separator));
				}
			}
		}
	}
}
add_filter('init', 'arnold_theme_register_google_fonts');

//register post type
function arnold_theme_register_post_type(){
	$arnold_theme_register_post_type = apply_filters('ux_theme_register_post_type', array());
	
	return $arnold_theme_register_post_type;
}
add_action('init', 'arnold_theme_register_post_type');

//register sidebar
function arnold_theme_register_sidebar($key){
	//sidebars
	$sidebars = array(
		array('value' => 'sidebar_1', 'title' => esc_html__('Sidebar 1 for Post/Page','arnold')),
		array('value' => 'sidebar_2', 'title' => esc_html__('Sidebar 2 for Post/Page','arnold')),
		array('value' => 'sidebar_3', 'title' => esc_html__('Sidebar 3 for Post/Page','arnold')),
		array('value' => 'sidebar_4', 'title' => esc_html__('Sidebar 4 for Post/Page','arnold')),
		array('value' => 'sidebar_5', 'title' => esc_html__('Sidebar 5 for Post/Page','arnold')),
		array('value' => 'sidebar_6', 'title' => esc_html__('Sidebar 6 for Post/Page','arnold')),
		array('value' => 'sidebar_7', 'title' => esc_html__('Sidebar 7 for Post/Page','arnold')),
		array('value' => 'sidebar_8', 'title' => esc_html__('Sidebar 8 for Post/Page','arnold')),
		array('value' => 'sidebar_9', 'title' => esc_html__('Sidebar 9 for Post/Page','arnold')),
		array('value' => 'sidebar_10', 'title' => esc_html__('Sidebar 10 for Post/Page','arnold'))
	);
	
	foreach($sidebars as $num => $sidebar){
		register_sidebar(array(
			'name' => $sidebar['title'],
			'id' => $sidebar['value'],
			'description'   => esc_html__('widgets for sidebar','arnold'),
			'before_title' => '<h3 class="widget-title"><span class="widget-title-inn">',
			'after_title' => '</span></h3>',
			'before_widget' => '<li class="widget-container %2$s">',
			'after_widget' => '</li>',
			'class' => ''
		));
	}
	
	//footer widget
	$footer_widget = array(
		array('value' => 'footer_widget_1', 'title' => __('Footer 1 for Post/Page','arnold')),
		array('value' => 'footer_widget_2', 'title' => __('Footer 2 for Post/Page','arnold')),
		array('value' => 'footer_widget_3', 'title' => __('Footer 3 for Post/Page','arnold')),
		array('value' => 'footer_widget_4', 'title' => __('Footer 4 for Post/Page','arnold')),
		array('value' => 'footer_widget_5', 'title' => __('Footer 5 for Post/Page','arnold'))
	);
	
	foreach($footer_widget as $num => $sidebar){
		register_sidebar(array(
			'name' => $sidebar['title'],
			'id' => $sidebar['value'],
			'description'   => __('No more than 3 widgets could be shown','arnold'),
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
			'before_widget' => '<section class="widget_footer_unit widget-container col-md-4 col-sm-4 %2$s">',
			'after_widget' => '</section>',
			'class' => ''
		));
	}
	
	switch($key){
		case 'sidebars':        return $sidebars; break;
		case 'footer_widget':   return $footer_widget; break;
	}
	
	
}
add_action('widgets_init', 'arnold_theme_register_sidebar');

function arnold_theme_register_nav_menu(){
	register_nav_menus(array(
		'primary' => 'Primary Menu'
	));
}
add_action('init', 'arnold_theme_register_nav_menu');
?>