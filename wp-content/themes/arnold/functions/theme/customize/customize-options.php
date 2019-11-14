<?php
//ux customize controls scripts
function arnold_theme_customize_controls_scripts(){
	wp_enqueue_script('arnold-admin-customize-controls');
}
add_action('customize_controls_print_scripts', 'arnold_theme_customize_controls_scripts');

//ux customize controls styles
function arnold_theme_customize_controls_styles(){
	wp_enqueue_style('style-customize', arnold_THEME . '/css/customize-controls.css');
}
add_action('customize_controls_enqueue_scripts', 'arnold_theme_customize_controls_styles');

//ux customize register
function arnold_theme_customize_register($wp_customize){
	
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	
	$wp_customize->remove_section('themes');
	
	$theme_config_fields = arnold_theme_options_config_fields();
	if($theme_config_fields){
		foreach($theme_config_fields as $config){
			if($config['id'] == 'options-schemes' && isset($config['section'])){
				foreach($config['section'] as $section){
					if($section['id'] != 'color-scheme' && isset($section['item'])){
						$section_title = isset($section['title']) ? $section['title'] : false;
						$section_id    = isset($section['id']) ? $section['id'] : false;
						
						$key = 900;
						$wp_customize->add_setting($section_id, array(
							'default'           => '',
							'capability'        => 'edit_theme_options',
							'type'              => 'option',
							'sanitize_callback' => 'sanitize_text_field'
						));
						
						$wp_customize->add_control(new arnold_Customize_Heading_Control($wp_customize, 
							$section_id, array(
								'type' => 'arnold-heading',
								'label' => $section_title,
								'section' => 'colors')
						));
						
						foreach($section['item'] as $item){
							$item_title   = isset($item['title']) ? $item['title'] : false;
							$item_name    = isset($item['name']) ? $item['name'] : false;
							$item_default = isset($item['default']) ? $item['default'] : false;
							$item_type    = isset($item['type']) ? $item['type'] : false;
							$scheme_name  = isset($item['scheme-name']) ? $item['scheme-name'] : false;
							
							switch($item_type){
								case 'switch-color': 
								
									$wp_customize->add_setting('ux_theme_option[' . $item_name . ']', array(
										'default'           => $item_default,
										'sanitize_callback' => 'sanitize_hex_color',
										'capability'        => 'edit_theme_options',
										'transport'         => 'postMessage',
										'type'              => 'option'
								 
									));
								 
									$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 
										$scheme_name, array(
											'label'    => $item_title,
											'section'  => 'colors',
											'settings' => 'ux_theme_option[' . $item_name . ']')
									));
									
								break;
								
								case 'upload':
								
									$wp_customize->add_setting('ux_theme_option[' . $item_name . ']', array(
										'default'           => $item_default,
										'capability'        => 'edit_theme_options',
										'transport'         => 'postMessage',
										'type'              => 'option',
										'sanitize_callback' => 'sanitize_text_field'
									));
								 
									$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,
										$scheme_name, array(
											'label'    => $item_title,
											'section'  => 'colors',
											'settings' => 'ux_theme_option[' . $item_name . ']')
									));
								
								break;
								
								case 'select':
								
									$wp_customize->add_setting('ux_theme_option[' . $item_name . ']', array(
										'default'           => $item_default,
										'capability'        => 'edit_theme_options',
										'transport'         => 'postMessage',
										'type'              => 'option',
										'sanitize_callback' => 'sanitize_text_field'
									));
									
									$wp_customize->add_control($scheme_name, array(
										'settings' => 'ux_theme_option[' . $item_name . ']',
										'label'    => $item_title,
										'section'  => 'colors',
										'type'     => 'select',
										'choices'  => arnold_theme_customize_select_fields($item_name)
									));
								
								break;
							}
						}
					}
				}
			}
		}
	}
	
	//ux customize live preview function action
	if($wp_customize->is_preview()){
		add_action('wp_footer', 'arnold_theme_customize_preview', 21);
	}
}
add_action('customize_register', 'arnold_theme_customize_register');

//ux customize jquery live preview
function arnold_theme_customize_preview(){ ?>
	<script type="text/javascript">
		(function($){
			//Main Colors
			//Theme Main Color
			wp.customize('ux_theme_option[theme_option_color_theme_main]', function(value){
				value.bind(function(val){
					$('a, #header .socialmeida-a:hover, #header .search-top-btn-class:hover,#header .wpml-translation li a:hover,#header .wpml-translation li .current-language, .current-language .languages-shortname,.comment-form .logged a:hover,.article-cate-a,.count-box,.social-like .wpulike .counter a.image:before,.post-meta-social .count, .height-light-ux,.post-categories a,.widget_archive li,.widget_categories li,.widget_nav_menu li,.widget_pages li,a:hover,.entry p a,.sidebar_widget a:hover,#footer a:hover,.archive-tit a:hover,.text_block a,.post_meta > li a:hover, #sidebar a:hover, #comments .comment-author a:hover,#comments .reply a:hover,.fourofour-wrap a,.archive-meta-unit a:hover,.post-meta-unit a:hover, .heighlight,.archive-meta-item a,.author-name,.carousel-wrap a:hover, .related-post-wrap h3:hover a, .iconbox-a .iconbox-h3:hover,.iconbox-a:hover,.iocnbox:hover .icon_wrap i.fa,.blog-masony-item .item-link:hover:before,.clients_wrap .carousel-btn .carousel-btn-a:hover:before,.blog_meta a:hover,.breadcrumbs a:hover,.link-wrap a:hover,.archive-wrap h3 a:hover,.more-link:hover,.post-color-default,.latest-posts-tags a:hover,.pagenums .current,.page-numbers.current,.fullwidth-text-white .fullwrap-with-tab-nav-a:hover,.fullwrap-with-tab-nav-a:hover,.fullwrap-with-tab-nav-a.full-nav-actived,.fullwidth-text-white .fullwrap-with-tab-nav-a.full-nav-actived,a.liquid-more-icon.ux-btn:hover,.moudle .iterblock-more.ux-btn:hover,.gallery-info-property-con a,.tp-caption a:hover ').css('color', val);
					$('.tagcloud a:hover,.related-post-wrap h3:before,.single-image-mask,input.idi_send:hover, .iconbox-content-hide .icon_text,.process-bar, .portfolio-caroufredsel-hover').css('background-color', val);
				});
			});

			// Auxiliary Color
			wp.customize('ux_theme_option[theme_option_color_second_auxiliary]', function(value){
				value.bind(function(val){
					$('.tagcloud a,.gallery-list-contiune, .author-unit-inn, .archive-bar,.blog-unit-link-li,.blog-unit-quote,.slider-panel,#main_title_wrap, .promote-wrap,.process-bar-wrap,.post_meta,.pagenumber a,.standard-blog-link-wrap,.blog-item.quote,.portfolio-standatd-tit-wrap:before,.quote-wrap,.entry pre,.text_block pre,.isotope-item.quote .blog-masony-item,.blog-masony-item .item-link-wrap,.pagenumber span,.testimenials,.testimenials .arrow-bg,.accordion-heading,.testimonial-thum-bg,.single-feild,.fullwidth-text-white .iconbox-content-hide .icon_wrap').css('background-color', val);
					$('.progress_bars_with_image_content .bar .bar_noactive.grey').css('color', val);
					$('body.archive #wrap,.widget_archive li,.widget_categories li,.widget_nav_menu li,.widget_pages li,.widget_recent_entries li,.widget_recent_comments li,.widget_meta li,.widget_rss li,		.nav-tabs,.border-style2,.border-style3,.nav-tabs > li > a,.tab-content,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tabs-v,.single-feild,.archive-unit').css('border-color', val);
					$('.tab-content.tab-content-v,blockquote').css('border-left-color', val);
					$('.tabs-v .nav-tabs > .active > a,.line_grey').css('border-top-color', val);
				});
			});

			//Page Bg Color
			wp.customize('ux_theme_option[theme_option_bg_page_post]', function(value){
				value.bind(function(val){
					$('body,#wrap-outer,#wrap,#search-overlay,#top-wrap,#main,.separator h4, .carousel-control,#login-form.modal .modal-dialog,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tab-content,.filters.filter-floating li a:before,.standard-list-item:hover .portfolio-standatd-tit-wrap:before,.ux-mobile #main-navi-inn').css('background-color', val);
					$('.testimenials span.arrow,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus').css('border-bottom-color', val);
					$('.tabs-v .nav-tabs > .active > a').css('border-right-color', val);
					$('.quote-wrap, .mouse-icon, #search-result .pagenums .tw-style-a:hover, .moudle .ux-btn.tw-style-a:hover, .ux-btn:hover,input[type="submit"]:hover,button:hover, .social-icon-triggle, .carousel-control,.moudle .ux-btn:before, .countdown_amount,.countdown_section,.blog-unit-link-li:hover,.blog-unit-link-li:hover a').css('color', val);
				});
			});

			//Header BG color
			wp.customize('ux_theme_option[theme_option_bg_header]', function(value){
				value.bind(function(val){
					$('#header,#menu-panel,.page_from_top.header-scrolled #header,#navi-header .sub-menu').css('background-color', val);
				});
			});

			//PageLoader BG color
			wp.customize('ux_theme_option[theme_option_bg_page_loader]', function(value){
				value.bind(function(val){
					$('.page-loading').css('background-color', val);
				});
			});

			//Selected Text Bg Color
			wp.customize('ux_theme_option[theme_option_color_selected_text_bg]', function(value){
				value.bind(function(val){
					$('::selection').css('background', val);
					$('::-moz-selection').css('background', val);
					$('::-webkit-selection').css('background', val);
				});
			});
			
			//Logo Color
			wp.customize('ux_theme_option[theme_option_color_logo]', function(value){
				value.bind(function(val){
					$('.logo-h1 ').css('color', val);
				});
			});
			
			//Logo Text Color Light
			wp.customize('ux_theme_option[theme_option_logo_text_color_light]', function(value){
				value.bind(function(val){
					$('.light-logo .logo-h1,.default-light-logo .logo-h1').css('color', val);
				});
			});
			
			//Menu on Header Dark
			wp.customize('ux_theme_option[theme_option_menu_icon_dark]', function(value){
				value.bind(function(val){
					$('#navi-trigger,#header .socialmeida-a,#navi_wrap > ul > li > a,.light-logo.header-scrolled #navi-trigger,.light-logo.header-scrolled #header .socialmeida-a,.light-logo.header-scrolled #navi_wrap > ul > li > a ').css('color', val);
				});
			});
			
			//Menu on Header Light
			wp.customize('ux_theme_option[theme_option_menu_icon_light]', function(value){
				value.bind(function(val){
					$('.light-logo #navi-trigger,.default-light-logo #navi-trigger,.light-logo #header .socialmeida-a,.default-light-logo .socialmeida-a,.light-logo #navi_wrap > ul > li > a,.default-light-logo #navi_wrap > ul > li > a,.light-logo.single-portfolio-fullscreen-slider .blog-unit-gallery-wrap .arrow-item, .default-light-logo.single-portfolio-fullscreen-slider .blog-unit-gallery-wrap .arrow-item,.light-logo #ux-slider-down, .default-light-logo #ux-slider-down,.light-logo.single-portfolio-fullscreen-slider .owl-dots, .default-light-logo.single-portfolio-fullscreen-slider .owl-dots').css('color', val);
				});
			});
			
			//Heading Text Color
			wp.customize('ux_theme_option[theme_option_color_heading]', function(value){
				value.bind(function(val){
					$('.title-wrap-tit,.title-wrap-h1,h1,h2,h3,h4,h5,h6,.archive-tit a, .item-title-a,#sidebar .social_active i:hover,.article-cate-a:hover:after,.portfolio-standatd-tags a[rel="tag"]:hover:after,.nav-tabs > .active > a, .nav-tabs > li > a:hover, .nav-tabs > .active > a:focus, .post-navi-a,.moudle .ux-btn,.mainlist-meta, .mainlist-meta a,carousel-des-wrap-tit-a,.jqbar.vertical span,.team-item-con-back a,.team-item-con-back i,.team-item-con-h p,.slider-panel-item h2.slider-title a,.bignumber-item.post-color-default,.blog-item .date-block,.iterlock-caption-tit-a,.clients_wrap .carousel-btn .carousel-btn-a, .image3-1-unit-tit').css('color', val);
					$('.post_social:before, .post_social:after,.title-ux.line_under_over,.gallery-wrap-sidebar .entry, .social-share').css('border-color', val);
					$('.team-item-con,.ux-btn:before,.title-ux.line_both_sides:before,.title-ux.line_both_sides:after,.galleria-info,#float-bar-triggler,.float-bar-inn,.short_line:after,.separator_inn.bg- ,.countdown_section').css('background-color', val); 
				});
			});
			
			//Content Text Color
			wp.customize('ux_theme_option[theme_option_color_content_text]', function(value){
				value.bind(function(val){
					$('body,a,.entry p a:hover,.text_block, .article-tag-label a[rel="tag"]:after,.article-meta-unit-cate > a.article-cate-a:after,.article-cate-a:hover,.text_block a:hover,#content_wrap,#comments,.blog-item-excerpt,.archive-unit-excerpt,.archive-meta-item a:hover,.entry code,.text_block code,h3#reply-title small, #comments .nav-tabs li.active h3#reply-title .logged,#comments .nav-tabs li a:hover h3 .logged,.testimonial-thum-bg i.fa,.header-info-mobile,.carousel-wrap a.disabled:hover,.stars a:hover,.moudle .iterblock-more.ux-btn,.moudle .liquid-more-icon.ux-btn,.fullwrap-block-inn a').css('color', val);
					$('.blog-unit-link-li:hover').css('background-color', val);
				});
			});
			
			//Auxiliary Text Color
			wp.customize('ux_theme_option[theme_option_color_auxiliary_content]', function(value){
				value.bind(function(val){
					$('.article-meta-unit,.article-meta-unit:not(.article-meta-unit-cate) > a,.article-tag-label-tit, .comment-meta,.comment-meta a,.title-wrap-des,.blog_meta_cate,.blog_meta_cate a').css('color', val);
					$('.blog-item-more-a:hover,.audio-unit').css('border-color', val);
					$('.comment-author:after').css('background-color', val);
				});
			});
			
			//Gallery Post Property Title
			wp.customize('ux_theme_option[theme_option_color_property_tit]', function(value){
				value.bind(function(val){
					$('.gallery-info-property-tit').css('color', val);
				});
			});

			//Gallery Post Property Content
			wp.customize('ux_theme_option[theme_option_color_property_con]', function(value){
				value.bind(function(val){
					$('.gallery-info-property-con,.gallery-info-property-con a:hover ').css('color', val);
				});
			});

			//Gallery Post Link
			wp.customize('ux_theme_option[theme_option_color_gallery_link]', function(value){
				value.bind(function(val){
					$('.gallery-link-a').css('color', val);
				});
			});

			//Gallery Post Prev Next
			wp.customize('ux_theme_option[theme_option_color_gallery_navi]', function(value){
				value.bind(function(val){
					$('.post-navi-single, .arrow-item').css('color', val);
				});
			});

			//Comment Title
			wp.customize('ux_theme_option[theme_option_color_comment_tit]', function(value){
				value.bind(function(val){
					$('.comment-box-tit,.comm-reply-title').css('color', val);
				});
			});

			//Comment Content
			wp.customize('ux_theme_option[theme_option_color_comment_con]', function(value){
				value.bind(function(val){
					$('.comm-u-wrap').css('color', val);
				});
			});

			//Comment Author
			wp.customize('ux_theme_option[theme_option_color_comment_author]', function(value){
				value.bind(function(val){
					$('.comment-meta .comment-author,.comment-meta .comment-author-a').css('color', val);
				});
			});

			//Portfolio list  Title for item
			wp.customize('ux_theme_option[theme_option_color_list_item_tit]', function(value){
				value.bind(function(val){
					$('.grid-item-tit,.grid-item-tit-a:hover').css('color', val);
				});
			});

			//Portfolio list  Tag for item
			wp.customize('ux_theme_option[theme_option_color_list_item_tag]', function(value){
				value.bind(function(val){
					$('.grid-item-cate-a').css('color', val);
				});
			});

			//Portfolio list  Mask for item
			wp.customize('ux_theme_option[theme_option_color_list_item_mask]', function(value){
				value.bind(function(val){
					$('.grid-item-con:after').css('background-color', val);
				});
			});

			//Button Text & Border Color
			wp.customize('ux_theme_option[theme_option_color_button]', function(value){
				value.bind(function(val){
					$('.ux-btn, button, input[type="submit"]').css('color', val);
				});
			});

			//Button Text Mouseover Color
			wp.customize('ux_theme_option[theme_option_color_button_mouseover]', function(value){
				value.bind(function(val){
					$('.ux-btn:hover,button:hover, input[type="submit"]:hover,.moudle .ux-btn.tw-style-a:hover,.moudle .ux-btn:before').css('color', val);
				});
			});

			//Button BG Mouseover Color
			wp.customize('ux_theme_option[theme_option_color_button_bg_mouseover]', function(value){
				value.bind(function(val){
					$('.ux-btn:hover,button:hover, input[type="submit"]:hover').css('background-color', val);
				});
			});

			//Text Input Box by Default
			wp.customize('ux_theme_option[theme_option_color_form]', function(value){
				value.bind(function(val){
					$('textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input').css('background-color', val);
				});
			});

			//Text Input Box Focused
			wp.customize('ux_theme_option[theme_option_color_form_focused]', function(value){
				value.bind(function(val){
					$('.moudle input[type="text"]:focus, .moudle textarea:focus, input:focus:invalid:focus, textarea:focus:invalid:focus, select:focus:invalid:focus, textarea:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus, .uneditable-input:focus,.comment-reply-title:hover').css('background-color', val);
				});
			});

			// Widget Title Color
			wp.customize('ux_theme_option[theme_option_color_sidebar_widget_title]', function(value){
				value.bind(function(val){
					$('.widget-container .widget-title, .widget-container .widget-title a').css('color', val);
				});
			});
			
			// Widget Content Color
			wp.customize('ux_theme_option[theme_option_color_sidebar_content_color]', function(value){
				value.bind(function(val){
					$('.widget-container,.widget-container a').css('color', val);
				});
			});

			// Sidebar Widget Title Text Color
			wp.customize('ux_theme_option[theme_option_color_widget_title_sidebar]', function(value){
				value.bind(function(val){
					$('.sidebar_widget .widget-container .widget-title,.sidebar_widget .widget-container .widget-title a').css('color', val);
				});
			});

			// Sidebar Widget Title Bg Color
			wp.customize('ux_theme_option[theme_option_color_widget_title_bg]', function(value){
				value.bind(function(val){
					$('.sidebar_widget .widget-title').css('background-color', val);
				});
			});

			
			//Footer Text Color
			wp.customize('ux_theme_option[theme_option_footer_text_color]', function(value){
				value.bind(function(val){
					$('.copyright, .copyright a,.footer-info,.footer-info a,#footer .logo-h1').css('color', val);
				});
			});

			//Footer bg Color
			wp.customize('ux_theme_option[theme_option_footer_bg_color]', function(value){
				value.bind(function(val){
					$('#footer').css('background-color', val);
				});
			});

		})(jQuery);
	</script>
<?php
}

//ux customize select fields
function arnold_theme_customize_select_fields($name){
	$config_select_fields = arnold_theme_options_config_select_fields();
	
	$select_fields = array();
	if(isset($config_select_fields[$name])){
		foreach($config_select_fields[$name] as $select){
			$select_fields[$select['value']] = $select['title'];
		}
	}
	
	return $select_fields;
}

if( !class_exists( 'arnold_Customize_Heading_Control' ) && class_exists( 'WP_Customize_Control' ) ) {

	class arnold_Customize_Heading_Control extends WP_Customize_Control {

		public $type = 'arnold-heading';

		public function render_content(){ ?>
			<div id="arnold-customize-control-<?php echo esc_attr( $this->id ); ?>" class="customize-control arnold-customize-control-<?php echo esc_attr( str_replace( 'layers-', '', $this->type ) ); ?>">
				
                <hr />
                
				<?php if ( '' != $this->label ) { ?>
					<h2 class="customize-control-title"><?php echo esc_attr($this->label); ?></h2>
				<?php } ?>

				<?php if ( '' != $this->description ) : ?>
					<div class="description customize-control-description">
						<?php echo esc_attr($this->description); ?>
					</div>
				<?php endif; ?>

			</div>
		<?php }
	}
}
?>