<?php
$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
$list_type_class = '';
switch($page_template){
	case 'masonry-grid': $list_type_class = 'masonry-grid'; break;
	case 'standard-grid': $list_type_class = 'grid-list'; break;
}

$list_grid_class = '';
if($page_template == 'standard-grid'){
	$list_grid_class = 'grid-list-tit-shown';
}

$page_what_thumb = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_what_thumb');
$page_what_thumb_class = '';
if($page_what_thumb == 'open-featured-img'){
	$page_what_thumb_class = 'lightbox-photoswipe';
}

$category = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_category');
$per_page = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_number');
$orderby = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_orderby');
$order = arnold_get_post_meta(get_the_ID(), 'theme_meta_order');

$per_page = $per_page ? $per_page : -1;

$post_id = get_the_ID();

if(!is_array($category)){
	$category = array($category);
}

$the_query = new WP_Query(array(
	'posts_per_page' => $per_page,
	'category__in' => $category,
	'orderby' => $orderby,
	'order' => $order,
	'tax_query' => array(
		array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => array('post-format-gallery', 'post-format-link'),
		)
	)
)); 

$page_pagination = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_pagination');
$page_pagination_tag = '';
$page_pagination_class = '';
if($page_pagination == 'infiniti-scroll'){
	$max_num_pages = intval($the_query->max_num_pages);
	$page_pagination_tag = 'data-paged="2" data-pageid="' .esc_attr(get_the_ID()). '" data-max="' .esc_attr($max_num_pages). '"';
	$page_pagination_class = 'infiniti-scroll';
}

global $wp_query;
$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

?>

<div class="masonry-list <?php echo sanitize_html_class($list_type_class); ?> <?php echo sanitize_html_class($list_grid_class); ?> <?php echo sanitize_html_class($page_what_thumb_class); ?> <?php echo sanitize_html_class($page_pagination_class); ?>" <?php echo balanceTags($page_pagination_tag); ?>>
    
    <?php if($the_query->have_posts()){
		arnold_page_load_masonry_list($post_id, $current);
	} ?>
    
</div>

<?php if($the_query->have_posts()){
	arnold_page_view_pagination($post_id, $the_query); 
} ?>