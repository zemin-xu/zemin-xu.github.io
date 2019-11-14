<?php
//excerpt
function arnold_excerpt_length( $length ) {
	return 10;
}
add_filter( 'excerpt_length', 'arnold_excerpt_length', 999 );

//theme meta save
function arnold_theme_meta_save($post_id) {  
    if(!isset($_POST['custom_meta_box_nonce'])){
		$post_nonce = '';
	}else{
		$post_nonce = $_POST['custom_meta_box_nonce'];
	}
	
	if (!wp_verify_nonce($post_nonce, ABSPATH))  
		return $post_id; 
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
        return $post_id;  
    
    if('page' == $_POST['post_type']){  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
        } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    }
	 
	$old = get_post_meta($post_id, 'ux_theme_meta', true);
	$new = @$_POST['ux_theme_meta'];  
	
	if ($new && $new != $old) {  
		update_post_meta($post_id, 'ux_theme_meta', $new);  
	} elseif ('' == $new && $old) {  
		delete_post_meta($post_id, 'ux_theme_meta', $old);  
	}
	
	//set_post_thumbnail
	$thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true); 
	if($thumbnail_id){
		$thumbnail_crop = get_post_meta($thumbnail_id, '_thumbnail_crop', true);
		if(!$thumbnail_crop){
			arnold_theme_option_process_generate_thumb($thumbnail_id);
		}
	}
	
	return $post_id;
}  
add_action('save_post', 'arnold_theme_meta_save'); 

//theme enter title
function arnold_theme_post_enter_title($post){
	$arnold_theme_post_type = arnold_theme_register_post_type();
	foreach($arnold_theme_post_type as $slug => $post_type){
		if(get_post_type() == $slug){
			if(isset($post_type['enter_title'])){
				$post = $post_type['enter_title'];
			}
		}
	}
	
	return $post;
}
add_filter('enter_title_here', 'arnold_theme_post_enter_title');

//theme sample permalink
function arnold_theme_post_sample_permalink_html($return){
	$arnold_theme_post_type = arnold_theme_register_post_type();
	foreach($arnold_theme_post_type as $slug => $post_type){
		if(get_post_type() == $slug){
			if(isset($post_type['sample_permalink'])){
				$return = $post_type['sample_permalink'];
			}
		}
	}
	return $return;
}
add_filter('get_sample_permalink_html', 'arnold_theme_post_sample_permalink_html');

//theme get youtube id
function arnold_theme_get_youtube($url){
	/*
	$matches = parse_url($url);
	$matches = str_replace("/", "", $matches['path']);
	return $matches;*/
	if(strstr($url, "youtube")){
		preg_match('#https?://(www\.)?youtube\.com/watch\?v=([A-Za-z0-9\-_]+)#s', $url, $matches);
		return $matches[2];
	}else{
		preg_match('#http://w?w?w?.?youtu.be/([A-Za-z0-9\-_]+)#s', $url, $matches);
		return $matches[1];
	}
}

//theme get vimeo id
function arnold_theme_get_vimeo($url){
	$matches = parse_url($url);
	$matches = str_replace("/", "", $matches['path']);
	return $matches;
}

//Define COMMENT
function arnold_cust_comment($comment, $args, $depth){
	$GLOBALS['comment'] = $comment; ?>
    <li class="commlist-unit">
        <div class="avatar"><?php echo get_avatar($comment, 50); ?></div><!--END avatar--> 

        <div class="comm-u-wrap">
            
            <div class="comment">
                <?php comment_text() ?>
            </div><!--END comment-->

            <div class="comment-meta">
                <span class="comment-author"><a href="<?php comment_author_url(); ?>" class="comment-author-a"><?php comment_author(); ?></a></span>
                <span class="date"><?php echo human_time_diff(get_comment_time('U'), current_time('timestamp'));  esc_html_e(' ago','arnold'); ?></span>
                <span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text'=>esc_html__('Reply','arnold'),'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
            </div><!--END comment-mata-->
                        		
        </div><!--END comm-u-wrap-->

		<?php if ($comment->comment_approved == '0'){ ?>
            <p><em><?php esc_html_e('Your comment is awaiting moderation','arnold'); ?>.</em></p>
        <?php } ?>
    </li>				
<?php 
}

//theme post meta default
function arnold_theme_post_meta_default($key){
	$theme_post_meta_fields = arnold_theme_post_meta_fields();
	$default = false;
	if(isset($theme_post_meta_fields[get_post_type()])){
		foreach($theme_post_meta_fields[get_post_type()] as $option){
			if(isset($option['section'])){
				foreach($option['section'] as $section){
					if(isset($section['item'])){
						foreach($section['item'] as $item){
							if(isset($item['name'])){
								if($item['name'] == $key){
									$default = isset($item['default']) ? $item['default'] : false;
									if($default == 'true'){
										$default = true;
									}elseif($default == 'false'){
										$default = false;
									}
								}else{
									if(isset($item['bind'])){
										foreach($item['bind'] as $bind){
											if($bind['name'] == $key){
												$default = isset($bind['default']) ? $bind['default'] : false;
												if($default == 'true'){
													$default = true;
												}elseif($default == 'false'){
													$default = false;
												}
											}
										}
									}
							}
							}
						}
					}
				}
			}
		}
	}
	return $default;
}

//require theme postmeta
require_once get_template_directory() . '/functions/theme/post/post-meta.php';

?>