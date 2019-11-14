<?php
//video template
function ux_pb_module_video($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	if($module_post){
		//video confing
		$embed_code   = get_post_meta($module_post, 'module_video_embed_code', true);
		$ratio        = get_post_meta($module_post, 'module_video_ratio', true);
		$custom_ratio = get_post_meta($module_post, 'module_video_custom_ratio', true);
		$cover        = get_post_meta($module_post, 'module_video_cover', true);
		
		$key_1        = false;
		$key_2        = false;
		switch($ratio){
			case '16:9': $video_size = 'video-16-9'; break;
			case '4:3': $video_size = 'video-4-3'; break;
			case 'custom':
				$key_1 = $custom_ratio && isset($custom_ratio[1][0]) ? $custom_ratio[1][0] : 4;
				$key_2 = $custom_ratio && isset($custom_ratio[2][0]) ? $custom_ratio[2][0] : 3;
				$video_size = false;
			break;
		}
		
		$key_1 = $key_1 ? $key_1 : 4;
		$key_2 = $key_2 ? $key_2 : 3;
		$video_size = $video_size ? $video_size : false;
		$video_custom = $custom_ratio ? 'padding-bottom:'.($key_2 / $key_1) * 100 .'%' : false; ?>
        <div class="video-face">
            <span class="fa fa-play video-play-btn"></span>
            <?php if($cover){
				echo '<img src="' . esc_url($cover) . '" class="video-face-img">';
			}else{
				echo '<img src="' .esc_url(UX_PAGEBUILDER. '/images/play.jpg'). '" class="video-face-img">';
			} ?>
            <div class="video-wrap hidden <?php echo sanitize_html_class($video_size); ?>" style=" <?php echo esc_attr($video_custom); ?>">
				<?php if($embed_code){
                    if(strstr($embed_code, "youtu") && !(strstr($embed_code, "iframe"))){ ?>
                        <iframe src="http://www.youtube.com/embed/<?php echo esc_attr(ux_theme_get_youtube($embed_code)); ?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent" width="1500" height="844" allowfullscreen=""></iframe>
                    <?php
                    }elseif(strstr($embed_code, "vimeo") && !(strstr($embed_code, "iframe"))){ ?>
                        <iframe src="http://player.vimeo.com/video/<?php echo esc_attr(ux_theme_get_vimeo($embed_code)); ?>?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=0" width="1500" height="844" allowfullscreen=""></iframe>
                    <?php	
                    }else{
                        echo balanceTags($embed_code);
                    }
                } ?>
            </div>
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-video', 'ux_pb_module_video');

//video select fields
function ux_pb_module_video_select($fields){
	$fields['module_video_ratio'] = array(
		array('title' => __('4:3','ux'), 'value' => '4:3'),
		array('title' => __('16:9','ux'), 'value' => '16:9'),
		array('title' => __('Custom','ux'), 'value' => 'custom')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_video_select');

//video config fields
function ux_pb_module_video_fields($module_fields){
	$module_fields['video'] = array(
		'id' => 'video',
		'animation' => false,
		'title' => __('Video','ux'),
		'item' =>  array(
			array('title' => __('Embed Code','ux'),
				  'description' => __('You could find the embed code on the source video page','ux').'<div class="show-hide-guide-wrap"><a href="http://www.uiueux.com/a/newtea/documentation/video-guide.html" target="_blank"><span>?</span></a></div>',
				  'type' => 'textarea',
				  'name' => 'module_video_embed_code'),
				  
			array('title' => __('Ratio','ux'),
				  'description' => __('Set the appropriate ratio can remove the black border of the video','ux'),
				  'type' => 'select',
				  'name' => 'module_video_ratio',
				  'default' => '4:3'),
				  
			array('type' => 'ratio',
				  'name' => 'module_video_custom_ratio',
				  'control' => array(
					  'name' => 'module_video_ratio',
					  'value' => 'custom'
				  )),
				  
			array('title' => __('Cover for Video','ux'),
				  'type' => 'upload',
				  'name' => 'module_video_cover')
			
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_video_fields');
?>