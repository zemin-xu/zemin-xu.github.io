<?php
//carousel template
function ux_pb_module_carousel($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'carousel';
	
	if($module_post){
		//carousel confing
		$posttype        = get_post_meta($module_post, 'module_carousel_posttype', true);
		$number          = get_post_meta($module_post, 'module_carousel_number', true);
		$ratio           = get_post_meta($module_post, 'module_carousel_ratio', true);
		$showfunction    = get_post_meta($module_post, 'module_carousel_showfunction', true);
		$align           = get_post_meta($module_post, 'module_carousel_align', true);
		$button_text     = get_post_meta($module_post, 'module_carousel_button_text', true);
		$navigation      = get_post_meta($module_post, 'module_carousel_navigation_hint', true);
		
		$category        = get_post_meta($module_post, 'module_carousel_category', true);
		$orderby         = get_post_meta($module_post, 'module_select_orderby', true);
		$order           = get_post_meta($module_post, 'module_select_order', true);

		
		$per_page        = $number ? $number : -1;
		$button_text     = $button_text ? $button_text : __('Read more','ux');
		
		$function = array();
		if($showfunction){
			if(is_array($showfunction)){
				$function = $showfunction;
			}else{
				array_push($function, $showfunction);
			}
		}
		
		$showtype = array();
		if($posttype){
			if(is_array($posttype)){
				$showtype = $posttype;
			}else{
				array_push($showtype, $posttype);
			}
		}
		
		$text_align = 'text-left';
		$pull_align = 'pull-left';
		if($align){
			switch($align){
				case 'center': $text_align = 'text-center'; $pull_align = false; break;
				case 'right': $text_align = 'text-right'; $pull_align = 'pull-right'; break;
			}
		}
		
		$image_ratio = 'image-thumb';
		switch($ratio){
			case '3:2':  $image_ratio = 'image-thumb'; break;
			case '1:1':  $image_ratio = 'image-thumb-1'; break;
			case '1:2':  $image_ratio = 'image-thumb-2'; break;
			case 'auto': $image_ratio = 'standard-thumb'; break;
		}
		
		$post_format = false;
		$post_operator = false;
		$thumbnail_compare = array(
			'relation' => 'AND',
			array(
				'key' => '_thumbnail_id',
				'compare' => 'EXISTS'
			)
		);
		if($showtype){
			$post_format = array();
			$post_format_date = array(
				'post-format-aside',
				'post-format-chat',
				'post-format-gallery',
				'post-format-link',
				'post-format-image',
				'post-format-quote',
				'post-format-status',
				'post-format-video',
				'post-format-audio'
			);
			foreach($showtype as $post_type){
				switch($post_type){
					case 'image': array_push($post_format, 'post-format-image'); break;
					case 'portfolio': array_push($post_format, 'post-format-gallery'); break;
					case 'audio': array_push($post_format, 'post-format-audio'); break;
					case 'video': array_push($post_format, 'post-format-video'); break;
				}
			}
			if(in_array("standard", $showtype)){
				$post_operator = 'NOT IN';
				foreach($post_format as $delete_format){
					foreach($post_format_date as $key => $format_string){
						if($delete_format == $format_string) unset($post_format_date[$key]);
					}
				}
				$post_format = $post_format_date;
			}else{
				$post_operator = 'IN';
			}
		}
		
		$get_posts = get_posts(array(
			'posts_per_page' => $per_page,
			'orderby'        => $orderby,
			'order'          => $order,
			'cat'            => $category,
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => $post_format,
					'operator' => $post_operator
				)
			),
			'meta_query' => $thumbnail_compare
		));
		
		if($get_posts){
			global $post; ?>
            <div class="post-carousel-wrap caroufredsel_wrapper ux-mod-nobg" data-column="4">
                <div class="post-carousel">
                    <?php foreach($get_posts as $post){ setup_postdata( $post ); ?>
                        <section class="post-carousel-item">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-carousel-img-a"><?php the_post_thumbnail($image_ratio, array('title' => get_the_title(get_post_thumbnail_id()),'class' => 'post-carousel-img')); ?></a>
                            <?php if(count($function)){
                                if(in_array("title", $function)){ ?><h1 class="<?php echo sanitize_html_class($text_align); ?> ux-grid-tit"><a class="ux-grid-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1><?php }
                                if(in_array("excerpt", $function)){ ?><div class="post-carousel-item-des ux-grid-excerpt <?php echo sanitize_html_class($text_align); ?>"><?php if(has_excerpt()) the_excerpt(); ?></div><?php }
                                if(in_array("read_more_button", $function)){ ?><a href="<?php the_permalink(); ?>" class="post-carousel-item-more <?php echo sanitize_html_class($pull_align); ?>" title="<?php the_title(); ?>"><?php echo esc_html($button_text); ?></a>
                                <?php 
                                }
                            } ?>
                        </section>
                    <?php }
                    wp_reset_postdata(); ?>
                </div>
                <?php if($navigation == 'on'){ ?><div class="post-carousel-pagination"></div><?php } ?>
            </div>
        <?php
		}
	}
}
add_action('ux-pb-module-template-carousel', 'ux_pb_module_carousel');

//carousel select fields
function ux_pb_module_carousel_select($fields){
	$fields['module_carousel_posttype'] = array(
		array('title' => __('Standard','ux'), 'value' => 'standard'),
		array('title' => __('Image','ux'), 'value' => 'image'),
		array('title' => __('Portfolio','ux'), 'value' => 'portfolio'),
		array('title' => __('Video','ux'), 'value' => 'video'),
		array('title' => __('Audio','ux'), 'value' => 'audio')
	);
	
	$fields['module_carousel_showfunction'] = array(
		array('title' => __('Title','ux'), 'value' => 'title'),
		array('title' => __('Excerpt','ux'), 'value' => 'excerpt'),
		array('title' => __('Read More Button','ux'), 'value' => 'read_more_button')
	);
	
	$fields['module_carousel_showfunction'] = array(
		array('title' => __('Title','ux'), 'value' => 'title'),
		array('title' => __('Excerpt','ux'), 'value' => 'excerpt'),
		array('title' => __('Read More Button','ux'), 'value' => 'read_more_button')
	);
	
	$fields['module_carousel_ratio'] = array(
		array('title' => '3:2', 'value' => '3:2'),
		array('title' => '1:1', 'value' => '1:1'),
		array('title' => '1:2', 'value' => '1:2'),
		array('title' => __('Auto','ux'), 'value' => 'auto')
	);
	
	$fields['module_carousel_align'] = array(
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Center','ux'), 'value' => 'center'),
		array('title' => __('Right','ux'), 'value' => 'right')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_carousel_select');

//carousel config fields
function ux_pb_module_carousel_fields($module_fields){
	$module_fields['carousel'] = array(
		'id' => 'carousel',
		'animation' => true,
		'title' => __('Carousel','ux'),
		'item' =>  array(
			array('title' => __('Post Type','ux'),
				  'description' => __('Check on the post types you want to show on this module','ux'),
				  'type' => 'checkbox-group',
				  'name' => 'module_carousel_posttype'),
				  
			array('title' => __('Category','ux'),
				  'description' =>__('The posts under the category you selected would be shown in this module','ux'),
				  'type' => 'category',
				  'name' => 'module_carousel_category',
				  'taxonomy' => 'category',
				  'default' => '0'),
				  
			array('title' => __('Number of Items','ux'),
				  'description' => __('How many items should be displayed in this module, leave it empty to show all items','ux'),
				  'type' => 'text',
				  'name' => 'module_carousel_number'),
				  
			array('title' => __('Ratio of Thumb','ux'),
				  'description' => __('The images come from featured image, choose a ratio to show in this module','ux'),
				  'type' => 'select',
				  'name' => 'module_carousel_ratio',
				  'default' => '3:2'),
				  
			array('title' => __('Order by','ux'),
				  'description' => __('Select sequence rules for the list','ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date'),
				  
			array('title' => __('Show','ux'),
				  'description' => __('Check on the elements you want to show','ux'),
				  'type' => 'checkbox-group',
				  'name' => 'module_carousel_showfunction'),
				  
			array('title' => __('Text Align','ux'),
				  'description' => __('Select alignment for the text','ux'),
				  'type' => 'select',
				  'name' => 'module_carousel_align',
				  'default' => 'left'),
				  
			array('title' => __('Button Text','ux'),
				  'description' => __('It is a read more button, enter the text you want to show on button','ux'),
				  'type' => 'text',
				  'name' => 'module_carousel_button_text'),
				  
			array('title' => __('Show Navigation Hint','ux'),
				  'description' => __('Turn on it to show navigation hint','ux'),
				  'type' => 'switch',
				  'name' => 'module_carousel_navigation_hint',
				  'default' => 'off'),
				  
				  
			array('title' => __('Bottom Margin','ux'),
				  'description' => __('the spacing outside the bottom of module','ux'),
				  'type' => 'select',
				  'name' => 'module_bottom_margin',
				  'default' => 'bottom-space-40'
				  // 'control' => array(
					 //  'name' => 'module_advanced_settings',
					 //  'value' => 'on'
				  // )
				  )
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_carousel_fields');
?>