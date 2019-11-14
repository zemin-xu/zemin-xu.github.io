<?php
//text list template
function ux_pb_module_textlist($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'text-list';
	
	if($module_post){
		//text list confing
		$items             = get_post_meta($module_post, 'module_textlist_items', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		if($items){
			$items_count = count($items['items']);
			$subcontrol_value = array();
			$get_subcontrol = ux_pb_getfield_subcontrol('module_textlist_items');
			if($get_subcontrol){
				foreach($get_subcontrol as $subcontrol => $field){
					$field_value = $field['value'];
					$field_type = $field['type']; 
					$subcontrol_value[$field_value] = $items[$subcontrol];
				}
			}
			
			for($i = 0; $i < $items_count; $i++){
				$title = $subcontrol_value['title'][$i];
				$icons = $subcontrol_value['icons'][$i];
				
				if(strstr($icons, "fa fa")){
					$icons = '<i class="' .esc_attr($icons). '"></i>';
				}else{
					$icons = '<img class="user-uploaded-icons" src="' .esc_url($icons). '" />';
				} ?>
                
				<div class="text-list ux-mod-nobg <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>">
                    <?php echo balanceTags($icons); ?>
                    <p class="text-list-inn"> <?php echo esc_html($title); ?></p>
                </div>
			<?php
			}
		}
	}
}
add_action('ux-pb-module-template-text-list', 'ux_pb_module_textlist');

//text list config fields
function ux_pb_module_textlist_fields($module_fields){
	$module_fields['text-list'] = array(
		'id' => 'text-list',
		'animation' => true,
		'title' => __('Text List','ux'),
		'item' =>  array(
			array('title' => __('Add Item','ux'),
				  'description' => __('Press the "Add" button to add an item','ux'),
				  'type' => 'items',
				  'name' => 'module_textlist_items',
				  'count' => 4),
				  
			array('title' => __('Select Icon','ux'),
				  'description' => __('Choose a icon for this Icon Box','ux'),
				  'type' => 'icons',
				  'name' => 'module_textlist_icon',
				  'subcontrol' => 'module_textlist_items|icons'),
				  
			array('title' => __('Content','ux'),
				  'description' => __('Enter content for this Text List','ux'),
				  'type' => 'text',
				  'name' => 'module_textlist_content',
				  'subcontrol' => 'module_textlist_items|title'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_textlist_fields');
?>