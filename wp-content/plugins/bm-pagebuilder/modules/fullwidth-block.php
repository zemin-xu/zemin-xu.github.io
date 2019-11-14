<?php
//fullwidth template
function ux_pb_module_fullwidth_block($arg){
	$itemid = $arg['itemid'];
	$items = $arg['items'];
	$moduleid = 'fullwidth-block';
	
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	//fullwrap confing
	$block_name = get_post_meta($module_post, 'module_fullwidth_anchor_name', true);
	$block_type = get_post_meta($module_post, 'module_fullwidth_block_type', true);
	$block_height = get_post_meta($module_post, 'module_fullwidth_block_height', true);
	$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
	$animation_base = get_post_meta($module_post, 'module_scroll_animation_base', true);
	$scroll_animation = get_post_meta($module_post, 'module_scroll_in_animation', true);
	
	$scroll_in_animation = $scroll_animation == 'on' ? 'moudle_has_animation' : false;
	$style_in_animation = $scroll_animation == 'on' ? ' animation_hidden' : false;
	$animation_style = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
	$animation_end = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
	
	//block height
	$block_height_data = false;
	if(!empty($block_height)){
		$block_height_data = 'data-height="' .esc_attr($block_height). '"';
	}
	
	//block name
	$block_name_id = false; 
	if(!empty($block_name)){
		$block_name = str_replace(' ', '-', $block_name);
		?>	
		<a name="<?php echo esc_attr($block_name); ?>" class="fullwidth-anchor-name"></a>
	<?php 
		$block_name_id = ' id="'.$block_name.'" ';
	}
	
	//block count
	$block_count = 2;
	if($block_type == '3-col'){
		$block_count = 3;
	}
	
	//module index
	$module_num = -1;
	
	$modules = array();
	$module_index = -1;
	
	if($items){
		foreach($items as $item){
			$first = $item['first'];
			
			if($first == 'is'){
				$module_index++;
			}
			$modules[$module_index][] = $item;
		}
	}
	?>
    
    <div <?php echo balanceTags($block_name_id); ?> class="fullwidth-wrap fullwrap-block-style <?php echo esc_attr($scroll_in_animation); ?>" <?php echo balanceTags($block_height_data); ?>>
        <div class="<?php echo esc_attr($animation_style); ?>" <?php echo balanceTags($block_height_data); ?> data-animationend="<?php echo esc_attr($animation_end); ?>">
            <div class="fullwrap-block" <?php echo balanceTags($block_height_data); ?>>
				
				<?php for($block_num=1; $block_num<=$block_count; $block_num++){
					$block_columnType = get_post_meta($module_post, 'block_column_' .$block_num. '_type', true);
					
					$block_inn_id = 'fullwrap_block_' .$itemid. '_' .$block_num;
					
					//block class
					$block_class = array('col-md-4 col-sm-4');
					
					if($block_type == '3-col'){
						array_push($block_class, 'fullwrap-block-one-third');
					}elseif($block_type == '2-col-2-1'){
						array_push($block_class, 'fullwrap-block-one-third');
						if($block_num == 1){
							array_push($block_class, 'fullwrap-block-two-third');
						}
					}elseif($block_type == '2-col-1-2'){
						array_push($block_class, 'fullwrap-block-one-third');
						if($block_num == 2){
							array_push($block_class, 'fullwrap-block-two-third');
						}
					}else{
						array_push($block_class, 'fullwrap-block-half');
					}
					
					array_push($block_class, 'fullwrap-block-inn');
					
					//background color
					$block_bgColor = get_post_meta($module_post, 'block_column_' .$block_num. '_bg_color', true);
					if($block_bgColor){
						array_push($block_class, 'bg-' . ux_theme_switch_color($block_bgColor));
					}
					
					//dark background
					$block_darkBg = get_post_meta($module_post, 'block_column_' .$block_num. '_dark_background', true);
					if($block_darkBg == 'on'){
						//if($block_columnType == 'module' || $block_columnType == 'text-button' || $block_columnType == 'post-by-category' || $block_columnType == 'single-post'){
							array_push($block_class, 'fullwidth-text-white');
						//}
					}
					
					//bmslider
					if($block_columnType == 'bm-slider'){
						array_push($block_class, 'fullwrap-block-slider');
					}
					
					$block_class = join(' ', $block_class);
					?>
                     
                    <div id="<?php echo esc_attr($block_inn_id); ?>" class="<?php echo esc_attr($block_class); ?>" <?php echo balanceTags($block_height_data); ?>>
                    
						<?php switch($block_columnType){
							case 'module': $module_num++;
								//$module_row_in = get_post_meta($module_post, 'block_column_' .$block_num. '_row_in', true);
								$module_valign = get_post_meta($module_post, 'block_column_' .$block_num. '_valign', true);
								$module_fill_wrap = get_post_meta($module_post, 'block_column_' .$block_num. '_fill_wrap', true);
								$module_fill_wrap_class = $module_fill_wrap == 'on' ? ' fullwrap-block-mod-full-wrap' : false;

								//module class
								$module_class = array('fullwrap-block-mod-wrap', 'height-no-auto');
								switch($module_valign){
									case 'top':    array_push($module_class, 'fullwrap-block-mod-wrap-top'); break;
									case 'middle': array_push($module_class, 'fullwrap-block-mod-wrap-middle'); break;
									case 'bottom': array_push($module_class, 'fullwrap-block-mod-wrap-bottom'); break;
								}
								$module_class = join(' ', $module_class);
								
								if(count($modules)){
									foreach($modules as $i => $items){
										if($i == $module_num && count($items)){
											echo '<div class="' .esc_attr($module_class).esc_attr($module_fill_wrap_class).'" '.balanceTags($block_height_data).'><div class="row">';
											foreach($items as $i => $item){
												$col = $item['col'];
												$type = $item['type'];
												$first = $item['first'];
												$itemid = $item['itemid'];
												$moduleid = $item['moduleid'];
												
												if($first == 'is'){
													if($i != 0){
														echo '</div>';
														echo '<div class="row '.sanitize_html_class($fullwrap_innerWidth).'">';
													}
												}
												
												ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, false, 'module');
											}
											echo '</div></div>';
										}
									}
								}
							break;
							
							case 'text-button':
								$text_title    = get_post_meta($module_post, 'block_column_' .$block_num. '_text_title', true);
								$text_subtitle = get_post_meta($module_post, 'block_column_' .$block_num. '_text_subtitle', true);
								$text_content  = get_post_meta($module_post, 'block_column_' .$block_num. '_text_content', true);
								$text_link     = get_post_meta($module_post, 'block_column_' .$block_num. '_text_link', true);
								$show_button   = get_post_meta($module_post, 'block_column_' .$block_num. '_show_button', true);
								$button_text   = get_post_meta($module_post, 'block_column_' .$block_num. '_button_text', true);
								$bg_image      = get_post_meta($module_post, 'block_column_' .$block_num. '_bg_image', true);
								?>
                                
                                <section class="fullwrap-block-text-button">
                                    <?php if(!empty($text_subtitle)){
										echo '<h3 class="fullwrap-block-text-button-subtit">';
										echo esc_html($text_subtitle);
										echo '</h3>';
									}
									
									if(!empty($text_title)){
										echo '<h2 class="fullwrap-block-text-button-tit">';
										echo esc_html($text_title); 
										echo '</h2>';
									}
									
									if(!empty($text_content)){
										echo '<div class="fullwrap-block-text-button-des">';
										echo balanceTags($text_content);
										echo '</div>';
									}
									
									if($show_button == 'on'){
										//permalink
										$get_permalink = '#';
										if(!empty($text_link)){
											$get_permalink = esc_url($text_link);
										}
										
										if(!empty($button_text)){
											echo '<a class="fullwrap-block-text-button-btn ux-btn" href="' .esc_url($get_permalink). '">';
											echo esc_html($button_text);
											echo '</a>';
										}
									} ?>
                                </section>
                                
								<?php if(!empty($bg_image)){
									$block_style = 'background-image:url(' .esc_attr($bg_image). ');';
									echo '<div class="text-button-bg-image" style="' .esc_attr($block_style). '"></div>';
								}
							break;
							
							case 'bm-slider':
								$bm_slider = get_post_meta($module_post, 'block_column_' .$block_num. '_bm_slider', true);
								if($bm_slider && post_type_exists('bmslider')){
									ux_theme_bmslider($bm_slider);
								}
							break;
							
							default:
								$post_ategory  = get_post_meta($module_post, 'block_column_' .$block_num. '_post_ategory', true);
								$choose_post   = get_post_meta($module_post, 'block_column_' .$block_num. '_choose_post', true);
								$show_category = get_post_meta($module_post, 'block_column_' .$block_num. '_show_category', true);
								$show_date     = get_post_meta($module_post, 'block_column_' .$block_num. '_show_date', true);
								$show_author   = get_post_meta($module_post, 'block_column_' .$block_num. '_show_author', true);
								
								if(!empty($post_ategory) && !is_array($post_ategory)){
									$post_ategory = array($post_ategory);
								}
								
								$post_id = false;
								if($block_columnType == 'post-by-category'){
									if($post_ategory){
										$get_posts = get_posts(array(
											'posts_per_page' => 1,
											'category__in' => $post_ategory
										));
									}else{
										$get_posts = get_posts('posts_per_page=1');
									}
									$post_id = $get_posts[0]->ID;
								}elseif($block_columnType == 'single-post'){
									if($choose_post){
										$post_id = $choose_post;
									}
								}
								
								global $post;
								$post = get_post($post_id); setup_postdata($post);
								
								$style_data = false;
								if(has_post_thumbnail()){
									$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
									$style_data = 'background-image:url(' .$thumb[0]. ');';
								} ?>
								<section class="fullwrap-block-post">
									<div class="fullwrap-block-post-con">
										<?php if($show_category == 'on'){
											echo '<span class="fullwrap-block-post-cate clearfix">';
											ux_theme_hide_category('  ');
											echo '</span>';
										}
										?>
										<h2 class="fullwrap-block-post-tit"><a class="fullwrap-block-post-tit-a" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<span class="fullwrap-block-post-meta">
											<?php if($show_date == 'on'){
												echo '<span class="fullwrap-block-post-meta-unit">' .get_the_date(). '</span>';
											}
											
											if($show_author == 'on'){
												echo '<span class="fullwrap-block-post-meta-unit">' .esc_attr__('BY: ','muti');
												the_author_meta('display_name', $post->post_author);
												echo '</span>';
											} ?>
										</span>
                                        <?php if(has_post_format('video')){
											echo '<div class="video-face"><span class="fa fa-play video-play-btn"></span>';
											$get_post_meta = get_post_meta(get_the_ID(), 'ux_theme_meta', true);
											$video_embeded_code = $get_post_meta['theme_meta_video_embeded_code'];
											echo '<div class="video-wrap hidden">';
											if($video_embeded_code){
												if(strstr($video_embeded_code, "youtu") && !(strstr($video_embeded_code, "iframe"))){ ?>
													<iframe src="http://www.youtube.com/embed/<?php echo esc_attr(ux_theme_get_youtube($video_embeded_code));?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent" width="1500" height="844" allowfullscreen=""></iframe>
												<?php
												}elseif(strstr($video_embeded_code, "vimeo") && !(strstr($video_embeded_code, "iframe"))){ ?>
													<iframe src="http://player.vimeo.com/video/<?php echo esc_attr(ux_theme_get_vimeo($video_embeded_code)); ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0" width="1500" height="844" allowfullscreen=""></iframe>
												<?php	
												}else{
													echo balanceTags($video_embeded_code);
												}
											}
											echo '</div></div>';
										} ?>
									</div>
									<div class="fullwrap-block-post-bgimg" style=" <?php echo esc_attr($style_data); ?>"></div>
								</section>
								<?php
								wp_reset_postdata(); 
							break;
						} ?>
					</div>
                <?php } ?>
            </div><!--End fullwrap-block-->
        </div>
    </div>
<?php
}
add_action('ux-pb-module-template-fullwidth-block', 'ux_pb_module_fullwidth_block');

//fullwidth block set fields
function ux_pb_module_fullwidth_block_set_fields($type){
	$output = array();
	
	switch($type){
		case 'column_type':
			$output = array(
				array('title' => __('Module','ux'), 'value' => 'module'),
				array('title' => __('Text + Button','ux'), 'value' => 'text-button'),
				array('title' => __('Post by Category','ux'), 'value' => 'post-by-category'),
				//array('title' => __('Single Post','ux'), 'value' => 'single-post')
			);
			
			if(post_type_exists('bmslider')){
				array_push($output, array('title' => __('BM Slider','ux'), 'value' => 'bm-slider'));
			}
		break;
		
		case 'row_in':
			$output = array(
				array('title' => 1, 'value' => '1'),
				array('title' => 2, 'value' => '2'),
				array('title' => 3, 'value' => '3')
			);
		break;
		
		case 'valign':
			$output = array(
				array('title' => __('Top','ux'), 'value' => 'top'),
				array('title' => __('Middle','ux'), 'value' => 'middle'),
				array('title' => __('Bottom','ux'), 'value' => 'bottom')
			);
		break;
		
		case 'bmslider':
			$output = ux_theme_meta_slider_bmslider();
		break;
	}
	
	return $output;
}

//fullwidth block select fields
function ux_pb_module_fullwidth_block_select($fields){
	$fields['module_fullwidth_block_type'] = array(
		array('title' => __('3 Column','ux'), 'value' => '3-col'),
		array('title' => __('2 Column 1:1','ux'), 'value' => '2-col-1-1'),
		array('title' => __('2 Column 2:1','ux'), 'value' => '2-col-2-1'),
		array('title' => __('2 Column 1:2','ux'), 'value' => '2-col-1-2')
	);
	
	$fields['module_fullwidth_block_height'] = array(
		array('title' => __('1/2 of Fullwidth','ux'), 'value' => '1-2-fullwidth'),
		array('title' => __('1/3 of Fullwidth','ux'), 'value' => '1-3-fullwidth')
	);
	
		//block column 1
		$fields['block_column_1_type']            = ux_pb_module_fullwidth_block_set_fields('column_type');
		
			//$fields['block_column_1_row_in']      = ux_pb_module_fullwidth_block_set_fields('row_in');
			$fields['block_column_1_valign']      = ux_pb_module_fullwidth_block_set_fields('valign');
			$fields['block_column_1_choose_post'] = array();
			//$fields['block_column_1_choose_post'] = ux_theme_get_latest_post(50, array('standard', 'gallery', 'image', 'video'));
			$fields['block_column_1_bm_slider']   = ux_pb_module_fullwidth_block_set_fields('bmslider');
	
		//block column 2
		$fields['block_column_2_type']            = ux_pb_module_fullwidth_block_set_fields('column_type');
		
			//$fields['block_column_2_row_in']      = ux_pb_module_fullwidth_block_set_fields('row_in');
			$fields['block_column_2_valign']      = ux_pb_module_fullwidth_block_set_fields('valign');
			$fields['block_column_2_text_height'] = ux_pb_module_fullwidth_block_set_fields('text_height');
			$fields['block_column_2_choose_post'] = array();
			//$fields['block_column_2_choose_post'] = ux_theme_get_latest_post(50, array('standard', 'gallery', 'image', 'video'));
			$fields['block_column_2_bm_slider']   = ux_pb_module_fullwidth_block_set_fields('bmslider');
	
		//block column 3
		$fields['block_column_3_type']            = ux_pb_module_fullwidth_block_set_fields('column_type');
		
			//$fields['block_column_3_row_in']      = ux_pb_module_fullwidth_block_set_fields('row_in');
			$fields['block_column_3_valign']      = ux_pb_module_fullwidth_block_set_fields('valign');
			$fields['block_column_3_text_height'] = ux_pb_module_fullwidth_block_set_fields('text_height');
			$fields['block_column_3_choose_post'] = array();
			//$fields['block_column_3_choose_post'] = ux_theme_get_latest_post(50, array('standard', 'gallery', 'image', 'video'));
			$fields['block_column_3_bm_slider']   = ux_pb_module_fullwidth_block_set_fields('bmslider');
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_fullwidth_block_select');

//fullwidth block config fields
function ux_pb_module_fullwidth_block_fields($module_fields){
	$module_fields['fullwidth-block'] = array(
		'id' => 'fullwidth-block',
		'animation' => true,
		'title' => __('Fullwidth Wrap Block','ux'),
		'item' => array(
			array('title' => __('Anchor Name','ux'),
				  'description' => __('Please enter the anchor name, please use lowercase letters, do not use spaces and other characters','ux'),
				  'type' => 'text',
				  'name' => 'module_fullwidth_anchor_name'),
				  
			array('title' => __('Type','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_block_type',
				  'default' => '2-col-1-1'),
				  
			//Block 1
			array('title' => __('Block 1','ux'),
				  'type' => 'none',
				  'name' => 'block_column_1_name'),
				  
				  //Block type
				  array('title' => __('Type','ux'),
						'type' => 'select',
						'name' => 'block_column_1_type',
						'default' => 'module'),
						
				  array('title' => __('Background Color','ux'),
						'description' => __('Optional, choose a background color for the wrap','ux'),
						'type' => 'bg-color',
						'name' => 'block_column_1_bg_color',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'module|text-button|post-by-category|single-post'
						)),
				  
				  array('title' => __('Background Image','ux'),
						'type' => 'upload',
						'name' => 'block_column_1_bg_image',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Shift Text Color for Dark Background','ux'),
						'type' => 'switch',
						'name' => 'block_column_1_dark_background',
						'default' => 'off',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'module|text-button|post-by-category|single-post|bm-slider'
						)),
			
				  /*array('title' => __('Rows in This Block','ux'),
						'type' => 'select',
						'name' => 'block_column_1_row_in',
						'default' => '1',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'module'
						)),*/
			
				  array('title' => __('Vertical Align','ux'),
						'type' => 'select',
						'name' => 'block_column_1_valign',
						'default' => 'top',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'module'
						)),

				  array('title' => __('Fill Container','ux'),
						'type' => 'switch',
						'name' => 'block_column_1_fill_wrap',
						'default' => 'off',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'module'
						)),
			
				  array('title' => __('Title','ux'),
						'type' => 'text',
						'name' => 'block_column_1_text_title',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Subtitle','ux'),
						'type' => 'text',
						'name' => 'block_column_1_text_subtitle',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Content','ux'),
						'type' => 'textarea',
						'name' => 'block_column_1_text_content',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Show Button','ux'),
						'type' => 'switch',
						'name' => 'block_column_1_show_button',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Button Text','ux'),
						'type' => 'text',
						'name' => 'block_column_1_button_text',
						'control' => array(
							'name' => 'block_column_1_show_button',
							'value' => 'on'
						)),
			
				  array('title' => __('Link','ux'),
						'type' => 'text',
						'name' => 'block_column_1_text_link',
						'control' => array(
							'name' => 'block_column_1_show_button',
							'value' => 'on'
						)),
			
				  array('title' => __('Category','ux'),
						'type' => 'category-multiple',
						'name' => 'block_column_1_post_ategory',
						'default' => '0',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'post-by-category'
						)),
			
				  array('title' => __('Choose a Post','ux'),
						'type' => 'select',
						'name' => 'block_column_1_choose_post',
						'default' => 0,
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'single-post'
						)),
			
				  array('title' => __('Show Category','ux'),
						'type' => 'switch',
						'name' => 'block_column_1_show_category',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'post-by-category|single-post'
						)),
			
				  array('title' => __('Show Date','ux'),
						'type' => 'switch',
						'name' => 'block_column_1_show_date',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'post-by-category|single-post'
						)),
			
				  array('title' => __('Show Author','ux'),
						'type' => 'switch',
						'name' => 'block_column_1_show_author',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'post-by-category|single-post'
						)),
			
				  array('title' => __('Choose a Slider','ux'),
						'type' => 'select',
						'name' => 'block_column_1_bm_slider',
						'default' => 0,
						'control' => array(
							'name' => 'block_column_1_type',
							'value' => 'bm-slider'
						)),
			
			//Block 2
			array('title' => __('Block 2','ux'),
				  'type' => 'none',
				  'name' => 'block_column_2_name'),
				  
				  //Block type
				  array('title' => __('Type','ux'),
						'type' => 'select',
						'name' => 'block_column_2_type',
						'default' => 'module'),
						
				  array('title' => __('Background Color','ux'),
						'description' => __('Optional, choose a background color for the wrap','ux'),
						'type' => 'bg-color',
						'name' => 'block_column_2_bg_color',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'module|text-button|post-by-category|single-post'
						)),
				  
				  array('title' => __('Background Image','ux'),
						'type' => 'upload',
						'name' => 'block_column_2_bg_image',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Shift Text Color for Dark Background','ux'),
						'type' => 'switch',
						'name' => 'block_column_2_dark_background',
						'default' => 'off',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'module|text-button|post-by-category|single-post|bm-slider'
						)),
			
				  /*array('title' => __('Rows in This Block','ux'),
						'type' => 'select',
						'name' => 'block_column_2_row_in',
						'default' => '1',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'module'
						)),*/
			
				  array('title' => __('Vertical Align','ux'),
						'type' => 'select',
						'name' => 'block_column_2_valign',
						'default' => 'top',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'module'
						)),

				  array('title' => __('Fill Container','ux'),
						'type' => 'switch',
						'name' => 'block_column_2_fill_wrap',
						'default' => 'off',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'module'
						)),
			
				  array('title' => __('Title','ux'),
						'type' => 'text',
						'name' => 'block_column_2_text_title',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Subtitle','ux'),
						'type' => 'text',
						'name' => 'block_column_2_text_subtitle',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Content','ux'),
						'type' => 'textarea',
						'name' => 'block_column_2_text_content',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Show Button','ux'),
						'type' => 'switch',
						'name' => 'block_column_2_show_button',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'text-button'
						)),
			
				  array('title' => __('Button Text','ux'),
						'type' => 'text',
						'name' => 'block_column_2_button_text',
						'control' => array(
							'name' => 'block_column_2_show_button',
							'value' => 'on'
						)),
			
				  array('title' => __('Link','ux'),
						'type' => 'text',
						'name' => 'block_column_2_text_link',
						'control' => array(
							'name' => 'block_column_2_show_button',
							'value' => 'on'
						)),
			
				  array('title' => __('Category','ux'),
						'type' => 'category-multiple',
						'name' => 'block_column_2_post_ategory',
						'default' => '0',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'post-by-category'
						)),
			
				  array('title' => __('Choose a Post','ux'),
						'type' => 'select',
						'name' => 'block_column_2_choose_post',
						'default' => 0,
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'single-post'
						)),
			
				  array('title' => __('Show Category','ux'),
						'type' => 'switch',
						'name' => 'block_column_2_show_category',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'post-by-category|single-post'
						)),
			
				  array('title' => __('Show Date','ux'),
						'type' => 'switch',
						'name' => 'block_column_2_show_date',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'post-by-category|single-post'
						)),
			
				  array('title' => __('Show Author','ux'),
						'type' => 'switch',
						'name' => 'block_column_2_show_author',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'post-by-category|single-post'
						)),
			
				  array('title' => __('Choose a Slider','ux'),
						'type' => 'select',
						'name' => 'block_column_2_bm_slider',
						'default' => 0,
						'control' => array(
							'name' => 'block_column_2_type',
							'value' => 'bm-slider'
						)),
				  
			//Block 3
			array('title' => __('Block 3','ux'),
				  'type' => 'none',
				  'name' => 'block_column_3_name',
				  'two-level' => 'block-3'),
				  
				  //Block type
				  array('title' => __('Type','ux'),
						'type' => 'select',
						'name' => 'block_column_3_type',
						'default' => 'module',
						'two-level' => 'block-3'),
						
				  array('title' => __('Background Color','ux'),
						'description' => __('Optional, choose a background color for the wrap','ux'),
						'type' => 'bg-color',
						'name' => 'block_column_3_bg_color',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'module|text-button|post-by-category|single-post'
						),
						'two-level' => 'block-3'),
				  
				  array('title' => __('Background Image','ux'),
						'type' => 'upload',
						'name' => 'block_column_3_bg_image',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'text-button'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Shift Text Color for Dark Background','ux'),
						'type' => 'switch',
						'name' => 'block_column_3_dark_background',
						'default' => 'off',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'module|text-button|post-by-category|single-post|bm-slider'
						),
						'two-level' => 'block-3'),
			
				 /*array('title' => __('Rows in This Block','ux'),
						'type' => 'select',
						'name' => 'block_column_3_row_in',
						'default' => '1',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'module'
						),
						'two-level' => 'block-3'),*/
			
				  array('title' => __('Vertical Align','ux'),
						'type' => 'select',
						'name' => 'block_column_3_valign',
						'default' => 'top',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'module'
						),
						'two-level' => 'block-3'),

				  array('title' => __('Fill Container','ux'),
						'type' => 'switch',
						'name' => 'block_column_3_fill_wrap',
						'default' => 'off',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'module'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Title','ux'),
						'type' => 'text',
						'name' => 'block_column_3_text_title',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'text-button'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Subtitle','ux'),
						'type' => 'text',
						'name' => 'block_column_3_text_subtitle',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'text-button'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Content','ux'),
						'type' => 'textarea',
						'name' => 'block_column_3_text_content',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'text-button'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Show Button','ux'),
						'type' => 'switch',
						'name' => 'block_column_3_show_button',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'text-button'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Button Text','ux'),
						'type' => 'text',
						'name' => 'block_column_3_button_text',
						'control' => array(
							'name' => 'block_column_3_show_button',
							'value' => 'on'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Link','ux'),
						'type' => 'text',
						'name' => 'block_column_3_text_link',
						'control' => array(
							'name' => 'block_column_3_show_button',
							'value' => 'on'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Category','ux'),
						'type' => 'category-multiple',
						'name' => 'block_column_3_post_ategory',
						'default' => '0',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'post-by-category'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Choose a Post','ux'),
						'type' => 'select',
						'name' => 'block_column_3_choose_post',
						'default' => 0,
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'single-post'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Show Category','ux'),
						'type' => 'switch',
						'name' => 'block_column_3_show_category',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'post-by-category|single-post'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Show Date','ux'),
						'type' => 'switch',
						'name' => 'block_column_3_show_date',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'post-by-category|single-post'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Show Author','ux'),
						'type' => 'switch',
						'name' => 'block_column_3_show_author',
						'default' => 'on',
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'post-by-category|single-post'
						),
						'two-level' => 'block-3'),
			
				  array('title' => __('Choose a Slider','ux'),
						'type' => 'select',
						'name' => 'block_column_3_bm_slider',
						'default' => 0,
						'control' => array(
							'name' => 'block_column_3_type',
							'value' => 'bm-slider'
						),
						'two-level' => 'block-3'),
				  
			//divider
			array('type' => 'divider'),
			
			array('title' => __('Height','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_block_height',
				  'default' => '1-2-fullwidth'),

			array('title' => __('Advanced Settings','ux'),
				  'description' => __('magin and animations','ux'),
				  'type' => 'switch',
				  'name' => 'module_advanced_settings',
				  'default' => 'off',
				  'modal-body' => 'after')
		
		)
	);
	
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_fullwidth_block_fields');

?>