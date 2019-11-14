<?php
$gallery_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_template');

//If set Password 
if(post_password_required()){
	echo '<div class="container ux-password-form">'.get_the_password_form().'</div>';
	return;
} else { 

if($gallery_template == 'slider'){
	//Slider
	arnold_get_template_part('single/gallery/portfolio', 'slider');
}

if($gallery_template == 'fullscreen'){
	//Fullscreen
	arnold_get_template_part('single/gallery/portfolio', 'fullscreen');
}

//Title
if($gallery_template == 'big-title'){

	arnold_get_template_part('single/gallery/portfolio', 'title');
}

if($gallery_template != 'big-title'){
	//Content
	arnold_get_template_part('single/gallery/portfolio', 'content');
}

$enable_template = true;
if($gallery_template == 'slider' || $gallery_template == 'fullscreen'){
	$enable_template = false;
}

if($enable_template){
	//Images
	arnold_get_template_part('single/gallery/portfolio', 'template');
}

if($gallery_template == 'big-title'){
	//Content
	arnold_get_template_part('single/gallery/portfolio', 'content');
}

//Gallery Link
arnold_get_template_part('single/gallery/portfolio', 'link');

//Social
arnold_get_template_part('single/gallery/portfolio', 'social');

//Shopping
$arnold_enable_shopping = arnold_get_post_meta(get_the_ID(), 'theme_meta_enable_shopping_function');
if($arnold_enable_shopping){
	arnold_get_template_part('single/gallery/portfolio', 'shopping');
}

//Navi
$arnold_enable_navi = arnold_get_option('theme_option_show_post_navigation');
if($arnold_enable_navi){
	arnold_get_template_part('single/gallery/portfolio', 'navi');
}

}//End if set password
?>