<?php
$thumb_width = 650;
$thumb_height = 490;
$thumb_blank = get_template_directory_uri(). '/img/blank.gif';
$thumb_url = esc_url($thumb_blank);
$thumb_padding_top = false;

if(has_post_thumbnail()){    
	$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'arnold-standard-thumb');
	$thumb_width = $thumb[1];
	$thumb_height = $thumb[2];
	$thumb_url = esc_url($thumb[0]);
    if($thumb_height > 0 && $thumb_width > 0) {
        $thumb_padding_top = 'padding-top: ' . (intval($thumb_height) / intval($thumb_width)) * 100 . '%;'; 
    }
	
	$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');
	$image_lazyload_img_style = 'src="' .esc_url($thumb_blank). '" data-src="' .esc_url($thumb_url). '"';
	$image_lazyload_img_class = 'lazy';
	if(!$image_lazyload){
		$image_lazyload_img_style = 'src="' .esc_url($thumb_url). '"';
		$image_lazyload_img_class = '';
	} 
} ?>

<section class="grid-item grid-item-video">
				                    
    <div class="grid-item-inside">
         <a class="ux-lazyload-wrap" style=" <?php echo esc_attr($thumb_padding_top); ?>" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
            <span class="blog-unit-video-play" href="<?php the_permalink(); ?>"><span class="fa fa-play"></span></span>
            <div class="video-wrap hidden">
				<?php $video_embeded_code = arnold_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');
                if($video_embeded_code){
                    if(strstr($video_embeded_code, "youtu") && !(strstr($video_embeded_code, "iframe"))){ ?>
                        <iframe data-src="http://www.youtube.com/embed/<?php echo esc_attr(arnold_theme_get_youtube($video_embeded_code));?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent" width="1500" height="844" allowfullscreen=""></iframe>
                    <?php
                    }elseif(strstr($video_embeded_code, "vimeo") && !(strstr($video_embeded_code, "iframe"))){ ?>
                        <iframe data-src="http://player.vimeo.com/video/<?php echo esc_attr(arnold_theme_get_vimeo($video_embeded_code)); ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0" width="1500" allowfullscreen=""></iframe>
                    <?php	
                    }else{
                        echo balanceTags($video_embeded_code);
                    }
                } ?>
            </div>
            <?php if(has_post_thumbnail()){  ?>
            <img class="ux-lazyload-img <?php echo sanitize_html_class($image_lazyload_img_class); ?>" width="<?php echo esc_attr($thumb_width); ?>" height="<?php echo esc_attr($thumb_height); ?>" <?php echo balanceTags($image_lazyload_img_style); ?> alt="<?php the_title_attribute(); ?>"/>
            <?php } ?>
         </a>
         <div class="gird-blog">
            <?php arnold_interface_blog_show_meta('category', 'blog-masonry'); ?>
            <h2 class="gird-blog-tit"><a class="gird-blog-tit-a" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="gird-blog-meta">
                <?php arnold_interface_blog_show_meta('date', 'blog-masonry'); ?>
                <?php edit_post_link('(Edit)'); ?>
            </div>
            <?php if(has_excerpt()){ echo '<div class="gird-blog-excerpt">'. wp_trim_words(get_the_excerpt(), 20, '...').'</div>' ;} ?>
         </div>
    </div>

</section>