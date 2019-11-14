<?php
$header_layout = arnold_get_option('theme_option_header_layout') ? arnold_get_option('theme_option_header_layout') : 'horizon-menu-right';
$menu_panle_type = arnold_get_option('theme_option_menu_panle_type') ? arnold_get_option('theme_option_menu_panle_type') : 'open_menu_panel_below';
$menu_text = arnold_get_option('theme_option_descriptions_menu') ? arnold_get_option('theme_option_descriptions_menu') : esc_html__('MENU','arnold');
$menu_close_text = arnold_get_option('theme_option_descriptions_menu_close') ? arnold_get_option('theme_option_descriptions_menu_close') : esc_html__('CLOSE','arnold');
$header_width = arnold_get_option('theme_option_header_width') ? arnold_get_option('theme_option_header_width') : false;
$header_width_class =  $header_width == 'fixed' ? 'container' : 'container-fluid';
$expanded_show_cart = arnold_get_option('theme_option_show_shopping_cart');
$header_show_social = arnold_get_option('theme_option_show_social');

$start_from_page_top = false;
if(is_page()){
	$start_from_page_top = arnold_get_post_meta(get_the_ID(), 'theme_meta_page_start_from_page_top');
	if($start_from_page_top){
		$start_from_page_top = 'start-from-top';
	}
}

?>

<header id="header" class="<?php echo sanitize_html_class($start_from_page_top); ?>">

    <div id="header-main" class="header-main">
    
        <div class="<?php echo sanitize_html_class($header_width_class); ?>">

            <span id="navi-trigger">
                <span class="navi-trigger-text">
                    <span class="navi-trigger-text-menu navi-trigger-text-inn"><?php echo esc_html($menu_text); ?></span>
                    <span class="navi-trigger-text-close navi-trigger-text-inn"><?php echo esc_html($menu_close_text); ?></span>
                </span>
                <span class="navi-trigger-inn"></span>
            </span>
            
            <?php if($header_layout == 'horizon-menu-left'){ 
                
                     //** Function Social
					if($header_show_social){ ?>
                    <div class="header-bar-social">
						<?php arnold_interface_header_social(); ?>
                    </div>
					<?php } 
            } ?>

            <?php if($header_layout == 'horizon-menu-right' || $header_layout == 'horizon-menu-left' || $header_layout == 'columned-menu-right' || $header_layout == 'menu-icon-horizon-menu'){ ?>
            
                <div class="heade-meta">
                
                    <?php if($header_layout == 'horizon-menu-right' || $header_layout == 'columned-menu-right' || $header_layout == 'menu-icon-horizon-menu'){
						//** Function Social
						if($header_show_social){ ?>
                            <div class="header-bar-social">
                                <?php arnold_interface_header_social(); ?>
                            </div>
                        <?php
                        }
					} ?>
    
                    <nav id="navi-header">
    
                        <?php wp_nav_menu(array(
                            'theme_location'  => 'primary',
                            'container_id' => 'navi_wrap',
                            'items_wrap' => '<ul class="%2$s clearfix">%3$s</ul>'
                        )); ?><!--End #navi_wrap-->
    
                    </nav>
                    
                </div>
            
            <?php } ?>
            
            <div class="navi-logo">

                <div class="logo-wrap">
                    <?php //** Function Logo for header
                    arnold_interface_logo('header'); ?>
                </div><!--End logo wrap-->
                 
            </div>

            <?php if ($header_layout == 'logo-centered') { ?>
            <nav id="navi-header">

                <?php wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'container_id' => 'navi_wrap',
                    'items_wrap' => '<ul class="%2$s clearfix">%3$s</ul>'
                )); ?><!--End #navi_wrap-->

            </nav>
            <?php } ?>
        
        </div>
        
    </div><!--End header main-->
    
</header>