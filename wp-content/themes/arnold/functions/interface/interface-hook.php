<?php
/****************************************************************/
/*
/* Html
/*
/****************************************************************/

//Action Hook WP Title
add_filter('wp_title', 'arnold_interface_wp_title', 10, 2);

//Action Web Head
add_action('arnold_interface_webhead', 'arnold_interface_webhead_viewport', 10);
//add_action('arnold_interface_webhead', 'arnold_interface_equiv_meta', 10);
add_action('arnold_interface_webhead', 'arnold_interface_webhead_favicon', 15);


/****************************************************************/
/*
/* Wrap
/*
/****************************************************************/

//Action Hook Wrap Before

add_filter('arnold_interface_wrap_before', 'arnold_interface_jplayer', 20);
add_filter('arnold_interface_wrap_before', 'arnold_interface_wrap_outer_before', 25);
add_filter('arnold_interface_wrap_before', 'arnold_interface_page_loading', 15);

//Action Hook Wrap After
add_filter('arnold_interface_wrap_after', 'arnold_interface_wrap_outer_after', 10); 
add_filter('arnold_interface_wrap_after', 'arnold_interface_photoswipe', 20);
add_action('arnold_interface_wrap_after', 'arnold_interface_video_popup', 25);


/****************************************************************/
/*
/* Content
/*
/****************************************************************/

//Action Hook Content Before
add_filter('arnold_interface_content_before', 'arnold_interface_content_before', 5);
add_filter('arnold_interface_content_before', 'arnold_interface_single_feature_image', 10);
add_filter('arnold_interface_content_before', 'arnold_interface_archive_titlewrap', 25);


//Action Hook Content After
add_filter('arnold_interface_content_after', 'arnold_interface_content_after', 10);


/****************************************************************/
/*
/* Sidebar
/*
/****************************************************************/

//Action Hook Sidebar Widget
add_action('arnold_interface_sidebar_widget', 'arnold_interface_sidebar_widget', 10);


/****************************************************************/
/*
/* Archive
/*
/****************************************************************/

//Action Hook Archive Loop
add_action('arnold_interface_archive_loop', 'arnold_interface_archive_loop', 10);

//Action Hook Archive Loop Item
//add_action('arnold_interface_loop_item_after', 'arnold_interface_social_bar_and_navi', 10);

//Action Hook Archive Pagination
add_action('arnold_interface_archive_pagination', 'arnold_interface_pagination', 10, 3);


/****************************************************************/
/*
/* Page
/*
/****************************************************************/

//Action Hook Page Content Before
add_action('arnold_interface_page_content_before', 'arnold_interface_page_content_before', 10);
add_action('arnold_interface_page_content_before', 'arnold_interface_page_feature_image', 15);
add_filter('arnold_interface_content_before', 'arnold_interface_content_page_slider', 20);
add_action('arnold_interface_page_content_before', 'arnold_interface_page_title', 20);

//Action Hook Page Content After
add_action('arnold_interface_page_content_after', 'arnold_interface_page_content_after', 10);

//Action Hook Page Content
add_action('arnold_interface_page_content', 'arnold_interface_page_content', 10);
add_action('arnold_interface_page_content', 'arnold_interface_pagebuilder', 20);
add_action('arnold_interface_page_content', 'arnold_interface_page_comment', 30);


/****************************************************************/
/*
/* Single
/*
/****************************************************************/



//Action Hook Single Content Before
add_action('arnold_interface_single_content_before', 'arnold_interface_single_content_before', 10);
//Action Hook Single Content Before video cover
add_action('arnold_interface_single_content_before', 'arnold_interface_single_content_video_cover', 5);

//Action Hook Single Content After
add_action('arnold_interface_single_content_after', 'arnold_interface_single_content_after', 11);

//Action Hook Single Content
add_action('arnold_interface_single_content', 'arnold_interface_single_content', 10);
add_action('arnold_interface_single_content', 'arnold_interface_pagebuilder', 15);
add_action('arnold_interface_single_content', 'arnold_interface_social_bar_and_navi', 21); 
add_action('arnold_interface_single_content', 'arnold_interface_single_comment', 30);

//Action Hook Single Content Before - Title
add_filter('arnold_interface_single_article_inn_before', 'arnold_interface_content_titlewrap', 10);
//Action Hook Single Article Inn before
//add_action('arnold_interface_single_article_inn_before', 'arnold_interface_single_content_inn', 5);


/****************************************************************/
/*
/* Header
/*
/****************************************************************/

//Action Hook Header
add_filter('arnold_interface_header', 'arnold_interface_header', 10);
add_filter('arnold_interface_header', 'arnold_interface_menu_hidden_panel', 10);

/****************************************************************/
/*
/* Footer
/*
/****************************************************************/

//Action Hook Footer
add_action('arnold_interface_footer', 'arnold_interface_footer', 10);
	
?>