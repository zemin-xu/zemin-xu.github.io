<?php get_header(); ?>
        
	<?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>
   
    <div id="content">
    
		<?php //** Do Hook Archive before
		do_action('arnold_interface_archive_before'); ?>
        
        <div class="content_wrap_outer two-cols-layout"> 
            
            <div class="container-fluid sidebar-layout">
                <div class="row">
                    <div id="content_wrap" class="col-md-9 col-sm-9"> 
        
                        <!--Ahthor info.-->
                        <section class="list-author-unit author-info-page container-inn">
                            <div class="author-avatar"><?php echo get_avatar(get_the_author_meta('ID'), 120); ?></div>
                            <ul class="socialmeida">
                                <?php if(get_the_author_meta('ux_facebook')){ echo '<li class="socialmeida-li"><a class="socialmeida-a" href="' .esc_url(get_the_author_meta('ux_facebook')). '"><span class="fa fa-facebook"></span></a></li>'; }
                                
                                if(get_the_author_meta('ux_twitter')){ echo '<li class="socialmeida-li"><a class="socialmeida-a" href="' .esc_url(get_the_author_meta('ux_twitter')). '"><span class="fa fa-twitter"></span></a></li>'; }
        
                                if(get_the_author_meta('ux_googleplus')){ echo '<li class="socialmeida-li"><a class="socialmeida-a" href="' .esc_url(get_the_author_meta('ux_googleplus')). '"><span class="fa fa-google-plus"></span></a></li>'; }
        
                                if(get_the_author_meta('ux_linkedin')){ echo '<li class="socialmeida-li"><a class="socialmeida-a" href="' .esc_url(get_the_author_meta('ux_linkedin')). '"><span class="fa fa-linkedin"></span></a></li>'; }
                                
                                if(get_the_author_meta('ux_youtube')){ echo '<li class="socialmeida-li"><a class="socialmeida-a" href="' .esc_url(get_the_author_meta('ux_youtube')). '"><span class="fa fa-youtube"></span></a></li>'; }
                                
                                if(get_the_author_meta('ux_pinterest')){ echo '<li class="socialmeida-li"><a class="socialmeida-a" href="' .esc_url(get_the_author_meta('ux_pinterest')). '"><span class="fa fa-pinterest"></span></a></li>'; }
                                
                                if(get_the_author_meta('ux_github_alt')){ echo '<li class="socialmeida-li"><a class="socialmeida-a" href="' .esc_url(get_the_author_meta('ux_github_alt')). '"><span class="fa fa-github-alt"></span></a></li>'; } ?>
                            </ul>
                            <h1 class="author-tit"><a class="author-tit-a" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php the_author_meta('display_name'); ?>"><?php the_author(); ?></a></h1>
                            <?php if(get_the_author_meta('description')){ ?><div class="author-excerpt"><?php the_author_meta('description'); ?></div><?php } ?>
                            
                        </section>
                        
                        <?php //** Do Hook Archive loop
                        /**
                         * @hooked  arnold_interface_archive_loop - 10
                         */
                        do_action('arnold_interface_archive_loop'); ?>
                        
                    </div>
                    
                    <?php //** Do Hook Sidebar Widget
					/**
					 * @hooked  arnold_interface_sidebar_widget - 10
					 */
					do_action('arnold_interface_sidebar_widget'); ?>
                    
                </div>
            </div>
        </div>
    </div>
  
<?php get_footer(); ?>