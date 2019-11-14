<?php
//pagebuilder module fields
function ux_pb_module_fields(){
	$module_fields = array();
	$module_fields = apply_filters('ux_pb_module_fields', $module_fields);
	$module_fields = ux_pb_animation($module_fields);
	return $module_fields;
}

//pagebuilder config social networks
function ux_pb_social_networks(){
	$ux_pb_social_networks = array(
		array('name' => __('Facebook','ux'), 'icon' => 'fa fa-facebook-square', 'icon2' => 'fa fa-facebook-square',
			  'slug' => 'facebook', 'dec'  => __('Visit Facebook page','ux')),
		array('name' => __('Twitter','ux'), 'icon' => 'fa fa-twitter-square', 'icon2' => 'fa fa-twitter-square',
			  'slug' => 'twitter', 'dec'  => __('Visit Twitter page','ux')),
		array('name' => __('Google+','ux'), 'icon' => 'fa fa-google-plus-square', 'icon2' => 'fa fa-google-plus-square',
			  'slug' => 'googleplus', 'dec'  => __('Visit Google Plus page','ux')),
		array('name' => __('Youtube','ux'), 'icon' => 'fa fa-youtube-square', 'icon2' => 'fa fa-youtube-square',
			  'slug' => 'youtube', 'dec'  => __('Visit Youtube page','ux')),
		array('name' => __('Vimeo','ux'), 'icon' => 'fa fa-vimeo-square', 'icon2' => 'fa fa-vimeo-square',
			  'slug' => 'vimeo', 'dec'  => __('Visit Vimeo page','ux')),
		array('name' => __('Tumblr','ux'), 'icon' => 'fa fa-tumblr-square', 'icon2' => 'fa fa-tumblr-square',
			  'slug' => 'tumblr', 'dec'  => __('Visit Tumblr page','ux')),
		array('name' => __('RSS','ux'), 'icon' => 'fa fa-rss-square', 'icon2' => 'fa fa-rss-square',
			  'slug' => 'rss', 'dec'  => __('Visit Rss','ux')),
		array('name' => __('Pinterest','ux'), 'icon' => 'fa fa-pinterest-square', 'icon2' => 'fa fa-pinterest-square',
			  'slug' => 'pinterest', 'dec'  => __('Visit Pinterest page','ux')),
		array('name' => __('Linkedin','ux'), 'icon' => 'fa fa-linkedin-square', 'icon2' => 'fa fa-linkedin-square',
			  'slug' => 'linkedin', 'dec'  => __('Visit Linkedin page','ux')),
		array('name' => __('Instagram','ux'), 'icon' => 'fa fa-instagram', 'icon2' => 'fa fa-instagram',
			  'slug' => 'instagram', 'dec'  => __('Visit Instagram page','ux')),
		array('name' => __('Github','ux'), 'icon' => 'fa fa-github-square', 'icon2' => 'fa fa-github-square',
			  'slug' => 'github', 'dec'  => __('Visit Github page','ux')),
		array('name' => __('Xing','ux'), 'icon' => 'fa fa-xing-square', 'icon2' => 'fa fa-xing-square',
			  'slug' => 'xing', 'dec'  => __('Visit Xing page','ux')),
		array('name' => __('Flickr','ux'), 'icon' => 'fa fa-flickr', 'icon2' => 'fa fa-flickr',
			  'slug' => 'flickr', 'dec'  => __('Visit Flickr page','ux')),
		array('name' => __('VK','ux'), 'icon' => 'fa fa-vk square-radiu', 'icon2' => 'fa fa-vk square-radiu',
			  'slug' => 'vk', 'dec'  => __('Visit VK page','ux')),
		array('name' => __('Weibo','ux'), 'icon' => 'fa fa-weibo square-radiu', 'icon2' => 'fa fa-weibo square-radiu',
			  'slug' => 'weibo', 'dec'  => __('Visit Weibo page','ux')),
		array('name' => __('Renren','ux'), 'icon' => 'fa fa-renren square-radiu', 'icon2' => 'fa fa-renren square-radiu',
			  'slug' => 'renren', 'dec'  => __('Visit Renren page','ux')),
		array('name' => __('Bitbucket','ux'), 'icon' => 'fa fa-bitbucket-square', 'icon2' => 'fa fa-bitbucket-square',
			  'slug' => 'bitbucket', 'dec'  => __('Visit Bitbucket page','ux')),
		array('name' => __('Foursquare','ux'), 'icon' => 'fa fa-foursquare square-radiu', 'icon2' => 'fa fa-foursquare square-radiu',
			  'slug' => 'foursquare', 'dec'  => __('Visit Foursquare page','ux')),
		array('name' => __('Skype','ux'), 'icon' => 'fa fa-skype square-radiu', 'icon2' => 'fa fa-skype square-radiu',
			  'slug' => 'skype', 'dec'  => __('Skype','ux')),
		array('name' => __('Dribbble','ux'), 'icon' => 'fa fa-dribbble square-radiu', 'icon2' => 'fa fa-dribbble square-radiu',
			  'slug' => 'dribbble', 'dec'  => __('Visit Dribbble page','ux'))
	);	
	
	return $ux_pb_social_networks;
	
}

//pagebuilder module select fields
function ux_pb_module_select_fields(){
	$module_fields['module_select_orderby'] = array(
		array('title' => __('Please Select','ux'), 'value' => 'none'),
		array('title' => __('Title','ux'), 'value' => 'title'),
		array('title' => __('Date','ux'), 'value' => 'date'),
		array('title' => __('ID','ux'), 'value' => 'id'),
		array('title' => __('Modified','ux'), 'value' => 'modified'),
		array('title' => __('Author','ux'), 'value' => 'author'),
		array('title' => __('Comment count','ux'), 'value' => 'comment_count')
	);
	
	$module_fields['module_select_order'] = array(
		array('title' => __('Ascending','ux'), 'value' => 'ASC'),
		array('title' => __('Descending','ux'), 'value' => 'DESC')
	);
	
	$module_fields['module_bottom_margin'] = array(
		array('title' => __('No Margin','ux'), 'value' => 'bottom-space-no'),
		array('title' => __('20px','ux'), 'value' => 'bottom-space-20'),
		array('title' => __('40px','ux'), 'value' => 'bottom-space-40'),
		array('title' => __('60px','ux'), 'value' => 'bottom-space-60'),
		array('title' => __('80px','ux'), 'value' => 'bottom-space-80')
	);
	
	$module_fields['module_scroll_animation_one'] = array(
		array('title' => __('Fade in','ux'), 'value' => 'fadein'),
		array('title' => __('Fade in and zoom in','ux'), 'value' => 'zoomin'),
		array('title' => __('Fade in from left','ux'), 'value' => 'from-left-translate'),
		array('title' => __('Fade in from right','ux'), 'value' => 'from-right-translate'),
		array('title' => __('Fade in from top','ux'), 'value' => 'from-top-translate'),
		array('title' => __('Fade in from bottom','ux'), 'value' => 'from-bottom-translate')
	);
	
	$module_fields['module_scroll_animation_two'] = array(
		array('title' => __('Fade in','ux'), 'value' => 'fadein')
		//array('title' => __('Fade in and zoom in','ux'), 'value' => 'zoomin'),
		//array('title' => __('Fade in from bottom','ux'), 'value' => 'from-bottom-translate')
	);
	
	$module_fields['module_scroll_animation_three'] = array(
		array('title' => __('Fade In','ux'), 'value' => 'fadein'),
		array('title' => __('Fade In Left','ux'), 'value' => 'from-left-translate'),
		array('title' => __('Fade In Right','ux'), 'value' => 'from-right-translate'),
		array('title' => __('Fade In Up','ux'), 'value' => 'from-top-translate'),
		array('title' => __('Fade In Down','ux'), 'value' => 'from-bottom-translate'),
		array('title' => __('Bounce In Left','ux'), 'value' => 'bouncdein-left-translate'),
		array('title' => __('Bounce In Right','ux'), 'value' => 'bouncdein-right-translate'),
		array('title' => __('Bounce In Up','ux'), 'value' => 'bouncdein-up-translate'),
		array('title' => __('Bounce In Down','ux'), 'value' => 'bouncdein-down-translate'),
		array('title' => __('Flip X','ux'), 'value' => 'flip-x-translate'),
		array('title' => __('Flip Y','ux'), 'value' => 'flip-y-translate'),
		array('title' => __('Rotate In DownLeft','ux'), 'value' => 'rotate-downleft-translate'),
		array('title' => __('Rotate In DownRight','ux'), 'value' => 'rotate-downright-translate')
	);
	
	$module_fields = apply_filters('ux_pb_module_select_fields', $module_fields);
	return $module_fields;
}
?>