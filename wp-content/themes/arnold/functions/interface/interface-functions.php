<?php
/****************************************************************/
/*
/* Functions
/*
/****************************************************************/

//Function more...
function arnold_continue_reading_link() {
	return '';
}
function arnold_auto_excerpt_more( $more ) {
	return ' &hellip;' . arnold_continue_reading_link();
}
add_filter( 'excerpt_more', 'arnold_auto_excerpt_more' );
function arnold_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= arnold_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'arnold_custom_excerpt_more' );

//Function Web Title
function arnold_interface_wp_title($title, $sep){
	global $paged, $page;

	if(is_feed() || is_search()){
		return $title;
	}

	$title .= get_bloginfo('name');

	$site_description = get_bloginfo('description', 'display');
	if($site_description &&(is_home() || is_front_page())){
		$title = "$title $sep $site_description";
	}

	if($paged >= 2 || $page >= 2){
		$title = "$title $sep " . sprintf(esc_html__('Page %s','arnold'), max($paged, $page));
	}

	return esc_attr($title);
}

//Function Web Head Viewport
function arnold_interface_webhead_viewport(){
	$enable_responsive = arnold_get_option('theme_option_mobile_enable_responsive');
	
	if($enable_responsive){ ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	}
}

//function
function arnold_interface_equiv_meta(){ ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php 
}


//Function Web Head Favicon
function arnold_interface_webhead_favicon(){
	$favicon_icon = arnold_get_option('theme_option_custom_favicon');
	$mobile_icon  = arnold_get_option('theme_option_mobile_icon');
	
	$favicon_icon = $favicon_icon ? $favicon_icon : arnold_LOCAL_URL . '/img/favicon.ico';
	$mobile_icon  = $mobile_icon ? $mobile_icon : arnold_LOCAL_URL . '/img/favicon.ico';  
    if ( ! function_exists( 'wp_site_icon' ) || ! has_site_icon() ) { ?>
<link rel="shortcut icon" href="<?php echo esc_url($favicon_icon); ?>">
	<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url($mobile_icon); ?>">
    <?php } ?>
<?php
}

//Function body class
if ( ! function_exists ( 'arnold_interface_body_class' ) ) {
	function arnold_interface_body_class(){
		$responsive = arnold_get_option('theme_option_mobile_enable_responsive') ? 'responsive-ux' : false;
		$header_layout = arnold_get_option('theme_option_header_layout') ? arnold_get_option('theme_option_header_layout') : 'horizon-menu-right';
		$default_logo = arnold_get_option('theme_option_custom_logo_choose') ? arnold_get_option('theme_option_custom_logo_choose') : 'dark-logo';
		$lightbox_skin_class = arnold_get_option('theme_option_color_skin_lightbox') ? arnold_get_option('theme_option_color_skin_lightbox') : false;
		$social_media = arnold_get_option('theme_option_show_social') ? arnold_get_option('theme_option_show_social') : false;
		$gallery_property = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_show_property') ? arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_show_property') : false;
		$hide_menu = arnold_get_option('theme_option_hide_menu');
		
		$header_layout_class = false;
		$hide_menu_class = false;
		switch($header_layout){
			case 'horizon-menu-right': $header_layout_class = 'navi-show navi-show-h'; break; 
			case 'horizon-menu-left': $header_layout_class = 'navi-show navi-show-h navi-show-h-left'; break;
			case 'columned-menu-right': $header_layout_class = 'navi-show navi-show-v'; break;
			case 'show-menu-icon': $header_layout_class = 'navi-hide'; break;
			case 'menu-icon-popup2': $header_layout_class = 'navi-hide navi-hide-pop2'; break;
			case 'menu-icon-horizon-menu': $header_layout_class = 'navi-hide navi-show-h navi-show-icon'; break;
			case 'logo-centered': $header_layout_class = 'navi-show navi-show-center'; if($hide_menu) { $hide_menu_class = 'ux-hide-menu'; } break;
			default: $header_layout_class = 'navi-show navi-show-h'; break; 
		}
		$body_glalery_property_class = false;
		
		$top_class = false;
		$bottom_class = false;
		$page_from_top_class = false;
		$non_bg_header_class = false;
		$default_logo_Class = $default_logo;
		$gallery_post_class  = false;
		$featured_img_color = '';
		$page_template_class = false;
		$page_header_sticky = '';
		$page_filter_sticky = ''; 

		if(is_page()){
			$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
			if($page_template == 'none'){
				$spacer_top = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_top_spacer');
				if($spacer_top){
					$top_class = 'show-top-space';
				}
				
				$spacer_bottom = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_bottom_spacer');
				if($spacer_bottom){
					$bottom_class = 'show-bottom-space';
				}
				
				$page_from_top = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_from_page_top');
				$page_from_top_class = $page_from_top ? 'page_from_top' : false;
				
				$featured_img_color = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_colour_for_text');
				$default_logo_Class = $featured_img_color ? $featured_img_color : $default_logo;

			}elseif($page_template == 'only-slider'){

				$page_from_top_class = 'page_from_top'; 
				$non_bg_header_class = 'non_bg_header';
				$page_template_class = 'page-template-only-slider-body';

			}elseif($page_template == 'masonry-grid'){

				$spacer_top2 = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_top_spacer2');
				if($spacer_top2){
					$top_class = 'show-top-space';
				}

			}elseif($page_template == 'custom-list'){

				$page_template_class = 'page-template-irregular'; 

			}else{

				$page_show_filter = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_filter');
			}
			
			if(class_exists('Woocommerce')){
				if(is_product()) {
					$top_class = 'show-top-space';
					$bottom_class = 'show-bottom-space';
				}
			} 


		} elseif(is_single()) {
			if(has_post_format('gallery')){
				$show_featured_image = false;
				$gallery_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_template');
				$gallery_wrap_fill = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_style');
				if($gallery_property) {
					$body_glalery_property_class = 'gallery-show-property';
				}
				switch($gallery_template){
					case 'standard':
						$show_featured_image = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_show_feature_image');
						$featured_img_color = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_brightness'); 
						if(has_post_thumbnail() && $show_featured_image && $featured_img_color) { 
							$default_logo_Class = $featured_img_color;
						}
						$gallery_post_class = 'single-portfolio-fullwidth';
					break;
					
					case 'big-title':
						$show_featured_image = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_show_feature_image');
						$featured_img_color = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_brightness');
						$gallery_post_class = 'single-portfolio-fullwidth single-portfolio-bigtitle';
						if(has_post_thumbnail() && $show_featured_image && $featured_img_color) { 
							$default_logo_Class = $featured_img_color;
						}
					break;
					
					case 'slider':
						$gallery_post_class = 'single-portfolio-fullwidth-slider';
					break;
					
					case 'fullscreen':
						$featured_img_color = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_colour_for_text');
						$gallery_post_class = 'single-portfolio-fullscreen-slider';
						if($featured_img_color) { 
							$default_logo_Class = $featured_img_color;
						}
					break;
				}
				
				if(arnold_enable_pb()){ 
				}

				if($show_featured_image || $gallery_template == 'fullscreen' || $gallery_template == 'big-title'){
					$page_from_top_class = 'page_from_top'; 
					$non_bg_header_class = 'non_bg_header'; 
				}
			}
		}
		
		body_class(sanitize_html_class($lightbox_skin_class). ' ' .sanitize_html_class($responsive). ' ' .sanitize_html_class($page_template_class). ' ' .esc_attr($header_layout_class). '  ' .sanitize_html_class($top_class). ' ' .sanitize_html_class($bottom_class).' ' . sanitize_html_class($page_from_top_class).' ' . sanitize_html_class($non_bg_header_class). ' ' . sanitize_html_class($default_logo_Class). ' ' . esc_attr($gallery_post_class). ' ' . sanitize_html_class($page_header_sticky). ' ' . sanitize_html_class($page_filter_sticky). ' '. sanitize_html_class($body_glalery_property_class). ' '.sanitize_html_class($hide_menu_class).' preload ux-start-hide');
	}
}

//Function post class
function arnold_interface_post_class(){
	$article_class = '';
	
	if(is_single()){
		$sidebar = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
		if(has_post_format('gallery')){
			$sidebar = 'without-sidebar';
		}

		if(!has_post_format('gallery')){
			if( $sidebar == 'without-sidebar' ) {
				$article_class = 'container';
			}
		}
	}
	
	post_class(sanitize_html_class($article_class));
}

//Function Logo
function arnold_interface_logo($key = ''){
	$enable_text_logo   = arnold_get_option('theme_option_enable_text_logo');
	$text_logo          = arnold_get_option('theme_option_text_logo');
	$text_logo          = $text_logo ? '<h1 class="logo-h1">' .balanceTags($text_logo). '</h1>' : '<h1 class="logo-h1">'. get_bloginfo('name'). '</h1>';
	$custom_logo        = arnold_get_option('theme_option_custom_logo');
	$custom_logo        = $custom_logo ? '<img class="logo-image logo-dark" src="' .esc_url($custom_logo). '" alt="' .get_bloginfo('name'). '" />' : '<h1 class="logo-h1">'. get_bloginfo('name'). '</h1>';
	$foot_custom_logo   = arnold_get_option('theme_option_custom_footer_logo');
	$foot_custom_logo   = $foot_custom_logo ? '<div id="logo-footer"><img class="logo-footer-img" src="' .esc_url($foot_custom_logo). '" alt="' .esc_attr(get_bloginfo('name')). '" /></div>' : false;
	$custom_logo_light  = arnold_get_option('theme_option_custom_logo_light');
	$custom_logo_light  = $custom_logo_light && $custom_logo && !$enable_text_logo ? '<span class="logo-light"><img class="logo-image" src="'.esc_url($custom_logo_light).'" alt="' .esc_attr(get_bloginfo('name')). '" /></span>' : false;
 	$custom_load_logo   = arnold_get_option('theme_option_custom_logo_for_loading');
	$custom_load_logo   = $custom_load_logo ? '<img src="' .esc_url($custom_load_logo). '" alt="' .get_bloginfo('name'). '" />' : false;
 	$home_url           = esc_url(home_url('/'));
	$output             = '';
	
	switch($key){

		case 'loading': 
			$output .= '<div class="site-loading-logo">';
			$output .= $enable_text_logo ? $text_logo : $custom_load_logo;
			$output .= '</div>';
		break; 

		case 'footer': 
			$output .= '<div id="logo-footer"><a href="' . esc_url($home_url) . '" title="' . get_bloginfo('name') . '">';
			$output .= $enable_text_logo ? $text_logo : $foot_custom_logo;
			$output .= '</a></div>';
		break; 
		
		default:       
			$output .= '<div id="logo"><a class="logo-a" href="' . esc_url($home_url) . '" title="' . get_bloginfo('name') . '">';
			$output .= $enable_text_logo ? $text_logo : '<h1 class="logo-h1 logo-not-show-txt">' . get_bloginfo('name') . '</h1>'. $custom_logo;
			$output .= ''.$custom_logo_light.'</a></div>';
		break;
		
	}
	
	echo balanceTags($output,false);
}

//Function theme get option
function arnold_get_option($key){
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
				case 'theme_option_enable_image_lazyload': $return = true; break;
				case 'theme_option_enable_meta_post_page': $return = true; break;
				case 'theme_option_posts_showmeta': $return = array(); break;
				case 'theme_option_mobile_enable_responsive': $return = true; break; 
				case 'theme_option_enable_share_buttons_for_posts': $return = true; break;
  	 			case 'theme_option_share_buttons': $return = array('facebook', 'twitter', 'google-plus', 'pinterest'); break;
				case 'theme_option_show_post_navigation': $return = true; break; 
				case 'theme_option_hide_category_on_post_page': $return = array(); break;
				
			}
		}
	}else{
		$return = arnold_theme_option_default($key);
		
		switch($key){
			case 'theme_option_enable_image_lazyload': $return = true; break;
			case 'theme_option_enable_meta_post_page': $return = true; break;
			case 'theme_option_enable_share_buttons_for_posts': $return = true; break;
  			case 'theme_option_share_buttons': $return = array('facebook', 'twitter', 'google-plus', 'pinterest'); break;
			case 'theme_option_posts_showmeta': $return = array('date', 'length', 'category', 'tag', 'author', 'comments'); break;
			case 'theme_option_mobile_enable_responsive': $return = true; break; 
			case 'theme_option_show_post_navigation': $return = true; break;
			case 'theme_option_hide_category_on_post_page': $return = array(); break;
		}
	}
	
	return $return;
}

//Function page blog masonry
function arnold_page_load_blog_masonry($module_post, $paged, $cat_id=false, $perpage=false, $post__not_in=array()){
	$category = arnold_get_post_meta($module_post, 'theme_meta_page_category');
	$orderby = arnold_get_post_meta($module_post, 'theme_meta_page_orderby');
	$order = arnold_get_post_meta($module_post, 'theme_meta_order');
	$per_page = arnold_get_post_meta($module_post, 'theme_meta_page_number');
	
	$per_page = $per_page ? $per_page : -1;
	
	if($cat_id){
		$category = array($cat_id);
	}
	
	if($perpage){
		$per_page = -1;
	}
	
	if(!is_array($category)){
		$category = array($category);
	}
	
	$get_posts = get_posts(array(
		'posts_per_page' => $per_page,
		'paged' => $paged,
		'orderby' => $orderby,
		'order' => $order,
		'category__in' => $category,
		'post__not_in' => $post__not_in
	));
	
	if($get_posts){
		global $post;
		
		foreach($get_posts as $num => $post){ setup_postdata($post);
			arnold_page_load_blog_masonry_item($module_post, $post, $category);
        }
		wp_reset_postdata();
	}
}

//Function page blog masonry item
function arnold_page_load_blog_masonry_item($module_post, $post, $category){
	//** Post format
	$get_post_format = (!get_post_format()) || get_post_format() == 'aside' || get_post_format() == 'status' || get_post_format() == 'chat' || get_post_format() == 'image' || get_post_format() == 'gallery' ? 'standard' : get_post_format();
	
	arnold_get_template_part('page/blog-masonry/blog-item', $get_post_format);
	
}

//Function page masonry grid
function arnold_page_load_masonry_grid($module_post, $paged){
	$category = arnold_get_post_meta($module_post, 'theme_meta_page_category_masonry_grid');
	$per_page = arnold_get_post_meta($module_post, 'theme_meta_page_number');
	$cat_id = $category;
	$list_layout = get_post_meta($module_post, '_portfolio_list_layout_' .intval($cat_id), true);
	
	$per_page = $per_page ? $per_page : -1;
	
	if($category){
		$category = array($category);
	}else{
		$category = array();
	}
	
	$get_categories = get_categories(array( 'parent' => $cat_id ));
	if($get_categories){
		foreach($get_categories as $cat){
			array_push($category, $cat->term_id);
		}
	}
	
	$get_posts = get_posts(array(
		'posts_per_page' => $per_page,
		'paged' => $paged,
		'category__in' => $category,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array('post-format-gallery', 'post-format-link'),
			)
		)
	));
	
	if($get_posts){
		global $post;
		
		foreach($get_posts as $post){ setup_postdata($post);
			arnold_page_load_masonry_grid_item($module_post, $post, $category, $list_layout);
        }
		wp_reset_postdata();
	}
}

//Function page masonry list
function arnold_page_load_masonry_list($module_post, $paged, $cat_id=false, $perpage=false, $post__not_in=array()){
	$page_template = arnold_get_post_meta($module_post, 'theme_meta_page_template');
	$category = arnold_get_post_meta($module_post, 'theme_meta_page_category');
	$orderby = arnold_get_post_meta($module_post, 'theme_meta_page_orderby');
	$order = arnold_get_post_meta($module_post, 'theme_meta_order');
	$per_page = arnold_get_post_meta($module_post, 'theme_meta_page_number');
	$layout_builder = arnold_get_post_meta($module_post, 'theme_meta_page_portfolio_layout_builder');
	
	$per_page = $per_page ? $per_page : -1;
	
	if($cat_id){
		$category = array($cat_id);
	}
	
	if($perpage){
		$per_page = -1;
	}
	
	if(!is_array($category)){
		$category = array($category);
	}
	
	$get_posts = get_posts(array(
		'posts_per_page' => $per_page,
		'paged' => $paged,
		'orderby' => $orderby,
		'order' => $order,
		'category__in' => $category,
		'post__not_in' => $post__not_in,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array('post-format-gallery', 'post-format-link'),
			)
		)
	));
	
	$layout_builder_count = 0;
	if(isset($layout_builder['imagealign'])){
		$layout_builder_count = count($layout_builder['imagealign']);
	}
	
	if($get_posts){
		global $post;
		
		foreach($get_posts as $i => $post){ setup_postdata($post);
			if($page_template == 'custom-list'){
				$num = $i % $layout_builder_count;
				arnold_page_load_custom_list_item($module_post, $post, $category, $num);
			}else{
				arnold_page_load_masonry_list_item($module_post, $post, $category);
			}
        }
		wp_reset_postdata();
	}
}

//Function page masonry grid item
function arnold_page_load_masonry_grid_item($module_post, $post, $category, $list_layout=false){
	$post_class = 'post--' .$post->ID;
	$page_item_style = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_item_style');
	
	//lightbox
	$page_what_thumb = arnold_get_post_meta($module_post, 'theme_meta_page_what_thumb');
	$page_what_thumb_data = '';
	if($page_what_thumb == 'open-featured-img' && has_post_thumbnail()){
		$page_what_thumb_data = 'data-lightbox="true"';
	}
	
	$title_link_before = $page_what_thumb != 'open-featured-img' ? '<a href="' .get_permalink(). '" title="' .get_the_title(). '" class="grid-item-tit-a">' : false;
	$title_link_after = $page_what_thumb != 'open-featured-img' ? '</a>' : false;
	
	//link
	$get_permalink = get_permalink();
	$get_linkname  = get_the_title();
	$link_style = false;
	if(has_post_format('link') && $page_item_style == 'img'){
		$arnold_link_item = arnold_get_post_meta($post->ID, 'theme_meta_link_item');
		if($arnold_link_item){
			$get_permalink = $arnold_link_item['url'][0];
			$get_linkname = $arnold_link_item['name'][0];
		}
		$link_text_color = arnold_get_post_meta($post->ID, 'theme_meta_link_text_color');
		$link_text_style = $link_text_color ? '.'.sanitize_html_class($post_class).' .grid-item-tit { color:'.esc_attr($link_text_color).'; } ' : false;
		$link_bg_color = arnold_get_post_meta($post->ID, 'theme_meta_link_bg_color');
		$link_bg_style = $link_bg_color ? '.'.sanitize_html_class($post_class).':after { background-color:'.esc_attr($link_bg_color).'; } ' : false;
		$link_text_mouseover_color = arnold_get_post_meta($post->ID, 'theme_meta_link_text_color_mouseover');
		$link_text_mouseover_style = $link_text_mouseover_color ? '.'.sanitize_html_class($post_class).':hover .grid-item-tit { color:'.esc_attr($link_text_mouseover_color).'; } ' : false;
		$link_bg_mouseover_color = arnold_get_post_meta($post->ID, 'theme_meta_link_bg_color_mouseover');
		$link_bg_mouseover_style = $link_bg_mouseover_color ? '.'.sanitize_html_class($post_class).':hover:after { background-color:'.esc_attr($link_bg_mouseover_color).'; } ' : false;
		$link_style = $link_text_color || $link_bg_color || $link_text_mouseover_color || $link_bg_mouseover_color ? '<style type="text/css" scoped>' . esc_attr($link_text_style) . esc_attr($link_bg_style) . esc_attr($link_text_mouseover_style) . esc_attr($link_bg_mouseover_style). '</style>' : false;

	}
	
	//bg color
	$gallery_style = false;
	$page_mouseover_effect = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_mouseover_effect');
	if(has_post_format('gallery') && $page_item_style == 'img' && $page_mouseover_effect == 'featured-color'){
		$bg_color = arnold_get_post_meta($post->ID, 'theme_meta_featured_color');
		$gallery_style = $bg_color !='null' ? '<style type="text/css" scoped> .' . sanitize_html_class($post_class).':after { background-color: '.esc_attr($bg_color).'}</style>' : false;		 
	}
	
	$show_title = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_show_title');
	$show_category = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_show_category');
	if($page_item_style != 'img'){
		$show_title = false;
	}
	
	//cat classes
	$classes = array();
	$taxonomies = get_taxonomies(array('public' => true));
	foreach((array) $taxonomies as $taxonomy){
		if(is_object_in_taxonomy($post->post_type, $taxonomy)){
			foreach((array) get_the_terms($post->ID, $taxonomy) as $term){
				if(empty($term->slug)){
					continue;
				}
				
				$term_class = sanitize_html_class($term->slug);
				if(is_numeric($term_class) || !trim($term_class, '-')){
					$term_class = $term->term_id;
				}
				
				// 'post_tag' uses the 'tag' prefix for backward compatibility.
				$classes[] = sanitize_html_class('filter_' . $term_class);
			}
		}
	}
	$classes = array_unique($classes);
	
	//thumb url
	$thumb_width = 650; $thumb_height = 650;
	$thumb_url = get_template_directory_uri(). '/img/blank.gif';

	if(has_post_thumbnail()){
		$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'arnold-thumb-11-normal');
		$thumb_width = $thumb[1];
		$thumb_height = $thumb[2];
		$thumb_url = $thumb[0];
	}

	//list layout
	$layout_array = array();
	if($list_layout){
		$layout_array = $list_layout;
	}
	
	$x = 0;
	$y = 0;
	$width = 3;
	$height = 3;
	
	if(count($layout_array)){
		foreach($layout_array as $layout){
			if($layout['post_id'] == $post->ID){
				$x = $layout['x'];
				$y = $layout['y'];
				$width = $layout['width'];
				$height = $layout['height'];

				// Image size for defferent size(width) Grid
				if(has_post_thumbnail()){
					if( $width > 3 && $width <= 7 ) {
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'arnold-thumb-43-medium');
					} elseif($width > 7 && $width < 11) {
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'arnold-thumb-43-big'); 
					} elseif($width >= 11) {
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
					} else {
						$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'arnold-thumb-11-normal');
					}
					$thumb_width = $thumb[1];
					$thumb_height = $thumb[2];
					$thumb_url = $thumb[0];
				}

			}
		}
	} 

	//thumb padding top
	$thumb_padding_top = false;
	if($thumb_height > 0 && $thumb_width > 0){
		$thumb_padding_top = 'padding-top: ' . (intval($thumb_height) / intval($thumb_width)) * 100 . '%;';
	}
	
	//lazyload
	$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');
	$image_lazyload_style = 'data-bg="' .esc_url($thumb_url). '"';
	$image_lazyload_class = 'ux-lazyload-bgimg';
	if(!$image_lazyload){
		$image_lazyload_style = 'style="background-image:url(' .esc_url($thumb_url). ');"'; 
	}
	?>
    
    <div class="grid-stack-item <?php echo esc_attr(join(' ', $classes)); ?>" data-postid="<?php echo esc_attr($post->ID); ?>" data-gs-x="<?php echo esc_attr($x); ?>" data-gs-y="<?php echo esc_attr($y); ?>" data-gs-width="<?php echo esc_attr($width); ?>" data-gs-height="<?php echo esc_attr($height); ?>">
        <div class="grid-stack-item-content">
            <div class="grid-item-inside" <?php echo balanceTags($page_what_thumb_data); ?>>
            	<?php 
            	echo balanceTags($link_style);
            	echo balanceTags($gallery_style); ?>

                <div class="grid-item-con <?php echo sanitize_html_class($post_class); ?>">
                    <?php if($page_what_thumb == 'open-featured-img'){
                        $thumb_full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $data_size = $thumb_full[1]. 'x' .$thumb_full[2]; ?>
                        <a title="<?php echo esc_attr($post->post_excerpt); ?>" class="lightbox-item grid-item-mask-link" href="<?php echo esc_url($thumb_full[0]); ?>" data-size="<?php echo esc_attr($data_size); ?>"><img class="lightbox-img-hide" width="<?php echo esc_attr($thumb_width); ?>" height="<?php echo esc_attr($thumb_height); ?>" src="<?php echo get_template_directory_uri(); ?>/img/blank.gif" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>" /></a>
                    <?php }else{ ?>
                        <a href="<?php echo esc_url($get_permalink); ?>" title="<?php echo get_the_title(); ?>" class="grid-item-mask-link"></a>
                    <?php
                    }
                    
                    if($page_item_style == 'img'){ ?>
                        <div class="grid-item-con-text">
                        	<?php if(has_post_format('gallery')) { ?>
                            <?php if($show_category){ ?><span class="grid-item-cate"><?php arnold_theme_hide_category(' ', 'grid-item-cate-a', array('data-filter' => true), $category, $post->ID); ?></span><?php } ?>
                            <?php if($show_title){ ?><h2 class="grid-item-tit"><?php echo balanceTags($title_link_before); echo get_the_title(); echo balanceTags($title_link_after); ?></h2><?php } ?>
                        	<?php }elseif(has_post_format('link')) { ?>
                        		<h2 class="grid-item-tit"><?php echo balanceTags($get_linkname); ?></h2>
                        	<?php } ?>
                        </div>
                    <?php
                    }else{ ?>
                        <div class="grid-item-con-text-show">
                            <?php if($show_category){ ?><span class="grid-item-cate"><?php arnold_theme_hide_category(' ', 'grid-item-cate-a', array('data-filter' => true), $category, $post->ID); ?></span><?php } ?>
                            <h2 class="grid-item-tit"><?php the_title(); ?></h2>
                        </div>
                    <?php } ?>
                </div>
                
                <div class="brick-content ux-lazyload-wrap" style=" <?php echo esc_attr($thumb_padding_top); ?>">
                    <div class="<?php echo sanitize_html_class($image_lazyload_class); ?> ux-background-img" <?php echo balanceTags($image_lazyload_style); ?>></div>
                </div>
            </div><!--End inside-->
        </div>
    </div>
<?php	
}

//Function page custom list item
function arnold_page_load_custom_list_item($module_post, $post, $category, $num){
	$gallery_brightness = arnold_get_post_meta($post->ID, 'theme_meta_gallery_brightness');
	$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');
	$cusl_class = '';
	if($gallery_brightness == 'dark'){
		$cusl_class = 'cusl-dark-img';
	}
	
	$layout_builder = arnold_get_post_meta($module_post, 'theme_meta_page_portfolio_layout_builder');
	$image_align = arnold_page_custom_list_layout('imagealign', $num, $layout_builder);
	$title_align = arnold_page_custom_list_layout('titlealign', $num, $layout_builder);
	$top_padding = arnold_page_custom_list_layout('toppadding', $num, $layout_builder);
	$image_width = arnold_page_custom_list_layout('imagewidth', $num, $layout_builder);
	
	$thumb_width = 600;
	$thumb_height = 400;
	$thumb_url = get_template_directory_uri(). '/img/blank.gif';
	
	if(has_post_thumbnail()){
		$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
		$thumb_width = $thumb[1];
		$thumb_height = $thumb[2];
		$thumb_url = $thumb[0];
	}

	$thumb_padding_top = false;
	if($thumb_height > 0 && $thumb_width > 0){
		$thumb_padding_top = 'padding-top: ' . (intval($thumb_height) / intval($thumb_width)) * 100 . '%;';
	}
	$image_src = ' src="'.esc_url($thumb_url).'"';
	$image_class = ' ';
	if($image_lazyload) {
		$image_src = 'src="' .get_template_directory_uri(). '/img/blank.gif" data-src="' .esc_url($thumb_url). '"';
		$image_class = 'lazy';
	}

	 ?>
    
    <section class="cusl-style-unit <?php echo sanitize_html_class($image_align); ?> <?php echo sanitize_html_class($title_align); ?> <?php echo sanitize_html_class($top_padding); ?> <?php echo sanitize_html_class($image_width); ?> <?php echo sanitize_html_class($cusl_class); ?>" data-postid="<?php echo esc_attr($post->ID); ?>">
        <div class="cusl-style-unit-inn">
            <div class="cusl-img-wrap" style="<?php echo esc_attr($thumb_padding_top); ?>"><img <?php echo balanceTags($image_src); ?> alt="<?php the_title(); ?>" class="cusl-img ux-lazyload-img <?php echo sanitize_html_class($image_class); ?>" /></div>
            <div class="cusl-style-normal-text-wrap">
                <div class="cusl-style-tit-wrap">
                    <span class="cusl-cate"><?php arnold_theme_hide_category(' ', 'cusl-cate-a'); ?></span>
                    <h2 class="cusl-tit"><a class="cusl-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                </div>
            </div>
            <div class="cusl-style-light-text-wrap">
                <div class="cusl-style-tit-wrap">
                    <span class="cusl-cate"><?php arnold_theme_hide_category(' ', 'cusl-cate-a'); ?></span>
                    <h2 class="cusl-tit"><a class="cusl-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                </div>
            </div>
        </div>
    </section>
<?php	
}

//Function page custom list layout builder
function arnold_page_custom_list_layout($key, $num, $builder){
	$return = false;
	if($builder){
		if(isset($builder[$key])){
			$layout = $builder[$key];
			
			switch($key){
				case 'imagealign':
					switch($layout[$num]){
						case 'left': $return = 'cusl-img-left'; break;
						case 'center': $return = 'cusl-img-center'; break;
						case 'right': $return = 'cusl-img-right'; break;
					}
				break;
				case 'titlealign':
					switch($layout[$num]){
						case 'top-left': $return = 'cusl-text-top-left'; break;
						case 'middle-left': $return = 'cusl-text-middle-left'; break;
						case 'bottom-left': $return = 'cusl-text-bottom-left'; break;
						case 'top-right': $return = 'cusl-text-top-right'; break;
						case 'middle-right': $return = 'cusl-text-middle-right'; break;
						case 'bottom-right': $return = 'cusl-text-bottom-right'; break;
					}
				break;
				case 'toppadding':
					switch($layout[$num]){
						case '100px': $return = 'cusl-100-padding'; break;
						case 'overlap': $return = 'cusl-negative-padding'; break;
					}
				break;
				case 'imagewidth':
					switch($layout[$num]){
						case '30%': $return = 'cusl-img-w30'; break;
						case '40%': $return = 'cusl-img-w40'; break;
						case '50%': $return = 'cusl-img-w50'; break;
						case '60%': $return = 'cusl-img-w60'; break;
						case '70%': $return = 'cusl-img-w70'; break;
					}
				break;
			}
		}
	}
	
	return $return;
}

//Function page masonry list item
function arnold_page_load_masonry_list_item($module_post, $post, $category){
	$post_class = 'post--' .$post->ID;
	
	$gallery_image_size = 'thumb-43-';
	//gallery shape
	$gallery_shape = arnold_get_post_meta($post->ID, 'theme_meta_gallery_shape');
	$columns = arnold_get_post_meta($module_post, 'theme_meta_page_columns');
	$page_show_standard_grid_title = arnold_get_post_meta($module_post, 'theme_meta_page_standard_grid_show_title');
	$page_show_project_property = arnold_get_post_meta($module_post, 'theme_meta_page_show_project_property');
	$page_show_standard_grid_text_align = arnold_get_post_meta($module_post, 'theme_meta_page_standard_grid_text_align');
	$page_show_standard_grid_text_align = $page_show_standard_grid_text_align ? $page_show_standard_grid_text_align : false;
	$page_show_standard_grid_padding = arnold_get_post_meta($module_post, 'theme_meta_page_standard_grid_padding');
	$page_show_standard_grid_pading_class = $page_show_standard_grid_padding ? ' standard-text-padding' : false;
	$page_what_thumb = arnold_get_post_meta($module_post, 'theme_meta_page_what_thumb');
	
	$classes = array();
	$taxonomies = get_taxonomies(array('public' => true));
	foreach((array) $taxonomies as $taxonomy){
		$page_template = arnold_get_post_meta($module_post, 'theme_meta_page_template');
		
		if(is_object_in_taxonomy($post->post_type, $taxonomy)){
			foreach((array) get_the_terms($post->ID, $taxonomy) as $term){
				if(empty($term->slug)){
					continue;
				}
				
				$term_class = sanitize_html_class($term->slug);
				if(is_numeric($term_class) || !trim($term_class, '-')){
					$term_class = $term->term_id;
				}
				
				// 'post_tag' uses the 'tag' prefix for backward compatibility.
				$classes[] = sanitize_html_class('filter_' . $term_class);
			}
		}
	}
	
	$classes = array_unique($classes);
	
	switch($columns){
		case '2': 
			if($gallery_shape == 'gallery_shape_1'){
				$gallery_image_size .= 'medium';
			}else{
				$gallery_image_size .= 'big';
			}
		break;
		case '3':
			if($gallery_shape == 'gallery_shape_1'){
				$gallery_image_size .= 'small';
			}else{
				$gallery_image_size .= 'medium';
			}
		break;
		case '4': $gallery_image_size .= 'small'; break;
		case '5': $gallery_image_size .= 'small'; break;
		case '6': $gallery_image_size .= 'small'; break;
		default: $gallery_image_size .= 'medium'; break;
	}
	
	$gallery_shape_class = '';
	
	if($page_template == 'masonry-portfolio'){
		switch($columns){
			case '2': $gallery_image_size = 'arnold-standard-thumb-medium'; break;
			case '3': $gallery_image_size = 'arnold-standard-thumb'; break;
			default: $gallery_image_size = 'arnold-standard-thumb'; break;
		}
	}
	
	if($page_template != 'standard-grid'){
		$bg_color = arnold_get_post_meta($post->ID, 'theme_meta_featured_color');
		if($bg_color){ ?>
			<style type="text/css">.<?php echo sanitize_html_class($post_class); ?>:after{ background-color: <?php echo esc_attr($bg_color); ?>; }</style>
        <?php
		}
	}
	
	$thumb_width = 650;
	$thumb_height = 490;
	$thumb_url = get_template_directory_uri(). '/img/blank.gif';
	
	if(has_post_thumbnail()){
		$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), $gallery_image_size);
		$thumb_width = $thumb[1];
		$thumb_height = $thumb[2];
		$thumb_url = $thumb[0];
	}

	$thumb_padding_top = false;
	if($thumb_height > 0 && $thumb_width > 0){
		$thumb_padding_top = 'padding-top: ' . (intval($thumb_height) / intval($thumb_width)) * 100 . '%;';
	}

	$page_what_thumb_data = '';
	if($page_what_thumb == 'open-featured-img' && has_post_thumbnail()){
		$page_what_thumb_data = 'data-lightbox="true"';
	}elseif($page_what_thumb == 'open-all-img'){
		$page_what_thumb_data = 'lightbox-photoswipe';
	}

	$title_link_before = $page_what_thumb != 'open-featured-img' ? '<a href="'.get_permalink().'" title="'.get_the_title().'" class="grid-item-tit-a">' : false;
	$title_link_after = $page_what_thumb != 'open-featured-img' ? '</a>' : false;
	
	//video
	$show_gallery_video = arnold_get_post_meta(get_the_ID(), 'theme_meta_show_gallery_video');
	$video_embeded_code = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_video_embeded_code');
	$data_type = '';
	if($show_gallery_video && $video_embeded_code){
		$data_type = 'video';
	}
	
	//link
	$get_permalink = get_permalink();
	if(has_post_format('link')){
		$get_permalink = get_permalink();
		$arnold_link_item = arnold_get_post_meta(get_the_ID(), 'theme_meta_link_item');
		if($arnold_link_item){
			$get_permalink = $arnold_link_item['url'][0];
		}
	}
				
	$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');
	$image_lazyload_style = 'data-bg="' .esc_url($thumb_url). '"';
	$image_lazyload_class = 'ux-lazyload-bgimg';
	$image_lazyload_img_style = 'src="' .get_template_directory_uri(). '/img/blank.gif" data-src="' .esc_url($thumb_url). '"';
	$image_lazyload_img_class = 'lazy';
	if(!$image_lazyload){
		$image_lazyload_style = 'style="background-image:url(' .esc_url($thumb_url). ');"';
		//$image_lazyload_class = '';
		$image_lazyload_img_style = 'src="' .esc_url($thumb_url). '"';
		$image_lazyload_img_class = '';
	} ?>
	
	<section class="grid-item <?php echo esc_attr($gallery_shape_class); ?> <?php echo esc_attr(join(' ', $classes)); ?>" data-postid="<?php echo esc_attr($post->ID); ?>">
		<div class="grid-item-inside" <?php echo balanceTags($page_what_thumb_data); ?>>
            <?php if($page_template != 'standard-grid'){ ?>
				<div class="grid-item-con <?php echo sanitize_html_class($post_class); ?>">
					<?php if($page_what_thumb == 'open-featured-img'){
						$thumb_full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
						$data_size = $thumb_full[1]. 'x' .$thumb_full[2]; ?>
						<a title="<?php echo esc_attr($post->post_excerpt); ?>" class="lightbox-item grid-item-mask-link" href="<?php echo esc_url($thumb_full[0]); ?>" data-type="<?php echo esc_attr($data_type); ?>" data-size="<?php echo esc_attr($data_size); ?>"><img class="lightbox-img-hide" width="<?php echo esc_attr($thumb_width); ?>" height="<?php echo esc_attr($thumb_height); ?>" src="<?php echo get_template_directory_uri(); ?>/img/blank.gif" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>" />
						
							<?php if($show_gallery_video && $video_embeded_code){
								echo '<div class="hidden">';
								arnold_get_template_part('single/gallery/portfolio', 'video');
								echo '</div>';
							} ?>
						</a>
					<?php }elseif($page_what_thumb == 'open-all-img'){
						arnold_page_load_masonry_list_open_all_img($post);
					}else{ ?>
						<a href="<?php echo esc_url($get_permalink); ?>" title="<?php the_title(); ?>" class="grid-item-mask-link"></a>
					<?php } ?>
					
					<div class="grid-item-con-text">
						<span class="grid-item-cate"><?php arnold_theme_hide_category(' ', 'grid-item-cate-a', array('data-filter' => true), $category); ?></span>
						<h2 class="grid-item-tit"><?php echo balanceTags($title_link_before); the_title(); echo balanceTags($title_link_after); ?></h2>
					</div>
				</div>
			<?php
			}else{
				if($page_what_thumb == 'open-featured-img'){
					$thumb_full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					$data_size = $thumb_full[1]. 'x' .$thumb_full[2]; ?>
					<a title="<?php echo esc_attr($post->post_excerpt); ?>" class="lightbox-item grid-item-mask-link" href="<?php echo esc_url($thumb_full[0]); ?>" data-type="<?php echo esc_attr($data_type); ?>" data-size="<?php echo esc_attr($data_size); ?>"><img class="lightbox-img-hide" width="<?php echo esc_attr($thumb_width); ?>" height="<?php echo esc_attr($thumb_height); ?>" src="<?php echo get_template_directory_uri(); ?>/img/blank.gif" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>" />
					
						<?php if($show_gallery_video && $video_embeded_code){
							echo '<div class="hidden">';
							arnold_get_template_part('single/gallery/portfolio', 'video');
							echo '</div>';
						} ?>
					</a>
				<?php }elseif($page_what_thumb == 'open-all-img'){
					arnold_page_load_masonry_list_open_all_img($post);
				}else{ ?>
					<a href="<?php echo esc_url($get_permalink); ?>" title="<?php the_title(); ?>" class="grid-item-mask-link"></a>
				<?php
				}
			}
			
			if($page_template != 'masonry-portfolio'){ ?>

				<div class="brick-content ux-lazyload-wrap" style=" <?php echo esc_attr($thumb_padding_top); ?>">
					<div class="<?php echo sanitize_html_class($image_lazyload_class); ?> ux-background-img" <?php echo balanceTags($image_lazyload_style); ?>></div>
				</div>
			<?php
			}else{ ?>
				<div class="brick-content ux-lazyload-wrap" style=" <?php echo esc_attr($thumb_padding_top); ?>"> 
					<img class="ux-lazyload-img <?php echo sanitize_html_class($image_lazyload_img_class); ?>" width="<?php echo esc_attr($thumb_width); ?>" height="<?php echo esc_attr($thumb_height); ?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>" <?php echo balanceTags($image_lazyload_img_style); ?>/>
				</div>
			<?php
			}
			
			//grid title
			if($page_template == 'standard-grid' && ($page_show_standard_grid_title || $page_show_project_property)){ ?>
				<div class="grid-item-con-text-tit-shown <?php echo esc_attr($page_show_standard_grid_text_align); echo esc_attr($page_show_standard_grid_pading_class); ?>">
					<?php if($page_show_standard_grid_title){ ?><h2 class="grid-item-tit"><?php the_title(); ?></h2><?php } ?>
                    <?php if($page_show_project_property){
						$gallery_template = arnold_get_post_meta($post->ID, 'theme_meta_gallery_template');
						$show_property = arnold_get_post_meta($post->ID, 'theme_meta_gallery_show_property');
						$property = arnold_get_post_meta($post->ID, 'theme_meta_enable_portfolio_property');
						
						if($show_property && $property){
							
							if(isset($property['title'])){
								$property_title = $property['title'];
								$switch = true;
								
								if(count($property_title) == 1){
									if(empty($property['title'][0]) && empty($property['content'][0])){
										$switch = false;
									}
								} 
						
								if($switch){ ?>
									<div class="grid-property">
										<ul class="grid-info-property">
											<?php foreach($property_title as $num => $title){
												$content = $property['content'][$num]; ?>
												<li class="gallery-info-property-li">
													<h3 class="gallery-info-property-item gallery-info-property-tit"><?php echo balanceTags($title, false); ?></h3>
													<div class="gallery-info-property-item gallery-info-property-con"><?php echo balanceTags($content, false); ?></div>
												</li>
											<?php } ?>
										</ul>    
									</div>
									
								<?php     
								}  
							}
						}
					} ?>
				</div>
			<?php } ?>
		</div><!--End inside-->

	</section> 
<?php
}

//Function page load 
function arnold_page_load_masonry_list_open_all_img($post){
	//** get portfolio image
	$portfolio = arnold_get_post_meta($post->ID, 'theme_meta_portfolio');
	$page_what_thumb_allurl = array();
	$page_what_thumb_allsize = array();
	if($portfolio){
		foreach($portfolio as $num => $imgethumb){
			$thumb_full = wp_get_attachment_image_src($imgethumb, 'full');
			$data_size = $thumb_full[1]. 'x' .$thumb_full[2];
			$thumb_width = $thumb_full[1];
			$thumb_height = $thumb_full[2];
			$thumb_url = $thumb_full[0];
			$hidden = $num == 0 ? '' : 'hidden'; ?>
            <div class="<?php echo sanitize_html_class($hidden); ?>" data-lightbox="true">
                <a title="<?php echo get_the_title($imgethumb); ?>" class="lightbox-item grid-item-mask-link" href="<?php echo esc_url($thumb_full[0]); ?>" data-size="<?php echo esc_attr($data_size); ?>"><img class="hidden" width="<?php echo esc_attr($thumb_width); ?>" height="<?php echo esc_attr($thumb_height); ?>" data-src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo get_the_title($imgethumb); ?>" title="<?php echo get_the_title($imgethumb); ?>" /></a>
            </div>
		<?php
        }
	}else{ ?>
        <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>" class="grid-item-mask-link"></a>
	<?php 
	}
}

//Function page load blog list pagination
function arnold_page_view_pagination($post_id, $the_query, $pagination=false){
	$max_num_pages = intval($the_query->max_num_pages);
	$found_posts = intval($the_query->found_posts);
	
	if($pagination){
		$page_pagination = $pagination;
	}else{
		$page_pagination = arnold_get_post_meta($post_id, 'theme_meta_page_pagination');
	}
	
	if($max_num_pages > 1){
		switch($page_pagination){
			case 'load-more':
				$pagination_text = arnold_get_option('theme_option_descriptions_pagination');
				$pagination_text = $pagination_text ? $pagination_text : esc_attr__('LOAD MORE ARTICLES','arnold');
				$loading_text = arnold_get_option('theme_option_descriptions_pagination_loading');
				$loading_text = $loading_text ? $loading_text : esc_attr__('LOADING...','arnold') ?>
				<div class="clearfix pagenums tw_style page_twitter" data-pagetext="<?php echo esc_attr($pagination_text); ?>" data-loadingtext="<?php echo esc_attr($loading_text); ?>">
					<a class="tw-style-a ux-btn ux-page-load-more" data-pageid="<?php echo esc_attr($post_id); ?>" data-max="<?php echo esc_attr($max_num_pages); ?>" data-postcount="<?php echo esc_attr($found_posts); ?>" data-paged="2" href="#"><?php echo esc_html($pagination_text); ?></a>
				</div>
			<?php
			break;
		}
	}
}

//Function pagination
function arnold_interface_pagination($pages = '', $range = 3, $type = 'pagenums'){
	global $wp_query, $wp_rewrite;
	
	$posts_per_page = intval(get_option('posts_per_page'));
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
	
	if($type == 'twitter'){
		$archive_query = 'is_home_____';
		
		if(is_date()){
			$archive_query  = 'is_date_____';
		}elseif(is_tag()){
			$archive_query  = 'is_tag_____';
		}elseif(is_author()){
			$archive_query  = 'is_author_____';
		}elseif(is_category()){
			$archive_query  = 'is_category_____';
		}elseif(is_archive()){
			$archive_query  = 'is_archive_____';
		}
		
		foreach($wp_query->query as $name => $query){
			$archive_query .= '@__@' .$name. '@_@' .$query;
		}
		
		$archive_query = $archive_query;
		if(function_exists('arnold_view_module_pagenums')){
			arnold_view_module_pagenums($archive_query, 'archive-main-list', $posts_per_page, $wp_query->found_posts, 'twitter');
		}
	}else{
		
		echo '<div class="clearfix pagenums pagenums-default container-fluid">';
		echo wp_kses_post(paginate_links( array(
			'base'      => @add_query_arg('paged','%#%'),
			'format'    => '',
			'current'   => $current,
			'prev_text' => esc_attr__('Previous','arnold'),
			'next_text' => esc_attr__('Next','arnold'),
			'total'     => $wp_query->max_num_pages,
			'mid_size'  => $range
		)));  
		echo '</div>';
		
	}
}

//Function Copyright
function arnold_interface_copyright(){
	$footer_copyright = arnold_get_option('theme_option_copyright');
	$footer_copyright = $footer_copyright ? $footer_copyright : 'Copyright uiueux.com';
	
	echo wp_kses_stripslashes($footer_copyright);
}

//Function Language Flags
function arnold_interface_language_flags(){
	if (function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			
				echo '<div class="wpml-translation">';
				echo '<ul class="wpml-language-flags clearfix">';
				foreach($languages as $l){
					echo '<li>';
					if($l['country_flag_url']){
						if(!$l['active']) {
							echo '<a href="'.esc_url($l['url']).'"><img src="'.esc_url($l['country_flag_url']).'" height="12" alt="'.esc_attr($l['language_code']).'" width="18" /><span class="languages-shortname">'.esc_attr($l['language_code']).'</span><span class="languages-name">'.esc_attr($l['native_name']).'</span></a>';
						} else {
							echo '<div class="current-language"><img src="'.esc_url($l['country_flag_url']).'" height="12" alt="'.esc_attr($l['language_code']).'" width="18" /><span class="languages-shortname">'.esc_attr($l['language_code']).'</span><span class="languages-name">'.esc_attr($l['native_name']).'</span></div>';
						}
					}
					echo '</li>';
				}
				echo '</ul>';
				echo '</div>';
			
		}
	} else {
		echo "<p class='wpml-tip'>". esc_attr__('WPML not installed and activated.','arnold') ."</p>";
	}
}

//Function Content wrap class
function arnold_interface_content_class(){
	$arnold_sidebar_class = 'col-md-9 col-sm-9';

	$output = $arnold_sidebar_class;
	
	if(is_singular('post') || is_page() || is_singular('team_item')){
		$pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
		$sidebar = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
		
		if(is_singular('post')){
			if(has_post_format('gallery')){
				$sidebar = 'without-sidebar';
			}
		}elseif(is_page()){
			$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
			if($page_template != 'none' && $page_template != 'blog-masonry'){
				$sidebar = 'without-sidebar';
			}
		}
		
		switch($sidebar){
			case 'right-sidebar':   $output = $arnold_sidebar_class; break;
			case 'left-sidebar':    $output = $arnold_sidebar_class. ' pull-right'; break;
			case 'without-sidebar': $output = '';
		}
	}
	
	if(arnold_enable_team_template()){
		$output = false;
	}
	
	echo 'class="' .esc_attr($output). '"';
	
}

//ux plugins
function ux_interface_pagebuilder(){
	arnold_interface_pagebuilder();
}

//Function Pagebuilder
function arnold_interface_pagebuilder(){
	$switch = false;
	
	if(arnold_enable_pb()){
		if(post_password_required()){
		 	echo get_the_password_form();
		 	return;
		}else{
		$switch = true;
		}
	}
		
	$enable_paid = false;
	//$enable_paid = arnold_get_option('theme_option_enable_paid_content');
	if($enable_paid){
		if(function_exists('pmpro_has_membership_access')){
			$hasaccess = pmpro_has_membership_access(NULL, NULL, true);
			if(is_array($hasaccess)){
				//returned an array to give us the membership level values
				$post_membership_levels_ids = $hasaccess[1];
				$post_membership_levels_names = $hasaccess[2];
				$hasaccess = $hasaccess[0];
			}
			if($hasaccess){
				$switch = true;
			}else{
				$switch = false;
			}
		}
	}
	
	if($switch){
		echo '<div class="pagebuilder-wrap">';
		do_action('ux-theme-single-pagebuilder');
		echo '</div>';
	}else{
		if(arnold_enable_pb()){
			the_excerpt();
		}
		
	}
}

//Function search list ajax
function arnold_interface_search_list_load($keyword, $paged){
	$the_search = new WP_Query('s=' .$keyword. '&paged=' .$paged);
	
	if($the_search->have_posts()){
		while($the_search->have_posts()){ $the_search->the_post(); ?>
            <section class="search-result-unit">
                <h1 class="search-result-unit-tit"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <?php if(has_excerpt()){ ?>
                    <div class="blog-unit-excerpt"><?php the_excerpt(); ?></div>
                <?php } ?>
                <div class="blog-unit-meta">
                    <?php arnold_interface_blog_show_meta('date'); ?><?php arnold_interface_blog_show_meta('category'); ?>
                </div>
            </section>
		<?php
        }
		wp_reset_postdata();
		
		$next_paged = (int) $paged + 1;
		
		if((int) $paged < $the_search->max_num_pages){
			echo '<div class="clearfix pagenums tw_style page_twitter">';
			echo '<a class="tw-style-a ux-btn container-inn" data-paged="' .esc_attr($next_paged). '" href="#">' . esc_attr__('Load More','arnold'). '</a>';
			echo '</div>';
		}
	}else{
		echo '<section class="search-result-unit">';
		esc_attr_e('Sorry, no result.','arnold');
		echo '</section>';
	}
}

//Function blog show meta
function arnold_interface_blog_min_read($post_id = false){
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

//Function blog show meta
function arnold_interface_blog_show_meta($meta, $container = false, $this_postid = false, $module_post = false){
	$showmeta = $showmeta = array('date', 'category', 'tag', 'author', 'continue-reading');
	
	$post = get_post(get_the_ID());
	
	if(is_single()){
		$showmeta = arnold_get_option('theme_option_posts_showmeta');
	}
	
	/*if(is_archive()||is_home()){
		$showmeta = array('date', 'category', 'tag', 'author', 'continue-reading');
	}*/
	
	// if(is_page()){
	// 	$showmeta = array('date', 'author');
	// }
	
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
				echo '<span class="article-meta-unit article-meta-date">' .esc_attr__('ON ','arnold'); echo get_the_date(). '</span>';
			}elseif($container == 'title'){
				echo '<span class="title-wrap-meta-b-item article-meta-date">' .esc_attr__('ON ','arnold'); echo get_the_date(). '</span>';
			}elseif($container == 'article'){
				echo '<span class="article-meta-date">'. get_the_date(). '</span>';
			}else{
				echo '<span class="article-meta-date">'. get_the_date(). '</span>';
			}
		}
		
		//category
		if($meta == 'category' && in_array($meta, $showmeta) && has_category()){
			if($container == 'single'){ ?>
				<span class="article-meta-unit article-meta-unit-cate">
			<?php
				echo arnold_theme_hide_category('  '); ?>
				</span>
			<?php }elseif($container == 'title'){
				arnold_theme_hide_category(' ');
			}elseif($container == 'article'){
				echo esc_attr__('IN: ','arnold');
				arnold_theme_hide_category(', ', 'archive-meta-a');
			}else{
				?>
			<div class="gird-blog-meta">
			<?php
				echo esc_attr__('IN ','arnold');
				arnold_theme_hide_category('  ', 'grid-meta-a');
			?>
			</div>
			<?php
			}
		}
		
		//tag
		if($meta == 'tag' && in_array($meta, $showmeta) && has_tag()){
			if($container == 'single'){
				echo '<div class="article-tag clearfix"><span class="article-tag-label">'; the_tags('<span class="article-tag-label-tit"></span>', ' '); echo '</span></div>';
			}elseif($container == 'title'){
				echo '<span class="title-wrap-meta-b-item">'; the_tags('/ '); echo '</span>';
			}elseif($container == 'article'){
				$posttags = get_the_tags();
				$separator = '/ ';
				$output = '';
				if($posttags){
					foreach($posttags as $tag) {
						$output .= '<a href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s",'arnold' ), $tag->name ) ) . '" class="archive-meta-a">'.$tag->name.'</a>'.$separator;
					}
				echo trim($output, $separator);
				}
			}
		}
		
		//author
		if($meta == 'author' && in_array($meta, $showmeta)){
			if($container == 'single'){
				echo '<span class="article-meta-unit">' .esc_attr__('BY: ','arnold'); the_author_meta('display_name', $post->post_author); echo '</span>';
			}elseif($container == 'title'){
				echo '<span class="title-wrap-meta-b-item">' .esc_attr__('BY: ','arnold'); the_author_meta('display_name', $post->post_author); echo '</span>';
			}elseif($container == 'article'){
				echo esc_attr__('BY: ','arnold'); the_author_meta('display_name', $post->post_author);
			}
		}
		
		//comments
		if($meta == 'comments' && in_array($meta, $showmeta)){
			$comments_count = wp_count_comments(get_the_ID());
			if($container == 'single'){ ?>
                <span class="article-meta-unit"><?php comments_number(esc_attr__('0 COMMENT', 'arnold'), esc_attr__('1 COMMENT', 'arnold'), esc_attr__('% COMMENTS', 'arnold') ); ?></span>
			<?php
            }elseif($container == 'title'){ ?>
                <span class="title-wrap-meta-b-item"><?php comments_number(esc_attr__('0 COMMENT', 'arnold'), esc_attr__('1 COMMENT', 'arnold'), esc_attr__('% COMMENTS', 'arnold') ); ?></span>
			<?php
			}elseif($container == 'article'){
				comments_number(esc_attr__('0 COMMENT', 'arnold'), esc_attr__('1 COMMENT', 'arnold'), esc_attr__('% COMMENTS', 'arnold') );
			}
		}
		
		//Continue Reading
		if($meta == 'continue-reading' && in_array($meta, $showmeta)){
			if($container == 'single'){
				echo '<div class="blog-unit-more"><a href="' .get_permalink(). '" class="blog-unit-more-a"><span class="blog-unit-more-txt">' .esc_html__('Continue Reading','arnold'). '</span> <span class="fa fa-long-arrow-right"></span></a></div>';
			}
		}		
	}
}

//Function video popup
function arnold_interface_video_popup(){ ?>
    <div class="video-overlay modal">
        <span class="video-close"></span>
    </div><!--end video-overlay-->
<?php
}

//dynamic sidebar
function arnold_dynamic_sidebar($index = 1, $count = 1){
	global $wp_registered_sidebars, $wp_registered_widgets;

	if(is_int($index)){
		$index = "sidebar-$index";
	}else{
		$index = sanitize_title($index);
		foreach((array) $wp_registered_sidebars as $key => $value){
			if(sanitize_title($value['name']) == $index){
				$index = $key;
				break;
			}
		}
	}

	$sidebars_widgets = wp_get_sidebars_widgets();
	if(empty($wp_registered_sidebars[ $index ]) || empty($sidebars_widgets[ $index ]) || ! is_array($sidebars_widgets[ $index ])){
		do_action('dynamic_sidebar_before', $index, false);
		do_action('dynamic_sidebar_after',  $index, false);
		return apply_filters('dynamic_sidebar_has_widgets', false, $index);
	}
	

	do_action('dynamic_sidebar_before', $index, true);
	$sidebar = $wp_registered_sidebars[$index];
	
	$widget_count = count((array) $sidebars_widgets[$index]);
	
	$col_class = 'col-md-4 col-sm-4';
	if($widget_count == 1){
		$col_class = 'col-md-12 col-sm-12';
	}elseif($widget_count == 2){
		$col_class = 'col-md-6 col-sm-6';
	}
	
	$did_one = false;
	foreach((array) $sidebars_widgets[$index] as $num => $id){
		
		if($num < $count){

			if(!isset($wp_registered_widgets[$id])) continue;
	
			$params = array_merge(
				array(array_merge($sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']))),
				(array) $wp_registered_widgets[$id]['params']
			);
	
			$classname_ = '';
			foreach((array) $wp_registered_widgets[$id]['classname'] as $cn){
				if(is_string($cn))
					$classname_ .= '_' . $cn;
				elseif(is_object($cn))
					$classname_ .= '_' . get_class($cn);
			}
			$classname_ = ltrim($classname_, '_');
			$params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);
			
			$params = apply_filters('dynamic_sidebar_params', $params);
			
			$params[0]['before_widget'] = str_replace('col-md-4 col-sm-4', $col_class, $params[0]['before_widget']);
	
			$callback = $wp_registered_widgets[$id]['callback'];
	
			do_action('dynamic_sidebar', $wp_registered_widgets[ $id ]);
	
			if(is_callable($callback)){
				call_user_func_array($callback, $params);
				$did_one = true;
			}
		}
	}

	do_action('dynamic_sidebar_after', $index, true);

	$did_one = apply_filters('dynamic_sidebar_has_widgets', $did_one, $index);

	return $did_one;
}

//theme exclude category
function arnold_theme_exclude_category($category){
	$hide_category = arnold_get_option('theme_option_hide_category_on_post_page');
	if($category){
		$return = array();
		foreach($category as $cat){
			if(!in_array($cat, $hide_category)){
				array_push($return, $cat);
			}
		}
	}else{
		$return = false;
	}
	//return $return;
	return $category;
}

//theme hide category
function arnold_theme_hide_category($separator= '', $class='article-cate-a', $data=array(), $has_cat=false, $post_id=false){
	$hide_category = arnold_get_option('theme_option_hide_category_on_post_page');
	if(!$hide_category){
		$hide_category = array();
	}
	
	if(!$post_id){
		$post_id = get_the_ID();
	}
	
	$has_cat_ids = array();
	if($has_cat){
		foreach((array) $has_cat as $cat){
			$get_category = get_category($cat);
			$has_cat_ids[] = $get_category->term_id;
			
			$get_categories = get_categories(array(
			  'parent' => $cat
			));
			
			if($get_categories){
				foreach($get_categories as $sub_cat){
					$has_cat_ids[] = $sub_cat->term_id;
				}
			}
		}
	}
	$has_cat_ids = array_unique($has_cat_ids);
	
	$categories = get_the_category($post_id);
	$output = '';
	if($categories){
		foreach($categories as $category){
			if(!in_array($category->term_id, $hide_category)){
				$data_array = array();
				if(count($data) != 0){
					foreach($data as $data_name => $data_val){
						if($data_name == 'data-filter'){
							$data_val = '.filter_' .$category->slug;
						}
						$data_array[] = $data_name. '="' .$data_val. '"';
					}
				}
				
				if($has_cat){
					if(in_array($category->term_id, $has_cat_ids)){
						$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s", 'arnold' ), $category->name ) ) . '" class="' .sanitize_html_class($class). '" ' .join(' ', $data_array). '>'.$category->cat_name.'</a>'.$separator;
					}
				}else{
					$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( esc_html__( "View all posts in %s", 'arnold' ), $category->name ) ) . '" class="' .sanitize_html_class($class). '"' .join(' ', $data_array). '>'.$category->cat_name.'</a>'.$separator;
				}
			}
		}
		echo trim($output, $separator);
	} 
}
add_action('arnold_interface_loop_the_category', 'arnold_theme_hide_category', 10);

//interface footer info elements
function arnold_interface_footer_info_element($type, $menu=false, $text=false){
	switch($type){
		case 'menu':
			if($menu){
				wp_nav_menu(array(
					'menu' => $menu,
					'container' => 'div',
					'container_class' => 'footer-menu',
					'items_wrap' => '<ul>%3$s</ul>',
					'fallback_cb' => false
				));
			}
		break;
		
		case 'text':
			if($text){ ?>
                <div class="footer-text">
					<?php echo wp_kses_stripslashes($text); ?>
                </div>
			<?php
            }
		break;
		
		case 'copyright': ?>
			<div class="copyright">
				<?php arnold_interface_copyright(); ?>
			</div>
		<?php
		break;
		
		case 'social':
			arnold_interface_footer_social();
		break;

		case 'logo':
			arnold_interface_logo('footer');
		break;

		case 'language':
			arnold_interface_language_flags(); 
		break;
	}
}

//ux plugins
function ux_theme_exclude_category($category){
	return arnold_theme_exclude_category($category);
} 

//portfolio template
function arnold_interface_portfolio_template_layout($post_id, $col, $num=false){
	$post_id = intval($post_id);
	$col_class = 'list-layout-col1-item';
	$image_size = 'arnold-standard-thumb-big';
	
	if($col == 'list_layout_5'){
		$layout_builder_content = arnold_get_post_meta(get_the_ID(), 'layout-builder-content');
		if($num && $layout_builder_content){
			if(isset($layout_builder_content[$num])){ ?>
                <div class="list-layout-text">
					<?php echo balanceTags($layout_builder_content[$num]); ?>
                </div>
			<?php
            }
        }
    }else{
		switch($col){
			case 'list_layout_1': $col_class = 'list-layout-col1-item'; $image_size = 'arnold-standard-thumb-big'; break;
			case 'list_layout_2': $col_class = 'list-layout-col2-item'; $image_size = 'arnold-standard-thumb-medium'; break;
			case 'list_layout_3': $col_class = 'list-layout-col3-item'; $image_size = 'arnold-standard-thumb'; break;
			case 'list_layout_4': $col_class = 'list-layout-col4-item'; $image_size = 'arnold-standard-thumb'; break;
		}
		
		$image_post = get_post($post_id);
		$thumbnail_caption = $image_post ? $image_post->post_excerpt : '';
		$thumb = wp_get_attachment_image_src($post_id, $image_size);
		if(!$thumb){
			$thumb = wp_get_attachment_image_src($post_id, 'medium');
		}
		
		$thumb_full = wp_get_attachment_image_src($post_id, 'full');

		$thumb_padding_top = false;
		if($thumb[1] > 0 && $thumb[2] > 0) {
			$thumb_padding_top = 'padding-top: ' . (intval($thumb[2]) / intval($thumb[1])) * 100 . '%;';
		}
		$data_size = $thumb_full[1]. 'x' .$thumb_full[2];

		$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');
		$image_lazyload_img_style = 'src="' .get_template_directory_uri(). '/img/blank.gif" data-src="' .esc_url($thumb[0]). '"';
		$image_lazyload_img_class = 'lazy';
		if(!$image_lazyload){
			$image_lazyload_img_style = 'src="' .esc_url($thumb[0]). '"';
			$image_lazyload_img_class = '';
		} ?>
		
		<div class="<?php echo sanitize_html_class($col_class); ?> list-layout-item" style="">
			<div class="list-layout-inside">
				<div class="single-image mouse-over" data-lightbox="true">
					<a title="<?php echo esc_attr($thumbnail_caption); ?>" class="lightbox-item" href="<?php echo esc_url($thumb_full[0]); ?>" data-size="<?php echo esc_attr($data_size); ?>">
						<span class="ux-lazyload-wrap" style=" <?php echo esc_attr($thumb_padding_top); ?>">
							<img alt="<?php echo get_the_title($post_id); ?>" title="<?php echo get_the_title($post_id); ?>" <?php echo balanceTags($image_lazyload_img_style); ?> width="<?php echo esc_attr($thumb[1]); ?>" height="<?php echo esc_attr($thumb[2]); ?>" class="list-layout-img gallery-images-img ux-lazyload-img <?php echo sanitize_html_class($image_lazyload_img_class); ?>">
						</span>
					</a>
				</div>
			</div><!--End list-layout-inside-->	
		</div><!--End list-layout-item-->
	<?php
	}
}

//page menu filter wrap
function arnold_interface_header_menu_filter_wrap(){
	$item_output = '';
	$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
	$page_show_filter = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_filter');
	if($page_template != 'none' && $page_template != 'custom-list'){
		if($page_show_filter == 'on-menu'){
			$category = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_category');
			if($page_template == 'masonry-grid'){
				$category = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_category_masonry_grid');
			}
			if(is_array($category)){
				$category = $category[0];
			}
			
			$get_category = get_category($category);
			$get_categories = get_categories(array(
				'parent' => $category
			));
			
			$category_count = 0;
			if($get_category){
				$get_posts = get_posts(array(
					'posts_per_page' => -1,
					'category__in' => $category,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery', 'post-format-link'),
						)
					)
				));
				$category_count = count($get_posts);
			}
			

			if($get_categories){
				$item_output .= '<li class="external menu-item active"><a data-filter="*" href="#">'.esc_html__('All','arnold').'<span class="filter-num">' .esc_html($category_count). '</span></a></li>';
				foreach($get_categories as $num => $category){
					$category_count = $category->count;
				
					if($page_template == 'masonry-grid'){
						$get_posts = get_posts(array(
							'posts_per_page' => -1,
							'cat' => $category->term_id,
							'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => array('post-format-gallery', 'post-format-link'),
								)
							)
						));
						$category_count = count($get_posts);
					}
					
					$item_output .= sprintf('<li class="external menu-item"><a data-filter=".filter_%1$s" href="%2$s" data-catid="%5$s" data-pageid="%6$s">%3$s<span class="filter-num">%4$s</span></a></li>',
						esc_attr($category->slug),
						esc_url(get_category_link($category->term_id)),
						esc_html($category->name),
						esc_html($category_count),
						esc_attr($category->term_id),
						esc_attr(get_the_ID())
					);
				}
			}
		}
	}
	
	return $item_output;
}

//header columned menu items
function arnold_interface_header_columned_menu_items($items, $args){
	$return = '';
	
	if($args->container_id == 'navi_wrap'){
		$header_layout = arnold_get_option('theme_option_header_layout');
		if($header_layout == 'columned-menu-right'){
			$return .= '<li class="menu-level1"><ul>';
			$return .= $items;
			$return .= '</ul></li>';
			
			$page_show_filter = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_filter');
			if($page_show_filter == 'on-menu'){
				$return .= '<li class="menu-level1 menu-filter"><ul>';
				$return .= arnold_interface_header_menu_filter_wrap();
				$return .= '</ul></li>';
			}
		}else{
			$return = $items;
		}
	}else{
		$return = $items;
	}
	
	return $return;
}
add_filter( 'wp_nav_menu_items', 'arnold_interface_header_columned_menu_items', 10, 2 );

//page menu filter
function arnold_interface_header_menu_filter($item_output, $item, $depth, $args){
	if($args->container_id == 'navi_wrap'){
		$header_layout = arnold_get_option('theme_option_header_layout');
		if($header_layout == 'horizon-menu-right' || $header_layout == 'horizon-menu-left'){
			if(get_the_ID() == $item->object_id){
				$page_show_filter = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_filter');
				if($page_show_filter == 'on-menu'){
					$item_output .= '<ul class="sub-menu menu-filter-wrap">';
					$item_output .= arnold_interface_header_menu_filter_wrap();
					$item_output .= '</ul>';
				}
			}
		}
	}
	
	return $item_output;
	
}
add_filter('walker_nav_menu_start_el', 'arnold_interface_header_menu_filter', 10, 4);

//wp get attachment image src
function arnold_wp_get_attachment_image_src($image, $attachment_id, $size){
	if($size != 'full'){
		$image_pathinfo = pathinfo($image[0]);
		
		if(isset($image_pathinfo['extension'])){
			if($image_pathinfo['extension'] == 'gif'){
				$thumb = wp_get_attachment_image_src($attachment_id, 'full');
				
				$src = $thumb[0];
				$width = $thumb[1];
				$height = $thumb[2];
				$image = array( $src, $width, $height );
			}
		}
	}
	
	return $image;
}
add_filter('wp_get_attachment_image_src', 'arnold_wp_get_attachment_image_src', 10, 3);

?>