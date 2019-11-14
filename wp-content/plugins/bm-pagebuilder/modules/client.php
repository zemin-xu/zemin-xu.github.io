<?php
//client template
function ux_pb_module_client($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'client';
	
	if($module_post){
		//client confing
		$category          = get_post_meta($module_post, 'module_client_category', true);
		$columns           = get_post_meta($module_post, 'module_client_columns', true);
		// $advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		// $animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		// $animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		// $animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		// $animation_end     = 'data-animationend="' . $animation_end . '"';
		
		$category          = get_term_by('id', $category, 'client_cat');
		$category_slug     = $category ? $category->slug : false;
		
		$get_clients = get_posts(array(
			'posts_per_page' => -1,
			'post_type'      => 'clients_item',
			'client_cat'     => $category_slug
		));
		
		$span_class = $columns ? $span_class = 12 / intval($columns) : $span_class = 12 / 1;
		$data_column = $columns ? $columns : 1; ?>
        
        <div class="clients_wrap owl-carousel-pb clearfix" data-item="<?php echo esc_attr($data_column); ?>" data-auto="false" data-center="false" data-margin="10" data-autowidth="false" data-slideby="<?php echo esc_attr($data_column); ?>">

            <?php if($get_clients){ ?> 
					<?php foreach($get_clients as $num => $client){
						$ux_theme_meta = get_post_meta($client->ID, 'ux_theme_meta', true);
						$client_link = isset($ux_theme_meta['theme_meta_client_link']) ? $ux_theme_meta['theme_meta_client_link'] : false; ?>
                        <div class="client-li"><a class="clients-wrap-unit-a" title="<?php echo esc_attr(get_the_title($client->ID)); ?>" href="<?php echo esc_url($client_link);?>"><?php echo balanceTags(get_the_post_thumbnail($client->ID, 'full')); ?></a></div>
                    <?php } ?>
            <?php } ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-client', 'ux_pb_module_client');

//client config fields
function ux_pb_module_client_fields($module_fields){
	$module_fields['client'] = array(
		'id' => 'client',
		'animation' => true,
		'title' => __('Client','ux'),
		'item' =>  array(
			array('title' => __('Client Category','ux'),
				  'description' => __('The clients under the category you selected would be shown in this module','ux'),
				  'type' => 'category',
				  'name' => 'module_client_category',
				  'taxonomy' => 'client_cat',
				  'default' => '0'),
				  
			array('title' => __('Columns','ux'),
				  'description' => __('Setup the number of columns you want to show in front end','ux'),
				  'type' => 'text',
				  'name' => 'module_client_columns'),
				  
			// array('title' => __('Advanced Settings','ux'),
			// 	  'description' => __('magin and animations','ux'),
			// 	  'type' => 'switch',
			// 	  'name' => 'module_advanced_settings',
			// 	  'default' => 'off'),
				  
			array('title' => __('Bottom Margin','ux'),
				  'description' => __('the spacing outside the bottom of module','ux'),
				  'type' => 'select',
				  'name' => 'module_bottom_margin',
				  'default' => 'bottom-space-40'
				  // 'control' => array(
					 //  'name' => 'module_advanced_settings',
					 //  'value' => 'on')
				  )
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_client_fields');
?>