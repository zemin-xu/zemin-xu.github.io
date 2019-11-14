<?php
function ux_theme_register_other_post_type($register){
	$register['team_item'] = array(
		'name' => __('Team','ux'),
		'meta' => true,
		'add_new' => __('Add New','ux'),
		'add_new_item' => __('Add New Team Member','ux'),
		'edit_item' => __('Edit Team Member','ux'),
		'new_item' => __('New Team Member','ux'),
		'view_item' => __('View Team Member','ux'),
		'not_found' => __('No Team Member found.','ux'),
		'not_found_in_trash' => __('No Team Member found in Trash.','ux'),
		'search_items' => __('Search Team Member','ux'),
		'cat_slug' => __('team_cat','ux'),
		'cat_menu_name' => __('Team Categories','ux'),
		'columns' => array(
			'column_category' => __('Categories','ux')
		),
		'menu_icon' => UX_PAGEBUILDER. '/images/icon/post-type/team.png'
	
	);
	
	$register['clients_item'] = array(
		'name' => __('Clients','ux'),
		'meta' => true,
		'add_new' => __('Add New','ux'),
		'add_new_item' => __('Add New Client','ux'),
		'edit_item' => __('Edit Client','ux'),
		'new_item' => __('New Client','ux'),
		'view_item' => __('View Client','ux'),
		'not_found' => __('No Client found.','ux'),
		'not_found_in_trash' => __('No Client found in Trash.','ux'),
		'search_items' => __('Search Client','ux'),
		'cat_slug' => __('client_cat','ux'),
		'cat_menu_name' => __('Client Categories','ux'),
		'columns' => array(
			'column_category' => __('Categories','ux')
		),
		'menu_icon' => UX_PAGEBUILDER. '/images/icon/post-type/client.png',
		'remove_support' => array('editor')
	
	);
	
	$register['testimonials_item'] = array(
		'name' => __('Testimonials','ux'),
		'meta' => true,
		'add_new' => __('Add New','ux'),
		'add_new_item' => __('Add New Testimonial','ux'),
		'edit_item' => __('Edit Testimonial','ux'),
		'new_item' => __('New Testimonial','ux'),
		'view_item' => __('View Testimonial','ux'),
		'not_found' => __('No Testimonial found.','ux'),
		'not_found_in_trash' => __('No Testimonial found in Trash.','ux'),
		'search_items' => __('Search Testimonial','ux'),
		'cat_slug' => __('testimonial_cat','ux'),
		'cat_menu_name' => __('Categories','ux'),
		'columns' => array(
			'column_category' => __('Categories','ux')
		),
		'menu_icon' => UX_PAGEBUILDER. '/images/icon/post-type/testimonial.png'
	
	);
	
	$register['jobs_item'] = array(
		'name' => __('Jobs','ux'),
		'meta' => true,
		'add_new' => __('Add New','ux'),
		'add_new_item' => __('Add New Job','ux'),
		'edit_item' => __('Edit Job','ux'),
		'new_item' => __('New Job','ux'),
		'view_item' => __('View Job','ux'),
		'not_found' => __('No Job found.','ux'),
		'not_found_in_trash' => __('No Job found in Trash.','ux'),
		'search_items' => __('Search Job','ux'),
		'cat_slug' => __('job_cat','ux'),
		'cat_menu_name' => __('Job Categories','ux'),
		'columns' => array(
			'column_category' => __('Categories','ux')
		),
		'menu_icon' => UX_PAGEBUILDER. '/images/icon/post-type/jobs.png'
	
	);
	
	$register['faqs_item'] = array(
		'name' => __('FAQs','ux'),
		'meta' => false,
		'add_new' => __('Add New','ux'),
		'add_new_item' => __('Add New Question','ux'),
		'edit_item' => __('Edit Question','ux'),
		'new_item' => __('New Question','ux'),
		'view_item' => __('View Question','ux'),
		'not_found' => __('No Question found.','ux'),
		'not_found_in_trash' => __('No Question found in Trash.','ux'),
		'search_items' => __('Search Question','ux'),
		'cat_slug' => __('question_cat','ux'),
		'cat_menu_name' => __('Topics','ux'),
		'columns' => array(
			'column_category' => __('Categories','ux')
		),
		'menu_icon' => UX_PAGEBUILDER.'/images/icon/post-type/faqs.png'
	);
	
	return $register;
}
add_filter('ux_theme_register_post_type', 'ux_theme_register_other_post_type');

// Register a menu page.
function ux_theme_register_pb_menu() {
    add_menu_page(
        __( 'BM PageBuilder', 'ux' ),
        __( 'BM PageBuilder', 'ux' ),
        'manage_options',
        'bm-pagebuilder',
        'ux_pb_interface_plugin_option'
    );
	add_submenu_page( 'bm-pagebuilder', __( 'Settings', 'ux' ), __( 'Settings', 'ux' ), 'manage_options', 'bm-pagebuilder', 'ux_pb_interface_plugin_option');
}
add_action( 'admin_menu', 'ux_theme_register_pb_menu' );
?>