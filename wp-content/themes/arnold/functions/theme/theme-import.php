<?php
///////////////////
// Import start //
/////////////////

//theme import layerslider
function arnold_import_layerslider(){
	global $wpdb;
	
	$table_layerslider = $wpdb->prefix . "layerslider";
	$sql = "CREATE TABLE $table_layerslider (
			  id int(10) NOT NULL AUTO_INCREMENT,
			  name varchar(100) NOT NULL,
			  data mediumtext NOT NULL,
			  date_c int(10) NOT NULL,
			  date_m int(11) NOT NULL,
			  flag_hidden tinyint(1) NOT NULL DEFAULT 0,
			  flag_deleted tinyint(1) NOT NULL DEFAULT 0,
			  PRIMARY KEY  (id)
			);";
			
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}
add_action( 'import_start', 'arnold_import_layerslider', 9 );

//theme import nav menu
function arnold_import_nav_menu(){
	$get_nav_menu = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'nav_menu_item'
	));
	
	if($get_nav_menu){
		foreach($get_nav_menu as $nav_menu){
			wp_delete_post($nav_menu->ID);
		}
	}
}
add_action( 'import_start', 'arnold_import_nav_menu' );

//theme import xmldata
function arnold_import_xmldata(){
	if(!empty( $_POST['xml'] )){
		$file = $_POST['xml'];
	}else{
		$this_id = (int) $_POST['import_id'];
		$file = get_attached_file( $this_id );
	}
	$result = simplexml_load_file($file, null, LIBXML_NOCDATA);

	$xml_data = $theme_option_data = $icons_custom_data = array();
	$posts_data = $attachment_data = $posts_meta_data = array();
	$category_data = $taxonomy_data = array();
	$widget_data = $front_data = array();
	$nav_menu_anchor_data = $nav_menu_locations_data = array();
	
	//theme option
	$theme_option = $result->channel->theme_option;
	if($theme_option){
		foreach($theme_option->children() as $name => $option){
			if(is_serialized((string) $option)){
				$theme_option_data[$name] = maybe_unserialize((string) $option);
			}else{
				$theme_option_data[$name] = (string) $option;
			}
		}
	}
	
	//icons custom
	$icons_custom = $result->channel->theme_icons_custom;
	if($icons_custom){
		$icons_custom = json_decode(json_encode($icons_custom), true);
		$icons_custom = maybe_unserialize($icons_custom[0]);
		$icons_custom_data = $icons_custom;
	}
	
	//category
	$category= $result->channel->children('wp',true)->category;
	if($theme_option){
		foreach($category as $cat){
			$term_id = $cat->children('wp',true)->term_id;
			$category_nicename = $cat->children('wp',true)->category_nicename;
			$cat_name = $cat->children('wp',true)->cat_name;
			
			$category_data[] = array(
				'term_id' => (int) $term_id,
				'category_nicename' => (string) $category_nicename,
				'cat_name' => (string) $cat_name
			);
		}
	}
	
	//taxonomy
	$taxonomy = $result->channel->children('wp',true)->term;
	if($taxonomy){
		foreach($taxonomy as $tax){
			$term_id = $tax->children('wp',true)->term_id;
			$term_name = $tax->children('wp',true)->term_name;
			$term_slug = $tax->children('wp',true)->term_slug;
			$term_taxonomy = $tax->children('wp',true)->term_taxonomy;
			
			$taxonomy_data[] = array(
				'term_id' => (int) $term_id,
				'term_name' => (string) $term_name,
				'term_slug' => (string) $term_slug,
				'term_taxonomy' => (string) $term_taxonomy
			);
		}
	}
	
	//posts
	$posts = $result->channel->item;
	if($posts){
		foreach($posts as $post){
			$post_title = $post->title;
			$post_id = $post->children('wp',true)->post_id;
			$post_type = $post->children('wp',true)->post_type;
			$post_date = $post->children('wp',true)->post_date;
			switch($post_type){
				case 'post':
					$posts_data[] = array(
						'post_id' => (int) $post_id,
						'post_title' => (string) $post_title,
						'post_date' => (string) $post_date
					);
				break;
				
				case 'attachment':
					$attachment_url = $post->children('wp',true)->attachment_url;
					$attachment_path = pathinfo((string) $attachment_url);
					$attachment_data[] = array(
						'post_id' => (int) $post_id,
						'post_title' => (string) $post_title,
						'post_date' => (string) $post_date,
						'attachment_url' => (string) $attachment_url,
						'filename' => (string) $attachment_path['filename'],
						'dirname' => (string) $attachment_path['dirname']
					);
				break;
			}
			
			//meta
			$meta_data = array();
			$postmeta = $post->children('wp',true)->postmeta;
			foreach($postmeta as $meta){
				$meta_key = (string) $meta->children('wp',true)->meta_key;
				$meta_value = (string) $meta->children('wp',true)->meta_value;
				switch($meta_key){
					case 'ux_theme_meta':
						$meta_data = array(
							'meta_key' => $meta_key,
							'meta_value' => $meta_value
						);
					break;
					
					//nav menu anchor
					case '_menu_item_anchor':
						$nicename = '';
						foreach($post->category->attributes() as $attributes_name => $attributes_value){
							if($attributes_name == 'nicename'){
								$nicename = $attributes_value;
							}
						}
						
						$menu_order = $post->children('wp',true)->menu_order;
						$nav_menu_anchor_data[] = array(
							'post_id' => (int) $post_id,
							'post_title' => (string) $post_title,
							'post_date' => (string) $post_date,
							'meta_value' => (string) $meta_value,
							'category' => (string) $nicename,
							'menu_order' => (int) $menu_order
						);
					break;
				}
			}
			
			if(count($meta_data) != 0){
				$posts_meta_data[] = array(
					'post_id' => (int) $post_id,
					'postmeta' => $meta_data
				);
			}
			
			//front page
			$show_on_front = $result->channel->theme_front_page->show_on_front;
			$page_on_front = $result->channel->theme_front_page->page_on_front;
			if((int) $post_id == (int) $page_on_front){
				$front_data = array(
					'post_id' => (int) $post_id,
					'post_title' => (string) $post_title,
					'post_date' => (string) $post_date,
					'show' => (string) $show_on_front
				); 
			}
		}
	}
	
	//nav menu locations
	$nav_menu_locations = $result->channel->nav_menu_locations;
	if($nav_menu_locations){
		foreach($nav_menu_locations as $locations){
			$nav_menu_locations_data = array(
				'menu_name' => (string) $locations->menu_name,
				'menu_slug' => (string) $locations->menu_slug
			);
		}
	}
	
	//widgets
	$widgets = array(
		'sidebars_widgets'       => (string) $result->channel->sidebars_widgets,
		'widget_categories'      => (string) $result->channel->theme_widgets->widget_categories,
		'widget_text'            => (string) $result->channel->theme_widgets->widget_text,
		'widget_rss'             => (string) $result->channel->theme_widgets->widget_rss,
		'widget_search'          => (string) $result->channel->theme_widgets->widget_search,
		'widget_recent-posts'    => (string) $result->channel->theme_widgets->widget_recent_posts,
		'widget_recent-comments' => (string) $result->channel->theme_widgets->widget_recent_comments,
		'widget_archives'        => (string) $result->channel->theme_widgets->widget_archives,
		'widget_meta'            => (string) $result->channel->theme_widgets->widget_meta,
		'widget_calendar'        => (string) $result->channel->theme_widgets->widget_calendar,
		'widget_uxconatactform'  => (string) $result->channel->theme_widgets->widget_uxconatactform,
		'widget_nav_menu'        => (string) $result->channel->theme_widgets->widget_nav_menu,
		'widget_pages'           => (string) $result->channel->theme_widgets->widget_pages,
		'widget_uxsocialinons'   => (string) $result->channel->theme_widgets->widget_uxsocialinons,
		'widget_tag_cloud'       => (string) $result->channel->theme_widgets->widget_tag_cloud
	);
	
	foreach($widgets as $name => $value){
		if(is_serialized((string) $value)){
			$widget_data[$name] = maybe_unserialize((string) $value);
		}else{
			$widget_data[$name] = (string) $value;
		}
	}
	
	//layerslider
	$layerslider = $result->channel->layerslider;
	if($layerslider){
		global $wpdb;
		
		foreach($layerslider as $slider){
			$id           = $slider->id;
			$name         = $slider->name;
			$data         = $slider->data;
			$date_c       = $slider->date_c;
			$date_m       = $slider->date_m;
			$flag_hidden  = $slider->flag_hidden;
			$flag_deleted = $slider->flag_deleted;
			
			$slider_row = $wpdb->get_row($wpdb->prepare("
				SELECT * FROM $table_layerslider
				WHERE date_c = %s 
				AND name = %s
				",
				$date_c,
				$name
			));
			
			if(!$slider_row){
				$wpdb->insert( 
					$table_layerslider, 
					array( 
						'name'         => $name, 
						'data'         => $data, 
						'date_c'       => $date_c,
						'date_m'       => $date_m, 
						'flag_hidden'  => $flag_hidden, 
						'flag_deleted' => $flag_deleted 
					),
					array(
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s'
					)
				);
				
				$new_id = $wpdb->insert_id;
			}else{
				$new_id = $slider_row->id;
			}
			
			$wpdb->insert( 
				$wpdb->options, 
				array( 
					'option_name'  => 'import_cache_layerslider_'.$id, 
					'option_value' => $new_id
				),
				array(
					'%s',
					'%s'
				)
			);
		}
	}
	
	$xml_data = array(
		'theme_option' => $theme_option_data,
		'icons_custom' => $icons_custom_data,
		'posts' => $posts_data,
		'posts_meta' => $posts_meta_data,
		'nav_menu_anchor' => $nav_menu_anchor_data,
		'nav_menu_locations' => $nav_menu_locations_data,
		'front' => $front_data,
		'attachments' => $attachment_data,
		'categories' => $category_data,
		'taxonomies' => $taxonomy_data,
		'widgets' => $widget_data
	);
	
	$GLOBALS['import_fetch_attachments'] = '';
	$GLOBALS['import_xmlcache'] = $xml_data;
	
	if(isset($_POST['fetch_attachments'])){
		$GLOBALS['import_fetch_attachments'] = $_POST['fetch_attachments'];
	}
	
}
add_action( 'import_start', 'arnold_import_xmldata' );

////////////////
// Importing //
//////////////

function ux_import_process_post_meta_preg($m){
	$m0 = strlen($m[2]);
	$m1 = $m[2];
	return 's:' .$m0. ':"' .$m1. '";';
}

//theme import reimport postmeta
function arnold_import_reimport_post_meta($post_id, $key, $value){
	global $import_xmlcache;
	
	if($import_xmlcache){
		//theme option
		if(isset($import_xmlcache['posts_meta'])){
			$meta_data = $import_xmlcache['posts_meta'];
			foreach($meta_data as $meta){
				$item_id = $meta['post_id'];
				if((int) $item_id == (int) $post_id){
					$postmeta = $meta['postmeta'];
					$meta_key = $postmeta['meta_key'];
					$meta_value = $postmeta['meta_value'];
					
					$meta_value = str_replace(array("\r\n", "\r", "\n"), "", $meta_value);
					$preg_value = preg_replace_callback(
						'/s:(\d+):"(.*?)";/',
						ux_import_process_post_meta_preg, $meta_value
					);
					
					$meta_value = maybe_unserialize($preg_value);
					update_post_meta( $post_id, 'ux_theme_meta', $meta_value);
				}
			}
		}
	}
}
add_action('reimport_post_meta', 'arnold_import_reimport_post_meta', 10, 3);

/////////////////
// Import end //
///////////////

//theme import process post
function arnold_import_process_post(){
	global $wpdb, $import_fetch_attachments;
	
	//delete too much meta
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'any',
		'post_status' => 'any'
	));
	
	if($get_posts){
		foreach($get_posts as $post){
			$get_post_meta = $wpdb->get_results($wpdb->prepare("
				SELECT `meta_id`, `meta_key`, `meta_value`
				FROM $wpdb->postmeta 
				WHERE `post_id` = %d
				",
				$post->ID
			));
			
			if($get_post_meta){
				foreach($get_post_meta as $meta){
					$meta_value = get_post_meta($post->ID, $meta->meta_key, false);
					
					if(count($meta_value) > 1){
						$this_meta_value = get_post_meta($post->ID, $meta->meta_key, true);
						delete_post_meta($post->ID, $meta->meta_key, $this_meta_value);
						add_post_meta($post->ID, $meta->meta_key, $this_meta_value);
					}
				}
			}
		}
	}
	
	//post gallery library
	$get_post_gallery = $wpdb->get_results($wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = '%s')
		AND (`meta_key` LIKE '%s')
		AND (`meta_value` LIKE '%s'))
		", 'post', 'ux_theme_meta', '%theme_meta_portfolio%'
	));
	
	if($get_post_gallery){
		foreach($get_post_gallery as $gallery){
			$post_id = $gallery->ID;
			$get_post_meta = get_post_meta($post_id, 'ux_theme_meta', true);
			if($get_post_meta){
				foreach($get_post_meta as $meta_key => $meta_value){
					if($meta_key == 'theme_meta_portfolio'){
						if(is_array($meta_value)){
							foreach($meta_value as $num => $image){
								$attachment_id = arnold_import_attachment_replace('id', $image);
								$get_post_meta['theme_meta_portfolio'][$num] = $attachment_id;
							}
						}
					}
				}
				update_post_meta($post_id, 'ux_theme_meta', $get_post_meta);
			}
		}
	}
	
	//layerslider
	$get_layerslider = $wpdb->get_results($wpdb->prepare("
		SELECT `post_id`, `meta_key`
		FROM $wpdb->postmeta 
		WHERE `meta_value` LIKE '%s'
		", '%layerslider%'
	));
	
	if($get_layerslider){
		foreach($get_layerslider as $layerslider){
			$post = get_post($layerslider->post_id);
			switch($post->post_type){
				case 'post':
					$get_post_meta = get_post_meta($layerslider->post_id, 'ux_theme_meta', true);
					foreach($get_post_meta as $name => $value){
						if($name == 'theme_meta_title_bar_slider_value'){
							$new_id = get_option('import_cache_layerslider_' . $value);;
							$get_post_meta['theme_meta_title_bar_slider_value'] = $new_id;
						}
					}
					update_post_meta($layerslider->post_id, 'ux_theme_meta', $get_post_meta);
				break;
			}
		}
	}
}
add_action( 'import_end', 'arnold_import_process_post', 11 );

//theme import process category taxonomy
function arnold_import_process_post_taxonomy(){
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => array('page', 'post', 'bmslider'),
		'post_status' => 'any',
		'meta_key' => 'ux_theme_meta'
	));
	
	if($get_posts){
		foreach($get_posts as $post){
			$arnold_theme_meta = get_post_meta($post->ID, 'ux_theme_meta', true);
			if(isset($arnold_theme_meta['theme_meta_page_portfolio_category'])){
				$category_id = $arnold_theme_meta['theme_meta_page_portfolio_category'];
				$category_id = arnold_import_taxonomy_replace('category', $category_id);
				
				$arnold_theme_meta['theme_meta_page_portfolio_category'] = $category_id;
				update_post_meta($post->ID, 'ux_theme_meta', $arnold_theme_meta);
			}
			
			if(isset($arnold_theme_meta['theme_meta_page_category_masonry_grid'])){
				$category_id = $arnold_theme_meta['theme_meta_page_category_masonry_grid'];
				$category_id = arnold_import_taxonomy_replace('category', $category_id);
				
				$arnold_theme_meta['theme_meta_page_category_masonry_grid'] = $category_id;
				update_post_meta($post->ID, 'ux_theme_meta', $arnold_theme_meta);
			}
			
			if(isset($arnold_theme_meta['theme_meta_page_category'])){
				$category_ids = $arnold_theme_meta['theme_meta_page_category'];
				$category_array = array();
				if(is_array($category_ids)){
					foreach($category_ids as $category_id){
						$category_id = arnold_import_taxonomy_replace('category', $category_id);
						array_push($category_array, $category_id);
					}
				}else{
					$category_id = arnold_import_taxonomy_replace('category', $category_ids);
					array_push($category_array, $category_id);
				}
				
				$arnold_theme_meta['theme_meta_page_category'] = $category_array;
				update_post_meta($post->ID, 'ux_theme_meta', $arnold_theme_meta);
			}
			
			if(isset($arnold_theme_meta['theme_bmslider_category'])){
				$category_ids = $arnold_theme_meta['theme_bmslider_category'];
				$category_array = array();
				if(is_array($category_ids)){
					foreach($category_ids as $category_id){
						$category_id = arnold_import_taxonomy_replace('category', $category_id);
						array_push($category_array, $category_id);
					}
				}else{
					$category_id = arnold_import_taxonomy_replace('category', $category_ids);
					array_push($category_array, $category_id);
				}
				
				$arnold_theme_meta['theme_bmslider_category'] = $category_array;
				update_post_meta($post->ID, 'ux_theme_meta', $arnold_theme_meta);
			}
		}
	}
	
	//portfolio list layout
	global $wpdb;
	$get_portfolio_list_layout = $wpdb->get_results($wpdb->prepare("
		SELECT `post_id`, `meta_key`
		FROM $wpdb->postmeta
		WHERE `meta_key` LIKE '%s'
		", '%' .$wpdb->esc_like('_portfolio_list_layout_'). '%'
	));
	
	if($get_portfolio_list_layout){
		foreach($get_portfolio_list_layout as $list_layout){
			if($list_layout->meta_key != '_portfolio_list_layout_cat'){
				$get_post_meta = get_post_meta($list_layout->post_id, $list_layout->meta_key, true);
				$meta_key = explode('_portfolio_list_layout_', $list_layout->meta_key);
				$category_id = arnold_import_taxonomy_replace('category', $meta_key[1]);
				$new_meta_key = '_portfolio_list_layout_' .$category_id;
				
				foreach($get_post_meta as $num => $grid_stack){
					foreach($grid_stack as $grid_key => $grid){
						if($grid_key == 'post_id'){
							$post_id = arnold_import_post_replace($grid);
							$get_post_meta[$num]['post_id'] = $post_id;
						}
						
					}
				}
				
				delete_post_meta($list_layout->post_id, $list_layout->meta_key);
				update_post_meta($list_layout->post_id, $new_meta_key, $get_post_meta);
			}
		}
	}
}
add_action( 'import_end', 'arnold_import_process_post_taxonomy', 11 );

//theme import process theme option
function arnold_import_process_themeoption(){
	global $import_xmlcache, $import_fetch_attachments;
	
	if($import_xmlcache){
		//theme option
		if(isset($import_xmlcache['theme_option'])){
			$theme_option = $import_xmlcache['theme_option'];
			update_option('ux_theme_option', $theme_option);
		}
		
		//icons_custom
		if(isset($import_xmlcache['icons_custom'])){
			$icons_custom = $import_xmlcache['icons_custom'];
			foreach($icons_custom as $num => $icon_id){
				$icons_custom[$num] = arnold_import_attachment_replace('id', $icon_id);
				
				if(isset($_POST['action'])){
					if($_POST['action'] == 'arnold_theme_process_demo_images_ajax'){
						$import_fetch_attachments = false;
					}
				}
				
				if(!$import_fetch_attachments){
					$demo_attachment = get_option('ux_theme_demo_attachment');
					if(!$demo_attachment){
						$demo_attachment = arnold_import_create_demo_image();
					}
					$icons_custom[$num] = $demo_attachment;
				}
			}
			update_option('ux_theme_option_icons_custom', $icons_custom);
		}
	}
}
add_action( 'import_end', 'arnold_import_process_themeoption', 11 );

//theme import process widgets
function arnold_import_process_widgets(){
	global $import_xmlcache;
	
	if($import_xmlcache){
		if(isset($import_xmlcache['widgets'])){
			foreach($import_xmlcache['widgets'] as $name => $value){
				update_option($name, $value);
			}
		}
	}
}
add_action( 'import_end', 'arnold_import_process_widgets', 11 );

//theme import process front page
function arnold_import_process_front_page(){
	global $import_xmlcache;
	
	if($import_xmlcache){
		$get_posts = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'any'
		));
		
		if(isset($import_xmlcache['front'])){
			$front_data = $import_xmlcache['front'];
			$post_title = $front_data['post_title'];
			$post_date = $front_data['post_date'];
			$show = $front_data['show'];
			
			if($show == ''){
				update_option('show_on_front', 'page'); 
			}else{
				update_option('show_on_front', $show); 
			}
			
			if($post_date != ''){
				foreach($get_posts as $post){
					if($post->post_date == $post_date && $post->post_title == $post_title){
						update_option('page_on_front', $post->ID); 
					}
				}
			}else{
				update_option('page_on_front', 0); 
			}
		}
	}
}
add_action( 'import_end', 'arnold_import_process_front_page', 11 );

//theme import process nav menu
function arnold_import_process_nav_menu(){
	global $import_xmlcache;
	
	if($import_xmlcache){
		if(isset($import_xmlcache['nav_menu_anchor'])){
			$nav_menu_anchor = $import_xmlcache['nav_menu_anchor'];
			foreach($nav_menu_anchor as $anchor){
				$post_id = $anchor['post_id'];
				$post_title = $anchor['post_title'];
				$post_date = $anchor['post_date'];
				$menu_order = $anchor['menu_order'];
				$category = $anchor['category'];
				$meta_value = $anchor['meta_value'];
				
				$items = wp_get_nav_menu_items($category);
				
				if($items){
					foreach($items as $item){
						if($item->menu_order == $menu_order){
							update_post_meta($item->ID, '_menu_item_anchor', $meta_value);
						}
					}
				}
			}
		}
	}
}
add_action( 'import_end', 'arnold_import_process_nav_menu', 11 );

//theme import process nav menu locations
function arnold_import_process_nav_menu_locations(){
	global $import_xmlcache;
	
	if($import_xmlcache){
		$nav_menu_locations = get_theme_mod('nav_menu_locations');
		if(isset($import_xmlcache['nav_menu_locations'])){
			$nav_menu_locations = $import_xmlcache['nav_menu_locations'];
			$menu_name = $nav_menu_locations['menu_name'];
			$menu_slug = $nav_menu_locations['menu_slug'];
			
			$get_term_by = get_term_by('slug', $menu_slug, 'nav_menu');
			$menu_id = $get_term_by->term_id;
			
			$nav_menu_locations[$menu_name] = $menu_id;
		}
		set_theme_mod('nav_menu_locations', $nav_menu_locations);
	}
}
add_action( 'import_end', 'arnold_import_process_nav_menu_locations', 11 );

//theme import process end demo images
function arnold_import_process_end_demo_images(){
	global $import_fetch_attachments;
	
	//process demo images
	if(!$import_fetch_attachments){
		arnold_theme_process_demo_images_ajax();
	}
}
add_action( 'import_end', 'arnold_import_process_end_demo_images', 99 );

//theme remove pb action
if( has_action( 'import_end', 'ux_import_module_set_taxonomy' ) ) { remove_action( 'import_end' , 'ux_import_module_set_taxonomy' ); }
if( has_action( 'import_end', 'ux_import_module_layerslider' ) ) { remove_action( 'import_end' , 'ux_import_module_layerslider' ); }
if( has_action( 'import_end', 'arnold_import_post_replace' ) ) { remove_action( 'import_end' , 'arnold_import_post_replace' ); }
if( has_action( 'ux_theme_process_demo_images_ajax', 'ux_import_process_modules_demo_images' ) ) { remove_action( 'ux_theme_process_demo_images_ajax', 'ux_import_process_modules_demo_images' ); }

//theme import process pb
function arnold_import_process_pb(){
	global $wpdb;
	
	//taxonomy
	$db_query = $wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = '%s')
		AND (`meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s'
		  OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s'
		  OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s'
		  OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s'))
		", 'modules',
		'module_carousel_category', 'module_blog_category', 'module_gallery_category', 'module_latestpost_category', 'module_liquidlist_category',
		'module_portfolio_category', 'module_slider_category', 'module_client_category', 'module_faq_category', 'module_jobs_category',
		'module_team_category', 'module_testimonials_category', 'block_column_1_post_ategory', 'block_column_2_post_ategory', 'block_column_3_post_ategory',
		'block_column_1_post_category', 'block_column_2_post_category', 'block_column_3_post_category'
	);
	$get_category = $wpdb->get_results($db_query);
	
	if($get_category){
		foreach($get_category as $category){
			$category_id = $category->meta_value;
			$post_id = $category->ID;
			$post_type = get_post($post_id)->post_type;
			$meta_key = $category->meta_key;
			$category_taxonomy = 'category';
			$cats = get_post_meta($post_id, $meta_key, true);
			
			switch($meta_key){
				case 'module_client_category':       $category_taxonomy = 'client_cat'; break;
				case 'module_faq_category':          $category_taxonomy = 'question_cat'; break;
				case 'module_jobs_category':         $category_taxonomy = 'job_cat'; break;
				case 'module_team_category':         $category_taxonomy = 'team_cat'; break;
				case 'module_testimonials_category': $category_taxonomy = 'testimonial_cat'; break;
			}
			
			if(is_array($cats)){
				$category_id = array();
				foreach($cats as $cat_ID){
					$cat_ID = arnold_import_taxonomy_replace($category_taxonomy, $cat_ID);
					array_push($category_id, $cat_ID);
				}
			}else{
				$category_id = arnold_import_taxonomy_replace($category_taxonomy, $category_id);
			}
			
			update_post_meta($post_id, $meta_key, $category_id);
		}
	}
	
	//layerslider
	$db_query = $wpdb->prepare("
		SELECT `post_id`, `meta_key`
		FROM $wpdb->postmeta
		WHERE `meta_value` LIKE '%s'
		", '%layerslider%'
	);
	$get_layerslider = $wpdb->get_results($db_query);
	
	if($get_layerslider){
		foreach($get_layerslider as $layerslider){
			$post = get_post($layerslider->post_id);
			switch($post->post_type){
				case 'modules':
					$get_post_meta = get_post_meta($layerslider->post_id, 'module_slider_layerslider', true);
					$new_id = get_option('import_cache_layerslider_' . $get_post_meta);
					update_post_meta($layerslider->post_id, 'module_slider_layerslider', $new_id);
				break;
			}
		}
	}
	
	//module image box / single image ／ all images
	$db_query_image = $wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = '%s')
		AND (`meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s'
		  OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s'))
		", 'modules',
		'module_singleimage_image', 'module_imagebox_image', 'module_fullwidth_background_image', 'module_fullwidth_alt_image', 'module_video_cover',
		'module_googlemap_pin_custom', 'block_column_1_bg_image', 'block_column_2_bg_image', 'block_column_2_bg_image'
	);
	$get_module_image = $wpdb->get_results($db_query_image);
	
	if($get_module_image){
		foreach($get_module_image as $module_image){
			$image_url = $module_image->meta_value;
			$post_id = $module_image->ID;
			$post_type = get_post($post_id)->post_type;
			$attachment_url = arnold_import_attachment_replace('url', $image_url);
			update_post_meta($post_id, $module_image->meta_key, $attachment_url);
		}
	}
	
	//module button image
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_status' => 'any',
		'post_type' => 'modules',
		'meta_key' => 'module_button_items'
	));
	
	if($get_posts){
		foreach($get_posts as $post){
			$button_items = get_post_meta($post->ID, 'module_button_items', true);
			if($button_items){
				if(count($button_items['module_button_items_image']) != 0){
					foreach($button_items['module_button_items_image'] as $num => $image){
						if($image != ''){
							$button_items['module_button_items_image'][$num] = arnold_import_attachment_replace('url', $image);
						}
					}
					update_post_meta($post->ID, 'module_button_items', $button_items);
				}
			}
		}
	}
	
	//module gallery library
	$db_query_gallery = $wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = '%s')
		AND (`meta_key` LIKE '%s'))
		", 'modules', 'module_gallery_library'
	);
	$get_module_gallery = $wpdb->get_results($db_query_gallery);
	
	if($get_module_gallery){
		foreach($get_module_gallery as $gallery){
			$post_id = $gallery->ID;
			$get_post_meta = get_post_meta($post_id, 'module_gallery_library', true);
			if($get_post_meta){
				if(is_array($get_post_meta)){
					foreach($get_post_meta as $num => $image){
						$attachment_id = arnold_import_attachment_replace('id', $image);
						$get_post_meta[$num] = $attachment_id;
					}
				}else{
					$attachment_id = arnold_import_attachment_replace('id', $image);
					$get_post_meta = $attachment_id;
				}
				update_post_meta($post_id, 'module_gallery_library', $get_post_meta);
			}
		}
	}
	
	//module fullwidth block
	$db_query_slider = $wpdb->prepare("
		SELECT 
		`$wpdb->postmeta`.`post_id` as 'ID',
		`$wpdb->postmeta`.`meta_key` as 'meta_key',
		`$wpdb->postmeta`.`meta_value` as 'meta_value',
		`$wpdb->posts`.`post_type` as 'post_type'
		
		FROM $wpdb->postmeta, $wpdb->posts
		
		WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
		AND (`$wpdb->posts`.`post_type` = '%s')
		AND (`meta_key` LIKE '%s'
		  OR `meta_key` LIKE '%s'
		  OR `meta_key` LIKE '%s'))
		", 'modules', 'block_column_1_bm_slider', 'block_column_2_bm_slider', 'block_column_3_bm_slider'
	);
	$get_module_slider = $wpdb->get_results($db_query_slider);
	
	if($get_module_slider){
		foreach($get_module_slider as $module_slider){
			$post_id = $module_slider->ID;
			$slider_id = $module_slider->meta_value;
			$slider_id = arnold_import_post_replace($slider_id);
			update_post_meta($post_id, $module_slider->meta_key, $slider_id);
		}
	}
}
add_action( 'import_end', 'arnold_import_process_pb', 11 );

//////////////////////
// Import function //
////////////////////

//theme import create demo image
function arnold_import_create_demo_image(){
	$demo_attachment = get_option('ux_theme_demo_attachment');
	
	if(!$demo_attachment){
		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		
		if(!class_exists('WP_Importer')){
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if(file_exists($class_wp_importer)){
				require $class_wp_importer;
			}
		}
		
		if(!class_exists('WXR_Parser')){
			// include WXR file parsers
			require get_template_directory() . '/functions/theme/wordpress-importer/parsers.php';
		}
		
		if(!class_exists('WP_Import')){
			require_once get_template_directory() . '/functions/class/class-ux-importer.php';
		}
		
		$arnold_import = new WP_Import();
		
		$url =  arnold_THEME . '/images/import-demo/demo-img.jpg';
		$parts = pathinfo( $url );
		$file_name = $parts['basename'];
		$t = date('Y-m-d G:i:s');
		$post = array(
			'upload_date' => $t,
			'guid' => ''
		);
		$upload = $arnold_import->fetch_remote_file($url, $post);
		$wp_filetype = wp_check_filetype($upload['file']);
		
		$attachment = array(
			'guid' => $upload['url'], 
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => $file_name,
			'post_content' => '',
			'post_status' => 'inherit',
			'upload_date' => $t
		);
		
		$attach_id = wp_insert_attachment($attachment, $upload['file']);
		wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $upload['file']));
		
		if($attach_id){
			update_option('ux_theme_demo_attachment', $attach_id);
			$demo_attachment = $attach_id;
		}
	}
	
	return $demo_attachment;
}

//theme import taxonomy replace
function arnold_import_taxonomy_replace($taxonomy, $val){
	global $import_xmlcache;
	
	if($import_xmlcache){
		$post_type = 'post';
		
		switch($taxonomy){
			case 'client_cat':      $post_type = 'clients_item'; break;
			case 'question_cat':    $post_type = 'faqs_item'; break;
			case 'job_cat':         $post_type = 'jobs_item'; break;
			case 'team_cat':        $post_type = 'team_item'; break;
			case 'testimonial_cat': $post_type = 'testimonials_item'; break;
		}
		
		$cat_name = false;
		$cat_slug = false;
		
		switch($taxonomy){
			case 'category':
				if(isset($import_xmlcache['categories'])){
					$categories = $import_xmlcache['categories'];
					if($categories){
						foreach($categories as $cat){
							if((int) $cat['term_id'] == (int) $val){
								$cat_name = $cat['cat_name'];
								$cat_slug = $cat['category_nicename'];
							}
						}
					}
					
				}
			
			break;
			
			default:
				if(isset($import_xmlcache['taxonomies'])){
					$taxonomies = $import_xmlcache['taxonomies'];
					if($taxonomies){
						foreach($taxonomies as $term){
							if((int) $term['term_id'] == (int) $val){
								$cat_name = $term['term_name'];
								$cat_slug = $term['term_slug'];
							}
						}
					}
				}
			break;
		}
		
		$categories = get_categories(array(
			'type' => $post_type,
			'hide_empty' => 0,
			'taxonomy' => $taxonomy
		));
		
		if($categories){
			foreach($categories as $category){
				if($cat_slug == $category->slug && $cat_name == $category->name){
					$val = $category->term_id;
				}
			}
		}
	}
	
	return $val;
}

//theme import attachment replace
function arnold_import_attachment_replace($key, $val){
	global $import_xmlcache;
	
	if($import_xmlcache){
		$get_attachment = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'attachment'
		));
		
		if(isset($import_xmlcache['attachments'])){
			$post = false;
			foreach($import_xmlcache['attachments'] as $attachment){
				$post_id = $attachment['post_id'];
				$attachment_url = $attachment['attachment_url'];
				
				switch($key){
					case 'url':
						if($attachment_url == $val){
							$post = $attachment;
						}
					break;
					
					case 'id':
						if($post_id == $val){
							$post = $attachment;
						}
					break;
				}
			}
			
			if($post){
				$post_title = $post['post_title'];
				$post_date = $post['post_date'];
				foreach($get_attachment as $attachment){
					if($attachment->post_date == $post_date && $attachment->post_title == $post_title){
						$attachment_image_src = wp_get_attachment_image_src($attachment->ID, 'full');
						$val = $key == 'url' ? $attachment_image_src[0] : $attachment->ID;
					}
				}
			} 
		}
	}
	
	return $val;
}

//theme import post replace
function arnold_import_post_replace($post_id){
	global $import_xmlcache;
	
	if($import_xmlcache){
		$get_posts = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'post'
		));
		
		if(isset($import_xmlcache['posts'])){
			$items = $import_xmlcache['posts'];
			foreach($items as $item){
				if(intval($item['post_id']) == intval($post_id)){
					$post_title = $item['post_title'];
					$post_date = $item['post_date'];
					foreach($get_posts as $post){
						if($post->post_date == $post_date && $post->post_title == $post_title){
							$post_id = $post->ID;
						}
					}
				}
			}
		}
	}
	
	return $post_id;
}

//theme import ajax
function arnold_theme_import_ajax(){
	// Load Importer API
	require_once ABSPATH . 'wp-admin/includes/import.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	
	if(!class_exists('WP_Importer')){
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if(file_exists($class_wp_importer)){
			require $class_wp_importer;
		}
	}
	
	if(!class_exists('WXR_Parser')){
		// include WXR file parsers
		require get_template_directory() . '/functions/theme/wordpress-importer/parsers.php';
	}
	
	if(!class_exists('WP_Import')){
		require_once get_template_directory() . '/functions/class/class-ux-importer.php';
	}
	
	$arnold_import = new WP_Import();
	//arnold_import->fetch_attachments = (!empty($_POST['fetch_attachments']) && $arnold_import->allow_fetch_attachments());
	$arnold_import->import($_POST['xml']);
	
	$demo_attachment = arnold_import_create_demo_image();
	
	die('');
}
add_action('wp_ajax_arnold_theme_import_ajax', 'arnold_theme_import_ajax');

//theme import process demo images
function arnold_theme_process_demo_images_ajax(){
	global $wpdb;
	
	$demo_attachment = get_option('ux_theme_demo_attachment');
	if($demo_attachment){
		
		//featured image
		$get_post = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => array('post', 'page', 'team_item', 'clients_item', 'testimonials_item', 'jobs_item', 'faqs_item')
		));
		
		if($get_post){
			foreach($get_post as $post){
				$_thumbnail_id = get_post_meta($post->ID, '_thumbnail_id', true);
				if($_thumbnail_id){
					update_post_meta($post->ID, '_thumbnail_id', $demo_attachment);
				}
			}
		}
		
		//gallery format library
		$get_post = $wpdb->get_results($wpdb->prepare("
			SELECT 
			`$wpdb->postmeta`.`post_id` as 'ID',
			`$wpdb->postmeta`.`meta_key` as 'meta_key',
			`$wpdb->postmeta`.`meta_value` as 'meta_value',
			`$wpdb->posts`.`post_type` as 'post_type'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = '%s')
			AND (`meta_key` LIKE '%s')
			AND (`meta_value` LIKE '%s'))
			", 'post', 'ux_theme_meta', '%theme_meta_portfolio%'
		));
		
		if($get_post){
			foreach($get_post as $post){
				$post_id = $post->ID;
				$get_post_meta = get_post_meta($post_id, 'ux_theme_meta', true);
				if($get_post_meta){
					foreach($get_post_meta as $meta_key => $meta_value){
						if($meta_key == 'theme_meta_portfolio'){
							if(is_array($meta_value)){
								foreach($meta_value as $num => $image){
									$get_post_meta['theme_meta_portfolio'][$num] = $demo_attachment;
								}
							}
						}
					}
					update_post_meta($post_id, 'ux_theme_meta', $get_post_meta);
				}
			}
		}
		
		//post content replace demo images
		$get_post = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => array('post', 'page', 'modules')
		));
		
		if($get_post){
			foreach($get_post as $post){
				
				//permalink
				preg_match_all("#href=('|\")(.*)('|\")#isU", $post->post_content, $permalink);
				if(count($permalink[2])){
					foreach($permalink[2] as $from_url){
						$to_href = wp_get_attachment_image_src($demo_attachment, 'full');
						$wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_href[0]));
					}
				}
				
				//image
				preg_match_all("#src=('|\")(.*)('|\")#isU", $post->post_content, $images);
				if(count($images[2])){
					foreach($images[2] as $from_img){
						$to_img = wp_get_attachment_image_src($demo_attachment, 'full');
						$wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_img, $to_img[0]));
					}
				}
			}
		}
		
		//module image box / single image
		$db_query_image = $wpdb->prepare("
			SELECT 
			`$wpdb->postmeta`.`post_id` as 'ID',
			`$wpdb->postmeta`.`meta_key` as 'meta_key',
			`$wpdb->postmeta`.`meta_value` as 'meta_value',
			`$wpdb->posts`.`post_type` as 'post_type'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = '%s')
			AND (`meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s' OR `meta_key` LIKE '%s'))
			", 'modules',
			'module_singleimage_image', 'module_imagebox_image', 'module_fullwidth_background_image', 'module_fullwidth_alt_image', 'module_video_cover',
			'module_googlemap_pin_custom', 'block_column_1_bg_image', 'block_column_2_bg_image', 'block_column_2_bg_image'
		);
		$get_module_image = $wpdb->get_results($db_query_image);
		
		if($get_module_image){
			foreach($get_module_image as $module_image){
				$image_url = $module_image->meta_value;
				$post_id = $module_image->ID;
				$post_type = get_post($post_id)->post_type;
				$attachment_url = wp_get_attachment_image_src($demo_attachment, 'full');
				update_post_meta($post_id, $module_image->meta_key, $attachment_url[0]);
			}
		}
		
		//module gallery library
		$db_query_gallery = $wpdb->prepare("
			SELECT 
			`$wpdb->postmeta`.`post_id` as 'ID',
			`$wpdb->postmeta`.`meta_key` as 'meta_key',
			`$wpdb->postmeta`.`meta_value` as 'meta_value',
			`$wpdb->posts`.`post_type` as 'post_type'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = '%s')
			AND (`meta_key` LIKE '%s'))
			", 'modules', 'module_gallery_library'
		);
		$get_module_gallery = $wpdb->get_results($db_query_gallery);
		
		if($get_module_gallery){
			foreach($get_module_gallery as $gallery){
				$post_id = $gallery->ID;
				$get_post_meta = get_post_meta($post_id, 'module_gallery_library', true);
				if($get_post_meta){
					if(is_array($get_post_meta)){
						foreach($get_post_meta as $num => $image){
							$get_post_meta[$num] = $demo_attachment;
						}
					}else{
						$get_post_meta = $demo_attachment;
					}
					update_post_meta($post_id, 'module_gallery_library', $get_post_meta);
				}
			}
		}
		
		//module fullwidth front-background parallax
		$db_query_foreground = $wpdb->prepare("
			SELECT `$wpdb->postmeta`.`post_id` as 'ID'
			
			FROM $wpdb->postmeta, $wpdb->posts
			
			WHERE ((`$wpdb->postmeta`.`post_id` = `$wpdb->posts`.`ID`)
			AND (`$wpdb->posts`.`post_type` = '%s')
			AND (`meta_key` LIKE '%s'))
			", 'modules', 'module_fullwidth_foreground'
		);
		
		$get_module_full_foreground = $wpdb->get_results($db_query_foreground);
		
		if($get_module_full_foreground){
			foreach($get_module_full_foreground as $foreground){
				$post_id = $foreground->ID;
				$get_post_meta = get_post_meta($post_id, 'module_fullwidth_foreground', true);
				if($get_post_meta){
					$foreground_image = $get_post_meta['image'];
					foreach($foreground_image as $num => $image){
						$get_post_meta['image'][$num] = $demo_attachment;
					}
					update_post_meta($post_id, 'module_fullwidth_foreground', $get_post_meta);
				}
			}
		}
	}
}
add_action( 'wp_ajax_arnold_theme_process_demo_images_ajax', 'arnold_theme_process_demo_images_ajax', 11 );
?>