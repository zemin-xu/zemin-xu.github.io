<section class="archive-item">
    <div class="archive-text-wrap">
        <?php $arnold_link_item = arnold_get_post_meta(get_the_ID(), 'theme_meta_link_item');
		if($arnold_link_item){ ?>
			<ul class="blog-unit-link">
				<?php foreach($arnold_link_item['name'] as $i => $name){
					$url = $arnold_link_item['url'][$i]; ?>
					<li class="blog-unit-link-li"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($name); ?>" class="blog-unit-link-li-a"><?php echo esc_html($name); ?></a></li>
				<?php } ?>
			</ul>
		<?php } ?>
    </div>
</section>