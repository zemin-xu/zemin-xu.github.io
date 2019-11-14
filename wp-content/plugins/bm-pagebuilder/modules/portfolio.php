<?php
//portfolio template
function ux_pb_module_portfolio($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		//portfolio confing
		$type           = get_post_meta($module_post, 'module_portfolio_type', true);
		$sortable       = get_post_meta($module_post, 'module_portfolio_sortable', true);
		$per_page       = get_post_meta($module_post, 'module_portfolio_per_page', true);
		$category       = get_post_meta($module_post, 'module_portfolio_category', true);
		$pagination     = get_post_meta($module_post, 'module_portfolio_pagination', true);
		$ratio          = get_post_meta($module_post, 'module_portfolio_image_ratio', true);
		$per_page       = esc_attr($per_page);
		$count          = 0;
		
		if(!is_array($category)){
			$category = array($category);
		}
		
		switch($type){
			default:

				$spacing        = get_post_meta($module_post, 'module_portfolio_image_spacing', true);
				$size           = get_post_meta($module_post, 'module_portfolio_image_size', true);
				$size           = $type == 'brick' ? 'brick' : $size;
				$fitrow         = $ratio == 'auto' ? ' masonry' : ' grid_list'; 
				
				if(is_array($category)){
					$get_categories = get_categories(array(
						'include' => $category
					));
				}else{
					$get_categories = get_categories('parent=' . $category);
				}
				
				$per_page       = $per_page ? $per_page : -1;
				
				$isotope_style  = 'margin: -' . $spacing . ' 0 0 -' . $spacing;
				$inside_style   = 'margin: ' . $spacing . ' 0 0 ' . $spacing;
				
				if($type == 'brick'){
					$sortable = get_post_meta($module_post, 'module_portfolio_brick_sortable', true);
					$sortable_fixed = get_post_meta($module_post, 'module_portfolio_brick_filter_fixed', true);
					$sortable_fixed = $sortable_fixed == 'on' ? ' filter-floating-fixed' : false;
				}
				
				switch($sortable){
					case 'top': 
						$filter_class = 'center-ux filters-nobg';
						$isotope_class = 'clear';
						$isotope_margin = false;
					break;
					
					case 'left': 
						$filter_class = 'span3 onside filters-nobg';
						$isotope_class = 'span9';
						$isotope_margin = false;
					break;
					
					case 'right': 
						$filter_class = 'span3 onside onright pull-right filters-nobg';
						$isotope_class = 'span9';
						$isotope_margin = 'margin-left:0;';
					break;

					case 'floating': 
						$filter_class = 'filter-floating'.$sortable_fixed;
						$isotope_class = '';
						$isotope_margin = '';
					break;
					
					default:
						$filter_class = false;
						$isotope_class = 'clear';
						$isotope_margin = false;
					break;
				}
				
				$filter_class   = $filter_class ? $filter_class : false;
				$isotope_class  = $isotope_class ? $isotope_class : false;
				$isotope_margin = $isotope_margin ? $isotope_margin : false;
				
				$portfolio_query = get_posts(array(
					'posts_per_page' => -1,
					'category__in' => $category,
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery'),
							'operator' => 'IN'
						)
					)
				));
				
				$count = count($portfolio_query); ?>
		        
		        <!--Portfolio isotope--> 
		        	
		            <?php if($sortable && $sortable != 'no'){
						
						if(is_array($category)){
							$category = $category[0];
						}
						
						$get_categories = get_categories('parent=' . $category);
						?>

		                <!--Filter-->
		                
			                <div class="clearfix filters <?php echo esc_attr($filter_class); ?>">
			                    <ul>
			                    	<li class="active"><a class="filters-a" href="#" data-filter="*"><?php _e('All', 'ux'); ?></a></li>	
			                    	<?php foreach($get_categories as $cate){ ?>		
			                        <li><a class="filters-a" data-filter=".filter_<?php echo esc_attr($cate->slug); ?>" href="#"><?php echo esc_html($cate->name); ?></a></li>
			                    	<?php } ?>
			                    </ul>
			                    <?php if($sortable == 'floating'){ ?>
		                		<div class="filter-floating-triggle hidden-phone"><i class="fa fa-filter"></i></div>
		               			<?php } ?>

			                </div><!--End filter-->

		            <?php } ?>

		            <div class="container-isotope <?php echo esc_attr($isotope_class); ?>" style=" <?php echo esc_attr($isotope_margin); ?>" data-post="<?php echo esc_attr($itemid); ?>">		             
		                <div class="isotope <?php echo esc_attr($fitrow); ?> <?php if($spacing =='0px'){ echo 'less-space'; } ?>" data-space="<?php echo esc_attr($spacing); ?>" style=" <?php echo esc_attr($isotope_style); ?>" data-size="<?php echo esc_attr($size); ?>">
							<?php ux_pb_module_load_portfolio($itemid, 1); ?>
		                </div>
		            </div> <!--End container-isotope--> 

		    <?php 
		    break;
			
			case 'interlock_list': 

				$portfolio_query = get_posts(array(
					'posts_per_page' => -1,
					'category__in' => $category,
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery'),
							'operator' => 'IN'
						)
					)
				));

				$count = count($portfolio_query);?>

				<!--Portfolio interlock list-->
		        <div class="interlock-list" data-post="<?php echo esc_attr($itemid); ?>" data-pageed="<?php echo $per_page; ?>">
					<?php ux_pb_module_load_portfolio($itemid, 1); ?>
		        </div><!--End interlock-list-->	

		<?php break; 
		
			//** new type
			case 'carousel_list': ux_pb_module_load_portfolio($itemid, 1); break;
			
			//custom grid
			case 'custom_grid':
			
				$blog_category = get_post_meta($module_post, 'module_blog_category', true);
				
				if(!is_array($blog_category)){
					$blog_category = array($blog_category);
				}
			
				$portfolio_query = get_posts(array(
					'posts_per_page' => -1,
					'category__in' => $blog_category,
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery'),
							'operator' => 'IN'
						)
					)
				));
				
				$count = count($portfolio_query);
				
				if($portfolio_query){ ?>
				
                    <div class="list-layout">
                    
						<?php ux_pb_module_load_portfolio($itemid, 1); ?>
    
                    </div>
                    
                <?php
				}
            break;
		
	}?>   

		<?php
		if($count > 2 && $type != 'brick' && $type != 'carousel_list'){
			ux_view_module_pagenums($itemid, 'portfolio', $per_page, $count, $pagination);
		}
	}
}
add_action('ux-pb-module-template-portfolio', 'ux_pb_module_portfolio');

//portfolio load template
function ux_pb_module_load_portfolio($itemid, $paged){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'portfolio';
	
	if($module_post){
		global $post;
		
		//portfolio confing
		$type              = get_post_meta($module_post, 'module_portfolio_type', true);
		$pagination        = get_post_meta($module_post, 'module_portfolio_pagination', true);
		$per_page          = get_post_meta($module_post, 'module_portfolio_per_page', true);
		$double_size       = get_post_meta($module_post, 'module_portfolio_double_size', true);
		$hover_effect      = false;
		$spacing           = get_post_meta($module_post, 'module_portfolio_image_spacing', true);
		$ratio             = get_post_meta($module_post, 'module_portfolio_image_ratio', true);
		$category          = get_post_meta($module_post, 'module_portfolio_category', true);
		$orderby           = get_post_meta($module_post, 'module_select_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$post_meta         = get_post_meta($module_post, 'module_portfolio_meta', true);
		$size              = get_post_meta($module_post, 'module_portfolio_image_size', true);
		$switch_hover      = get_post_meta($module_post, 'module_portfolio_switch_hover_effect', true);
		$gray              = get_post_meta($module_post, 'module_portfolio_brick_style', true);
		$hover_status      = get_post_meta($module_post, 'module_portfolio_carousel_hover_status', true);
		//$ajax_effect       = get_post_meta($module_post, 'module_portfolio_ajax_effect', true);
		$tags              = get_post_meta($module_post, 'module_portfolio_tags', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		$animation_end     = 'data-animationend="' . $animation_end . '"';
		$per_page          = esc_attr($per_page);
		$per_page          = $per_page ? $per_page : -1;
		$isotope_style     = 'margin: -' . $spacing.' 0 0 -' . $spacing . ';';
		$inside_style      = $hover_effect == 'flip' ? 'padding:' . $spacing . ' 0 0 ' . $spacing . ';' : 'margin:' . $spacing . ' 0 0 ' . $spacing . ';';
		$back_con_style    ='padding-left: ' . $spacing . ';';
		$back_bg_style     = 'left: ' . $spacing . '; top: -' . $spacing . ';';
		$back_tit_style    = 'margin-top: -' . $spacing . ';' ;
		$brick_hover       = $switch_hover == 'on' ? 'brick-hover' : false; 
		
		if(!is_array($category)){
			$category = array($category);
		}
		
		if($type == 'carousel_list'){
			$per_page = -1;
			$ratio = get_post_meta($module_post, 'module_portfolio_image_carousel_ratio', true);
		}
		
		$sticky = get_option('sticky_posts');
		
		$get_sticky = get_posts(array(
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'category__in'   => $category,
			'orderby'        => $orderby,
			'order'          => $order,
			'post__in'       => $sticky
		));
		
		$portfolio_query = get_posts(array(
			'posts_per_page' => $per_page,
			'paged' => $paged,
			'category__in' => $category,
			'orderby' => $orderby,
			'order' => $order,
			'post__not_in' => $sticky,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array(
						'post-format-gallery'
					),
					'operator' => 'IN'
				)
			)
		));
		
		$image_ratio = 'standard-thumb';
		switch($ratio){
			case '3:2':  $image_ratio = 'image-thumb'; break;
			case '1:1':  $image_ratio = $size == 'small' ? 'imagebox-thumb' : 'image-thumb-1'; break;
			case '1:2':  $image_ratio = 'image-thumb-2'; break;
			case '2:3':  $image_ratio = 'image-thumb-3'; break;
			case '4:3':  $image_ratio = 'image-thumb-4'; break;
			case '2:1':  $image_ratio = 'image-thumb-5'; break;
			case 'auto': $image_ratio = 'standard-thumb'; break;
		}
		
		$hover_show = array();
		if($hover_status){
			if(is_array($hover_status)){
				$hover_show = $hover_status;
			}else{
				array_push($hover_show, $hover_status);
			}
		}
		
		$enable_ajax = false;
		//if($ajax_effect == 'on'){
		//	$enable_ajax = 'ajax-permalink';
		//}
		
		if($sticky){
			$portfolio_query = array_merge_recursive($get_sticky, $portfolio_query);
		}
		
		switch($type){
			case 'standard_list':

		foreach($portfolio_query as $num => $post){ setup_postdata($post);
			$ux_portfolio      = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
			$thumbnail_url     = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
			$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $image_ratio);

			$width_item =  'width2';
			
			$hide_category = ux_get_option('theme_option_hide_category_on_post_page');
			if(!$hide_category){
				$hide_category = array();
			}
			
			$portfolio_categories = get_the_category(get_the_ID());
			$separator = ' ';
			$output = '';
			if($portfolio_categories){
				foreach($portfolio_categories as $category){
					if(!in_array($category->term_id, $hide_category)){
						$output .= 'filter_' . $category->slug . $separator;
					}
				}
			} ?>

			<div class="<?php echo esc_attr(trim($output, $separator)); ?> <?php echo esc_attr($width_item); ?> isotope-item standard-list-item container3d">
                    <div class="inside <?php echo esc_attr($animation_style); ?>" <?php echo balanceTags($animation_end); ?> style=" <?php echo esc_attr($inside_style); ?>">

                    	<a class="standard-list-item-img-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <img class="standard-list-item-img" src="<?php echo esc_url($thumb_src_preview[0]); ?>" width="<?php echo esc_attr($thumb_src_preview[1]); ?>" height="<?php echo esc_attr($thumb_src_preview[2]); ?>" alt="<?php the_title(); ?>">
                        </a>

                        <div class="portfolio-standatd-tit-wrap text-center">
                            <h2 class="portfolio-standatd-tit">
                            	<a class="portfolio-standatd-tit-a" href="<?php the_permalink(); ?>"><span class="portfolio-standatd-tit-a-inn"><?php the_title(); ?></span></a>
								<?php  
									if ( $tags == 'on') { ?>
								<span class="portfolio-standatd-tags"><?php the_tags('', '  '); ?></span>
								<?php } ?>
                            </h2>
                        </div>
                    
                    </div><!--End inside-->
                </div>
		<?php }	
		wp_reset_postdata();


			break;

			case 'masonry_list':

		foreach($portfolio_query as $num => $post){ setup_postdata($post);
			$bg_color          = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
			$bg_color          = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
			$ux_portfolio      = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
			$thumbnail_url     = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
			$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $image_ratio);
			$data_size         = $thumbnail_url[1]. 'x' .$thumbnail_url[2];
			
			$width_item = $num == 0 && $paged == 1 ? $double_size == 'on' ? 'width4' : 'width2' : 'width2';
			
			$hide_category = ux_get_option('theme_option_hide_category_on_post_page');
			if(!$hide_category){
				$hide_category = array();
			}
			
			$portfolio_categories = get_the_category(get_the_ID());
			$separator = ' ';
			$output = '';
			if($portfolio_categories){
				foreach($portfolio_categories as $category){
					if(!in_array($category->term_id, $hide_category)){
						$output .= 'filter_' . $category->slug . $separator;
					}
				}
			}
			?>
                <div class="<?php echo esc_attr(trim($output, $separator)); ?> <?php echo esc_attr($width_item); ?> isotope-item portfolio-grid-item">
                    <div class="inside <?php echo esc_attr($animation_style); ?>" <?php echo balanceTags($animation_end); ?> style=" <?php echo esc_attr($inside_style); ?>">
                        <div class="img_wrap">
							<?php if(has_post_thumbnail()) { ?>
                                <img class="captionhover-img" src="<?php echo esc_url($thumb_src_preview[0]); ?>" width="<?php echo esc_attr($thumb_src_preview[1]); ?>" height="<?php echo esc_attr($thumb_src_preview[2]); ?>">
                            <?php } ?>
                        </div>
                        <div class="portfolio-grid-item-text">
                        	<div class="portfolio-grid-item-text-inn">
	                        	<span class="grid-item-text-cate clearfix"><?php ux_theme_hide_category('  '); ?></span>
	                            <h2 class="grid-item-text-h2">
	                            	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="grid-item-text-h2-a"><?php the_title(); ?></a>
	                            </h2>
                            </div>
                        </div>
                    </div><!--End inside-->
                </div>
            <?php	
			
		}
		wp_reset_postdata();

		break;

		case 'interlock_list': 

			$learnmore = ux_get_option('theme_option_descriptions_portfolio_learnmore');
			$learnmore = $learnmore ? $learnmore : esc_attr__('LEARN MORE','ux');

			foreach($portfolio_query as $num => $post){ setup_postdata($post);
				$bg_color          = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
				$bg_color          = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
				$ux_portfolio      = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
				$thumbnail_url     = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
				$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'image-thumb');
				$data_size         = $thumbnail_url[1]. 'x' .$thumbnail_url[2];

		?>
			<?php if(has_post_thumbnail()) { ?>
				<section class="interlock-item <?php echo esc_attr($animation_style); ?> " <?php echo balanceTags($animation_end); ?>>
					<div class="lightbox-photoswipe">
						<div class="iterlock-item-img" data-lightbox="true">
							<a class="lightbox-item ux-hover-wrap" href="<?php echo esc_url($thumbnail_url[0]); ?>" style="background-image:url(<?php echo esc_url($thumb_src_preview[0]); ?>)" data-size="<?php echo $data_size; ?>">
	                        	<div class="blog-item-img-hover ux-hover-icon-wrap"></div>
	                            <img src="<?php echo $thumb_src_preview[0]; ?>" class="hidden" />
	                        </a>
	                    </div>
					</div>
					<div class="iterlock-caption">
						<h2 class="iterlock-caption-tit"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="iterlock-caption-tit-a"><?php the_title(); ?></a></h2>
						<?php if ($post_meta != 'off') { ?>
                            <ul class="blog_meta hidden-phone">
                                <li class="blog_meta_cate"><span class="blog_meta_cate_label"><?php esc_html_e('In ','ux'); ?></span><?php ux_theme_hide_category(' '); ?></li>
                            </ul><!--End .blog_meta-->
                        <?php } ?>
						<div class="iterblock-expt hidden-phone"><?php the_excerpt(); ?></div>
						<a href="<?php the_permalink(); ?>" class="iterblock-more ux-btn" title="<?php the_title(); ?>" ><?php echo balanceTags($learnmore); ?><span class="fa fa-play"></span></a>
					</div>
				</section>
			<?php } ?>
		<?php

			} //End foreach
			wp_reset_postdata();

		break;
		
		case 'brick':
		
			foreach($portfolio_query as $num => $post){ setup_postdata($post);
				$bg_color          = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
				$bg_color          = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
				
				$thumbnail_size    = ux_get_post_meta(get_the_ID(), 'theme_meta_thumbnail_size');
				$thumbnail_size    = $thumbnail_size ? $thumbnail_size : 'imagebox-thumb';
				
				$the_excerpt       = $post->post_excerpt ? get_the_excerpt() : false;
				
				switch($thumbnail_size){
					case 'imagebox-thumb': $width_item = 'width-and-small'; $thumbnail_size_final = 'imagebox-thumb'; break;
					case 'image-thumb-1': $width_item = 'width-and-big'; $thumbnail_size_final = 'image-thumb-1'; break;
					case 'standard-blog-thumb': $width_item = 'width-and-long'; $thumbnail_size_final = 'standard-blog-thumb'; break;
					case 'image-thumb-2': $width_item = 'width-and-height'; $thumbnail_size_final = 'image-thumb-2'; break;
				}
				
				$hide_category = ux_get_option('theme_option_hide_category_on_post_page');
				if(!$hide_category){
					$hide_category = array();
				}
				
				$portfolio_categories = get_the_category(get_the_ID());
				$separator = ' ';
				$output = '';
				if($portfolio_categories){
					foreach($portfolio_categories as $category){
						if(!in_array($category->term_id, $hide_category)){
							$output .= 'filter_' . $category->slug . $separator;
						}
					}
				} ?>
                
                <div class="<?php echo esc_attr(trim($output, $separator)); ?> <?php echo esc_attr($width_item); ?> isotope-item <?php if(has_post_thumbnail()){ echo ' brick-with-img'; } ?>">
                    
                    <div class="inside brick-inside <?php echo esc_attr($bg_color); ?> <?php echo esc_attr($animation_style); ?>" <?php echo balanceTags($animation_end); ?> style=" <?php echo esc_attr($inside_style); ?>">
                        
                        <?php if($gray=='grey') { ?>

						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="brick-link brick-link-gray <?php echo esc_attr($enable_ajax); ?>">
	                        <div class="brick-hover-mask <?php echo esc_attr($brick_hover); ?>">
		                        <h3 class="brick-title"><?php the_title(); ?></h3>
	                        </div>

	                        <div class="brick-content brick-grey">
	                            <?php if(has_post_thumbnail()){
									the_post_thumbnail($thumbnail_size_final,array('class' => 'grayscale'));
								} ?>
	                        	<div class="brick-conteng-bg"></div>

							</div>
						</a>

						<?php 
						}else{ 
						?>

						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="brick-link <?php echo esc_attr($enable_ajax); ?>">
							<div class="brick-hover-mask <?php echo esc_attr($brick_hover); ?>">
	                            <h3 class="brick-title"><?php the_title(); ?></h3>
	                        </div>

							<div class="brick-content"> 
	                            <?php if(has_post_thumbnail()){
									the_post_thumbnail($thumbnail_size_final);
								} ?>
							</div>
						</a>
						<?php } ?>

                    </div><!--End inside-->
                </div>
			
            <?php
            }
			wp_reset_postdata();
		
		break;
		
		case 'carousel_list': ?>
            <div class="post-carousel-wrap caroufredsel_wrapper portfolio-caroufredsel carousel-mod" data-column="4">
                <div class="post-carousel">
                
					<?php foreach($portfolio_query as $num => $post){ setup_postdata($post);
						$bg_color          = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
						$bg_color          = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
						$thumb_src_preview = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $image_ratio);
						
						if(is_array($category)){
							$category = join(",", $category);
						} ?>
                        
                        <section class="post-carousel-item <?php echo esc_attr($animation_style); ?>" <?php echo balanceTags($animation_end); ?> data-bgcolor="<?php echo esc_attr($bg_color); ?>" data-category="<?php echo esc_attr($category); ?>">
                            <a class="portfolio-caroufredsel-item-inn <?php echo esc_attr($enable_ajax); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php if($switch_hover == 'on'){ ?>
                                    <div class="portfolio-caroufredsel-hover"></div>
                                    <?php if(in_array("title", $hover_show)){ ?> <h1 class="portfolio-caroufredsel-h1 text-center middle-ux"><?php the_title(); ?></h1><?php } ?>
                                <?php } 

								if(has_post_thumbnail()){ ?>
									<div class="portfolio-caroufredsel-div"><img class="portfolio-caroufredsel-img" src="<?php echo esc_url($thumb_src_preview[0]); ?>" width="<?php echo esc_attr($thumb_src_preview[1]); ?>" height="<?php echo esc_attr($thumb_src_preview[2]); ?>" title="<?php echo esc_attr(get_the_title(get_post_thumbnail_id(get_the_ID()))); ?>" /></div>
								<?php } ?>
                            </a>
                        </section>
                    <?php }
					wp_reset_postdata(); ?>
                    
                </div>
                <div class="portfolio-caroufredsel-nav"><a class="prev" href="#"><i class="fa fa-angle-left"></i></a><a class="next" href="#"><i class="fa fa-angle-right"></i></a></div>
            </div>
        <?php
		break;
		
		case 'custom_grid':
		
			$blog_category = get_post_meta($module_post, 'module_blog_category', true);
			$layout_builder = get_post_meta($module_post, 'module_portfolio_layout_builder', true);
			//$auto_play = get_post_meta($module_post, 'module_portfolio_auto_play', true);
			
			$isotope_style = 'margin: -' . $spacing . ' 0 0 -' . $spacing;
			$inside_style = 'margin: ' . $spacing . ' 0 0 ' . $spacing;
			
			if(!is_array($blog_category)){
				$blog_category = array($blog_category);
			}
			
			$sticky = get_option('sticky_posts');
		
			$get_sticky = get_posts(array(
				'posts_per_page' => $per_page,
				'paged'          => $paged,
				'category__in'   => $blog_category,
				'post__in'       => $sticky
			));
			
			$portfolio_query = get_posts(array(
				'posts_per_page' => $per_page,
				'paged' => $paged,
				'category__in' => $blog_category,
				'post__not_in' => $sticky,
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array(
							'post-format-gallery'
						),
						'operator' => 'IN'
					)
				)
			));
			
			if($sticky){
				$portfolio_query = array_merge_recursive($get_sticky, $portfolio_query);
			}
			
			$index = -1;
			$portfolio_count = count($portfolio_query); 
			
			if(!is_array($layout_builder)){
				$layout_builder = array($layout_builder);
			}
			
			foreach($layout_builder as $num => $layout){
				if($index + 1 <= $portfolio_count){
					switch($layout){
                        case 'col1':
                            $i = 1; ?>
                            <div class="portfolio-list list-layout-col list-layout-col1 clearfix" style=" <?php echo esc_attr($isotope_style); ?>">
                                <?php for($ii=0; $ii<$i; $ii++){ $index++;
									if(isset($portfolio_query[$index])){
										ux_pb_module_portfolio_col_template($portfolio_query[$index]->ID, $layout, $inside_style);
									}
								} ?>
                            </div>
                        <?php
                        break;
                        
                        case 'col2':
                            $i = 2; ?>
                            <div class="portfolio-list list-layout-col list-layout-col2 clearfix" style=" <?php echo esc_attr($isotope_style); ?>">
                            
								<?php for($ii=0; $ii<$i; $ii++){ $index++;
									if(isset($portfolio_query[$index])){
										ux_pb_module_portfolio_col_template($portfolio_query[$index]->ID, $layout, $inside_style);
									}
								} ?>
                            </div>
                        <?php
                        break;
                        
                        case 'col3':
                            $i = 3; ?>
                            <div class="portfolio-list list-layout-col list-layout-col3-1 clearfix" style=" <?php echo esc_attr($isotope_style); ?>">
                            
								<?php for($ii=0; $ii<$i; $ii++){ $index++;
									if(isset($portfolio_query[$index])){
										ux_pb_module_portfolio_col_template($portfolio_query[$index]->ID, $layout, $inside_style);
									}
								} ?>
                            </div>
                            
                        <?php
                        break;
                    }
				}
			}
			
			/*foreach($portfolio_query as $num => $post){
                if($num > $index){ ?>
                    <div class="list-layout-col list-layout-col1 clearfix" style=" <?php echo esc_attr($isotope_style); ?>">
                        <?php ux_pb_module_portfolio_col_template($portfolio_query[$num]->ID, 'col1', $inside_style); ?>
                    </div>
				<?php
				}
			}  */  
			
		break;

	} //End swith type
	}
}

//portfolio ajaxwrap
function ux_pb_module_portfolio_ajaxwrap(){
	global $ux_pagebuilder; 
	if($ux_pagebuilder->has_module('portfolio')){ ?>
    
        <!--Ajax portfolio post load wrap-->
        <div class="portfolio-ajaxwrap">
    
            <!--Close button wrap-->
            <i class="icon-m-close-thin portfolio-ajaxwrap-close hidden"></i>
    
            <!--Ajax loading wrap-->
            <div class="portfolio-ajaxwrap-loading hidden">
                <div class="ux-loading"></div>
                <div class="ux-loading-transform"><div class="spinner"></div></div>
            </div>
            
            <!--Ajax portfolio post content wrap-->
            <div class="container portfolio-ajaxwrap-inn"></div>
		
        </div><!--End portfolio-ajaxwrap-->
    <?php	
	}
}
//add_action('ux_interface_footer', 'ux_pb_module_portfolio_ajaxwrap', 30);

//portfolio ajaxtitle
function ux_interface_single_portfolio_ajaxtitle(){
	if(isset($_REQUEST['mode'])){
		if($_REQUEST['mode'] == 'ajax-portfolio'){ ?>
            <div class="title-bar title-bar-ajax">

                <div class="title-bar-ajax-inn middle-ux">
                    <h1 class="main-title"><?php the_title(); ?></h1>
                    <div class="post-expert"><?php the_excerpt(); ?></div>      
                </div>    

            </div>
		<?php
		}
	}
}
add_action('ux_interface_single_content_portfolio_before', 'ux_interface_single_portfolio_ajaxtitle', 10);

//portfolio select fields
function ux_pb_module_portfolio_select($fields){

	$fields['module_portfolio_type'] = array(
		//array('title' => __('Standard List', 'ux'), 'value' => 'standard_list'),
		//array('title' => __('Grid List', 'ux'), 'value' => 'masonry_list'),
		//array('title' => __('Custom Grid', 'ux'), 'value' => 'custom_grid'),
		array('title' => __('Interlock List', 'ux'), 'value' => 'interlock_list')
		//array('title' => __('Carousel List', 'ux'), 'value' => 'carousel_list')
	);
	
	$fields['module_portfolio_image_spacing'] = array(
		array('title' => __('0px', 'ux'), 'value' => '0px'),
		array('title' => __('1px', 'ux'), 'value' => '1px'),
		array('title' => __('2px', 'ux'), 'value' => '2px'),
		array('title' => __('5px', 'ux'), 'value' => '5px'),
		array('title' => __('10px', 'ux'), 'value' => '10px'),
		array('title' => __('20px', 'ux'), 'value' => '20px'),
		array('title' => __('30px', 'ux'), 'value' => '30px'),
		array('title' => __('40px', 'ux'), 'value' => '40px'),
		array('title' => __('60px', 'ux'), 'value' => '60px'),
		array('title' => __('80px', 'ux'), 'value' => '80px')
	);
	
	$fields['module_portfolio_image_size'] = array(
		array('title' => __('4 Columns', 'ux'), 'value' => 'small'),
		array('title' => __('3 Columns', 'ux'), 'value' => 'medium'),
		array('title' => __('2 Columns', 'ux'), 'value' => 'large'), 
		array('title' => __('1 Column', 'ux'), 'value' => 'fullwidth')
	);
	
	$fields['module_portfolio_image_ratio'] = array(
		array('title' => '4:3', 'value' => '4:3'),
		array('title' => '3:2', 'value' => '3:2'),
		array('title' => '2:1', 'value' => '2:1'),
		array('title' => '1:1', 'value' => '1:1'),
		array('title' => '1:2', 'value' => '1:2'),
		array('title' => __('Auto', 'ux'), 'value' => 'auto')
	);
	
	$fields['module_portfolio_image_carousel_ratio'] = array(
		array('title' => '3:2', 'value' => '3:2'),
		array('title' => '1:1', 'value' => '1:1'),
		array('title' => '1:2', 'value' => '1:2'),
		array('title' => '2:3', 'value' => '2:3')
	);
	
	$fields['module_portfolio_sortable'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Center', 'ux'), 'value' => 'top'),
		array('title' => __('Left', 'ux'), 'value' => 'left'),
		array('title' => __('Right', 'ux'), 'value' => 'right')
	);
	
	$fields['module_portfolio_brick_sortable'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Top', 'ux'), 'value' => 'top'),
		array('title' => __('Left', 'ux'), 'value' => 'left'),
		array('title' => __('Right', 'ux'), 'value' => 'right'),
		array('title' => __('Floating', 'ux'), 'value' => 'floating')
	);
	
	$fields['module_portfolio_brick_style'] = array(
		array('title' => __('Standard', 'ux'), 'value' => 'standard'),
		array('title' => __('Grey', 'ux'), 'value' => 'grey')
	);
	
	$fields['module_portfolio_pagination'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Page Number', 'ux'), 'value' => 'page_number'),
		array('title' => __('Load More', 'ux'), 'value' => 'twitter')
	);
	
	$fields['module_portfolio_carousel_hover_status'] = array(
		array('title' => __('Title', 'ux'), 'value' => 'title')
		//array('title' => __('Tag', 'ux'), 'value' => 'tag')
	);
	
	$fields['module_portfolio_layout_builder'] = array(
		array('title' => __('col1', 'ux'), 'value' => 'col1'),
		array('title' => __('col2', 'ux'), 'value' => 'col2'),
		array('title' => __('col3', 'ux'), 'value' => 'col3')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_portfolio_select');

//portfolio config fields
function ux_pb_module_portfolio_fields($module_fields){
	$module_fields['portfolio'] = array(
		'id' => 'portfolio',
		'animation' => true,
		'title' => __('Portfolio', 'ux'),
		'item' =>  array(
			array('title' => __('List Type', 'ux'),
				  'description' => '',
				  'type' => 'select',
				  'name' => 'module_portfolio_type',
				  'default' => 'masonry_list'),

			array('title' => __('Spacing Between Images', 'ux'),
				  'description' => __('Choose the spacing between images', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_image_spacing',
				  'default' => '0px',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'custom_grid|masonry_list|brick|standard_list'
				  )),
				  
			array('title' => __('Column', 'ux'),
				  'description' => '',
				  'type' => 'select',
				  'name' => 'module_portfolio_image_size',
				  'default' => 'medium',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|standard_list'
				  )),
				  
			array('title' => __('Image Ratio', 'ux'),
				  'description' => __('From portfilio post featured image, recommended size: larger than 800px * 800px', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_image_ratio',
				  'default' => '3:2',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|standard_list'
				  )),
				  
			array('title' => __('Image Ratio', 'ux'),
				  'description' => __('From portfilio post featured image, recommended size: larger than 800px * 800px', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_image_carousel_ratio',
				  'default' => '3:2',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'carousel_list'
				  )),
				  
			array('title' => __('Sortable', 'ux'),
				  'description' => __('Choose whether you want the list to be sortable or not', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_sortable',
				  'default' => 'no',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|standard_list'
				  )),

			array('title' => __('Show Tags','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_portfolio_tags',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'standard_list'
				  )),
				  
			array('title' => __('Pagination', 'ux'),
				  'description' => __('The "Twitter" option is to show a "Load More" button on the bottom of the list', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_pagination',
				  'default' => 'no',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|interlock_list|standard_list'
				  )),
				  
			array('title' => __('Post Number per Page', 'ux'),
				  'description' => __('How many items should be displayed per page, leave it empty to show all items in one page', 'ux'),
				  'type' => 'text',
				  'name' => 'module_portfolio_per_page',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|interlock_list|standard_list'
				  )),
				  
			array('title' => __('Category', 'ux'),
				  'description' => __('The featured images of the Portfolio posts under the category you selected would be shown in this module', 'ux'),
				  'type' => 'category',
				  'name' => 'module_portfolio_category',
				  'default' => '0',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|interlock_list|standard_list|carousel_list'
				  )),
				  
			array('title' => __('Order by', 'ux'),
				  'description' => __('Select sequence rules for the list', 'ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'masonry_list|interlock_list|carousel_list'
				  )),
                  
            array('title'       => __('Category', 'ux'),
				  'description' => __('The Posts under the category you selected would be shown in this module', 'ux'),
				  'type'        => 'category-multiple',
				  'name'        => 'module_blog_category',
				  'default'     => '0',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'custom_grid'
				  )),
				  
			array('title' => __('List Layout Builder','ux'),
				  'type' => 'layout-builder',
				  'name' => 'module_portfolio_layout_builder',
				  'default' => 'col1',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'custom_grid'
				  )),
				  
			// array('title' => __('Auto Play Wide Video','ux'),
			// 	  'type' => 'switch',
			// 	  'name' => 'module_portfolio_auto_play',
			// 	  'default' => 'off',
			// 	  'control' => array(
			// 		  'name' => 'module_portfolio_type',
			// 		  'value' => 'custom_grid'
			// 	  )),
			
			array('title' => __('Enable Post Meta','ux'),
				  'description' => __('Turn on it to enable post meta information','ux'),
				  'type' => 'switch',
				  'name' => 'module_portfolio_meta',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'interlock_list'
				  )),
				  
			array('title' => __('Style', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_brick_style',
				  'default' => 'standard',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'brick'
				  )),
				  
			array('title' => __('Sortable', 'ux'),
				  'type' => 'select',
				  'name' => 'module_portfolio_brick_sortable',
				  'default' => 'no',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'brick'
				  )),
				  
			array('title' => __('Filter Fixed', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_portfolio_brick_filter_fixed',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_portfolio_brick_sortable',
					  'value' => 'floating'
				  )),
				  
			array('title' => __('Show On Hover Status', 'ux'),
				  'type' => 'checkbox-group',
				  'name' => 'module_portfolio_carousel_hover_status',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'carousel_list'
				  )),
				  
			/*array('title' => __('Enable Ajax Effect', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_portfolio_ajax_effect',
				  'default' => 'off'),*/
				  
			array('title' => __('Hover Effect', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_portfolio_switch_hover_effect',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_portfolio_type',
					  'value' => 'brick|carousel_list'
				  )),

			array('title' => __('Advanced Settings', 'ux'),
				  'description' => __('magin and animations', 'ux'),
				  'type' => 'switch',
				  'name' => 'module_advanced_settings',
				  'default' => 'off'),
				  
			array('title' => __('Bottom Margin', 'ux'),
				  'description' => __('the spacing outside the bottom of module', 'ux'),
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
add_filter('ux_pb_module_fields', 'ux_pb_module_portfolio_fields');
?>