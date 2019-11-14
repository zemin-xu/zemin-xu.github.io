<?php
//theme color
if(!function_exists('ux_theme_switch_color')){
	function ux_theme_switch_color($key, $to='value'){
		$theme_color = ux_theme_color();
		$return = false;
		foreach($theme_color as $color){
			if($color['id'] == $key){
				$return = $color[$to];
			}
		}
		return $return;
	}
}

//pagebuilder color
if(!function_exists('ux_theme_color')){
	function ux_theme_color(){
		$theme_color = array(
			array('id' => 'color1', 'value' => 'theme-color-1', 'rgb' => '#F9885C'),
			array('id' => 'color2', 'value' => 'theme-color-2', 'rgb' => '#BD9DD1'),
			array('id' => 'color3', 'value' => 'theme-color-3', 'rgb' => '#F1A1C3'),
			array('id' => 'color4', 'value' => 'theme-color-4', 'rgb' => '#92C3E3'),
			array('id' => 'color5', 'value' => 'theme-color-5', 'rgb' => '#5B6A81'),
			array('id' => 'color6', 'value' => 'theme-color-6', 'rgb' => '#858687'),
			array('id' => 'color7', 'value' => 'theme-color-7', 'rgb' => '#69CE9B'),
			array('id' => 'color8', 'value' => 'theme-color-8', 'rgb' => '#fbd44d'),
			array('id' => 'color9', 'value' => 'theme-color-9', 'rgb' => '#c9b69d'),
			array('id' => 'color10', 'value' => 'theme-color-10', 'rgb' => '#313139')
		);	

		//color 1-10
		for($color_num=1;$color_num<=10;$color_num++){
			$featured_color = ux_get_option('theme_option_featured_color_' .$color_num);
			if($featured_color){
				$i = $color_num - 1;
				$theme_color[$i]['rgb'] = $featured_color;
			}
		}
		
		return $theme_color;
	}
}

//ux theme hide category
if(!function_exists('ux_theme_hide_category')){
	function ux_theme_hide_category($separator= '', $class=''){
		$hide_category = ux_get_option('theme_option_hide_category_on_post_page');
		if(!$hide_category){
			$hide_category = array();
		}
		$categories = get_the_category();
		$output = '';
		if($categories){
			foreach($categories as $category){
				if(!in_array($category->term_id, $hide_category)){
					$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'ux' ), $category->name ) ) . '" class="' .sanitize_html_class($class). '">'.$category->cat_name.'</a>'.$separator;
				}
			}
			echo trim($output, $separator);
		} 
	}
	add_action('ux_interface_loop_the_category', 'ux_theme_hide_category', 10);
}

//Function theme get option
if(!function_exists('ux_get_option')){
	function ux_get_option($key){
		$get_option = get_option('ux_theme_option');
		$return = false;
		
		if($get_option){
			if(isset($get_option[$key])){
				if($get_option[$key] != ''){
					switch($get_option[$key]){
						case 'true': $return = true; break;
						case 'false': $return = false; break;
						default: $return = $get_option[$key]; break;
					}
				}
			}else{
				switch($key){
					case 'theme_option_enable_fadein_effect': $return = true; break;
					case 'theme_option_enable_search_field': $return = true; break;
					case 'theme_option_enable_search_button': $return = true; break;
					case 'theme_option_enable_meta_post_page': $return = true; break;
					case 'theme_option_posts_showmeta': $return = array('date', 'length', 'category', 'tag', 'author', 'comments'); break;
					case 'theme_option_mobile_enable_responsive': $return = true; break;
					case 'theme_option_enable_share_buttons_for_posts': $return = true; break;
					case 'theme_option_share_buttons': $return = array('facebook', 'twitter', 'google-plus', 'pinterest'); break;
					case 'theme_option_enable_footer_widget_for_pages': $return = true; break;
					case 'theme_option_show_post_author_information': $return = true; break;
					case 'theme_option_show_post_navigation': $return = true; break;
					case 'theme_option_show_related_post': $return = true; break;
					case 'theme_option_show_social_in_menu_panle': $return = true; break;
					case 'theme_option_enable_header_sticky_top': $return = true; break;
					case 'theme_option_hide_category_on_post_page': $return = array(); break;
					
				}
			}
		}
		
		return $return;
	}
}

//Function blog show meta
if(!function_exists('ux_interface_blog_show_meta')){
	function ux_interface_blog_show_meta($meta, $container = false, $this_postid = false, $module_post = false){
		$showmeta = array('date', 'category', 'tag', 'author', 'continue-reading');;
		
		if(is_single()){
			$showmeta = ux_get_option('theme_option_posts_showmeta');
		}
		
		/*if(is_archive()||is_home()){
			$showmeta = array('date', 'category', 'tag', 'author', 'continue-reading');
		}*/
		
		if(is_page()){
			$showmeta = array('date', 'author');
		}
		
		if($module_post){ 
			$get_this_meta = get_post_meta($module_post, 'module_blog_posts_showmeta', true);
			$get_blog_type = get_post_meta($module_post, 'module_blog_type', true);
			
			if($get_blog_type == 'big_image_list'){
				$get_this_meta = get_post_meta($module_post, 'module_blog_show_meta_below_title_feature', true);
			}
			
			if(is_array($get_this_meta)){
				$showmeta = $get_this_meta;
			}else{
				$showmeta = array($get_this_meta);
			}
		}
		
		if(count($showmeta)){
			//date
			if($meta == 'date' && in_array($meta, $showmeta)){
				if($container == 'single'){
					echo '<span class="article-meta-unit article-meta-date">' .get_the_date(). '</span>';
				}elseif($container == 'title'){
					echo '<span class="title-wrap-meta-b-item article-meta-date">' .get_the_date(). '</span>';
				}elseif($container == 'article'){
					echo '<span class="article-meta-date">' .get_the_date(). '</span>';
				}
			}
			
			//length
			if($meta == 'length' && in_array($meta, $showmeta)){
				$pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
				$read_length = ux_get_post_meta(get_the_ID(), 'theme_meta_post_length');
	
				if($read_length) {
	
					if($container == 'single'){
						echo '<span class="article-meta-unit">' .esc_html($read_length). ' ' .esc_html__(' MIN READ','ux'). '</span>';
					}elseif($container == 'navi'){
						echo '<div class="post-navi-meta">' .esc_html($read_length). ' ' .esc_html__(' MIN READ','ux'). '</div>';
					}elseif($container == 'title'){
						echo '<span class="title-wrap-meta-b-item">' .esc_html($read_length). ' ' .esc_html__(' MIN READ','ux'). '</span>';
					}elseif($container == 'article'){
						echo esc_html($read_length). ' ' .esc_html__(' MIN READ','ux');
					}
	
				}else{
					if($pb_switch != 'pagebuilder'){
						
						if($container == 'single'){
							echo '<span class="article-meta-unit">' .esc_html(ux_interface_blog_min_read()). ' ' .esc_html__(' MIN READ','ux'). '</span>';
						}elseif($container == 'navi'){
							echo '<div class="post-navi-meta">' .esc_html(ux_interface_blog_min_read($this_postid)). ' ' .esc_html__(' MIN READ','ux'). '</div>';
						}elseif($container == 'title'){
							echo '<span class="title-wrap-meta-b-item">' .esc_html(ux_interface_blog_min_read()). ' ' .esc_html__(' MIN READ','ux'). '</span>';
						}elseif($container == 'article'){
							echo esc_html(ux_interface_blog_min_read()). ' ' .esc_html__(' MIN READ','ux');
						}
					}
				}
			}
			
			//category
			if($meta == 'category' && in_array($meta, $showmeta) && has_category()){
				if($container == 'single'){
					echo '<span class="article-meta-unit">' .esc_attr__('IN: ','ux'); ux_theme_hide_category(', '); echo '</span>';
				}elseif($container == 'title'){
					ux_theme_hide_category(', ');
				}elseif($container == 'article'){
					echo esc_attr__('IN: ','ux');
					ux_theme_hide_category(', ', 'mainlist-meta-a');
				}
			}
			
			//tag
			if($meta == 'tag' && in_array($meta, $showmeta) && has_tag()){
				if($container == 'single'){
					echo '<span class="article-meta-unit">' .esc_attr__('TAGS: ','ux'); the_tags(', '); echo '</span>';
				}elseif($container == 'title'){
					echo '<span class="title-wrap-meta-b-item">' .esc_attr__('TAGS: ','ux'); the_tags(', '); echo '</span>';
				}elseif($container == 'article'){
					echo esc_attr__('TAGS: ','ux');
					$posttags = get_the_tags();
					$separator = ', ';
					$output = '';
					if($posttags){
						foreach($posttags as $tag) {
							$output .= '<a href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s","ux" ), $tag->name ) ) . '" class="mainlist-meta-a">'.$tag->name.'</a>'.$separator;
						}
					echo trim($output, $separator);
					}
				}
			}
			
			//author
			if($meta == 'author' && in_array($meta, $showmeta)){
				if($container == 'single'){
					echo '<span class="article-meta-unit">' .esc_attr__('BY: ','ux'); the_author_link(); echo '</span>';
				}elseif($container == 'title'){
					echo '<span class="title-wrap-meta-b-item">' .esc_attr__('BY: ','ux'); the_author_link(); echo '</span>';
				}elseif($container == 'article'){
					echo esc_attr__('BY: ','ux'); the_author_link();
				}
			}
			
			//comments
			if($meta == 'comments' && in_array($meta, $showmeta)){
				$comments_count = wp_count_comments(get_the_ID());
				if($container == 'single'){ ?>
					<span class="article-meta-unit"><?php comments_number(esc_attr__('0 COMMENT', "ux"), esc_attr__('1 COMMENT', "ux"), esc_attr__('% COMMENTS', "ux") ); ?></span>
				<?php
				}elseif($container == 'title'){ ?>
					<span class="title-wrap-meta-b-item"><?php comments_number(esc_attr__('0 COMMENT', "ux"), esc_attr__('1 COMMENT', "ux"), esc_attr__('% COMMENTS', "ux") ); ?></span>
				<?php
				}elseif($container == 'article'){
					comments_number(esc_attr__('0 COMMENT', "ux"), esc_attr__('1 COMMENT', "ux"), esc_attr__('% COMMENTS', "ux") );
				}
			}
			
			//Continue Reading
			if($meta == 'continue-reading' && in_array($meta, $showmeta)){
				if($container == 'single'){
					echo '<div class="blog-unit-more"><a href="' .get_permalink(). '" class="blog-unit-more-a"><span class="blog-unit-more-txt">' .esc_html__('Continue Reading','ux'). '</span> <span class="fa fa-long-arrow-right"></span></a></div>';
				}
			}		
		}
	}
}

//theme interface get post meta
if(!function_exists('ux_get_post_meta')){
	function ux_get_post_meta($post_id, $key){
		$get_post_meta = get_post_meta($post_id, 'ux_theme_meta', true);
		$return = false;
		
		if($get_post_meta){
			if(isset($get_post_meta[$key])){
				if($get_post_meta[$key] != ''){
					switch($get_post_meta[$key]){
						case 'true': $return = true; break;
						case 'false': $return = false; break;
						default: $return = $get_post_meta[$key]; break;
					}
				}
			}
		}
		
		return $return;
	}
}

//Function blog show meta
if(!function_exists('ux_interface_blog_min_read')){
	function ux_interface_blog_min_read($post_id = false){
		$time = 2;
		$content = get_the_content();
		
		if($post_id){
			global $post;
			$post = get_post($post_id);
			setup_postdata($post);
			$content = get_the_content();
			wp_reset_postdata(); 
		}
		
		if($content){
			$length = mb_strlen($content);
			$time = $length / 200;
		}
		
		return ceil($time);
	}
}

//theme icons
if(!function_exists('ux_theme_icons_fields')){
	function ux_theme_icons_fields(){
	
		// Fontawesome icons list
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$fontawesome_path =  UX_PAGEBUILDER_PLUGINS . '/css/font-awesome.min.css';
		if( file_exists( $fontawesome_path ) ) {
			if(!class_exists('WP_Filesystem_Direct')){
				require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
				require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');
			}
			$wp_filesystem = new WP_Filesystem_Direct('');
			@$subject = $wp_filesystem->get_contents($fontawesome_path);
		}
		
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
		
		$icons = array();
		
		foreach($matches as $match){
			//$icons[$match[1]] = $match[2];
			array_push($icons, 'fa ' . $match[1]);
		}
		//$icons = apply_filters('ux_theme_icons_fields', $icons);
		
		return $icons;
	
	}
}

//Template photoswipe
if(!function_exists('ux_interface_photoswipe')){
	function ux_interface_photoswipe(){ ?>
		<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="pswp__bg"></div>
        
            <div class="pswp__scroll-wrap">
        
                <div class="pswp__container">
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                    <div class="pswp__item"></div>
                </div>
        
                <div class="pswp__ui pswp__ui--hidden">
        
                    <div class="pswp__top-bar">
        
                        <div class="pswp__counter"></div>
        
                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
        
                        <button class="pswp__button pswp__button--share" title="Share"></button>
        
                        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
        
                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
        
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                              <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                              </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div> 
                    </div>
        
                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                    </button>
        
                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                    </button>
        
                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
        
                </div>
        
            </div>
        
        </div>
        <?php
	}
	add_action('wp_footer', 'ux_interface_photoswipe', 9999);
}

//theme get youtube id
if(!function_exists('ux_theme_get_youtube')){
	function ux_theme_get_youtube($url){
		/*
		$matches = parse_url($url);
		$matches = str_replace("/", "", $matches['path']);
		return $matches;*/
		if(strstr($url, "youtube")){
			preg_match('#https?://(www\.)?youtube\.com/watch\?v=([A-Za-z0-9\-_]+)#s', $url, $matches);
			return $matches[2];
		}else{
			preg_match('#http://w?w?w?.?youtu.be/([A-Za-z0-9\-_]+)#s', $url, $matches);
			return $matches[1];
		}
	}
}

//theme get vimeo id
if(!function_exists('ux_theme_get_vimeo')){
	function ux_theme_get_vimeo($url){
		$matches = parse_url($url);
		$matches = str_replace("/", "", $matches['path']);
		return $matches;
	}
}

//pagebuilder has module
if(!function_exists('ux_has_module')){
	function ux_has_module($module){
		$return = false;
		if(is_singular('post') || is_page()){
		   global $post;
		   $ux_pb_meta = get_post_meta($post->ID, 'ux_pb_meta', true);
		   
		   if($ux_pb_meta){
			   $moduleid_date = array();
			   foreach($ux_pb_meta as $i => $wrap){
					$moduleid = isset($wrap['moduleid']) ? $wrap['moduleid'] : false;
					if($moduleid){
						$moduleid_date['w_' . $i] = $moduleid;
					}
					
					$items = isset($wrap['items']) ? $wrap['items'] : false;
					if($items){
						foreach($items as $item_num => $item){
							$moduleid = isset($item['moduleid']) ? $item['moduleid'] : false;
							
							if($moduleid){
								$moduleid_date['i_' . $i . '_' . $item_num] = $moduleid;
							}
						}
					}
			   }
			   if(in_array($module, $moduleid_date)){
				   $return = true;
			   }
		   }
		}
		
		return $return;
	}
}

//theme latest post
if(!function_exists('ux_theme_get_latest_post')){
	function ux_theme_get_latest_post($num = -1, $format = false){
		$get_posts = get_posts(array(
			'posts_per_page' => $num
		));
		
		$posts = array();
		
		if($get_posts){
			foreach($get_posts as $post){
				$post_format = (!get_post_format($post->ID)) ? 'standard' : get_post_format($post->ID);
				if(is_array($format)){
					if(in_array($post_format, $format)){
						$post = array('value' => $post->ID, 'title' => $post->post_title);
						array_push($posts, $post);
					}
				}else{
					$post = array('value' => $post->ID, 'title' => $post->post_title);
					array_push($posts, $post);
				}
				
			}
		}else{
			$post = array('value' => 0, 'title' => __('No post','ux'));
			array_push($posts, $post);
		}
		
		return $posts;
	}
}

//theme meta slider bmslider
if(!function_exists('ux_theme_meta_slider_bmslider')){
	function ux_theme_meta_slider_bmslider(){
		if(post_type_exists('bmslider')){
			$meta = array(
				array('title' => esc_html__('Select slider name', 'muti'), 'value' => 0)
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
				array('title' => esc_html__('Bmslider not installed', 'muti'), 'value' => 0)
			);
		}
		
		return $meta;
	}
}

//theme import attachment replace
if(!function_exists('ux_import_attachment_replace')){
	function ux_import_attachment_replace($key, $val){
		global $wpdb;
		$get_attachment = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'attachment'
		));
		
		$import_cache_attachment = false;
		switch($key){
			case 'url':
				$get_attachment_cache = $wpdb->get_row($wpdb->prepare("
					SELECT `option_name` FROM $wpdb->options 
					WHERE `option_value` LIKE '%s'
				", '%' .$wpdb->esc_like($val). '%'));
				if($get_attachment_cache){
					$import_cache_attachment = get_option($get_attachment_cache->option_name);
				}
			break;
			
			case 'id':
				$import_cache_attachment = get_option('import_cache_attachment_' . $val);
			break;
		}
		
		if($import_cache_attachment){
			$import_post_title = $import_cache_attachment['post_title'];
			$import_post_date = $import_cache_attachment['post_date'];
			foreach($get_attachment as $attachment){
				if($attachment->post_date == $import_post_date && $attachment->post_title == $import_post_title){
					$attachment_image_src = wp_get_attachment_image_src($attachment->ID, 'full');
					$val = $key == 'url' ? $attachment_image_src[0] : $attachment->ID;
				}
			}
		} 
		
		return $val;
	}
}

//theme import post replace
if(!function_exists('ux_import_post_replace')){
	function ux_import_post_replace($post_id){
		global $wpdb;
		$get_posts = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'post'
		));
		
		$import_cache_post = get_option('import_cache_post_s_' .$post_id);
		if($import_cache_post){
			$import_post_title = $import_cache_post['post_title'];
			$import_post_date = $import_cache_post['post_date'];
			foreach($get_posts as $post){
				if($post->post_date == $import_post_date && $post->post_title == $import_post_title){
					$attachment_image_src = wp_get_attachment_image_src($attachment->ID, 'full');
					$post_id = $post->ID;
				}
			}
		} 
		
		return $post_id;
	}
}
?>