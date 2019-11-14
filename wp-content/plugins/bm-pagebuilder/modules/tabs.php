<?php
//tabs template
function ux_pb_module_tabs($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'tabs';
	
	if($module_post){
		//tabs confing
		$type              = get_post_meta($module_post, 'module_tabs_type', true);
		$items             = get_post_meta($module_post, 'module_tabs_items', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$nav_type          = $type == 'vertical_tabs' ? 'tabs-v' : 'tabs-h';
		$nav_tabs          = $type == 'vertical_tabs' ? 'nav-tabs-v' : false;
		$nav_content       = $type == 'vertical_tabs' ? 'tab-content-v' : false;
		$nav_clear         = $type == 'vertical_tabs' ? '<div class="clearfix"></div>' : false; ?>
        
        <div class="<?php echo sanitize_html_class($nav_type); ?> <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>">
            <?php if($items){
                $items_count = count($items['items']);
                $subcontrol_value = array();
                $get_subcontrol = ux_pb_getfield_subcontrol('module_tabs_items');
                if($get_subcontrol){
                    foreach($get_subcontrol as $subcontrol => $field){
                        $field_value = $field['value'];
                        $field_type = $field['type']; 
                        $subcontrol = $field_type == 'content' ? 'ux-pb-module-content' : $subcontrol;
                        $subcontrol_value[$field_value] = $items[$subcontrol];
                    }
                } ?>
                <ul id="myTab-<?php echo esc_attr($itemid); ?>" class="nav nav-tabs <?php echo sanitize_html_class($nav_tabs); ?>">
                    <?php for($i = 0; $i < $items_count; $i++){
                        $title = $subcontrol_value['title'][$i];
                        $content = $subcontrol_value['content'][$i];
                        $active = $i == 0 ? 'active' : false; ?>
                        <li class="<?php echo sanitize_html_class($active); ?>"><a href="#tabs_<?php echo esc_attr($itemid . $i); ?>"><?php echo esc_html($title); ?></a></li>
                    <?php } ?>
                </ul>
                
                <div class="tab-content <?php echo sanitize_html_class($nav_content); ?>">
                    <?php for($i = 0; $i < $items_count; $i++){
                        $title = $subcontrol_value['title'][$i];
                        $content = $subcontrol_value['content'][$i];
                        $active = $i == 0 ? 'active' : false;  ?>
                        <div id="tabs_<?php echo esc_attr($itemid . $i); ?>" class="tab-pane <?php echo sanitize_html_class($active); ?>"><?php echo balanceTags(do_shortcode($content)); ?></div>
                    <?php } ?>
                
                </div>
                <?php 
                echo balanceTags($nav_clear);
            } ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-tabs', 'ux_pb_module_tabs');

//tabs select fields
function ux_pb_module_tabs_select($fields){
	$fields['module_tabs_type'] = array(
		array('title' => __('Horizontal Tabs','ux'), 'value' => 'horizontal_tabs'),
		array('title' => __('Vertical Tabs','ux'), 'value' => 'vertical_tabs')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_tabs_select');

//tabs config fields
function ux_pb_module_tabs_fields($module_fields){
	$module_fields['tabs'] = array(
		'id' => 'tabs',
		'animation' => true,
		'title' => __('Tabs','ux'),
		'item' =>  array(
			array('title' => __('Type','ux'),
				  'description' => __('Select a layout for the Tabs module','ux'),
				  'type' => 'select',
				  'name' => 'module_tabs_type',
				  'default' => 'horizontal_tabs'),
				  
			array('title' => __('Add Item','ux'),
				  'description' => __('Press the "Add" button to add an item','ux'),
				  'type' => 'items',
				  'name' => 'module_tabs_items',
				  'count' => 4),
				  
			array('title' => __('Title','ux'),
				  'description' => __('Enter the title for this item','ux'),
				  'type' => 'text',
				  'name' => 'module_tabs_title',
				  'subcontrol' => 'module_tabs_items|title'),
				  
			array('title' => __('Content','ux'),
				  'description' => __('Enter content for this Icon Box','ux'),
				  'type' => 'content',
				  'name' => 'module_content',
				  'subcontrol' => 'module_tabs_items|content'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_tabs_fields');
?>