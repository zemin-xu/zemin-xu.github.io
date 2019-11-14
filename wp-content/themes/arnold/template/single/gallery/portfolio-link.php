<?php
$gallery_template = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_template');
$gallery_show_button = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_show_button');
$gallery_buttons = arnold_get_post_meta(get_the_ID(), 'theme_meta_gallery_buttons');

$container = 'container';

if($gallery_show_button){ ?>

    <div class="gallery-link <?php echo sanitize_html_class($container); ?>">
    
        <?php
        if($gallery_buttons){
            
            if(isset($gallery_buttons['title'])){
                $button_title = $gallery_buttons['title'];
                $switch = true;
                
                if(count($button_title) == 1){
                    if(empty($gallery_buttons['title'][0]) && empty($gallery_buttons['link'][0])){
                        $switch = false;
                    }
                } 
        
                if($switch){
                    foreach($button_title as $num => $title){
                        $link = $gallery_buttons['link'][$num]; ?>
                        <p><a href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($title); ?>" class="gallery-link-a" target="_blank"><?php echo esc_html($title); ?></a></p> 
                    <?php
                    }	   
                }  
            }
        } ?>
    
    </div>

<?php } ?>