<?php
//count down template
function ux_pb_module_countdown($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'text-block';
	
	if($module_post){
		//count down confing
		$time              = get_post_meta($module_post, 'module_countdown_time', true);
		$start             = get_post_meta($module_post, 'module_countdown_start', true);
		$end               = get_post_meta($module_post, 'module_countdown_end', true);
		
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$date_array = array(
			'years' => 0,
			'months' => 1,
			'days' => 2,
			'hours' => 3,
			'minutes' => 4,
			'seconds' => 5
		);
		
		$start = $start ? $date_array[$start] : $date_array['years'];
		$end = $end ? $date_array[$end] : $date_array['seconds'];
		
		$date_format = false;
		foreach($date_array as $date => $i){
			if($i >= $start && $i <= $end){
				switch($date){
					case 'years': $date_format .= 'y'; break;
					case 'months': $date_format .= 'o'; break;
					case 'days': $date_format .= 'd'; break;
					case 'hours': $date_format .= 'H'; break;
					case 'minutes': $date_format .= 'M'; break;
					case 'seconds': $date_format .= 'S'; break;
				}
			}
		}
		
		$date = new DateTime($time); ?>
        <div class="countdown <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>" data-years="<?php echo esc_attr($date->format('Y')); ?>" data-months="<?php echo esc_attr($date->format('n')); ?>" data-days="<?php echo esc_attr($date->format('d')); ?>" data-hours="<?php echo esc_attr($date->format('H')); ?>" data-minutes="<?php echo esc_attr($date->format('i')); ?>" data-seconds="<?php echo esc_attr($date->format('s')); ?>" data-dateformat="<?php echo esc_attr($date_format); ?>"></div>
	<?php
	}
}
add_action('ux-pb-module-template-count-down', 'ux_pb_module_countdown');

//count down select fields
function ux_pb_module_countdown_select($fields){
	$fields['module_countdown_start'] = array(
		array('title' => __('Years','ux'), 'value' => 'years'),
		array('title' => __('Months','ux'), 'value' => 'months'),
		array('title' => __('Days','ux'), 'value' => 'days'),
		array('title' => __('Hours','ux'), 'value' => 'hours'),
		array('title' => __('Minutes','ux'), 'value' => 'minutes'),
		array('title' => __('Seconds','ux'), 'value' => 'seconds')
	);
	
	$fields['module_countdown_end'] = array(
		array('title' => __('Years','ux'), 'value' => 'years'),
		array('title' => __('Months','ux'), 'value' => 'months'),
		array('title' => __('Days','ux'), 'value' => 'days'),
		array('title' => __('Hours','ux'), 'value' => 'hours'),
		array('title' => __('Minutes','ux'), 'value' => 'minutes'),
		array('title' => __('Seconds','ux'), 'value' => 'seconds')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_countdown_select');

//count down config fields
function ux_pb_module_countdown_fields($module_fields){
	$module_fields['count-down'] = array(
		'id' => 'count-down',
		'animation' => true,
		'title' => __('Count Down','ux'),
		'item' =>  array(
			array('title' => __('Date','ux'),
				  'description' => __('Select a deadline for the counter','ux'),
				  'type' => 'date',
				  'name' => 'module_countdown_time'),
				  
			array('title' => __('Count Start','ux'),
				  'description' => __('Choose a start time unit','ux'),
				  'type' => 'select',
				  'name' => 'module_countdown_start',
				  'default' => 'years'),
				  
			array('title' => __('Count To','ux'),
				  'description' => __('Choose a end time unit','ux'),
				  'type' => 'select',
				  'name' => 'module_countdown_end',
				  'default' => 'seconds'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_countdown_fields');
?>