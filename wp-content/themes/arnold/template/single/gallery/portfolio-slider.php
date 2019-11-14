<?php
//** get portfolio image
$portfolio = arnold_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');

$data_lazy = $image_lazyload ? 'true' : 'false';

if($portfolio){ ?>

    <div class="blog-unit-gallery-wrap single-fullwidth-slider-wrap">
    
        <div class="owl-carousel" data-item="3" data-center="true" data-margin="30" data-autowidth="true" data-slideby="1" data-showdot="false" data-nav="true" data-loop="true" data-lazy="<?php echo esc_attr($data_lazy); ?>">
            
            <?php foreach($portfolio as $image){
				$thumb_width = 1000;
				$thumb_height = '';
				$thumb_url = get_template_directory_uri(). '/img/blank.gif';
				
                $thumb = wp_get_attachment_image_src($image, 'arnold-standard-thumb-medium');
				
				if($thumb){
					$thumb_width = $thumb[1];
					$thumb_height = $thumb[2];
					$thumb_url = $thumb[0];
				}
				
				$image_lazyload_img_style = 'src="' .esc_url($thumb_url). '" data-src="' .esc_url($thumb_url). '"';
				if(!$image_lazyload){
					$image_lazyload_img_style = 'src="' .esc_url($thumb_url). '"';
				} ?>
                
                <section class="item">
                    <div class="carousel-img-wrap"><img width="<?php echo esc_attr($thumb_width); ?>" height="<?php echo esc_attr($thumb_height); ?>" alt="<?php echo get_the_title($image); ?>" title="<?php echo get_the_title($image); ?>" <?php echo balanceTags($image_lazyload_img_style); ?> class="single-fullwidth-slider-carousel-img"></div>
                </section>
            <?php } ?>
         </div> 
    </div>

<?php } ?>