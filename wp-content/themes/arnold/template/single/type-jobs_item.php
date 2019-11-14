<?php 
$jobs_location = arnold_get_post_meta(get_the_ID(), 'theme_meta_jobs_location');
$jobs_number   = arnold_get_post_meta(get_the_ID(), 'theme_meta_jobs_number'); 
?>

<?php if(get_the_content()){ ?><div class="entry"><?php the_content(); wp_link_pages(); ?></div><!--End entry--><?php } ?>

<div class="job-info">
    <?php if($jobs_location){ ?>
        <span class="job-location"><?php echo esc_html__('Location:','arnold'). ' ' .esc_html($jobs_location); ?></span>
    <?php }
    
    if($jobs_number){ ?>
        <span class="job-number"><?php echo esc_html__('Number:','arnold'). ' ' .esc_html($jobs_number); ?></span>
    <?php } ?>
</div>