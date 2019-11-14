<?php
//image 3+1 template
function ux_pb_module_image3_1($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'image3-1';
	$index = -1;
	$img_index = -1;
	
	if($module_post){
		$section_position = get_post_meta($module_post, 'module_image3_1_text_section_position', true);
		$images = get_post_meta($module_post, 'module_image3_1_images', true);
		$title = get_post_meta($module_post, 'module_image3_1_title', true);
		$description = get_post_meta($module_post, 'module_image3_1_description', true);
		$more_button = get_post_meta($module_post, 'module_image3_1_more_button', true);
		$more_button_text = get_post_meta($module_post, 'module_image3_1_more_button_text', true);
		$more_button_link = get_post_meta($module_post, 'module_image3_1_more_button_link', true);
		$text_color = get_post_meta($module_post, 'module_image3_1_text_color', true);
		$background_color = get_post_meta($module_post, 'module_image3_1_background_color', true);
		$show_circle = get_post_meta($module_post, 'module_image3_1_show_circle', true);
		$circle_text = get_post_meta($module_post, 'module_image3_1_circle_text', true);
		$circle_text_color = get_post_meta($module_post, 'module_image3_1_circle_text_color', true);
		$circle_bg_color = get_post_meta($module_post, 'module_image3_1_circle_bg_color', true);
		
		$position_index = -1;
		switch($section_position){
			case 'upper_left': $position_index = 0; break;
			case 'upper_right': $position_index = 1; break;
			case 'lower_left': $position_index = 2; break;
			case 'lower_right': $position_index = 3; break;
		}
		
		$text_style = 'color: #FFFFFF;';
		if($text_color){
			$text_style = 'color: ' .$text_color. ';';
		}
		
		$background_style = 'background-color: #F5F6F7;';
		if($background_color){
			$background_style = 'background-color: ' .$background_color. ';';
		} ?>
        
		<section class="image3-1 lightbox-photoswipe clearfix">
			<?php for($row=0; $row<2; $row++){ ?>
                <div class="image3-1-inn">
                
                    <?php for($col=0; $col<2; $col++){ $index++;
                    
                        if($position_index == $index){ ?>
                        
                            <div class="image3-1-unit" style=" <?php echo esc_attr($background_style); ?>">
                                
                                <div class="image3-1-unit-con">
                                    <h2 class="image3-1-unit-tit"><?php echo esc_html($title); ?></h2>
                                    <div class="image3-1-unit-excerpt"><?php echo esc_html($description); ?></div>
                                    <?php if($more_button == 'on'){ ?>
                                        <a href="<?php echo esc_url($more_button_link); ?>" title="section title" class="ux-btn iterblock-more"><?php echo esc_html($more_button_text); ?><span class="fa fa-play"></span></a>
                                    <?php } ?>
                                </div>
                                
                            </div>
                            
                        <?php
                        }else{ $img_index++; ?>
                            <div class="image3-1-unit" data-lightbox="true">
                            
                                <?php if(is_array($images) && isset($images[$img_index])){
                                    $image_id = $images[$img_index];
                                    
                                    $image_thumbnail = wp_get_attachment_image_src($image_id, 'image-thumb-4');
                                    $image_full = wp_get_attachment_image_src($image_id, 'full');
                                    $data_size = $image_full[1]. 'x' .$image_full[2];
                                    
                                    if($image_thumbnail){
                                        echo '<a href="' .$image_full[0]. '" class="lightbox-item" data-size="' .esc_attr($data_size). '"><img src="' .$image_thumbnail[0]. '" alt="' .esc_attr(get_the_title($image_id)). '"></a>';
                                    }
                                } ?>
                            
                            </div>
                        <?php
                        }
                    } ?>
                
                </div>
            <?php
            }
            
            if($show_circle == 'on'){
                
                $circle_text_style = 'color: #FFFFFF;';
                if($circle_text_color){
                    $circle_text_style = 'color: ' .$text_color. ';';
                }
                
                $circle_background_style = 'background-color: #FFD0C7;';
                if($circle_bg_color){
                    $circle_background_style = 'background-color: ' .$circle_bg_color. ';';
                }
                
                echo '<div class="image3-1-label" style="' .esc_attr($circle_text_style). ' ' .esc_attr($circle_background_style). '">' .esc_html($circle_text). '</div>';
            }?>
        </section>
	<?php
    }
}
add_action('ux-pb-module-template-image3-1', 'ux_pb_module_image3_1');

//image 3+1 select fields
function ux_pb_module_image3_1_select($fields){
	$fields['module_image3_1_text_section_position'] = array(
		array('title' => __('Upper Left','ux'), 'value' => 'upper_left'),
		array('title' => __('Upper Right','ux'), 'value' => 'upper_right'),
		array('title' => __('Lower Left','ux'), 'value' => 'lower_left'),
		array('title' => __('Lower Right','ux'), 'value' => 'lower_right')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_image3_1_select');

//image 3+1 config fields
function ux_pb_module_image3_1_fields($module_fields){
	$module_fields['image3-1'] = array(
		'id' => 'image3-1',
		'animation' => false,
		'title' => __('Image 3+1','ux'),
		'item' =>  array(
			array('title' => __('Text Section Position','ux'),
				  'description' => '',
				  'type' => 'select',
				  'name' => 'module_image3_1_text_section_position'),
				  
			array('title' => __('Title','ux'),
				  'type' => 'text',
				  'name' => 'module_image3_1_title'),
				  
			array('title' => __('Description','ux'),
				  'type' => 'text',
				  'name' => 'module_image3_1_description'),
				  
			array('title' => __('Show Learn More Button','ux'),
				  'type' => 'switch',
				  'name' => 'module_image3_1_more_button',
				  'default' => 'off'),
				  
			array('type' => 'text',
				  'name' => 'module_image3_1_more_button_text',
				  'default' => 'Learn More',
				  'control' => array(
					  'name' => 'module_image3_1_more_button',
					  'value' => 'on'
				  )),
				  
			array('type' => 'text',
				  'name' => 'module_image3_1_more_button_link',
				  'control' => array(
					  'name' => 'module_image3_1_more_button',
					  'value' => 'on'
				  )),
				  
			// array('title' => __('Text Color','ux'),
			// 	  'description' => '',
			// 	  'type' => 'switch-color',
			// 	  'name' => 'module_image3_1_text_color',
			// 	  'default' => '#FFFFFF'),
				  
			array('title' => __('Background Color','ux'),
				  'description' => '',
				  'type' => 'switch-color',
				  'name' => 'module_image3_1_background_color',
				  'default' => '#F5F6F7'),
				  
			array('type' => 'divider'),	
				  
			array('title' => __('Select Images','ux'),
				  'description' => '',
				  'type' => 'image-3+1',
				  'name' => 'module_image3_1_images',
				  'default' => array()),
			
			array('type' => 'divider'),
				  
			array('title' => __('Show Circle Label','ux'),
				  'type' => 'switch',
				  'name' => 'module_image3_1_show_circle',
				  'default' => 'off'),
				  
			array('title' => __('Text On Label','ux'),
				  'description' => '',
				  'type' => 'text',
				  'name' => 'module_image3_1_circle_text',
				  'control' => array(
					  'name' => 'module_image3_1_show_circle',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Label Text Color','ux'),
				  'description' => '',
				  'type' => 'switch-color',
				  'name' => 'module_image3_1_circle_text_color',
				  'default' => '#FFFFFF',
				  'control' => array(
					  'name' => 'module_image3_1_show_circle',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Label Background Color','ux'),
				  'description' => '',
				  'type' => 'switch-color',
				  'name' => 'module_image3_1_circle_bg_color',
				  'default' => '#FFD0C7',
				  'control' => array(
					  'name' => 'module_image3_1_show_circle',
					  'value' => 'on'
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
add_filter('ux_pb_module_fields', 'ux_pb_module_image3_1_fields');
?>