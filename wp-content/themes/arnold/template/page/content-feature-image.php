<?php
if(is_page()){
	$switch = false;
	$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
	$show_featured_image = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_featured_image');
	$cover_height = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_featured_image_height');
	$cover_height_class = $cover_height == 'screen-height' ? ' fullscreen-wrap' : ' post-cover-400';
	
	if($page_template == 'none'){
		$switch = true;
	}
	
	if($switch && $show_featured_image){
		$thumb_bg = '';
		if(has_post_thumbnail()){
			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
			$thumb_bg = $thumbnail[0];
		}
				
		$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');
		$image_lazyload_style = 'data-bg="' .esc_url($thumb_bg). '"';
		$image_lazyload_class = 'ux-lazyload-bgimg';
		if(!$image_lazyload){
			$image_lazyload_style = 'style="background-image:url(' .esc_url($thumb_bg). ');"';
			//$image_lazyload_class = '';
		}
		echo '<div class="post-cover ux-lazyload-wrap'.esc_attr($cover_height_class).'"><div class="' .sanitize_html_class($image_lazyload_class). ' ux-background-img" ' .balanceTags($image_lazyload_style). '></div></div>';
	}
}
?>