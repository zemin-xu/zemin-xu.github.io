<?php
$switch = true;

$excerpt = false;
$title = get_the_title();
$section_class = 'archive-title';
$search_text = arnold_get_option('theme_option_descriptions_search') ? arnold_get_option('theme_option_descriptions_search') : esc_attr__('Type and Hit Enter','arnold');

if(is_single()) {
	$section_class = false;
	if(has_post_format('gallery')){
		$switch = false;
	}
	
	$excerpt = get_the_excerpt();
	$title = get_the_title();
}

if(is_day()){
	$excerpt = esc_html__('Daily Archives','arnold');
	$title = get_the_date();
}

if(is_month()){
	$excerpt = esc_html__('Monthly Archives','arnold');
	$title = get_the_date(_x('F Y', 'monthly archives date format', 'arnold'));
}

if(is_year()){
	$excerpt = esc_html__('Yearly Archives','arnold');
	$title = get_the_date(_x('Y', 'yearly archives date format', 'arnold'));
}

if ( is_front_page() && is_home() ) {
	// Default homepage
	$title = esc_html__('Latest Posts','arnold'); 
} elseif ( is_home() ) {
	// blog page
	$title = esc_html__('News','arnold');
}

if(is_404()){
	$excerpt = false;
	$title = false;
}

if(is_archive()){
	$excerpt = false;
	$title = esc_html__('Archives','arnold');
	if(class_exists('Woocommerce')){
		if(is_shop()){
			$title = esc_html__('Shop','arnold');
		}
	}
}

if(is_tag()){
	$excerpt = esc_html__('Tag','arnold');
	$title = esc_html__('Posts for','arnold') . ' <strong>' . single_tag_title('', false) . '</strong> ' . $excerpt;
}

if(is_author()){
	$excerpt = esc_html__('Author','arnold');
	$title = get_the_author();
}

if(is_category()){
	$excerpt = esc_html__('Category','arnold');
	$title = esc_html__('Posts for','arnold') . ' <strong>' . single_cat_title('', false) . '</strong> ' . $excerpt;
}

if(class_exists('Woocommerce')){
	if(is_product_category()) {
		$title = single_cat_title('', false);
	}
}

if(is_search()){
	$title = esc_html__( 'Search Results', 'arnold');
	$excerpt = esc_html__( 'Search for: ', 'arnold') . get_search_query();
}

if($switch){ ?>

    <div class="<?php echo sanitize_html_class($section_class); ?> title-wrap">
        <div class="title-wrap-con">
            <h2 class="title-wrap-tit"><?php echo balanceTags($title); ?></h2>
            <?php if(is_archive() || is_home()){
				if(is_home()){

					query_posts(array(
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array('post-format-gallery'),
								'operator' => 'NOT IN' 
							)
						))
					);	
				} ?>
				<div class="archive-des"><?php echo esc_html($wp_query->found_posts); esc_html_e(' items found','arnold'); ?></div>
			<?php }
			
			if(is_single()){ ?>
                <div class="article-meta clearfix"><?php arnold_get_template_part('single/content', 'meta'); ?></div>
            <?php } 

            if(is_search()){ ?>
            	<div class="archive-des"><?php echo balanceTags($excerpt); ?></div>
            	<form method="get" name="search" action="<?php echo home_url('/'); ?>/" class="archive-search-form">
                    <input type="search" name="s" class="archive-search-input" placeholder="<?php echo esc_attr($search_text); ?>">
                </form>
            <?php } ?>
        </div>
    </div>    
<?php } ?>
