<div class="archive-custom container">
    <div class="archive-custom-list">
    	<h2 class="archive-custom-title"><?php esc_html_e('last 10 Posts','arnold'); ?></h2>
    	<ul class="archive-custom-list-ul">
        <?php wp_get_archives('type=postbypost&limit=10'); ?>
        </ul>
        <h2 class="archive-custom-title"><?php esc_html_e('Archives by Month','arnold'); ?></h2>
        <ul class="archive-custom-list-ul">
        <?php wp_get_archives(); ?>
        </ul>
        <ul class="archive-custom-list-ul last-item">
        <h2 class="archive-custom-title"><?php esc_html_e('Archives by Category','arnold'); ?></h2>
        <?php 

        $args = array(
            'show_option_all'    => '',
            'orderby'            => 'name',
            'order'              => 'ASC',
            'style'              => 'list',
            'show_count'         => 0,
            'hide_empty'         => 1,
            'use_desc_for_title' => 1,
            'child_of'           => 0,
            'feed'               => '',
            'feed_type'          => '',
            'feed_image'         => '',
            'exclude'            => '',
            'exclude_tree'       => '',
            'include'            => '',
            'hierarchical'       => 1,
            'title_li'           => '',
            'show_option_none'   => '',
            'number'             => null,
            'echo'               => 1,
            'depth'              => 0,
            'current_category'   => 0,
            'pad_counts'         => 0,
            'taxonomy'           => 'category',
            'walker'             => null
            );

        wp_list_categories($args); 

        ?>
        </ul>
    </div>
</div>