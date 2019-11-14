<?php
$visible = 'visible';

//** enable page loading
$arnold_enable_fadein_effect = arnold_get_option('theme_option_enable_fadein_effect');

if($arnold_enable_fadein_effect){ ?>
<div class="page-loading fullscreen-wrap <?php echo esc_attr($visible); ?>">
    <div class="page-loading-inn">
        <div class="page-loading-transform">
            <?php arnold_interface_logo('loading'); ?>
        </div>
    </div>
</div>
<?php } ?>