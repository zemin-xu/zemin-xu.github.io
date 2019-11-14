<?php
if(is_page()){
	$switch = false;
	
	$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
	$show_title = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_title');
	
	if($page_template == 'none'){
		$switch = true;
	}
	
	if($switch && $show_title){ ?>
        <div class="title-wrap container">
            <div class="title-wrap-con">
                <h1 class="title-wrap-h1"><?php the_title(); ?></h1>
                <div class="title-wrap-des"><?php the_excerpt(); ?></div>
            </div>
        </div>
	<?php
    }
}
?>