<?php
//single image template
function ux_pb_module_singleimage($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'single-image';
	
	if($module_post){
		global $wpdb;
		
		//single image confing
		$image_src         = get_post_meta($module_post, 'module_singleimage_image', true);
		$style             = get_post_meta($module_post, 'module_singleimage_style', true);
		$align             = get_post_meta($module_post, 'module_singleimage_align', true);
		$effect            = get_post_meta($module_post, 'module_singleimage_effect', true);
		$lightbox          = get_post_meta($module_post, 'module_singleimage_lightbox', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		$gray_effect       = $style == 'grey' ? 'grayscale' : false;
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$get_attachment    = $wpdb->get_row($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE `guid` LIKE %s", $image_src));
		
		$thumb_full        = $get_attachment ? wp_get_attachment_image_src($get_attachment->ID, 'full') : false;
		$img_src_full      = $image_src ? $thumb_full[0] : false;
		$data_size         = $image_src ? $thumb_full[1]. 'x' .$thumb_full[2] : false;
		
		$shadow_before     = $style == 'shadow' ? '<div class="single-image-shadow shadow">' : false;
		$shadow_after      = $style == 'shadow' ? '</div>' : false;
		$mouseover         = $effect == 'on' ? 'mouse-over' : false;
		$lightbox_before   = $lightbox == 'on' ? '<div data-lightbox="true"><a class="lightbox-item ux-hover-wrap" href="' .esc_url($img_src_full). '" data-size="' .$data_size. '">' : '<div class="ux-hover-wrap">';
		$lightbox_after    = $lightbox == 'on' ? '</a></div>' : '</div>';
		$lightbox_class    = $lightbox == 'on' ? 'lightbox-photoswipe' : false;
		$image             = $image_src ? '<img class="single-image-img ' .sanitize_html_class($gray_effect). '"  src=" ' .esc_url($image_src). '" />' : false; ?>
		
		<div class="single-image <?php echo sanitize_html_class($lightbox_class); ?> <?php echo sanitize_html_class($mouseover); ?> <?php echo sanitize_html_class($align); ?>-ux <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>">
			<?php 
				echo balanceTags($lightbox_before);
				echo balanceTags($shadow_before);
				echo balanceTags($image);
				echo balanceTags($shadow_after);
				echo balanceTags($lightbox_after);
			?>
		</div>
        
	<?php
	}
}
add_action('ux-pb-module-template-single-image', 'ux_pb_module_singleimage');

//single image select fields
function ux_pb_module_singleimage_select($fields){
	$fields['module_singleimage_style'] = array(
		array('title' => __('Standard','ux'), 'value' => 'no'),
		array('title' => __('Shadow','ux'), 'value' => 'shadow'),
		array('title' => __('Grey','ux'), 'value' => 'grey')
	);
	
	$fields['module_singleimage_align'] = array(
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Center','ux'), 'value' => 'singleimage-center'),
		array('title' => __('Right','ux'), 'value' => 'right')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_singleimage_select');

//single image box config fields
function ux_pb_module_singleimage_fields($module_fields){
	$module_fields['single-image'] = array(
		'id' => 'single-image',
		'animation' => true,
		'title' => __('Single Image','ux'),
		'item' =>  array(
			array('title' => __('Image','ux'),
				  'description' => __('Select image','ux'),
				  'type' => 'upload',
				  'name' => 'module_singleimage_image'),
				  
			array('title' => __('Style','ux'),
				  'description' => __('Select a style for the image','ux'),
				  'type' => 'select',
				  'name' => 'module_singleimage_style',
				  'default' => 'no'),

			array('title' => __('Algin','ux'),
				  'description' => '',
				  'type' => 'select',
				  'name' => 'module_singleimage_align',
				  'default' => 'left'),
				  
			array('title' => __('Mouseover Effect','ux'),
				  'description' => __('Enable the mouseover effect','ux'),
				  'type' => 'switch',
				  'name' => 'module_singleimage_effect',
				  'default' => 'on'),
				  
			array('title' => __('Lightbox','ux'),
				  'description' => __('Enable the Lightbox','ux'),
				  'type' => 'switch',
				  'name' => 'module_singleimage_lightbox',
				  'default' => 'on'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_singleimage_fields');
?>