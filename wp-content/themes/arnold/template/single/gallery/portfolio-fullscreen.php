<?php
//** get portfolio image
$portfolio = arnold_get_post_meta(get_the_ID(), 'theme_meta_portfolio');

$image_lazyload = arnold_get_option('theme_option_enable_image_lazyload');

$data_lazy = $image_lazyload ? 'true' : 'false';

if($portfolio){ ?>

    <div class="blog-unit-gallery-wrap fullscreen-wrap">
    
        <div id="ux-slider-down"></div>
        <?php arnold_get_template_part('single/gallery/portfolioslider', 'navi'); ?>
        <div class="owl-carousel" data-item="1" data-center="false" data-margin="0" data-autowidth="false" data-slideby="1" data-showdot="true" data-nav="false" data-loop="false" data-lazy="<?php echo esc_attr($data_lazy); ?>">
            <?php foreach($portfolio as $image){
				$thumb_url = get_template_directory_uri(). '/img/blank.gif';
                $thumb = wp_get_attachment_image_src($image, 'full');
				if($thumb){
					$thumb_url = $thumb[0];
				}
				
				$image_lazyload_style = 'data-bg="' .esc_url($thumb_url). '"';
				if(!$image_lazyload){
					$image_lazyload_style = 'style="background-image:url(' .esc_url($thumb_url). ');"';
				} ?>
                <section class="fullscreen-wrap item">
                    <div class="carousel-img-wrap fullscreen-wrap ux-background-img" <?php echo balanceTags($image_lazyload_style); ?>></div>
                </section>
            <?php } ?>
         </div>
    </div>
<?php } ?>