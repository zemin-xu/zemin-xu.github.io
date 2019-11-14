<?php
$team_position      = arnold_get_post_meta(get_the_ID(), 'theme_meta_team_position');
$team_position      = esc_attr($team_position);
$team_email         = arnold_get_post_meta(get_the_ID(), 'theme_meta_team_email');
$team_email         = esc_attr($team_email);
$team_phone_number  = arnold_get_post_meta(get_the_ID(), 'theme_meta_team_phone_number');
$team_social_medias = arnold_get_post_meta(get_the_ID(), 'theme_meta_team_social_medias');

if(has_post_thumbnail()){
    echo '<div class="team-photo-wrap">';
	echo get_the_post_thumbnail(get_the_ID(), 'full', array('class'=>'team-photo'));
    echo '</div>';
}

if(get_the_content()){ ?><div class="entry"><?php the_content(); wp_link_pages(); ?></div><!--End entry--><?php } ?>

<?php if(arnold_enable_team_template()){ ?>
    <section class="gallery-property">
        <ul class="gallery-info-property">
            <?php if($team_position) { ?>
            <li class="gallery-info-property-li">
                <div class="gallery-info-property-item gallery-info-property-tit"><?php echo esc_html__('POSITION','arnold'); ?></div>
                <div class="gallery-info-property-item gallery-info-property-con"><?php echo esc_html($team_position); ?></div>
            </li>
            <?php } ?>
            <?php if($team_email) { ?>
            <li class="gallery-info-property-li">
                <div class="gallery-info-property-item gallery-info-property-tit"><?php echo esc_html__('EMAIL','arnold'); ?></div>
                <div class="gallery-info-property-item gallery-info-property-con"><?php echo is_email($team_email); ?></div>
            </li>
            <?php } ?>
            <?php if($team_phone_number) { ?>
            <li class="gallery-info-property-li">
                <div class="gallery-info-property-item gallery-info-property-tit"><?php echo esc_html__('PHONE NUMBER','arnold'); ?></div>
                <div class="gallery-info-property-item gallery-info-property-con"><?php echo esc_html($team_phone_number); ?></div>
            </li>
            <?php } ?>
        </ul> 
    </section>  
<?php } ?>