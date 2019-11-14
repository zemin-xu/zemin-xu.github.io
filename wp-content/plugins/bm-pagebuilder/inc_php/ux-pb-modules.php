<?php
//pagebuilder modules
function ux_pb_modules(){
	$ux_pb_modules = array(
		'accordion-toggle' => __('Accordion/Toggle','ux'),
		'button'           => __('Button','ux'),
		'contact-form'     => __('Contact Form','ux'),
		'client'           => __('Client','ux'),
		'count-down'       => __('Count Down','ux'),
		'divider'          => __('Divider','ux'), 
		'google-map'       => __('Google Map','ux'),
		'icon-box'         => __('Icon Box','ux'),
		'image-box'        => __('Image Box','ux'), 
		'progress-bar'     => __('Info-graphic','ux'), 
		'message-box'      => __('Message Box','ux'),
		'price'            => __('Price','ux'),
		'promote'          => __('Promote','ux'), 
		'single-image'     => __('Single Image','ux'),
		'slider'           => __('Slider','ux'),
		'team'       	   => __('Team','ux'),
		'tabs'             => __('Tabs','ux'), 
		'testimonials'     => __('Testimonials','ux'),
		'text-block'       => __('Text Block','ux'),
		'text-list'        => __('Text List','ux'),
		'video'            => __('Video','ux'),
		'latest-tweets'    => __('Latest Tweets','ux'),
		'fullwidth'        => __('Fullwidth Wrap','ux'),
		'fullwidth-block'  => __('Fullwidth Wrap (Block)','ux'),
	);
	$ux_pb_modules = apply_filters('ux_pb_config_fields', $ux_pb_modules);
	return $ux_pb_modules;
}

//pagebuilder choose module
function ux_pb_choose_module($target=''){
	$ux_pb_modules = ux_pb_modules();
	if(count($ux_pb_modules) > 0){ ?>
        <ul class="nav nav-pills ux-pb-choose-module" data-target="<?php echo esc_attr($target); ?>">
            <?php foreach($ux_pb_modules as $id => $modules){
				if($id != 'fullwidth' && $id != 'fullwidth-block'){ ?>
                    <li><a href="<?php echo esc_attr('#' .$id); ?>" data-toggle="insert-module" data-id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr('module-' .$id); ?>"><?php echo esc_html($modules); ?></a></li>
                <?php
				}
			} ?>
        </ul>
	<?php
	}
}

//pagebuilder load module
function ux_pb_load_module($post_id){
	$ux_pb_meta = get_post_meta($post_id, 'ux_pb_meta', true);
	
	if($ux_pb_meta){
		foreach($ux_pb_meta as $wrap){
			$col = $wrap['col'];
			$type = $wrap['type'];
			$first = $wrap['first'];
			$itemid = $wrap['itemid'];
			$moduleid = isset($wrap['moduleid']) ? $wrap['moduleid'] : false;
			$items = isset($wrap['items']) ? $wrap['items'] : false;
			ux_pb_module_template($col, $type, $first, $itemid, $moduleid, $items, 'wrap');
        }
	}
}

//pagebuilder module template
function ux_pb_module_template($col, $type, $first, $itemid, $moduleid, $items, $key){
	$text_fullwidth = __('Fullwidth Wrap','ux');
	$text_fullwidth_block = __('Fullwidth Wrap (Block)','ux');
	$text_addmodule = __('+ Module','ux');
	$text_setting = __('Setting','ux');
	$text_choosemodule = __('Choose Module','ux');
	
	$ux_pb_modules = ux_pb_modules();
	$module_title = $moduleid ? $ux_pb_modules[$moduleid] : false;
	$wrap_class = $key == 'wrap' ? 'isotopey' : 'sub-isotopey';
	
	$cols = array(
		'12' => '1/1',
		'9'  => '3/4',
		'8'  => '2/3',
		'6'  => '1/2',
		'4'  => '1/3',
		'3'  => '1/4'
	);
	
	if($type != 'module'){ ?>
    
		<div class="ux-pb-item isotopey ux-sortable-wrap" pb-col="<?php echo esc_attr($col); ?>" data-type="<?php echo esc_attr($type); ?>" data-itemid="<?php echo esc_attr($itemid); ?>">
            <input class="ux-pb-field-col" type="hidden" value="<?php echo sanitize_text_field($col); ?>" />
            <input class="ux-pb-field-type" type="hidden" value="<?php echo sanitize_text_field($type); ?>" />
            <input class="ux-pb-field-first" type="hidden" value="<?php echo sanitize_text_field($first); ?>" />
            <input class="ux-pb-field-itemid" type="hidden" value="<?php echo sanitize_text_field($itemid); ?>" />
            <div class="panel-pbbox">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php switch($type){
                            case 'general' ?>
                                <a href="#" class="increase"><span class="glyphicon glyphicon-plus"></span></a>
                                <a href="#" class="decrease"><span class="glyphicon glyphicon-minus"></span></a>
                                <div class="module-title"><span class="label label-primary"><?php echo esc_html($cols[$col]); ?></span></div>
                                <div class="module-choose" data-target="#ux-pb-modal" data-title="<?php echo esc_attr($text_choosemodule); ?>" data-id="choose-module"><span class="label label-default"><?php echo esc_html($text_addmodule); ?></span></div>
                                <a href="#" class="remove"><span class="glyphicon glyphicon-remove"></span></a>
                            <?php
                            break;
                            
                            case 'fullwidth':
								global $ux_pagebuilder; 
								$module_post = $ux_pagebuilder->item_postid($itemid);
								$anchor_name = get_post_meta($module_post, 'module_fullwidth_anchor_name', true);
								$label_fullwidth = $text_fullwidth;
								if($anchor_name != ''){
									$label_fullwidth = $anchor_name;
								} ?>
                                
                                <div class="module-title"><span class="label label-primary"><?php echo esc_html($label_fullwidth); ?></span></div>
                                <div class="module-setting" data-target="#ux-pb-modal" data-title="<?php echo esc_attr($text_fullwidth); ?>" data-id="module-fullwidth" data-itemid="<?php echo esc_attr($itemid); ?>"><span class="label label-default"><?php echo esc_html($text_setting); ?></span></div>
                                <div class="module-choose" data-target="#ux-pb-modal" data-title="<?php echo esc_attr($text_choosemodule); ?>" data-id="choose-module"><span class="label label-default"><?php echo esc_html($text_addmodule); ?></span></div>
                                <a href="#" class="remove"><span class="glyphicon glyphicon-remove"></span></a>
                            <?php
                            break;
                            
                            case 'fullwidth-block':
								global $ux_pagebuilder; 
								$module_post = $ux_pagebuilder->item_postid($itemid);
								$anchor_name = get_post_meta($module_post, 'module_fullwidth_anchor_name', true);
								$label_fullwidth = $text_fullwidth_block;
								if($anchor_name != ''){
									$label_fullwidth = $anchor_name;
								} ?>
                                
                                <div class="module-title"><span class="label label-primary"><?php echo esc_html($label_fullwidth); ?></span></div>
                                <div class="module-setting" data-target="#ux-pb-modal" data-title="<?php echo esc_attr($text_fullwidth_block); ?>" data-id="module-fullwidth-block" data-itemid="<?php echo esc_attr($itemid); ?>"><span class="label label-default"><?php echo esc_html($text_setting); ?></span></div>
                                <div class="module-choose" data-target="#ux-pb-modal" data-title="<?php echo esc_attr($text_choosemodule); ?>" data-id="choose-module"><span class="label label-default"><?php echo esc_html($text_addmodule); ?></span></div>
                                <a href="#" class="remove"><span class="glyphicon glyphicon-remove"></span></a>
                            <?php
                            break;
                        } ?>
                    </div>
                    <div class="panel-body">
                        <div class="ux-pb-subbox-container">
							<?php if($items){
                                foreach($items as $item){
									$col = $item['col'];
									$type = $item['type'];
									$first = $item['first'];
									$itemid = $item['itemid'];
									$moduleid = $item['moduleid'];
									ux_pb_module_template($col, $type, $first, $itemid, $moduleid, false, 'module');
								}
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
	<?php }else{ ?> 
    
		<div class="ux-pb-item <?php echo sanitize_html_class($wrap_class); ?> ux-sortable-item" pb-col="<?php echo esc_attr($col); ?>" data-type="<?php echo esc_attr($type); ?>" data-itemid="<?php echo esc_attr($itemid); ?>">
            <input class="ux-pb-field-col" type="hidden" value="<?php echo sanitize_text_field($col); ?>" />
            <input class="ux-pb-field-type" type="hidden" value="<?php echo sanitize_text_field($type); ?>" />
            <input class="ux-pb-field-first" type="hidden" value="<?php echo sanitize_text_field($first); ?>" />
            <input class="ux-pb-field-itemid" type="hidden" value="<?php echo sanitize_text_field($itemid); ?>" />
            <input class="ux-pb-field-moduleid" type="hidden" value="<?php echo sanitize_text_field($moduleid); ?>" />
            <div class="panel-pbsubbox">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#" class="increase"></a>
                        <a href="#" class="decrease"></a>
                        <a href="#" class="edit" data-target="#ux-pb-modal" data-title="<?php echo esc_attr($module_title); ?>" data-id="<?php echo esc_attr($moduleid); ?>" data-itemid="<?php echo esc_attr($itemid); ?>"><?php esc_html_e('Edit','ux'); ?></a>
                        <a href="#" class="copy"></a>
                        <a href="#" class="remove"></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body"><?php echo esc_html($module_title); ?> <span class="label label-primary"><?php echo esc_html($cols[$col]); ?></span></div>
                </div>
            </div>
        </div>
        
	<?php	
	}
}

//pagebuilder copy module
function ux_pb_copy_module($post_id, $ux_pb_meta){
	global $ux_pagebuilder; 
	
	foreach($ux_pb_meta as $num => $wrap){
		$itemid = $wrap['itemid'];
		$items = isset($wrap['items']) ? $wrap['items'] : false;
		$random_num = date("Ymd-His") . '-' . rand(100,999) . '-' . $num;
		$module_post = $ux_pagebuilder->item_postid($itemid);
		
		if($module_post){
			global $wpdb;
			$post_fields = array(
				'post_title' => $random_num,
				'post_name' => $random_num,
				'post_status' => 'publish',
				'post_type' => 'modules'
			);
			
			$post_this_id = wp_insert_post($post_fields);
			$db_query_custom = $wpdb->prepare("
				SELECT `meta_key`, `meta_value`
				FROM $wpdb->postmeta 
				WHERE `post_id` = %d
				",
				$module_post
			);
			
			$get_post_custom = $wpdb->get_results($db_query_custom);
			
			if($get_post_custom){
				foreach($get_post_custom as $custom){
					$get_custom_meta = get_post_meta($module_post, $custom->meta_key, true);
					update_post_meta($post_this_id, $custom->meta_key, $get_custom_meta);
				}
			}
			$ux_pb_meta[$num]['itemid'] = $random_num;
		}
		if($items){
			foreach($items as $i => $item){
				$itemid = $item['itemid'];
				$random_num = date("Ymd-His") . '-' . rand(100,999) . '-' . $num . '-' . $i;
				$module_post = $ux_pagebuilder->item_postid($itemid);
				if($module_post){
					global $wpdb;
					$post_fields = array(
						'post_title' => $random_num,
						'post_name' => $random_num,
						'post_status' => 'publish',
						'post_type' => 'modules'
					);
					
					$post_this_id = wp_insert_post($post_fields);
					
					$db_query_custom = $wpdb->prepare("
						SELECT `meta_key`, `meta_value`
						FROM $wpdb->postmeta
						WHERE `post_id` = %d
						",
						$module_post
					);
					
					$get_post_custom = $wpdb->get_results($db_query_custom);
					
					if($get_post_custom){
						foreach($get_post_custom as $custom){
							$get_custom_meta = get_post_meta($module_post, $custom->meta_key, true);
							update_post_meta($post_this_id, $custom->meta_key, $get_custom_meta);
						}
					}
					$ux_pb_meta[$num]['items'][$i]['itemid'] = $random_num;
				}
			}
		}
	}
	update_post_meta($post_id, 'ux_pb_meta', $ux_pb_meta);
}

//pagebuilder copy module
function ux_pb_module_animation_style($itemid, $moduleid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$ux_pb_module_fields  = ux_pb_module_fields();
	
	$animation_style = '';
	if($module_post){
		$scroll_in_animation   = get_post_meta($module_post, 'module_scroll_in_animation', true);
		$scroll_animation_base = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_class = false;
		if(isset($ux_pb_module_fields[$moduleid])){
			if(isset($ux_pb_module_fields[$moduleid]['animation'])){
				$animation_class = $ux_pb_module_fields[$moduleid]['animation'];
			}
		}
		
		if($animation_class){
			$scroll_animation = $scroll_animation_base;
		}else{
			$scroll_animation = false;
		}
		
		$animation_style .= $scroll_animation != 'fadein' ? $scroll_animation . ' ' : false;
		$animation_style .= $scroll_in_animation == 'on' ? 'animation-default-ux ' : false;
		$animation_style .= $scroll_in_animation == 'on' ? 'animation-scroll-ux ' : false;
	}
	return $animation_style;
}
?>