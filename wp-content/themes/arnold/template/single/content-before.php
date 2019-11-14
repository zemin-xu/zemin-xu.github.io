<?php
//** get sidebar meta
$sidebar = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar');

if(has_post_format('gallery')){
	$sidebar = 'without-sidebar';
}

$sidebar_class = $sidebar == 'without-sidebar' ? 'fullwrap-layout' : 'container two-cols-layout'; 
$layout_class = $sidebar == 'without-sidebar' ? 'fullwrap-layout-inn' : 'sidebar-layout row';

echo '<div class="content_wrap_outer ' .esc_attr($sidebar_class). '">';
echo '<div class="' .esc_attr($layout_class). '">';