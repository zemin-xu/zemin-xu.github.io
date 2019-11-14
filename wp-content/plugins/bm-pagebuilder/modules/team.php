<?php
//team template
function ux_pb_module_team($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		//team confing
		$spacer        = get_post_meta($module_post, 'module_team_spacer_between', true);
		$per_page      = get_post_meta($module_post, 'module_team_per_page', true);
		$category      = get_post_meta($module_post, 'module_team_category', true);
		$image_style   = get_post_meta($module_post, 'module_team_image_style', true);
		$orderby       = get_post_meta($module_post, 'module_select_orderby', true);
		$order         = get_post_meta($module_post, 'module_select_order', true);
		
		$per_page      = $per_page ? $per_page : -1;
		$category      = get_term_by('id', $category, 'team_cat');
		$category_slug = $category ? $category->slug : false;
		$space         = $spacer != 'on' ? '0px' : '40px';
		$space_style   = $spacer != 'on' ? 'margin: 0px;' : 'margin: -40px 0px 0px -40px;';
		
		$get_team = get_posts(array(
			'posts_per_page' => $per_page ,
			'post_type'      => 'team_item',
			'team_cat'       => $category_slug,
			'orderby'        => $orderby,
			'order'          => $order
		));
		$count = count($get_team); ?>
        
        <!--Team list-->
        <div class="container-isotope" style="" data-post="<?php echo esc_attr($itemid); ?>">
            <div class="isotope grid_list team-isotope <?php echo sanitize_html_class($image_style); ?>" data-space="<?php echo esc_attr($space); ?>" style=" <?php echo esc_attr($space_style); ?>" data-size="<?php echo esc_attr($image_style); ?>">
                <?php ux_pb_module_load_team($itemid, 1); ?>
            </div>
        </div> <!--End container-isotope-->
        
	<?php
	}
}
add_action('ux-pb-module-template-team', 'ux_pb_module_team');

//team load template
function ux_pb_module_load_team($itemid, $paged){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'team';
	
	if($module_post){
		global $post;
		
		//team confing
		$spacer            = get_post_meta($module_post, 'module_team_spacer_between', true);
		$position          = get_post_meta($module_post, 'module_team_position', true);
		$email             = get_post_meta($module_post, 'module_team_email', true);
		$phone_number      = get_post_meta($module_post, 'module_team_phone_number', true);
		$social_network    = get_post_meta($module_post, 'module_team_social_network', true);
		$per_page          = get_post_meta($module_post, 'module_team_per_page', true);
		$category          = get_post_meta($module_post, 'module_team_category', true);
		$orderby           = get_post_meta($module_post, 'module_select_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$social_networks   = ux_pb_social_networks();
		
		$per_page          = $per_page ? $per_page : -1;
		$space_style       = $spacer != 'on' ? 'padding: 0px;' : 'padding: 40px 0 0 40px;';
		
		$category          = get_term_by('id', $category, 'team_cat');
		$category_slug     = $category ? $category->slug : false;
		
		$get_team = get_posts(array(
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'team_cat'       => $category_slug,
			'orderby'        => $orderby,
			'order'          => $order,
			'post_type'      => 'team_item'
		));
		
		foreach($get_team as $num => $post){ setup_postdata($post);
			$team_position      = ux_get_post_meta(get_the_ID(), 'theme_meta_team_position', true);
			$team_email         = ux_get_post_meta(get_the_ID(), 'theme_meta_team_email', true);
			$team_phone_number  = ux_get_post_meta(get_the_ID(), 'theme_meta_team_phone_number', true);
			$team_social_medias = ux_get_post_meta(get_the_ID(), 'theme_meta_team_social_medias', true);
			
			?>
            <div class="width2 isotope-item">
                <div class="inside card <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>" style=" <?php echo esc_attr($space_style); ?>">
                    <div class="team-item">
						
						<div class="img-wrap"><?php the_post_thumbnail(array(520,520), array('class' => 'team-img')); ?></div>
                        
                        <div class="team-item-con-back">
	                        <div class="team-item-con-back-inn">	
	                            <a class="team-item-title" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                            <div class="team-item-con-h">
	                                <?php if($position == 'on'){ ?>
	                                    <p class="team-position"><?php echo esc_html($team_position); ?></p>
	                                <?php }
	                                
	                                if($email == 'on'){ ?>
	                                    <p class="team-email"><?php echo is_email($team_email); ?></p>
	                                <?php }
	                                
	                                if($phone_number == 'on'){ ?>
	                                    <p class="team-phone"><?php echo esc_html($team_phone_number); ?></p>
	                                <?php } ?>
	                            </div>
	                            <?php if($social_network == 'on'){ ?>
	                                <p class="team-icons">
										<?php if($team_social_medias && isset($team_social_medias['icontype'])){
											$icon_type = $team_social_medias['icontype'];
											foreach($icon_type as $num => $type){
												$icon = $team_social_medias['icon'][$num];
												$url = $team_social_medias['url'][$num];
												$tip = $team_social_medias['tip'][$num]; ?>
												<a href="<?php echo esc_url($url); ?>">
													<?php if($type == 'fontawesome'){ ?>
                                                        <i class="<?php echo esc_attr($icon); ?>"></i>
                                                    <?php }elseif($type == 'user'){ ?>
                                                        <img src="<?php echo esc_url($icon); ?>" />
                                                    <?php } ?>
                                                </a>
											<?php
                                            }
										}
										?>
									</p><!--End team-icons-->
								<?php } ?>
							</div><!--End team-item-con-back-inn-->	
                        </div><!--End team-item-con-back-->
                    </div>
                </div><!--End inside-->
            </div>
		<?php
        }
		wp_reset_postdata();
	}
}

//tabs select fields
function ux_pb_module_team_select($fields){
	$fields['module_team_image_style'] = array(
		array('title' => __('Large Image','ux'), 'value' => 'large'),
		array('title' => __('Medium Image','ux'), 'value' => 'medium'),
		array('title' => __('Small Image','ux'), 'value' => 'small')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_team_select');

//team config fields
function ux_pb_module_team_fields($module_fields){
	$module_fields['team'] = array(
		'id' => 'team',
		'animation' => true,
		'title' => __('Team','ux'),
		'item' =>  array(
			array('title' => __('Style','ux'),
				  'type' => 'select',
				  'name' => 'module_team_image_style',
				  'default' => 'medium'),
			
			array('title' => __('Spacer Between Items','ux'),
				  'type' => 'switch',
				  'name' => 'module_team_spacer_between',
				  'default' => 'on'),
				  
			array('title' => __('Show Position','ux'),
				  'description' => __('Show the team number\'s position in the module','ux'),
				  'type' => 'switch',
				  'name' => 'module_team_position',
				  'default' => 'on'),
				  
			array('title' => __('Show Email','ux'),
				  'description' => __('Show the team number\'s email in the module','ux'),
				  'type' => 'switch',
				  'name' => 'module_team_email',
				  'default' => 'on'),
				  
			array('title' => __('Show Phone Number','ux'),
				  'description' => __('Show the team number\'s phone number in the module','ux'),
				  'type' => 'switch',
				  'name' => 'module_team_phone_number',
				  'default' => 'on'),
				  
			array('title' => __('Show Social Network','ux'),
				  'description' => __('show the team number\'s social medias in the module','ux'),
				  'type' => 'switch',
				  'name' => 'module_team_social_network',
				  'default' => 'on'),
				  
			array('title' => __('Number','ux'),
				  'description' => __('How many items should be displayed in this module, leave it empty to show all items.','ux'),
				  'type' => 'text',
				  'name' => 'module_team_per_page'),
			
			array('title' => __('Team Category','ux'),
				  'type' => 'category',
				  'name' => 'module_team_category',
				  'taxonomy' => 'team_cat',
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
add_filter('ux_pb_module_fields', 'ux_pb_module_team_fields');
?>