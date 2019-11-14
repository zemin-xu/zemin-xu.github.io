<?php get_header(); ?>

	<div id="content">
        
		<?php while(have_posts()){ the_post(); ?>
        
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
                <?php 
                //** Do Hook Page before
				/**
				 * @hooked  arnold_interface_page_content_before - 10
				 * @hooked  arnold_interface_page_feature_image - 15
				 * @hooked  airtheme_interface_content_page_slider - 20
				 * @hooked  arnold_interface_page_title - 20
				 */
				do_action('arnold_interface_page_content_before'); ?>
                
                <div id="content_wrap" <?php arnold_interface_content_class(); ?>>
                
                    <?php
					//** Do Hook Page Article before
					do_action('arnold_interface_page_article_before');
					
					//** Do Hook Page content
					/**
					 * @hooked  arnold_interface_page_content - 10
					 * @hooked  arnold_interface_pagebuilder - 20
					 * @hooked  arnold_interface_page_comment - 30
					 */
					do_action('arnold_interface_page_content');
					
					//** Do Hook Page Article after
					do_action('arnold_interface_page_article_after'); ?>

                    
                </div><!--End content_wrap-->
    
                <?php //** Do Hook Sidebar Widget
                /**
                 * @hooked  arnold_interface_sidebar_widget - 10
                 */
                do_action('arnold_interface_sidebar_widget');
                    
                //** Do Hook Page after
				/**
				 * @hooked  arnold_interface_page_content_after - 10
				 */
                do_action('arnold_interface_page_content_after'); ?>   
            
            </div><!--end #postID-->    
        
        <?php } ?>      
    
    </div><!--End content-->
	
<?php get_footer(); ?>