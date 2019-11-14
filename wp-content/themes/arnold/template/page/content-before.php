<?php
//** get sidebar meta
$sidebar = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
$sidebar_class = $sidebar == 'without-sidebar' ? 'fullwrap-layout' : 'container two-cols-layout'; 
//$layout_class  = $sidebar == 'without-sidebar' ? 'fullwrap-layout-inn' : 'container-fluid row';

$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
if($page_template != 'none' && $page_template != 'blog-masonry'){
	$sidebar_class = 'fullwrap-layout';
}

?>
<div class="content_wrap_outer <?php echo esc_attr($sidebar_class); ?>">
<?php /*?><div class="<?php echo esc_attr($layout_class); ?>"><?php */?>