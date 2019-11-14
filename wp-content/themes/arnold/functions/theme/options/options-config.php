<?php
//theme icons
function arnold_theme_icons_fields(){

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path =  get_template_directory() . '/functions/theme/css/font-awesome.min.css';
if( file_exists( $fontawesome_path ) ) {
	$method = '';
	$url = wp_nonce_url('themes.php?page=theme-option');
	if (false === ($creds = request_filesystem_credentials($url, $method, false, false, false) ) ) {
		return true;
	}
	
	if ( ! WP_Filesystem($creds) ) {
		request_filesystem_credentials($url, $method, true, false, false);
		return true;
	}
	
	global $wp_filesystem;
	@$subject = $wp_filesystem->get_contents($fontawesome_path);
}


preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	array_push($icons, 'fa ' . $match[1]);
}

return $icons;


}

function arnold_theme_get_categories_fields($type=false){
	$output = array();
	
	$categories = get_categories(array(
		'hide_empty' => 0,
		'orderby' => 'id'
	));
	if($categories){
		foreach($categories as $category){
			array_push($output, array(
				'title' => $category->name,
				'value' => $category->term_id
			));
		}
	}else{
		$output = false;
	}
	
	return $output;
}

function arnold_wp_get_nav_menus(){
	$output = array();
	$menus = wp_get_nav_menus();
	
	array_push($output, array(
		'title' => esc_html__('Select menu', 'arnold'),
		'value' => 0
	));
	
	if($menus){
		foreach($menus as $menu){
			array_push($output, array(
				'title' => $menu->name,
				'value' => $menu->term_id
			));
		}
	}
	return $output;
}

//theme color
function arnold_theme_color(){
	$theme_color = array(
		array('id' => 'color1', 'value' => 'theme-color-1', 'rgb' => '#F9885C'),
		array('id' => 'color2', 'value' => 'theme-color-2', 'rgb' => '#BD9DD1'),
		array('id' => 'color3', 'value' => 'theme-color-3', 'rgb' => '#F1A1C3'),
		array('id' => 'color4', 'value' => 'theme-color-4', 'rgb' => '#92C3E3'),
		array('id' => 'color5', 'value' => 'theme-color-5', 'rgb' => '#5B6A81'),
		array('id' => 'color6', 'value' => 'theme-color-6', 'rgb' => '#B8B69A'),
		array('id' => 'color7', 'value' => 'theme-color-7', 'rgb' => '#69CE9B'),
		array('id' => 'color8', 'value' => 'theme-color-8', 'rgb' => '#FFD02E'),
		array('id' => 'color9', 'value' => 'theme-color-9', 'rgb' => '#C6A584'),
		array('id' => 'color10', 'value' => 'theme-color-10', 'rgb' => '#313139')
	);	

	//color 1-10
	for($color_num=1;$color_num<=10;$color_num++){
		$featured_color = arnold_get_option('theme_option_featured_color_' .$color_num);
		if($featured_color){
			$i = $color_num - 1;
			$theme_color[$i]['rgb'] = $featured_color;
		}
	}
	
	return $theme_color;
}

//theme config social networks
function arnold_theme_social_networks(){
	$theme_config_social_networks = array(
		array(
			'name' => esc_html__('Facebook','arnold'),
			'icon' => 'fa fa-facebook-square',
			'icon2' => 'fa fa-facebook-square',
			'slug' => 'facebook',
			'dec'  => esc_html__('Visit Facebook page','arnold')
		),
		array(
			'name' => esc_html__('Twitter','arnold'),
			'icon' => 'fa fa-twitter-square',
			'icon2' => 'fa fa-twitter-square',
			'slug' => 'twitter',
			'dec'  => esc_html__('Visit Twitter page','arnold')
		),
		array(
			'name' => esc_html__('Google+','arnold'),
			'icon' => 'fa fa-google-plus-square',
			'icon2' => 'fa fa-google-plus-square',
			'slug' => 'googleplus',
			'dec'  => esc_html__('Visit Google Plus page','arnold')
		),
		array(
			'name' => esc_html__('Youtube','arnold'),
			'icon' => 'fa fa-youtube-square',
			'icon2' => 'fa fa-youtube-square',
			'slug' => 'youtube',
			'dec'  => esc_html__('Visit Youtube page','arnold')
		),
		array(
			'name' => esc_html__('Vimeo','arnold'),
			'icon' => 'fa fa-vimeo-square',
			'icon2' => 'fa fa-vimeo-square',
			'slug' => 'vimeo',
			'dec'  => esc_html__('Visit Vimeo page','arnold')
		),
		array(
			'name' => esc_html__('Tumblr','arnold'),
			'icon' => 'fa fa-tumblr-square',
			'icon2' => 'fa fa-tumblr-square',
			'slug' => 'tumblr',
			'dec'  => esc_html__('Visit Tumblr page','arnold')
		),
		array(
			'name' => esc_html__('RSS','arnold'),
			'icon' => 'fa fa-rss-square',
			'icon2' => 'fa fa-rss-square',
			'slug' => 'rss',
			'dec'  => esc_html__('Visit Rss','arnold')
		),
		array(
			'name' => esc_html__('Pinterest','arnold'),
			'icon' => 'fa fa-pinterest-square',
			'icon2' => 'fa fa-pinterest-square',
			'slug' => 'pinterest',
			'dec'  => esc_html__('Visit Pinterest page','arnold')
		),
		array(
			'name' => esc_html__('Linkedin','arnold'),
			'icon' => 'fa fa-linkedin-square',
			'icon2' => 'fa fa-linkedin-square',
			'slug' => 'linkedin',
			'dec'  => esc_html__('Visit Linkedin page','arnold')
		),
		array(
			'name' => esc_html__('Instagram','arnold'),
			'icon' => 'fa fa-instagram',
			'icon2' => 'fa fa-instagram',
			'slug' => 'instagram',
			'dec'  => esc_html__('Visit Instagram page','arnold')
		),
		array(
			'name' => esc_html__('Github','arnold'),
			'icon' => 'fa fa-github-square',
			'icon2' => 'fa fa-github-square',
			'slug' => 'github',
			'dec'  => esc_html__('Visit Github page','arnold')
		),
		array(
			'name' => esc_html__('Xing','arnold'),
			'icon' => 'fa fa-xing-square',
			'icon2' => 'fa fa-xing-square',
			'slug' => 'xing',
			'dec'  => esc_html__('Visit Xing page','arnold')
		),
		array(
			'name' => esc_html__('Flickr','arnold'),
			'icon' => 'fa fa-flickr',
			'icon2' => 'fa fa-flickr',
			'slug' => 'flickr',
			'dec'  => esc_html__('Visit Flickr page','arnold')
		),
		array(
			'name' => esc_html__('VK','arnold'),
			'icon' => 'fa fa-vk square-radiu',
			'icon2' => 'fa fa-vk square-radiu',
			'slug' => 'vk',
			'dec'  => esc_html__('Visit VK page','arnold')
		),
		array(
			'name' => esc_html__('Weibo','arnold'),
			'icon' => 'fa fa-weibo square-radiu',
			'icon2' => 'fa fa-weibo square-radiu',
			'slug' => 'weibo',
			'dec'  => esc_html__('Visit Weibo page','arnold')
		),
		array(
			'name' => esc_html__('Renren','arnold'),
			'icon' => 'fa fa-renren square-radiu',
			'icon2' => 'fa fa-renren square-radiu',
			'slug' => 'renren',
			'dec'  => esc_html__('Visit Renren page','arnold')
		),
		array(
			'name' => esc_html__('Bitbucket','arnold'),
			'icon' => 'fa fa-bitbucket-square',
			'icon2' => 'fa fa-bitbucket-square',
			'slug' => 'bitbucket',
			'dec'  => esc_html__('Visit Bitbucket page','arnold')
		),
		array(
			'name' => esc_html__('Foursquare','arnold'),
			'icon' => 'fa fa-foursquare square-radiu',
			'icon2' => 'fa fa-foursquare square-radiu',
			'slug' => 'foursquare',
			'dec'  => esc_html__('Visit Foursquare page','arnold')
		),
		array(
			'name' => esc_html__('Skype','arnold'),
			'icon' => 'fa fa-skype square-radiu',
			'icon2' => 'fa fa-skype square-radiu',
			'slug' => 'skype',
			'dec'  => esc_html__('Skype','arnold')
		),
		array(
			'name' => esc_html__('Dribbble','arnold'),
			'icon' => 'fa fa-dribbble square-radiu',
			'icon2' => 'fa fa-dribbble square-radiu',
			'slug' => 'dribbble',
			'dec'  => esc_html__('Visit Dribbble page','arnold')
		)
	);	
	
	return $theme_config_social_networks;
	
}

//theme config fonts size
function arnold_theme_options_fonts_size(){
	$theme_config_fonts_size = array('Font Size','8px','10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '22px', '24px', '26px', '28px', '30px', '32px','34px', '36px', '38px', '40px', '42px','44px','46px', '50px', '52px','56px', '60px', '62px','66px', '70px','72px','76px', '80px', '82px','86px', '90px','92px', '98px');
	
	return $theme_config_fonts_size;
}

//theme config fonts style
function arnold_theme_options_fonts_style(){
	$theme_config_fonts_style = array(
		array('title' => 'Select', 'value' => ''),
		array('title' => 'Light', 'value' => 'light'),
		array('title' => 'Normal', 'value' => 'regular'),
		array('title' => 'Bold', 'value' => 'bold'),
		array('title' => 'Italic', 'value' => 'italic')
	);
	
	return $theme_config_fonts_style;
}

//theme config color scheme
function arnold_theme_options_color_scheme(){
	
	$color_scheme = array(
		'scheme-1' => array(
			array('name' => 'theme_main_color', 			  'value' => '#5179FC'),
			array('name' => 'second_auxiliary_color', 		  'value' => '#F8F8F8'),
			array('name' => 'page_post_bg_color', 			  'value' => '#FFFFFF'),
			array('name' => 'theme_border_color', 			  'value' => '#48484d'),
			array('name' => 'logo_text_color', 				  'value' => '#313139'),
			array('name' => 'page_from_top_logo_text_color',  'value' => '#FFFFFF'),
			array('name' => 'expanded_panel_logo_text_color', 'value' => '#FFFFFF'),
			array('name' => 'logo_text_color_floating', 	  'value' => '#313139'), 
			array('name' => 'header_menu_item_text_color', 	  'value' => '#313139'),
			array('name' => 'top_menu_bar_bg_color', 	      'value' => '#FFFFFF'),
			array('name' => 'header_menu_transparent_color',  'value' => '#FFFFFF'),
			array('name' => 'menu_item_text_color',           'value' => '#FFFFFF'),
			array('name' => 'expanded_panel_bg_color', 		  'value' => '#313139'),
			array('name' => 'menu_item_text_mouseover_color', 'value' => '#5179FC'),
			array('name' => 'menu_item_text_active_color',    'value' => '#FFFFFF'),
			array('name' => 'heading_color', 				  'value' => '#313139'),
			array('name' => 'content_text_color', 			  'value' => '#414145'),
			array('name' => 'auxiliary_content_color', 		  'value' => '#ADADAD'),
			array('name' => 'selected_text_bg_color', 		  'value' => '#DBD7D2'),
			array('name' => 'sidebar_widget_title_color',     'value' => '#313139'),
			array('name' => 'sidebar_content_color', 	      'value' => '#606066'),
			array('name' => 'footer_text_color', 			  'value' => '#28282E'),
			array('name' => 'footer_bg_color', 				  'value' => '#FFFFFF')
		) 
	);
	return $color_scheme;
	
}

//theme config select fields
function arnold_theme_options_config_select_fields(){
	$theme_config_select_fields = array(
		'theme_option_posts_showmeta' => array(
		array('title' => esc_html__('Date','arnold'),                                   'value' => 'date'),
		array('title' => esc_html__('Length','arnold'),                                 'value' => 'length'),
		array('title' => esc_html__('Category','arnold'),                               'value' => 'category'), 
		array('title' => esc_html__('Author','arnold'),                                 'value' => 'author'),
		array('title' => esc_html__('Comments','arnold'),                               'value' => 'comments')
		),
		
		'theme_meta_demo_site' => array(  
		array('title' => esc_html__('Demo 1','arnold'),                           'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/default-demo.xml'),
		array('title' => esc_html__('Demo 2','arnold'),                           'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo2.xml'),
		array('title' => esc_html__('Demo 3','arnold'),                           'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo3.xml'),
		array('title' => esc_html__('Demo 4','arnold'),                           'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo4.xml'),
		array('title' => esc_html__('Demo 5','arnold'),                           'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo5.xml'),
		array('title' => esc_html__('Demo 6','arnold'),                           'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo6.xml'),
		array('title' => esc_html__('Demo 7','arnold'),                           'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo7.xml'),
		array('title' => esc_html__('Demo 8','arnold'),                           'value' => '../wp-content/themes/'.get_stylesheet().'/functions/theme/demo8.xml')
		),
		
		'theme_option_footer_widget_for_posts'                                        => arnold_theme_register_sidebar('footer_widget'),
		'theme_option_hide_category_on_post_page'                                     => arnold_theme_get_categories_fields(),
		
		'theme_option_header_layout' => array(
		array('title' => esc_html__('Horizon Menu Right','arnold'),  					'value' => 'horizon-menu-right'),
		array('title' => esc_html__('Horizon Menu left','arnold'),  					'value' => 'horizon-menu-left'),
		array('title' => esc_html__('Columned Menu on Right','arnold'),                 'value' => 'columned-menu-right'),
		array('title' => esc_html__('Show Menu Icon','arnold'),                         'value' => 'show-menu-icon'),
		array('title' => esc_html__('Menu Icon - Popup2','arnold'),                     'value' => 'menu-icon-popup2'),
		array('title' => esc_html__('Menu Icon - Horizon Menu','arnold'),               'value' => 'menu-icon-horizon-menu'),
		array('title' => esc_html__('Logo Centered','arnold'),               			'value' => 'logo-centered')
		),

		'theme_option_header_width' => array( 
		array('title' => esc_html__('Fluid','arnold'),                                  'value' => 'fluid'),
		array('title' => esc_html__('Same As Main Container','arnold'),                 'value' => 'fixed') 
		),

		'theme_option_menu_hover' => array( 
		array('title' => esc_html__('Cross Line','arnold'),                        'value' => 'menu_hover_cross_line'),
		array('title' => esc_html__('Highlight Color','arnold'),                 		 'value' => 'menu_hover_highlight') 
		),
		
		'theme_option_footer_elements' => array(
		array('title' => esc_html__('Logo','arnold'),                                   'value' => 'logo'),
		array('title' => esc_html__('Copyright','arnold'),                               'value' => 'copyright'),
		array('title' => esc_html__('Menu','arnold'),                                   'value' => 'menu'),
		array('title' => esc_html__('Text','arnold'),                                   'value' => 'text'),
		array('title' => esc_html__('Social Links','arnold'),                           'value' => 'social')
		),
		
		'theme_option_footer_elements_menu'                          => arnold_wp_get_nav_menus(),
		
		'theme_option_footer_elements_align' => array(
		array('title' => esc_html__('Horizon','arnold'),                                   'value' => 'horizon'),
		array('title' => esc_html__('Vertical','arnold'),                                   'value' => 'vertical')
		),

		'theme_option_color_skin_lightbox' => array(
		array('title' => __('Dark','arnold'),                'value' => 'pswp-dark-skin'),
		array('title' => __('Light','arnold'),               'value' => 'pswp-light-skin')
		),

		'theme_option_custom_logo_choose' => array(
		array('title' => __('Dark','arnold'),                'value' => 'dark-logo'),
		array('title' => __('Light','arnold'),               'value' => 'light-logo')
		),

		'theme_option_main_width' => array(
		array('title' => __('1170','arnold'),                'value' => '1170'),
		array('title' => __('1070','arnold'),                'value' => '1070'),
		array('title' => __('970','arnold'),                 'value' => '970')
		),

		'theme_option_share_buttons' => array(
		array('title' => esc_html__('Facebook','arnold'),                     'value' => 'facebook'),
		array('title' => esc_html__('Twitter','arnold'),                      'value' => 'twitter'),
		array('title' => esc_html__('Google Plus','arnold'),                  'value' => 'google-plus'),
		array('title' => esc_html__('Pinterest','arnold'),                    'value' => 'pinterest'),
		array('title' => esc_html__('Digg','arnold'),                    	 'value' => 'digg'),
		array('title' => esc_html__('Reddit','arnold'),                    	 'value' => 'reddit'),
		array('title' => esc_html__('Linkedin','arnold'),                     'value' => 'linkedin'),
		array('title' => esc_html__('Stumbleupon','arnold'),                   'value' => 'stumbleupon'),
		array('title' => esc_html__('Tumblr','arnold'),                    	 'value' => 'tumblr'),
		array('title' => esc_html__('Mail','arnold'),                    	 'value' => 'mail')
		)
		
	);
	
	$theme_config_select_fields = apply_filters('theme_config_select_fields', $theme_config_select_fields);
	return $theme_config_select_fields;
}

//theme config fields
function arnold_theme_options_config_fields(){
	$theme_config_fields = array(
		array(
			'id'      => 'options-theme',
			'name'    => esc_html__('Theme Options','arnold'),
			'section' => array(
				
				array(/* Import Demo Data */
					'id'    => 'import-export',
					'title' => esc_html__('Import Demo Data','arnold'),
					'item'  => array(
						array('description' => esc_html__('if you are new to WordPress or have problems creating posts or pages that look like the theme demo, you could import dummy posts and pages here that will definitely help to understand how those tasks are done','arnold'),
							  'button'      => array('title'   => esc_html__('Import Demo Data','arnold'),
													 'loading' => esc_html__('Loading data, don&acute;t close the page please.','arnold'),
													 'type'    => 'import-demo-data',
													 'class'   => 'btn-info',
													 'url'     => admin_url('admin.php?import=wordpress&step=2', 'http')),
							  'notice'      => esc_html__('The demo content will be import including post/pages and sliders, the images in sliders could only be use as placeholder and could not be use in your finally website due to copyright reasons.','arnold'),
							  'type'        => 'button',
							  'name'        => 'theme_option_import_demo'),
								  
						array('type'        => 'select',
							  'description' => '',
							  'name'        => 'theme_meta_demo_site',
							  'col_size'    => 'width: 300px;'),
						
						array('description' => esc_html__('export your current data to a file and save it on your computer','arnold'),
							  'button'      => array('title' => esc_html__('Export Current Data','arnold'),
													 'type'  => 'export-current-data',
													 'class' => 'btn-default',
													 'url'   => admin_url('export.php?download=true')),
							  'type'        => 'button',
							  'name'        => 'theme_option_export_current_data'),
								  
						array('description' => esc_html__('import a data file you have saved','arnold'),
							  'button'      => array('title' => esc_html__('Import My Saved Data','arnold'),
													 'type'  => 'import-mysaved-data',
													 'class' => 'btn-default',
													 'url'   => admin_url('admin.php?import=wordpress')),
							  'type'        => 'button',
							  'name'        => 'theme_option_import_mysaved_data'))),
							  
							  
				array(/* Generate New Thumbs for This Theme */
					'id'   => 'generate-thumbs',
					'item' => array(
						array('title'       => esc_html__('Generate New Thumbs for This Theme','arnold'),
							  'description' => esc_html__('if you have many posts and had assigned some Featured Image for them before using this theme, this button could help you adapt these feature images to appropriate size for this theme','arnold'),
							  'button'      => array('title'   => esc_html__('Generate New Thumbnails','arnold'),
													 'loading' => esc_html__('Processing, don&acute;t close the page please.','arnold'),
													 'type'    => 'generate-thumbs',
													 'class'   => 'btn-default'),
							  'type'        => 'button',
							  'name'        => 'theme_option_generate_thumbs')))
			)
		),
		
		array(
			'id'      => 'options-general',
			'name'    => esc_html__('General Settings','arnold'),
			'section' => array(    

				array(/* Logo */
					'id'    => 'logo',
					'title' => esc_html__('Logo','arnold'),
					'item'  => array(        
						
						// Enable Plain Text Logo
						array('title'       => esc_html__('Enable Plain Text Logo','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_text_logo',
							  'default'     => 'false'),

						// Logo Text
						array('title'       => esc_html__('Logo Text','arnold'),
							  'type'        => 'text',
							  'name'        => 'theme_option_text_logo',
							  'description' => '',
							  'default'     => '',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'true')),

						// Costom Logo
						array('title'       => esc_html__('Dark Custom Logo','arnold'),
							  'description' => esc_html__('the container for custom logo is 120px(width) * 120px(hight) for "Menu Bar on Side" layout,  240px(width) * 100px(hight) for "Menu Bar on Head" layout, you could upload a double size logo image to meet the needs of retina screens','arnold'),
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_logo',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'false')),

						// Costom Logo for Dark Background
						array('title'       => esc_html__('Light Custom Logo','arnold'),
							  'description' => '',
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_logo_light',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'false')),

						// Custom Logo For Loading Page
						array('title'       => esc_html__('Custom Logo For Loading Page','arnold'),
							  'description' => '',
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_logo_for_loading',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'false')),

						// Costom Footer Logo
						array('title'       => esc_html__('Custom Footer Logo','arnold'),
							  'description' => '',
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_footer_logo',
							  'control'     => array('name'  => 'theme_option_enable_text_logo',
													 'value' => 'false')),
						)),
				
				array(/* Descriptions */
					'id'    => 'descriptions',
					'title' => esc_html__('Descriptions','arnold'),
					'item'  => array(

						// Menu
                        array('title'       => esc_html__('Menu Icon','arnold'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => esc_html__('MENU','arnold'),
                               'name'        => 'theme_option_descriptions_menu'),

                        // Menu
                        array('title'       => esc_html__('Close Menu Icon','arnold'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => esc_html__('CLOSE','arnold'),
                               'name'        => 'theme_option_descriptions_menu_close'),

						// Pagination
                        array('title'       => esc_html__('Load More','arnold'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => esc_html__('LOAD MORE ARTICLES','arnold'),
                               'name'        => 'theme_option_descriptions_pagination'),

                        // Pagination
                        array('title'       => esc_html__('Loading','arnold'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => esc_html__('LOADING...','arnold'),
                               'name'        => 'theme_option_descriptions_pagination_loading'),

						// Leave a Comment
                        array('title'       => esc_html__('Comment Title','arnold'),
                               'description' => esc_html__('Comments in posts','arnold'),
                               'type'        => 'text',
                               'default'     => esc_html__('Leave a Comment','arnold'),
                               'name'        => 'theme_option_descriptions_comment_title'),

						// Your message
                        array('title'       => esc_html__('Comment Box Placeholder','arnold'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => esc_html__('Leave your comment here','arnold'),
                               'name'        => 'theme_option_descriptions_your_message'),

                        // Send
                        array('title'       => esc_html__('Comment Submit Button Name','arnold'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => esc_html__('SEND COMMENT','arnold'),
                               'name'        => 'theme_option_descriptions_comment_submit'),

                        // Search
                        array('title'       => esc_html__('Search','arnold'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => esc_html__('Type and Hit Enter','arnold'),
                               'name'        => 'theme_option_descriptions_search'),

                        // Blog Readmore
                        array('title'       => esc_html__('Readmore in Blog','arnold'),
                               'description' => '',
                               'type'        => 'text',
                               'default'     => esc_html__('READ MORE','arnold'),
                               'name'        => 'theme_option_descriptions_blog_more'),         
						)),
				
				array(/* Copyright */
					'id'    => 'copyright',
					'title' => esc_html__('Copyright','arnold'),
					'item'  => array(
						
						// Copyright Information
						array('title'       => esc_html__('Copyright Information','arnold'),
							  'description' => esc_html__('enter the copyright information, it would be placed on the bottom of the pages','arnold'),
							  'type'        => 'text',
							  'name'        => 'theme_option_copyright',
							  'default'     => 'Copyright Information.'))),
							 
							  
				array(/* Icon */
					'id'    => 'icon',
					'title' => esc_html__('Icon','arnold'),
					'item'  => array(
						
						// Custom Favicon
						array('title'       => esc_html__('Custom Favicon','arnold'),
							  'description' => esc_html__('upload the favicon for your website, it would be shown on the tab of the browser','arnold'),
							  'type'        => 'upload',
							  'name'        => 'theme_option_custom_favicon',
							  'default'     => arnold_LOCAL_URL . '/img/favicon.ico'),
							  
						// Custom Mobile Icon
						array('title'       => esc_html__('Custom Mobile Icon','arnold'),
							  'description' => esc_html__('upload the icon for the shortcuts on mobile devices','arnold'),
							  'type'        => 'upload',
							  'name'        => 'theme_option_mobile_icon',
							  'default'     => arnold_LOCAL_URL . '/img/apple-touch-icon-114x114.png'))),
							
				array(/* Custom CSS */
					'title' => esc_html__('Custom CSS','arnold'),
					'id'    => 'custom-css',
					'title' => esc_html__('Custom CSS','arnold'),
					'item'  => array(
						
						// Please enter your Custom CSS (Optional)
						array('title'       => esc_html__('Please enter your Custom CSS (Optional)','arnold'),
							  'description' => '',
							  'type'        => 'textarea',
							  'name'        => 'theme_option_custom_css')))
			)
		),
		
		array(
			'id'      => 'options-social-networks',
			'name'    => esc_html__('Social Networks','arnold'),
			'section' => array(
				
				array(/* Your Social Media Links */
					'id'    => 'social-media-links',
					'title' => esc_html__('Your Social Media Links','arnold'),
					'item'  => array(
 
															
						// Social Medias
						array('title'       => esc_html__('Social Medias','arnold'),
							  'description' => '',
							  'type'        => 'new-social-medias',
							  'name'        => 'theme_option_show_social_medias'
							  ))),
				array(/* Share Buttons For Post */
					'id'    => 'social-media-buttons',
					'title' => esc_html__('Share Buttons For Post','arnold'),
					'item'  => array(
											 
					    // Enable Share Buttons for Posts
						array('title'       => esc_html__('Enable Share Buttons for Posts','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_share_buttons_for_posts',
							  'default'     => 'true',
							  'bind'        => array(
								  array('type'     => 'checkbox-group',
										'name'     => 'theme_option_share_buttons',
										'position' => 'after',
										'default'  => array('facebook', 'twitter', 'google-plus', 'pinterest'),
										'control'  => array('name'  => 'theme_option_enable_share_buttons_for_posts',
															'value' => 'true'))))
					)
				)
						


			)
		),
		
		array(
			'id'      => 'options-schemes',
			'name'    => esc_html__('Schemes','arnold'),
			'section' => array(
				
				array(/* Color Setting */
					'id'    => 'color-scheme',
					'title' => esc_html__('Color Setting','arnold'),
					'item'  => array(
						
						// Select Color Scheme
						array('title'       => esc_html__('Select a predefined color scheme ','arnold'),
							  'description' => '',
							  'type'        => 'color-scheme',
							  'name'        => 'theme_option_color_scheme'))),
							  
				array(/* Global */
					'id'    => 'color-main',
					'title' => esc_html__('Global','arnold'),
					'item'  => array(
						
						// Highlight Color
						array('title'       => esc_html__('Highlight Color','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_theme_main',
							  'scheme-name' => 'theme_main_color',
							  'default'     => '#5179FC'),
							  
						//** Auxiliary Color
						array('title'       => esc_html__('Auxiliary Color','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_second_auxiliary',
							  'scheme-name' => 'second_auxiliary_color',
							  'default'     => '#F8F8F8'),
							  
						// Page Post Bg Color
						array('title'       => esc_html__('Page/Post Bg Color','arnold'),
							  'description' => esc_html__('background color for the page area','arnold'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_bg_page_post',
							  'scheme-name' => 'page_post_bg_color',
							  'default'     => '#ffffff'),

						// Page Post Bg Color
						array('title'       => esc_html__('Header Bg Color','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_bg_header',
							  'scheme-name' => 'header_bg_color',
							  'default'     => '#ffffff'),

						// Page Post Bg Color
						array('title'       => esc_html__('Page Loader Bg Color','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_bg_page_loader',
							  'scheme-name' => 'page_loader_bg_color',
							  'default'     => '#ffffff'),

						// Selected Text Bg Color
						array('title'       => esc_html__('Selected Text Bg Color','arnold'),
							  'description' => esc_html__('the color for selected text background','arnold'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_selected_text_bg',
							  'scheme-name' => 'selected_text_bg_color',
							  'default'     => '#DBD7D2') 
						)),
                                
				array(/* Logo */
					'id'    => 'color-logo',
					'title' => esc_html__('Plain Text Logo','arnold'),
					'item'  => array(
						
						// Logo Text Color
						array('title'       => esc_html__('Logo Dark','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_logo',
							  'scheme-name' => 'logo_text_color',
							  'default'     => '#313139'),

						//  Logo Text Color Light
						array('title'       => esc_html__('Logo Light','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_logo_text_color_light',
							  'scheme-name' => 'logo_text_color_light',
							  'default'     => '#ffffff'),

						
					)
				),

				array(/* Logo */
					'id'    => 'color-menu',
					'title' => esc_html__('Menu','arnold'),
					'item'  => array(

						// Menu on Header Dark
						array('title'       => esc_html__('Menu on Header Dark','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_menu_icon_dark',
							  'scheme-name' => 'menu_icon_dark',
							  'default'     => '#313139'),

						// Menu on Header Light
						array('title'       => esc_html__('Menu on Header Light','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_menu_icon_light',
							  'scheme-name' => 'menu_icon_light',
							  'default'     => '#ffffff')

					)
				),
							  
				array(/* Posts & Pages */
					'id'    => 'color-post-page',
					'title' => esc_html__('Posts & Pages','arnold'),
					'item'  => array(

						// Title
						array('title'       => esc_html__('Title','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_heading',
							  'scheme-name' => 'heading_color',
							  'default'     => '#313139'),
							  
						// Content 
						array('title'       => esc_html__('Content','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_content_text',
							  'scheme-name' => 'content_text_color',
							  'default'     => '#414145'),
							  
						// Meta
						array('title'       => esc_html__('Meta Info.','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_auxiliary_content',
							  'scheme-name' => 'auxiliary_content_color',
							  'default'     => '#adadad'),

						// Property
						array('title'       => esc_html__('Gallery Post Property Title','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_property_tit',
							  'scheme-name' => 'property_tit_color',
							  'default'     => '#313139'),

						// Property
						array('title'       => esc_html__('Gallery Post Property Content','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_property_con',
							  'scheme-name' => 'property_con_color',
							  'default'     => '#313139'),

						// Galley LINK button
						array('title'       => esc_html__('Gallery Post Link Button','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_gallery_link',
							  'scheme-name' => 'gallery_link_color',
							  'default'     => '#313139'),
							  
						// Prev & Next
						array('title'       => esc_html__('Previous & Next','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_post_navi',
							  'scheme-name' => 'post_navi_color',
							  'default'     => '#313139'),

						// Comment Title
						array('title'       => esc_html__('Comment Title','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_comment_tit',
							  'scheme-name' => 'comment_tit_color',
							  'default'     => '#313139'),

						// Comment Content
						array('title'       => esc_html__('Comment Content','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_comment_con',
							  'scheme-name' => 'comment_con_color',
							  'default'     => '#313139'),

						// Comment Author
						array('title'       => esc_html__('Comment Author Name','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_comment_author',
							  'scheme-name' => 'comment_author_color',
							  'default'     => '#313139'),
				)),

				array(/* Portfolio List */
					'id'    => 'color-portfolio-list',
					'title' => esc_html__('Portfolio List','arnold'),
					'item'  => array(
                                                
						// LoadMore
						array('title'       => esc_html__('Load More Button','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_loadmore',
							  'scheme-name' => 'loadmore_color',
							  'default'     => '#313139'), 

						// Title for Item
						array('title'       => esc_html__('Title for Item','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_list_item_tit',
							  'scheme-name' => 'list_item_tit_color',
							  'default'     => '#313139'), 

						// Tag for Item
						array('title'       => esc_html__('Tag for Item','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_list_item_tag',
							  'scheme-name' => 'list_item_tag_color',
							  'default'     => '#313139'), 

						// Mask for Item
						array('title'       => esc_html__('Mask for Item','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_list_item_mask',
							  'scheme-name' => 'list_item_mask_color',
							  'default'     => '#ffffff'), 
				)),

				array(/* Button */
					'id'    => 'color-button',
					'title' => esc_html__('Button','arnold'),
					'item'  => array(
                                                
						 
						array('title'       => esc_html__('Text & Border','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_button',
							  'scheme-name' => 'button_color',
							  'default'     => '#313139'),

						array('title'       => esc_html__('Text Mouseover','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_button_mouseover',
							  'scheme-name' => 'button_mouseover_color',
							  'default'     => '#ffffff'),

						array('title'       => esc_html__('Bg Mouseover','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_button_bg_mouseover',
							  'scheme-name' => 'button_bg_mouseover_color',
							  'default'     => '#313139')
				)),

				array(/* Button */
					'id'    => 'color-form',
					'title' => esc_html__('Form','arnold'),
					'item'  => array(

						array('title'       => esc_html__('Text Input Box by Default','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_form',
							  'scheme-name' => 'form_color',
							  'default'     => '#adadad'),

						array('title'       => esc_html__('Text Input Box Focused','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_form_focused',
							  'scheme-name' => 'form_focused_color',
							  'default'     => '#313139')
				)),
				
				array(/* Sidebar */
					'id'    => 'color-widget',
					'title' => esc_html__('Widget','arnold'),
					'item'  => array(
                                                
						// Widget Title Color
						array('title'       => esc_html__('Title Text','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_widget_title',
							  'scheme-name' => 'widget_title_color',
							  'default'     => '#313139'),
							  
						// Widget Content Color
						array('title'       => esc_html__('Content Text','arnold'),
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_widget_content_color',
							  'scheme-name' => 'widget_content_color',
							  'default'     => '#999999'),

						// Sidebar Widget Title Text Color
						array('title'       => esc_html__('Widget on Sidebar Title','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_widget_title_sidebar',
							  'scheme-name' => 'widget_title_sidebar_color',
							  'default'     => '#f0f0f0'),

						// Sidebar Widget Title Bg Color
						array('title'       => esc_html__('Widget on Sidebar Title Bg','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_color_widget_title_bg',
							  'scheme-name' => 'widget_title_bg_color',
							  'default'     => '#313139')
				)),
							  
				array( /* Footer */
					'id'    => 'color-footer',
					'title' => esc_html__('Footer','arnold'),
					'item'  => array( 
							  
						// Footer Text Color
						array('title'       => esc_html__('Footer Text Color','arnold'),
                              'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_footer_text_color',
							  'scheme-name' => 'footer_text_color',
							  'default'     => '#28282E'),
							  
						// Footer Bg Color
						array('title'       => esc_html__('Footer Bg Color','arnold'),
                              'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_footer_bg_color',
							  'scheme-name' => 'footer_bg_color',
							  'default'     => '#ffffff'))),

				array(/* Lightbox */
					'id'    => 'color-general-default-skin',
					'title' => esc_html__('Others','arnold'),
					'item'  => array(

						// Logo & Menu Skin on Header
						array('title'       => esc_html__('Logo & Menu Skin on Header','arnold'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_custom_logo_choose',
							  'scheme-name' => 'color_skin_logo_header',
							  'col_size'    => 'width:140px;',
							  'default'     => 'dark'),

						// Lightbox Color Skin
						array('title'       => esc_html__('Lightbox Color Skin','arnold'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_color_skin_lightbox',
							  'scheme-name' => 'color_skin_lightbox',
							  'col_size' => 'width:140px;',
							  'default'     => 'dark'))),
			)
		),
		
		array(
			'id'      => 'options-font',
			'name'    => esc_html__('Font Settings','arnold'),
			'section' => array(
				
				array(/* Synchronous */
					'id'    => 'font-synchronous',
					'title' => esc_html__('Synchronous','arnold'),
					'item'  => array(
						
						// Update to new Google Font Data
						array('description' => '',
							  'button'      => array('title'   => esc_html__('Update to new Google Font Data','arnold'),
													 'loading' => esc_html__('Updating ...','arnold'),
													 'type'    => 'font-synchronous',
													 'class'   => 'btn-primary'),
							  'type'        => 'button',
							  'name'        => 'theme_option_font_synchronous'))),
							  
		

				array(/* Logo Font */
					'id'   => 'font-logo',
					'title' => esc_html__('Logo','arnold'),
					'item' => array(
						
						// Logo Font Header
						array('title'       => esc_html__('Plain Text Logo (for header)','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_family_logo',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_logo',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_logo',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Logo Font Footer
						array('title'       => esc_html__('Plain Text Logo (for footer)','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_family_logo_footer',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_logo_footer',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_logo_footer',
										'default'  => '',
										'position' => 'after')
								)
						)
					)
				),
										
				
										
                array(/* Menu Font */
					'id'   => 'menu-font',
					'title' => esc_html__('Menu','arnold'),
					'item' => array(

						// Menu on Header
						array('title'       => esc_html__('Menu on Header','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_family_menu_header',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_menu_header',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_menu_header',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Menu Line Height
						array('title'       => esc_html__('Menu Line-height','arnold'),
							  'description' => '',
							  'type'        => 'text',
							  'default'     => '',
							  'name'        => 'theme_option_menu_line_height',
							  'col_size'    => 'width: 100px;',
							  'control'     => array('name'  => 'theme_option_header_layout',
													 'value' => 'columned-menu-right')
						),

						// Menu on Expanded
						array('title'       => esc_html__('Menu Item on Expanded Panel','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_family_menu_expanded',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_menu_expanded',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_menu_expanded',
										'default'  => '',
										'position' => 'after')
								)
						),
				)),
							  
				array(/* Page Post Font */
					'id'   => 'font-post-page',
					'title' => esc_html__('Posts & Pages','arnold'),
					'item' => array(
						
						// Post Page Title Font
						array('title'       => esc_html__('Title','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_title',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_title',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_title',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Post Page Content Font
						array('title'       => esc_html__('Content','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_content',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_content',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_content',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Post Page Content Heading 1-6 Font
						array('title'       => esc_html__('Content Heading 1-6','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_content_heading',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_content_heading',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Content Heading 1 size
						array('title' => __('Content Heading 1','arnold'),
							  'description' => '',
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_post_page_content_heading-1-size',
							  'default' => ''),

						// Content Heading 2 size
						array('title' => __('Content Heading 2','arnold'),
							  'description' => '',
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_post_page_content_heading-2-size',
							  'default' => ''),

						// Content Heading 3 size
						array('title' => __('Content Heading 3','arnold'),
							  'description' => '',
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_post_page_content_heading-3-size',
							  'default' => ''),

						// Content Heading 4 size
						array('title' => __('Content Heading 4','arnold'),
							  'description' => '',
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_post_page_content_heading-4-size',
							  'default' => ''),

						// Content Heading 5 size
						array('title' => __('Content Heading 5','arnold'),
							  'description' => '',
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_post_page_content_heading-5-size',
							  'default' => ''),

						// Content Heading 6 size
						array('title' => __('Content Heading 6','arnold'),
							  'description' => '',
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_post_page_content_heading-6-size',
							  'default' => ''),

						// Link Button for Page Template
						array('title'       => esc_html__('Link Button for Page Template','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_link_page_tempalte',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_link_page_tempalte',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_link_page_tempalte',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Post Page meta Font
						array('title'       => esc_html__('Meta','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_meta',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_meta',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_meta',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Gallery Post Property Title (Small Heading: Comment Author included)
						array('title'       => esc_html__('Gallery Post Property Title','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_property_title',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_property_title',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_property_title',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Gallery Post Property content
						array('title'       => esc_html__('Gallery Post Property Content','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_property_content',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_property_content',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_property_content',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Gallery Post Link
						array('title'       => esc_html__('Gallery Post Link Button','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_link',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_link',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_link',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Share button size
						array('title' => __('Share Button','arnold'),
							  'description' => '',
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_post_page_content_share_btn_size',
							  'default' => ''),

						// Post Previous $ Next
						array('title'       => esc_html__('Post Previous & Next','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_navi',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_navi',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_navi',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Comment Title (Medium Heading: PageBuilder Mod Title included)
						array('title'       => esc_html__('Comments Title','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_comments_tit',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_comments_tit',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_comments_tit',
										'default'  => '',
										'position' => 'after')
								)
						),

						// Comment Content
						array('title'       => esc_html__('Comments Content','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_comments_con',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_comments_con',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_comments_con',
										'default'  => '',
										'position' => 'after')
								)
						),

						//Comment Author Name
						array('title'       => esc_html__('Comments Author Name','arnold'),
							  'description' => '',
							  'type'        => 'fonts-size',
							  'name'        => 'theme_option_font_size_post_page_comments_author',
							  'default'     => ''),
							  
						
					)),

					array( /* list Font */
					'id'   => 'list',
					'title' => esc_html__('Portfolio List','arnold'),
					'item' => array(
						
						//  Filter
						array('title'       => esc_html__('Filter','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_filter',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_filter',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_filter',
										'default'  => '',
										'position' => 'after')
								)
						),
						//  Load More Button
						array('title'       => esc_html__('Load More Button','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_loadmore',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_loadmore',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_loadmore',
										'default'  => '',
										'position' => 'after')
								)
						),
						//  Title
						array('title'       => esc_html__('Title for Item','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_list_item_tit',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_list_item_tit',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_list_item_tit',
										'default'  => '',
										'position' => 'after')
								)
						),
						//  Tag
						array('title'       => esc_html__('Tag for Item','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_list_item_tag',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_list_item_tag',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_list_item_tag',
										'default'  => '',
										'position' => 'after')
								)
						),
					)),


					array( /* Blog Font */
					'id'   => 'blog',
					'title' => esc_html__('Masonry Blog','arnold'),
					'item' => array(
						
						 //  Title
						array('title'       => esc_html__('Title for Item','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_blog_item_tit',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_blog_item_tit',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_blog_item_tit',
										'default'  => '',
										'position' => 'after')
								)
						),
						//  Meta
						array('title'       => esc_html__('Meta for Item','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_blog_item_meta',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_blog_item_meta',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_blog_item_meta',
										'default'  => '',
										'position' => 'after')
								)
						),
						// Excerpt size
						array('title' => __('Excerpt for Item','arnold'),
							  'description' => '',
							  'type' => 'fonts-size',
							  'name' => 'theme_option_font_post_page_blog_excerpt',
							  'default' => ''),
						
					)),


					array( /* Buttons Font */
					'id'   => 'button',
					'title' => esc_html__('Button','arnold'),
					'item' => array(
						
						//  Buttons
						array('title'       => esc_html__('Button','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_button',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_button',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_button',
										'default'  => '',
										'position' => 'after')
								)
						),
					)),

					array( /* Form Font */
					'id'   => 'form',
					'title' => esc_html__('Form','arnold'),
					'item' => array(
						
						// Text Input Box
						array('title'       => esc_html__('Text Input Box','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_form',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_form',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_form',
										'default'  => '',
										'position' => 'after')
								)
						),
					)),

					array( /* Archive Font */
					'id'   => 'Archive',
					'title' => esc_html__('Archive','arnold'),
					'item' => array(
						
						// Archive Title
						array('title'       => esc_html__('Title','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_archive_tit',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_archive_tit',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_archive_tit',
										'default'  => '',
										'position' => 'after')
								)
						),
						// Archive Posts Title
						array('title'       => esc_html__('Posts Title','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_archive_posts_tit',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_archive_posts_tit',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_archive_posts_tit',
										'default'  => '',
										'position' => 'after')
								)
						),	  
						 
					)),

					array( /* Widgets Font */
					'id'   => 'widgets',
					'title' => esc_html__('Widgets','arnold'),
					'item' => array(
						
						// Widget Title
						array('title'       => esc_html__('Widget Title','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_widget_tit',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_widget_tit',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_widget_tit',
										'default'  => '',
										'position' => 'after')
								)
						),
						// Widget Content
						array('title'       => esc_html__('Widget Content','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_widget_con',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_widget_con',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_widget_con',
										'default'  => '',
										'position' => 'after')
								)
						),	  
						 
					)),

					array(/* Footer Font */
					'id'   => 'footer',
					'title'=> 'Footer',
					'item' => array(


						array('title'       => esc_html__('Footer','arnold'),
							  'description' => '',
							  'type'        => 'fonts-family',
							  'default'     => '',
							  'name'        => 'theme_option_font_post_page_footer',
							  'bind'        => array(
								  array('type'     => 'fonts-style',
										'name'     => 'theme_option_font_style_post_page_footer',
										'default'  => '',
										'position' => 'after'),
								  array('type'     => 'fonts-size',
										'name'     => 'theme_option_font_size_post_page_footer',
										'default'  => '',
										'position' => 'after')
								)
						),	
						
						
					))
			)
		),
		
		array(
			'id'      => 'options-icons',
			'name'    => esc_html__('Icons','arnold'),
			'section' => array(
				
				array(/* Upload Icons */
					'id'    => 'icons-upload',
					'title' => esc_html__('Upload Icons','arnold'),
					'item'  => array(
						
						// Upload Icons
						array('description' => esc_html__('select images for your icons from Media Library, it is recommended to upload 48*48 images','arnold'),
							  'type'        => 'select-images',
							  'name'        => 'theme_option_icons_custom')))
			)
		),	
			
		array(
			'id'      => 'options-layout',
			'name'    => esc_html__('Layout','arnold'),
			'section' => array(
				array(/*  General */
					'title' => esc_html__('General','arnold'),
					'item'  => array(

						// Enable  page loader
						array('title'       => esc_html__('Main Container Width (px)','arnold'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_main_width',
							  'default'     => '1170'), 

						// Enable  page loader
						array('title'       => esc_html__('Page Loader','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_fadein_effect',
							  'default'     => 'false'),

						// Enable image lazyload
						array('title'       => esc_html__('Image LazyLoad','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_image_lazyload',
							  'default'     => 'true')
						
						)),
				
				array(/* Header */
					'title' => esc_html__('Header','arnold'),
					'item'  => array(

						// Menu Style
						array('title'       => esc_html__('Menu Style','arnold'),
							  'description' => '',
							  'type'        => 'image-select',
							  'size'        => '90:64',
							  'name'        => 'theme_option_header_layout',
							  'default'     => 'horizon-menu-right',
							  'data'        =>  array('position' => 'right bottom')),//default 'right top' ... option: left top, right top, center center, left bottom, right bottom

						// Show Menu
						array('title'       => esc_html__('Hide Menu','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_hide_menu',
							  'default'     => 'true',
							  'control'     => array('name'  => 'theme_option_header_layout',
													 'value' => 'logo-centered')),

						// Menu Width
						array('title'       => esc_html__('Header Width','arnold'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_header_width',
							  'default'     => 'fluid'),

						// Header Fluid Padding
						array('title'       => esc_html__('Header Fluid Padding','arnold'),
							  'description' => '',
							  'type'        => 'text',
							  'name'        => 'theme_option_header_padding',
							  'default'     => '',
							  'control'     => array('name'  => 'theme_option_header_width',
													 'value' => 'fluid')),

						// Header Height
						array('title'       => esc_html__('Header Height','arnold'),
							  'description' => '',
							  'type'        => 'text',
							  'name'        => 'theme_option_header_height',
							  'default'     => ''),
					
						
						// Show Social Links On Expanded Menu Panel
						array('title'       => esc_html__('Show Social Links','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_social',
							  'default'     => 'false'),
							  
						// Show Search Button On Menu
						array('title'       => esc_html__('Show Search Button On Menu','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_search_on_expanded_menu_panel',
							  'default'     => 'false'),
							  
						// Enable WPML & Show Multi Language Links On Menu
						array('title'       => esc_html__('Enable WPML & Show Multi Language Links On Menu','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_wpml_on_expanded_menu_panel',
							  'default'     => 'false'),

						// Enable Woocomerce
						array('title'       => esc_html__('Enable Woocomerce Cart','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_shopping_cart',
							  'default'     => 'false'),
						
						//Menu Item Hover Effect
						array('title'       => esc_html__('Menu Item Mouseover Effect','arnold'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_menu_hover',
							  'default'     => 'menu_hover_cross_line'),
					)
				),
							  
				array(/* Footer */
					'title' => esc_html__('Footer','arnold'),
					'item'  => array(

						// Enable Footer Widget for Posts
						array('title'       => __('Enable Footer Widget for Posts','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_footer_widget_for_posts',
							  'default'     => 'true'),

						// Select Footer Widget for Posts
						array('title'       => __('Select Footer Widget for Posts','arnold'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_footer_widget_for_posts',
							  'default'     => 'true',
							  'control'     => array('name'  => 'theme_option_enable_footer_widget_for_posts',
													 'value' => 'true')),

                        // Footer Elements
						array('title'       => __('Footer Elements','arnold'),
							  'description' => '',
							  'type'        => 'select-item',
							  'name'        => 'theme_option_footer_elements',
							  'default'     => 'logo'),

                        // Footer Elements Align
						array('title'       => __('Footer Elements Align','arnold'),
							  'description' => '',
							  'type'        => 'select',
							  'name'        => 'theme_option_footer_elements_align',
							  'default'     => 'horizon')
                        
						)),
							  
				array(/* Page Post */
					'title' => esc_html__('Page/Post','arnold'),
					'item' => array(						
													 
					    // Show Meta On Post Page
						array('title'       => esc_html__('Show Meta On Post Content Page','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_enable_meta_post_page',
							  'default'     => 'true',
							  'bind'        => array(
								  array('type'     => 'checkbox-group',
										'name'     => 'theme_option_posts_showmeta',
										'position' => 'after',
										'default'  => array('date', 'length', 'category', 'author', 'comments'),
										'control'  => array('name'  => 'theme_option_enable_meta_post_page',
															'value' => 'true')))),

						// Category to Hide on Page Post
						array('title'       => esc_html__('Category to Hide on Page/Post','arnold'),
							  'description' => '',
							  'type'        => 'checkbox-group',
							  'name'        => 'theme_option_hide_category_on_post_page',
							  'default'     => array(),
							  'control'  => array('name'  => 'theme_option_enable_meta_post_page',
												  'value' => 'true')),

						// Enable Share Buttons for Project(Gallery Post)
						array('title'       => esc_html__('Enable Share Buttons for Project(Gallery Post)','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_share_button_project',
							  'default'     => 'true'),

						// Enable Share Buttons for Other Post Format'
						array('title'       => esc_html__('Enable Share Buttons for Other Post Format','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_share_button_other',
							  'default'     => 'true'),

						// Show Post (Previous/Next) Navigation On Project Item Page（Gallery Post）
						array('title'       => esc_html__('Show Post (Previous/Next) Navigation On Project Item Page（Gallery Post）','arnold'),
							  'description' => '',
							  'type'        => 'switch',
							  'name'        => 'theme_option_show_post_navigation',
							  'default'     => 'true'),

						// Category for More Project Button On The Bottom of Gallery Post
						array('title'       => esc_html__('Category for More Project Button On The Bottom of Gallery Post','arnold'),
							  'description' => '',
							  'type'        => 'category',
							  'name'        => 'theme_option_category_for_more_project',
							  'default'     => 0),

						// Items Number for More Project Button On The Bottom of Gallery Post (3 Columns)
						array('title'       => esc_html__('Items Number for More Project Button On The Bottom of Gallery Post (3 Columns)','arnold'),
							  'description' => '',
							  'type'        => 'text',
							  'name'        => 'theme_option_category_for_more_project_num',
							  'default'     => '12')
						)),
			)
		),
		
		array(
			'id' => 'options-mobile',
			'name' => esc_html__('Mobile','arnold'),
			'section' => array(
				
				array(/* Mobile Responsive */
					'id' => 'mobile-responsive',
					'title' => esc_html__('Responsive','arnold'),
					'item' => array(
						
						// Enable Mobile Layout
						array('title'       => esc_html__('Enable Mobile Layout','arnold'),
							  'description' => esc_html__('disable this option if you want to display the same with PC end','arnold'),
							  'type'        => 'switch',
							  'name'        => 'theme_option_mobile_enable_responsive',
							  'default'     => 'true'))))
		),
		
		array(
			'id'      => 'options-featured-colors',
			'name'    => esc_html__('Featured Colors','arnold'),
			'section' => array(
							  
				array(/* Global */
					'id'    => 'featured-colors',
					'title' => esc_html__('Featured Colors','arnold'),
					'item'  => array(
						
						// Color by Default
						array('description' => esc_html__('Setup the featured colors for posts and modules','arnold'),
							  'type'        => 'description',
							  'name'        => 'theme_option_featured_color_description'),
						
						// Color by Default
						array('title'       => esc_html__('Color by Default','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_default',
							  'default'     => ''),
						
						// Color 1
						array('title'       => esc_html__('Color 1','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_1',
							  'default'     => '#F5C9C9'),
						
						// Color 2
						array('title'       => esc_html__('Color 2','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_2',
							  'default'     => '#F17567'),
						
						// Color 3
						array('title'       => esc_html__('Color 3','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_3',
							  'default'     => '#5ED672'),
						
						// Color 4
						array('title'       => esc_html__('Color 4','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_4',
							  'default'     => '#0E4792'),
						
						// Color 5
						array('title'       => esc_html__('Color 5','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_5',
							  'default'     => '#FAE800'),
						
						// Color 6
						array('title'       => esc_html__('Color 6','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_6',
							  'default'     => '#9FDEDF'),
						
						// Color 7
						array('title'       => esc_html__('Color 7','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_7',
							  'default'     => '#9895A5'),
						
						// Color 8
						array('title'       => esc_html__('Color 8','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_8',
							  'default'     => '#D63F37'),
						
						// Color 9
						array('title'       => esc_html__('Color 9','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_9',
							  'default'     => '#AF9065'),
						
						// Color 10
						array('title'       => esc_html__('Color 10','arnold'),
							  'description' => '',
							  'type'        => 'switch-color',
							  'name'        => 'theme_option_featured_color_10',
							  'default'     => '#313139')
							  
					)
				)
			)
		)
	);
	
	return $theme_config_fields;
}


?>