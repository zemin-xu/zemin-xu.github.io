<?php
$thumb_width = 650;
$thumb_height = 490;
$thumb_blank = get_template_directory_uri(). '/img/blank.gif';
$thumb_url = $thumb_blank;

if(has_post_thumbnail()){    
	$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
	$thumb_width = $thumb[1];
	$thumb_height = $thumb[2];
	$thumb_url = $thumb[0];
    if($thumb_height > 0 && $thumb_width > 0) {
        $thumb_padding_top = 'padding-top: ' . (intval($thumb_height) / intval($thumb_width)) * 100 . '%;'; 
    }
}

$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');
$image_lazyload_img_style = 'src="' .esc_url($thumb_blank). '" data-src="' .esc_url($thumb_url). '"';
$image_lazyload_img_class = 'lazy';
if(!$image_lazyload){
	$image_lazyload_img_style = 'src="' .esc_url($thumb_url). '"';
	$image_lazyload_img_class = '';
}
?>

<section class="archive-item">
    <?php if(has_post_thumbnail()){ ?>
    <a class="ux-lazyload-wrap" style=" <?php echo esc_attr($thumb_padding_top); ?>" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
        <img class="ux-lazyload-img <?php echo sanitize_html_class($image_lazyload_img_class); ?>" width="<?php echo esc_attr($thumb_width); ?>" height="<?php echo esc_attr($thumb_height); ?>" <?php echo balanceTags($image_lazyload_img_style); ?> alt="<?php the_title_attribute(); ?>"/>
    </a>
    <?php } ?>
    <h2 class="arvhive-tit"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php if(has_excerpt()){ echo '<div class="arvhive-excerpt">'. wp_trim_words(get_the_excerpt(), 20, '...').'</div>' ;} ?>
    <div class="archive-meta clearfix">
        <?php arnold_get_template_part('single/content', 'meta'); ?>
        <?php arnold_get_template_part('archive/readmore', false); ?>
    </div>
</section>