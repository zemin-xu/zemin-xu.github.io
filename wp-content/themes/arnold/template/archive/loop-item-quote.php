<section class="archive-item">
    <div class="archive-text-wrap">
		<?php 
        $arnold_quote = arnold_get_post_meta(get_the_ID(), 'theme_meta_quote');
        $arnold_quote_cite = arnold_get_post_meta(get_the_ID(), 'theme_meta_quote_cite'); ?>
        
        <div class="blog-unit-quote"><?php echo wp_kses_post($arnold_quote); ?>
            <?php if($arnold_quote_cite) { ?>
            <cite><span class="cite-line"></span> <?php echo wp_kses_post($arnold_quote_cite); ?></cite>
            <?php } 
            ?> 
        </div>
    </div>
</section>