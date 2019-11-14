<?php
//text block template
function ux_pb_module_textblock($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'text-block';
	
	if($module_post){
		//text block confing
		$bg_color          = get_post_meta($module_post, 'module_textblock_background_color', true);
		$content           = get_post_meta($module_post, 'module_content', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$content           = $content ? $content : false;
		$centered_wdith    = get_post_meta($module_post, 'module_textblock_center_width', true);
		$centered_before   = $centered_wdith ? '<div class="text_block_centered" style="width:' .esc_attr($centered_wdith). '">' : false;
		$centered_after    = $centered_wdith ? '</div>' : false;
		$bg_color          = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : false;
		$module_style      = $bg_color ? 'text_block withbg' : 'text_block ux-mod-nobg'; ?>
        
        <div data-post="<?php echo esc_attr($itemid); ?>" class="<?php echo esc_attr($module_style); ?> <?php echo sanitize_html_class($bg_color); ?> <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>">
        	<?php echo balanceTags($centered_before); ?>
			<?php echo balanceTags(do_shortcode($content)); ?>
			<?php echo balanceTags($centered_after); ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-text-block', 'ux_pb_module_textblock');

function ux_pb_module_textblock_select($fields){
	$fields['module_textblock_center_width'] = array(
		array('title' => '100%', 'value' => ''),
		array('title' => '90%', 'value' => '90%'),
		array('title' => '80%', 'value' => '80%'),
		array('title' => '70%', 'value' => '70%'),
		array('title' => '60%', 'value' => '60%'),
		array('title' => '50%', 'value' => '50%')
	);
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_textblock_select');

//text block config fields
function ux_pb_module_textblock_fields($module_fields){
	$module_fields['text-block'] = array(
		'id' => 'text-block',
		'animation' => true,
		'title' => __('Text Block','ux'),
		'item' =>  array(
			array('title' => __('Background Color','ux'),
				  'description' => __('Select the Background Color for Text Block.','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_textblock_background_color'),
				  
			array('title' => __('Content','ux'),
				  'description' => __('Enter some content for this Text Block.','ux'),
				  'type' => 'content',
				  'name' => 'module_content'),

			array('title' => __('Inner Wrap Width','ux'),
				  'type' => 'select',
				  'name' => 'module_textblock_center_width',
				  'default' => ''),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_textblock_fields');
?>