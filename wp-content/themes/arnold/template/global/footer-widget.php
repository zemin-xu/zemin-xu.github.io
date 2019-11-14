<?php
if(is_singular('post')){
	
	$sidebar_widget = arnold_get_option('theme_option_footer_widget_for_posts');
	$switch_sidebar = arnold_get_option('theme_option_enable_footer_widget_for_posts');
	
	if($switch_sidebar){ ?>
        <div class="widget_footer">
            <div class="container">
                <div class="row">
                    <?php if($sidebar_widget){
						arnold_dynamic_sidebar($sidebar_widget, 3);
					} ?>
                </div>
            </div>
        </div>
    
    <?php
	}
} ?>