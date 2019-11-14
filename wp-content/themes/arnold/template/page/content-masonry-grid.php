<?php
$module_post = get_the_ID();

$per_page = arnold_get_post_meta($module_post, 'theme_meta_page_number');
$per_page = $per_page ? $per_page : -1;

$list_layout = get_post_meta($module_post, '_portfolio_list_layout', true);
$list_layout_cat = get_post_meta($module_post, '_portfolio_list_layout_cat', true);
$category = arnold_get_post_meta($module_post, 'theme_meta_page_category_masonry_grid');
$cat_id = $category;

if($category){
	$category = array($category);
}else{
	$category = array();
}

$get_categories = get_categories(array( 'parent' => $cat_id ));
if($get_categories){
	foreach($get_categories as $cat){
		array_push($category, $cat->term_id);
	}
}

$page_spacing = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_spacing');
$spacing = '0';
switch($page_spacing){
	case 'normal': $spacing = '40'; break;
	case '10': $spacing = '10'; break;
	case '20': $spacing = '20'; break;
	case '30': $spacing = '30'; break;
	case '40': $spacing = '40'; break;
	case 'no-spacing': $spacing = '0'; break;
}

$page_what_thumb = arnold_get_post_meta($module_post, 'theme_meta_page_what_thumb');
$page_what_thumb_class = '';
if($page_what_thumb == 'open-featured-img'){
	$page_what_thumb_class = 'lightbox-photoswipe';
}

$page_item_style = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_item_style');
$show_title = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_show_title');
$show_category = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_show_category');
$show_text_align = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_text_align');
if($page_item_style != 'img'){
	$show_title = false;
	$show_text_align = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_text_align_2');
}
$page_show_masonry_grid_padding = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_padding');
$page_show_masonry_grid_pading_class = $page_show_masonry_grid_padding && ($show_text_align == 'grid-text-left' || $show_text_align == 'grid-text-right') ? ' masonry-text-padding' : false;

$page_text_align_class = 'grid-text-center';
if($show_text_align){
	$page_text_align_class = $show_text_align;
}

$page_mouseover_effect = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_mouseover_effect');
$page_transparent_for_mask = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_transparent_for_mask');
$masonry_grid_txt_show_mouseover_effect = arnold_get_post_meta($module_post, 'theme_meta_page_masonry_grid_mouseover_effect_2');

if($page_item_style == 'img' && $page_transparent_for_mask){ ?>
	<style type="text/css">.grid-stack .grid-item-con:hover:after{ opacity: <?php echo esc_attr($page_transparent_for_mask); ?>; }</style>
<?php 
}

$page_mouseover_effect_class = false;
$page_masonry_grid_show_text_class = false;
if($page_item_style != 'img'){
	if( $masonry_grid_txt_show_mouseover_effect =='img-zoom-in') {
		$page_mouseover_effect_class = 'img-zoom-in';
	}
	$page_masonry_grid_show_text_class = 'masonry-grid-show-text';
}

$the_query = new WP_Query(array(
	'posts_per_page' => $per_page,
	'category__in' => $category,
	'tax_query' => array(
		array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => array('post-format-gallery', 'post-format-link')
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

/*if(count($category) == 0 || $list_layout_cat != $cat_id){
	
	if($the_query->have_posts()){
		$query_layout = array();
		
		$i = 0;
		$width = 3;
		$height = 3;
		$col = 12 / $width;
		$row = 0;
		
		while($the_query->have_posts()){ $the_query->the_post();
			if($i > 0 && $i % $col == 0){
				$row++;
			}
			
			$x = ($i % $col) * $width;
			$y = $row * $height;
			
			$layout = array(
				'x' => $x,
				'y' => $y,
				'width' => $width,
				'height' => $height,
				'post_id' => get_the_ID()
			);
			
			array_push($query_layout, $layout);
			$i ++;
		}
		wp_reset_postdata();
		
		$list_layout = $query_layout;
	}
}*/

echo '<div class="grid-stack ' .sanitize_html_class($page_what_thumb_class). ' ' .sanitize_html_class($page_text_align_class). ' ' .sanitize_html_class($page_mouseover_effect_class). ' ' .sanitize_html_class($page_masonry_grid_show_text_class). ' ' .sanitize_html_class($page_pagination_class). ' ' .sanitize_html_class($page_show_masonry_grid_pading_class).'" data-spacing="' .esc_attr($spacing). '" data-item-style="' .esc_attr($page_item_style). '" data-perpage="' .esc_attr($per_page). '" data-pageid="' .esc_attr($module_post). '" ' .balanceTags($page_pagination_tag). '>';
	
if($the_query->have_posts()){
	arnold_page_load_masonry_grid($module_post, $current);
}

echo '</div>';	

if($the_query->have_posts()){
	arnold_page_view_pagination($module_post, $the_query);
}

?>