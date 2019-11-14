<?php
if(has_post_thumbnail()){
	$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
	$thumb_bg = $thumbnail[0];
}
$gallery_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_template'); 

$enable_title_masking = false;
if($gallery_template != 'standard'){
	$enable_title_masking = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_title_masking');
}

$enable_title_masking_class = $enable_title_masking && has_post_thumbnail() ? ' title-masking' : false;
$enable_title_masking_bgimg = $enable_title_masking && has_post_thumbnail() ? 'data-bg="'.esc_url($thumb_bg). '"' : false;

$fullscreen = $gallery_template =='big-title' ? ' fullscreen-wrap' : false;
$middle = $gallery_template =='big-title' ? ' middle-ux' : false;

?>

<div class="title-wrap<?php echo esc_attr($fullscreen); ?>">
  <div class="title-wrap-con<?php echo esc_attr($middle); ?>">
		<h1 class="title-wrap-tit<?php echo esc_attr($enable_title_masking_class); ?>" <?php echo balanceTags($enable_title_masking_bgimg); ?>><?php the_title(); ?></h1>
	</div>
</div>