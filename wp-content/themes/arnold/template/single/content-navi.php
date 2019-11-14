<?php 
    $prev_post = get_previous_post();
    $prevthumbnail = $prev_post ? get_the_post_thumbnail($prev_post->ID, 'thumbnail') : false;
    $next_post = get_next_post();
    $nextthumbnail = $next_post ? get_the_post_thumbnail($next_post->ID, 'thumbnail') : false;
	$prefix_permalink = false;
	$data = false;
	$get_post = false;
	
	if(isset($_REQUEST['mode'])){
		if($_REQUEST['mode'] == 'ajax-portfolio'){
			$cat = $_REQUEST['category'];
			if($cat != ''){
				$categories = get_the_category();
				$categoryIDS = array();
				foreach($categories as $category) {
					if($category->term_id != $cat){
						array_push($categoryIDS, $category->term_id);
					}
				}
				$categoryIDS = implode(",", $categoryIDS);
				
				$prev_post = get_previous_post(true, $categoryIDS);
				$next_post = get_next_post(true, $categoryIDS);
				
				$prefix_permalink = '#/';
			}
			$bg_color = arnold_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
			$bg_color = $bg_color ? 'bg-' . arnold_theme_switch_color($bg_color) : 'post-bgcolor-default';
			$data = 'data-bgcolor="' . $bg_color . '" data-category="' . $cat . '"';
		}
	}
	
	//first post
	$get_first_post = get_posts(array(
		'posts_per_page' => 1,
		'order'          => 'ASC'
	)); 
	
	$first_post = $get_first_post ? $get_first_post[0] : false; 
	$firstthumbnail = $get_first_post ? get_the_post_thumbnail($first_post->ID, 'thumbnail') : false;

	//last post
	$get_last_post = get_posts(array(
		'posts_per_page' => 1,
		'order'          => 'DESC'
	)); 
	
	$last_post = $get_last_post ? $get_last_post[0] : false; 
	$lastthumbnail = $get_last_post ? get_the_post_thumbnail($last_post->ID, 'thumbnail') : false;

	$prefix_permalink = esc_attr($prefix_permalink);
	
?>
<!--Post navi-->
<nav class="post-navi-single post-navi-single-normal clearfix">
<?php if(!empty($prev_post)){ ?>
    <div class="post-navi-unit post-navi-unit-prev col-sm-6 col-md-6 col-xs-6">
        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>" class="arrow-item arrow-prev">
        	<span class="navi-title-tag"><?php esc_html_e('PREV', 'arnold'); ?></span>
        	<span class="post-navi-unit-tit middle-ux hidden-xs"><?php echo esc_html($prev_post->post_title); ?></span>
        </a>
        
    </div>
<?php }elseif($last_post){ ?>
    <div class="post-navi-unit post-navi-unit-prev col-sm-6 col-md-6 col-xs-6">
        <a href="<?php echo esc_url(get_permalink($last_post->ID)); ?>" title="<?php echo esc_attr($last_post->post_title); ?>" class="arrow-item arrow-prev">
        	<span class="navi-title-tag"><?php esc_html_e('PREV', 'arnold'); ?></span>
        	<span class="post-navi-unit-tit middle-ux hidden-xs"><?php echo esc_html($last_post->post_title); ?></span>
        </a>	
    </div>
<?php } ?>

<?php
if(!empty($next_post)){ ?>
    <div class="post-navi-unit post-navi-unit-next col-sm-6 col-md-6 col-xs-6">
        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" title="<?php echo esc_attr($next_post->post_title); ?>" class="arrow-item arrow-next">
        	<span class="navi-title-tag"><?php esc_html_e('NEXT', 'arnold'); ?></span>
      		<span class="post-navi-unit-tit middle-ux hidden-xs"><?php echo esc_html($next_post->post_title); ?></span>
      	</a>
    </div>
<?php }elseif($first_post){ ?>
    <div class="post-navi-unit post-navi-unit-next col-sm-6 col-md-6 col-xs-6">
        <a href="<?php echo esc_url(get_permalink($first_post->ID)); ?>" title="<?php echo esc_attr($first_post->post_title); ?>" class="arrow-item arrow-next">
        	<span class="navi-title-tag"><?php esc_html_e('NEXT', 'arnold'); ?></span>
        	<span class="post-navi-unit-tit middle-ux hidden-xs"><?php echo esc_html($first_post->post_title); ?></span>
        </a>
    </div>
<?php } ?>
</nav>