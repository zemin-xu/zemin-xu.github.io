<?php
//google map template
function ux_pb_module_googlemap($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		//google map confing
		$address    = get_post_meta($module_post, 'module_googlemap_address', true);
		$canvas     = get_post_meta($module_post, 'module_googlemap_canvas', true);
		$height     = get_post_meta($module_post, 'module_googlemap_height', true);
		$view       = get_post_meta($module_post, 'module_googlemap_view', true);
		$zoom       = get_post_meta($module_post, 'module_googlemap_zoom', true);
		$pin        = get_post_meta($module_post, 'module_googlemap_pin', true);
		$pin_custom = get_post_meta($module_post, 'module_googlemap_pin_custom', true);
		$dismouse   = get_post_meta($module_post, 'module_googlemap_disable_mouse_scroll_zoom', true);
		$style      = get_post_meta($module_post, 'module_googlemap_style', true);
		$style_code = get_post_meta($module_post, 'module_googlemap_style_code', true);
		
		$height     = $height ? $height : 400;
		$height     = 'style="height: ' .esc_attr($height). 'px;"'; 
		$pin        = $pin == 'on' ? 't' : 'f';
		$dismouse   = $dismouse == 'on' ? 't' : 'f';
		$style      = $style == 'on' ? 't' : 'f';
		
		$location_l = -33.8674869;
		$location_r = 151.20699020000006;
		if($canvas){
			$map_location = str_replace('(', '', $canvas);
			$map_location = str_replace(')', '', $map_location);
			$map_location = explode(', ', $map_location);
			
			$location_l = (isset($map_location[0])) ? $map_location[0] : $location_l;
			$location_r = (isset($map_location[1])) ? $map_location[1] : $location_r;
		} ?>
        
        <div class="module-map-canvas" data-add="<?php echo esc_attr($address); ?>" <?php echo balanceTags($height); ?> data-l="<?php echo esc_attr($location_l); ?>" data-r="<?php echo esc_attr($location_r); ?>" data-zoom="<?php echo esc_attr($zoom); ?>" data-pin="<?php echo esc_attr($pin); ?>" data-view="<?php echo esc_attr($view); ?>" data-dismouse="<?php echo esc_attr($dismouse); ?>" data-pin-custom="<?php echo esc_attr($pin_custom); ?>" data-style="<?php echo esc_attr($style); ?>"></div>
        <textarea class="form-control hidden module-map-style-code" rows="3"><?php echo esc_js($style_code); ?></textarea>
	<?php
	}
}
add_action('ux-pb-module-template-google-map', 'ux_pb_module_googlemap');

//google map fields
function ux_pb_module_googlemap_select($fields){
	$fields['module_googlemap_zoom'] = array(
		array('title' => __('1','ux'), 'value' => '1'),
		array('title' => __('2','ux'), 'value' => '2'),
		array('title' => __('3','ux'), 'value' => '3'),
		array('title' => __('4','ux'), 'value' => '4'),
		array('title' => __('5','ux'), 'value' => '5'),
		array('title' => __('6','ux'), 'value' => '6'),
		array('title' => __('7','ux'), 'value' => '7'),
		array('title' => __('8','ux'), 'value' => '8'),
		array('title' => __('9','ux'), 'value' => '9'),
		array('title' => __('10','ux'), 'value' => '10'),
		array('title' => __('11','ux'), 'value' => '11'),
		array('title' => __('12','ux'), 'value' => '12'),
		array('title' => __('13','ux'), 'value' => '13'),
		array('title' => __('14','ux'), 'value' => '14'),
		array('title' => __('15','ux'), 'value' => '15'),
		array('title' => __('16','ux'), 'value' => '16'),
		array('title' => __('17','ux'), 'value' => '17'),
		array('title' => __('18','ux'), 'value' => '18'),
		array('title' => __('19','ux'), 'value' => '19'),
		array('title' => __('20','ux'), 'value' => '20')
	);
	
	$fields['module_googlemap_view'] = array(
		array('title' => __('Map','ux'), 'value' => 'map'),
		array('title' => __('Satellite','ux'), 'value' => 'satellite'),
		array('title' => __('Map+Terrain','ux'), 'value' => 'map_terrain')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_googlemap_select');

//google map config fields
function ux_pb_module_googlemap_fields($module_fields){
	$module_fields['google-map'] = array(
		'id' => 'google-map',
		'animation' => false,
		'title' => __('Google Map','ux'),
		'item' =>  array(
			array('title' => __('Address','ux'),
				  'description' => __('Enter the address that you would like to show on the map here, i.e. "Sydney, NSW".','ux'),
				  'type' => 'text',
				  'name' => 'module_googlemap_address'),
				  
			array('type' => 'google_map',
				  'name' => 'module_googlemap_canvas'),
				  
			array('title' => __('Height','ux'),
				  'description' => __('Enter the height for your map (e.g. 400)','ux'),
				  'type' => 'text',
				  'name' => 'module_googlemap_height',
				  'default' => '300',
				  'unit' => __('px','ux')),
				  
			array('title' => __('View','ux'),
				  'description' => __('Select a map view','ux'),
				  'type' => 'select',
				  'name' => 'module_googlemap_view',
				  'default' => 'map'),
				  
			array('title' => __('Map Zoom','ux'),
				  'description' => __('Descriptions','ux'),
				  'type' => 'select',
				  'name' => 'module_googlemap_zoom',
				  'default' => '7'),
				  
			array('title' => __('Show Map Pin','ux'),
				  'type' => 'switch',
				  'name' => 'module_googlemap_pin',
				  'default' => 'on'),
				  
			array('type' => 'upload',
				  'name' => 'module_googlemap_pin_custom',
				  'control' => array(
					  'name' => 'module_googlemap_pin',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Enable Mouse Scroll Zoom','ux'),
				  'type' => 'switch',
				  'name' => 'module_googlemap_disable_mouse_scroll_zoom',
				  'default' => 'off'),
				  
			array('title' => __('Enable Google Map Style','ux'),
				  'type' => 'switch',
				  'name' => 'module_googlemap_style',
				  'default' => 'off'),
				  
			array('type' => 'textarea',
				  'name' => 'module_googlemap_style_code',
				  'description' => __('Edit the style <a href="http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html?utm_medium=twitter" target="_blank">here</a>, or get one in <a href="http://snazzymaps.com/" target="_blank">snazzymaps</a>','ux'),
				  'default' => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
				  'control' => array(
					  'name' => 'module_googlemap_style',
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
add_filter('ux_pb_module_fields', 'ux_pb_module_googlemap_fields');
?>