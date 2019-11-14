<?php
//fullwidth template
function ux_pb_module_fullwidth($arg){
	$itemid      = $arg['itemid'];
	$items       = $arg['items'];
	
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	//fullwrap confing
	$fullwrap_name              = get_post_meta($module_post, 'module_fullwidth_anchor_name', true);
	$fullwrap_type              = get_post_meta($module_post, 'module_fullwidth_type', true);
	$fullwrap_bgImage           = get_post_meta($module_post, 'module_fullwidth_background_image', true);
	$fullwrap_bgRatio           = get_post_meta($module_post, 'module_fullwidth_background_ratio', true);
	$fullwrap_innerWidth        = get_post_meta($module_post, 'module_fullwidth_inner_width', true);
	$fullwrap_tab_class         = $fullwrap_type == 'tab' ? ' fullwrap-tab-class' : false;
	
	//spacer
	$fullwrap_spacerInTop       = get_post_meta($module_post, 'module_fullwidth_spacer_in_top', true);
	$fullwrap_spacerInBottom    = get_post_meta($module_post, 'module_fullwidth_spacer_in_bottom', true);
	$fullwrap_spacerTop         = get_post_meta($module_post, 'module_fullwidth_spacer_top', true);
	$fullwrap_spacerBottom      = get_post_meta($module_post, 'module_fullwidth_spacer_bottom', true);
	$spacer_class               = '';
	$spacer_class_in            = '';
	if($fullwrap_spacerTop      == 'on'){ $spacer_class .= 'top-space-40 '; }
	if($fullwrap_spacerBottom   == 'on'){ $spacer_class .= 'bottom-space-40 '; }
	if($fullwrap_spacerInTop    == 'on'){
		$spacer_class_in .= 'top-space-80-in ';
		if($fullwrap_type != 'half-image' && $fullwrap_type != 'half-video'){
			$spacer_class .= 'top-space-80-in ';
		}
	}
	if($fullwrap_spacerInBottom == 'on'){
		$spacer_class_in .= 'bottom-space-40-in ';
		if($fullwrap_type != 'half-image' && $fullwrap_type != 'half-video'){
			$spacer_class .= 'bottom-space-40-in ';
		}
	}
	
	//height style
	$fullwrap_heightType = get_post_meta($module_post, 'module_fullwidth_height_type', true);
	$fullwrap_height     = get_post_meta($module_post, 'module_fullwidth_height', true);
	$height_class        = false;
	$height_style        = false;
	$height_data         = false;
	$browser_class       = false;
	if($fullwrap_heightType == 'static'){
		$height_class = 'height-no-auto';
		$height_style = 'height: 500px;';
		$height_data  = 'data-height="500"';
		if(!empty($fullwrap_height)){
			$height_style = 'height: ' .esc_attr($fullwrap_height). 'px;';
			$height_data  = 'data-height="' .esc_attr($fullwrap_height). '"';
		}
	}elseif($fullwrap_heightType == 'browser'){
		$browser_class = 'fullscreen-wrap';
	}
	
	//shadow border
	$fullwrap_shadow = get_post_meta($module_post, 'module_fullwidth_shadow', true);
	$fullwrap_border = false;
	if($fullwrap_shadow == 'on'){
		$fullwrap_border = 'fullwrap-border';
	}
	
	//background color
	$fullwrap_bgColor      = get_post_meta($module_post, 'module_fullwidth_background_color', true);
	$fullwrap_bgSwitch     = get_post_meta($module_post, 'module_fullwidth_background_switch_color', true);
	$fullwrap_bgColorStyle = false;
	$fullwrap_bgColor      = $fullwrap_bgColor ? 'bg-' . ux_theme_switch_color($fullwrap_bgColor) : false;
	if($fullwrap_bgSwitch){
		$fullwrap_bgColorStyle = 'background-color: ' .esc_attr($fullwrap_bgSwitch). ';';
		$fullwrap_bgColor = false;
	}
	
	//dark background
	$fullwrap_darkBg = get_post_meta($module_post, 'module_fullwidth_dark_background', true);
	$fullwrap_darkBg = $fullwrap_darkBg == 'on' ? 'fullwidth-text-white' : false;
	
	//fit content
	$fullwrap_fitContent       = get_post_meta($module_post, 'module_fullwidth_fit_content', true);
	$fullwrap_fitContentBefore = $fullwrap_fitContent != 'on' ? '<div class="container-fluid">' : false;
	$fullwrap_fitContentAfter  = $fullwrap_fitContent != 'on' ? '</div>' : false;
	
	//fullwrap video wrap
	$fullwrap_videoWebm = get_post_meta($module_post, 'module_fullwidth_video_webm', true);
	$fullwrap_videoMp4  = get_post_meta($module_post, 'module_fullwidth_video_mp4', true);
	$fullwrap_videoOgg  = get_post_meta($module_post, 'module_fullwidth_video_ogg', true);
	$fullwrap_altImage  = get_post_meta($module_post, 'module_fullwidth_alt_image', true);
	$fullwrap_video     = '<div class="fullwrap-video">';
	$fullwrap_video    .= '<video autoplay loop poster="' .esc_attr($fullwrap_altImage). '" class="centered-ux">';
	$fullwrap_video    .= $fullwrap_videoWebm ? '<source src="' .esc_url($fullwrap_videoWebm). '" type="video/webm">' : false;
	$fullwrap_video    .= $fullwrap_videoMp4 ? '<source src="' .esc_url($fullwrap_videoMp4). '" type="video/mp4">' : false;
	$fullwrap_video    .= $fullwrap_videoOgg ? '<source src="' .esc_url($fullwrap_videoOgg). '" type="video/ogg">' : false;
	$fullwrap_video    .= '</video>';
	$fullwrap_video    .= '<div class="video-cover" ';
	$fullwrap_video    .= $fullwrap_altImage ? 'style="background-image: url(' .esc_url($fullwrap_altImage). ');"' : false;
	$fullwrap_video    .= '></div>';
	$fullwrap_video    .= '</div>';
	$fullwrap_video_ie  = '<div class="fullwrap-video">';
	$fullwrap_video_ie .= '<div class="video-cover" ';
	$fullwrap_video_ie .= $fullwrap_altImage ? 'style="background-image: url(' .esc_url($fullwrap_altImage). ');"' : false;
	$fullwrap_video_ie .= '></div>';
	$fullwrap_video_ie .= '</div>';
	
	//anchor name
	if($fullwrap_name){
		$fullwrap_name = str_replace(' ', '-', $fullwrap_name);
		?>	
		<a name="<?php echo esc_attr($fullwrap_name); ?>" class="fullwidth-anchor-name"></a>
	<?php 
		$fullwrap_name_warp = ' id="'.$fullwrap_name.'" ';
	} else {
		$fullwrap_name_warp = false; 
	}
	
	//standard
	if($fullwrap_type == 'standard-color' || $fullwrap_type == 'standard-image' || $fullwrap_type == 'standard-video' || $fullwrap_type == 'tab'){
		$fullwrap_overflow = get_post_meta($module_post, 'module_fullwidth_show_overflow_visible', true);
		$fullwrap_overflow = $fullwrap_overflow == 'on' ? 'fullwidth_over_visibale' : false;
		
		if($fullwrap_type != 'standard-color' && $fullwrap_type != 'tab'){
			$fullwrap_bgColor = false;
			$fullwrap_bgColorStyle = false;
		} ?>
        <div <?php echo balanceTags($fullwrap_name_warp); ?> class="fullwidth-wrap <?php echo sanitize_html_class($fullwrap_tab_class); ?> <?php echo sanitize_html_class($fullwrap_border); ?> <?php echo sanitize_html_class($fullwrap_bgColor); ?> <?php echo esc_attr($spacer_class); ?> <?php echo sanitize_html_class($fullwrap_darkBg); ?> <?php echo sanitize_html_class($fullwrap_overflow); ?> <?php echo sanitize_html_class($height_class); ?> <?php echo sanitize_html_class($browser_class); ?>" style=" <?php echo esc_attr($height_style); ?> <?php echo esc_attr($fullwrap_bgColorStyle); ?>" <?php echo balanceTags($height_data); ?>>
        
			<?php if($fullwrap_type == 'standard-image'){ ?>
                <div data-type="background" class="parallax back-background" data-ratio="<?php echo esc_attr($fullwrap_bgRatio); ?>">
                    <?php if($fullwrap_bgImage){ ?>
                    <img class="back-background-img" src="<?php echo esc_url($fullwrap_bgImage); ?>" alt="<?php the_title(); ?>">
                    <div class="back-background-img-mobile" style="background-image:url(<?php echo esc_url($fullwrap_bgImage); ?>)"></div>
                    <?php } ?>
                </div>
            <?php }
			
			$fullwrap_foreground = get_post_meta($module_post, 'module_fullwidth_foreground', true);
			if($fullwrap_type != 'tab' && $fullwrap_foreground){
				$foreground_image = $fullwrap_foreground['image'];
				
				foreach($foreground_image as $num => $image){
					$ratio = $fullwrap_foreground['ratio'][$num];
					$background_speed = 'data-ratio="' .esc_attr($ratio). '"';
					$num = 999 - $num;
					$zindex = 'z-index: ' . $num . ';'; ?>
                
                    <!--Front End Background for parallax-->
                    <div class="front-background parallax" <?php echo balanceTags($background_speed); ?> style=" <?php echo esc_attr($zindex); ?>">
                        <?php if($image != ''){ ?><img class="front-background-img" src="<?php echo esc_url($image); ?>"><?php } ?>
                    </div>
                    
                <?php
				}
			}
			
			if($fullwrap_shadow == 'on'){
				echo '<div class="fullwrap-shadow"></div>';
			}
			
			if($fullwrap_type == 'standard-video'){
				if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT'])) {
            		echo balanceTags($fullwrap_video_ie);
            	} else {
            		echo balanceTags($fullwrap_video);
            	}
			}
			
			if($fullwrap_type == 'tab'){
				$fullwrap_tab = get_post_meta($module_post, 'module_fullwidth_tabs', true);
				if($fullwrap_tab){ ?>
					<nav class="fullwrap-with-tab-nav" data-itemid="<?php echo esc_attr($itemid); ?>">
						<?php if(is_array($fullwrap_tab)){
							foreach($fullwrap_tab as $i => $tab){ 
								echo '<a class="fullwrap-with-tab-nav-a" href="javascript:;">' . esc_html($tab) . '</a>';
							}
						}else{
							echo '<a class="fullwrap-with-tab-nav-a" href="javascript:;">' . esc_html($fullwrap_tab) . '</a>';
						} ?>
					</nav>
				<?php
				}
			}
			
			echo balanceTags($fullwrap_fitContentBefore);
			if($items){
				echo '<div class="fullwidth-wrap-inn"><div class="row '.sanitize_html_class($fullwrap_innerWidth).'">';
				foreach($items as $i => $item){
					$col = $item['col'];
					$type = $item['type'];
					$first = $item['first'];
					$itemid = $item['itemid'];
					$moduleid = $item['moduleid'];
					
					if($first == 'is'){
						if($i != 0){
							echo '</div>';
							echo '<div class="row '.sanitize_html_class($fullwrap_innerWidth).'">';
						}
					}
					
					ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, false, 'module');
				}
				echo '</div></div>';
			}
			echo balanceTags($fullwrap_fitContentAfter); ?>
        
        </div>
    <?php	
	
	//half
	}elseif($fullwrap_type == 'half-image' || $fullwrap_type == 'half-video'){
		$fullwrap_contentAlign = get_post_meta($module_post, 'module_fullwidth_half_content_align', true);
		$fullwrap_fgColor      = get_post_meta($module_post, 'module_fullwidth_foreground_color', true);
		$fullwrap_fgSwitch     = get_post_meta($module_post, 'module_fullwidth_foreground_switch_color', true);
		$fullwrap_fgColorStyle = false;
		$fullwrap_fgColor      = $fullwrap_fgColor ? 'bg-' . ux_theme_switch_color($fullwrap_fgColor) : false;
		if($fullwrap_bgSwitch){
			$fullwrap_fgColorStyle = 'background-color: ' .esc_attr($fullwrap_fgSwitch). ';';
			$fullwrap_fgColor = false;
		} ?>
        <div <?php echo balanceTags($fullwrap_name_warp); ?> class="fullwidth-wrap fullwidth-half <?php echo esc_attr($spacer_class); ?> <?php echo sanitize_html_class($fullwrap_darkBg); ?> <?php echo sanitize_html_class($height_class); ?> <?php echo sanitize_html_class($browser_class); ?>" style=" <?php echo esc_attr($height_style); ?>" <?php echo balanceTags($height_data); ?>>
        
            <div class="full-half-inn">
                <div class="row <?php echo sanitize_html_class($height_class); ?>" style=" <?php echo esc_attr($height_style); ?>">
                
					<?php if($fullwrap_contentAlign == 'right'){ ?>	
                        <!--Fullwidth wrap Half - BG -->
                        <div class="col-md-6 col-sm-6 fullwrap-half fullwrap-half-bg <?php echo esc_attr($spacer_class_in); ?>"> 
                            <?php if($fullwrap_type == 'half-image'){ ?>
                                <div data-type="background" class="parallax back-background" data-ratio="<?php echo esc_attr($fullwrap_bgRatio); ?>">
                                    <?php if($fullwrap_bgImage){ ?><img class="back-background-img" src="<?php echo esc_url($fullwrap_bgImage); ?>" alt="<?php the_title(); ?>"><?php } ?>
                                </div>
                            <?php }
                            
                            if($fullwrap_type == 'half-video'){
                            	if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT'])) {
                            		echo balanceTags($fullwrap_video_ie);
                            	} else {
                            		echo balanceTags($fullwrap_video);
                            	}
                                
                            }; ?>
                        </div>
                    <?php } ?>
                    
                    <!--Fullwidth wrap Half - content -->
                    <div class="col-md-6 col-sm-6 fullwrap-half fullwrap-half-content <?php echo esc_attr($spacer_class_in); ?> <?php echo sanitize_html_class($fullwrap_fgColor); ?>" style=" <?php echo esc_attr($fullwrap_fgColorStyle); ?>">
                        <?php if($items){
                            echo '<div class="fullwidth-wrap-inn"><div class="row">';
                            foreach($items as $i => $item){
                                $col = $item['col'];
                                $type = $item['type'];
                                $first = $item['first'];
                                $itemid = $item['itemid'];
                                $moduleid = $item['moduleid'];
                                
                                if($first == 'is'){
                                    if($i != 0){
                                        echo '</div>';
                                        echo '<div class="row">';
                                    }
                                }
                                
                                ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, false, 'module');
                            }
                            echo '</div></div>';
                        } ?>
                    </div>
                    
					<?php if($fullwrap_contentAlign != 'right'){ ?>	
                        <!--Fullwidth wrap Half - BG -->
                        <div class="col-md-6 col-sm-6 fullwrap-half fullwrap-half-bg <?php echo esc_attr($spacer_class_in); ?>"> 
                            <?php if($fullwrap_type == 'half-image'){ ?>
                                <div data-type="background" class="parallax back-background" data-ratio="<?php echo esc_attr($fullwrap_bgRatio); ?>">
                                    <?php if($fullwrap_bgImage){ ?><img class="back-background-img" src="<?php echo esc_url($fullwrap_bgImage); ?>" alt="<?php the_title(); ?>"><?php } ?>
                                </div>
                            <?php }
                            
                            if($fullwrap_type == 'half-video'){
                                if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT'])) {
                            		echo balanceTags($fullwrap_video_ie);
                            	} else {
                            		echo balanceTags($fullwrap_video);
                            	}
                            }; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
	<?php
	
	//block	
	}
	/*elseif($fullwrap_type == 'block'){
		$fullwrap_block_column = get_post_meta($module_post, 'module_fullwidth_block_column', true); ?>
		<div <?php echo balanceTags($fullwrap_name_warp); ?> class="fullwidth-wrap fullwrap-block-style <?php echo sanitize_html_class($height_class); ?> <?php echo sanitize_html_class($browser_class); ?>" style=" <?php echo esc_attr($height_style); ?>">
            <div class="row" style=" <?php echo esc_attr($height_style); ?>">
                <div class="fullwrap-block" style=" <?php echo esc_attr($height_style); ?>">
                
					<?php
					$column = 2; $column_class = 'span6 fullwrap-block-half';
					if($fullwrap_block_column == 'three-column'){
                        $column = 3;
						$column_class = 'span4 fullwrap-block-one-third';
                    }
					for($i=1; $i<=$column; $i++){
						$block_ID               = 'fullwrap_block_'.$module_post.'_'.$i;
						
						$block_bgColor          = get_post_meta($module_post, 'module_fullwidth_block_column_'.$i.'_background_color', true);
						$block_bgSwitch         = get_post_meta($module_post, 'module_fullwidth_block_column_'.$i.'_background_switch_color', true);
						$block_bgOverColor      = get_post_meta($module_post, 'module_fullwidth_block_column_'.$i.'_mouseover_color', true);
						$block_bgOverSwitch     = get_post_meta($module_post, 'module_fullwidth_block_column_'.$i.'_mouseover_switch_color', true);
						$block_darkBg           = get_post_meta($module_post, 'module_fullwidth_block_column_'.$i.'_dark_background', true);
						$block_darkOverBg       = get_post_meta($module_post, 'module_fullwidth_block_column_'.$i.'_dark_mouseover_background', true);
						$block_rows             = get_post_meta($module_post, 'module_fullwidth_block_column_'.$i.'_rows', true);
						
						$block_darkBg           = $block_darkBg == 'on' ? 'fullwidth-text-white' : false;
						$block_darkBgHover      = $block_darkOverBg == 'on' ? 'fullwidth-text-white-hover' : false;
						
						$block_bgColorStyle     = false;
						$block_bgColor          = $block_bgColor ? 'bg-' . ux_theme_switch_color($block_bgColor) : false;
						$block_bgOverColorStyle = false;
						$block_bgOverColor      = $block_bgOverColor ? 'bg-' . ux_theme_switch_color($block_bgOverColor) . '-hover' : false;
						
						$iNum = $i - 1;
						
						if($block_bgSwitch){
							$block_bgColorStyle = 'background-color: ' .esc_attr($block_bgSwitch). ';';
							$block_bgColor = false;
						}
						
						if($block_bgOverSwitch){
							$block_bgOverColorStyle = 'background-color: ' .esc_attr($block_bgOverSwitch). '!important;';
							$block_bgOverColor = false;
						}
						
						echo '<div id="' .esc_attr($block_ID). '" class="' .esc_attr($column_class). ' fullwrap-block-inn ' .sanitize_html_class($block_bgColor). ' ' .sanitize_html_class($block_bgOverColor). ' ' .sanitize_html_class($block_darkBg). ' ' .sanitize_html_class($block_darkBgHover). ' ' .esc_attr($spacer_class). '" style="' .esc_attr($block_bgColorStyle). ' ' .esc_attr($height_style). '">';
						if($items){
							foreach($items as $num => $item){
								$col = $item['col'];
								$type = $item['type'];
								$first = $item['first'];
								$itemid = $item['itemid'];
								$moduleid = $item['moduleid'];
								
								if($num == $iNum){
									echo '<div class="row">';
									ux_pb_module_interface_template(12, $type, 'is', $itemid, $moduleid, false, 'module');
									echo '</div>';
								}
								
							}
						}
						
						echo '</div>';
						
						if($block_bgOverSwitch){
							echo '<style type="text/css">#' .esc_attr($block_ID). ':hover{' .esc_attr($block_bgOverColorStyle). '}</style>';
						}
					} ?>
                </div><!--End fullwrap-block-->
            </div>
        </div>
	<?php
    }*/
}
add_action('ux-pb-module-template-fullwidth', 'ux_pb_module_fullwidth');

//fullwidth select fields
function ux_pb_module_fullwidth_select($fields){
	$fields['module_fullwidth_half_content_align'] = array(
		array('title' => __('Left','ux'), 'value' => 'left'),
		array('title' => __('Right','ux'), 'value' => 'right')
	);
	
	$fields['module_fullwidth_background_repeat'] = array(
		array('title' => __('Fill','ux'), 'value' => 'fill'),
		array('title' => __('Repeat','ux'), 'value' => 'repeat')
	);
	
	$fields['module_fullwidth_background_attachment'] = array(
		array('title' => __('Parallax','ux'), 'value' => 'parallax'),
		//array('title' => __('Fixed','ux'), 'value' => 'fixed'),
		array('title' => __('Scroll','ux'), 'value' => 'scroll')
	);
	
	$fields['module_fullwidth_background_ratio'] = array(
		
		array('title' => '0.1', 'value' => '0.1'),
		array('title' => '0.2', 'value' => '0.2'),
		array('title' => '0.3', 'value' => '0.3'),
		array('title' => '0.4', 'value' => '0.4'),
		array('title' => '0.5', 'value' => '0.5'),
		array('title' => '0.6', 'value' => '0.6'),
		array('title' => '0.7', 'value' => '0.7'),
		array('title' => '0.8', 'value' => '0.8'),
		array('title' => '0.9', 'value' => '0.9'),
		array('title' => '1.0', 'value' => '1')
	);

	$fields['module_fullwidth_inner_width'] = array(
		array('title' => '100%', 'value' => ''),
		array('title' => '90%', 'value' => 'fullwrap-inn-width-90'),
		array('title' => '80%', 'value' => 'fullwrap-inn-width-80'),
		array('title' => '70%', 'value' => 'fullwrap-inn-width-70'),
		array('title' => '60%', 'value' => 'fullwrap-inn-width-60'),
		array('title' => '50%', 'value' => 'fullwrap-inn-width-50')
	);
	
	
	$fields['module_fullwidth_dark_background_checkbox'] = array(
		array('title' => __('Text Shadow','ux'), 'value' => 'text_shadow')
	);
	
	$fields['module_fullwidth_type'] = array(
		array('title' => __('Standard (Color Background)','ux'), 'value' => 'standard-color'),
		array('title' => __('Standard (Image Background)','ux'), 'value' => 'standard-image'),
		array('title' => __('Standard (Video Background)','ux'), 'value' => 'standard-video'),
		array('title' => __('Half (Image Background)','ux'), 'value' => 'half-image'),
		array('title' => __('Half (Video Background)','ux'), 'value' => 'half-video')
		//array('title' => __('Tab','ux'), 'value' => 'tab') 
	);
	
	$fields['module_fullwidth_block_column'] = array(
		array('title' => __('2 Column','ux'), 'value' => 'two-column'),
		array('title' => __('3 Column','ux'), 'value' => 'three-column')
	);
	
	$fields['module_fullwidth_block_column_1_rows'] = array(
		array('title' => __('1','ux'), 'value' => '1'),
		array('title' => __('2','ux'), 'value' => '2'),
		array('title' => __('3','ux'), 'value' => '3')
	);
	
	$fields['module_fullwidth_block_column_2_rows'] = array(
		array('title' => __('1','ux'), 'value' => '1'),
		array('title' => __('2','ux'), 'value' => '2'),
		array('title' => __('3','ux'), 'value' => '3')
	);
	
	$fields['module_fullwidth_block_column_3_rows'] = array(
		array('title' => __('1','ux'), 'value' => '1'),
		array('title' => __('2','ux'), 'value' => '2'),
		array('title' => __('3','ux'), 'value' => '3')
	);
	
	$fields['module_fullwidth_height_type'] = array(
		array('title' => __('Auto','ux'), 'value' => 'auto'),
		array('title' => __('Static Height','ux'), 'value' => 'static'),
		array('title' => __('Browser Height','ux'), 'value' => 'browser')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_fullwidth_select');

//fullwidth config fields
function ux_pb_module_fullwidth_fields($module_fields){
	$module_fields['fullwidth'] = array(
		'id' => 'fullwidth',
		'title' => __('Fullwidth Wrap','ux'),
		'item' => array(
			array('title' => __('Anchor Name','ux'),
				  'description' => __('Please enter the anchor name, please use lowercase letters, do not use spaces and other characters','ux'),
				  'type' => 'text',
				  'name' => 'module_fullwidth_anchor_name'),
				  
			array('title' => __('Type','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_type',
				  'default' => 'standard-color'),
				  
			array('type' => 'tabs',
				  'name' => 'module_fullwidth_tabs',
				  'placeholder' => __('Tab Name','ux'),
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'tab'
				  )),

			array('title' => __('Block Column','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_block_column',
				  'default' => 'two-column',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'block'
				  )),
				  
			//Block 1
			array('title' => __('Block 1','ux'),
				  'type' => 'none',
				  'name' => 'module_fullwidth_block_column_1_name',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),
				  
			array('title' => __('Background Color','ux'),
				  'description' => __('Optional, choose a background color for the wrap','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_block_column_1_background_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_block_column_1_background_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),
				  
			/*array('title' => __('Mouseover Bg Color','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_block_column_1_mouseover_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_block_column_1_mouseover_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),*/
			
			array('title' => __('Shift Text Color for Dark Background','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_block_column_1_dark_background',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),
			
			/*array('title' => __('Shift Text Color for Dark Mouseover Bg','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_block_column_1_dark_mouseover_background',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),

			array('title' => __('Rows in this Block','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_block_column_1_rows',
				  'default' => '1',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),*/
			
			//Block 2	  
			array('title' => __('Block 2','ux'),
				  'type' => 'none',
				  'name' => 'module_fullwidth_block_column_2_name',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),
				  
			array('title' => __('Background Color','ux'),
				  'description' => __('Optional, choose a background color for the wrap','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_block_column_2_background_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_block_column_2_background_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),
				  
			/*array('title' => __('Mouseover Bg Color','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_block_column_2_mouseover_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_block_column_2_mouseover_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),*/
			
			array('title' => __('Shift Text Color for Dark Background','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_block_column_2_dark_background',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),
			
			/*array('title' => __('Shift Text Color for Dark Mouseover Bg','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_block_column_2_dark_mouseover_background',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),

			array('title' => __('Rows in this Block','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_block_column_2_rows',
				  'default' => '1',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'two-column|three-column'
				  )),*/
				
			//Block 3  
			array('title' => __('Block 3','ux'),
				  'type' => 'none',
				  'name' => 'module_fullwidth_block_column_3_name',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'three-column'
				  )),
				  
			array('title' => __('Background Color','ux'),
				  'description' => __('Optional, choose a background color for the wrap','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_block_column_3_background_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_block_column_3_background_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'three-column'
				  )),
				  
			/*array('title' => __('Mouseover Bg Color','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_block_column_3_mouseover_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_block_column_3_mouseover_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'three-column'
				  )),*/
			
			array('title' => __('Shift Text Color for Dark Background','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_block_column_3_dark_background',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'three-column'
				  )),
			
			/*array('title' => __('Shift Text Color for Dark Mouseover Bg','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_block_column_3_dark_mouseover_background',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'three-column'
				  )),

			array('title' => __('Rows in this Block','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_block_column_3_rows',
				  'default' => '1',
				  'control' => array(
					  'name' => 'module_fullwidth_block_column',
					  'value' => 'three-column'
				  )),*/
			
			//block end
			
			array('title' => __('Background Color','ux'),
				  'description' => __('Optional, choose a background color for the wrap','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_background_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_background_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-color|tab'
				  )),
				  
			array('title' => __('Background Image','ux'),
				  'type' => 'upload',
				  'name' => 'module_fullwidth_background_image',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-image|half-image'
				  )),
			
			array('title' => __('Parallax Ratio','ux'),
				  'description' => __('select a ratio for Parallax effect','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_background_ratio',
				  'default' => '0.3',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-image|half-image'
				  )),
			
			array('title' => __('Video Url','ux'),
				  'description' => __('enter the video url into right fields','ux'),
				  'type' => 'text',
				  'name' => 'module_fullwidth_video_webm',
				  'placeholder' => __('enter the webm video url here for firefox/chrome/opera browser','ux'),
				  'bind' => array(
					  array('type' => 'text',
							'name' => 'module_fullwidth_video_mp4',
							'placeholder' => __('enter the mp4 or m4v video url here for chrome/ie/safari browser','ux'),
							'position' => 'after'),
							
					  array('type' => 'text',
							'name' => 'module_fullwidth_video_ogg',
							'placeholder' => __('enter the ogg or video url here for chrome/firefox  browser','ux'),
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-video|half-video'
				  )),
			  
			array('title' => __('Alt Image','ux'),
				  'description' => __('Touch devices and ie 8 do not support video background, you need to select a image for them ','ux'),
				  'type' => 'upload',
				  'name' => 'module_fullwidth_alt_image',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-video|half-video'
				  )),

			array('title' => __('Content Panel Align','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_half_content_align',
				  'default' => 'right',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'half-image|half-video'
				  )),
				  
			array('title' => __('Foreground Color','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_fullwidth_foreground_color',
				  'bind' => array(
					  array('type' => 'switch-color',
							'name' => 'module_fullwidth_foreground_switch_color',
							'position' => 'after')
				  ),
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'half-image|half-video'
				  )),
			
			array('title' => __('Shift Text Color for Dark Background','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_dark_background',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-color|standard-image|standard-video|half-image|half-video|tab'
				  )),
				  
			array('type' => 'divider'),	
			
			array('title' => __('Foreground Image','ux'),
				  'type' => 'foreground',
				  'name' => 'module_fullwidth_foreground',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-color|standard-image|standard-video'
				  )),
			
			array('title' => __('Overflow visible','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_show_overflow_visible',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-color|standard-image|standard-video'
				  )),
			
			array('title' => __('Height auto','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_height_type',
				  'default' => 'auto'),
				  
			array('title' => __('Insert Height','ux'),
				  'type' => 'text',
				  'name' => 'module_fullwidth_height',
				  'description' => __('it is recommended to leave it empty to be "auto", if you do need a fixed height, please pay attention to the final effect on mobile devices. e.g. 500','ux'),
				  'unit' => __('px','ux'),
				  'control' => array(
					  'name' => 'module_fullwidth_height_type',
					  'value' => 'static'
				  )),

			array('title' => __('Show Shadow','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_shadow',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-color|standard-image|standard-video|tab'
				  )),
				  
			array('title' => __('Fit Content to Fullwidth','ux'),
				  'description' => __('Content would fit to content container by default, turn on this option the content would fit to fullwidth of the page','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_fit_content',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-color|standard-image|standard-video|tab'
				  )),

			array('title' => __('Inner Wrap Width','ux'),
				  'type' => 'select',
				  'name' => 'module_fullwidth_inner_width',
				  'default' => '',
				  'control' => array(
					  'name' => 'module_fullwidth_type',
					  'value' => 'standard-color|standard-image|standard-video|tab'
				  )),
			
			array('type' => 'divider'),
							  
			//** Advanced Settings
			array('title' => __('Advanced Settings','ux'),
				  'type' => 'switch',
				  'name' => 'module_fullwidth_advanced_settings',
				  'default' => 'off'),
			
			array('title' => __('Enable Top Inner Spacer','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_fullwidth_spacer_in_top',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_advanced_settings',
					  'value' => 'on'
				  )),

			array('title' => __('Enable Bottom Inner Spacer','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_fullwidth_spacer_in_bottom',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_advanced_settings',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Enable Top Outer Spacer','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_fullwidth_spacer_top',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_advanced_settings',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Enable Bottom Outer Spacer','ux'),
				  'description' => '',
				  'type' => 'switch',
				  'name' => 'module_fullwidth_spacer_bottom',
				  'default' => 'off',
				  'control' => array(
					  'name' => 'module_fullwidth_advanced_settings',
					  'value' => 'on'
				  )),
				  
		)
	);
	
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_fullwidth_fields');
?>