<?php
//liquid list template
function ux_pb_module_liquidlist($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		global $post;
		
		//liquid list confing
		$style              = get_post_meta($module_post, 'module_liquidlist_style', true);
		$category           = get_post_meta($module_post, 'module_liquidlist_category', true);
		$image_spacing      = get_post_meta($module_post, 'module_liquidlist_image_spacing', true);
		$image_size         = get_post_meta($module_post, 'module_liquidlist_image_size', true);
		$width              = get_post_meta($module_post, 'module_liquidlist_width', true);
		$words              = get_post_meta($module_post, 'module_liquidlist_words', true);
		$social_network     = get_post_meta($module_post, 'module_liquidlist_social_network', true);
		$per_page           = get_post_meta($module_post, 'module_liquidlist_per_page', true);
		$pagination         = get_post_meta($module_post, 'module_liquidlist_pagination', true);
		$select_image_ratio = get_post_meta($module_post, 'module_liquidlist_image_ratio', true);
		
		$image_ratio = 'image-thumb';
		switch($select_image_ratio){
			case '3:2':  $image_ratio = 'image-thumb'; break;
			case '1:1':  $image_ratio = $image_size == 'large' ? 'image-thumb-1' : 'imagebox-thumb'; break;
			case '1:2':  $image_ratio = 'image-thumb-2'; break;
			case 'auto': $image_ratio = 'standard-thumb'; break;
		}
		
		$block_width = false;
		switch($width){
			case '3': $block_width = 'width6'; break;
			case '4': $block_width = 'width8'; break;
		}

		$words          = esc_attr($words);
		$block_width    = $block_width ? $block_width : 'width4';
		$block_words    = $words ? $words : false;
		$show_social    = $social_network == 'on' ? 'true' : 'false';
		$per_page       = esc_attr($per_page);
		$per_page       = $per_page ? $per_page : -1;
		$isotope_style  = 'margin:-' . $image_spacing . ' 0 0 -' . $image_spacing . ';';
		
		$get_posts = get_posts(array(
			'posts_per_page'  => -1,
			'cat'             => $category,
			'meta_query'      => array(
				'relation'    => 'AND',
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS'
				)
			)
		));
		if($style == 'magazine'){
			$image_size = 'large';
			$get_posts = get_posts(array(
				'posts_per_page' => -1,
				'cat'            => $category,
			));
		}
		$count = count($get_posts); ?>
        <div class="container-isotope clear" data-post="<?php echo $itemid; ?>">
        	
            <div id="isotope-load">
            	<div class="ux-loading"></div>
            	<div class="ux-loading-transform"><div class="liquid-loading"></div></div>
            </div>
            <div class="isotope masonry isotope-liquid-list <?php if($image_spacing =='0px'){ echo 'less-space'; } ?>" data-space="<?php echo $image_spacing; ?>" style=" <?php echo $isotope_style; ?>" data-size="<?php echo $image_size; ?>"  data-width="<?php echo $block_width; ?>" data-words="<?php echo $block_words; ?>" data-social="<?php echo $show_social; ?>" data-ratio="<?php echo $image_ratio; ?>">
                <?php ux_pb_module_load_liquidlist($itemid, 1); ?>
            </div>
        </div>
        <?php
		if($count > 2){
			ux_view_module_pagenums($itemid, 'liquid-list', $per_page, $count, $pagination);
		}
	}
}
add_action('ux-pb-module-template-liquid-list', 'ux_pb_module_liquidlist');

//liquid list load template
function ux_pb_module_load_liquidlist($itemid, $paged){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'liquid-list';
	
	if($module_post){
		global $post;
		//liquid list confing
		$style              = get_post_meta($module_post, 'module_liquidlist_style', true);
		$effect             = get_post_meta($module_post, 'module_liquidlist_mouseover_effect', true);
		$image_spacing      = get_post_meta($module_post, 'module_liquidlist_image_spacing', true);
		$image_size         = get_post_meta($module_post, 'module_liquidlist_image_size', true);
		$loading_color      = get_post_meta($module_post, 'module_liquidlist_loading_color', true);
		$category           = get_post_meta($module_post, 'module_liquidlist_category', true);
		$orderby            = get_post_meta($module_post, 'module_select_orderby', true);
		$order              = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings  = get_post_meta($module_post, 'module_advanced_settings', true);
		$select_image_ratio = get_post_meta($module_post, 'module_liquidlist_image_ratio', true);
		$per_page           = get_post_meta($module_post, 'module_liquidlist_per_page', true);
		$animation_base     = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$animation_style    = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end      = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		$animation_end      = 'data-animationend="' . $animation_end . '"';
		
		$animation_style    = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$per_page           = $per_page ? $per_page : -1;
		
		$block_color = false;
		switch($loading_color){
			case 'featured_color': $block_color = 'featured_color'; break;
			case 'grey': $block_color = 'bg-theme-color-10'; break;
		}
		
		$image_ratio = 'image-thumb';
		switch($select_image_ratio){
			case '3:2':  $image_ratio = 'image-thumb'; break;
			case '1:1':  $image_ratio = $image_size=='large' ? 'image-thumb-1' : 'imagebox-thumb'; break;
			case '1:2':  $image_ratio = 'image-thumb-2'; break;
			case 'auto': $image_ratio = 'standard-thumb'; break;
		}
		
		$container3d    = $effect == 'on' ? 'hover-effect' : false;
		$back_con_style = 'padding-left: '.$image_spacing.';';
		$back_tit_style = 'margin-top: -'.$image_spacing.';';
		$back_bg_style  = 'left: ' . $image_spacing . '; top: -' . $image_spacing . ';';
		$block_color    = $block_color ? $block_color : false;
		//$inside_style   = $style == 'magazine' ? 'padding:' . $image_spacing . ' 0 0 ' . $image_spacing . ';' : 'margin:' . $image_spacing . ' 0 0 ' . $image_spacing;
		$inside_style   = 'padding:' . $image_spacing . ' 0 0 ' . $image_spacing . ';';
		
		$sticky = get_option('sticky_posts');
		
		$get_sticky = get_posts(array(
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'cat'            => $category,
			'orderby'        => $orderby,
			'order'          => $order,
			'post__in'       => $sticky,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				)
			)
		));
		
		$get_posts = get_posts(array(
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'cat'            => $category,
			'orderby'        => $orderby,
			'order'          => $order,
			'post__not_in'   => $sticky,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				)
			)
		));
		
		if($style == 'magazine'){
			$get_posts = get_posts(array(
				'posts_per_page' => $per_page,
				'paged'          => $paged,
				'cat'            => $category,
				'orderby'        => $orderby,
				'order'          => $order,
				'post__not_in'   => $sticky,
			));
		}
		
		if($sticky){
			$get_posts = array_merge_recursive($get_sticky, $get_posts);
		}
		
		foreach($get_posts as $num => $post){ setup_postdata($post);
			$bg_color = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
			$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
			$bg_color = $loading_color == 'featured_color' ? $bg_color : $block_color;
			
			switch($style){
				case 'image': ?>
					<div class="width2 isotope-item <?php echo $container3d; ?>">
						<div class="inside liquid_inside brick-inside <?php echo $animation_style; ?>" <?php echo $animation_end; ?> style=" <?php echo $inside_style; ?>">
							
							<div class="brick-content brick-hover <?php echo $bg_color; ?>">
								<a href="<?php the_permalink(); ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>">
								<div class="brick-hover-mask">
									<h3 class="brick-title"><?php the_title(); ?></h3>
									
								</div>
							<?php if(has_post_thumbnail()){
								the_post_thumbnail($image_ratio);
							} ?>
								</a>
							</div><!--End brick-content-->
						
						</div><!--End inside-->
						<div style="display:none; <?php echo 'margin:' . $image_spacing . ' 0 0 ' . $image_spacing . ';'; ?>" class="inside liquid-loading-wrap <?php echo $bg_color; ?>">
							<div class="ux-loading"></div>
							<div class="ux-loading-transform"><div class="liquid-loading"></div></div>


							<?php echo get_the_post_thumbnail(get_the_ID(), $image_ratio, array('class'=>'liquid-hide')); ?>
						</div>
					</div>
				<?php
				break;
				
				case 'magazine':
					$get_post_format = (get_post_format() == '') ? 'standard' : get_post_format(); ?>
                    <div class="width2 isotope-item <?php echo $get_post_format; ?>">
                        <div class="inside liquid_inside <?php echo $animation_style; ?>" <?php echo $animation_end; ?> style=" <?php echo $inside_style; ?>">
                            <div class="liquid-item blog-masony-item">
                                <div class="item_topbar <?php echo $bg_color; ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="item_link liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"></a></div>
                                
                                <?php if(has_post_format('quote')){
                                    $ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote');  ?>
                                    <div class="item_des <?php echo $bg_color; ?>">
                                    	<i class="icon-m-quote-left center-ux"></i>
                                        <p><?php echo $ux_quote; ?></p>
                                        
                                    </div>
                                <?php }elseif(has_post_format('link')){
                                    $ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item'); ?>
                                    <div class="item_des <?php echo $bg_color; ?>">
                                    	<h2 class="item_title ux-grid-tit"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ux-grid-tit-a liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
                                        <?php if(get_the_excerpt()){ ?><div class="item-des-p hidden-phone ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
                                        <div class="item-link-wrap">
                                        	<?php foreach($ux_link_item['name'] as $i => $name){
											$url = $ux_link_item['url'][$i]; ?>

											<p class="item-link"><a title="<?php echo $name; ?>" href="<?php echo esc_url($url); ?>"><?php echo $name; ?></a></p>
										<?php } ?>
										</div>
                                        
                                    </div>
                                <?php }elseif(has_post_format('audio')){
                                    $ux_audio_type = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
									$ux_audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
									$ux_audio_mp3 = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
									$ux_audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');
                                    if($ux_audio_type == 'soundcloud'){  ?>
                                        <div class="item_des <?php echo $bg_color; ?>">
                                            <h2 class="item_title ux-grid-tit"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ux-grid-tit-a liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
                                            <div class="soundcloudWrapper">
                                                <iframe width="100%" height="166" scrolling="no" src="https://w.soundcloud.com/player/?url=<?php echo $ux_audio_soundcloud;?>&amp;color=ff3900&amp;auto_play=false&amp;show_artwork=false"></iframe>
                                            </div>
                                            
                                        </div>
                                    <?php }else{ ?>
                                        <div class="item_des <?php echo $bg_color; ?>">
                                            <h2 class="item_title ux-grid-tit"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ux-grid-tit-a liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
                                        </div>
                                        <ul class="audio_player_list <?php echo $bg_color; ?>">
                                            <?php foreach($ux_audio_mp3['name'] as $i => $name){
												$url = $ux_audio_mp3['url'][$i]; ?>
												<li class="audio-unit"><span id="audio-<?php echo get_the_ID() . '-' . $i; ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span><span class="songtitle" title="<?php echo $name;?>"><?php echo $name;?></span></li>
											<?php } ?>
                                        </ul>
                                    <?php
                                    }
                                }elseif(has_post_format('video')){
                                    $ux_video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');
									$thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb');
									
									if($ux_video_embeded_code){ ?>
                                        <div class="video-face">
                                            <span class="fa fa-play video-play-btn"></span>
                                            <?php if(has_post_thumbnail()){
                                                echo '<img src="' . $thumb_src_360[0] . '" class="video-face-img">';
                                            }else{
												echo '<img src="' . UX_PAGEBUILDER . '/images/play.jpg" class="video-face-img">';
											}
											
											if(strstr($ux_video_embeded_code, "youtu") && !(strstr($ux_video_embeded_code, "iframe"))){ ?>
                                                <div class="videoWrapper video-wrap hidden">
                                                    <iframe src="http://www.youtube.com/embed/<?php echo ux_theme_get_youtube($ux_video_embeded_code);?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent"></iframe>
                                                </div>
                                                <?php }elseif(strstr($ux_video_embeded_code, "vimeo") && !(strstr($ux_video_embeded_code, "iframe"))){ ?>
                                                <div class="videoWrapper video-wrap hidden" style="padding-bottom:49%">
                                                    <iframe src="http://player.vimeo.com/video/<?php echo ux_theme_get_vimeo($ux_video_embeded_code); ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0" width="100%" height="auto" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                                                </div>
                                                <?php }else{ ?>
                                                <div class="videoWrapper video-wrap hidden">
                                                    <?php echo $ux_video_embeded_code; ?>
                                                </div>
											<?php } ?>
                                        </div>
									<?php } ?>
                                    <div class="item_des <?php echo $bg_color; ?>">
                                        <h2 class="item_title ux-grid-tit"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ux-grid-tit-a liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
                                        
                                    </div>
                                <?php
                                }elseif(has_post_format('gallery')){
                                    $ux_portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio'); ?>
                                    
                                    <div class="liqd-gallery item_des <?php echo $bg_color; ?>">
                                        
                                        <?php if($ux_portfolio){
											if(has_post_thumbnail()){
		                                        $thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
		                                        $thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb'); ?>
		                                        
												<?php foreach($ux_portfolio as $num => $image){ 

                                                    $thumb_src_full = wp_get_attachment_image_src($image, 'full'); ?>

			                                        <a href="<?php echo $thumb_src_full[0]; ?>" class="liqd-gallery-img liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>" title="<?php the_title(); ?>">
														<i class="icon-m-pt-portfolio centered-ux"></i>
			                                        	<img alt="<?php the_title(); ?>" src="<?php echo $thumb_src_360[0]; ?>" width="800" class="isotope-list-thumb">
			                                        </a>

												<?php
												} //end foreach
											} 
										} ?>

                                        <h2 class="item_title ux-grid-tit"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ux-grid-tit-a liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
                                        <?php if(get_the_excerpt()){ ?><div class="item-des-p hidden-phone ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
                                        
                                    </div><!--End item_des-->
                                <?php }else{
                                    if(has_post_thumbnail()){
                                        $thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                                        $thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb'); ?>
                                        <a href="<?php echo $thumb_src_full[0]; ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>" title="<?php the_title(); ?>">
                                        	<img alt="<?php the_title(); ?>" src="<?php echo $thumb_src_360[0]; ?>" width="800" class="isotope-list-thumb">
                                        </a>
                                    <?php } ?>
                                    <div class="item_des <?php echo $bg_color; ?>">
                                        <h2 class="item_title ux-grid-tit"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="ux-grid-tit-a liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
                                        <?php if(get_the_excerpt()){ ?><div class="item-des-p hidden-phone ux-grid-excerpt"><?php the_excerpt(); ?></div><?php } ?>
                                        <div class="like clear"></div><!--End like-->
                                    </div>
                                <?php } ?>
                            </div>
                        </div><!--End inside-->
                        <div style="display:none; <?php echo 'margin:' . $image_spacing . ' 0 0 ' . $image_spacing . ';'; ?>" class="inside liquid-loading-wrap <?php echo $bg_color; ?>">
                            <div class="ux-loading"></div>
							<div class="ux-loading-transform"><div class="liquid-loading"></div></div>
                            <div class="liquid-hide"></div>
                        </div>
                    </div><!--End isotope-item-->
				<?php
                break;
			}
		}
		wp_reset_postdata();
	}
}

//liquid list charlength
function ux_pb_view_liquid_charlength($charlength){
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5, "utf-8" );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut, "utf-8" );
		} else {
			echo $subex;
		}
		echo '...';
	} else {
		echo $excerpt;
	}
}

//liquid list view load
function ux_pb_view_liquid_load($post_id, $block_words, $show_social, $image_ratio){
	global $post;
	
	$post = get_post($post_id);
	setup_postdata($post); 
	
	$bg_color = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
	$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';

	$learnmore = ux_get_option('theme_option_descriptions_portfolio_learnmore');
	$learnmore = $learnmore ? $learnmore : esc_attr__('LEARN MORE','ux');
    
	$show_social = ($show_social == 'true') ? true : false; ?>
	<section class="liquid-expand-wrap" style="display:none;">
        <h1 class="liquid-title <?php echo $bg_color; ?>">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            <i class="icon-m-close-thin liquid-item-close"></i>
        </h1>
        <div class="liquid-body">
			<?php if(get_the_excerpt()){ ?>
                <div class="liquid-body-des">
                    <?php if($block_words){
                        ux_pb_view_liquid_charlength($block_words);
                    }else{
                        the_excerpt();
                    } ?>
                </div><!--End liquid-body-des-->
            <?php
			}
			
			if(has_post_format('gallery')){
				$ux_portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
				if($ux_portfolio){ ?>
                    <div class="liquid-body-thumbs lightbox-photoswipe clearfix">
                        <?php foreach($ux_portfolio as $num => $image){
                            $thumb_src_full = wp_get_attachment_image_src($image, 'full');
                            $thumb_src = wp_get_attachment_image_src($image, 'imagebox-thumb');
							$data_size = $thumb_src_full[1]. 'x' .$thumb_src_full[2]; ?>
                            <div data-lightbox="true">
                                <a href="<?php echo $thumb_src_full[0]; ?>" title="<?php echo get_the_title($image); ?>" class="imgwrap lightbox-item" data-size="<?php echo $data_size; ?>"><img class="imgwrap-img" width="100" height="100" src="<?php echo $thumb_src[0]; ?>" /></a>
                            </div>
                        <?php } ?>
                    </div>
                <?php 
				}
            }elseif(has_post_format('audio')){
				$ux_audio_type = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
				$ux_audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
				$ux_audio_mp3 = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
				$ux_audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud'); ?>
                <div class="liquid-body-audio">
					<?php if($ux_audio_type == 'soundcloud'){

						if($ux_audio_soundcloud){ ?>
                            <iframe width="100%" height="166" scrolling="no" src="https://w.soundcloud.com/player/?url=<?php echo $ux_audio_soundcloud;?>&amp;color=ff3900&amp;auto_play=false&amp;show_artwork=true"></iframe>
                        <?php
						}
					}else{
						if($ux_audio_mp3){ ?>
							<ul class="audio_player_list">
								<?php foreach($ux_audio_mp3['name'] as $i => $name){
									$url = $ux_audio_mp3['url'][$i]; ?>
									<li class="audio-unit"><span id="audio-<?php echo get_the_ID() . '-' . $i; ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span><span class="songtitle" title="<?php echo $name;?>"><?php echo $name;?></span></li>
								<?php } ?>
                            </ul>
						<?php
						}
					} ?>
				</div>
			<?php 
            }elseif(has_post_format('quote')){
				$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote'); ?>
				<div class="liquid-body-quote">
                    <div class="quote-wrap"><i class="icon-m-quote-left"></i><?php echo $ux_quote; ?></div><!--End quote-wrap-->
                </div><!--End liquid-body-quote-->
			<?php
			}elseif(has_post_format('video')){
				$ux_video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');
				
				if($ux_video_embeded_code){ ?>
                    <div class="liquid-body-video video-wrap video-16-9">
                         <?php if(strstr($ux_video_embeded_code, "youtu") && !(strstr($ux_video_embeded_code, "iframe"))){ ?>
                            <iframe src="http://www.youtube.com/embed/<?php echo ux_theme_get_youtube($ux_video_embeded_code);?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent"></iframe>
                        <?php }elseif(strstr($ux_video_embeded_code, "vimeo") && !(strstr($ux_video_embeded_code, "iframe"))){ ?>
                            <iframe src="http://player.vimeo.com/video/<?php echo ux_theme_get_vimeo($ux_video_embeded_code); ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0" width="100%" height="auto" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                        <?php }else{
                            echo $ux_video_embeded_code;
                        } ?>
                    </div>
				<?php
				}
			}elseif(has_post_format('link')){
				$ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');
				if($ux_link_item){ ?>
					<div class="liquid-body-link">
                        <ul class="link-wrap">
							<?php foreach($ux_link_item['name'] as $i => $name){
                                $url = $ux_link_item['url'][$i]; ?>
                                <li><a title="<?php echo $name; ?>" href="<?php echo esc_url($url); ?>"><i class="icon-m-link"></i><?php echo $name; ?></a></li>
                            <?php } ?>
						</ul>
                    </div><!--End liquid-body-link-->
				<?php
				}
			}else{
				if(has_post_thumbnail()){ ?>
                    <div class="liquid-body-img">
						<?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
                    </div>
				<?php 
				}
			} ?>

        </div><!--End liquid-body-->
        
        <div class="liquid-more">
	            <a href="<?php the_permalink(); ?>" class="liquid-more-icon ux-btn <?php if($show_social){ echo 'liquid-more-icon-right';} ?>" title="<?php the_title(); ?>"><?php echo esc_html($learnmore); ?><span class="fa fa-play"></span></a>
	            <?php if($show_social){ ?>
	                <div class="social-share-buttons clearfix hidden-phone">
	                	<button onclick="javascript:window.open('http://www.facebook.com/share.php?u=<?php the_permalink(); ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="social-share-facebook social-share-button"><span class="fa fa-facebook"></span> <?php _e('Share','ux'); ?></button>
					    <button onclick="javascript:window.open('https://twitter.com/share?url=<?php the_permalink(); ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="social-share-twitter social-share-button"><span  class="fa fa-twitter"></span> <?php _e('Tweet','ux'); ?></button>
					    <button onclick="javascript:window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="social-share-google-plus social-share-button"><span  class="fa fa-google-plus"></span> <?php _e('Share','ux'); ?></button>
					    <?php if(has_post_thumbnail()) { $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?><button onclick="javascript:window.open('http://pinterest.com/pin/create/bookmarklet/?url=<?php the_permalink(); ?>&amp;is_video=false&amp;media=<?php echo $thumbnail[0]; ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="social-share-pinterest social-share-button"><span  class="fa fa-pinterest"></span> <?php _e('Pin it','ux'); ?></button><?php } ?>
	                </div>
	            <?php } ?>
	        </div><!--End liquid-more-->
	        
    </section>
	<?php
    wp_reset_postdata();
}

//liquid list select fields
function ux_pb_module_liquidlist_select($fields){
	$fields['module_liquidlist_style'] = array(
		array('title' => __('Image','ux'), 'value' => 'image')
		//array('title' => __('Magazine','ux'), 'value' => 'magazine')
	);
	
	$fields['module_liquidlist_image_spacing'] = array(
		array('title' => __('0px','ux'), 'value' => '0px'),
		array('title' => __('10px','ux'), 'value' => '10px'),
		array('title' => __('20px','ux'), 'value' => '20px'),
		array('title' => __('30px','ux'), 'value' => '30px'),
		array('title' => __('40px','ux'), 'value' => '40px')
	);
	
	$fields['module_liquidlist_image_ratio'] = array(
		array('title' => '3:2', 'value' => '3:2'),
		array('title' => '1:1', 'value' => '1:1'),
		array('title' => '1:2', 'value' => '1:2'),
		array('title' => __('Auto', 'ux'), 'value' => 'auto')
	);
	
	$fields['module_liquidlist_image_size'] = array(
		array('title' => __('Medium', 'ux'), 'value' => 'medium'),
		array('title' => __('Large', 'ux'), 'value' => 'large'),
		array('title' => __('Small', 'ux'), 'value' => 'small')
	);
	
	$fields['module_latestpost_showfunction'] = array(
		array('title' => __('Title', 'ux'), 'value' => 'title'),
		array('title' => __('Read More Button', 'ux'), 'value' => 'read_more_button')
	);
	
	$fields['module_liquidlist_pagination'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Page Number', 'ux'), 'value' => 'page_number'),
		array('title' => __('Load More', 'ux'), 'value' => 'twitter')
	);
	
	$fields['module_liquidlist_loading_color'] = array(
		array('title' => __('Post Featured Color','ux'), 'value' => 'featured_color'),
		array('title' => __('Grey','ux'), 'value' => 'grey'),
		array('title' => __('White','ux'), 'value' => 'white')
	);
	
	$fields['module_liquidlist_width'] = array(
		array('title' => __('2 Columns','ux'), 'value' => '2'),
		array('title' => __('3 Columns','ux'), 'value' => '3'),
		array('title' => __('4 Columns','ux'), 'value' => '4')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_liquidlist_select');

//liquid list config fields
function ux_pb_module_liquidlist_fields($module_fields){
	$module_fields['liquid-list'] = array(
		'id' => 'liquid-list',
		'animation' => true,
		'title' => __('Liquid list', 'ux'),
		'item' =>  array(
			array('title' => __('Style by Default','ux'),
				  'description' => __('Choose a style for the Liquid List','ux'),
				  'type' => 'select',
				  'name' => 'module_liquidlist_style',
				  'default' => 'image'),
				  
			array('title' => __('Enable Mouseover Effect','ux'),
				  'description' => __('Turn on it to enable mouseover effect','ux'),
				  'type' => 'switch',
				  'name' => 'module_liquidlist_mouseover_effect',
				  'default' => 'on',
				  'control' => array(
					  'name' => 'module_liquidlist_style',
					  'value' => 'image'
				  )),
				  
			array('title' => __('Image Size','ux'),
				  'description' => __('Choose a size for the images under image style','ux'),
				  'type' => 'select',
				  'name' => 'module_liquidlist_image_size',
				  'default' => 'medium',
				  'control' => array(
					  'name' => 'module_liquidlist_style',
					  'value' => 'image'
				  )),
				  
			array('title' => __('Block Ratio','ux'),
				  'description' => __('The images come from featured image, a image larger than 600*600px would be recommended','ux'),
				  'type' => 'select',
				  'name' => 'module_liquidlist_image_ratio',
				  'default' => '3:2',
				  'control' => array(
					  'name' => 'module_liquidlist_style',
					  'value' => 'image'
				  )),
				  
			array('title' => __('Spacing Between Blocks','ux'),
				  'description' => __('The size of gaps between post blocks','ux'),
				  'type' => 'select',
				  'name' => 'module_liquidlist_image_spacing',
				  'default' => '20px'),
				  
			array('title' => __('Category','ux'),
				  'description' => __('The posts under the category you selected would be shown in this module','ux'),
				  'type' => 'category',
				  'name' => 'module_liquidlist_category',
				  'taxonomy' => 'category',
				  'default' => '0'),
				  
			array('title' => __('Order by','ux'),
				  'description' => __('Select sequence rules for the list','ux'),
				  'type' => 'orderby',
				  'name' => 'module_select_orderby',
				  'default' => 'date'),
				  
			array('title' => __('Pagination','ux'),
				  'description' => __('The "Twitter" option is to show a "Load More" button on the bottom of the list','ux'),
				  'type' => 'select',
				  'name' => 'module_liquidlist_pagination',
				  'default' => 'no'),
				  
			array('title' => __('Number per Page','ux'),
				  'description' => __('How many items should be displayed per page, leave it empty to show all items in one page','ux'),
				  'type' => 'text',
				  'name' => 'module_liquidlist_per_page'),
				  
			array('title' => __('Loading Block Color','ux'),
				  'description' => __('The panel color for the loading status after you click on it','ux'),
				  'type' => 'select',
				  'name' => 'module_liquidlist_loading_color',
				  'default' => 'featured_color',
				  'control' => array(
					  'name' => 'module_liquidlist_style',
					  'value' => 'image'
				  )),
				  
			array('title' => __('Expanded Block Width','ux'),
				  'description' => __('The width after a block is expanded','ux'),
				  'type' => 'select',
				  'name' => 'module_liquidlist_width',
				  'default' => '2'),
				  
			array('title' => __('Expanded Block Words Numbers','ux'),
				  'description' => __('How many descrptions should be showed for a expanded block','ux'),
				  'type' => 'text',
				  'name' => 'module_liquidlist_words'),
				  
			array('title' => __('Show Social Medias on Expanded Block','ux'),
				  'description' => __('Enable it to show Social Medias links on expanded block','ux'),
				  'type' => 'switch',
				  'name' => 'module_liquidlist_social_network',
				  'default' => 'off'),
				  
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
add_filter('ux_pb_module_fields', 'ux_pb_module_liquidlist_fields'); 
?>