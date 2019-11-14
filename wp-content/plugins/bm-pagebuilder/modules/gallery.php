<?php
//gallery template
function ux_pb_module_gallery($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		//gallery confing
		$source         = get_post_meta($module_post, 'module_gallery_source', true);
		$category       = get_post_meta($module_post, 'module_gallery_category', true);
		$sortable       = get_post_meta($module_post, 'module_gallery_sortable', true);
		$spacing        = get_post_meta($module_post, 'module_gallery_image_spacing', true);
		$size           = get_post_meta($module_post, 'module_gallery_image_size', true);
		$pagination     = get_post_meta($module_post, 'module_gallery_pagination', true);
		$library        = get_post_meta($module_post, 'module_gallery_library', true);
		$per_page       = get_post_meta($module_post, 'module_gallery_per_page', true);
		
		$per_page       = $per_page ? $per_page : -1;
		$get_categories = get_categories('parent=' .esc_attr($category));
		
		$isotope_style  = 'margin: -' .esc_attr($spacing). ' 0 0 -' .esc_attr($spacing);
		$inside_style   = 'margin: ' .esc_attr($spacing). ' 0 0 ' .esc_attr($spacing);
		
		switch($sortable){
			case 'top': 
				$filter_class = false;
				$isotope_class = 'clear';
				$isotope_margin = false;
			break;
			
			case 'left': 
				$filter_class = 'span3 onside';
				$isotope_class = 'span9';
				$isotope_margin = false;
			break;
			
			case 'right': 
				$filter_class = 'span3 onside onright pull-right';
				$isotope_class = 'span9';
				$isotope_margin = 'margin-left:0;';
			break;
			
			default:
				$filter_class = false;
				$isotope_class = 'clear';
				$isotope_margin = false;
			break;
		}
		
		?>
        <!--gallery isotope-->
        
            <?php switch($source){
				case 'image_post':
					$gallery_querys = get_posts(array(
						'posts_per_page' => -1,
						'cat' => $category,
						'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array('post-format-image'),
								'operator' => 'IN'
							)
						)
					));
					$count = count($gallery_querys);
					
					if($sortable && $sortable != 'no'){ ?>
                        <!--Filter-->
                        <ul class="clearfix filters <?php echo esc_attr($filter_class); ?>">
                            <li class="active"><a href="#" data-filter="*"><?php esc_attr_e('All','ux'); ?></a></li>	
                            <?php foreach($get_categories as $cate){ ?>		
                                <li><a data-filter=".filter_<?php echo esc_attr($cate->slug); ?>" href="#"><?php echo esc_html($cate->name); ?></a></li>
                            <?php } ?> 
                        </ul><!--End filter-->
                    <?php } ?>
                    
                    <div class="container-isotope <?php echo sanitize_html_class($isotope_class); ?>" style=" <?php echo esc_attr($isotope_margin); ?>" data-post="<?php echo esc_attr($itemid); ?>">
                        <div id="isotope-load" class="isotope-load"></div>
                        <div class="isotope masonry lightbox-photoswipe <?php if($spacing =='0px'){ echo 'less-space'; } ?>" data-space="<?php echo esc_attr($spacing); ?>" style=" <?php echo esc_attr($isotope_style); ?>" data-size="<?php echo esc_attr($size); ?>">
                            <?php ux_pb_module_load_gallery($itemid, 1); ?>
                        </div>
                    </div> <!--End container-isotope-->
				<?php
                break;
				
				case 'library':
					$count = count($library); ?>
                    <div class="container-isotope" data-post="<?php echo esc_attr($itemid); ?>">
                        <div id="isotope-load" class="isotope-load"></div>
                        <div class="isotope masonry lightbox-photoswipe" data-space="<?php echo esc_attr($spacing); ?>" style=" <?php echo esc_attr($isotope_style); ?>" data-size="<?php echo esc_attr($size); ?>">
                            <?php ux_pb_module_load_gallery($itemid, 1); ?>
                        </div>
                    </div> <!--End container-isotope-->
                <?php
				break;
			} ?>
        
		<?php
        if($count > 2){
			ux_view_module_pagenums($itemid, 'gallery', $per_page, $count, $pagination);
		}	
	}
}
add_action('ux-pb-module-template-gallery', 'ux_pb_module_gallery');

//gallery load template
function ux_pb_module_load_gallery($itemid, $paged){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'gallery';
	
	if($module_post){
		global $post;
		
		//gallery confing
		$source            = get_post_meta($module_post, 'module_gallery_source', true);
		$double_size       = get_post_meta($module_post, 'module_gallery_double_size', true);
		$category          = get_post_meta($module_post, 'module_gallery_category', true);
		$sortable          = get_post_meta($module_post, 'module_gallery_sortable', true);
		$spacing           = get_post_meta($module_post, 'module_gallery_image_spacing', true);
		$size              = get_post_meta($module_post, 'module_gallery_image_size', true);
		$ratio             = get_post_meta($module_post, 'module_gallery_image_ratio', true);
		$pagination        = get_post_meta($module_post, 'module_gallery_pagination', true);
		$library           = get_post_meta($module_post, 'module_gallery_library', true);
		$per_page          = get_post_meta($module_post, 'module_gallery_per_page', true);
		$hover_effect      = get_post_meta($module_post, 'module_gallery_mouseover_effect', true);
		$orderby           = get_post_meta($module_post, 'module_select_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		$per_page          = $per_page ? $per_page : -1;
		$get_categories    = get_categories('parent=' .esc_attr($category));
		$isotope_style     = 'margin: -' .esc_attr($spacing). ' 0 0 -' .esc_attr($spacing);
		$inside_style      = 'margin: ' .esc_attr($spacing). ' 0 0 ' .esc_attr($spacing);
		
		$thumb_src_preview_size = 'standard-thumb';
		switch($ratio){
			case '3:2':  $thumb_src_preview_size = 'image-thumb'; break;
			case '1:1':  $thumb_src_preview_size = 'image-thumb-1'; break;
			case '1:2':  $thumb_src_preview_size = 'image-thumb-2'; break;
			case 'auto': $thumb_src_preview_size = 'standard-thumb'; break;
		}
		
		$get_categories = get_categories('parent=' .esc_attr($category));
		$gallery_query = get_posts(array(
			'posts_per_page' => $per_page,
			'paged' => $paged,
			'cat' => $category,
			'orderby' => $orderby,
			'order' => $order,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array('post-format-image'),
					'operator' => 'IN'
				)
			)
		));
		
		switch($source){
			case 'image_post':
				foreach($gallery_query as $num => $post){ setup_postdata($post);
					$width_item = $num == 0 && $paged == 1 ? $double_size == 'on' ? 'width4' : 'width2' : 'width2';
					$gallery_categories = get_the_category(get_the_ID());
					$separator = ' ';
					$output = '';
					if($gallery_categories){
						foreach($gallery_categories as $category){
							$output .= 'filter_' . $category->slug . $separator;
						}
					}
					
					$thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
					$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $thumb_src_preview_size);
					$ux_image_link = ux_get_post_meta(get_the_ID(), 'theme_meta_image_link');
					$data_size = $thumb_src_full[1]. 'x' .$thumb_src_full[2]; ?>
                    <div class="<?php echo esc_attr(trim($output, $separator)); ?> <?php echo esc_attr($width_item); ?> isotope-item">
                        <div class="inside <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>" style=" <?php echo esc_attr($inside_style); ?>">
                            <div class="fade_wrap" data-lightbox="true">
                                <a href="<?php echo esc_url($ux_image_link); ?>" class="lightbox-item" data-size="<?php echo $data_size; ?>">
									<?php if($hover_effect == 'on'){ ?>
                                        <div class="fade_wrap_back">
                                            <div class="fade_wrap_back_bg">
                                                <i class="icon-m-link"></i>
                                            </div>
                                        </div>
                                    
                                    <?php } ?>
                                    <img src="<?php echo esc_url($thumb_src_preview[0]); ?>" width="<?php echo esc_attr($thumb_src_preview[1]); ?>" height="<?php echo esc_attr($thumb_src_preview[2]); ?>" class="isotope-list-thumb">
								</a>
                            </div><!--End fade_wrap-->
                        </div><!--End inside-->
                    </div>
                    <!--End isotope-item-->
				<?php
				}
				wp_reset_postdata();
			break;
				
			case 'library':
				if($library){
					$library       = is_array($library) ? $library : array($library); 
					$library_count = count($library);
					$per_page      = $per_page == -1 ? $library_count : $per_page;
					
					if($per_page){
						$library_page  = ceil($library_count / $per_page);
						
						$i = (intval($paged) - 1) * $per_page;
						for($i; $i<intval($paged) * $per_page; $i++){
							if(isset($library[$i])){
								$image = $library[$i];
								$thumb_src_preview = wp_get_attachment_image_src($image, $thumb_src_preview_size);
								$thumb_src_full = wp_get_attachment_image_src($image, 'full');
								$data_size = $thumb_src_full[1]. 'x' .$thumb_src_full[2]; 
								$width_item = $i == (intval($paged) - 1) * $per_page  && $paged == 1 ? $double_size == 'on' ? 'width4' : 'width2' : 'width2'; ?>
								
								<?php if($i < $library_count){ ?>
                                    <div class="<?php echo esc_attr($width_item); ?> isotope-item">
                                        <div class="inside <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>" style=" <?php echo esc_attr($inside_style); ?>">
                                            <div class="fade_wrap" data-lightbox="true">
                                                <a href="<?php echo esc_url($thumb_src_full[0]); ?>" class="lightbox-item" data-rel="post-<?php echo esc_attr($module_post); ?>" data-size="<?php echo $data_size; ?>">
                                                    <?php if($hover_effect == 'on'){ ?>
                                                        <div class="fade_wrap_back">
                                                            <div class="fade_wrap_back_bg">
                                                                <i class="icon-m-view"></i>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <img src="<?php echo esc_url($thumb_src_preview[0]); ?>" width="<?php echo esc_attr($thumb_src_preview[1]); ?>" height="<?php echo esc_attr($thumb_src_preview[2]); ?>" class="isotope-list-thumb">
                                                </a>
                                            </div><!--End fade_wrap-->
                                        </div><!--End inside-->
                                    </div><!--End isotope-item-->
								<?php
								}
							}
						}
					}
				}
			break;
		}
	}
}

//gallery select fields
function ux_pb_module_gallery_select($fields){
	$fields['module_gallery_source'] = array(
		array('title' => __('Library','ux'), 'value' => 'library')
		//array('title' => __('Image Post','ux'), 'value' => 'image_post')
	);
	
	$fields['module_gallery_image_spacing'] = array(
		array('title' => __('0px','ux'), 'value' => '0px'),
		array('title' => __('1px','ux'), 'value' => '1px'),
		array('title' => __('2px','ux'), 'value' => '2px'),
		array('title' => __('5px','ux'), 'value' => '5px'),
		array('title' => __('10px','ux'), 'value' => '10px'),
		array('title' => __('20px','ux'), 'value' => '20px')
	);
	
	$fields['module_gallery_image_size'] = array(
		array('title' => __('Medium','ux'), 'value' => 'medium'),
		array('title' => __('Large','ux'), 'value' => 'large'),
		array('title' => __('Small','ux'), 'value' => 'small'),
		array('title' => __('Tiny','ux'), 'value' => 'tiny'),
	);
	
	$fields['module_gallery_image_ratio'] = array(
		array('title' => '3:2', 'value' => '3:2'),
		array('title' => '1:1', 'value' => '1:1'),
		array('title' => '1:2', 'value' => '1:2'),
		array('title' => __('Auto','ux'), 'value' => 'auto')
	);
	
	$fields['module_gallery_sortable'] = array(
		array('title' => __('No','ux'), 'value' => 'no'),
		array('title' => __('Top','ux'), 'value' => 'top'),
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Right','ux'), 'value' => 'right')
	);
	
	$fields['module_gallery_pagination'] = array(
		array('title' => __('No','ux'), 'value' => 'no'),
		array('title' => __('Page Number','ux'), 'value' => 'page_number'),
		array('title' => __('Twitter','ux'), 'value' => 'twitter')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_gallery_select');

//gallery config fields
function ux_pb_module_gallery_fields($module_fields){
	$module_fields['gallery'] = array(
		'id' => 'gallery',
		'animation' => true,
		'title' => __('Gallery','ux'),
		'item' =>  array(
			array('title' => __('Image Source','ux'),
				  'description' => __('Select where the images come from','ux'),
				  'type' => 'select',
				  'name' => 'module_gallery_source',
				  'default' => 'library'),
				  
			array('title' => __('Category','ux'),
				  'description' => __('The featured images of the Image Posts under the category you selected would be shown in this module','ux'),
				  'type' => 'category',
				  'name' => 'module_gallery_category',
				  'default' => '0',
				  'control' => array(
					  'name' => 'module_gallery_source',
					  'value' => 'image_post'
				  )),
				  
			array('title' => __('Spacing Between Images','ux'),
				  'description' => __('Choose the spacing between images','ux'),
				  'type' => 'select',
				  'name' => 'module_gallery_image_spacing',
				  'default' => '0'),
				  
			array('title' => __('Order by','ux'),
				  'description' => __('Select sequence rules for the list','ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date',
				  'control' => array(
					  'name' => 'module_gallery_source',
					  'value' => 'image_post'
				  )),
				  
			array('title' => __('Image Size','ux'),
				  'description' => __('Choose a size for the images','ux'),
				  'type' => 'select',
				  'name' => 'module_gallery_image_size',
				  'default' => 'medium'),
				  
			array('title' => __('Image Ratio','ux'),
				  'description' => __('From portfilio post featured image, recommended size: larger than 600px * 600px','ux'),
				  'type' => 'select',
				  'name' => 'module_gallery_image_ratio',
				  'default' => '3:2'),
				  
			array('title' => __('Sortable','ux'),
				  'description' => __('Choose whether you want the list to be sortable or not','ux'),
				  'type' => 'select',
				  'name' => 'module_gallery_sortable',
				  'default' => 'no',
				  'control' => array(
					  'name' => 'module_gallery_source',
					  'value' => 'image_post'
				  )),
				  
			array('title' => __('Double Size First Item','ux'),
				  'description' => __('Enlarge the first image in the list','ux'),
				  'type' => 'switch',
				  'name' => 'module_gallery_double_size',
				  'default' => 'on'),
				  
			array('title' => __('Hover Effect','ux'),
				  'description' => __('Enable the mouseover effect','ux'),
				  'type' => 'switch',
				  'name' => 'module_gallery_mouseover_effect',
				  'default' => 'on'),
				  
			array('title' => __('Post Number per Page','ux'),
				  'description' => __('How many items should be displayed per page, leave it empty to show all items in one page','ux'),
				  'type' => 'text',
				  'name' => 'module_gallery_per_page'),
				  
			array('title' => __('Pagination','ux'),
				  'description' => __('The "Twitter" option is to show a "Load More" button on the bottom of the list','ux'),
				  'type' => 'select',
				  'name' => 'module_gallery_pagination',
				  'default' => 'no'),
				  
			array('title' => __('Choose Image from Library','ux'),
				  'type' => 'gallery',
				  'name' => 'module_gallery_library',
				  'control' => array(
					  'name' => 'module_gallery_source',
					  'value' => 'library'
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
add_filter('ux_pb_module_fields', 'ux_pb_module_gallery_fields');
?>