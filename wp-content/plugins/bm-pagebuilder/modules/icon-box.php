<?php
//icon box template
function ux_pb_module_iconbox($itemid){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$moduleid = 'icon-box';
	
	if($module_post){
		//icon box confing
		$icons             = get_post_meta($module_post, 'module_iconbox_icon', true);
		$layout            = get_post_meta($module_post, 'module_iconbox_layout', true);
		$mask              = get_post_meta($module_post, 'module_iconbox_mask', true);
		$mask_color        = get_post_meta($module_post, 'module_iconbox_mask_color', true);
		$animation         = get_post_meta($module_post, 'module_iconbox_hover_animation', true);
		$title             = get_post_meta($module_post, 'module_iconbox_title', true);
		$link              = get_post_meta($module_post, 'module_iconbox_link', true);
		$link_blank        = get_post_meta($module_post, 'module_iconbox_hyperlink_blank', true);
		$hyperlink         = get_post_meta($module_post, 'module_iconbox_hyperlink', true);
		$content           = get_post_meta($module_post, 'module_content', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$animation_base    = get_post_meta($module_post, 'module_scroll_animation_base', true);
		
		$link_blank_attr   = $link_blank == 'on' ? ' target="_blank"' : false;
		$hyperlink_before  = $link == 'on' ? '<a href="' . esc_url($hyperlink) . '"' . esc_attr($link_blank_attr) . ' class="iconbox-a">' : false;
		$hyperlink_after   = $link == 'on' ? '</a>' : false;
		$title             = $title ? '<span class="iconbox-h5">' .esc_html($title). '</span>' : false;
		$content           = $content ? '<div class="iconbox-con">'.do_shortcode($content).'</div>' : false;
		$mask_color        = $mask_color ? ux_theme_switch_color($mask_color, 'rgb') : ux_theme_switch_color('color10', 'rgb');
		$mask_type         = $mask ? 'iconbox-plus-' .esc_attr($mask) : false;
		$mask_animation    = $animation ? 'hover-' .esc_attr($animation) : false;
		$mask_style        = $layout == 'icon_top' ? 'iconbox-plus ' .esc_attr($mask_type). ' ' .esc_attr($mask_animation) : false;
		$animation         = $animation ? 'data-animation="' .esc_attr($animation). '"' : false;
		$layout_class      = $layout == 'icon_mouseover' ? 'iconbox-content-hide center-ux' : $layout;
		
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, $moduleid) : false;
		$animation_end     = $advanced_settings == 'on' ? ux_pb_animation_end($animation_base) : false;
		
		if(strstr($icons, "fa fa")){
			$icons = '<i class="' .esc_attr($icons). '"></i>';
		}else{
			$icons = '<img class="user-uploaded-icons" src="' .esc_url($icons). '" />';
		} ?>
         
        <div <?php echo balanceTags($animation); ?> class="iocnbox <?php echo esc_attr($layout_class); ?> <?php echo esc_attr($mask_style); ?> ux-mod-nobg <?php echo esc_attr($animation_style); ?>" data-animationend="<?php echo esc_attr($animation_end); ?>">
            <?php if($mask){
				if($layout == 'icon_top'){ ?>
                    <!--End iconbox-plus-svg-wrap-->
                    <div class="iconbox-plus-svg-wrap">
                        <?php echo balanceTags($hyperlink_before);
                        switch($mask){
                            case 'circle': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .esc_attr($module_post); ?>" version="1.1"><circle r="65" cy="258.5" cx="105.5" fill="<?php echo esc_attr($mask_color); ?>" /></svg>
                            <?php
                            break;
                            case 'triangle': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .esc_attr($module_post); ?>" version="1.1"><g><path d="M39.791,315.5c-6.487,0-9.148-4.574-5.915-10.162L99.62,191.691c3.234-5.588,8.527-5.588,11.757,0
        l65.747,113.646c3.232,5.588,0.572,10.162-5.917,10.162H39.791z" fill="<?php echo esc_attr($mask_color); ?>"/></g></svg>
                            <?php
                            break;
                            case 'square': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .esc_attr($module_post); ?>" version="1.1"><path d="M175.5,308c0,9.659-7.841,17.5-17.5,17.5H53c-9.669,0-17.5-7.841-17.5-17.5V203
        c0-9.659,7.831-17.5,17.5-17.5h105c9.659,0,17.5,7.841,17.5,17.5V308z" fill="<?php echo esc_attr($mask_color); ?>"/></svg>
                            <?php
                            break;
                            case 'hexagonal': ?>
                                <svg xml:space="preserve" enable-background="new 0 0 160 160" viewBox="0 0 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .esc_attr($module_post); ?>" version="1.1"><g><path d="M17.676,125.522C12.905,122.787,9,116.05,9,110.55l0-61.366c0-5.5,3.904-12.237,8.676-14.972L71.315,3.472
		c4.772-2.735,12.581-2.735,17.353,0l53.655,30.744c4.772,2.734,8.676,9.472,8.675,14.972l-0.013,61.362
		c-0.001,5.5-3.906,12.237-8.678,14.973l-53.643,30.741c-4.772,2.735-12.581,2.735-17.352,0L17.676,125.522z" fill="<?php echo esc_attr($mask_color); ?>"/></g></svg>
                            <?php
                            break;
                            case 'pentagon': ?>
                                <svg xml:space="preserve" enable-background="new 25.5 175.5 160 160" viewBox="25.5 175.5 160 160" height="160px" width="160px" y="0px" x="0px" id="<?php echo 'iconbox-plus' .esc_attr($module_post); ?>" version="1.1"><g><path d="M109.339,305.159c-2.113-1.104-5.562-1.106-7.675,0l-39.981,20.895c-2.11,1.102-3.506,0.09-3.103-2.248
        l7.636-44.251c0.405-2.34-0.664-5.604-2.37-7.262L31.5,240.937c-1.707-1.654-1.175-3.286,1.182-3.627l44.708-6.463
        c2.357-0.339,5.15-2.36,6.206-4.489l19.983-40.265c1.06-2.124,2.783-2.124,3.843,0l19.979,40.265
        c1.056,2.127,3.847,4.15,6.206,4.489l44.711,6.463c2.355,0.342,2.889,1.973,1.183,3.627l-32.348,31.355
        c-1.706,1.657-2.773,4.922-2.369,7.262l7.628,44.251c0.404,2.339-0.992,3.349-3.1,2.248L109.339,305.159z" fill="<?php echo esc_attr($mask_color); ?>"/></g></svg>
                            <?php
                            break;
                        }
						echo balanceTags($icons);
						echo balanceTags($hyperlink_after); ?>
                    </div>
				<?php
				}
			}else{
				if($icons && $layout == 'icon_top'){ ?>
                    <div class="icon_wrap">
                        <?php  
							echo balanceTags($hyperlink_before);
							echo balanceTags($icons);
							echo balanceTags($hyperlink_after);
						?>
                    </div>
                <?php
				}
			} ?>
            <div class="icon_text">
            	<?php if($layout == 'icon_left'){

            		echo '<span class="side-icons-wrap">';
            		echo balanceTags($hyperlink_before);
					echo balanceTags($icons); 
					echo balanceTags($title);
					echo balanceTags($hyperlink_after);
					echo '</span>';
					 
				} elseif($layout == 'icon_right') {

					echo '<span class="side-icons-wrap">';
            		echo balanceTags($hyperlink_before);
            		echo balanceTags($title);
					echo balanceTags($icons);
					echo balanceTags($hyperlink_after);
					echo '</span>';

				} elseif($layout == 'icon_on_fullwrap_block') {
					echo '<span class="block-icon-wrap">';
					echo balanceTags($hyperlink_before);
					echo balanceTags($icons);
					echo balanceTags($hyperlink_after);
					echo '</span>';
					echo '<span class="block-text-wrap">';
					echo balanceTags($hyperlink_before);
					echo balanceTags($title);
					echo balanceTags($hyperlink_after);
					echo balanceTags($content);
					echo '</span>';
				}
					if($layout == 'icon_top'){
					echo balanceTags($hyperlink_before);
					echo balanceTags($title);
					echo balanceTags($hyperlink_after);
					}
					if($layout != 'icon_on_fullwrap_block') {
						echo balanceTags($content);
					}
				?>
            </div><!--End icon_text-->
                        
        </div>
	<?php
	}
}
add_action('ux-pb-module-template-icon-box', 'ux_pb_module_iconbox');

//icon box select fields
function ux_pb_module_iconbox_select($fields){
	$fields['module_iconbox_layout'] = array(
		array('title' => __('Icon on Left','ux'), 'value' => 'icon_left'),
		array('title' => __('Icon on Top','ux'), 'value' => 'icon_top'),
		array('title' => __('Icon on Right','ux'), 'value' => 'icon_right'),
		array('title' => __('Layout for Fullwidth Wrap(Block) ','ux'), 'value' => 'icon_on_fullwrap_block')
	);
	
	$fields['module_iconbox_hover_animation'] = array(
		array('title' => __('Full Rotate','ux'), 'value' => 'rorate'),
		array('title' => __('Flip','ux'), 'value' => 'flip'),
		array('title' => __('Scale','ux'), 'value' => 'scale')
	);
	
	$fields['module_iconbox_mask'] = array(
		array('title' => __('Circle','ux'), 'value' => 'circle'),
		array('title' => __('Triangle','ux'), 'value' => 'triangle'),
		array('title' => __('Rounded Square','ux'), 'value' => 'square'),
		array('title' => __('Diamond','ux'), 'value' => 'hexagonal'),
		array('title' => __('Star','ux'), 'value' => 'pentagon')
	);
	
	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_iconbox_select');

//icon box config fields
function ux_pb_module_iconbox_fields($module_fields){
	$module_fields['icon-box'] = array(
		'id' => 'icon-box',
		'animation' => true,
		'title' => __('Icon Box','ux'),
		'item' =>  array(
			array('title' => __('Select Icon','ux'),
				  'description' => __('Choose a icon for this Icon Box','ux'),
				  'type' => 'icons',
				  'name' => 'module_iconbox_icon'),
				  
			array('title' => __('Layout','ux'),
				  'description' => __('Place the Icon on left or top','ux'),
				  'type' => 'select',
				  'name' => 'module_iconbox_layout',
				  'default' => 'icon_left'),
				  
			array('title' => __('Icon Mask','ux'),
				  'type' => 'image_select',
				  'name' => 'module_iconbox_mask',
				  'control' => array(
					  'name' => 'module_iconbox_layout',
					  'value' => 'icon_top'
				  )),
				  
			array('title' => __('Mask Color','ux'),
				  'type' => 'bg-color',
				  'name' => 'module_iconbox_mask_color',
				  'control' => array(
					  'name' => 'module_iconbox_layout',
					  'value' => 'icon_top'
				  )),
				  
			array('title' => __('Hover Animation','ux'),
				  'type' => 'select',
				  'name' => 'module_iconbox_hover_animation',
				  'default' => 'rorate',
				  'control' => array(
					  'name' => 'module_iconbox_layout',
					  'value' => 'icon_top'
				  )),
				  
			array('title' => __('Title','ux'),
				  'description' => __('Enter a title for this Icon Box','ux'),
				  'type' => 'text',
				  'name' => 'module_iconbox_title'),
				  
			array('title' => __('Link','ux'),
				  'type' => 'switch',
				  'name' => 'module_iconbox_link'),
				  
			array('title' => __('Url','ux'),
				  'description' => __('Paste a url for the icon','ux'),
				  'type' => 'text',
				  'name' => 'module_iconbox_hyperlink',
				  'control' => array(
					  'name' => 'module_iconbox_link',
					  'value' => 'on'
				  )),

			array('title' => __('Open link in a new window/tab','ux'),
				  'type' => 'switch',
				  'default' => 'off',
				  'name' => 'module_iconbox_hyperlink_blank',
				  'control' => array(
					  'name' => 'module_iconbox_link',
					  'value' => 'on'
				  )),
				  
			array('title' => __('Content','ux'),
				  'description' => __('Enter content for this Icon Box','ux'),
				  'type' => 'content',
				  'name' => 'module_content'),

			array('title' => __('Advanced Settings','ux'),
				  'description' => __('magin and animations','ux'),
				  'type' => 'switch',
				  'name' => 'module_advanced_settings',
				  'default' => 'off',
				  'modal-body' => 'after'),
				  
			array('title' => __('Bottom Margin','ux'),
				  'description' => __('the spacing outside the bottom of module','ux'),
				  'type' => 'select',
				  'name' => 'module_bottom_margin',
				  'default' => 'bottom-space-40',
				  'control' => array(
					  'name' => 'module_advanced_settings',
					  'value' => 'on'
				  ),
				  'modal-body' => 'after')
				  
		)
	);
	return $module_fields;
	
}
add_filter('ux_pb_module_fields', 'ux_pb_module_iconbox_fields');
?>