<?php
//template
$gallery_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_template');

//width
$gallery_width = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_width');

$gallery_col_class = '';
$gallery_width_class = '';
if($gallery_template == 'standard' || $gallery_template == 'big-title'){
	switch($gallery_width){
		case 'normal' : $gallery_width_class = 'container'; break;
	}
}
?>

<div class="<?php echo sanitize_html_class($gallery_col_class); ?> gallery-spacing-20 blog-unit-gallery-wrap <?php echo esc_attr($gallery_width_class); ?>">

    <div class="single-gallery-wrap-inn">

		<?php
		$gallery_video_position = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_video_position');
		
		if($gallery_video_position == 'top'){
			//Video
			arnold_get_template_part('single/gallery/portfolio', 'video');
		}
		
        //** get portfolio image
        $portfolio = arnold_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
        
        //** get portfolio list layout builder
        $layout_builder = arnold_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_list_layout_builder');
		
		$index = -1;
        
        if($portfolio){
            $portfolio_count = count($portfolio);
			$layout_end = end($layout_builder);
			$layout_class = 'list-layout-col1'; ?>
            <div class="list-layout lightbox-photoswipe" data-gap="20">
                <?php 
                if($layout_builder){
                    foreach($layout_builder as $num => $layout){
						if($layout == 'list_layout_5'){ ?>
                            <div class="list-layout-col list-layout-col1 clearfix">
                                <?php arnold_interface_portfolio_template_layout(0, 'list_layout_5', $num); ?>
                            </div>
						<?php
                        }else{
							if($index + 1 <= $portfolio_count){
								switch($layout){
									case 'list_layout_1': $i = 1; $layout_class = 'list-layout-col1'; break;
									case 'list_layout_2': $i = 2; $layout_class = 'list-layout-col2'; break;
									case 'list_layout_3': $i = 3; $layout_class = 'list-layout-col3'; break;
									case 'list_layout_4': $i = 4; $layout_class = 'list-layout-col4'; break;
								} ?>
								
								<div class="list-layout-col <?php echo sanitize_html_class($layout_class); ?> clearfix">
									<?php for($ii=0; $ii<$i; $ii++){ $index++;
										if(isset($portfolio[$index])){
											arnold_interface_portfolio_template_layout($portfolio[$index], $layout, $num);
										}
									} ?>
								</div>
							<?php
							}
						}
                    }
                }
				
				if($index + 1 <= $portfolio_count){
					$remaining = $portfolio_count - ($index + 1);
					if($remaining > 0){
						switch($layout_end){
							case 'list_layout_1': $i = 1; $layout_class = 'list-layout-col1'; break;
							case 'list_layout_2': $i = 2; $layout_class = 'list-layout-col2'; break;
							case 'list_layout_3': $i = 3; $layout_class = 'list-layout-col3'; break;
							case 'list_layout_4': $i = 4; $layout_class = 'list-layout-col4'; break;
							case 'list_layout_5': $i = 1; $layout_class = 'list-layout-col1'; break;
						}
						
						$row = ceil($remaining / $i);
						for($ii=0; $ii<$row; $ii++){ ?>
                            <div class="list-layout-col <?php echo sanitize_html_class($layout_class); ?> clearfix">
								<?php for($iii=0; $iii<$i; $iii++){ $index++;
                                    if(isset($portfolio[$index])){
                                        arnold_interface_portfolio_template_layout($portfolio[$index], $layout_end);
                                    }
                                } ?>
                            </div>
                        <?php	
						}
					}
				} ?>
            </div>
        <?php
		}
		
		if($gallery_video_position == 'bottom'){
			//Video
			arnold_get_template_part('single/gallery/portfolio', 'video');
		} ?>
    
    </div>
</div>