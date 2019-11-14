<?php
function arnold_theme_slider_source(){
	$output = array();
	
	array_push($output, array(
		'title' => esc_html__('Select menu', 'arnold'),
		'value' => 0
	));
	
	if(is_plugin_active('revslider/revslider.php')){
		array_push($output, array(
			'title' => esc_html__('Revolution Slider', 'arnold'),
			'value' => 'revolution-slider'
		));
	}
	
	if(post_type_exists('bmslider')){
		array_push($output, array(
			'title' => __('BM Slider', 'arnold'),
			'value' => 'bmslider'
		));
		
	}
	
	return $output;
}

//theme meta slider bmslider
function arnold_theme_meta_slider_bmslider(){
	if(post_type_exists('bmslider')){
		$meta = array(
			array('title' => esc_html__('Select slider name', 'arnold'), 'value' => 0)
		);
		
		$get_bmslider = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'bmslider'
		));
		
		if($get_bmslider){
			foreach($get_bmslider as $slider){
				array_push($meta, array(
					'title' => $slider->post_title, 'value' => $slider->ID
				));
			}
		}
	}else{
		$meta = array(
			array('title' => esc_html__('Bmslider not installed', 'arnold'), 'value' => 0)
		);
	}
	
	return $meta;
}

//theme meta slider revolution
function arnold_theme_meta_slider_revolution(){
	if(is_plugin_active('revslider/revslider.php')){
		global $wpdb;
		$table_revslider = $wpdb->prefix . "revslider_sliders";
		$revslidersliders = $wpdb->get_results("
			SELECT * FROM $table_revslider
			ORDER BY id ASC
			"
		);
		
		$meta = array(
			array('title' => esc_html__('Select slider name', 'arnold'), 'value' => 0)
		);
		
		if(count($revslidersliders)){
			foreach($revslidersliders as $num => $slider){
				array_push($meta, array(
					'title' => $slider->title, 'value' => $slider->alias
				));
			}
		}
	}else{
		$meta = array(
			array('title' => esc_html__('revolution slider not installed', 'arnold'), 'value' => 0)
		);
	}
	return $meta;
}

//theme meta select fields
function arnold_theme_meta_select_fields($fields){
	$fields['theme_meta_sidebar'] = array(
		array('title' => esc_html__('Right Sidebar','arnold'),                         'value' => 'right-sidebar'),
		array('title' => esc_html__('Left Sidebar','arnold'),                          'value' => 'left-sidebar'),
		array('title' => esc_html__('Without Sidebar','arnold'),                       'value' => 'without-sidebar')
	);
	$fields['theme_meta_title_bar_slider_value'] = array(
		array('title' => esc_html__('Select a slider','arnold'),                       'value' => '-1')
	);
	$fields['theme_meta_audio_type'] = array(
		array('title' => esc_html__('Self Hosted Audio','arnold'),                     'value' => 'self-hosted-audio'),
		array('title' => esc_html__('Soundcloud','arnold'),                            'value' => 'soundcloud')
	);
	$fields['theme_meta_video_ratio'] = array(
		array('title' => esc_html__('4:3','arnold'),                                   'value' => '4:3'),
		array('title' => esc_html__('16:9','arnold'),                                  'value' => '16:9'),
		array('title' => esc_html__('Custom','arnold'),                                'value' => 'custom')
	);
	$fields['theme_meta_video_ratio'] = array(
		array('title' => esc_html__('4:3','arnold'),                                   'value' => '4:3'),
		array('title' => esc_html__('16:9','arnold'),                                  'value' => '16:9'),
		array('title' => esc_html__('Custom','arnold'),                                'value' => 'custom')
	);
	$fields['theme_meta_gallery_video_ratio'] = array(
		array('title' => esc_html__('4:3','arnold'),                                   'value' => '4:3'),
		array('title' => esc_html__('16:9','arnold'),                                  'value' => '16:9'),
		array('title' => esc_html__('Custom','arnold'),                                'value' => 'custom')
	);
	$fields['theme_meta_gallery_video_position'] = array(
		array('title' => esc_html__('Top of Gallery','arnold'),                        'value' => 'top'),
		array('title' => esc_html__('Bottom of Gallery','arnold'),                     'value' => 'bottom')
	);
	
	$fields['theme_meta_sidebar_widgets'] = arnold_theme_register_sidebar('sidebars');
	
	$fields['theme_meta_order'] = array(
		array('title' => esc_html__('Ascending','arnold'),                             'value' => 'ASC'),
		array('title' => esc_html__('Descending','arnold'),                            'value' => 'DESC')
	);
	
	$fields['theme_meta_enable_portfolio_list_layout_builder'] = array(
		array('title' => esc_html__('Layout 1','arnold'),                              'value' => 'list_layout_1'),
		array('title' => esc_html__('Layout 2','arnold'),                              'value' => 'list_layout_2'),
		array('title' => esc_html__('Layout 3','arnold'),                              'value' => 'list_layout_3'),
		array('title' => esc_html__('Layout 4','arnold'),                              'value' => 'list_layout_4'),
		array('title' => esc_html__('Layout Text','arnold'),                           'value' => 'list_layout_5')
	);
	
	$fields['theme_meta_page_masonry_grid_item_style'] = array(
		array('title' => esc_html__('Image','arnold'),                                 'value' => 'img'),
		array('title' => esc_html__('Image + Text','arnold'),                          'value' => 'image+text')
	);
	
	$fields['theme_meta_page_masonry_grid_mouseover_effect'] = array(
	array('title' => esc_html__('Static Color Mask + Title','arnold'),                 'value' => 'static-color'),
	array('title' => esc_html__('Featured Color Mask + Title','arnold'),               'value' => 'featured-color')
	);
	
	$fields['theme_meta_page_masonry_grid_mouseover_effect_2'] = array(
		array('title' => esc_html__('No Effect','arnold'),                             'value' => 'none'),
		array('title' => esc_html__('Image Zoom In','arnold'),                          'value' => 'img-zoom-in')
	);
	
	$fields['theme_meta_page_masonry_grid_transparent_for_mask'] = array(
	array('title' => esc_html__('100%','arnold'),                                      'value' => '1'),
	array('title' => esc_html__('90%','arnold'),                                       'value' => '0.9'),
	array('title' => esc_html__('80%','arnold'),                                       'value' => '0.8')
	);

	$fields['theme_meta_slider_source']                                              = arnold_theme_slider_source(); 
	$fields['theme_meta_select_bmslider']                                            = arnold_theme_meta_slider_bmslider();
	$fields['theme_meta_select_revolution_slider']                                   = arnold_theme_meta_slider_revolution();
	
	$fields['theme_meta_page_masonry_grid_text_align'] = array(
	array('title' => esc_html__('Center','arnold'),                                    'value' => 'grid-text-center'),
	array('title' => esc_html__('Left','arnold'),                                      'value' => 'grid-text-left'),
	array('title' => esc_html__('Right','arnold'),                                     'value' => 'grid-text-right'),
	array('title' => esc_html__('Top Left','arnold'),                                  'value' => 'grid-text-top-left'),
	array('title' => esc_html__('Top Center','arnold'),                                'value' => 'grid-text-top-center'),
	array('title' => esc_html__('Top Right','arnold'),                                 'value' => 'grid-text-top-right'),
	array('title' => esc_html__('Bottom Left','arnold'),                               'value' => 'grid-text-bottom-left'),
	array('title' => esc_html__('Bottom Center','arnold'),                             'value' => 'grid-text-bottom-center'),
	array('title' => esc_html__('Bottom Right','arnold'),                              'value' => 'grid-text-bottom-right')
	);
	
	$fields['theme_meta_page_masonry_grid_text_align_2'] = array(
	array('title' => esc_html__('Center','arnold'),                                    'value' => 'grid-text-center'),
	array('title' => esc_html__('Left','arnold'),                                      'value' => 'grid-text-left'),
	array('title' => esc_html__('Right','arnold'),                                     'value' => 'grid-text-right')
	);

	$fields['theme_meta_page_standard_grid_text_align'] = array(
	array('title' => esc_html__('Center','arnold'),                                    'value' => 'standard-text-center'),
	array('title' => esc_html__('Left','arnold'),                                      'value' => 'standard-text-left'),
	array('title' => esc_html__('Right','arnold'),                                     'value' => 'standard-text-right')
	);
	
	$fields['theme_meta_page_pagination'] = array(
	array('title' => esc_html__('Load More Button','arnold'),                          'value' => 'load-more'),
	array('title' => esc_html__('Infiniti Scroll','arnold'),                           'value' => 'infiniti-scroll')
	);
	
	$fields['theme_meta_page_featured_image_height'] = array(
	array('title' => esc_html__('400','arnold'),                                       'value' => '400'),
	array('title' => esc_html__('Screen Height','arnold'),                             'value' => 'screen-height')
	);
	
	$fields['page_template_share_buttons'] = array(
	array('title' => esc_html__('Facebook','arnold'),                                  'value' => 'facebook'),
	array('title' => esc_html__('Twitter','arnold'),                                   'value' => 'twitter'),
	array('title' => esc_html__('Google Plus','arnold'),                               'value' => 'google-plus'),
	array('title' => esc_html__('Pinterest','arnold'),                                 'value' => 'pinterest'),
	array('title' => esc_html__('Digg','arnold'),                    	 	            'value' => 'digg'),
	array('title' => esc_html__('Reddit','arnold'),                    	 	            'value' => 'reddit'),
	array('title' => esc_html__('Linkedin','arnold'),                    	            'value' => 'linkedin'),
	array('title' => esc_html__('Stumbleupon','arnold'),                               'value' => 'stumbleupon'),
	array('title' => esc_html__('Tumblr','arnold'),                    	 	            'value' => 'tumblr'),
	array('title' => esc_html__('Mail','arnold'),                    	 	            'value' => 'mail')
	);
	
	$fields['theme_meta_page_orderby'] = array(
		array('title' => esc_html__('Please Select','arnold'),                         'value' => 'none'),
		array('title' => esc_html__('Title','arnold'),                                 'value' => 'title'),
		array('title' => esc_html__('Date','arnold'),                                  'value' => 'date'),
		array('title' => esc_html__('ID','arnold'),                                    'value' => 'id'),
		array('title' => esc_html__('Modified','arnold'),                              'value' => 'modified'),
		array('title' => esc_html__('Author','arnold'),                                'value' => 'author'),
		array('title' => esc_html__('Comment count','arnold'),                         'value' => 'comment_count')
	);
	
	$fields['theme_meta_page_template'] = array(
	array('title' => esc_html__('No Template','arnold'),                               'value' => 'none'),
	array('title' => esc_html__('Custom Grid Portfolio','arnold'),                    'value' => 'masonry-grid'),
	array('title' => esc_html__('Masonry Portfolio','arnold'),                         'value' => 'masonry-portfolio'),
	array('title' => esc_html__('Standard Grid Portfolio','arnold'),					'value' => 'standard-grid'), 
	array('title' => esc_html__('Irregular List','arnold'),                               'value' => 'custom-list'),
	array('title' => esc_html__('Blog Masonry','arnold'),                              'value' => 'blog-masonry'),
	array('title' => esc_html__('Slider','arnold'),			                       		'value' => 'only-slider')
	);
	
	$fields['theme_meta_page_colour_for_text'] = array(
	array('title' => esc_html__('Dark','arnold'),                                      'value' => 'dark-logo'),
	array('title' => esc_html__('Light','arnold'),                                     'value' => 'light-logo')
	);
	
	$fields['theme_meta_page_grid_ratio'] = array(
	array('title' => esc_html__('4:3','arnold'),                                       'value' => '4_3'),
	array('title' => esc_html__('16:9','arnold'),                                      'value' => '16_9'),
	array('title' => esc_html__('1:1','arnold'),                                       'value' => '1_1')
	);
	
	$fields['theme_meta_page_columns'] = array(
	array('title' => esc_html__('2','arnold'),                                         'value' => '2'),
	array('title' => esc_html__('3','arnold'),                                         'value' => '3'),
	array('title' => esc_html__('4','arnold'),                                         'value' => '4'),
	array('title' => esc_html__('5','arnold'),                                         'value' => '5'),
	array('title' => esc_html__('6','arnold'),                                         'value' => '6')
	);
	
	$fields['theme_meta_page_columns_blog'] = array(
	array('title' => esc_html__('1','arnold'),                                         'value' => '1'),
	array('title' => esc_html__('2','arnold'),                                         'value' => '2'),
	array('title' => esc_html__('3','arnold'),                                         'value' => '3'),
	array('title' => esc_html__('4','arnold'),                                         'value' => '4')
	);
	
	$fields['theme_meta_page_spacing'] = array(
	array('title' => esc_html__('No Spacing','arnold'),                                'value' => 'no-spacing'),
	array('title' => esc_html__('Narrow','arnold'),                                    'value' => 'narrow'),
	array('title' => esc_html__('Normal','arnold'),                                    'value' => 'normal')
	);
	
	$fields['theme_meta_page_masonry_grid_spacing'] = array(
	array('title' => esc_html__('Normal','arnold'),                                    'value' => 'normal'),
	array('title' => esc_html__('10','arnold'),                                        'value' => '10'),
	array('title' => esc_html__('20','arnold'),                                        'value' => '20'),
	array('title' => esc_html__('30','arnold'),                                        'value' => '30'),
	array('title' => esc_html__('40','arnold'),                                        'value' => '40'),
	array('title' => esc_html__('No Spacing','arnold'),                                'value' => 'no-spacing')
	);
	
	$fields['theme_meta_page_list_width'] = array(
	array('title' => esc_html__('Normal(Main Container Width)','arnold'),              'value' => 'normal'),
	array('title' => esc_html__('Fullwidth','arnold'),                                 'value' => 'fullwidth'),
	array('title' => esc_html__('Fullwidth Filled','arnold'),                          'value' => 'fullwidth-filled')
	);
	
	$fields['theme_meta_page_what_thumb'] = array(
	array('title' => esc_html__('Open The Portfolio Item','arnold'),                   'value' => 'open-item'),
	array('title' => esc_html__('Open Lightbox','arnold'),                      		  'value' => 'open-featured-img')
	//array('title' => esc_html__('Open Lightbox(Play All Images of Current Project)','arnold'),	'value' => 'open-all-img')
	);
	
	$fields['theme_meta_page_mouseover_effect'] = array(
	array('title' => esc_html__('Static Color Mask + Title','arnold'),                 'value' => 'static-color'),
	array('title' => esc_html__('Featured Color Mask + Title','arnold'),               'value' => 'featured-color'),
	//array('title' => esc_html__('The First Image in Gallery','arnold'),              'value' => 'first-gallery')
	);
	
	$fields['theme_meta_page_show_filter'] = array(
	array('title' => esc_html__('No','arnold'),                                        'value' => 'no'),
	array('title' => esc_html__('Show Filter On Header With Menu','arnold'),           'value' => 'on-menu'),
	array('title' => esc_html__('Above Gallery','arnold'),                             'value' => 'above-gallery')
	);
	
	$fields['theme_meta_page_portfolio_layout_builder_image_align'] = array(
	array('title' => esc_html__('Image Align','arnold'),                               'value' => 0),
	array('title' => esc_html__('Left','arnold'),                                      'value' => 'left'),
	array('title' => esc_html__('Center','arnold'),                                    'value' => 'center'),
	array('title' => esc_html__('Right','arnold'),                                     'value' => 'right')
	);
	
	$fields['theme_meta_page_portfolio_layout_builder_title_align'] = array(
	array('title' => esc_html__('Text Align','arnold'),                                'value' => 0),
	array('title' => esc_html__('Top Left','arnold'),                                  'value' => 'top-left'),
	array('title' => esc_html__('Middle Left','arnold'),                               'value' => 'middle-left'),
	array('title' => esc_html__('Bottom Left','arnold'),                               'value' => 'bottom-left'),
	array('title' => esc_html__('Top Right','arnold'),                                 'value' => 'top-right'),
	array('title' => esc_html__('Middle Right','arnold'),                              'value' => 'middle-right'),
	array('title' => esc_html__('Bottom Right','arnold'),                              'value' => 'bottom-right')
	);
	
	$fields['theme_meta_page_portfolio_layout_builder_top_padding'] = array(
	array('title' => esc_html__('Top Padding','arnold'),                               'value' => 0),
	array('title' => esc_html__('100px Spacing','arnold'),                             'value' => '100px'),
	array('title' => esc_html__('Overlap','arnold'),                                   'value' => 'overlap')
	);
	
	$fields['theme_meta_page_portfolio_layout_builder_image_width'] = array(
	array('title' => esc_html__('Image Width','arnold'),                               'value' => 0),
	array('title' => esc_html__('30%','arnold'),                                       'value' => '30%'),
	array('title' => esc_html__('40%','arnold'),                                       'value' => '40%'),
	array('title' => esc_html__('50%','arnold'),                                       'value' => '50%'),
	array('title' => esc_html__('60%','arnold'),                                       'value' => '60%'),
	array('title' => esc_html__('70%','arnold'),                                       'value' => '70%')
	);
	
	$fields['theme_meta_gallery_template'] = array(
	array('title' => esc_html__('Standard','arnold'),                                  'value' => 'standard'),
	array('title' => esc_html__('Big Title','arnold'),                                 'value' => 'big-title'),
	array('title' => esc_html__('Slider','arnold'),                                    'value' => 'slider'),
	array('title' => esc_html__('Fullscreen','arnold'),                                'value' => 'fullscreen')
	);
	
	$fields['theme_meta_gallery_width'] = array(
	array('title' => esc_html__('Fullwidth','arnold'),                                 'value' => 'fullwidth'),
	array('title' => esc_html__('Normal','arnold'),                                    'value' => 'normal')
	);
	
	$fields['theme_meta_gallery_colour_for_text'] = array(
	array('title' => esc_html__('Dark','arnold'),                                      'value' => 'dark-logo'),
	array('title' => esc_html__('Light','arnold'),                                     'value' => 'light-logo')
	);
	
	$fields['theme_meta_gallery_pb_colour_for_text'] = array(
	array('title' => esc_html__('Dark','arnold'),                                      'value' => 'dark-logo'),
	array('title' => esc_html__('Light','arnold'),                                     'value' => 'light-logo')
	);
	
	$fields['theme_meta_gallery_brightness'] = array(
	array('title' => esc_html__('Dark Image','arnold'),                                'value' => 'light-logo'),
	array('title' => esc_html__('Light Image','arnold'),                               'value' => 'dark-logo')
	);
	
	return $fields;
}
add_filter('theme_config_select_fields', 'arnold_theme_meta_select_fields');

//theme meta fields
function arnold_theme_post_meta_fields(){
	$arnold_theme_post_meta_fields = array(
		
		// Page
		'page' => array(
			array(
				'id'      => 'page-options',
				'title'   => esc_html__('Page Options','arnold'),
				'section' => array(

					array(
						'item' => array(
						
							// Page Template
							array('title'       => esc_html__('Page Template','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_page_template',
								  'default'     => 'none',
								  'col_size'    => 'width:50%;'),
						)
					),
					
					array(/* Sidebar */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'none|blog-masonry'
						),
						'item' => array(
								  
							array('type'        => 'divider'),
							
							// Sidebar
							array('title'       => esc_html__('Sidebar','arnold'),
								  'description' => '',
								  'type'        => 'image-select',
								  'name'        => 'theme_meta_sidebar',
								  'size'        => '126:80',
								  'default'     => 'without-sidebar',
								  'bind'        => array(
									  array('type'     => 'select',
											'name'     => 'theme_meta_sidebar_widgets',
											'col_size' => 'width:200px;',
											'position' => 'after')))
						)),
					
					array(/* Sidebar */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'none'
						),
						'item' => array(

							// Show Featured Image
							array('title'       => esc_html__('Show Featured Image','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_show_featured_image',
								  'default'     => 'false'), 

							// Height for Featured Image
							array('title'       => esc_html__('Height for Featured Image','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_page_featured_image_height',
								  'default'     => '400',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_show_featured_image',
														 'value' => 'true')), 

							// Show Page Title
							array('title'       => esc_html__('Show Page Title','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_show_title',
								  'default'     => 'true'),
								  
							// Colour for Logo & Menu Button
							array('title'       => esc_html__('Colour for Logo & Menu Button','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_page_colour_for_text',
								  'default'     => 'dark-logo',
								  'col_size'    => 'width:50%;'),
								  
							// Show Top Spacer
							array('title'       => esc_html__('Show Top Spacer','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_show_top_spacer',
								  'default'     => 'true'),
								  
							// Show Bottom Spacer
							array('title'       => esc_html__('Show Bottom Spacer','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_show_bottom_spacer',
								  'default'     => 'true'),

							// From Page Top
							array('title'       => esc_html__('From Page Top','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_from_page_top',
								  'default'     => 'false')
							)),
							
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'masonry-grid|masonry-portfolio|standard-grid|custom-list'
						),
						'item' => array(
								  
							array('type'        => 'divider'), 

							// Introduction Section
							array('title'       => esc_html__('Introduction Section','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'default'     => 'false',
								  'name'        => 'theme_meta_page_show_introduction'),

							// Show Social Links
							array('title'       => esc_html__('Show Social Links','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'default'     => 'false',
								  'name'        => 'theme_meta_page_show_social_link',
								  'control'     => array('name'  => 'theme_meta_page_show_introduction',
														 'value' => 'true'))
							)),
							
					array(/* Page Template blog */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'custom-list'
						),
						'item' => array(
								  
							array('type'        => 'divider'), 

							// Portfolio Layout Builder
							array('title'       => esc_html__('Portfolio Layout Builder','arnold'),
								  'description' => '',
								  'type'        => 'page_layout_builder',
								  'default'     => '',
								  'name'        => 'theme_meta_page_portfolio_layout_builder')
						
						)),
					
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'masonry-grid'
						),
						
						'item' => array(
						
							array('type'        => 'divider'),

							// Category
							array('title'       => esc_html__('Category','arnold'),
								  'description' => '',
								  'type'        => 'category',
								  'default'     => 0,
								  'name'        => 'theme_meta_page_category_masonry_grid',
								  'col_size'    => 'width:50%;',
								  'post_format' => array('post-format-gallery', 'post-format-link')),

							// Edit Portfolio List Layout
							array('type'        => 'edit-portfolio-list-layout',
								  'name'        => 'theme_meta_page_masonry_grid_list_layout'),
								  
							// Item Style
							array('title'       => esc_html__('Item Style','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_page_masonry_grid_item_style',
								  'default'     => 'img',
								  'col_size'    => 'width:50%;'),
								  
							// Mouseover Effect Image
							array('title'       => esc_html__('Mouseover Effect','arnold'),
								  'type'        => 'select',
								  'default'     => 'static-color',
								  'name'        => 'theme_meta_page_masonry_grid_mouseover_effect',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_masonry_grid_item_style',
														 'value' => 'img')),
								  
							// Mouseover Effect Image + Text
							array('title'       => esc_html__('Mouseover Effect','arnold'),
								  'type'        => 'select',
								  'default'     => 'none',
								  'name'        => 'theme_meta_page_masonry_grid_mouseover_effect_2',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_masonry_grid_item_style',
														 'value' => 'image+text')),
								  
							// Transparent for Mask
							array('title'       => esc_html__('Transparent for Mask','arnold'),
								  'type'        => 'select',
								  'default'     => '100%',
								  'name'        => 'theme_meta_page_masonry_grid_transparent_for_mask',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_masonry_grid_item_style',
														 'value' => 'img')),

							// Show Title
							array('title'       => esc_html__('Show Title','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_masonry_grid_show_title',
								  'default'     => 'false',
								  'control'     => array('name'  => 'theme_meta_page_masonry_grid_item_style',
														 'value' => 'img')),

							// Show Category
							array('title'       => esc_html__('Show Category','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_masonry_grid_show_category',
								  'default'     => 'false'),
								  
							// Text Align
							array('title'       => esc_html__('Text Align','arnold'),
								  'type'        => 'select',
								  'default'     => 'center',
								  'name'        => 'theme_meta_page_masonry_grid_text_align',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_masonry_grid_item_style',
														 'value' => 'img')),

							// Text Align
							array('title'       => esc_html__('Text Align','arnold'),
								  'type'        => 'select',
								  'default'     => 'center',
								  'name'        => 'theme_meta_page_masonry_grid_text_align_2',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_masonry_grid_item_style',
														 'value' => 'image+text')),

							// Show Padding - Standard Grid 
							array('title'       => esc_html__('Text Padding','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_masonry_grid_padding',
								  'default'     => 'false',
								  'control'     => array('name'  => 'theme_meta_page_masonry_grid_item_style',
														 'value' => 'image+text')), 
						
						)),
					
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'blog-masonry|masonry-portfolio|standard-grid|custom-list'
						),
						
						'item' => array(
								  
							array('type'        => 'divider'), 

							// Category
							array('title'       => esc_html__('Category','arnold'),
								  'description' => '',
								  'type'        => 'category',
								  'default'     => 0,
								  'name'        => 'theme_meta_page_category',
								  'col_size'    => 'width:50%;'),
								  
							// Select Category Order
							array('title'       => esc_html__('Order','arnold'),
								  'description' => '',
								  'type'        => 'orderby',
								  'name'        => 'theme_meta_page_orderby',
								  'default'     => 'date',
								  'col_size'    => 'width:50%;')
								  
						)),

					array(/* Page Template - Standard Grid */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'standard-grid'
						),
						
						'item' => array(
							// Show Title - Standard Grid 
							array('title'       => esc_html__('Show Title','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_standard_grid_show_title',
								  'default'     => 'false'),

							// Show Project Property
							array('title'       => esc_html__('Show Project Property','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_show_project_property',
								  'default'     => 'false'),

							// Text Align - Standard Grid  
							array('title'       => esc_html__('Text Align','arnold'),
								  'type'        => 'select',
								  'default'     => 'standard-text-left',
								  'name'        => 'theme_meta_page_standard_grid_text_align',
								  'col_size'    => 'width:50%;'),

							// Show Padding - Standard Grid 
							array('title'       => esc_html__('Padding','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_standard_grid_padding',
								  'default'     => 'false',
								  'control'     => array('name'  => 'theme_meta_page_standard_grid_text_align',
														 'value' => 'standard-text-left|standard-text-right')),
						)
					),
					
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'blog-masonry|masonry-portfolio|standard-grid'
						),
						
						'item' => array(
								  
							// Columns
							array('title'       => esc_html__('Columns','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_page_columns',
								  'default'     => '2',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'masonry-portfolio|standard-grid')),
								  
							// Columns for blog masonry
							array('title'       => esc_html__('Columns','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_page_columns_blog',
								  'default'     => '2',
								  'col_size'    => 'width:75%;',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'blog-masonry'))
								  
						)),
					
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'blog-masonry|masonry-portfolio|standard-grid|custom-list'
						),
						
						'item' => array(
								  
							// Post Number per Page
							array('title'       => esc_html__('Post Number per Page','arnold'),
								  'type'        => 'text',
								  'default'     => 10,
								  'name'        => 'theme_meta_page_number',
								  'col_size'    => 'width:50%;'),
								  
							// Pagination
							array('title'       => esc_html__('Pagination','arnold'),
								  'type'        => 'select',
								  'default'     => 'load-more',
								  'name'        => 'theme_meta_page_pagination',
								  'col_size'    => 'width:50%;')
								  
						)),
					
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'standard-grid'
						),
						
						'item' => array(
								  
							// Grid Ratio
							array('title'       => esc_html__('Grid Ratio','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_page_grid_ratio',
								  'default'     => '4_3',
								  'col_size'    => 'width:50%;')
								  
						)),
					
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'masonry-grid|masonry-portfolio|standard-grid|custom-list'
						),
						
						'item' => array(
								  
							// What Thumbnail Does
							array('title'       => esc_html__('What Thumbnail Does','arnold'),
								  'type'        => 'select',
								  'default'     => 'open-item',
								  'name'        => 'theme_meta_page_what_thumb',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'masonry-grid|masonry-portfolio')),
								  
							// Item Spacing
							array('title'       => esc_html__('Item Spacing','arnold'),
								  'type'        => 'select',
								  'default'     => 'normal',
								  'name'        => 'theme_meta_page_spacing',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'masonry-portfolio|standard-grid')),
								  
							// Item Spacing
							array('title'       => esc_html__('Item Spacing','arnold'),
								  'type'        => 'select',
								  'default'     => 'normal',
								  'name'        => 'theme_meta_page_masonry_grid_spacing',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'masonry-grid')),
								  
							// List Width
							array('title'       => esc_html__('List Width','arnold'),
								  'type'        => 'select',
								  'default'     => 'fullwidth-filled',
								  'name'        => 'theme_meta_page_list_width',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'standard-grid|masonry-grid|masonry-portfolio'))
								  
						)),
					
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'masonry-portfolio'
						),
						
						'item' => array(
								  
							// Mouseover Effect
							array('title'       => esc_html__('Mouseover Effect','arnold'),
								  'type'        => 'select',
								  'default'     => 'bordered-left',
								  'name'        => 'theme_meta_page_mouseover_effect',
								  'col_size'    => 'width:50%;')
								  
						)),

					array(/* Slider */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'only-slider'
						),
						'item' => array(
							
							array('type'        => 'divider'),

							// Show Slider
							array('title'       => esc_html__('Show Slider','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_enable_slider',
								  'default'     => 'false'),

							// Slider Source
							array('title'       => esc_html__('Slider Source','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_slider_source',
								  'control'     => array('name'  => 'theme_meta_enable_slider',
														 'value' => 'true')),
	
							// Select Slider
							array('title'       => esc_html__('Select Slider','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_select_revolution_slider',
								  'control'     => array('name'  => 'theme_meta_slider_source',
														 'value' => 'revolution-slider')),
	
							// Select Slider
							array('title'       => esc_html__('Select Slider','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_select_bmslider',
								  'control'     => array('name'  => 'theme_meta_slider_source',
														 'value' => 'bmslider'))
							
							)),

					 
					
					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'masonry-grid|masonry-portfolio|standard-grid|custom-list'
						),
						
						'item' => array( 

							// Show Tags
							array('title'       => esc_html__('Show Tags','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_show_tags',
								  'default'     => 'false',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'custom-list')),
								  
							// Show Filter
							array('title'       => esc_html__('Show Filter','arnold'),
								  'type'        => 'select',
								  'default'     => 'no',
								  'name'        => 'theme_meta_page_show_filter',
								  'col_size'    => 'width:50%;',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'masonry-grid|masonry-portfolio|standard-grid')),

							// Show Link
							array('title'       => esc_html__('Show Link','arnold'),
								  'type'        => 'button-single',
								  'default'     => '',
								  'name'        => 'theme_meta_page_show_link',
								  'placeholder' => array(esc_html__('Title','arnold'), esc_html__('Link','arnold')),
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'masonry-grid|masonry-portfolio|standard-grid'))
						
						)),

					array(/* Page Template */
						'super-control' => array(
							'name'  => 'theme_meta_page_template',
							'value' => 'none|masonry-grid|masonry-portfolio|standard-grid|custom-list'
						),
						'item' => array(
						// Show Footer
							array('title'       => esc_html__('Show Footer','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_show_footer',
								  'default'     => 'true'),

							// Show Top Spacer
							array('title'       => esc_html__('Show Top Spacer','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_page_show_top_spacer2',
								  'default'     => 'false',
								  'control'     => array('name'  => 'theme_meta_page_template',
														 'value' => 'masonry-grid'))
					))
					
				)
			)
		),
		
		// Single Post
		'post' => array(
			
			/* Select Images */
			array(
				'id'      => 'gallery-setting',
				'title'   => esc_html__('Gallery Setting','arnold'),
				'format'  => 'gallery',
				'section' => array(
					
					array(/* Format Gallery */
						'item' => array(
							
							// gallery
							array('title'       => esc_html__('Select Images','arnold'),
								  'type'        => 'gallery',
								  'description' => '',
								  'name'        => 'theme_meta_portfolio'),
								  
							array('type'        => 'divider'),
							
							

							))
				)
			),
			
			/* Images Settings */
			// array(
			// 	'id'      => 'images-settings',
			// 	'title'   => esc_html__('Images Settings','arnold'),
			// 	'format'  => 'image',
			// 	'section' => array(
					
			// 		array(/* Format Image */
			// 			'item' => array(
							
			// 				// Link
			// 				array('title'       => esc_html__('Link','arnold'),
			// 					  'description' => '',
			// 					  'type'        => 'text',
			// 					  'name'        => 'theme_meta_image_link')))
			// 	)
			// ),
			
			/* Audio Settings */
			array(
				'id'      => 'audio-settings',
				'title'   => esc_html__('Audio Settings','arnold'),
				'format'  => 'audio',
				'section' => array(
					
					array(/* Format Audio */
						'item' => array(
						
							// Audio Type
							array('title'       => esc_html__('Audio Type','arnold'),
								  'description' => '',
								  'type'        => 'image-select',
								  'size'        => '106:43',
								  'default'     => 'self-hosted-audio',
								  'name'        => 'theme_meta_audio_type'),
								  
							array('type'        => 'divider'),
							
							// Artist
							array('title'       => esc_html__('Artist','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_audio_artist',
								  'control'     => array('name'  => 'theme_meta_audio_type',
														 'value' => 'self-hosted-audio')),
								  
							// MP3
							array('title'       => esc_html__('MP3','arnold'),
								  'description' => '',
								  'type'        => 'social-medias',
								  'name'        => 'theme_meta_audio_mp3',
								  'special'     => 'mp3',
								  'placeholder' => array(esc_html__('Title','arnold'), esc_html__('URL','arnold')),
								  'control'     => array('name'  => 'theme_meta_audio_type',
														 'value' => 'self-hosted-audio')),
								  
							// Code for WP
							array('title'       => esc_html__('Code for WP','arnold'),
								  'type'        => 'textarea',
								  'name'        => 'theme_meta_audio_soundcloud',
								  'description' => esc_html__('*Format: https://soundcloud.com/imam-lepast-konyol/maher-zain-always-be-there-1','arnold'),
								  'control'     => array('name'  => 'theme_meta_audio_type',
														 'value' => 'soundcloud'))))
				)
			),
			
			/* Video Settings */
			array(
				'id'      => 'video-settings',
				'title'   => esc_html__('Video Settings','arnold'),
				'format'  => 'video',
				'section' => array(
					
					array(/* Format Video */
						'item' => array(
							
							// Description
							array('description' => esc_html__('You could find the embed code on the source video page.','arnold').'<div class="show-hide-guide-wrap"><a href="http://www.uiueux.com/a/newtea/documentation/video-guide.html" target="_blank"><span>?</span></a></div>',
								  'type'        => 'description'),
								  
							// Embeded Code
							array('title'       => esc_html__('Embeded Code','arnold'),
								  'description' => '',
								  'type'        => 'textarea',
								  'name'        => 'theme_meta_video_embeded_code'),
								  
							// Ratio	  
							array('title'       => esc_html__('Ratio','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_video_ratio',
								  'default'     => '4:3'),
								  
							// Custom Ratio	  
							array('type'        => 'ratio',
								  'name'        => 'theme_meta_video_custom_ratio',
								  'description' => '',
								  'control'     => array('name'  => 'theme_meta_video_ratio',
														 'value' => 'custom'))))
				)
			),
			
			/* Quote Settings */
			array(
				'id' => 'quote-settings',
				'title' => esc_html__('Quote Settings','arnold'),
				'format' => 'quote',
				'section' => array(
				
					array(/* Format Quote */
						'item' => array(
							
							// The Quote
							array('title'       => esc_html__('The Quote','arnold'),
								  'description' => esc_html__('Write your quote in this field.','arnold'),
								  'type'        => 'textarea',
								  'name'        => 'theme_meta_quote'),
							
							// Cite 
							array('title'       => esc_html__('Cite','arnold'),
								  'description' => '',
								  'type'        => 'textarea',
								  'name'        => 'theme_meta_quote_cite')))
				)
			),
			
			/* Link Settings */
			array(
				'id' => 'link-settings',
				'title' => esc_html__('Link Settings','arnold'),
				'format' => 'link',
				'section' => array(
					
					array(/* Format Link */
						'item' => array(
						
							// Link Item
							array('title'       => esc_html__('Link Item','arnold'),
								  'description' => '',
								  'type'        => 'social-medias',
								  'name'        => 'theme_meta_link_item',
								  'special'     => 'mp3',
								  'placeholder' => array(esc_html__('Title','arnold'), esc_html__('URL','arnold')))
						)
					)
				)
			),

			array(
				'id' => 'link-color',
				'title' => esc_html__('Colour for Masonry Grid','arnold'),
				'format' => 'link',
				'section' => array(
					
					array(/* Format Link */
						'item' => array(
						
							array('title'       => __('Text Colour by Default','arnold'),
								  'description' => '',
								  'type'        => 'switch-color',
								  'name'        => 'theme_meta_link_text_color',//theme_meta_bg_color
								  'format'      => 'link',
								  'default'     => '#ffffff',
								  'mod'         => ''),

							array('title'       => __('Bg Colour by Default','arnold'),
								  'description' => '',
								  'type'        => 'switch-color',
								  'name'        => 'theme_meta_link_bg_color',//theme_meta_bg_color
								  'format'      => 'link',
								  'default'     => '#313139',
								  'mod'         => ''),

							array('title'       => __('Text Colour Mouseover','arnold'),
								  'description' => '',
								  'type'        => 'switch-color',
								  'name'        => 'theme_meta_link_text_color_mouseover',//theme_meta_bg_color
								  'format'      => 'link',
								  'default'     => '#ffffff',
								  'mod'         => ''),

							array('title'       => __('Bg Colour by Mouseover','arnold'),
								  'description' => '',
								  'type'        => 'switch-color',
								  'name'        => 'theme_meta_link_bg_color_mouseover',//theme_meta_bg_color
								  'format'      => 'link',
								  'default'     => '#313139',
								  'mod'         => ''),
						)
					)
				)
			),

			/* Post Options */
			array(
				'id'      => 'post-options', 
				'title'   => esc_html__('Layout Options','arnold'), 
				'format' => 'audio',
				'section' => array( 

					array(/* Sidebar */
						'item' => array(
							
							// Sidebar
							array('title'       => esc_html__('Sidebar','arnold'),
								  'description' => '',
								  'type'        => 'image-select',
								  'name'        => 'theme_meta_sidebar',
								  'size'        => '126:80',
								  'default'     => 'none',
								  'bind'        => array(
									  array('type'     => 'select',
											'name'     => 'theme_meta_sidebar_widgets',
											'col_size' => 'width:200px;',
											'position' => 'after'))))
					)

				)

			),
							
			
			/* Post Options */
			array(
				'id'      => 'gallery-options',
				'format' => 'gallery',
				'title'   => esc_html__('Gallery Template','arnold'),
				'section' => array(
				
					array(
						'super-control' => array(
							'name'  => 'theme_meta_gallery_template',
							'value' => 'standard|big-title|slider|fullscreen'
						),
						'item' => array(
						
							// Featured Color
							array('title'       => __('Featured Color','arnold'),
								  'description' => '',
								  'type'        => 'switch-color',
								  'name'        => 'theme_meta_featured_color',//theme_meta_bg_color
								  'format'      => 'gallery',
								  'default'     => '#ffffff',
								  'mod'         => ''))),
				
					array(
						'item' => array(
								  
							array('type'        => 'divider',
								  'format'      => 'gallery'),
							
							
							// Layout Template
							array('title'       => esc_html__('Layout Template','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_gallery_template',
								  'format'      => 'gallery',
								  'col_size'    => 'width:50%;',
								  'default'     => 'standard'))),

					array(
						'super-control' => array(
							'name'  => 'theme_meta_gallery_template',
							'value' => 'big-title|slider|fullscreen'
						),
						'item' => array(
								  
							array('type'        => 'divider',
								  'format'      => 'gallery'),

							// Title Masking
							array('title'       => esc_html__('Title Text Masking','arnold'),
								  'description' => esc_html__('The Featured Image need be set. For Webkit Browser only, like Chrome, Safari','arnold'),
								  'type'        => 'switch',
								  'format'      => 'gallery',
								  'name'        => 'theme_meta_gallery_title_masking',
								  'default'     => 'false')
						)
					),
					
					array(
						'super-control' => array(
							'name'  => 'theme_meta_gallery_template',
							'value' => 'standard|big-title'
						),
						'item' => array(
								  
							array('type'        => 'divider',
								  'format'      => 'gallery'),

							// Gallery Layout Builder
							array('title'       => esc_html__('Gallery Layout Builder','arnold'),
								  'description' => '',
								  'type'        => 'layout-builder',
								  'name'        => 'theme_meta_enable_portfolio_list_layout_builder',
								  'format'      => 'gallery',
								  'default'     => 'list_layout_1'),
								  
							// Show Video
							array('title'       => esc_html__('Show Video','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_show_gallery_video',
								  'format'      => 'gallery',
								  'default'     => 'false'),
							
							// Description
							array('description' => esc_html__('You could find the embed code on the source video page.','arnold').'<div class="show-hide-guide-wrap"><a href="http://www.uiueux.com/a/newtea/documentation/video-guide.html" target="_blank"><span>?</span></a></div>',
								  'type'        => 'description',
								  'format'      => 'gallery',
								  'control'     => array('name'  => 'theme_meta_show_gallery_video',
														 'value' => 'true')),
								  
							// Embeded Code
							array('title'       => esc_html__('Embeded Code','arnold'),
								  'description' => '',
								  'type'        => 'textarea',
								  'format'      => 'gallery',
								  'name'        => 'theme_meta_gallery_video_embeded_code',
								  'control'     => array('name'  => 'theme_meta_show_gallery_video',
														 'value' => 'true')),
								  
							// Ratio	  
							array('title'       => esc_html__('Ratio','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_gallery_video_ratio',
								  'format'      => 'gallery',
								  'default'     => '4:3',
								  'control'     => array('name'  => 'theme_meta_show_gallery_video',
														 'value' => 'true')),
								  
							// Custom Ratio	  
							array('type'        => 'ratio',
								  'name'        => 'theme_meta_gallery_video_custom_ratio',
								  'format'      => 'gallery',
								  'description' => '',
								  'control'     => array('name'  => 'theme_meta_gallery_video_ratio',
														 'value' => 'custom')),
								  
							// Video Position	  
							array('title'       => esc_html__('Video Position','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_gallery_video_position',
								  'format'      => 'gallery',
								  'default'     => 'top',
								  'control'     => array('name'  => 'theme_meta_show_gallery_video',
														 'value' => 'true')),
							
							// Gallery Width
							array('title'       => esc_html__('Gallery Width','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_gallery_width',
								  'format'      => 'gallery',
								  'col_size'    => 'width:50%;',
								  'default'     => 'wide'))),
					
					array(
						'super-control' => array(
							'name'  => 'theme_meta_gallery_template',
							'value' => 'standard|big-title|slider|fullscreen'
						),
						'item' => array(
								  
							array('type'        => 'divider',
								  'format'      => 'gallery'),

							// Show Buttons
							array('title'       => esc_html__('Show Button','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_gallery_show_button',
								  'format'      => 'gallery',
								  'default'     => 'true'),
							
							// Buttons
							array('type'        => 'button-multiple',
								  'name'        => 'theme_meta_gallery_buttons',
								  'format'      => 'gallery',
								  'placeholder' => array(esc_html__('Title','arnold'), esc_html__('Link','arnold')),
								  'control'     => array('name'  => 'theme_meta_gallery_show_button',
														 'value' => 'true')),
								  
							// Show Property
							array('title'       => esc_html__('Show Property','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_gallery_show_property',
								  'format'      => 'gallery',
								  'default'     => 'true'),
							
							// Property
							array('type'        => 'property',
								  'name'        => 'theme_meta_enable_portfolio_property',
								  'format'      => 'gallery',
								  'placeholder' => array(esc_html__('Title','arnold'), esc_html__('Content','arnold'), esc_html__('URL','arnold')),
								  'control'     => array('name'  => 'theme_meta_gallery_show_property',
														 'value' => 'true')))),
					
					array(
						'super-control' => array(
							'name'  => 'theme_meta_gallery_template',
							'value' => 'standard|big-title|fullscreen'
						),
						'item' => array(
								  
							array('type'        => 'divider',
								  'format'      => 'gallery'),
								  
							// Show Feature Image
							array('title'       => esc_html__('Show Feature Image','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_gallery_show_feature_image',
								  'format'      => 'gallery',
								  'default'     => 'false'))),
					
					array(
						'super-control' => array(
							'name'  => 'theme_meta_gallery_template',
							'value' => 'standard|big-title|slider|fullscreen'
						),
						'item' => array(
								  
							// Brightness of Featured Image
							array('title'       => esc_html__('Brightness of Featured Image','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_gallery_brightness',
								  'format'      => 'gallery',
								  'default'     => 'dark-logo',
								  'col_size'    => 'width:50%;'))),
					
					array(
						'super-control' => array(
							'name'  => 'theme_meta_gallery_template',
							'value' => 'fullscreen'
						),
						'item' => array(
								  
							// Colour for Logo & Menu Button
							array('title'       => esc_html__('Colour for Logo & Menu Button','arnold'),
								  'description' => '',
								  'type'        => 'select',
								  'name'        => 'theme_meta_gallery_colour_for_text',
								  'format'      => 'gallery',
								  'default'     => 'dark-logo',
								  'col_size'    => 'width:50%;'))),

					array(
						'super-control' => array(
							'name'  => 'theme_meta_gallery_template',
							'value' => 'standard|big-title|slider|fullscreen'
						),
						'item' => array(
								  
							array('type'        => 'divider',
								  'format'      => 'gallery'),

							// Enable Shopping Function
							array('title'       => esc_html__('Enable Shopping Function','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'format'      => 'gallery',
								  'name'        => 'theme_meta_enable_shopping_function',
								  'default'     => 'false'),

							// Select a Product to Associate
							array('title'       => esc_html__('Select a Product to Associate','arnold'),
								  'description' => '',
								  'type'        => 'auto-select',
								  'format'      => 'gallery',
								  'name'        => 'theme_meta_shopping_select_product',
								  'control'     => array('name'  => 'theme_meta_enable_shopping_function',
														 'value' => 'true'))
						)
					),
					
					// array(
					// 	'super-control' => array(
					// 		'name'  => 'theme_meta_gallery_template',
					// 		'value' => 'pagebuilder'
					// 	),
					// 	'item' => array(
								  
					// 		// Show Feature Image
					// 		array('title'       => esc_html__('Show Feature Image','arnold'),
					// 			  'description' => '',
					// 			  'type'        => 'switch',
					// 			  'name'        => 'theme_meta_gallery_pb_show_feature_image',
					// 			  'format'      => 'gallery',
					// 			  'default'     => 'false'),
								  
					// 		// Colour for Logo & Menu Button
					// 		array('title'       => esc_html__('Colour for Logo & Menu Button','arnold'),
					// 			  'description' => '',
					// 			  'type'        => 'select',
					// 			  'name'        => 'theme_meta_gallery_pb_colour_for_text',
					// 			  'format'      => 'gallery',
					// 			  'default'     => 'dark',
					// 			  'col_size'    => 'width:50%;'))),
					
					
					
				
					
											
				)
			)
		),
		
		/* Jobs Meta */
		'jobs_item' => array(
			array(
				'id'      => 'jobs-meta',
				'title'   => esc_html__('Jobs Meta','arnold'),
				'section' => array(
					
					array(/* Jobs Meta */
						'item' => array(
							
							// Location
							array('title'       => esc_html__('Location','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_jobs_location'),
								
							// Number
							array('title'       => esc_html__('Number','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_jobs_number'))))
			)
		),
		
		/* Testimonials Meta */
		'testimonials_item' => array(
			array(
				'id'      => 'testimonials-meta',
				'title'   => esc_html__('Testimonials Meta','arnold'),
				'section' => array(
				
					array(/* Testimonials Meta */
						'item' => array(
							
							// Testimonial Cite
							array('title'       => esc_html__('Testimonial Cite','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_testimonial_cite'),
								  
							// Position
							array('title'       => esc_html__('Position','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_testimonial_position'),
								  
							// Link
							array('title'       => esc_html__('Link','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_testimonial_link_title',
								  'placeholder' => esc_html__('Title','arnold'),
								  'col_style'   => 'width:30%;margin-right:5%;float:left;',
								  'bind'        => array(
									  array('type'        => 'text',
											'name'        => 'theme_meta_testimonial_link',
											'position'    => 'after',
											'placeholder' => esc_html__('Link','arnold'),
											'col_style'   => 'width:65%;float:left;'))))))
			)
		),
		
		/* Clients Meta */
		'clients_item' => array(
			array(
				'id' => 'clients-meta',
				'title' => esc_html__('Clients Meta','arnold'),
				'section' => array(
				
					array(/* Clients Meta */
						'item' => array(
							
							//Client Link
							array('title'       => esc_html__('Client Link','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_client_link'))))
			)
		),
		
		/* Team Meta */
		'team_item' => array(
			array(
				'id' => 'team-meta',
				'title' => esc_html__('Team Meta','arnold'),
				'section' => array(
					
					array(/* Team Meta */
						'item' => array(
							
							//use team template
							array('title'       => esc_html__('use team template','arnold'),
								  'description' => '',
								  'type'        => 'switch',
								  'name'        => 'theme_meta_enable_team_template',
								  'default'     => 'true'))),
					
					
					array(/* Sidebar */
						'super-control' => array(
							'name'  => 'theme_meta_enable_team_template',
							'value' => 'false'
						),
						'item' => array(
							
							// Sidebar
							array('title'       => esc_html__('Sidebar','arnold'),
								  'description' => '',
								  'type'        => 'image-select',
								  'name'        => 'theme_meta_sidebar',
								  'size'        => '126:80',
								  'default'     => 'without-sidebar',
								  'bind'        => array(
									  array('type'     => 'select',
											'name'     => 'theme_meta_sidebar_widgets',
											'col_size' => 'width:200px;',
											'position' => 'after') )),
								  
							array('type'        => 'divider'))),
					
					
					array(/** Team Template is true */
						'super-control' => array(
							'name'  => 'theme_meta_enable_team_template',
							'value' => 'true'
						),
						'item' => array(
							
							// Position
							array('title'       => esc_html__('Position','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_team_position'),
								  
							// Email
							array('title'       => esc_html__('Email','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_team_email'),
								  
							// Phone Number
							array('title'       => esc_html__('Phone Number','arnold'),
								  'description' => '',
								  'type'        => 'text',
								  'name'        => 'theme_meta_team_phone_number'),
								  
							// Social Networks
							array('title'       => esc_html__('Social Networks','arnold'),
								  'description' => '',
								  'type'        => 'new-social-medias',
								  'name'        => 'theme_meta_team_social_medias'))))
			)
		)
	);
	$arnold_theme_post_meta_fields = apply_filters('ux_theme_post_meta_fields', $arnold_theme_post_meta_fields);
	return $arnold_theme_post_meta_fields;
}

//Shape for Masonry Grid List
function arnold_add_posts_meta_box($post){
    add_meta_box(
        'gallery_shape_for_masonry_grid_list_gallery', esc_html__( 'Shape for Masonry Grid List', 'arnold' ),
        'arnold_theme_post_meta_gallery_side_interface',
        'post', 'side', 'low'
    );
}
//add_action( 'add_meta_boxes_post', 'arnold_add_posts_meta_box' );

//require theme meta interface
require_once get_template_directory() . '/functions/theme/post/post-meta-interface.php';
?>