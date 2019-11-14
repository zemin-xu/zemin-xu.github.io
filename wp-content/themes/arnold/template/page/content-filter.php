<?php
$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
$category = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_category');

if($page_template == 'masonry-grid'){
	$category = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_category_masonry_grid');
}

if(is_array($category)){
	$category = $category[0];
}

$get_category = get_category($category);
$get_categories = get_categories(array(
	'parent' => $category
));

$page_show_filter = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_filter');

$page_filter_hidden = 'hidden';
if($page_show_filter == 'above-gallery'){
	$page_filter_hidden = '';
}

$category_count = 0;
if($get_category){
	$get_posts = get_posts(array(
		'posts_per_page' => -1,
		'category__in' => $category,
		'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => array('post-format-gallery', 'post-format-link'),
			)
		)
	));
	$category_count = count($get_posts);
} ?>

<div class="clearfix filters <?php echo sanitize_html_class($page_filter_hidden); ?>">
    <ul class="filters-ul container">
        <li class="filters-li active"><a id="all" class="filters-a" href="#" data-filter="*">All<span class="filter-num"><?php echo esc_html($category_count); ?></span></a></li>	
        <?php if($get_categories){
			foreach($get_categories as $num => $category){
				$category_count = $category->count;
				
				if($page_template == 'masonry-grid'){
					$get_posts = get_posts(array(
						'posts_per_page' => -1,
						'cat' => $category->term_id,
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array('post-format-gallery', 'post-format-link'),
							)
						)
					));
					$category_count = count($get_posts);
				}
				
                printf('<li class="filters-li"><a class="filters-a" data-filter=".filter_%1$s" href="%2$s" data-catid="%5$s" data-pageid="%6$s">%3$s<span class="filter-num">%4$s</span></a></li>',
                    esc_attr($category->slug),
                    esc_url(get_category_link($category->term_id)),
                    esc_html($category->name),
                    esc_html($category_count),
                    esc_attr($category->term_id),
                    esc_attr(get_the_ID())
                );
            }
        } ?>
    </ul>
                            
</div><!--End filter-->