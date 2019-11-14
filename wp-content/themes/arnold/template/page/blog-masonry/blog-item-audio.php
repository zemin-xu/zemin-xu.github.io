<section class="grid-item grid-item-audio">

    <div class="grid-item-inside">
        <?php
		$audio_type = arnold_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
		$audio_soundcloud = arnold_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');
		if($audio_type == 'soundcloud' && $audio_soundcloud){ ?>
        
            <div class="grid-iframe">
                <iframe width="100%" height="400" scrolling="no" frameborder="no" data-src="https://w.soundcloud.com/player/?url=<?php echo esc_url($audio_soundcloud); ?>&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>
            </div>
            
        <?php }else{
			$audio_artist = arnold_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
			$audio_mp3    = arnold_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
			$first_name   = $audio_mp3['name'][0];
			$first_url    = esc_url($audio_mp3['url'][0]); 
			
			$style = false;
			if(has_post_thumbnail()){    
				$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
				$style = 'background-image:url(' .esc_url($thumb[0]). ');';
			}
			
			if($audio_mp3){ ?>
			
				<div class="grid-audio-bar">					
					<ul class="audio_player_list blog-list-audio">
						<li class="audio-unit"><span id="audio-<?php echo get_the_ID() . '-0'; ?>" class="audiobutton pause" rel="<?php echo esc_url($first_url); ?>"></span><span class="songtitle" title="<?php echo esc_attr($first_name); ?>"><?php echo esc_html($first_name); ?></span></li>
					</ul>
		
				</div>
				
			<?php
			}
		} ?> 
        
        <div class="gird-blog">
        	<?php arnold_interface_blog_show_meta('category', 'blog-masonry'); ?>
            <h2 class="gird-blog-tit"><a class="gird-blog-tit-a" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php if(has_excerpt()){ echo '<div class="gird-blog-excerpt">'. wp_trim_words(get_the_excerpt(), 20, '...').'</div>' ;} ?>
            <div class="gird-blog-meta">
                <?php arnold_interface_blog_show_meta('date', 'blog-masonry'); ?> 
                <?php edit_post_link('(Edit)'); ?>  
            </div>
        </div>
    </div>

</section>