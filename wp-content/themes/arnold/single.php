<?php get_header(); ?>

	<div id="content">

		<?php while(have_posts()){ the_post(); ?>
        
            <?php //** Do Hook Single summary
			do_action('arnold_interface_single_summary'); ?>
            
            
			<?php //** Do Hook Single before
            /**
             * @hooked  arnold_interface_single_content_before 10
             */
            do_action('arnold_interface_single_content_before'); ?>
            
            <div id="content_wrap" <?php arnold_interface_content_class(); ?>>
                
                <?php //** Do Hook Single Article before
				/**
				 * @hooked  arnold_interface_content_titlewrap - 10
				 */
				
				do_action('arnold_interface_single_article_before'); ?>
                
                
                <article id="post-<?php the_ID(); ?>" <?php arnold_interface_post_class(); ?>>
                
                    <?php //** Do Hook Single Article Inn before
                    /**
                     * @hooked  arnold_interface_single_content_inn - 5
                     */
					do_action('arnold_interface_single_article_inn_before'); ?>
                    
					<?php //** Do Hook Page content
                    /**
                     * @hooked  arnold_interface_single_content - 10
                     * @hooked  arnold_interface_pagebuilder - 15
                     * @hooked  arnold_interface_social_bar_and_navi - 21
                     * @hooked  arnold_interface_single_comment - 30
                     */
                    do_action('arnold_interface_single_content'); ?>
                    
                </article><!--end article-->
                
                 <?php //** Do Hook Single Article after
				do_action('arnold_interface_single_article_after'); ?>

            </div><!--End content_wrap-->

            <?php //** Do Hook Sidebar Widget
            /**
             * @hooked  arnold_interface_sidebar_widget - 10
             */
            do_action('arnold_interface_sidebar_widget'); ?>
                
            <?php //** Do Hook Single after
            /**
			 * @hooked  arnold_interface_single_related - 10
             * @hooked  arnold_interface_single_content_after 11
             */
            do_action('arnold_interface_single_content_after'); ?>
        
        <?php } ?>
    
    </div><!--End content-->
	
<?php get_footer(); ?>