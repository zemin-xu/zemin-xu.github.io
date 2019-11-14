<?php
//theme import module set taxonomy
if(!function_exists('ux_import_module_set_taxonomy')){
	function ux_import_module_set_taxonomy(){
		global $wpdb;
		
		$db_query = $wpdb->prepare("
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
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'))
			", 'modules', 'module_carousel_category', 'module_blog_category', 'module_gallery_category', 'module_latestpost_category', 'module_liquidlist_category', 'module_portfolio_category', 'module_slider_category', 'module_client_category', 'module_faq_category', 'module_jobs_category', 'module_team_category', 'module_testimonials_category', 'block_column_1_post_ategory', 'block_column_2_post_ategory', 'block_column_3_post_ategory', 'block_column_1_post_category', 'block_column_2_post_category', 'block_column_3_post_category'
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
						$cat_ID = ux_import_taxonomy_replace($category_taxonomy, $cat_ID);
						array_push($category_id, $cat_ID);
					}
				}else{
					$category_id = ux_import_taxonomy_replace($category_taxonomy, $category_id);
				}
				
				update_post_meta($post_id, $meta_key, $category_id);
			}
		}
		
	}
	add_action( 'import_end' , 'ux_import_module_set_taxonomy' );
}

//theme import module layerslider
if(!function_exists('ux_import_module_layerslider')){
	function ux_import_module_layerslider(){
		global $wpdb;
		$db_query = $wpdb->prepare("
			SELECT `post_id`, `meta_key`
			FROM $wpdb->postmeta
			WHERE `meta_value` LIKE '%s'
			", '%layerslider%'
		);
		$get_module_layerslider = $wpdb->get_results($db_query);
		
		if($get_module_layerslider){
			foreach($get_module_layerslider as $module_layerslider){
				$post = get_post($module_layerslider->post_id);
				switch($post->post_type){
					case 'modules':
						$get_post_meta = get_post_meta($module_layerslider->post_id, 'module_slider_layerslider', true);
						$new_id = get_option('import_cache_layerslider_' . $get_post_meta);
						update_post_meta($module_layerslider->post_id, 'module_slider_layerslider', $new_id);
					break;
				}
			}
		}
	}
	add_action( 'import_end' , 'ux_import_module_layerslider' );
}

//theme import set module
if(!function_exists('ux_import_set_modules')){
	function ux_import_set_modules(){
		global $wpdb;
		
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
			AND (`meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'
			  OR `meta_key` LIKE '%s'))
			", 'modules', 'module_singleimage_image', 'module_imagebox_image', 'module_fullwidth_background_image', 'module_fullwidth_alt_image', 'module_video_cover', 'module_googlemap_pin_custom', 'block_column_1_bg_image', 'block_column_2_bg_image', 'block_column_2_bg_image'
		);
		$get_module_image = $wpdb->get_results($db_query_image);
		
		if($get_module_image){
			foreach($get_module_image as $module_image){
				$image_url = $module_image->meta_value;
				$post_id = $module_image->ID;
				$post_type = get_post($post_id)->post_type;
				$attachment_url = ux_import_attachment_replace('url', $image_url);
				update_post_meta($post_id, $module_image->meta_key, $attachment_url);
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
							$attachment_id = ux_import_attachment_replace('id', $image);
							$get_post_meta[$num] = $attachment_id;
						}
					}else{
						$attachment_id = ux_import_attachment_replace('id', $image);
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
				$slider_id = ux_import_post_replace($slider_id);
				update_post_meta($post_id, $module_slider->meta_key, $slider_id);
			}
		}
	}
	add_action( 'import_end' , 'ux_import_set_modules' );
}

//theme import process module
if(!function_exists('ux_import_process_modules_demo_images')){
	function ux_import_process_modules_demo_images(){
		global $wpdb;
		
		$demo_attachment = get_option('ux_theme_demo_attachment');
		if($demo_attachment){
		
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
				AND (`meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'
				  OR `meta_key` LIKE '%s'))
				", 'modules', 'module_singleimage_image', 'module_imagebox_image', 'module_fullwidth_background_image', 'module_fullwidth_alt_image', 'module_video_cover', 'module_googlemap_pin_custom'
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
	add_action('ux_theme_process_demo_images_ajax', 'ux_import_process_modules_demo_images');
}

//theme import taxonomy replace
if(!function_exists('ux_import_taxonomy_replace')){
	function ux_import_taxonomy_replace($taxonomy, $val){
		$post_type = 'post';
		
		switch($taxonomy){
			case 'client_cat':      $post_type = 'clients_item'; break;
			case 'question_cat':    $post_type = 'faqs_item'; break;
			case 'job_cat':         $post_type = 'jobs_item'; break;
			case 'team_cat':        $post_type = 'team_item'; break;
			case 'testimonial_cat': $post_type = 'testimonials_item'; break;
		}
		
		$categories = get_categories(array(
			'type' => $post_type,
			'hide_empty' => 0,
			'taxonomy' => $taxonomy
		));
		
		if($categories){
			foreach($categories as $category){
				$term_id = $category->term_id;
				$category_nicename = $category->category_nicename;
				$cat_name = $category->cat_name;
				
				$get_option = get_option('import_cache_taxonomy_' . $taxonomy . '_' . $val);
				if($get_option){
					$get_category_nicename = $get_option['category_nicename'];
					$get_cat_name = $get_option['cat_name'];
					if($get_category_nicename == $category_nicename && $get_cat_name == $cat_name){
						$val = $term_id;
					}
				}
			}
		}
		
		return $val;
	}
}
?>