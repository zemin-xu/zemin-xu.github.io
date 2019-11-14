<?php
$page_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_template'); 
$page_button = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_show_link');

if($page_template && $page_template != 'none') {

	if($page_button) { ?>
<div class="portfolio-link-button">
	<?php 
	if(isset($page_button['title'])){
        $button_title = $page_button['title'];
        $switch = true;
        
        if(count($button_title) == 1){
            if(empty($page_button['title'][0]) && empty($page_button['link'][0])){
                $switch = false;
            }
        } 

        if($switch){
            foreach($button_title as $num => $title){
                $link = $page_button['link'][$num]; ?>
    <a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>" class="portfolio-link-button-a"><?php echo esc_html($title); ?></a> 
            <?php
            }	   
        }  
    }
	?>
</div>	
	<?php

	}

}
?>