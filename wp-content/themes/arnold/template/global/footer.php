<?php
$elements_align = arnold_get_option('theme_option_footer_elements_align');
$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
$footer_class = 'footer-cols-layout';

if($elements_align == 'vertical'){
	$footer_class = 'foot-one-col';
}
$show_footer_switch = true;
$show_footer_meta = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_footer');
if($show_footer_meta != 'null' && !$show_footer_meta && is_page()){
	$show_footer_switch = false;
}
if ($page_template == 'only-slider') {
	$show_footer_switch = false;
}
if($show_footer_switch) {
?>
<footer id="footer" class="<?php echo sanitize_html_class($footer_class);?>">

    <?php //** Template Footer Widget
	arnold_interface_footer_widget();
	
	//** Template Footer Info
	arnold_interface_footer_info(); ?>
    <div class="container-fluid back-top-wrap centered-ux"><div id="back-top"></div></div>
</footer>
<?php } ?>