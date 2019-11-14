<?php
$enable_slider = arnold_get_post_meta(get_the_ID(), 'theme_meta_enable_slider');
$slider_source = arnold_get_post_meta(get_the_ID(), 'theme_meta_slider_source');
$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');

if($page_template != 'none' && $page_template != 'blog-masonry'){
	if($enable_slider){
		switch($slider_source){
			case 'revolution-slider':
				$revolution_slider = arnold_get_post_meta(get_the_ID(), 'theme_meta_select_revolution_slider');
				if($revolution_slider && function_exists('putRevSlider')){ ?>
					<?php putRevSlider($revolution_slider); ?>
				<?php
				}
			break;
			
			case 'bmslider':
				$bmslider = arnold_get_post_meta(get_the_ID(), 'theme_meta_select_bmslider');
				if($bmslider && post_type_exists('bmslider')){ ?>
                    
                    <?php ux_theme_bmslider($bmslider);  ?>
                    
				<?php
				}
			break;
		}
	}
}

?>