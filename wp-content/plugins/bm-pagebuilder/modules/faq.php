<?php
//faq template
function ux_pb_module_faq($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'faq';
	
	if($module_post){
		//faq confing
		$category          = get_post_meta($module_post, 'module_faq_category', true);
		$orderby           = get_post_meta($module_post, 'module_select_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$category          = get_term_by('id', $category, 'question_cat');
		$category_slug     = $category ? $category->slug : false;
		
		$get_faq = get_posts(array(
			'posts_per_page' => -1,
			'post_type'      => 'faqs_item',
			'question_cat'   => $category_slug,
			'orderby'        => $orderby,
			'order'          => $order
		)); ?>
        
        <div id="accordion-<?php echo esc_attr($module_post); ?>" class="accordion accordion-style-b ux-mod-nobg faq-mod accordion-ux">
			<?php if($get_faq){
				global $post;
				foreach($get_faq as $post){ setup_postdata($post); ?>
                    <div class="accordion-group <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>">
                        <div class="accordion-heading">
                            <a href="#collapse_<?php the_ID(); ?>" data-parent="#accordion-<?php echo esc_attr($module_post); ?>" data-toggle="collapse" class="accordion-toggle"><?php the_title(); ?></a>
                        </div><!--End accordion-heading-->
                        
                        <div class="accordion-body collapse" id="collapse_<?php the_ID(); ?>">
                            <div class="accordion-inner">
                                <?php the_content(); ?>
                            </div><!--End accordion-inner-->
                        </div><!--End accordion-body-->
                    </div>
				<?php
				}
				wp_reset_postdata();
			} ?>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-faq', 'ux_pb_module_faq');

//faq config fields
function ux_pb_module_faq_fields($module_fields){
	$module_fields['faq'] = array(
		'id' => 'faq',
		'animation' => true,
		'title' => __('FAQ','ux'),
		'item' =>  array(
			array('title' => __('FAQ Category','ux'),
				  'description' => __('The questions under the category you selected would be shown in this module.','ux'),
				  'type' => 'category',
				  'name' => 'module_faq_category',
				  'taxonomy' => 'question_cat',
				  'default' => '0'),
				  
			array('title' => __('Order by','ux'),
				  'description' => __('Select sequence rules for the list','ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_faq_fields');
?>