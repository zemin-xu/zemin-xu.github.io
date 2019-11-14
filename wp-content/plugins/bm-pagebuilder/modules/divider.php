<?php
//divider template
function ux_pb_module_divider($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'divider';
	
	if($module_post){
		//divider confing
		$type              = get_post_meta($module_post, 'module_divider_type', true);
		$text              = get_post_meta($module_post, 'module_divider_text', true);
		$text_align        = get_post_meta($module_post, 'module_divider_text_align', true);
		$height            = get_post_meta($module_post, 'module_divider_height', true);
		$bg_color          = get_post_meta($module_post, 'module_divider_background_color', true);
		$short_line        = get_post_meta($module_post, 'module_divider_short', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		switch($text_align){
			case 'left': $type_align = 'title_on_left'; break;
			case 'center': $type_align = 'text-center'; break;
			case 'right': $type_align = 'title_on_right'; break;
			case 'above': $type_align = 'title_above'; break;
		}
		$type_class       = $type != 'text_and_line' ? 'without-title' : false;
		$type_top         = $type != 'text_and_line' ? 'style="top: 8px;"' : false;
		$type_blank       = $type == 'blank_divider' ? 'blank-divider' : false;
		$type_dashed      = $type == 'dashed_line' ? 'dashed_line' : false;
		$type_align       = $type == 'text_and_line' ? $type_align : false;
		$height_class     = $type == 'blank_divider' ? $height : false;
		$bg_color         = $bg_color ? ux_theme_switch_color($bg_color) : false;
		$bg_color         = $type != 'blank_divider' ? $bg_color : false;
		$divider_title    = $type == 'text_and_line' ? '<h4 class="' .esc_attr($bg_color). '" style="background:none;">' .balanceTags($text). '</h4>' : false;
		$separator_inn    = '<div class="separator_inn bg-' .esc_attr($bg_color). '" ' . $type_top . '></div>'; 
        $short_line       = $short_line == 'on' ? 'short-line' : false;
        ?>
        <div class="separator <?php echo sanitize_html_class($type_dashed); ?> <?php echo sanitize_html_class($type_class); ?> <?php echo sanitize_html_class($type_align); ?> <?php echo sanitize_html_class($type_blank); ?> <?php echo sanitize_html_class($height_class); ?> <?php echo sanitize_html_class($short_line); ?> <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>">
			<?php if($text_align == 'center'){
				echo balanceTags($separator_inn);
			} 
			
			echo balanceTags($divider_title);
			echo balanceTags($separator_inn);
			?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-divider', 'ux_pb_module_divider');

//divider select fields
function ux_pb_module_divider_select($fields){
	$fields['module_divider_type'] = array(
		array('title' => __('Single Line','ux'), 'value' => 'single_line'),
		//array('title' => __('Dashed Line','ux'), 'value' => 'dashed_line'),
		array('title' => __('Text and Line','ux'), 'value' => 'text_and_line'),
		array('title' => __('Blank Divider','ux'), 'value' => 'blank_divider')
	);
	
	$fields['module_divider_text_align'] = array(
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Center','ux'), 'value' => 'center'),
		array('title' => __('Right','ux'), 'value' => 'right'),
		array('title' => __('Above','ux'), 'value' => 'above')
	);
		
	$fields['module_divider_height'] = array(
		array('title' => __('20px','ux'), 'value' => 'height-20'),
		array('title' => __('40px','ux'), 'value' => 'height-40'),
		array('title' => __('60px','ux'), 'value' => 'height-60'),
		array('title' => __('80px','ux'), 'value' => 'height-80'),
		array('title' => __('100px','ux'), 'value' => 'height-100'),
		array('title' => __('200px','ux'), 'value' => 'height-200'),
		array('title' => __('300px','ux'), 'value' => 'height-300'),
		array('title' => __('400px','ux'), 'value' => 'height-400')

	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_divider_select');

//divider config fields
function ux_pb_module_divider_fields($module_fields){
	$module_fields['divider'] = array(
		'id' => 'divider',
		'animation' => true,
		'title' => __('Divider','ux'),
		'item' =>  array(
			array('title' => __('Type','ux'),
				  'description' => __('select a type for the Divider module','ux'),
				  'type' => 'select',
				  'name' => 'module_divider_type',
				  'default' => 'single_line'),
				  
			array('title' => __('Divider Text','ux'),
				  'description' => __('Enter the text you want to show in the divider, HTML: &lt;span class=heighlight&gt;Heighlight Text&lt;/span&gt;','ux'),
				  'type' => 'text',
				  'name' => 'module_divider_text',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'text_and_line'
				  )),
			
			array('title' => __('Text Align','ux'),
				  'description' => __('Select alignment for the text','ux'),
				  'type' => 'select',
				  'name' => 'module_divider_text_align',
				  'default' => 'left',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'text_and_line'
				  )),
			
			array('title' => __('Height','ux'),
				  'type' => 'select',
				  'name' => 'module_divider_height',
				  'default' => '20px',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'blank_divider'
				  )),
				  
			array('title' => __('Color','ux'),
				  'description' => __('Select a color for the divider','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_divider_background_color',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'single_line|text_and_line'
				  )),

			array('title' => __('Short Line','ux'),
				  'type' => 'switch',
				  'name' => 'module_divider_short',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_divider_type',
					  'value' => 'single_line'
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
add_filter('ux_pb_module_fields', 'ux_pb_module_divider_fields');
?>