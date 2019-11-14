<?php
//promote template
function ux_pb_module_promote($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'promote';
	
	if($module_post){
		//promote confing
		$content               = get_post_meta($module_post, 'module_promote_content', true);
		$button_bgcolor        = get_post_meta($module_post, 'module_promote_button_bg_color', true);
		$button_mouseovercolor = get_post_meta($module_post, 'module_promote_button_bg_color_mouseover', true);
		$button_link           = get_post_meta($module_post, 'module_promote_button_link', true);
		$button_target         = get_post_meta($module_post, 'module_promote_button_link_target', true);
		$advanced_settings     = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base        = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style       = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end         = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$bgcolor               = $button_bgcolor ? 'bg-' . ux_theme_switch_color($button_bgcolor) : false;
		$mouseovercolor        = $button_mouseovercolor ? 'promote-hover-bg-' . ux_theme_switch_color($button_mouseovercolor) : false; 
		$target                = $button_target == 'on' ? 'target="_blank"' : false; 
		$button_link_before    = $button_link ? '<a href="' .esc_url($button_link). '" ' .$target. '>' : false;
		$button_link_after     = $button_link ? '</a>' : false;	

		?>
        
        <div class="promote-mod <?php echo sanitize_html_class($bgcolor); ?> <?php echo sanitize_html_class($mouseovercolor); ?> <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>" data-post="<?php echo esc_attr($itemid); ?>">
            <?php echo balanceTags($button_link_before); ?>
            <p class="promote-mod-a"><?php echo balanceTags($content); ?></p>
            <?php echo balanceTags($button_link_after); ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-promote', 'ux_pb_module_promote');

//promote select fields
function ux_pb_module_promote_select($fields){
	$fields['module_promote_text_align'] = array(
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Center','ux'), 'value' => 'center')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_promote_select');

//promote config fields
function ux_pb_module_promote_fields($module_fields){
	$module_fields['promote'] = array(
		'id' => 'promote',
		'animation' => true,
		'title' => __('Promote','ux'),
		'item' =>  array(
			array('title' => __('Content','ux'),
				  'description' => __('Enter the text you want to show in a largger size.','ux'),
				  'type' => 'textarea',
				  'name' => 'module_promote_content'),
				  
			array('title' => __('Background Color By Default','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_promote_button_bg_color'),
				  
			array('title' => __('Background Color Mouseover','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_promote_button_bg_color_mouseover'),
				  
			array('title' => __('Link','ux'),
				  'type' => 'text',
				  'name' => 'module_promote_button_link'),
				  
			array('title' => __('Open Link in New Tab','ux'),
				  'type' => 'switch',
				  'name' => 'module_promote_button_link_target',
				  'default' => 'off'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_promote_fields');
?>