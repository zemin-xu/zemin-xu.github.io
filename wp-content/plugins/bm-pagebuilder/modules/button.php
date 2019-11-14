<?php
//button template
function ux_pb_module_button($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'button';
	
	if($module_post){
		//button confing
		$items             = get_post_meta($module_post, 'module_button_items', true);
		$size              = get_post_meta($module_post, 'module_button_size', true);
		$align             = get_post_meta($module_post, 'module_button_align', true);
		
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$btn_align         = 'btn-' .$align;
		$btn_size          = 'button-medium';
		switch($size){
			case 'small': $btn_size = 'button-small'; break;
			case 'large': $btn_size = 'button-large'; break;
		} ?>
        
        <!--Button module-->
        <div class="btn-mod-wrap <?php echo sanitize_html_class($btn_align); ?>">
            <?php if(isset($items['items'])){
				if(count($items['items'])){
					foreach($items['items'] as $num => $item){
						$item_style = $items['module_button_items_style'][$num];
						$item_text = $items['module_button_items_text'][$num];
						$item_image = $items['module_button_items_image'][$num];
						$item_link = $items['module_button_items_link'][$num];
						$item_bgcolor = $items['module_button_items_color'][$num];
						$item_mouseovercolor = $items['module_button_items_mouseover_color'][$num];
						$item_how_icon = $items['module_button_items_show_icon'][$num];
						$item_icon = $items['module_button_items_icon'][$num];
						$item_icon_align = $items['module_button_items_icon_align'][$num];
						
						$item_style = $item_style ? $item_style : 'border';
						$item_link = $item_link ? $item_link : '#';
						$item_bgcolor = $item_bgcolor ? 'bg-' . ux_theme_switch_color($item_bgcolor) : false; 
						$item_mouseovercolor = $item_mouseovercolor ? 'bg-' . ux_theme_switch_color($item_mouseovercolor) . '-hover' : false; 
						$item_icon_align = $item_icon_align == 'left' ? 'on-left' : 'on-right';
						$item_hasicon = $item_how_icon == 'on' ? 'ux-btn-hasicon' : false;
						
						if(strstr($item_icon, "fa fa")){
							$item_icon = '<i class="' .esc_attr($item_icon_align). ' ' .esc_attr($item_icon). '"></i>';
						}else{
							$item_icon = '<img class="' .esc_attr($item_icon_align). ' user-uploaded-icons" src="' .esc_url($item_icon). '" />';
						}

						if ($item_style == 'image') { ?>
							<a class="ux-btn-image <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>" href="<?php echo esc_url($item_link); ?>"><img src="<?php echo esc_url($item_image); ?>" alt="<?php echo esc_attr($item_text); ?>"></a> 
						<?php } else {

						?>

							<a class="ux-btn <?php echo sanitize_html_class($item_hasicon); ?> <?php echo sanitize_html_class($btn_size); ?> <?php echo sanitize_html_class($item_bgcolor); ?> <?php echo sanitize_html_class($item_mouseovercolor); ?> <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>" href="<?php echo esc_url($item_link); ?>"><span class="ux-middle">
							<?php if($item_icon_align == 'on-left'){
								if($item_how_icon == 'on'){
									echo balanceTags($item_icon) . ' ';
								}
								echo '<span class="ux-btn-text">' .esc_html($item_text). '</span>';
							}else{
								echo '<span class="ux-btn-text">' .esc_html($item_text). '</span>';
								if($item_how_icon == 'on'){
									echo ' ' . balanceTags($item_icon);
								}
							} ?>
	                        </span></a>
					<?php
						} //end if style
					}
				}
            } ?>
        </div>	
	<?php
	}
}
add_action('ux-pb-module-template-button', 'ux_pb_module_button');

//button select fields
function ux_pb_module_button_select($fields){
	$fields['module_button_size'] = array(
		array('title' => __('Small','ux'), 'value' => 'small'),
		array('title' => __('Medium','ux'), 'value' => 'medium'),
		array('title' => __('Large','ux'), 'value' => 'large')
	);
	$fields['module_button_align'] = array(
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Center','ux'), 'value' => 'center'),
		array('title' => __('Right','ux'), 'value' => 'right')
	);
	$fields['module_button_skin'] = array(
		array('title' => __('Light','ux'), 'value' => 'btn-light'),
		array('title' => __('Dark','ux'), 'value' => 'btn-dark')
	);
	$fields['module_button_items_icon_align'] = array(
		array('title' => __('On Left','ux'), 'value' => 'left'),
		array('title' => __('On Right','ux'), 'value' => 'right')
	);
	$fields['module_button_items_style'] = array(
		array('title' => __('Border','ux'), 'value' => 'border'),
		array('title' => __('Image','ux'), 'value' => 'image')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_button_select');

//button config fields
function ux_pb_module_button_fields($module_fields){
	$module_fields['button'] = array(
		'id' => 'button',
		'animation' => true,
		'title' => __('Button','ux'),
		'item' =>  array(
			array('title' => __('Buttons','ux'),
				  'type' => 'items',
				  'name' => 'module_button_items',
				  'count' => 1),
			
			//**Button items
			array('title' => __('Button Style','ux'),
				  'type' => 'select',
				  'name' => 'module_button_items_style',
				  'subcontrol' => 'module_button_items|select2',
				  'default' => 'border'),

			array('title' => __('Button Image','ux'),
				  'type' => 'upload',
				  'name' => 'module_button_items_image',
				  'subcontrol' => 'module_button_items|upload',
				  'control' => array(
					  'name' => 'module_button_items_style',
					  'value' => 'image'
				  )),

			array('title' => __('Button Text','ux'),
				  'type' => 'text',
				  'name' => 'module_button_items_text',
				  'subcontrol' => 'module_button_items|title'),
				  
			array('title' => __('Button Link','ux'),
				  'type' => 'text',
				  'name' => 'module_button_items_link',
				  'subcontrol' => 'module_button_items|button_link'
				  ),
				  
			array('title' => __('Show Icon','ux'),
				  'type' => 'switch',
				  'name' => 'module_button_items_show_icon',
				  'subcontrol' => 'module_button_items|switch',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_button_items_style',
					  'value' => 'border'
				  )),
				  
			array('title' => __('Select Icon','ux'),
				  'description' => __('Choose a icon for this Icon Box','ux'),
				  'type' => 'icons',
				  'name' => 'module_button_items_icon',
				  'subcontrol' => 'module_button_items|icons',
				  'control' => array(
					  'name' => 'module_button_items_show_icon',
					  'value' => 'on'
				  )),
			
			array('title' => __('Icon Align','ux'),
				  'type' => 'select',
				  'name' => 'module_button_items_icon_align',
				  'subcontrol' => 'module_button_items|select',
				  'default' => 'left',
				  'control' => array(
					  'name' => 'module_button_items_show_icon',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Button Color','ux'),
				  'description' => __('Choose a color for the button','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_button_items_color',
				  'subcontrol' => 'module_button_items|bgcolor',
				  'control' => array(
					  'name' => 'module_button_items_style',
					  'value' => 'border'
				  )),
				  
			array('title' => __('Mouseover Color','ux'),
				  'description' => __('Choose a color for the button mouseover','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_button_items_mouseover_color',
				  'subcontrol' => 'module_button_items|bgcolor2',
				  'control' => array(
					  'name' => 'module_button_items_style',
					  'value' => 'border'
				  )),
			
			array('title' => __('Button Size','ux'),
				  'description' => __('Choose a size for the button','ux'),
				  'type' => 'select',
				  'name' => 'module_button_size',
				  'default' => 'medium'),
			
			array('title' => __('Buttons Align','ux'),
				  'type' => 'select',
				  'name' => 'module_button_align',
				  'default' => 'left'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_button_fields');
?>