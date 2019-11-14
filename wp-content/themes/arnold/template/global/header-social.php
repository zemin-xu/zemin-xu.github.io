<?php 
$social_medias = arnold_get_option('theme_option_show_social_medias');

$social_media_title = arnold_get_option('theme_option_social_media_title');
$social_media_descriptions = arnold_get_option('theme_option_social_media_descriptions');
	
if($social_medias && isset($social_medias['icontype'])){
	$icon_type = $social_medias['icontype'];  ?>
	
    <ul class="socialmeida clearfix">						
        <?php foreach($icon_type as $num => $type){
            $icon = $social_medias['icon'][$num];
            $url = $social_medias['url'][$num];
            $tip = $social_medias['tip'][$num];  
            $tip_wrap =  $tip ? '<span class="socialmeida-text">'.esc_attr($tip).'</span>' : false; 
            ?>
            
            <li class="socialmeida-li">
                <a title="<?php echo esc_attr($tip); ?>" href="<?php echo esc_url($url); ?>" class="socialmeida-a">
                    <?php      
                    if($type == 'user'){
                        echo '<img src="' .esc_url($icon). '" alt="' .esc_attr($tip). '" /> ';
                    } else { 
                        if($icon) { echo '<span class="' .esc_attr($icon). '"></span> '; } 
                    } 
                    echo balanceTags($tip_wrap);
                    ?>

                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>