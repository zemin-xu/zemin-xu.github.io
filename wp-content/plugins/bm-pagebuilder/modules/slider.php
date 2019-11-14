<?php
//slider template
function ux_pb_module_slider($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		global $post;
		
		//slider confing
		$type          = get_post_meta($module_post, 'module_slider_type', true);
		$per_page      = get_post_meta($module_post, 'module_slider_per_page', true);
		$animation     = get_post_meta($module_post, 'module_slider_animation', true);
		$navigation    = get_post_meta($module_post, 'module_slider_navigation_hint', true);
		$previous_next = get_post_meta($module_post, 'module_slider_previous_next', true);
		$speed_second  = get_post_meta($module_post, 'module_slider_speed_second', true);
		$category      = get_post_meta($module_post, 'module_slider_category', true);
		$orderby       = get_post_meta($module_post, 'module_select_orderby', true);
		$order         = get_post_meta($module_post, 'module_select_order', true);
		
		$direction     = $previous_next == 'on' ? 'true' : 'false'; 
		$control       = $navigation == 'on' ? 'true' : 'false'; 
		$speed         = $speed_second ? $speed_second : 7000; 
		
		$per_page = $per_page ? $per_page : 3;
		
		$slider_query = get_posts(array(
			'posts_per_page' => $per_page,
			'category'       => $category,
			'orderby'        => $orderby,
			'order'          => $order,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array(
						'post-format-quote',
						'post-format-link',
						'post-format-audio',
						'post-format-video'
					),
					'operator' => 'NOT IN'
				)
			),
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				)
			)
		)); ?>
		<?php
		switch($type){
			case 'novo': ?>
                <!--Content slider-->
                <div id="post<?php echo esc_attr($itemid); ?>" class="listitem_slider carousel slide">
                
                    <ol class="carousel-indicators">
                        <?php foreach($slider_query as $num => $slider){
							$active = $num == 0 ? 'active' : false; ?>
                            <li class="<?php echo sanitize_html_class($active); ?>" data-slide-to="<?php echo esc_attr($num); ?>" data-target="#post<?php echo esc_attr($itemid); ?>"></li>
                        <?php
						}  ?>
                    </ol>
                    
                    <div class="carousel-img-wrap">
                        <div class="carousel-inner lightbox-photoswipe">
                            <?php foreach($slider_query as $num => $slider){
								$thumbnail_full = wp_get_attachment_image_src(get_post_thumbnail_id($slider->ID), 'full');
								$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($slider->ID), 'image-thumb-1');
								$data_size = $thumbnail_full[1]. 'x' .$thumbnail_full[2]; 
								$active = $num == 0 ? 'active' : false; ?>
                                <div class="item <?php echo esc_attr($active); ?>">
                                    <div class="slider_img" data-lightbox="true">
                                        <a href="<?php echo esc_url($thumbnail_full[0]); ?>" class="lightbox-item" rel="prettyPhoto[post<?php echo esc_attr($itemid); ?>]" data-size="<?php echo $data_size; ?>"><img src="<?php echo esc_url($thumbnail_url[0]); ?>" width="800" height="800"></a>
                                    </div><!--End slider_img-->
                                </div><!--End item-->
							<?php
							}  ?>
                        </div><!--End .carousel-inner-->
                        
                        <div class="carousel-control-wrap">
                        	<a class="carousel-control left" href="#post<?php echo esc_attr($itemid); ?>" data-slide="prev"></a>
                        	<a class="carousel-control right" href="#post<?php echo esc_attr($itemid); ?>" data-slide="next"></a>
                    	</div>
                    </div><!--End .carousel-img-wrap-->
                    
                    <div class="slider-panel">
                        <?php foreach($slider_query as $num => $slider){
							$active = $num == 0 ? 'active' : false; ?>
                            <div class="slider-panel-item <?php echo esc_attr($active); ?>">
                                <h2 class="slider-title"><a href="<?php echo esc_url(get_permalink($slider->ID)); ?>" title="<?php echo esc_attr(get_the_title($slider->ID)); ?>"><?php echo esc_html(get_the_title($slider->ID)); ?></a></h2>
                                <p class="slider-des"><?php echo balanceTags($slider->post_excerpt); ?></p>
                            </div><!--End .slider-panel-item-->
                        <?php
						} ?>
                        
                    </div><!--End .slider-panel-->	
                    
                </div><!--End .listitem_slider-->
			<?php
            break;
			
			case 'flexslider': ?>
                <div class="flex-slider-wrap slide-wrap-ux" data-direction="<?php echo esc_attr($direction); ?>" data-control="<?php echo esc_attr($control); ?>" data-speed="<?php echo esc_attr($speed); ?>" data-animation="<?php echo esc_attr($animation); ?>">
                    <div class="flexslider">
                        <ul class="slides clearfix">
                            <?php foreach($slider_query as $num => $slider):
                                $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($slider->ID), 'full');  ?>
                                <li><a href="<?php echo esc_url(get_permalink($slider->ID)); ?>" title="<?php echo esc_attr(get_the_title($slider->ID)); ?>"><img src="<?php echo esc_url($thumbnail_url[0]); ?>" title="<?php echo esc_attr(get_the_title($slider->ID)); ?>"></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div><!--End flexslider-->
                </div>
                <!--End flex-slider-wrap-->
			<?php
            break;
			
			case 'layerslider':
				$layerslider = get_post_meta($module_post, 'module_slider_layerslider', true);
				if($layerslider){
					echo balanceTags(do_shortcode('[layerslider id="'.esc_attr($layerslider).'"]'));
				}
			break;
			
			case 'revolutionslider':
				$revolution = get_post_meta($module_post, 'module_slider_revolution', true);
				if($revolution){
					echo balanceTags(do_shortcode('[rev_slider '.esc_attr($revolution).']'));
				}
			break;
		}
    }
}
add_action('ux-pb-module-template-slider', 'ux_pb_module_slider');

//slider select fields
function ux_pb_module_slider_select($fields){
	$fields['module_slider_animation'] = array(
		array('title' => __('Fade','ux'), 'value' => 'fade'),
		array('title' => __('Slide','ux'), 'value' => 'slide')
	);
	
	$fields['module_slider_type'] = array(
		array('title' => __('Content Slider','ux'), 'value' => 'novo'),
		array('title' => __('Flex Slider','ux'), 'value' => 'flexslider')
	);
	
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_slider_select');

//slider config fields
function ux_pb_module_slider_fields($module_fields){
	$module_fields['slider'] = array(
		'id' => 'slider',
		'animation' => true,
		'title' => __('Slider','ux'),
		'item' =>  array(
			array('title' => __('Slider Type','ux'),
				  'description' => __('Select the slider type','ux'),
				  'type' => 'select',
				  'name' => 'module_slider_type',
				  'default' => 'novo'),
				  
			array('title' => __('Category','ux'),
				  'description' => __('The post under the category you selected would be shown in this slider.','ux'),
				  'type' => 'category',
				  'name' => 'module_slider_category',
				  'default' => '0',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'novo|flexslider'
				  )),
				  
			array('title' => __('Order by','ux'),
				  'description' => __('Select sequence rules for the list','ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'novo|flexslider'
				  )),
				  
			array('title' => __('Number to Show','ux'),
				  'description' => __('How many posts(slides) you want to show in the slider.','ux'),
				  'type' => 'text',
				  'name' => 'module_slider_per_page',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'novo|flexslider'
				  )),
				  
			array('title' => __('Animation','ux'),
				  'description' => __('Choose an animation effect for the slider','ux'),
				  'type' => 'select',
				  'name' => 'module_slider_animation',
				  'default' => 'fade',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'flexslider'
				  )),
				  
			array('title' => __('Show Navigation Hint(dot)','ux'),
				  'description' => __('Turn on if you want to show the Nav Hint','ux'),
				  'type' => 'switch',
				  'name' => 'module_slider_navigation_hint',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'flexslider'
				  )),
				  
			array('title' => __('Show Previous/Next Button','ux'),
				  'description' => __('Turn on if you want to show the Nav Button','ux'),
				  'type' => 'switch',
				  'name' => 'module_slider_previous_next',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'flexslider'
				  )),
				  
			array('title' => __('Speed (second)','ux'),
				  'description' => __('Enter a speed for the animation','ux'),
				  'type' => 'text',
				  'name' => 'module_slider_speed_second',
				  'control' => array(
					  'name' => 'module_slider_type',
					  'value' => 'flexslider'
				  )),
				  
			array('title' => __('Advanced Settings','ux'),
				  'description' => __('magin and animations','ux'),
				  'type' => 'switch',
				  'name' => 'module_advanced_settings',
				  'default' => 'off'),
				  
			array('title' => __('Bottom Margin','ux'),
				  'description' => __('the spacing outside the bottom of module','ux'),
				  'type' => 'select',
				  'name' => 'module_bottom_margin',
				  'default' => 'bottom-space-40',
				  'control' => array(
					  'name' => 'module_advanced_settings',
					  'value' => 'on'
				  ))
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_slider_fields');

//layerslider select fields
function ux_pb_module_layerslider_select($fields){
	if(is_plugin_active('LayerSlider/layerslider.php') && isset($fields['module_slider_type'])){
		global $wpdb;
		$table_layerslider = $wpdb->prefix . "layerslider";
		$layerslider = $wpdb->get_results("
			SELECT * FROM $table_layerslider
			WHERE flag_hidden = '0' AND flag_deleted = '0'
			ORDER BY id ASC
			"
		);
		
		if(count($layerslider)){
			$slider_layerslider = array();
			foreach($layerslider as $num => $slider){
				$name = empty($slider->name) ? 'Unnamed' : $slider->name;
				array_push($slider_layerslider, array(
					'title' => $name, 'value' => $slider->id
				));
			}
			
			$fields['module_slider_layerslider'] = $slider_layerslider;
		}
		
		array_push($fields['module_slider_type'], array(
			'title' => __('LayerSlider','ux'), 'value' => 'layerslider'
		));
	}
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_layerslider_select', 10);

//layerslider config fields
function ux_pb_module_layerslider_fields($module_fields){
	if(is_plugin_active('LayerSlider/layerslider.php') && isset($module_fields['slider'])){
		array_push($module_fields['slider']['item'], array(
			'title' => __('LayerSlider Alias','ux'),
			'description' => __('The right hand dropdown menu would be enabled after you have create at least 1 slider by LayerSlider plugin.','ux'),
			'type' => 'select',
			'name' => 'module_slider_layerslider',
			'control' => array(
				'name' => 'module_slider_type',
				'value' => 'layerslider'
			)
		));
	}
	return $module_fields;
}
add_filter('ux_pb_module_fields', 'ux_pb_module_layerslider_fields', 10);

//revolution select fields
function ux_pb_module_revolution_select($fields){
	if(is_plugin_active('revslider/revslider.php') && isset($fields['module_slider_type'])){
		global $wpdb;
		$table_revslider = $wpdb->prefix . "revslider_sliders";
		$revslidersliders = $wpdb->get_results("
			SELECT * FROM $table_revslider
			ORDER BY id ASC
			"
		);
		
		if(count($revslidersliders)){
			$slider_revslider = array();
			foreach($revslidersliders as $num => $slider){
				array_push($slider_revslider, array(
					'title' => $slider->title, 'value' => $slider->alias
				));
			}
			
			$fields['module_slider_revolution'] = $slider_revslider;
		}
		
		array_push($fields['module_slider_type'], array(
			'title' => __('Revolution Slider','ux'), 'value' => 'revolutionslider'
		));
	}
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_revolution_select', 10);

//revslider config fields
function ux_pb_module_revslider_fields($module_fields){
	if(is_plugin_active('revslider/revslider.php') && isset($module_fields['slider'])){
		array_push($module_fields['slider']['item'], array(
			'title' => __('Revolution Slider Alias','ux'),
			'type' => 'select',
			'name' => 'module_slider_revolution',
			'control' => array(
				'name' => 'module_slider_type',
				'value' => 'revolutionslider'
			)
		));
	}
	return $module_fields;
}
add_filter('ux_pb_module_fields', 'ux_pb_module_revslider_fields', 10);
?>