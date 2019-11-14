<?php 
	global $post;
	$prev_post = get_previous_post();
    $next_post = get_next_post();
	
	//first post
	$get_first_post = get_posts(array(
		'posts_per_page' => 1,
		'order' => 'ASC'
	)); 
	
	//last post
	$get_last_post = get_posts(array(
		'posts_per_page' => 1,
		'order' => 'DESC'
	)); 
	
    $category = arnold_get_option('theme_option_category_for_more_project');
	if(intval($category)){
		$project_post = get_posts(array(
			'posts_per_page' => -1,
			'category__in' => intval($category),
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array('post-format-gallery')
				)
			)
		));
		
		if($project_post){
			if(in_array($post, $project_post)){
				$current_key = false;
				foreach($project_post as $key => $project){
					if($project == $post){
						$current_key = $key;
					}
				}
				//echo $current_key;
				
				if($current_key > 0){
					$prev_post = $project_post[$current_key - 1];
				}else{
					$prev_post = '';
				}
				
				if($current_key < count($project_post) - 1){
					$next_post = $project_post[$current_key + 1];
				}else{
					$next_post = '';
				}
				
				//first post
				$get_first_post = get_posts(array(
					'posts_per_page' => 1,
					'order' => 'DESC',
					'category__in' => intval($category),
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery')
						)
					)
				)); 
				
				//last post
				$get_last_post = get_posts(array(
					'posts_per_page' => 1,
					'order' => 'ASC',
					'category__in' => intval($category),
					'tax_query' => array(
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array('post-format-gallery')
						)
					)
				)); 
			}
		}
	
	}
	
    $prevthumbnail = $prev_post ? get_the_post_thumbnail($prev_post->ID, 'thumbnail') : false;
    $nextthumbnail = $next_post ? get_the_post_thumbnail($next_post->ID, 'thumbnail') : false;
	
	$prefix_permalink = false;
	
	$first_post = $get_first_post ? $get_first_post[0] : false; 
	$last_post = $get_last_post ? $get_last_post[0] : false;
    $firstthumbnail = $get_first_post ? get_the_post_thumbnail($first_post->ID, 'thumbnail') : false;
    $lastthumbnail = $get_last_post ? get_the_post_thumbnail($last_post->ID, 'thumbnail') : false;

	$prefix_permalink = esc_attr($prefix_permalink);

	
?>
<!--Post navi-->
<div class="blog-unit-meta-bottom">
    <nav class="post-navi-single row">
        <div class="container">
            <?php if(!empty($prev_post)){ ?>
			    <div class="post-navi-unit post-navi-unit-prev col-sm-5 col-md-5 col-xs-5">
			        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>" class="arrow-item arrow-prev">
			        	<span class="navi-title-tag"><?php esc_html_e('PREV', 'arnold'); ?></span>
			        	<span class="post-navi-unit-tit middle-ux hidden-xs"><?php echo esc_html($prev_post->post_title); ?></span>
			        </a>
			        
			    </div>
			<?php }elseif($last_post){ ?>
			    <div class="post-navi-unit post-navi-unit-prev col-sm-5 col-md-5 col-xs-5">
			        <a href="<?php echo esc_url(get_permalink($last_post->ID)); ?>" title="<?php echo esc_attr($last_post->post_title); ?>" class="arrow-item arrow-prev">
			        	<span class="navi-title-tag"><?php esc_html_e('PREV', 'arnold'); ?></span>
			        	<span class="post-navi-unit-tit middle-ux hidden-xs"><?php echo esc_html($last_post->post_title); ?></span>
			        </a>	
			    </div>
			<?php } ?>
            <div class="post-navi-go-back col-sm-2 col-md-2 col-xs-2">
                <a class="post-navi-go-back-a" href="#" data-postid="<?php echo esc_attr(get_the_ID()); ?>"><span class="post-navi-go-back-a-inn"></span></a>
            </div>
            
            <?php
            if(!empty($next_post)){ ?>
			    <div class="post-navi-unit post-navi-unit-next col-sm-5 col-md-5 col-xs-5">
			        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" title="<?php echo esc_attr($next_post->post_title); ?>" class="arrow-item arrow-next">
			        	<span class="navi-title-tag"><?php esc_html_e('NEXT', 'arnold'); ?></span>
			      		<span class="post-navi-unit-tit middle-ux hidden-xs"><?php echo esc_html($next_post->post_title); ?></span>
			      	</a>
			    </div>
			<?php }elseif($first_post){ ?>
			    <div class="post-navi-unit post-navi-unit-next col-sm-5 col-md-5 col-xs-5">
			        <a href="<?php echo esc_url(get_permalink($first_post->ID)); ?>" title="<?php echo esc_attr($first_post->post_title); ?>" class="arrow-item arrow-next">
			        	<span class="navi-title-tag"><?php esc_html_e('NEXT', 'arnold'); ?></span>
			        	<span class="post-navi-unit-tit middle-ux hidden-xs"><?php echo esc_html($first_post->post_title); ?></span>
			        </a>
			    </div>
			<?php } ?>
        </div>
    </nav>
</div>