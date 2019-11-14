<?php
$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
$page_introduction = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_introduction');

$columns = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_columns');
$columns_class = 'ux-portfolio-2col';
switch($columns){
	case '2': $columns_class = 'ux-portfolio-2col'; break;
	case '3': $columns_class = 'ux-portfolio-3col'; break;
	case '4': $columns_class = 'ux-portfolio-4col'; break;
	case '5': $columns_class = 'ux-portfolio-5col'; break;
	case '6': $columns_class = 'ux-portfolio-6col'; break;
}

$page_spacing_class = ''; $spacing = '0';
if($page_template == 'masonry-portfolio' || $page_template == 'standard-grid'){
	$page_spacing = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_spacing');
	switch($page_spacing){
		case 'narrow': $page_spacing_class = 'ux-portfolio-spacing-10'; $spacing = '10'; break;
		case 'normal': $page_spacing_class = 'ux-portfolio-spacing-40'; $spacing = '40'; break;
		case 'no-spacing': $page_spacing_class = 'ux-portfolio-spacing-none'; $spacing = '0'; break;
	}
}elseif($page_template == 'masonry-grid'){
	$page_spacing = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_masonry_grid_spacing');
	switch($page_spacing){ 
		case 'normal': $page_spacing_class = 'ux-portfolio-spacing-40'; $spacing = '40'; break;
		case '10': $page_spacing_class = 'ux-portfolio-spacing-10'; $spacing = '10'; break;
		case '20': $page_spacing_class = 'ux-portfolio-spacing-20'; $spacing = '20'; break;
		case '30': $page_spacing_class = 'ux-portfolio-spacing-30'; $spacing = '30'; break;
		case '40': $page_spacing_class = 'ux-portfolio-spacing-40'; $spacing = '40'; break;
		case 'no-spacing': $page_spacing_class = 'ux-portfolio-spacing-none'; $spacing = '0'; break;
	}
}

$page_list_width_class = false;
if( $page_template == 'masonry-portfolio' || $page_template == 'standard-grid'){
	$page_list_width = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_list_width');
	switch($page_list_width){
		case 'normal': $page_list_width_class = 'container'; break;
		case 'fullwidth': $page_list_width_class = 'ux-portfolio-full'; break;
	}
}elseif($page_template == 'masonry-grid') {
	$page_list_width = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_list_width');
	switch($page_list_width){
		case 'normal': $page_list_width_class = 'container'; break;
		case 'fullwidth': $page_list_width_class = 'ux-portfolio-full '.$page_spacing_class; break;
	}
}

$page_show_filter = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_filter');
$page_has_filter = '';
if($page_show_filter == 'above-gallery'){
	$page_has_filter = 'ux-has-filter';
}

$page_grid_ratio = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_grid_ratio');
$page_grid_ratio_data = '';
$page_grid_ratio_class = '';
if($page_template == 'standard-grid'){
	switch($page_grid_ratio){
		case '4_3': $page_grid_ratio_data = '0.75'; $page_grid_ratio_class = 'ux-ratio-34'; break;
		case '16_9': $page_grid_ratio_data = '0.5625'; $page_grid_ratio_class = 'ux-ratio-169'; break;
		case '1_1': $page_grid_ratio_data = '1'; $page_grid_ratio_class = 'ux-ratio-11'; break;
	}
}

if(/*$page_template == 'masonry-grid' ||*/ $page_template == 'masonry-portfolio' || $page_template == 'standard-grid'){
?>

    <div class="container-masonry <?php echo sanitize_html_class($page_spacing_class); ?> <?php echo sanitize_html_class($columns_class); ?> <?php echo sanitize_html_class($page_list_width_class); ?> <?php echo sanitize_html_class($page_has_filter); ?> <?php echo sanitize_html_class($page_grid_ratio_class); ?>" data-ratio="<?php echo esc_attr($page_grid_ratio_data); ?>" data-col="<?php echo esc_attr($columns); ?>" data-spacer="<?php echo esc_attr($spacing); ?>" data-template="<?php echo esc_attr($page_template); ?>">
    
		<?php if($page_introduction){
			arnold_get_template_part('page/content', 'intro');
		}
		
		if($page_show_filter == 'above-gallery' || $page_show_filter == 'on-menu'){
			arnold_get_template_part('page/content', 'filter');
		}
		
		arnold_get_template_part('page/content', 'masonry-list');
		arnold_get_template_part('page/content', 'link'); ?>
    
    </div>

<?php }elseif($page_template == 'masonry-grid'){
		
	if($page_introduction){
		arnold_get_template_part('page/content', 'intro');
	}
	
	if($page_show_filter == 'above-gallery' || $page_show_filter == 'on-menu'){
		arnold_get_template_part('page/content', 'filter');
	} ?>

	<div class="<?php echo esc_attr($page_list_width_class); ?>">
		<?php arnold_get_template_part('page/content', 'masonry-grid'); ?>
	</div>
	
<?php
	arnold_get_template_part('page/content', 'link');

}elseif($page_template == 'blog-masonry'){
	
	arnold_get_template_part('page/blog-masonry/blog', false);
	
}elseif($page_template == 'custom-list'){
	
	if($page_introduction){
		arnold_get_template_part('page/content', 'intro');
	}
	
	arnold_get_template_part('page/content', 'custom-list');
	arnold_get_template_part('page/content', 'link');
	
} ?>