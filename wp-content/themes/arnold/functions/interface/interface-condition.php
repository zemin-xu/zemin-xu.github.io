<?php
/****************************************************************/
/*
/* Condition
/*
/****************************************************************/

//Condition enable sidebar
function arnold_enable_sidebar(){
	$sidebar = true;
	if(is_singular('post')){
		$sidebar = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
		//** not portfolio template get sidebar template
		if($sidebar == 'without-sidebar'){
			$sidebar = false;
		}
		if(has_post_format('gallery')){
			$sidebar = false;
		}
	}elseif(is_page()){
		$sidebar = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
		if($sidebar == 'without-sidebar'){
			$sidebar = false;
		}
		
		$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template');
		if($page_template != 'none' && $page_template != 'blog-masonry'){
			$sidebar = false;
		}
	}elseif(is_singular('team_item')){
		$sidebar = arnold_get_post_meta(get_the_ID(), 'theme_meta_sidebar');
		
		if($sidebar == 'without-sidebar'){
			$sidebar = false;
		}
		
		if(arnold_enable_team_template()){
			$sidebar = false;
		}
	}
	
	return $sidebar;
}

//Condition enable pagebuilder
function arnold_enable_pb(){
	$switch = false;
	
	if(is_singular('post') || is_page() ){
		$pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
		
		if($pb_switch == 'pagebuilder'){
			$switch = true;
		}
		
		//if(arnold_enable_team_template()){
		//	$switch = false;
		//}
	}
	
	return $switch;
	
}

//Condition enable team template
function arnold_enable_team_template(){
	$switch = false;
	
	if(is_singular('team_item')){
		$team_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_enable_team_template');
		
		if($team_template){
			$switch = true;
		}
	}
	
	return $switch;
	
}

?>