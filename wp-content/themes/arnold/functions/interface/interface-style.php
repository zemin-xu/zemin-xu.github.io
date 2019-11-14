<?php
 
//Function theme custom css
function arnold_theme_custom_css(){
	$custom_css = '';
	
	///////////////////////// Global Color 
	
	//Highlight Color
	$arnold_color_theme_main = arnold_get_option('theme_option_color_theme_main') ? esc_attr(arnold_get_option('theme_option_color_theme_main')) : '#5179FC';
	$arnold_color_menu_hover = arnold_get_option('theme_option_menu_hover');
	if($arnold_color_theme_main){
		$custom_css .= '
a,  #header .search-top-btn-class:hover,#header .wpml-translation li a:hover,#header .wpml-translation li .current-language, .current-language .languages-shortname,.comment-form .logged a:hover,.article-cate-a, 
.count-box,.social-like .wpulike .counter a.image:before,.post-meta-social .count, .height-light-ux,.post-categories a,.widget_archive li,.widget_categories li,.widget_nav_menu li,.widget_pages li,
a:hover,.entry p a,.sidebar_widget a:hover, .archive-tit a:hover,.text_block a,.post_meta > li a:hover, #sidebar a:hover, #comments .comment-author a:hover,#comments .reply a:hover,.fourofour-wrap a,.archive-meta-unit a:hover,.post-meta-unit a:hover, .heighlight,.archive-meta-item a,.author-name,
.carousel-wrap a:hover, .related-post-wrap h3:hover a, .iconbox-a .iconbox-h3:hover,.iconbox-a:hover,.iocnbox:hover .icon_wrap i.fa,.blog-masony-item .item-link:hover:before,.clients_wrap .carousel-btn .carousel-btn-a:hover:before,
.blog_meta a:hover,.breadcrumbs a:hover,.link-wrap a:hover,.archive-wrap h3 a:hover,.more-link:hover,.post-color-default,.latest-posts-tags a:hover,.pagenums .current,.page-numbers.current,.fullwidth-text-white .fullwrap-with-tab-nav-a:hover,.fullwrap-with-tab-nav-a:hover,.fullwrap-with-tab-nav-a.full-nav-actived,.fullwidth-text-white .fullwrap-with-tab-nav-a.full-nav-actived,a.liquid-more-icon.ux-btn:hover,.moudle .iterblock-more.ux-btn:hover,
body.single .gallery-info-property-con a, .grid-meta-a
{ 
	color: '.esc_attr($arnold_color_theme_main).'; 
}

.tagcloud a:hover,.related-post-wrap h3:before,.single-image-mask,input.idi_send:hover, .iconbox-content-hide .icon_text,.process-bar, .portfolio-caroufredsel-hover
{ 
	background-color: '.esc_attr($arnold_color_theme_main).';
}
		';
		if(class_exists('Woocommerce')){
			$custom_css .= '
body.single-product .woocommerce-Price-amount,.woocommerce-MyAccount-navigation-link.is-active a,.woocommerce-MyAccount-navigation-link:hover a { 
	color: '.esc_attr($arnold_color_theme_main).'; 
}
.woocommerce span.onsale, .woocommerce-page span.onsale,.woocomerce-cart-number {
	background-color: '.esc_attr($arnold_color_theme_main).';
}
			';
		}
		if($arnold_color_menu_hover == 'menu_hover_highlight') {
			$custom_css .= '
.menu-item > a:after, .socialmeida-a .socialmeida-text:after, .portfolio-link-button-a:after, .archive-more-a:after, .gallery-link-a:after {
	display:none;
}
.menu-item > a:hover, .menu-item > a:focus, .socialmeida-a:hover .socialmeida-text, .socialmeida-a:focus .socialmeida-text, .portfolio-link-button-a:hover,
.portfolio-link-button-a:focus, .archive-more-a:hover, .archive-more-a:focus, .gallery-link-a:focus, .gallery-link-a:hover {
	color: '.esc_attr($arnold_color_theme_main).'; 
}
			';
		}
		

	}

	// Auxiliary Color
	$ux_color_second_auxiliary = arnold_get_option('theme_option_color_second_auxiliary') ? esc_attr(arnold_get_option('theme_option_color_second_auxiliary')) : '#f8f8f8';
	if($ux_color_second_auxiliary){   
		$custom_css .= '
.tagcloud a,.gallery-list-contiune, .author-unit-inn, .archive-bar,.blog-unit-link-li,.audio-unit,.slider-panel,#main_title_wrap, .promote-wrap,.process-bar-wrap,.post_meta,.pagenumber a,.standard-blog-link-wrap,.blog-item.quote,.portfolio-standatd-tit-wrap:before,.quote-wrap,.entry pre,.text_block pre,.isotope-item.quote .blog-masony-item,.blog-masony-item .item-link-wrap,.pagenumber span,.testimenials,.testimenials .arrow-bg,.accordion-heading,.testimonial-thum-bg,.single-feild,.fullwidth-text-white .iconbox-content-hide .icon_wrap
{ 
	background-color: '.esc_attr($ux_color_second_auxiliary).'; 
}
.progress_bars_with_image_content .bar .bar_noactive.grey,.audio-unit span.audiobutton.pause:hover:before
{
  color: '.esc_attr($ux_color_second_auxiliary).'; 
}
body.archive #wrap,.widget_archive li,.widget_categories li,.widget_nav_menu li,.widget_pages li,.widget_recent_entries li,.widget_recent_comments li,.widget_meta li,.widget_rss li,
.nav-tabs,.border-style2,.border-style3,.nav-tabs > li > a,.tab-content,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tabs-v,.single-feild,.archive-unit
{ 
	border-color: '.esc_attr($ux_color_second_auxiliary).'; 
} 
.tab-content.tab-content-v,blockquote
{
	border-left-color: '.esc_attr($ux_color_second_auxiliary).'; 
} 
.tabs-v .nav-tabs > .active > a,.line_grey
{
	border-top-color: '.esc_attr($ux_color_second_auxiliary).'; 
}
		';
	}

	// Page Body BG Color
	$arnold_bg_page_post = arnold_get_option('theme_option_bg_page_post') ? esc_attr(arnold_get_option('theme_option_bg_page_post')) : '#fff';
	if($arnold_bg_page_post){
		$custom_css .= '
body,#wrap-outer,#wrap,#search-overlay,#top-wrap,#main,.separator h4, .carousel-control,#login-form.modal .modal-dialog,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus,.tab-content,.filters.filter-floating li a:before,.standard-list-item:hover .portfolio-standatd-tit-wrap:before,.ux-mobile #main-navi-inn,.grid-item-con-text-show 
{ 
	background-color: '.esc_attr($arnold_bg_page_post).';
}
.testimenials span.arrow,.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus { 
	border-bottom-color: '.esc_attr($arnold_bg_page_post).'; 
}
	.tabs-v .nav-tabs > .active > a
{ 
	border-right-color: '.esc_attr($arnold_bg_page_post).'; 
}
button:hover, input[type="submit"]:hover,.ux-btn:hover,.quote-wrap, .mouse-icon,.social-icon-triggle,.carousel-control, .countdown_amount,.countdown_section,.blog-unit-link-li:hover,.blog-unit-link-li:hover a 
{
	color: '.esc_attr($arnold_bg_page_post).'; 
}
		';
	}

	//Header BGcolor
	$arnold_header_bg = arnold_get_option('theme_option_bg_header') ? esc_attr(arnold_get_option('theme_option_bg_header')) : '#fff';
	if($arnold_header_bg){
		$custom_css .= '
#header,#menu-panel,.page_from_top.header-scrolled #header,.navi-show-h #navi-header .sub-menu
{ 
	background-color: '.esc_attr($arnold_header_bg).';
}
		';
	}

	//Page loader BGcolor
	$arnold_bg_page_loader = arnold_get_option('theme_option_bg_page_loader') ? esc_attr(arnold_get_option('theme_option_bg_page_loader')) : '#fff';
	if($arnold_bg_page_loader){
		$custom_css .= '
.page-loading
{ 
	background-color: '.esc_attr($arnold_bg_page_loader).';
}
		';
	}

	//Selected Text Bg Color
	$arnold_color_selected_text_bg = arnold_get_option('theme_option_color_selected_text_bg') ? esc_attr(arnold_get_option('theme_option_color_selected_text_bg')) : false;
	if($arnold_color_selected_text_bg){
		$custom_css .= '
::selection { background: '.esc_attr($arnold_color_selected_text_bg).'; }
::-moz-selection { background: '.esc_attr($arnold_color_selected_text_bg).'; }
::-webkit-selection { background: '.esc_attr($arnold_color_selected_text_bg).'; }
		';
	}

	///////////////////////// Text Logo 

	//Text Logo Color Dark (default)
	$arnold_color_text_logo = arnold_get_option('theme_option_color_logo') ? esc_attr(arnold_get_option('theme_option_color_logo')) : '#313139';
	if($arnold_color_text_logo){
		$custom_css .= '
.logo-h1 
{
	color: '.esc_attr($arnold_color_text_logo).'; 
}
		';
	}

	//Logo Text Color Light
	$arnold_color_text_logo_light = arnold_get_option('theme_option_logo_text_color_light') ? esc_attr(arnold_get_option('theme_option_logo_text_color_light')) : '#ffffff';
	if($arnold_color_text_logo_light){
		$custom_css .= '
.light-logo .logo-h1,.default-light-logo .logo-h1
{
	color: '.esc_attr($arnold_color_text_logo_light).'; 
}
		';
	}

	///////////////////////// Menu Color

	//Menu on Header Dark
	$arnold_color_text_menu_icon = arnold_get_option('theme_option_menu_icon_dark') ? esc_attr(arnold_get_option('theme_option_menu_icon_dark')) : '#313139';
	if($arnold_color_text_menu_icon ){
		$custom_css .= '
#navi-trigger,#header .socialmeida-a, #navi_wrap > ul > li > a,
.light-logo.header-scrolled #navi-trigger, 
.light-logo.header-scrolled #header .socialmeida-a, 
.light-logo.header-scrolled #navi_wrap > ul > li > a,
.bm-tab-slider-trigger-item .bm-tab-slider-trigger-tilte,
.top-slider .carousel-des a,
.top-slider .owl-dot
{
	color: '.esc_attr($arnold_color_text_menu_icon ).'; 
}	
		';
	}

	//Menu on Header Light
	$arnold_color_text_logo_menu_icon_light = arnold_get_option('theme_option_menu_icon_light') ? esc_attr(arnold_get_option('theme_option_menu_icon_light')) : '#ffffff';
	if($arnold_color_text_logo_menu_icon_light ){
		$custom_css .= '
.light-logo #navi-trigger, 
.light-logo #header .socialmeida-a, 
.light-logo #navi_wrap > ul > li > a,
.light-logo #navi_wrap > ul > li.menu-level1 > ul > li > a, 
.light-logo.single-portfolio-fullscreen-slider .blog-unit-gallery-wrap .arrow-item, 
.light-logo #ux-slider-down,  
.light-logo.single-portfolio-fullscreen-slider .owl-dots,
.light-logo .bm-tab-slider-trigger-item .bm-tab-slider-trigger-tilte,
.light-logo .top-slider .carousel-des a,
.light-logo .top-slider .owl-dot
{
	color: '.esc_attr($arnold_color_text_logo_menu_icon_light).'; 
}	
		';
	}
	
	///////////////////////// Posts & Pages Color
	
	// Title color 
	$theme_option_color_heading = arnold_get_option('theme_option_color_heading') ? esc_attr(arnold_get_option('theme_option_color_heading')) : '#313139';
	if($theme_option_color_heading){
		$custom_css .= '
.title-wrap-tit,.title-wrap-h1,h1,h2,h3,h4,h5,h6,.archive-tit a, .item-title-a,#sidebar .social_active i:hover,.article-cate-a:hover:after,
.portfolio-standatd-tags a[rel="tag"]:hover:after,.nav-tabs > .active > a, .nav-tabs > li > a:hover, .nav-tabs > .active > a:focus, .post-navi-a,.moudle .ux-btn,.mainlist-meta, .mainlist-meta a,carousel-des-wrap-tit-a,
.jqbar.vertical span,.team-item-con-back a,.team-item-con-back i,.team-item-con-h p,.slider-panel-item h2.slider-title a,.bignumber-item.post-color-default,.blog-item .date-block,.iterlock-caption-tit-a,
.clients_wrap .carousel-btn .carousel-btn-a, .image3-1-unit-tit
{ 
	color:'.esc_attr($theme_option_color_heading).'; 
}
.post_social:before, .post_social:after,.title-ux.line_under_over,.gallery-wrap-sidebar .entry, .social-share 
{ 
	border-color: '.esc_attr($theme_option_color_heading).'; 
} 
.team-item-con,.ux-btn:before,.title-ux.line_both_sides:before,.title-ux.line_both_sides:after,.galleria-info,#float-bar-triggler,.float-bar-inn,.short_line:after, 
.separator_inn.bg- ,.countdown_section 
{
	background-color: '.esc_attr($theme_option_color_heading).';
}
		';
	}
	
	// Content text Color 
	$arnold_color_content = arnold_get_option('theme_option_color_content_text') ? esc_attr(arnold_get_option('theme_option_color_content_text')) : '#414145';
	if($arnold_color_content){
		$custom_css .= '
			
body,a,.entry p a:hover,.text_block, .article-tag-label a[rel="tag"]:after,.article-meta-unit-cate > a.article-cate-a:after,.article-cate-a:hover,.text_block a:hover,#content_wrap,#comments,.blog-item-excerpt,.archive-unit-excerpt,.archive-meta-item a:hover,.entry code,.text_block code,
h3#reply-title small, #comments .nav-tabs li.active h3#reply-title .logged,#comments .nav-tabs li a:hover h3 .logged,.testimonial-thum-bg i.fa,
.header-info-mobile,.carousel-wrap a.disabled:hover,.stars a:hover,.moudle .iterblock-more.ux-btn,.moudle .liquid-more-icon.ux-btn,.fullwrap-block-inn a,
textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input
{
	color: '.esc_attr($arnold_color_content).'; 
}
.blog-unit-link-li:hover,.audio-unit span.audiobutton:hover {
	background-color: '.esc_attr($arnold_color_content).'; 
}
			
		';
	}
	
	//Meta text Color 
	$arnold_color_auxiliary_content = arnold_get_option('theme_option_color_auxiliary_content') ? esc_attr(arnold_get_option('theme_option_color_auxiliary_content')) : '#adadad';
	if($arnold_color_auxiliary_content){
		$custom_css .= '
.article-meta-unit,.article-meta-unit:not(.article-meta-unit-cate) > a,.article-tag-label-tit, .comment-meta,.comment-meta a,.title-wrap-des,.blog_meta_cate,.blog_meta_cate a,.gird-blog-meta,.grid-meta-a:after
{ 
	color:'.esc_attr($arnold_color_auxiliary_content).'; 
}
.comment-author:after {
	background-color: '.esc_attr($arnold_color_auxiliary_content).'; 
}
.blog-item-more-a:hover,.audio-unit
{
	border-color: '.esc_attr($arnold_color_auxiliary_content).'; 
}
		';
		if(class_exists('Woocommerce')){
$custom_css .= '.woocommerce .price del, .woocommerce .price del .woocommerce-Price-amount,.woocommerce-account .addresses .title .edit {
	color:'.esc_attr($arnold_color_auxiliary_content).'; 
}';
		}

	} 

	// Gallery Post Property Title
	$arnold_color_property_tit = arnold_get_option('theme_option_color_property_tit') ? esc_attr(arnold_get_option('theme_option_color_property_tit')) : '#313139';
	if($arnold_color_property_tit){
		$custom_css .= '
.gallery-info-property-tit 
{ 
	color: '.esc_attr($arnold_color_property_tit).';
}
		';
	}

	// Gallery Post Property Content
	$arnold_color_property_con = arnold_get_option('theme_option_color_property_con') ? esc_attr(arnold_get_option('theme_option_color_property_con')) : '#313139';
	if($arnold_color_property_con){
		$custom_css .= '
.gallery-info-property-con,.grid-list .gallery-info-property-con a,.gallery-info-property-con a:hover 
{ 
	color: '.esc_attr($arnold_color_property_con).';
}
		';
	}

	// Gallery Post Link Button
	$arnold_color_gallery_link = arnold_get_option('theme_option_color_gallery_link') ? esc_attr(arnold_get_option('theme_option_color_gallery_link')) : '#313139';
	if($arnold_color_gallery_link){
		$custom_css .= '
.gallery-link-a 
{ 
	color: '.esc_attr($arnold_color_gallery_link).';
}
		';
	}

	// Prev & Next
	$arnold_color_post_navi = arnold_get_option('theme_option_color_post_navi') ? esc_attr(arnold_get_option('theme_option_color_post_navi')) : '#313139';
	if($arnold_color_post_navi){
		$custom_css .= '
.post-navi-single, .arrow-item 
{ 
	color: '.esc_attr($arnold_color_post_navi).';
}
		';
	}

	// Comment Title
	$arnold_color_comment_tit = arnold_get_option('theme_option_color_comment_tit') ? esc_attr(arnold_get_option('theme_option_color_comment_tit')) : false;
	if($arnold_color_comment_tit){
		$custom_css .= '
.comment-box-tit,.comm-reply-title 
{ 
	color: '.esc_attr($arnold_color_comment_tit).';
}
		';
	}

	// Comment Content
	$arnold_color_comment_con = arnold_get_option('theme_option_color_comment_con') ? esc_attr(arnold_get_option('theme_option_color_comment_con')) : false;
	if($arnold_color_comment_con){
		$custom_css .= '
.comm-u-wrap 
{ 
	color: '.esc_attr($arnold_color_comment_con).';
}
		';
	}

	// Comment Author
	$arnold_color_comment_author = arnold_get_option('theme_option_color_comment_author') ? esc_attr(arnold_get_option('theme_option_color_comment_author')) : false;
	if($arnold_color_comment_author){
		$custom_css .= '
.comment-meta .comment-author,.comment-meta .comment-author-a 
{ 
	color: '.esc_attr($arnold_color_comment_author).';
}
		';
	}

	///////////////////////// Portfolio List Color

	// Load More Color
	$arnold_color_loadmore = arnold_get_option('theme_option_color_loadmore') ? esc_attr(arnold_get_option('theme_option_color_loadmore')) : false;
	if($arnold_color_loadmore){
		$custom_css .= '
.tw-style-a.ux-btn
{ 
	color: '.esc_attr($arnold_color_loadmore).';
}
		';
	}

	// Title for Item
	$arnold_color_list_item_tit = arnold_get_option('theme_option_color_list_item_tit') ? esc_attr(arnold_get_option('theme_option_color_list_item_tit')) : false;
	if($arnold_color_list_item_tit){
		$custom_css .= '
.grid-item-tit,.grid-item-tit-a:hover,.grid-item-tit-a
{ 
	color: '.esc_attr($arnold_color_list_item_tit).';
}
		';
	}

	// Tag for Item
	$arnold_color_list_item_tag = arnold_get_option('theme_option_color_list_item_tag') ? esc_attr(arnold_get_option('theme_option_color_list_item_tag')) : false;
	if($arnold_color_list_item_tag){
		$custom_css .= '
.grid-item-cate-a,.article-cate-a
{ 
 	color: '.esc_attr($arnold_color_list_item_tag).';
}
		';
	}

	// Mask for Item
	$arnold_color_list_item_mask = arnold_get_option('theme_option_color_list_item_mask') ? esc_attr(arnold_get_option('theme_option_color_list_item_mask')) : false;
	if($arnold_color_list_item_mask){
		$custom_css .= '
.grid-item-con:after,.product-caption 
{ 
	background-color: '.esc_attr($arnold_color_list_item_mask).';
}
		';
	}


	///////////////////////// Button Color
	// Button Text & Border Color
	$arnold_color_button = arnold_get_option('theme_option_color_button') ? esc_attr(arnold_get_option('theme_option_color_button')) : false;
	if($arnold_color_button){
		$custom_css .= '
.ux-btn, button, input[type="submit"] 
{ 
	color: '.esc_attr($arnold_color_button).';
}
		';
	}

	// Button Text Mouseover Color
	$arnold_color_button_mouseover = arnold_get_option('theme_option_color_button_mouseover') ? esc_attr(arnold_get_option('theme_option_color_button_mouseover')) : '#ffffff';
	if($arnold_color_button_mouseover){
		$custom_css .= '
.ux-btn:hover,button:hover, input[type="submit"]:hover,.moudle .ux-btn.tw-style-a:hover,.moudle .ux-btn:before
{ 
	color: '.esc_attr($arnold_color_button_mouseover).';
}
		';
	}

	// Button BG Mouseover Color
	$arnold_color_button_bg_mouseover = arnold_get_option('theme_option_color_button_bg_mouseover') ? esc_attr(arnold_get_option('theme_option_color_button_bg_mouseover')) : '#313139';
	if($arnold_color_button_bg_mouseover){
		$custom_css .= '
.ux-btn:hover,button:hover, input[type="submit"]:hover
{ 
	background-color: '.esc_attr($arnold_color_button_bg_mouseover).'; border-color: '.esc_attr($arnold_color_button_bg_mouseover).';
}
		';
	}


	///////////////////////// Form Color
	// Text Input Box by Default
	$arnold_color_form = arnold_get_option('theme_option_color_form') ? esc_attr(arnold_get_option('theme_option_color_form')) : '#adadad';
	if($arnold_color_form){
		$custom_css .= '
textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input 
{ 
	border-color: '.esc_attr($arnold_color_form).';
}
		';
	}

	// Text Input Box Focused
	$arnold_color_form_focused = arnold_get_option('theme_option_color_form_focused') ? esc_attr(arnold_get_option('theme_option_color_form_focused')) : '#313139';
	if($arnold_color_form_focused){
		$custom_css .= '
.moudle input[type="text"]:focus, .moudle textarea:focus, input:focus:invalid:focus, textarea:focus:invalid:focus, select:focus:invalid:focus, textarea:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus, .uneditable-input:focus,
.comment-reply-title:hover
{ 
	color: '.esc_attr($arnold_color_form_focused).'; border-color: '.esc_attr($arnold_color_form_focused).';
}
		';
	}


	///////////////////////// Widget
	// Widget Title Text Color
	$arnold_color_widget_title = arnold_get_option('theme_option_color_widget_title') ? esc_attr(arnold_get_option('theme_option_color_widget_title')) : '#313139';
	if($arnold_color_widget_title){
		$custom_css .= '
.widget-container .widget-title, .widget-container .widget-title a 
{ 
	color: '.esc_attr($arnold_color_widget_title).';
}
		';
	} 
	
	// Widget content Text Color
	$arnold_color_widget_con_color = arnold_get_option('theme_option_color_widget_content_color') ? esc_attr(arnold_get_option('theme_option_color_widget_content_color')) : '#606066';
	if($arnold_color_widget_con_color){
		$custom_css .= '
.widget-container,.widget-container a 
{ 
	color: '.esc_attr($arnold_color_widget_con_color).';
}
		';
	}

	// Sidebar Widget Title Text Color
	$arnold_color_widget_title_sidebar = arnold_get_option('theme_option_color_widget_title_sidebar') ? esc_attr(arnold_get_option('theme_option_color_widget_title_sidebar')) : false;
	if($arnold_color_widget_title_sidebar){
		$custom_css .= '
.sidebar_widget .widget-container .widget-title,.sidebar_widget .widget-container .widget-title a
{ 
	color: '.esc_attr($arnold_color_widget_title_sidebar).';
}
		';
	}

	// Sidebar Widget Title Bg Color
	$arnold_color_widget_title_bg = arnold_get_option('theme_option_color_widget_title_bg') ? esc_attr(arnold_get_option('theme_option_color_widget_title_bg')) : false;
	if($arnold_color_widget_title_bg){
		$custom_css .= '
.sidebar_widget .widget-title 
{ 
	background-color: '.esc_attr($arnold_color_widget_title_bg).';
}
		';
	}


	//Footer
	//Footer Text Color
	$arnold_color_footer_text = arnold_get_option('theme_option_footer_text_color') ? esc_attr(arnold_get_option('theme_option_footer_text_color')) : false;
	if($arnold_color_footer_text){
		$custom_css .= '
.copyright, .copyright a,.footer-info,.footer-info a,#footer .logo-h1,.footer-info .socialmeida-a 
{ 
	color: '.esc_attr($arnold_color_footer_text).'; 
}
		';
	}
	
	//Footer bg Color
	$arnold_color_footer_bg = arnold_get_option('theme_option_footer_bg_color') ? esc_attr(arnold_get_option('theme_option_footer_bg_color')) : false;
	if($arnold_color_footer_bg){
		$custom_css .= '
#footer 
{
	background-color: '.esc_attr($arnold_color_footer_bg).'; 
}
		';
	}
	
	//## FONT ########################################################################################

	//////////////////////// LOGO
	// logo font Header
	$arnold_logo_font = arnold_get_option('theme_option_font_family_logo');
	$arnold_logo_font = $arnold_logo_font != -1 ? $arnold_logo_font : false;
	if($arnold_logo_font){
		$arnold_logo_font = str_replace('+', ' ', $arnold_logo_font);
		$custom_css .= '
.logo-h1 { font-family: '.esc_attr($arnold_logo_font).'; }
		';
	}
	//logo size
	$arnold_logo_font_size = arnold_get_option('theme_option_font_size_logo');
	if($arnold_logo_font_size && $arnold_logo_font_size!='Select'){
		$custom_css .= '
.logo-h1 { font-size: '.esc_attr($arnold_logo_font_size).';}
		';
	}
	//logo style
	$arnold_logo_font_style = arnold_get_option('theme_option_font_style_logo');
	if($arnold_logo_font_style){
		$custom_css .= '
.logo-h1 { '.esc_attr(arnold_theme_google_font_style($arnold_logo_font_style)).'}
		';
	}

	// logo font Footer
	$arnold_logo_font_footer = arnold_get_option('theme_option_font_family_logo_footer');
	$arnold_logo_font_footer = $arnold_logo_font_footer != -1 ? $arnold_logo_font_footer : false;
	if($arnold_logo_font_footer){
		$arnold_logo_font_footer = str_replace('+', ' ', $arnold_logo_font_footer);
		$custom_css .= '
#logo-footer .logo-h1 { font-family: '.esc_attr($arnold_logo_font_footer).'; }
		';
	}
	//logo size_footer
	$arnold_logo_font_footer_size = arnold_get_option('theme_option_font_size_logo_footer');
	if($arnold_logo_font_footer_size && $arnold_logo_font_footer_size!='Select'){
		$custom_css .= '
#logo-footer .logo-h1 { font-size: '.esc_attr($arnold_logo_font_footer_size).';}
		';
	}
	//logo style
	$arnold_logo_font_footer_style = arnold_get_option('theme_option_font_style_logo_footer');
	if($arnold_logo_font_footer_style){
		$custom_css .= '
#logo-footer .logo-h1 { '.esc_attr(arnold_theme_google_font_style($arnold_logo_font_footer_style)).'}
		';
	}

	//////////////////////// MENU 
	//Menu on Header font
	$arnold_menu_header_font = arnold_get_option('theme_option_font_family_menu_header');
	$arnold_menu_header_font = $arnold_menu_header_font != -1 ? $arnold_menu_header_font : false;
	if($arnold_menu_header_font){
		$arnold_menu_header_font = str_replace('+', ' ', $arnold_menu_header_font);
		$custom_css .= '
.navi-trigger-text, #navi-header a,.header-bar-social .socialmeida-a { font-family: '.esc_attr($arnold_menu_header_font).'; }
		';
	}
	//Menu on Header size
	$arnold_menu_header_size = arnold_get_option('theme_option_font_size_menu_header');
	if($arnold_menu_header_size && $arnold_menu_header_size!='Select'){
		$custom_css .= '
.navi-trigger-text, #navi-header a,.header-bar-social .socialmeida-a { font-size: '.esc_attr($arnold_menu_header_size).';}
		';
	}
	//Menu on Header style
	$arnold_menu_header_style = arnold_get_option('theme_option_font_style_menu_header');
	if($arnold_menu_header_style){
		$custom_css .= '
.navi-trigger-text, #navi-header a,.header-bar-social .socialmeida-a { '.esc_attr(arnold_theme_google_font_style($arnold_menu_header_style)).'}
		';
	}

	//Menu Line Height
	$arnold_menu_line_height = arnold_get_option('theme_option_menu_line_height');
	$arnold_menu_layout = arnold_get_option('theme_option_header_layout');

	if($arnold_menu_layout == 'columned-menu-right' && $arnold_menu_line_height ) {
		$custom_css .= '
.navi-show-v #navi-header>div>ul>li,.navi-show-v .header-bar-social .socialmeida-li { line-height:'.esc_attr($arnold_menu_line_height).'; }
		';
	}

	//Menu on expanded font
	$arnold_menu_expanded_font = arnold_get_option('theme_option_font_family_menu_expanded');
	$arnold_menu_expanded_font = $arnold_menu_expanded_font != -1 ? $arnold_menu_expanded_font : false;
	if($arnold_menu_expanded_font){
		$arnold_menu_expanded_font = str_replace('+', ' ', $arnold_menu_expanded_font);
		$custom_css .= '
#navi a { font-family: '.esc_attr($arnold_menu_expanded_font).'; }
		';
	}

	//Menu on expanded size
	$arnold_menu_expanded_size = arnold_get_option('theme_option_font_size_menu_expanded') ? arnold_get_option('theme_option_font_size_menu_expanded') : '30px';
	if($arnold_menu_expanded_size && $arnold_menu_expanded_size!='Select'){
		$custom_css .= '
#navi a { font-size: '.esc_attr($arnold_menu_expanded_size).';}
		';
	}
	//Menu on expanded style
	$arnold_menu_expanded_style = arnold_get_option('theme_option_font_style_menu_expanded');
	if($arnold_menu_expanded_style){
		$custom_css .= '
#navi a { '.esc_attr(arnold_theme_google_font_style($arnold_menu_expanded_style)).'}
		';
	}

	//////////////////////// POST & PAGE
	//Post & page Title font
	$arnold_post_page_title_font = arnold_get_option('theme_option_font_post_page_title');
	$arnold_post_page_title_font = $arnold_post_page_title_font != -1 ? $arnold_post_page_title_font : false;
	if($arnold_post_page_title_font){
		$arnold_post_page_title_font = str_replace('+', ' ', $arnold_post_page_title_font);
		$custom_css .= '
body.single .title-wrap-tit,.title-wrap-h1, .archive-grid-item-tit,.title-wrap-meta-a,.archive-grid-item-meta-item,h1,h2,h3,h4,h5,h6
{ 
	font-family: '.esc_attr($arnold_post_page_title_font).';
}
		';
	}
	//Post & page Title stlye
	$arnold_post_page_title_font_style = arnold_get_option('theme_option_font_style_post_page_title');
	if($arnold_post_page_title_font_style){
		$custom_css .= '
body.single .title-wrap-tit,.title-wrap-h1, .archive-grid-item-tit,.title-wrap-meta-a,.archive-grid-item-meta-item,h1,h2,h3,h4,h5,h6
{ 
'	.esc_attr(arnold_theme_google_font_style($arnold_post_page_title_font_style)).'
}
		';
	}
	//Post & page Title size
	$arnold_post_page_title_font_size = arnold_get_option('theme_option_font_size_post_page_title');
	if($arnold_post_page_title_font_size && $arnold_post_page_title_font_size !='Select' ){
		$custom_css .= '
body.single .title-wrap-tit,.title-wrap-h1 { font-size: '.esc_attr($arnold_post_page_title_font_size).';}
		';
	}

	//Post & page content font
	$arnold_post_page_content_font = arnold_get_option('theme_option_font_post_page_content');
	$arnold_post_page_content_font = $arnold_post_page_content_font != -1 ? $arnold_post_page_content_font : false;
	if($arnold_post_page_content_font){
		$arnold_post_page_content_font = str_replace('+', ' ', $arnold_post_page_content_font);
		$custom_css .= '
body { font-family: '.esc_attr($arnold_post_page_content_font).'; }
		';
	}
	//Post & page content stlye
	$arnold_post_page_content_font_style = arnold_get_option('theme_option_font_style_post_page_content');
	if($arnold_post_page_content_font_style){
		$custom_css .= '
body { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_content_font_style)).' }
		';
	}
	//Post & page content size
	$arnold_post_page_content_font_size = arnold_get_option('theme_option_font_size_post_page_content');
	if($arnold_post_page_content_font_size && $arnold_post_page_content_font_size !='Select' ){
		$custom_css .= '
body { font-size: '.esc_attr($arnold_post_page_content_font_size).';}
		';
	}

	//Post & page content heading 1-6 font
	$arnold_post_page_content_heading_font = arnold_get_option('theme_option_font_post_page_content_heading');
	$arnold_post_page_content_heading_font = $arnold_post_page_content_heading_font != -1 ? $arnold_post_page_content_heading_font : false;
	if($arnold_post_page_content_heading_font){
		$arnold_post_page_content_heading_font = str_replace('+', ' ', $arnold_post_page_content_heading_font);
		$custom_css .= '
.entry h1,.entry h2,.entry h3,.entry h4,.entry h5,.entry h6, .text_block h1,.text_block h2,.text_block h3,.text_block h4,.text_block h5,.text_block h6,.ux-portfolio-template-intro h1,.ux-portfolio-template-intro h2,.ux-portfolio-template-intro h3,.ux-portfolio-template-intro h4,.ux-portfolio-template-intro h5,.ux-portfolio-template-intro h6,.slider-con-inn h1,.slider-con-inn h2,.slider-con-inn h3,.slider-con-inn h4,.slider-con-inn h5,.slider-con-inn h6,
.infrographic-tit,.bignumber-item
{ 
	font-family: '.esc_attr($arnold_post_page_content_heading_font).'; 
}
		';
	}
	//Post & page content heading 1-6 stlye
	$arnold_post_page_content_heading_font_style = arnold_get_option('theme_option_font_style_post_page_content_heading');
	if($arnold_post_page_content_heading_font_style){
		$custom_css .= '
.entry h1,.entry h2,.entry h3,.entry h4,.entry h5,.entry h6, .text_block h1,.text_block h2,.text_block h3,.text_block h4,.text_block h5,.text_block h6,.ux-portfolio-template-intro h1,.ux-portfolio-template-intro h2,.ux-portfolio-template-intro h3,.ux-portfolio-template-intro h4,.ux-portfolio-template-intro h5,.ux-portfolio-template-intro h6,.slider-con-inn h1,.slider-con-inn h2,.slider-con-inn h3,.slider-con-inn h4,.slider-con-inn h5,.slider-con-inn h6,
.infrographic-tit,.bignumber-item 
{ 
	'.esc_attr(arnold_theme_google_font_style($arnold_post_page_content_heading_font_style)).' 
}
		';
	}
	//Post & page content heading 1-6 size
	$arnold_post_page_content_heading_font_1_size = arnold_get_option('theme_option_font_post_page_content_heading-1-size');
	$arnold_post_page_content_heading_font_1_size = $arnold_post_page_content_heading_font_1_size != 'Select' ? $arnold_post_page_content_heading_font_1_size : false; 
	if($arnold_post_page_content_heading_font_1_size ){
		$custom_css .= '
.entry h1,.text_block h1, .ux-portfolio-template-intro h1 
{
	font-size: '.esc_attr($arnold_post_page_content_heading_font_1_size).';
}		';
	}

	$arnold_post_page_content_heading_font_2_size = arnold_get_option('theme_option_font_post_page_content_heading-2-size');
	$arnold_post_page_content_heading_font_2_size = $arnold_post_page_content_heading_font_2_size != 'Select' ? $arnold_post_page_content_heading_font_2_size : false; 
	if($arnold_post_page_content_heading_font_2_size){
		$custom_css .= '
.entry h2,.text_block h2, .ux-portfolio-template-intro h2
{
	font-size: '.esc_attr($arnold_post_page_content_heading_font_2_size).';
}		';
	}

	$arnold_post_page_content_heading_font_3_size = arnold_get_option('theme_option_font_post_page_content_heading-3-size');
	$arnold_post_page_content_heading_font_3_size = $arnold_post_page_content_heading_font_3_size != 'Select' ? $arnold_post_page_content_heading_font_3_size : false; 
	if($arnold_post_page_content_heading_font_3_size){
		$custom_css .= '
.entry h3,.text_block h3, .ux-portfolio-template-intro h3
{
	font-size: '.esc_attr($arnold_post_page_content_heading_font_3_size).';
}		';
	}

	$arnold_post_page_content_heading_font_4_size = arnold_get_option('theme_option_font_post_page_content_heading-4-size');
	$arnold_post_page_content_heading_font_4_size = $arnold_post_page_content_heading_font_4_size != 'Select' ? $arnold_post_page_content_heading_font_4_size : false; 
	if($arnold_post_page_content_heading_font_4_size){
		$custom_css .= '
.entry h4,.text_block h4, .ux-portfolio-template-intro h4
{
	font-size: '.esc_attr($arnold_post_page_content_heading_font_4_size).';
}		';
	}

	$arnold_post_page_content_heading_font_5_size = arnold_get_option('theme_option_font_post_page_content_heading-5-size');
	$arnold_post_page_content_heading_font_5_size = $arnold_post_page_content_heading_font_5_size != 'Select' ? $arnold_post_page_content_heading_font_5_size : false; 
	if($arnold_post_page_content_heading_font_5_size){
		$custom_css .= '
.entry h5,.text_block h5, .ux-portfolio-template-intro h5
{
	font-size: '.esc_attr($arnold_post_page_content_heading_font_5_size).';
}		';
	}

	$arnold_post_page_content_heading_font_6_size = arnold_get_option('theme_option_font_post_page_content_heading-6-size');
	$arnold_post_page_content_heading_font_6_size = $arnold_post_page_content_heading_font_6_size != 'Select' ? $arnold_post_page_content_heading_font_6_size : false; 
	if($arnold_post_page_content_heading_font_6_size){
		$custom_css .= '
.entry h6,.text_block h6, .ux-portfolio-template-intro h6
{
	font-size: '.esc_attr($arnold_post_page_content_heading_font_6_size).';
}		';
	}

	//Link Button for Page Template
	$arnold_link_page_tempalte_font = arnold_get_option('theme_option_font_link_page_tempalte');
	$arnold_link_page_tempalte_font = $arnold_link_page_tempalte_font != -1 ? $arnold_link_page_tempalte_font : false;
	if($arnold_link_page_tempalte_font){
		$arnold_link_page_tempalte_font = str_replace('+', ' ', $arnold_link_page_tempalte_font);
		$custom_css .= '
.portfolio-link-button-a { font-family: '.esc_attr($arnold_link_page_tempalte_font).'; }
		';
	}
	//Post & page meta stlye
	$arnold_link_page_tempalte_font_style = arnold_get_option('theme_option_font_style_link_page_tempalte');
	if($arnold_link_page_tempalte_font_style){
		$custom_css .= '
.portfolio-link-button-a { '.esc_attr(arnold_theme_google_font_style($arnold_link_page_tempalte_font_style)).' }
		';
	}
	//Post & page meta size
	$arnold_link_page_tempalte_font_size = arnold_get_option('theme_option_font_size_link_page_tempalte');
	if($arnold_link_page_tempalte_font_size && $arnold_link_page_tempalte_font_size !='Select' ){
		$custom_css .= '
.portfolio-link-button-a { font-size: '.esc_attr($arnold_link_page_tempalte_font_size).';}
		';
	}

	//Post & page meta font
	$arnold_post_page_meta_font = arnold_get_option('theme_option_font_post_page_meta');
	$arnold_post_page_meta_font = $arnold_post_page_meta_font != -1 ? $arnold_post_page_meta_font : false;
	if($arnold_post_page_meta_font){
		$arnold_post_page_meta_font = str_replace('+', ' ', $arnold_post_page_meta_font);
		$custom_css .= '
.article-meta, .comment-form .logged,.comment-meta,.archive-des,.archive-meta,.title-wrap-des,.blog_meta_cate { font-family: '.esc_attr($arnold_post_page_meta_font).'; }
		';
	}
	//Post & page meta stlye
	$arnold_post_page_meta_font_style = arnold_get_option('theme_option_font_style_post_page_meta');
	if($arnold_post_page_meta_font_style){
		$custom_css .= '
.article-meta, .comment-form .logged,.comment-meta,.archive-des,.archive-meta,.title-wrap-des,.blog_meta_cate { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_meta_font_style)).' }
		';
	}
	//Post & page meta size
	$arnold_post_page_meta_font_size = arnold_get_option('theme_option_font_size_post_page_meta');
	if($arnold_post_page_meta_font_size && $arnold_post_page_meta_font_size !='Select' ){
		$custom_css .= '
.article-meta, .comment-form .logged,.comment-meta,.archive-des,.archive-meta,.title-wrap-des,.blog_meta_cate { font-size: '.esc_attr($arnold_post_page_meta_font_size).';}
		';
	}

	//Gallery Post Property Title font (Small Heading)
	$arnold_post_page_property_title_font = arnold_get_option('theme_option_font_post_page_property_title');
	$arnold_post_page_property_title_font = $arnold_post_page_property_title_font != -1 ? $arnold_post_page_property_title_font : false;
	if($arnold_post_page_property_title_font){
		$arnold_post_page_property_title_font = str_replace('+', ' ', $arnold_post_page_property_title_font);
		$custom_css .= '
.gallery-info-property-tit,.comment-author,.comment-author-a { font-family: '.esc_attr($arnold_post_page_property_title_font).'; }
		';
	}
	//Gallery Post Property Title stlye
	$arnold_post_page_property_title_font_style = arnold_get_option('theme_option_font_style_post_page_property_title');
	if($arnold_post_page_property_title_font_style){
		$custom_css .= '
.gallery-info-property-tit,.comment-author,.comment-author-a { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_property_title_font_style)).' }
		';
	}
	//Gallery Post Property Title size
	$arnold_post_page_property_title_font_size = arnold_get_option('theme_option_font_size_post_page_property_title');
	if($arnold_post_page_property_title_font_size && $arnold_post_page_property_title_font_size !='Select' ){
		$custom_css .= '
.gallery-info-property-tit { font-size: '.esc_attr($arnold_post_page_property_title_font_size).';}
		';
	}

	//Gallery Post Property content font
	$arnold_post_page_property_content_font = arnold_get_option('theme_option_font_post_page_property_content');
	$arnold_post_page_property_content_font = $arnold_post_page_property_content_font != -1 ? $arnold_post_page_property_content_font : false;
	if($arnold_post_page_property_content_font){
		$arnold_post_page_property_content_font = str_replace('+', ' ', $arnold_post_page_property_content_font);
		$custom_css .= '
.gallery-info-property-con { font-family: '.esc_attr($arnold_post_page_property_content_font).'; }
		';
	}
	//Gallery Post Property content stlye
	$arnold_post_page_property_content_font_style = arnold_get_option('theme_option_font_style_post_page_property_content');
	if($arnold_post_page_property_content_font_style){
		$custom_css .= '
.gallery-info-property-con { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_property_content_font_style)).' }
		';
	}
	//Gallery Post Property content size
	$arnold_post_page_property_content_font_size = arnold_get_option('theme_option_font_size_post_page_property_content');
	if($arnold_post_page_property_content_font_size && $arnold_post_page_property_content_font_size !='Select' ){
		$custom_css .= '
.gallery-info-property-con { font-size: '.esc_attr($arnold_post_page_property_content_font_size).';}
		';
	}

	//Gallery Post LINK font
	$arnold_post_page_link_font = arnold_get_option('theme_option_font_post_page_link');
	$arnold_post_page_link_font = $arnold_post_page_link_font != -1 ? $arnold_post_page_link_font : false;
	if($arnold_post_page_link_font){
		$arnold_post_page_link_font = str_replace('+', ' ', $arnold_post_page_link_font);
		$custom_css .= '
.gallery-link-a { font-family: '.esc_attr($arnold_post_page_link_font).'; }
		';
	}
	//Gallery Post LINK stlye
	$arnold_post_page_link_font_style = arnold_get_option('theme_option_font_style_post_page_link');
	if($arnold_post_page_link_font_style){
		$custom_css .= '
.gallery-link-a { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_link_font_style)).' }
		';
	}
	//Gallery Post LINK size
	$arnold_post_page_link_font_size = arnold_get_option('theme_option_font_size_post_page_link');
	if($arnold_post_page_link_font_size && $arnold_post_page_link_font_size !='Select' ){
		$custom_css .= '
.gallery-link-a { font-size: '.esc_attr($arnold_post_page_link_font_size).';}
		';
	}

	//Share button size
	$arnold_post_page_share_btn_size = arnold_get_option('theme_option_font_post_page_content_share_btn_size');
	if($arnold_post_page_share_btn_size && $arnold_post_page_share_btn_size !='Select' ){
		$custom_css .= '
.post-meta-social-li .fa { font-size: '.esc_attr($arnold_post_page_share_btn_size).';}
		';
	}

	//Post Navi font
	$arnold_post_page_navi_font = arnold_get_option('theme_option_font_post_page_navi');
	$arnold_post_page_navi_font = $arnold_post_page_navi_font != -1 ? $arnold_post_page_navi_font : false;
	if($arnold_post_page_navi_font){
		$arnold_post_page_navi_font = str_replace('+', ' ', $arnold_post_page_navi_font);
		$custom_css .= '
.post-navi-single,.post-navi-unit-tit { font-family: '.esc_attr($arnold_post_page_navi_font).'; }
		';
	}
	//Post Navi stlye
	$arnold_post_page_navi_font_style = arnold_get_option('theme_option_font_style_post_page_navi');
	if($arnold_post_page_navi_font_style){
		$custom_css .= '
.post-navi-single,.post-navi-unit-tit { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_navi_font_style)).' }
		';
	}
	//Post Navi size
	$arnold_post_page_navi_font_size = arnold_get_option('theme_option_font_size_post_page_navi');
	if($arnold_post_page_navi_font_size && $arnold_post_page_navi_font_size !='Select' ){
		$custom_css .= '
.post-navi-single,.post-navi-unit-tit { font-size: '.esc_attr($arnold_post_page_navi_font_size).';}
		';
	}

	//Comments Title font (Medium Heading)
	$arnold_post_page_comments_tit_font = arnold_get_option('theme_option_font_post_page_comments_tit');
	$arnold_post_page_comments_tit_font = $arnold_post_page_comments_tit_font != -1 ? $arnold_post_page_comments_tit_font : false;
	if($arnold_post_page_comments_tit_font){
		$arnold_post_page_comments_tit_font = str_replace('+', ' ', $arnold_post_page_comments_tit_font);
		$custom_css .= '
.comment-box-tit,.comm-reply-title,#content_wrap .infrographic p,#content_wrap .promote-mod p, a.team-item-title { font-family: '.esc_attr($arnold_post_page_comments_tit_font).'; }
		';
	}
	//Comments Title stlye
	$arnold_post_page_comments_tit_font_style = arnold_get_option('theme_option_font_style_post_page_comments_tit');
	if($arnold_post_page_comments_tit_font_style){
		$custom_css .= '
.comment-box-tit,.comm-reply-title,#content_wrap .infrographic p,#content_wrap .promote-mod p, a.team-item-title { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_comments_tit_font_style)).' }
		';
	}
	//Comments Title size
	$arnold_post_page_comments_tit_font_size = arnold_get_option('theme_option_font_size_post_page_comments_tit');
	if($arnold_post_page_comments_tit_font_size && $arnold_post_page_comments_tit_font_size !='Select' ){
		$custom_css .= '
.comment-box-tit,.comm-reply-title,#content_wrap .infrographic p,#content_wrap .promote-mod p, a.team-item-title { font-size: '.esc_attr($arnold_post_page_comments_tit_font_size).';}
		';
	}

	//Comments Content font
	$arnold_post_page_comments_con_font = arnold_get_option('theme_option_font_post_page_comments_con');
	$arnold_post_page_comments_con_font = $arnold_post_page_comments_con_font != -1 ? $arnold_post_page_comments_con_font : false;
	if($arnold_post_page_comments_con_font){
		$arnold_post_page_comments_con_font = str_replace('+', ' ', $arnold_post_page_comments_con_font);
		$custom_css .= '
.comment { font-family: '.esc_attr($arnold_post_page_comments_con_font).'; }
		';
	}
	//Comments Content stlye
	$arnold_post_page_comments_con_font_style = arnold_get_option('theme_option_font_style_post_page_comments_con');
	if($arnold_post_page_comments_con_font_style){
		$custom_css .= '
.comment { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_comments_con_font_style)).' }
		';
	}
	//Comments Content size
	$arnold_post_page_comments_con_font_size = arnold_get_option('theme_option_font_size_post_page_comments_con');
	if($arnold_post_page_comments_con_font_size && $arnold_post_page_comments_con_font_size !='Select' ){
		$custom_css .= '
.comment { font-size: '.esc_attr($arnold_post_page_comments_con_font_size).';}
		';
	}

	//Comments Author Name Font Size
	$arnold_comment_author = arnold_get_option('theme_option_font_size_post_page_comments_author');
	if($arnold_comment_author && $arnold_comment_author !='Select'){
		$custom_css .= '
.comment-author { font-size: '.esc_attr($arnold_comment_author).';}
		';
	}

	//////////////////////// List
	// Filter Font
	$arnold_post_page_filter_font = arnold_get_option('theme_option_font_post_page_filter');
	$arnold_post_page_filter_font = $arnold_post_page_filter_font != -1 ? $arnold_post_page_filter_font : false;
	if($arnold_post_page_filter_font){
		$arnold_post_page_filter_font = str_replace('+', ' ', $arnold_post_page_filter_font);
		$custom_css .= '
.filters-li, .menu-filter-wrap a { font-family: '.esc_attr($arnold_post_page_filter_font).'; }
		';
	}
	// Filter stlye
	$arnold_post_page_filter_font_style = arnold_get_option('theme_option_font_style_post_page_filter');
	if($arnold_post_page_filter_font_style){
		$custom_css .= '
.filters-li, .menu-filter-wrap a { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_filter_font_style)).' }
		';
	}
	// Filter size
	$arnold_post_page_filter_font_size = arnold_get_option('theme_option_font_size_post_page_filter');
	if($arnold_post_page_filter_font_size && $arnold_post_page_filter_font_size !='Select' ){
		$custom_css .= '
.filters-li, .menu-filter-wrap a { font-size: '.esc_attr($arnold_post_page_filter_font_size).';}
		';
	}

	// Load More Font
	$arnold_post_page_loadmore_font = arnold_get_option('theme_option_font_post_page_loadmore');
	$arnold_post_page_loadmore_font = $arnold_post_page_loadmore_font != -1 ? $arnold_post_page_loadmore_font : false;
	if($arnold_post_page_loadmore_font){
		$arnold_post_page_loadmore_font = str_replace('+', ' ', $arnold_post_page_loadmore_font);
		$custom_css .= '
.pagenums { font-family: '.esc_attr($arnold_post_page_loadmore_font).'; }
		';
	}
	// Load More stlye
	$arnold_post_page_loadmore_font_style = arnold_get_option('theme_option_font_style_post_page_loadmore');
	if($arnold_post_page_loadmore_font_style){
		$custom_css .= '
.pagenums { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_loadmore_font_style)).' }
		';
	}
	// Load More size
	$arnold_post_page_loadmore_font_size = arnold_get_option('theme_option_font_size_post_page_loadmore');
	if($arnold_post_page_loadmore_font_size && $arnold_post_page_loadmore_font_size !='Select' ){
		$custom_css .= '
.pagenums { font-size: '.esc_attr($arnold_post_page_loadmore_font_size).';}
		';
	}

	// Title of Item Font
	$arnold_post_page_list_item_tit_font = arnold_get_option('theme_option_font_post_page_list_item_tit');
	$arnold_post_page_list_item_tit_font = $arnold_post_page_list_item_tit_font != -1 ? $arnold_post_page_list_item_tit_font : false;
	if($arnold_post_page_list_item_tit_font){
		$arnold_post_page_list_item_tit_font = str_replace('+', ' ', $arnold_post_page_list_item_tit_font);
		$custom_css .= '
.grid-item-tit,.product-caption-title,.bm-tab-slider-trigger-tilte { font-family: '.esc_attr($arnold_post_page_list_item_tit_font).'; }
		';
	}
	// Title of Item stlye
	$arnold_post_page_list_item_tit_font_style = arnold_get_option('theme_option_font_style_post_page_list_item_tit');
	if($arnold_post_page_list_item_tit_font_style){
		$custom_css .= '
.grid-item-tit,.product-caption-title,.bm-tab-slider-trigger-tilte { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_list_item_tit_font_style)).' }
		';
	}
	// Title of Item size
	$arnold_post_page_list_item_tit_font_size = arnold_get_option('theme_option_font_size_post_page_list_item_tit');
	if($arnold_post_page_list_item_tit_font_size && $arnold_post_page_list_item_tit_font_size !='Select' ){
		$custom_css .= '
.grid-item-tit,.product-caption-title,.bm-tab-slider-trigger-tilte { font-size: '.esc_attr($arnold_post_page_list_item_tit_font_size).';}
		';
	}

	// Tag of Item Font
	$arnold_post_page_list_item_tag_font = arnold_get_option('theme_option_font_post_page_list_item_tag');
	$arnold_post_page_list_item_tag_font = $arnold_post_page_list_item_tag_font != -1 ? $arnold_post_page_list_item_tag_font : false;
	if($arnold_post_page_list_item_tag_font){
		$arnold_post_page_list_item_tag_font = str_replace('+', ' ', $arnold_post_page_list_item_tag_font);
		$custom_css .= '
.grid-item-cate-a,.woocommerce .product-caption .price,.article-cate-a { font-family: '.esc_attr($arnold_post_page_list_item_tag_font).'; }
		';
	}
	// Tag of Item stlye
	$arnold_post_page_list_item_tag_font_style = arnold_get_option('theme_option_font_style_post_page_list_item_tag');
	if($arnold_post_page_list_item_tag_font_style){
		$custom_css .= '
.grid-item-cate-a,.woocommerce .product-caption .price,.article-cate-a { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_list_item_tag_font_style)).' }
		';
	}
	// Tag of Item size
	$arnold_post_page_list_item_tag_font_size = arnold_get_option('theme_option_font_size_post_page_list_item_tag');
	if($arnold_post_page_list_item_tag_font_size && $arnold_post_page_list_item_tag_font_size !='Select' ){
		$custom_css .= '
.grid-item-cate-a,.woocommerce .product-caption .price,.article-cate-a { font-size: '.esc_attr($arnold_post_page_list_item_tag_font_size).';}
		';
	}

	//////////////////////// Masonry Blog
	// Title of Item Font
	$arnold_post_page_blog_item_tit_font = arnold_get_option('theme_option_font_post_page_blog_item_tit');
	$arnold_post_page_blog_item_tit_font = $arnold_post_page_blog_item_tit_font != -1 ? $arnold_post_page_blog_item_tit_font : false;
	if($arnold_post_page_blog_item_tit_font){
		$arnold_post_page_blog_item_tit_font = str_replace('+', ' ', $arnold_post_page_blog_item_tit_font);
		$custom_css .= '
.gird-blog-tit,.blog-unit-quote,.blog-unit-link-li { font-family: '.esc_attr($arnold_post_page_blog_item_tit_font).'; }
		';
	}
	// Title of Item stlye
	$arnold_post_page_blog_item_tit_font_style = arnold_get_option('theme_option_font_style_post_page_blog_item_tit');
	if($arnold_post_page_blog_item_tit_font_style){
		$custom_css .= '
.gird-blog-tit, .blog-unit-link-li { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_blog_item_tit_font_style)).' }
		';
	}
	// Title of Item size
	$arnold_post_page_blog_item_tit_font_size = arnold_get_option('theme_option_font_size_post_page_blog_item_tit');
	if($arnold_post_page_blog_item_tit_font_size && $arnold_post_page_blog_item_tit_font_size !='Select' ){
		$custom_css .= '
.gird-blog-tit { font-size: '.esc_attr($arnold_post_page_blog_item_tit_font_size).';}
		';
	}

	// Meta of Item Font
	$arnold_post_page_blog_item_meta_font = arnold_get_option('theme_option_font_post_page_blog_item_meta');
	$arnold_post_page_blog_item_meta_font = $arnold_post_page_blog_item_meta_font != -1 ? $arnold_post_page_blog_item_meta_font : false;
	if($arnold_post_page_blog_item_meta_font){
		$arnold_post_page_blog_item_meta_font = str_replace('+', ' ', $arnold_post_page_blog_item_meta_font);
		$custom_css .= '
.gird-blog-meta { font-family: '.esc_attr($arnold_post_page_blog_item_meta_font).'; }
		';
	}
	// Meta of Item stlye
	$arnold_post_page_blog_item_meta_font_style = arnold_get_option('theme_option_font_style_post_page_blog_item_meta');
	if($arnold_post_page_blog_item_meta_font_style){
		$custom_css .= '
.gird-blog-meta { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_blog_item_meta_font_style)).' }
		';
	}
	// meta of Item size
	$arnold_post_page_blog_item_meta_font_size = arnold_get_option('theme_option_font_size_post_page_blog_item_meta');
	if($arnold_post_page_blog_item_meta_font_size && $arnold_post_page_blog_item_meta_font_size !='Select' ){
		$custom_css .= '
.gird-blog-meta { font-size: '.esc_attr($arnold_post_page_blog_item_meta_font_size).';}
		';
	}

	// Excerpt of Item size
	$arnold_post_page_blog_item_excerpt_font_size = arnold_get_option('theme_option_font_post_page_blog_excerpt');
	if($arnold_post_page_blog_item_excerpt_font_size && $arnold_post_page_blog_item_excerpt_font_size !='Select' ){
		$custom_css .= '
.gird-blog-excerpt { font-size: '.esc_attr($arnold_post_page_blog_item_excerpt_font_size).';}
		';
	}

	//////////////////////// Button
	// Button Font
	$arnold_post_page_button_font = arnold_get_option('theme_option_font_post_page_button');
	$arnold_post_page_button_font = $arnold_post_page_button_font != -1 ? $arnold_post_page_button_font : false;
	if($arnold_post_page_button_font){
		$arnold_post_page_button_font = str_replace('+', ' ', $arnold_post_page_button_font);
		$custom_css .= '
button, input[type="submit"] { font-family: '.esc_attr($arnold_post_page_button_font).'; }
		';
	}
	//Button stlye
	$arnold_post_page_button_font_style = arnold_get_option('theme_option_font_style_post_page_button');
	if($arnold_post_page_button_font_style){
		$custom_css .= '
button, input[type="submit"] { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_button_font_style)).' }
		';
	}
	//Button size
	$arnold_post_page_button_font_size = arnold_get_option('theme_option_font_size_post_page_button');
	if($arnold_post_page_button_font_size && $arnold_post_page_button_font_size !='Select' ){
		$custom_css .= '
button, input[type="submit"] { font-size: '.esc_attr($arnold_post_page_button_font_size).';}
		';
	}

	//////////////////////// Form
	// Form Font
	$arnold_post_page_form_font = arnold_get_option('theme_option_font_post_page_form');
	$arnold_post_page_form_font = $arnold_post_page_form_font != -1 ? $arnold_post_page_form_font : false;
	if($arnold_post_page_form_font){
		$arnold_post_page_form_font = str_replace('+', ' ', $arnold_post_page_form_font);
		$custom_css .= '
textarea,input { font-family: '.esc_attr($arnold_post_page_form_font).'; }
		';
	}
	//Form stlye
	$arnold_post_page_form_font_style = arnold_get_option('theme_option_font_style_post_page_form');
	if($arnold_post_page_form_font_style){
		$custom_css .= '
textarea,input { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_form_font_style)).' }
		';
	}
	//Form size
	$arnold_post_page_form_font_size = arnold_get_option('theme_option_font_size_post_page_form');
	if($arnold_post_page_form_font_size && $arnold_post_page_form_font_size !='Select' ){
		$custom_css .= '
textarea,input { font-size: '.esc_attr($arnold_post_page_form_font_size).';}
		';
	}

	//////////////////////// Archive
	// Archive Title Font
	$arnold_archive_tit_font = arnold_get_option('theme_option_font_archive_tit');
	$arnold_archive_tit_font = $arnold_archive_tit_font != -1 ? $arnold_archive_tit_font : false;
	if($arnold_archive_tit_font){
		$arnold_archive_tit_font = str_replace('+', ' ', $arnold_archive_tit_font);
		$custom_css .= '
.archive-title .title-wrap-tit { font-family: '.esc_attr($arnold_archive_tit_font).'; }
		';
	}
	// Archive Title stlye
	$arnold_archive_tit_font_style = arnold_get_option('theme_option_font_style_archive_tit');
	if($arnold_archive_tit_font_style){
		$custom_css .= '
.archive-title .title-wrap-tit { '.esc_attr(arnold_theme_google_font_style($arnold_archive_tit_font_style)).' }
		';
	}
	// Archive Title size
	$arnold_archive_tit_font_size = arnold_get_option('theme_option_font_size_archive_tit');
	if($arnold_archive_tit_font_size && $arnold_archive_tit_font_size !='Select' ){
		$custom_css .= '
.archive-title .title-wrap-tit { font-size: '.esc_attr($arnold_archive_tit_font_size).';}
		';
	}

	// Archive Posts Title Font
	$arnold_archive_posts_tit_font = arnold_get_option('theme_option_font_archive_posts_tit');
	$arnold_archive_posts_tit_font = $arnold_archive_posts_tit_font != -1 ? $arnold_archive_posts_tit_font : false;
	if($arnold_archive_posts_tit_font){
		$arnold_archive_posts_tit_font = str_replace('+', ' ', $arnold_archive_posts_tit_font);
		$custom_css .= '
.arvhive-tit,.iterlock-caption h2 { font-family: '.esc_attr($arnold_archive_posts_tit_font).'; }
		';
	}
	// Archive Posts Title stlye
	$arnold_archive_posts_tit_font_style = arnold_get_option('theme_option_font_style_archive_posts_tit');
	if($arnold_archive_posts_tit_font_style){
		$custom_css .= '
.arvhive-tit,.iterlock-caption h2 { '.esc_attr(arnold_theme_google_font_style($arnold_archive_posts_tit_font_style)).' }
		';
	}
	// Archive Posts Title size
	$arnold_archive_posts_tit_font_size = arnold_get_option('theme_option_font_size_archive_posts_tit');
	if($arnold_archive_posts_tit_font_size && $arnold_archive_posts_tit_font_size !='Select' ){
		$custom_css .= '
.arvhive-tit,.iterlock-caption h2 { font-size: '.esc_attr($arnold_archive_posts_tit_font_size).';}
		';
	}

	//////////////////////// Widgets
	// Widgets Title Font
	$arnold_post_page_widget_tit_font = arnold_get_option('theme_option_font_post_page_widget_tit');
	$arnold_post_page_widget_tit_font = $arnold_post_page_widget_tit_font != -1 ? $arnold_post_page_widget_tit_font : false;
	if($arnold_post_page_widget_tit_font){
		$arnold_post_page_widget_tit_font = str_replace('+', ' ', $arnold_post_page_widget_tit_font);
		$custom_css .= '
.widget-title { font-family: '.esc_attr($arnold_post_page_widget_tit_font).'; }
		';
	}
	// Widgets Title stlye
	$arnold_post_page_widget_tit_font_style = arnold_get_option('theme_option_font_style_post_page_widget_tit');
	if($arnold_post_page_widget_tit_font_style){
		$custom_css .= '
.widget-title { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_widget_tit_font_style)).' }
		';
	}
	// Widgets Title size
	$arnold_post_page_widget_tit_font_size = arnold_get_option('theme_option_font_size_post_page_widget_tit');
	if($arnold_post_page_widget_tit_font_size && $arnold_post_page_widget_tit_font_size !='Select' ){
		$custom_css .= '
.widget-title { font-size: '.esc_attr($arnold_post_page_widget_tit_font_size).';}
		';
	}

	// Widget Content Font
	$arnold_post_page_widget_con_font = arnold_get_option('theme_option_font_post_page_widget_con');
	$arnold_post_page_widget_con_font = $arnold_post_page_widget_con_font != -1 ? $arnold_post_page_widget_con_font : false;
	if($arnold_post_page_widget_con_font){
		$arnold_post_page_widget_con_font = str_replace('+', ' ', $arnold_post_page_widget_con_font);
		$custom_css .= '
.widget-container { font-family: '.esc_attr($arnold_post_page_widget_con_font).'; }
		';
	}
	// Widget Content stlye
	$arnold_post_page_widget_con_font_style = arnold_get_option('theme_option_font_style_post_page_widget_con');
	if($arnold_post_page_widget_con_font_style){
		$custom_css .= '
.widget-container { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_widget_con_font_style)).' }
		';
	}
	// Widget Content size
	$arnold_post_page_widget_con_font_size = arnold_get_option('theme_option_font_size_post_page_widget_con');
	if($arnold_post_page_widget_con_font_size && $arnold_post_page_widget_con_font_size !='Select' ){
		$custom_css .= '
.widget-container { font-size: '.esc_attr($arnold_post_page_widget_con_font_size).';}
		';
	}

	// Footer Font
	$arnold_post_page_footer_font = arnold_get_option('theme_option_font_post_page_footer');
	$arnold_post_page_footer_font = $arnold_post_page_footer_font != -1 ? $arnold_post_page_footer_font : false;
	if($arnold_post_page_footer_font){
		$arnold_post_page_footer_font = str_replace('+', ' ', $arnold_post_page_footer_font);
		$custom_css .= '
.footer-info { font-family: '.esc_attr($arnold_post_page_footer_font).'; }
		';
	}
	// Footer stlye
	$arnold_post_page_footer_font_style = arnold_get_option('theme_option_font_style_post_page_footer');
	if($arnold_post_page_footer_font_style){
		$custom_css .= '
.footer-info { '.esc_attr(arnold_theme_google_font_style($arnold_post_page_footer_font_style)).' }
		';
	}
	// Footer size
	$arnold_post_page_footer_font_size = arnold_get_option('theme_option_font_size_post_page_footer');
	if($arnold_post_page_footer_font_size && $arnold_post_page_footer_font_size !='Select' ){
		$custom_css .= '
.footer-info { font-size: '.esc_attr($arnold_post_page_footer_font_size).';}
		';
	}
	



	/////////////////  Featured Colors

	$featured_color_default = arnold_get_option('theme_option_featured_color_default');
	if($featured_color_default){
		$custom_css .= ".post-bgcolor-default{color:" .esc_attr($featured_color_default). ";}\n";
		$custom_css .= ".post-bgcolor-default{background-color:" .esc_attr($featured_color_default). ";}\n";
		$custom_css .= ".grid-item-con:after{background-color:" .esc_attr($featured_color_default). ";}\n";
	}

	//color 1-10
	for($color_num=1;$color_num<=10;$color_num++){
		$featured_color = arnold_get_option('theme_option_featured_color_' .$color_num);
		if($featured_color){
			$custom_css .= ".theme-color-".$color_num."{color:" .esc_attr($featured_color). ";}\n";
			$custom_css .= ".bg-theme-color-".$color_num.",.promote-hover-bg-theme-color-".$color_num.":hover,.list-layout-con.bg-theme-color-".$color_num."{background-color:" .esc_attr($featured_color). ";}\n";
			$custom_css .= ".moudle .ux-btn.bg-theme-color-".$color_num." { border-color:" .esc_attr($featured_color). "; color:" .esc_attr($featured_color). "; }\n";
			$custom_css .= ".moudle .ux-btn.bg-theme-color-".$color_num."-hover:hover{ border-color:" .esc_attr($featured_color). "; color:" .esc_attr($featured_color). "; }\n";

			if($color_num == 10){
				$custom_css .= ".navi-bgcolor-default { background-color:" .esc_attr($featured_color). "; }\n";
			}
		}
	}

	//Global

	$arnold_color_header_width = esc_attr(arnold_get_option('theme_option_header_width'));
	$arnold_color_header_padding = esc_attr(arnold_get_option('theme_option_header_padding'));

	if($arnold_color_header_width == 'fluid' && $arnold_color_header_padding) {

		$custom_css .= "
@media (min-width: 768px) {
	.header-main > .container-fluid { 
    	padding-left: ".$arnold_color_header_padding."px; padding-right: ".$arnold_color_header_padding."px;
	}
}
		";
	}


	$arnold_color_header_height = esc_attr(arnold_get_option('theme_option_header_height'));

	if($arnold_color_header_height) {

		$custom_css .= "
@media (min-width: 768px) {
	#wrap { min-height: calc(100vh - ".esc_attr($arnold_color_header_height)."px); }
	.header-main {
		line-height: ".esc_attr($arnold_color_header_height)."px; 
	}
	.header-main,
	.navi-hide .navi-logo,
	.navi-show-h .navi-logo,
	.navi-hide .header-main > .container-fluid,
	.navi-hide .header-main > .container,
	.navi-show-icon .header-main > .container-fluid,
	.navi-show-icon .header-main > .container {
	  height: ".esc_attr($arnold_color_header_height)."px;
	}
	.logo-image {
		max-height: ".esc_attr($arnold_color_header_height)."px;
	}
	
}
		";
	}

	
	$arnold_color_main_width = esc_attr(arnold_get_option('theme_option_main_width'));

	if($arnold_color_main_width == '1070') {
		$custom_css .= "
@media (min-width: 1200px) {
  .container {
    width: 1070px;
  }
  .pagebuilder-wrap > .container-fluid { 
  	width: 1070px; 
  }
}
		";
	} else if($arnold_color_main_width == '970') {
		$custom_css .= "
@media (min-width: 1200px) {
  .container {
    width: 970px;
  }
  .pagebuilder-wrap > .container-fluid { 
  	width: 970px; 
  }
}
		";
	} 

	//Custom css
	$arnold_custom_css = arnold_get_option('theme_option_custom_css');
	if($arnold_custom_css){ 
		$custom_css .= wp_kses_stripslashes($arnold_custom_css);
	}

	return $custom_css;

}

?>