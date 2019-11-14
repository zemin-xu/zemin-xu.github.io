<?php
//blog template
function ux_pb_module_blog($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		//blog confing
		$type           = get_post_meta($module_post, 'module_blog_type', true);
		$per_page       = get_post_meta($module_post, 'module_blog_per_page', true);
		$category       = get_post_meta($module_post, 'module_blog_category', true);
		$pagination     = get_post_meta($module_post, 'module_blog_pagination', true);
		$per_page       = $per_page ? $per_page : -1;
		
		if(!is_array($category)){
			$category = array($category);
		}

		switch($type){
			case 'masonry_list':
				$blog_querys = get_posts(array(
					'posts_per_page' => -1,
					'category__in' => $category
				));
				
				$count = count($blog_querys); ?>
                <div class="blog-masony-wrap">
                    
					<div class="container-isotope clear" data-post="<?php echo esc_attr($itemid); ?>">
						
                        <div id="isotope-load">
			            	<!-- <div class="ux-loading"></div>
			            	<div class="ux-loading-transform"><div class="spinner"></div></div> -->
			            </div>
						<div class="isotope masonry" style="margin:-20px 0 0 -20px;" data-space="20px" data-size="medium">
							<?php ux_pb_module_load_blog($itemid, 1); ?>
                        </div>
					</div> <!--End container-isotope-->
				</div>
				<?php
				if($count > 2){
					ux_view_module_pagenums($itemid, 'blog', $per_page, $count, $pagination);
				}
			break;
			
			case 'standard_list':
				$blog_querys = get_posts(array(
					'posts_per_page' => -1,
					'category__in' => $category
					
				));
				$count = count($blog_querys); ?>
				
				<div class="blog-list list-heigh-fixed" data-post="<?php echo esc_attr($itemid); ?>">
					<?php 
					if($blog_querys){ 
						ux_pb_module_load_blog($itemid, 1);
					} ?>
                </div>
				<?php
				if($count > 2){
					ux_view_module_pagenums($itemid, 'blog', $per_page, $count, $pagination);
				}
			break;
			
			case 'big_image_list':
				$blog_querys = get_posts(array(
					'posts_per_page' => -1,
					'category__in' => $category
					
				));
				$count = count($blog_querys);
				
				$number_featured_post = get_post_meta($module_post, 'module_blog_number_featured_post', true);
				$number_grid_post = get_post_meta($module_post, 'module_blog_number_grid_post', true);
				$orderby = get_post_meta($module_post, 'module_select_orderby', true);
				$order = get_post_meta($module_post, 'module_select_order', true);
				
				$per_page = intval($number_grid_post);
				$per_page = $per_page ? $per_page : -1;
				$count = $count - intval($number_featured_post);

				$cols = get_post_meta($module_post, 'module_blog_list_cols', true); 
				$cols = $cols ? $cols : 'col3';
				?>
            
                <div class="blog-bigimage <?php echo esc_attr($cols); ?>" data-animationend="fadeined">
					<?php 
					if($blog_querys){
						$exclude_ids = '';
		
						$this_per_page = intval($number_featured_post) + intval($number_grid_post);
						$this_per_page = $this_per_page ? $this_per_page : -1;
						
						$get_blogs = get_posts(array(
							'posts_per_page' => $this_per_page,
							'orderby'        => $orderby,
							'order'          => $order,
							'category__in'   => $category
						));
						
						if(intval($number_featured_post) && $get_blogs){
							global $post;
							$exclude_ids = array(); ?>
                            
                            <div class="blog-bi-feature">
                                <?php foreach($get_blogs as $num => $post){ setup_postdata($post);
                                    $get_post_format = (!get_post_format()) ? 'standard' : get_post_format();
									
                                    if($num < intval($number_featured_post)){
										array_push($exclude_ids, $post->ID); ?>
                                        <section class="blog-bi-feature-item section-anchor fullscreen-wrap">
                                            <?php ux_pb_module_blog_big_item($get_post_format, false, $module_post); ?>
                                        </section>
                                    <?php
                                    }
                                }
                                wp_reset_postdata();
								$exclude_ids = join(',', $exclude_ids); ?>
                            </div>
                        <?php
                        }
						
						if(intval($number_grid_post) && $get_blogs){ ?>
                            <div class="blog-bi-list clearfix section-anchor" data-post="<?php echo esc_attr($itemid); ?>">
                                <?php ux_pb_module_load_blog($itemid, 1, $exclude_ids); ?>
                            </div>
                        <?php
                        }
					} ?>
                </div>
				<?php
				$show_load_more = get_post_meta($module_post, 'module_blog_show_load_more', true);
				if($show_load_more == 'on'){
					if($count > 2){
						ux_view_module_pagenums($itemid, 'blog', $per_page, $count, 'twitter', $exclude_ids);
					}
				}
			
			break;
		}
	}
}
add_action('ux-pb-module-template-blog', 'ux_pb_module_blog');


//blog load template
function ux_pb_module_load_blog($itemid, $paged, $exclude_ids=''){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'blog';
	
	if($module_post){
		//blog confing
		$type                 = get_post_meta($module_post, 'module_blog_type', true);
		$per_page             = get_post_meta($module_post, 'module_blog_per_page', true);
		$pagination           = get_post_meta($module_post, 'module_blog_pagination', true);
		$category             = get_post_meta($module_post, 'module_blog_category', true);
		$orderby              = get_post_meta($module_post, 'module_select_orderby', true);
		$order                = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings    = get_post_meta($module_post, 'module_advanced_settings', true);
		$post_meta            = get_post_meta($module_post, 'module_blog_meta', true);
		$blog_center          = get_post_meta($module_post, 'module_blog_center', true);
		$number_featured_post = get_post_meta($module_post, 'module_blog_number_featured_post', true);
		$number_grid_post     = get_post_meta($module_post, 'module_blog_number_grid_post', true);
		
		$animation_base       = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$per_page             = $per_page ? $per_page : -1;
		
		$animation_style      = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end        = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		$animation_end        = 'data-animationend="' . $animation_end . '"';
		
		if(!is_array($category)){
			$category = array($category);
		}
		
		switch($type){
			case 'masonry_list':
				global $post;
				
				$sticky = get_option('sticky_posts');
		
				$get_sticky = get_posts(array(
					'posts_per_page' => $per_page,
					'paged'          => $paged,
					'category__in'   => $category,
					'orderby'        => $orderby,
					'order'          => $order,
					'post__in'       => $sticky
				));
				
				$get_blogs = get_posts(array(
					'posts_per_page' => $per_page,
					'orderby'        => $orderby,
					'paged'          => $paged,
					'order'          => $order,
					'category__in'   => $category,
					'post__not_in'   => $sticky,
				));
				
				if($sticky){
					$get_blogs = array_merge_recursive($get_sticky, $get_blogs);
				}
				
				foreach($get_blogs as $post){ setup_postdata($post);
					$get_post_format = (!get_post_format()) ? 'standard' : get_post_format();
					$blog_categories = get_the_category(get_the_ID());
					$separator = ' ';
					$output = '';
					if($blog_categories){
						foreach($blog_categories as $category){
							$output .= 'filter_'.$category->slug.$separator;
						}
					}
					
					$bg_color = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
					$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
					
					 ?>
                    <div class="<?php echo esc_attr(trim($output, $separator)); ?> width2 isotope-item <?php echo sanitize_html_class($get_post_format); ?>">
                        <div class="inside <?php echo esc_attr($animation_style); ?>" <?php echo balanceTags($animation_end); ?> style="margin:20px 0 0 20px;">
                            <div class="blog-masony-item">
                                <div class="item_topbar"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="item_link"></a></div>
                                
                                <?php // ux_pb_module_blog_format($get_post_format); 
                                	switch($get_post_format){
										case 'quote':
											$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote'); ?>
								            <div class="item_des blog-item-quote item-des-p">
		                                    	<i class="icon-m-quote-left"></i>
		                                        <p><?php echo wp_kses_post($ux_quote); ?></p>
		                                        
		                                    </div>
								        <?php
										break;
										
										case 'link':
											$ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');
											if($ux_link_item){ ?>
												<div class="item_des blog-item-link">
													<h2 class="item_title ux-grid-tit"><a class="item-title-a ux-grid-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			                                        <?php if(get_the_excerpt()){ ?><div class="item-des-p ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
													<div class="item-link-wrap">
													<?php foreach($ux_link_item['name'] as $i => $name){
														$url = $ux_link_item['url'][$i]; ?>
								                        <p class="item-link"><a title="<?php echo esc_attr($name); ?>" href="<?php echo esc_url($url); ?>"><?php echo esc_html($name); ?></a></p>
								                    <?php } ?>
								                	</div>
								                    
								              </div>
											<?php
								            }
										break;
										
										case 'audio':
											$ux_audio_type = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
											$ux_audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
											$ux_audio_mp3 = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
											$ux_audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');
											switch($ux_audio_type){
												case 'self-hosted-audio': ?>
													<ul class="audio_player_list">
														<?php foreach($ux_audio_mp3['name'] as $i => $name){
															$url = $ux_audio_mp3['url'][$i]; ?>
															<li class="audio-unit"><span id="audio-<?php echo esc_attr(get_the_ID() . '-' . $i); ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span><span class="songtitle" title="<?php echo esc_attr($name);?>"><?php echo esc_html($name); ?></span></li>
														<?php } ?>
								                    </ul>
								                    <div class="item_des">
								                        <div class="date-block">
								                        	<p class="date-block-m"><?php echo esc_html(get_the_time('M'));?></p>
								                            <p class="date-block-big"><?php echo esc_html(get_the_time('d'));?></p>
								                            <p class="date-block-y"><?php echo esc_html(get_the_time('Y'));?></p>
								                            <div class="date-block-bg"></div>
								                        </div><!--End .date-block-->
								                        <h2 class="item_title ux-grid-tit"><a class="item-title-a ux-grid-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
								                    	<?php if(get_the_excerpt()){ ?><div class="item-des-p ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
								                    </div>
								                <?php
												break;
												
												case 'soundcloud': ?>
													<div class="soundcloudWrapper">
							                            <?php if($ux_audio_soundcloud){ ?>
							                                <iframe width="100%" height="166" scrolling="no" src="https://w.soundcloud.com/player/?url=<?php echo esc_url($ux_audio_soundcloud); ?>&amp;color=ff3900&amp;auto_play=false&amp;show_artwork=false"></iframe>
							                            <?php } ?>
								                    </div>
								                    <div class="item_des">
								                        <div class="date-block">
								                        	<p class="date-block-m"><?php echo esc_html(get_the_time('M')); ?></p>
								                            <p class="date-block-big"><?php echo esc_html(get_the_time('d')); ?></p>
								                            <p class="date-block-y"><?php echo esc_html(get_the_time('Y')); ?></p>
								                            <div class="date-block-bg"></div>
								                        </div><!--End .date-block-->
								                        <h2 class="item_title ux-grid-tit"><a class="item-title-a ux-grid-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
								                        <?php if(get_the_excerpt()){ ?><div class="item-des-p ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
								                    </div>
								                <?php
												break;
											}
										break;
										
										case 'video':
											$ux_video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');
											if($ux_video_embeded_code){ ?>
                                                <div class="video-face">
                                                    <span class="fa fa-play video-play-btn"></span>
                                                    <?php if(has_post_thumbnail()){
                                                        $thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-blog-thumb');
														echo '<img src="' . esc_url($thumb_src_360[0]) . '" class="video-face-img">';
                                                    }else{
														echo '<img src="' . esc_url(UX_PAGEBUILDER) . '/images/play.jpg" class="video-face-img">';
													}
													
                                                    if(strstr($ux_video_embeded_code, "youtu") && !(strstr($ux_video_embeded_code, "iframe"))){ ?>
                                                        <div class="videoWrapper youtube video-wrap hidden">
                                                            <iframe src="http://www.youtube.com/embed/<?php echo esc_attr(ux_theme_get_youtube($ux_video_embeded_code)); ?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent">
                                                            </iframe>
                                                        </div>	
                                                    <?php }elseif(strstr($ux_video_embeded_code, "vimeo") && !(strstr($ux_video_embeded_code, "iframe"))){ ?>
                                                        <div class="videoWrapper vimeo video-wrap hidden">
                                                            <iframe src="http://player.vimeo.com/video/<?php echo esc_attr(ux_theme_get_vimeo($ux_video_embeded_code)); ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0" width="100%" height="auto" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                                                        </div>
                                                    <?php }else{
                                                        echo '<div class="videoWrapper video-wrap hidden">'. balanceTags($ux_video_embeded_code). '</div>';
                                                    } ?>
                                                </div>
                                            <?php } ?>
								            
								            
								            <div class="item_des ">
								                <div class="date-block">
						                        	<p class="date-block-m"><?php echo esc_html(get_the_time('M')); ?></p>
						                            <p class="date-block-big"><?php echo esc_html(get_the_time('d')); ?></p>
						                            <p class="date-block-y"><?php echo esc_html(get_the_time('Y')); ?></p>
						                            <div class="date-block-bg"></div>
						                        </div><!--End .date-block-->
								                <h2 class="item_title ux-grid-tit"><a class="item-title-a ux-grid-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
								                <?php if(get_the_excerpt()){ ?><div class="item-des-p ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
								            </div>
								        <?php
										break;
										
										case 'gallery':
											$ux_portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio'); ?>
								            <div class="item_des">
								                
											
											<?php if($ux_portfolio){ ?>


                                        		<?php if(has_post_thumbnail()){
		                                        $thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
		                                        $thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb'); ?>
		                                        
		                                        <div class="lightbox-photoswipe">

													<?php foreach($ux_portfolio as $num => $image){

                                                    $thumb_src_full = wp_get_attachment_image_src($image, 'full');
													$data_size = $thumb_src_full[1]. 'x' .$thumb_src_full[2]; ?>
                                                    
                                                    <div class="liqd-gallery-img" data-lightbox="true">

                                                        <a href="<?php echo esc_url($thumb_src_full[0]); ?>" class="lightbox-item" rel="post<?php the_ID(); ?>" title="<?php the_title(); ?>" data-size="<?php echo $data_size; ?>">
                                                            <i class="icon-m-pt-portfolio"></i>
                                                            <img alt="<?php the_title(); ?>" src="<?php echo esc_url($thumb_src_360[0]); ?>" width="800" class="isotope-list-thumb">
                                                        </a>
                                                    
                                                    </div>

		                                   			<?php } //end foreach ?>
		                                   		</div>	
		                                   		<?php } 
		                                   	}	
		                                   	?>
								                <div class="date-block">
						                        	<p class="date-block-m"><?php echo esc_html(get_the_time('M')); ?></p>
						                            <p class="date-block-big"><?php echo esc_html(get_the_time('d')); ?></p>
						                            <p class="date-block-y"><?php echo esc_html(get_the_time('Y')); ?></p>
						                            <div class="date-block-bg"></div>
						                        </div><!--End .date-block-->
								                <h2 class="item_title ux-grid-tit"><a class="item-title-a ux-grid-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
								                <?php if(get_the_excerpt()){ ?><div class="item-des-p ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
								            </div><!--End item_des-->
								        <?php
										break;
										
										default:
											if(has_post_thumbnail()){
												$thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
												$thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb');
												$data_size = $thumb_src_full[1]. 'x' .$thumb_src_full[2]; ?>
                                                <div class="lightbox-photoswipe">
                                                    <div data-lightbox="true">
                                                        <a href="<?php echo esc_url($thumb_src_full[0]); ?>" class="lightbox-item isotope-list-a-of-img" rel="post<?php the_ID(); ?>" title="<?php the_title(); ?>" data-size="<?php echo $data_size; ?>">
                                                            <img alt="<?php the_title(); ?>" src="<?php echo esc_url($thumb_src_360[0]); ?>" width="800" class="isotope-list-thumb">
                                                        </a>
                                                    </div>
                                                </div>
								            <?php } ?>
								            <div class="item_des">
								            	<div class="date-block">
						                        	<p class="date-block-m"><?php echo esc_html(get_the_time('M')); ?></p>
						                            <p class="date-block-big"><?php echo esc_html(get_the_time('d')); ?></p>
						                            <p class="date-block-y"><?php echo esc_html(get_the_time('Y')); ?></p>
						                            <div class="date-block-bg"></div>
						                        </div><!--End .date-block-->
								                <h2 class="item_title ux-grid-tit"><a class="item-title-a ux-grid-tit-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
								                <?php if(get_the_excerpt()){ ?><div class="item-des-p ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
								                <div class="like clear"></div><!--End like-->
								            </div>
										<?php
								        break;
									} ?>
                                
                            </div>
                        </div>
                    </div>
                <?php	
				}
				wp_reset_postdata();
			break;
			
			case 'standard_list':
				global $post;
				
				$sticky = get_option('sticky_posts');
		
				$get_sticky = get_posts(array(
					'posts_per_page' => $per_page,
					'paged'          => $paged,
					'category__in'   => $category,
					'orderby'        => $orderby,
					'order'          => $order,
					'post__in'       => $sticky
				));
				
				$get_blogs = get_posts(array(
					'posts_per_page' => $per_page,
					'orderby'        => $orderby,
					'paged'          => $paged,
					'order'          => $order,
					'category__in'   => $category,
					'post__not_in'   => $sticky,
					
				));
				
				if($sticky){
					$get_blogs = array_merge_recursive($get_sticky, $get_blogs);
				}

				foreach($get_blogs as $post){ setup_postdata($post);
				
					//** Post format
					$get_post_format = (!get_post_format()) ? 'standard' : get_post_format(); ?>
                    
                    <article <?php post_class(); ?>>
					
						<?php switch($get_post_format){
                            case 'standard':
							
								ux_pb_module_blog_list_title($module_post);
								
								if(has_post_thumbnail()){
                                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                                    <div class="post-featured-img">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img src="<?php echo esc_url($thumb[0]); ?>" alt="<?php the_title(); ?>" class="" /></a>
                                    </div>
                                <?php
								}
								ux_interface_blog_list_excerpt($module_post);
                                ux_interface_blog_show_meta('continue-reading', 'article', false, $module_post);
								ux_interface_social_bar($module_post);
                            break;
							
							case 'audio':
							
								ux_pb_module_blog_list_title($module_post);
								
								$audio_type = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
								$audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');
								if($audio_type == 'soundcloud' && $audio_soundcloud){ ?>
								
									<div class="blog-unit-soundcloud">
										<iframe width="100%" height="160" scrolling="no" src="https://w.soundcloud.com/player/?url=<?php echo esc_url($audio_soundcloud); ?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
									</div>
									
								<?php }else{
									$audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
									$audio_mp3 = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
									$first_name = $audio_mp3['name'][0];
									$first_url = $audio_mp3['url'][0]; ?>
									
									<div class="blog-unit-img-wrap " style="">
										<ul class="audio_player_list blog-list-audio">
											<li class="audio-unit"><span id="audio-<?php echo esc_attr(get_the_ID() . '-0'); ?>" class="audiobutton pause" rel="<?php echo esc_url($first_url); ?>"></span><span class="songtitle" title="<?php echo esc_attr($first_name); ?>"><?php echo esc_html($first_name); ?></span></li>
											<div class="blog-list-audio-artist"><?php esc_html_e('Artist:','ux'); ?> <?php echo esc_html($audio_artist); ?></div>
										</ul>
									</div>
									
								<?php
								}
								ux_interface_blog_list_excerpt($module_post);
                                ux_interface_blog_show_meta('continue-reading', 'article', false, $module_post);
								ux_interface_social_bar($module_post);
							
							break;
							
							case 'gallery':
							
								ux_pb_module_blog_list_title($module_post);
								ux_get_template_part('single/portfolio', 'template');
								ux_interface_blog_list_excerpt($module_post);
                                ux_interface_blog_show_meta('continue-reading', 'article', false, $module_post);
								ux_interface_social_bar($module_post);
							
							break;
							
							case 'image':
							
								ux_pb_module_blog_list_title($module_post);
								
								if(has_post_thumbnail()){
                                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                                    <div class="post-featured-img">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img src="<?php echo esc_url($thumb[0]); ?>" alt="<?php the_title(); ?>" class="" /></a>
                                    </div>
                                <?php
								}
								ux_interface_blog_list_excerpt($module_post);
                                ux_interface_blog_show_meta('continue-reading', 'article', false, $module_post);
								ux_interface_social_bar($module_post);
							
							break;
							
							case 'link':
							
								$ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');
								if($ux_link_item){ ?>
									<ul class="blog-unit-link">
										<?php foreach($ux_link_item['name'] as $i => $name){
											$url = $ux_link_item['url'][$i]; ?>
											<li class="blog-unit-link-li"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($name); ?>" class="blog-unit-link-li"><?php echo esc_html($name); ?></a></li>
										<?php } ?>
									</ul>
								<?php
								edit_post_link('(Edit)'); 
								}
								ux_interface_social_bar($module_post);
							
							break;
							
							case 'quote':
							
								$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote');
								$ux_quote_cite = ux_get_post_meta(get_the_ID(), 'theme_meta_quote_cite'); ?>
								
								<div class="blog-unit-quote"><?php echo esc_html($ux_quote); ?>
									<?php if($ux_quote_cite){ ?>
									<cite><span class="cite-line">&mdash;</span> <?php echo esc_html($ux_quote_cite); ?></cite>
										<?php } ?> 
								</div>
								<?php
								edit_post_link('(Edit)');
								ux_interface_social_bar($module_post);
							
							break;
							
							case 'video':
								ux_pb_module_blog_list_title($module_post); ?>
                                
                                <div class="blog-unit-img-wrap " style=""><a class="blog-unit-video-play" href="<?php the_permalink(); ?>"><span class="fa fa-play"></span></a>
									<?php if(has_post_thumbnail()){    
                                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                                        <img alt="<?php the_title(); ?>" src="<?php echo esc_url($thumb[0]); ?>" class="blog-unit-img">
                                    <?php } ?>
                                    <div class="video-wrap hidden">
                                        <?php $video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');
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
                                        } ?>
                                    </div>
                                </div>
								
                                <?php
								ux_interface_blog_list_excerpt($module_post);
                                ux_interface_blog_show_meta('continue-reading', 'article', false, $module_post);
								ux_interface_social_bar($module_post);
							
							break;
                        } ?>
                    </article>
				<?php
				}
				wp_reset_postdata();
			break;
			
			case 'big_image_list':
				global $post;
		
				$per_page = intval($number_grid_post);
				$per_page = $per_page ? $per_page : -1;
				
				if($exclude_ids != ''){
					$exclude_ids = explode(',', $exclude_ids);
				}else{
					$exclude_ids = array();
				}
				
				$get_blogs = get_posts(array(
					'posts_per_page' => $per_page,
					'orderby'        => $orderby,
					'paged'          => $paged,
					'order'          => $order,
					'category__in'   => $category,
					'post__not_in'   => $exclude_ids
				));
				
				if($get_blogs){
					foreach($get_blogs as $post){ setup_postdata($post);
						$get_post_format = (!get_post_format()) ? 'standard' : get_post_format(); ?>
                        
                        <section class="blog-bi-list-item  blog-grid-half">
                            <?php ux_pb_module_blog_big_item($get_post_format, 'list', $module_post); ?>
                        </section>
                        
                    <?php
					}
					wp_reset_postdata();
                }
			break;
		}
	}
}

//blog list title
function ux_pb_module_blog_big_item($format, $type=false, $module_post){
	$item_tit = 'bi-feature-item-tit';
	$item_tit_a = 'bi-feature-item-tit-a';
	$item_con = 'bi-feature-item-con';
	$item_meta = 'bi-feature-item-meta';
	$item_meta_a = 'bi-feature-item-meta-item';
	$item_bg = 'blog-bi-feature-item-bg';
	$item_bg_style = false;
	
	if($type == 'list'){
		$item_tit = 'bi-list-item-tit';
		$item_tit_a = 'bi-list-item-tit-a';
		$item_con = 'bi-list-item-con';
		$item_meta = 'bi-list-item-meta';
		$item_meta_a = 'bi-list-item-meta-item';
		$item_bg = 'blog-bi-list-item-bg';
	}
	
	if(has_post_thumbnail()){
		$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
		$item_bg_style = 'background:url(' .$thumbnail[0]. ') 50% 50% no-repeat; background-size:cover;';
	}
	
	switch($format){
		case 'link': ?>
			<div class="<?php echo sanitize_html_class($item_con); ?> middle-ux">
				
                <?php $ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');
                if($ux_link_item){ ?>
                    <ul class="bi-link">
                        <?php foreach($ux_link_item['name'] as $i => $name){
                            $url = $ux_link_item['url'][$i]; ?>
                            <li class="bi-link-li"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($name); ?>" class="bi-link-li-a"><?php echo esc_html($name); ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                
			</div>
			<div class="<?php echo sanitize_html_class($item_bg); ?>" style=" <?php echo esc_attr($item_bg_style); ?>"></div>
		<?php
		break;
		
		case 'quote':
			$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote');
			$ux_quote_cite = ux_get_post_meta(get_the_ID(), 'theme_meta_quote_cite'); ?>
			<div class="<?php echo sanitize_html_class($item_con); ?> middle-ux">
				<div class="bi-quote"><?php echo wp_kses_post($ux_quote); ?>
					<?php if($ux_quote_cite){ ?>
                    <cite><span class="cite-line">&mdash;</span> <?php echo wp_kses_post($ux_quote_cite); ?></cite>
                    <?php } ?>
				</div>
			</div>
			<div class="<?php echo sanitize_html_class($item_bg); ?>" style=" <?php echo esc_attr($item_bg_style); ?>"></div>
		<?php
        break;
		
		case 'gallery':
			$enable_video_cover = ux_get_post_meta(get_the_ID(), 'theme_meta_enable_video_cover');
			$video_cover_alt_image = ux_get_post_meta(get_the_ID(), 'theme_meta_video_cover_alt_image');
			
			if(has_post_format('gallery') && $enable_video_cover && $video_cover_alt_image){
				$item_bg_style = 'background:url(' .$video_cover_alt_image. ') 50% 50% no-repeat; background-size:cover;';
			} ?>
			
			<div class="<?php echo sanitize_html_class($item_con); ?> middle-ux">
				<span class="<?php echo sanitize_html_class($item_meta); ?>">
					<?php ux_theme_hide_category(' ', $item_meta_a);  ?>
                
                </span>
				<h1 class="<?php echo sanitize_html_class($item_tit); ?>"><a class="<?php echo sanitize_html_class($item_tit_a); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
				 <div class="bi-feature-item-meta-bottom">
                	<?php ux_interface_blog_show_meta('date', 'article', false, $module_post); ?>
                	<?php ux_interface_blog_show_meta('length', 'article', false, $module_post); ?>
                	<?php ux_interface_blog_show_meta('author', 'article', false, $module_post); ?>
                </div>
			</div>
            <div class="<?php echo sanitize_html_class($item_bg); ?>" style=" <?php echo esc_attr($item_bg_style); ?>"></div>
            <?php if($enable_video_cover && $type != 'list'){
				$webm = ux_get_post_meta(get_the_ID(), 'theme_meta_video_cover_webm');
				$mp4 = ux_get_post_meta(get_the_ID(), 'theme_meta_video_cover_mp4');
				$ogg = ux_get_post_meta(get_the_ID(), 'theme_meta_video_cover_ogg');
				$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
				$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
				$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
				$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
				$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS"); 
				$ie9     = strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 9.0");
				?>
				
				<div class="blog-bi-video-wrap">
                    <div class="fullwrap-video">
                    	<?php if(!$ie9 && !$iPod && !$iPhone && !$iPad && !$Android && !$webOS) { ?>
                        <video id="video-<?php the_ID(); ?>" autoplay muted loop poster="<?php echo esc_url($thumbnail[0]); ?>" class="centered-ux video-tag">
                            <?php if($webm){ ?><source src="<?php echo esc_url($webm); ?>" type="video/webm"><?php } ?>
                            <?php if($mp4){ ?><source src="<?php echo esc_url($mp4); ?>" type="video/mp4"><?php } ?>
                            <?php if($ogg){ ?> <source src="<?php echo esc_url($ogg); ?>" type="video/ogg"><?php } ?>
                        </video>
                        <?php } ?>
                    </div>
                </div>
			<?php 
			}
		break;
		
		default: ?>
            <div class="<?php echo sanitize_html_class($item_con); ?> middle-ux">
                <span class="<?php echo sanitize_html_class($item_meta); ?>">
					<?php ux_theme_hide_category(' ', $item_meta_a); ?>
                </span>
                <h1 class="<?php echo sanitize_html_class($item_tit); ?>"><a class="<?php echo sanitize_html_class($item_tit_a); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
                <div class="bi-feature-item-meta-bottom">
                	<?php ux_interface_blog_show_meta('date', 'article', false, $module_post); ?>
                	<?php ux_interface_blog_show_meta('length', 'article', false, $module_post); ?>
                	<?php ux_interface_blog_show_meta('author', 'article', false, $module_post); ?>
                </div>
            </div>
            <div class="<?php echo sanitize_html_class($item_bg); ?>" style=" <?php echo esc_attr($item_bg_style); ?>"></div>
		<?php
        break;
	}
}

//blog list title
function ux_pb_module_blog_list_title($module_post){
	$show_on_top = get_post_meta($module_post, 'module_blog_show_on_top', true);
	
	if($show_on_top){
		switch($show_on_top){
			case 'date': echo get_the_time('M j, Y'); break;
			case 'length':
				$pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
				$read_length = ux_get_post_meta(get_the_ID(), 'theme_meta_post_length');
				$read_length = $read_length ? $read_length : '2'; 
	
				$length = ux_get_option('theme_option_descriptions_x_min_read');
				$length_text = $length ? $length : __(' min read','ux');
	
				if($read_length){
					echo esc_html($read_length). ' ' .esc_html($length_text);
	
				}else{
					if($pb_switch != 'pagebuilder'){
						echo ux_interface_blog_min_read(). ' ' .esc_html($length_text);
					}
				}
			break;
			case 'category': the_category(); break;
			case 'tag': the_tags(); break;
			case 'author': the_author(); break;
		}
	} ?>
    
	<div class="blog-unit-tit-wrap">
        <h1 class="blog-unit-tit"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="blog-unit-meta">
			<?php
			ux_interface_blog_show_meta('date', 'article', false, $module_post);
			ux_interface_blog_show_meta('length', 'article', false, $module_post);
			ux_interface_blog_show_meta('category', 'article', false, $module_post);
			ux_interface_blog_show_meta('tag', 'article', false, $module_post);
			ux_interface_blog_show_meta('author', 'article', false, $module_post);
			ux_interface_blog_show_meta('comments', 'article', false, $module_post);
			edit_post_link('(Edit)'); ?>
        </div>
    </div>
<?php
}

//blog select fields
function ux_pb_module_blog_select($fields){
	$fields['module_blog_type'] = array(
		//array('title' => __('Masonry List', 'ux'),                  'value' => 'masonry_list'),
		//array('title' => __('Standard List', 'ux'),                 'value' => 'standard_list'),
		array('title' => __('Big Image List', 'ux'),                'value' => 'big_image_list')
	);
	
	$fields['module_blog_pagination'] = array(
		array('title' => __('No', 'ux'),                            'value' => 'no'),
		array('title' => __('Page Number', 'ux'),                   'value' => 'page_number'),
		array('title' => __('Load More', 'ux'),                     'value' => 'twitter')
	);

	$fields['module_blog_list_cols'] = array(
		array('title' => __('2 Columns', 'ux'),                     'value' => 'col2'),
		array('title' => __('3 Columns', 'ux'),            	        'value' => 'col3') 
	);
	
	$fields['module_blog_posts_showmeta'] = array(
		array('title' => __('Date','ux'),                           'value' => 'date'),
		array('title' => __('Length','ux'),                         'value' => 'length'),
		array('title' => __('Category','ux'),                       'value' => 'category'),
		array('title' => __('Tag','ux'),                            'value' => 'tag'),
		array('title' => __('Author','ux'),                         'value' => 'author'),
		array('title' => __('Comments','ux'),                       'value' => 'comments'),
		array('title' => __('Continue Reading','ux'),               'value' => 'continue-reading')
	);
	
	$fields['module_blog_show_on_top'] = array(
		array('title' => __('Date','ux'),                           'value' => 'date'),
		array('title' => __('Length','ux'),                         'value' => 'length'),
		array('title' => __('Category','ux'),                       'value' => 'category'),
		array('title' => __('Tag','ux'),                            'value' => 'tag'),
		array('title' => __('Author','ux'),                         'value' => 'author')
	);

	$fields['module_blog_show_meta_below_title_feature'] = array(
		array('title' => __('Date','ux'),                           'value' => 'date'),
		array('title' => __('Length','ux'),                         'value' => 'length'),
		array('title' => __('Author','ux'),                         'value' => 'author')
	);
	
	$fields['module_blog_share_buttons'] = array(
		array('title' => __('Facebook','ux'),                       'value' => 'facebook'),
		array('title' => __('Twitter','ux'),                        'value' => 'twitter'),
		array('title' => __('Google Plus','ux'),                    'value' => 'google-plus'),
		array('title' => __('Pinterest','ux'),                      'value' => 'pinterest'),
		array('title' => __('Digg','ux'),                    	 	'value' => 'digg'),
		array('title' => __('Reddit','ux'),                    	 	'value' => 'reddit'),
		array('title' => __('Linkedin','ux'),                    	'value' => 'linkedin'),
		array('title' => __('Stumbleupon','ux'),                    'value' => 'stumbleupon'),
		array('title' => __('Tumblr','ux'),                    	 	'value' => 'tumblr'),
		array('title' => __('Mail','ux'),                    	 	'value' => 'mail')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_blog_select');

//blog config fields
function ux_pb_module_blog_fields($module_fields){
	$module_fields['blog'] = array(
		'id' => 'blog',
		'animation' => true,
		'title' => __('Blog', 'ux'),
		'item' =>  array(
			array('title'       => __('List Type', 'ux'),
				  'description' => '',
				  'type'        => 'select',
				  'name'        => 'module_blog_type',
				  'default'     => 'standard_list'),
                  
            array('title'       => __('Category', 'ux'),
				  'description' => __('The Posts under the category you selected would be shown in this module', 'ux'),
				  'type'        => 'category-multiple',
				  'name'        => 'module_blog_category',
				  'default'     => '0'),
                  
            array('title'       => __('Order by', 'ux'),
				  'description' => __('select sequence rules for the list', 'ux'),
				  'type'        => 'orderby',
				  'name'        => 'module_select_orderby',
				  'default'     => 'date'),
				  
			// array('title'       => __('Show on Top of Item', 'ux'),
			// 	  'description' => '',
			// 	  'type'        => 'select',
			// 	  'name'        => 'module_blog_show_on_top',
			// 	  'default'     => 'category',
			// 	  'control'     => array('name'  => 'module_blog_type',
			// 							 'value' => 'standard_list')),
				  
			// array('title'       => __('Show Meta','ux'),
			// 	  'description' => '',
			// 	  'type'        => 'checkbox-group',
			// 	  'name'        => 'module_blog_posts_showmeta',
			// 	  'default'     => array(),
			// 	  'control'     => array('name'  => 'module_blog_type',
			// 							 'value' => 'standard_list')),

			// array('title'       => __('Show Summary of Content', 'ux'),
			// 	  'description' => '',
			// 	  'type'        => 'switch',
			// 	  'name'        => 'module_blog_show_summary',
			// 	  'default'     => 'off',
			// 	  'control'     => array('name'  => 'module_blog_type',
			// 		                     'value' => 'standard_list')),
				  
			// array('title'       => __('Words to Show on List', 'ux'),
			// 	  'description' => '',
			// 	  'type'        => 'text',
			// 	  'name'        => 'module_blog_summary_words',
			// 	  'control'     => array('name'  => 'module_blog_show_summary',
			// 		                     'value' => 'on')),

			// array('title'       => __('Show Share Button', 'ux'),
			// 	  'description' => '',
			// 	  'type'        => 'switch',
			// 	  'name'        => 'module_blog_show_share',
			// 	  'default'     => 'on',
			// 	  'control'     => array('name'  => 'module_blog_type',
			// 		                     'value' => 'standard_list')),
				  
			// array('title'       => '',
			// 	  'description' => '',
			// 	  'type'        => 'checkbox-group',
			// 	  'name'        => 'module_blog_share_buttons',
			// 	  'default'     => array('facebook', 'twitter', 'google-plus', 'pinterest'),
			// 	  'control'     => array('name'  => 'module_blog_show_share',
			// 							 'value' => 'on')),
				  
			// array('title'       => __('Post Number per Page', 'ux'),
			// 	  'description' => __('How many items should be displayed per page, leave it empty to show all items in one page', 'ux'),
			// 	  'type'        => 'text',
			// 	  'name'        => 'module_blog_per_page',
			// 	  'control'     => array('name'  => 'module_blog_type',
			// 							 'value' => 'standard_list|masonry_list')),
				  
			// array('title'       => __('Pagination', 'ux'),
			// 	  'description' => __('The "Twitter" option is to show a "Load More" button on the bottom of the list', 'ux'),
			// 	  'type'        => 'select',
			// 	  'name'        => 'module_blog_pagination',
			// 	  'default'     => 'no',
			// 	  'control'     => array('name'  => 'module_blog_type',
			// 							 'value' => 'standard_list|masonry_list')),
				  
			array('title'       => __('Number of Featured Post', 'ux'),
				  'description' => '',
				  'default'     => '1',
				  'type'        => 'text',
				  'name'        => 'module_blog_number_featured_post'),

			array('title'       => __('Show Meta on Featured Post', 'ux'),
				  'description' => '',
				  'type'        => 'checkbox-group',
				  'name'        => 'module_blog_show_meta_below_title_feature',
				  'default'     => array()),

			array('title'       => __('Columns of Grid Post', 'ux'),
				  'description' => '',
				  'type'        => 'select',
				  'name'        => 'module_blog_list_cols'),
				  
			array('title'       => __('Number of Grid Post (3 Columns/2 Columns)', 'ux'),
				  'description' => '',
				  'default'     => '6',
				  'type'        => 'text',
				  'name'        => 'module_blog_number_grid_post'),

			array('title'       => __('Show Load More Button', 'ux'),
				  'description' => '',
				  'type'        => 'switch',
				  'name'        => 'module_blog_show_load_more',
				  'default'     => 'on'),

			// array('title'       => __('Advanced Settings', 'ux'),
			// 	  'description' => __('magin and animations', 'ux'),
			// 	  'type'        => 'switch',
			// 	  'name'        => 'module_advanced_settings',
			// 	  'default'     => 'off'),
				  
			array('title'       => __('Bottom Margin', 'ux'),
				  'description' => __('the spacing outside the bottom of module', 'ux'),
				  'type'        => 'select',
				  'name'        => 'module_bottom_margin',
				  'default'     => 'bottom-space-no')
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_blog_fields');
?>