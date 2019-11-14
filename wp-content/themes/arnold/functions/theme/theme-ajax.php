<?php
//select icons
function arnold_theme_option_select_icons(){
	$icons_fields = arnold_theme_icons_fields();
	$get_value = get_option('ux_theme_option_icons_custom');
	$i = $_POST['i'];
	$type = $_POST['type']; ?>

    <div class="ux-theme-option-select-icons">
        <div class="row">
            <div class="col-xs-4">
                <h5><strong><?php esc_html_e('Select Icon','arnold'); ?></strong></h5>
                <p class="text-muted"><?php esc_html_e('Choose a icon for this Icon Box','arnold'); ?></p>
            </div>
            
            <div class="col-xs-8">
                <select class="form-control">
					<option value="fontawesome"><?php esc_html_e('Font Awesome','arnold'); ?></option>
                    <?php if($get_value){ ?>
                        <option value="user-uploaded-icons"><?php esc_html_e('User Uploaded Icons','arnold'); ?></option>
                    <?php } ?>
                </select>
                <div class="ux-theme-option-icons">
					<?php foreach($icons_fields as $icon){  ?>
                        <a href="#" class="fontawesome"><i class="<?php echo esc_attr($icon); ?>"></i></a>
                    <?php }
					
					if($get_value){
						foreach($get_value as $portfolio){
							$image_src = wp_get_attachment_image_src($portfolio); ?>
                            <a href="#" class="user-uploaded-icons"><img src="<?php echo esc_url($image_src[0]); ?>" /></a>
						<?php
						}
					} ?>
                    <div class="clearfix"></div>
                    <input type="hidden" id="ux-theme-social-medias-rel" value="<?php echo sanitize_text_field($i); ?>" />
                    <input type="hidden" id="ux-theme-option-icons-input" value="" />
                    <script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery('.ux-theme-option-select-icons').each(function(){
                                var _this = jQuery(this);
								var _this_select = _this.find('select');
								var _this_icon = _this.find('a');
								var _this_input = _this.find('#ux-theme-option-icons-input');
								var _this_rel = jQuery('#ux-theme-social-medias-rel').val();
								
								<?php if($type){ ?>
									var _target = jQuery('#<?php echo esc_attr($type); ?>').find('.ux-theme-social-medias[rel=' + _this_rel + ']');
								<?php }else{ ?>
									var _target = jQuery('.ux-theme-social-medias[rel=' + _this_rel + ']');
								<?php } ?>
								
								var _target_icon = _target.find('.new-media-col-icon');
								
								_this_select.change(function(){
									var _select_val = jQuery(this).val();
									_this_icon.each(function(){
                                        if(jQuery(this).hasClass(_select_val)){
											jQuery(this).fadeIn();
										}else{
											jQuery(this).hide();
										}
                                    });
								});
								
								_this_icon.click(function(){
									if(jQuery(this).is('.fontawesome')){
										var _icon = jQuery(this).find('i');
										var _icon_val = _icon.attr('class');
										var _icon_type = 'fontawesome';
									}else{
										var _icon = jQuery(this).find('img');
										var _icon_val = _icon.attr('src');
										var _icon_type = 'user';
									}
									
									_target_icon.find('.icon-content').html(_icon);
									_target_icon.find('.icon-content').next().val(_icon_val);
									_target_icon.find('.icon-content').next().next().val(_icon_type);
									jQuery('#ux-theme-modal').modal('hide');
									return false;
								});
                            });
						});
					</script>
                </div>
            </div>
        </div>
    </div>
    
	<?php
	die('');
}
add_action('wp_ajax_arnold_theme_option_select_icons', 'arnold_theme_option_select_icons');

//load google font
function arnold_theme_option_googlefont(){
	$response = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyC83M8-g7oz8yZSslS7tzkF_5TA3gQfJzs', array('sslverify' => false));
	
	if(is_wp_error($response)){
		echo 'error';
	}else{
		if(isset($response['body']) && $response['body']){
			if(strpos($response['body'], 'error') === false){
				$fonts_json = $response['body'];
				update_option('ux_theme_googlefont', $fonts_json);
				echo 'success';
			}else{
				echo 'error';
			}
		}
	}
	die('');
}
add_action('wp_ajax_arnold_theme_option_googlefont', 'arnold_theme_option_googlefont');

//add google font
function arnold_theme_option_font_ajax(){
	$data = $_POST['data'];
	$fonts = null;
	$fonts_object = null;
	
	$json = get_option('ux_theme_googlefont');
	
	if($json){
		$fonts_object = json_decode($json);
	}
	if($fonts_object && is_object($fonts_object)){
		if($fonts_object->items && is_array($fonts_object->items)){
			$fonts = $fonts_object->items;
			if($data == 'load-fonts'){ ?>
                <option value="-1"><?php esc_html_e('-- Select Font --','arnold'); ?></option>
            <?php 
			}
			
			foreach($fonts as $item){
				$family_val = str_replace(' ', '+', $item->family);
				switch($data){
					case 'load-fonts': ?>
                        <option value="<?php echo sanitize_text_field($family_val); ?>"><?php echo esc_html($item->family); ?></option>
					<?php
					break;
					
					case 'load-style':
						$font_family = $_POST['font'];
						$selected = (isset($_POST['selected'])) ? $_POST['selected'] : false;
						if($family_val == $font_family){
							foreach($item->variants as $variants){ ?>
                                <option value="<?php echo sanitize_text_field($variants); ?>" <?php selected(sanitize_text_field($selected), sanitize_text_field($variants)); ?>><?php echo esc_html($variants); ?></option>
                            <?php
							}
						}
					break;
				}
            }
		}
	}
	die('');
}
add_action('wp_ajax_arnold_theme_option_font_ajax', 'arnold_theme_option_font_ajax');

//theme restore defaults
function arnold_theme_option_restore(){
	$delete = delete_option('ux_theme_option');
	echo ($delete) ? 'success' : 'error';
	die('');
}
add_action('wp_ajax_arnold_theme_option_restore', 'arnold_theme_option_restore');

//load slider
function arnold_theme_meta_slider_ajax(){
	$data = $_POST['data'];
	
	switch($data){
		case 'load-slider':
			$selected = (isset($_POST['selected'])) ? $_POST['selected'] : false; ?>
            
            <option value="-1" <?php selected(sanitize_text_field($selected), '-1'); ?>><?php esc_html_e('Select a slider','arnold'); ?></option>
            
			<?php $slider = $_POST['slider'];
			switch($slider){
				case 'zoomslider':
					$get_topslider = get_posts(array(
						'posts_per_page' => -1,
						'post_type' => 'zoomslider'
					));
					foreach($get_topslider as $zoomslider){ ?>
						<option value="<?php echo sanitize_text_field($zoomslider->post_name); ?>" <?php selected(sanitize_text_field($selected), sanitize_text_field($zoomslider->post_name)); ?>><?php echo esc_html($zoomslider->post_title); ?></option>
					<?php
					}
				break;
				
				case 'revolutionslider':
					global $wpdb;
					$table_revslider = $wpdb->prefix . "revslider_sliders";
					$revslidersliders = $wpdb->get_results($wpdb->prepare("
						SELECT * FROM $table_revslider
						ORDER BY id ASC
						", $table_revslider
					));
					
					if(count($revslidersliders)){
						$slider_revslider = array();
						foreach($revslidersliders as $num => $slider){
							$params = (array) json_decode($slider->params);
							if(isset($params['template'])){
								$template = $params['template'] == 'true' ? true : false;
								if(!$template){ ?>
									<option value="<?php echo sanitize_text_field($slider->alias); ?>" <?php selected(sanitize_text_field($selected), sanitize_text_field($slider->alias)); ?>><?php echo esc_html($slider->title); ?></option>
								<?php
								}
							}
                        }
					}
				break;
				
				case 'layerslider':
					global $wpdb;
					$table_layerslider = $wpdb->prefix . "layerslider";
					$layerslider = $wpdb->get_results($wpdb->prepare("
						SELECT * FROM %s
						WHERE flag_hidden = '0' AND flag_deleted = '0'
						ORDER BY id ASC
						", $table_layerslider
					));
					
					if(count($layerslider)){
						$slider_layerslider = array();
						foreach($layerslider as $num => $slider){
							$name = empty($slider->name) ? 'Unnamed' : $slider->name; ?>
                            <option value="<?php echo sanitize_text_field($slider->id); ?>" <?php selected(sanitize_text_field($selected), sanitize_text_field($slider->id)); ?>><?php echo esc_html($name); ?></option>
						<?php	
						}
					}
				break;
			}
			
		break;
	}
	die('');
}
add_action('wp_ajax_arnold_theme_meta_slider_ajax', 'arnold_theme_meta_slider_ajax');

//generate thumbs
function arnold_theme_option_generate_thumbs_ajax(){
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'any'
	));
	
	if($get_posts){
		$thumbnails = array();
		
		foreach($get_posts as $post){
			if(has_post_thumbnail($post->ID)){
				$attachment_metadata = wp_get_attachment_metadata(get_post_thumbnail_id($post->ID));
				$thumbnail_crop = update_post_meta(get_post_thumbnail_id($post->ID), '_thumbnail_crop', true);
				if($attachment_metadata && !$thumbnail_crop){
					$thumbnails[get_post_thumbnail_id($post->ID)] = get_post_thumbnail_id($post->ID);
				}
			}
		}
		
		if(count($thumbnails)){
			foreach($thumbnails as $thumbs){ ?>
				<input class="generate_thumbs_progress_thumbnails" type="hidden" value="<?php echo sanitize_text_field($thumbs); ?>" />
			<?php } ?>
            <input id="generate_thumbs_progress_count" type="hidden" value="<?php echo sanitize_text_field(count($thumbnails)); ?>" />
            <div id="generate_thumbs_progress" class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0/<?php echo esc_attr(count($thumbnails)); ?></div>
            </div>
		<?php
        }
	}else{
		echo 'error';
	}
	
	
	die('');
}
add_action('wp_ajax_arnold_theme_option_generate_thumbs_ajax', 'arnold_theme_option_generate_thumbs_ajax');

//process generate thumbs size
function arnold_theme_option_process_generate_thumbs_size($image_width, $image_height, $target_name, $target_width, $target_height, $crop){
	$thumbs_width = $target_width;
	$thumbs_height = $target_height;
	$thumbs_crop = $crop;
	
	if($image_width < $image_height){ //is long vertical image
		if($target_name == 'arnold-thumb-11-normal'){ // target is square image
			if($image_width < $target_width){
				$thumbs_width = $image_width;
				$thumbs_height = $image_width;
			}
		}
		
		if($target_name == 'arnold-standard-thumb' || $target_name == 'arnold-standard-thumb-medium' || $target_name == 'arnold-standard-thumb-big'){ // target is 9999 height
			$thumbs_crop = false;
			if($image_width < $target_width){
				$thumbs_width = $image_width;
			}
		}
		
		if($target_name == 'arnold-thumb-169-normal' || $target_name == 'arnold-thumb-43-big' || $target_name == 'arnold-thumb-43-medium'){ // target is long horizontal image
			if($image_width < $target_width){
				$target_ratio = $target_height / $target_width;
				$thumbs_width = $image_width;
				$thumbs_height = $image_width * $target_ratio;
			}
		}
		
	}
	
	if($image_width > $image_height){ //is long horizontal image
		if($target_name == 'arnold-thumb-11-normal'){ // target is square image
			if($image_height < $target_height){
				$thumbs_width = $image_height;
				$thumbs_height = $image_height;
			}
		}
		
		if($target_name == 'arnold-standard-thumb' || $target_name == 'arnold-standard-thumb-medium' || $target_name == 'arnold-standard-thumb-big'){ // target is 9999 height
			$thumbs_crop = false;
			if($image_width < $target_width){
				$thumbs_width = $image_width;
			}
		}
		
		if($target_name == 'arnold-thumb-169-normal' || $target_name == 'arnold-thumb-43-big' || $target_name == 'arnold-thumb-43-medium' ){ // target is long horizontal image
			if($image_height < $target_height){
				$target_ratio = $target_width / $target_height;
				$thumbs_height = $image_height;
				$thumbs_width = $image_height * $target_ratio;
				
				if($image_width < $thumbs_width){
					$target_ratio = $image_width /  $thumbs_width;
					$thumbs_width = $image_width;
					$thumbs_height = $image_height * $target_ratio;
				}
			}
			
			if($image_height > $target_height){
				$target_ratio = $target_height / $image_height;
				$thumbs_width = $image_width * $target_ratio;
				
				if($thumbs_width < $target_width){
					$target_ratio = $target_height / $target_width;
					$thumbs_width = $image_width;
					$thumbs_height = $image_width * $target_ratio;
				}
				
				if($thumbs_width > $target_width){
					$thumbs_width = $target_width;
					$thumbs_height = $target_height;
				}
			}
		}
		
	}
	
	if($image_width == $image_height){ //is square image
		if($target_name == 'arnold-thumb-11-normal'){ // target is square image
			if($image_width < $target_width){
				$thumbs_width = $image_width;
				$thumbs_height = $image_height;
			}
		}
		
		if($target_name == 'arnold-thumb-169-normal' || $target_name == 'arnold-thumb-43-big' || $target_name == 'arnold-thumb-43-medium' ){ // target is long horizontal image
			if($image_width < $target_width){
				$target_ratio = $target_height / $target_width;
				$thumbs_width = $image_width;
				$thumbs_height = $image_height * $target_ratio;
			}
		}
	}
	
	return array($thumbs_width, $thumbs_height, $thumbs_crop);
}

//process generate thumb
function arnold_theme_option_process_generate_thumb($thumbnail_id){
	$return = false;
	$upload_dir = wp_upload_dir();
	$attachment_metadata = wp_get_attachment_metadata($thumbnail_id);
	$attachment_mime_type = get_post_mime_type($thumbnail_id);
	
	$custom_image_size = array(
		array('arnold-standard-thumb', 650, 9999, true),
		array('arnold-standard-thumb-medium', 1000, 9999, false),
		array('arnold-standard-thumb-big', 2000, 9999, false),
		array('arnold-thumb-169-normal', 800, 450, true),
		array('arnold-thumb-11-normal', 650, 650, true),
		array('arnold-thumb-43-big', 2000, 1500, true),
		array('arnold-thumb-43-medium', 1000, 750, true)
	);
	
	if($attachment_metadata){
		$thumbnail_file = $upload_dir['basedir'] . '/' . $attachment_metadata['file'];
		$thumbnail_width = intval($attachment_metadata['width']);
		$thumbnail_height = intval($attachment_metadata['height']);
		$thumbnail_pathinfo = pathinfo($thumbnail_file);
		$thumbnail_extension = $thumbnail_pathinfo['extension'];
		$thumbnail_info = pathinfo(get_attached_file($thumbnail_id));
		$thumbnail_basename = str_replace('.' .$thumbnail_info['extension'], '' , $thumbnail_info['basename']);
		
		if($thumbnail_extension != 'gif'){
			foreach($custom_image_size as $image_size){
				$new_image = wp_get_image_editor($thumbnail_file);
				
				if(!is_wp_error($new_image)){
					$image_size_name = $image_size[0];
					$image_size_width = intval($image_size[1]);
					$image_size_height = intval($image_size[2]);
					$image_size_crop = $image_size[3];
					
					$final_size = arnold_theme_option_process_generate_thumbs_size($thumbnail_width, $thumbnail_height, $image_size_name, $image_size_width, $image_size_height, $image_size_crop);
					$final_width = $final_size[0];
					$final_height = $final_size[1];
					$final_crop = $final_size[2];
	
					$new_image->resize($final_width, $final_height, $final_crop);
					$new_image_dir = $thumbnail_info['dirname'];
					
					$new_image_dir = str_replace('/' .$thumbnail_info['basename'], '', $new_image_dir);
					$new_image_file = $new_image_dir . '/' . $thumbnail_basename . '-' . $image_size_name . '-' . $new_image->get_suffix() . '.' . $thumbnail_extension;
					
					$result = @unlink($new_image_file); 
					$saved = $new_image->save($new_image_file, $attachment_mime_type);
					if($saved){
						$new_image_size = $new_image->get_size();
						$attachment_metadata['sizes'][$image_size_name] = array(
							'file' => $thumbnail_basename . '-' . $image_size_name . '-' . $new_image->get_suffix() . '.' . $thumbnail_extension,
							'width' => $new_image_size['width'],
							'height' => $new_image_size['height']
						);
						$new_image_update = wp_update_attachment_metadata($thumbnail_id, $attachment_metadata);
					}
				}
			}
		}
		
		$thumbnail_update = update_post_meta($thumbnail_id, '_thumbnail_crop', 'yes');
		if($thumbnail_update){
			$return = true;
		}
	}
	
	return $return;
}

//process generate thumbs
function arnold_theme_option_process_generate_thumbs_ajax(){
	$thumbnail_id = $_POST['thumbnail_id'];
	if(arnold_theme_option_process_generate_thumb($thumbnail_id)){
		echo 'success';
	}
	die('');
}
add_action('wp_ajax_arnold_theme_option_process_generate_thumbs_ajax', 'arnold_theme_option_process_generate_thumbs_ajax');

//process generate thumbs
function arnold_theme_option_auto_select(){
	$keyword = $_POST['keyword'];
	
	if($keyword){
		$query = new WP_Query( array( 's' => $keyword ) );
		if($query->have_posts()){
			echo '<ul>';
			while($query->have_posts()){ $query->the_post();
				$title = str_replace($keyword, '<ins>' .$keyword. '</ins>', get_the_title()); ?>
				<li><a data-id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>">#<?php the_ID(); ?> - <?php echo balanceTags($title); ?></a></li>
			<?php
            }
			echo '</ul>';
			wp_reset_postdata();
		}else{
			echo 'error';
		}
	}
	
	die('');
}
add_action('wp_ajax_arnold_theme_option_auto_select', 'arnold_theme_option_auto_select');

//Edit Portfolio list layout for Page
function arnold_edit_portfolio_list_layout_ajax(){
	$cat_id = intval($_POST['cat_id']);
	$post_ID = intval($_POST['post_ID']);
	
	if($post_ID){ ?>
        <div class="edit-portfolio-list-layout">
            <div class="grid-stack">
				<?php
				$layout_array = array();
				$list_layout = get_post_meta($post_ID, '_portfolio_list_layout_' .$cat_id, true);
				if($list_layout){
					$layout_array = $list_layout;
				}
				
				$category = array();
				if($cat_id){
					$category = array($cat_id);
				}
				
				$get_categories = get_categories(array(
					'parent' => $cat_id
				));
				
				if($get_categories){
					foreach($get_categories as $cat){
						array_push($category, $cat->term_id);
					}
				}
				
				$get_posts = get_posts(array(
					'posts_per_page' => -1,
					'category__in' => $category,
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery', 'post-format-link')
						)
					)
				));
				
				if($get_posts){
					$i = 0;
					$width = 3;
					$height = 3;
					$col = 12 / $width;
					$row = 0;
					
					foreach($get_posts as $post){
						if($i > 0 && $i % $col == 0){
							$row++;
						}
						
						$x = ($i % $col) * $width;
						$y = $row * $height;
						
						if(count($layout_array)){
							foreach($layout_array as $layout){
								if($layout['post_id'] == $post->ID){
									$x = $layout['x'];
									$y = $layout['y'];
									$width = $layout['width'];
									$height = $layout['height'];
								}
							}
						}
						
						$bg_style = false;
						if(has_post_thumbnail($post->ID)){
							$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'arnold-thumb-11-normal');
							$bg_style = 'background-image:url(' .esc_url($thumb[0]). ');';
						} ?>
						
						<div class="grid-stack-item" data-postid="<?php echo esc_attr($post->ID); ?>"
							data-gs-x="<?php echo esc_attr($x); ?>" data-gs-y="<?php echo esc_attr($y); ?>"
							data-gs-width="<?php echo esc_attr($width); ?>" data-gs-height="<?php echo esc_attr($height); ?>">
								<div class="grid-stack-item-content" style=" <?php echo esc_attr($bg_style); ?>">
									<?php if(!has_post_thumbnail($post->ID)){
										echo '<div class="title">' .get_the_title($post->ID). '</div>';
									} ?>
								</div>
						</div>
						<?php
						$i ++;
					}
				}  ?>
            </div>
        </div>
	<?php
    }
	exit;
}
add_action('wp_ajax_arnold_edit_portfolio_list_layout_ajax', 'arnold_edit_portfolio_list_layout_ajax');

//Save Portfolio list layout for Page
function arnold_save_portfolio_list_layout_ajax(){
	$data = $_POST['data'];
	$cat_id = intval($_POST['cat_id']);
	$post_ID = intval($_POST['post_ID']);
	
	if($post_ID){
		update_post_meta($post_ID, '_portfolio_list_layout_' .$cat_id, $data);
	}
	
	exit;
}
add_action('wp_ajax_arnold_save_portfolio_list_layout_ajax', 'arnold_save_portfolio_list_layout_ajax');
?>