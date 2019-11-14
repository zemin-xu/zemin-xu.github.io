<?php 
$readmore_text = arnold_get_option('theme_option_descriptions_blog_more') ? arnold_get_option('theme_option_descriptions_blog_more') : esc_html__('READ MORE','arnold');
?>
<div class="archive-more"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="archive-more-a"><?php echo esc_html($readmore_text); ?></a></div>