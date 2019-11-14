<?php
//template
$gallery_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_template');
$show_property = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_show_property');
$property = arnold_get_post_meta(get_the_ID(), 'theme_meta_enable_portfolio_property');
$container = $gallery_template =='big-title' ? false : ' container';
?>

<div class="gallery-post-des<?php echo esc_attr($container); ?>">
	<?php if($gallery_template != 'big-title'){
	arnold_get_template_part('single/gallery/portfolio', 'title');
	} ?>
	<div class="gallery-post-des-inn">
		<div class="entry">
			<?php the_content(); wp_link_pages(); ?>
		</div><!--End entry-->
	<?php 
	if($show_property && $property){
		
		if(isset($property['title'])){
			$property_title = $property['title'];
			$switch = true;
			
			if(count($property_title) == 1){
				if(empty($property['title'][0]) && empty($property['content'][0])){
					$switch = false;
				}
			} 

			if($switch){ ?>
		
		<div class="gallery-property">
		    <ul class="gallery-info-property">
		        <?php foreach($property_title as $num => $title){
					$content = $property['content'][$num]; ?>
					<li class="gallery-info-property-li">
						<h3 class="gallery-info-property-item gallery-info-property-tit"><?php echo balanceTags($title, false); ?></h3>
						<div class="gallery-info-property-item gallery-info-property-con"><?php echo balanceTags($content, false); ?></div>
					</li>
				<?php } ?>
		    </ul>    
		</div><!--End gallery-property-->
			<?php     
			}  
		}
	}
	?>
	</div><!--End gallery-post-des-inn-->
</div><!--End gallery-post-des-->