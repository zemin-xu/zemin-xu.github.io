<?php
$page_social = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_social_link');
$page_show_social = '';
if($page_social){
	$page_show_social = 'ux-show-social';
}

?>

<div class="page-template-intro-outer <?php echo sanitize_html_class($page_show_social); ?> container">
    <section class="ux-portfolio-template-intro">
        <?php the_content(); ?>
    </section>
    <?php
	if($page_social){
		arnold_get_template_part('page/content', 'social');
	} ?>
</div>