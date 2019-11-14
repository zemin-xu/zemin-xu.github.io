<?php
//pagebuilder switch
function ux_pb_switch($post){
	$get_switch = get_post_meta($post->ID, 'ux-pb-switch', true);
	$get_switch = $get_switch ? $get_switch : 'classic';
	$text_pagebuilder = __('Switch to Page Builder','ux');
	$text_classic = __('Classic Editor','ux');
	$button_style = $get_switch == 'classic' ? 'button-primary' : false;
	$button_text = $get_switch == 'classic' ? $text_pagebuilder : $text_classic;
	
	if($post->post_type == 'post' || $post->post_type == 'page' || $post->post_type == 'team'){ ?>
        <div id="ux-pb-switch">
            <input type="button" class="switch-btn button <?php echo sanitize_html_class($button_style); ?> button-large" value="<?php echo esc_attr($button_text); ?>" />
            <input type="hidden" name="ux-pb-switch" class="switch-value" value="<?php echo sanitize_text_field($get_switch); ?>" />
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('.switch-btn').each(function(){
                    var _t = jQuery(this);
                    var _wp_pd = _t.parents('#post-body-content').find('#postdivrich');
                    var _pb_box = _t.parents('#post-body-content').find('#ux-pb-box');
					var ux_pb_box_container = jQuery('.ux-pb-box-container');
					var ux_pb_subbox_container = jQuery('.ux-pb-subbox-container');
                    
                    _t.click(function(){
                        var _this = jQuery(this);
                        if(_this.hasClass('button-primary')){
                            _this.removeClass('button-primary').val('<?php echo esc_attr($text_classic); ?>');
                            _this.next('.switch-value').val('pagebuilder');
                            _wp_pd.slideUp(); _pb_box.show();
							
							var ux_pb = new PageBuilder();
							ux_pb.refreshitem();
							if(ux_pb_subbox_container.length){
								ux_pb_subbox_container.each(function(index, element){
									var _this = jQuery(this);
									_this.isotope('reloadItems').isotope({sortBy: 'original-order'}, function(){
										ux_pb.refreshitem();
										_this.isotope('reLayout'); 
									});
								});
							}
							
							ux_pb_subbox_container.isotope('reloadItems').isotope({sortBy: 'original-order'}, function(){
								 ux_pb_box_container.isotope('reLayout'); 
							});
							
							setTimeout(function(){
								ux_pb_subbox_container.isotope('reLayout')
								ux_pb_box_container.isotope('reLayout'); 
							}, 1000);
                        }else{
                            _this.addClass('button-primary').val('<?php echo esc_attr($text_pagebuilder); ?>');
                            _this.next('.switch-value').val('classic');
                            _wp_pd.slideDown(); _pb_box.hide();
                        }
					});
                });
            });
        </script>
    <?php
	}
}
add_action('edit_form_after_title', 'ux_pb_switch');

//pagebuilder wrap
function ux_pb_wrap($post){
	global $ux_pagebuilder; ?>
    <div id="ux-pb-box" class="postbox ux-theme-box">
        <h3 class="hndle"><span><?php esc_html_e('Page Builder','ux');?></span></h3>
        <div class="inside">
            <input type="hidden" name="ux_pb_meta_box_nonce" value="<?php echo esc_attr(wp_create_nonce(ABSPATH)); ?>" />
        
            <div id="ux-pb-box-choose"><?php ux_pb_choose_module(); ?></div>
            
            <div id="ux-pb-box-cols">
                <input pb-col='12' value="1/1" type="hidden" />
                <input pb-col="9" value="3/4" type="hidden" />
                <input pb-col="8" value="2/3" type="hidden" />
                <input pb-col="6" value="1/2" type="hidden" />
                <input pb-col="4" value="1/3" type="hidden" />
                <input pb-col="3" value="1/4" type="hidden" />
            </div>
            
            <div id="ux-pb-box-bgcolor"><?php $ux_pagebuilder->box_bgcolor(); ?></div>
            
            <div id="ux-pb-box-toolbar">
                <div id="ux-pb-box-toolbar-main">
                    <?php do_action('ux-pb-box-toolbar-main'); ?>
                </div>
                <div id="ux-pb-box-toolbar-sub" class="text-right">
                    <?php do_action('ux-pb-box-toolbar-sub'); ?>
                </div>
            </div>
            <div id="ux-pb-box-container">
                <div class="ux-pb-box-container">
                    <?php ux_pb_load_module(get_the_ID()); ?>
                    
                </div>
            </div>
            
            <?php ux_pb_modal(); ?>
        </div>
    </div>
    <script type="text/javascript">
		jQuery(document).ready(function(){
			var ux_pb = new PageBuilder();
			ux_pb.init();
			ux_pb.modalsave();
			ux_pb.modaledit();
			ux_pb.loadtemplate();
			ux_pb.deletetemplate();
			
			jQuery(window).resize(function(){
				ux_pb.refreshitem();
			});
		});
    </script>
<?php
}
add_action('edit_form_after_editor', 'ux_pb_wrap', 1);

//pagebuilder modal
function ux_pb_modal(){ ?>
    <div class="modal fade" id="ux-pb-modal" role="dialog" aria-labelledby="ux-pb-modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="model-open-subwin"></div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="ux-pb-modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div id="ux-pb-modal-body">
                        <div id="ux-pb-modal-body-before"></div>
                        <div id="ux-pb-box-editor">
                            <div class="row ux-pb-module-field" data-type="content" data-name="ux-pb-module-content">
                                <div class="col-xs-4">
                                    <h5><strong></strong></h5>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="col-xs-8">
									<?php wp_editor('', 'ux-pb-module-content',
                                        array(
                                            'quicktags' => true,
                                            'tinymce' => true,
                                            'media_buttons' => true,
                                            'textarea_rows' => 10,
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        <div id="ux-pb-modal-body-after"></div>
                    </div>
                </div>
                <div id="ux-pb-modal-footer" class="modal-footer">
                    <button type="button" class="btn btn-default ux-pb-modalclose" data-dismiss="modal"><?php esc_html_e('Close','ux'); ?></button>
                    <button type="button" data-loading-text="<?php esc_attr_e('Saving...','ux'); ?>" class="btn btn-primary ux-pb-modalsave"><?php esc_html_e('Save','ux'); ?></button>
                    <button type="button" data-loading-text="<?php esc_attr_e('Saving...','ux'); ?>" class="btn btn-success ux-pb-modaledit"><?php esc_html_e('Save Item','ux'); ?></button>
                    <button type="button" data-loading-text="<?php esc_attr_e('Loading...','ux'); ?>" class="btn btn-success ux-pb-loadtemplate"><?php esc_html_e('Load Template','ux'); ?></button>
                    <button type="button" data-loading-text="<?php esc_attr_e('Deleting...','ux'); ?>" class="btn btn-danger ux-pb-deletetemplate pull-left"><?php esc_html_e('Delete Template','ux'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php
}

//pagebuilder toolbar wrap
function ux_pb_box_toolbar_wrap(){ ?>
    <div class="btn-group dropdown">
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-plus"></span> <?php esc_html_e('Wrap','ux'); ?></button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#" data-toggle="insert-wrap" data-id="general" data-target=".ux-pb-box-container"><?php esc_html_e('General Wrap','ux'); ?></a></li>
            <li><a href="#" data-toggle="insert-wrap" data-id="fullwidth" data-target=".ux-pb-box-container"><?php esc_html_e('FullWidth Wrap','ux'); ?></a></li>
            <li><a href="#" data-toggle="insert-wrap" data-id="fullwidth-block" data-target=".ux-pb-box-container"><?php esc_html_e('FullWidth Wrap (Block)','ux'); ?></a></li>
        </ul>
    </div>
<?php	
}
add_action('ux-pb-box-toolbar-main', 'ux_pb_box_toolbar_wrap');

//pagebuilder toolbar wrap
function ux_pb_box_toolbar_choose(){
	$title = __('Choose Module','ux'); ?>
    <div class="btn-group">
        <button type="button" class="btn btn-default" data-target="#ux-pb-modal" data-totarget="ux-pb-box-container" data-title="<?php echo esc_attr($title); ?>" data-id="choose-module"><?php echo esc_html($title); ?> <span class="glyphicon glyphicon-align-justify"></span></button>
    </div>
<?php	
}
add_action('ux-pb-box-toolbar-main', 'ux_pb_box_toolbar_choose');

//pagebuilder toolbar template
function ux_pb_box_toolbar_template(){ ?>
    <div class="btn-group dropdown">
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><?php esc_html_e('Template','ux'); ?> <span class="glyphicon glyphicon-align-justify"></span></button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#" data-target="#ux-pb-modal" data-title="<?php esc_attr_e('Save Current Layout as a Template','ux'); ?>" data-id="save_current_template"><?php esc_html_e('Save Current Layout as a Template','ux'); ?></a></li>
            <li><a href="#" data-target="#ux-pb-modal" data-title="<?php esc_attr_e('Load a Template','ux'); ?>" data-id="load_template"><?php esc_html_e('Load a Template','ux'); ?></a></li>
        </ul>
    </div>
<?php	
}
add_action('ux-pb-box-toolbar-sub', 'ux_pb_box_toolbar_template');

//pagebuilder module interface template
function ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, $items, $key){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	
	$cols = array(
		'12' => 'col-md-12 col-sm-12',
		'9'  => 'col-md-9 col-sm-9',
		'8'  => 'col-md-8 col-sm-8',
		'6'  => 'col-md-6 col-sm-6',
		'4'  => 'col-md-4 col-sm-4',
		'3'  => 'col-md-3 col-sm-3'
	);
	
	switch($type){
		case 'fullwidth':
			do_action('ux-pb-module-template-fullwidth', array('itemid' => $itemid, 'items' => $items));
		break;
		
		case 'fullwidth-block':
			do_action('ux-pb-module-template-fullwidth-block', array('itemid' => $itemid, 'items' => $items));
		break;
		
		case 'general': ?>
            <div class="<?php echo esc_attr($cols[$col]); ?> general_moudle">
				<?php if($items){
                    echo '<div class="row">';
                    foreach($items as $i => $item){
                        $col = $item['col'];
                        $type = $item['type'];
                        $first = $item['first'];
                        $itemid = $item['itemid'];
                        $moduleid = $item['moduleid'];
                        
                        if($first == 'is'){
                            if($i != 0){
                                echo '</div>';
                                echo '<div class="row">';
                            }
                        }
                        
                        ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, false, 'module');
                    }
                    echo '</div>';
                } ?>
            </div>
		<?php
		break;
		
		case 'module':
			$ux_pb_module_fields  = ux_pb_module_fields();
			$animation_class = false;
			if(isset($ux_pb_module_fields[$moduleid])){
				if(isset($ux_pb_module_fields[$moduleid]['animation'])){
					$animation_class = $ux_pb_module_fields[$moduleid]['animation'];
				}
			}
			
			$advanced_settings    = get_post_meta($module_post, 'module_advanced_settings', true);
			$bottom_margin        = get_post_meta($module_post, 'module_bottom_margin', true);
			$scroll_animation     = get_post_meta($module_post, 'module_scroll_in_animation', true);
			$bottom_margin        = $bottom_margin ? $bottom_margin : false;
			$scroll_in_animation  = $scroll_animation == 'on' ? 'moudle_has_animation' : false;
			$style_in_animation   = $scroll_animation == 'on' ? ' animation_hidden' : false;  ?>
            
			<div class="<?php echo esc_attr($cols[$col]); ?> moudle <?php echo esc_attr($scroll_in_animation); ?> <?php echo esc_attr($bottom_margin); ?>" style="">
				<?php do_action('ux-pb-module-template-' . $moduleid, $itemid); ?>
			</div>
		<?php
        break;
	}
}

//pagebuilder module interface
function ux_pb_module_interface(){
	global $post;
	$ux_pb_meta = get_post_meta($post->ID, 'ux_pb_meta', true);
	
	if($ux_pb_meta){
		foreach($ux_pb_meta as $i => $wrap){
			$col = $wrap['col'];
			$type = $wrap['type'];
			$first = $wrap['first'];
			$itemid = $wrap['itemid'];
			$moduleid = isset($wrap['moduleid']) ? $wrap['moduleid'] : false;
			$items = isset($wrap['items']) ? $wrap['items'] : false;
			
			if(function_exists('ux_enable_sidebar')){
				$container = ux_enable_sidebar() ? false : 'container';
			}else{
				$container = 'container-fluid';
			}
			
			if($i == 0){
				if($type == 'fullwidth' || $type == 'fullwidth-block'){
					echo '<div class="fullwrap_moudle"><div class="row">';
				}else{
					echo '<div class="' . esc_attr($container) . '"><div class="row">';
				}
			}
			
			if($first == 'is'){
				if($i != 0){
					echo '</div></div>';
					if($type == 'fullwidth' || $type == 'fullwidth-block'){
						echo '<div class="fullwrap_moudle"><div class="row">';
					}else{
						echo '<div class="' . esc_attr($container) . '"><div class="row">';
					}
				}
			}
			
			ux_pb_module_interface_template($col, $type, $first, $itemid, $moduleid, $items, 'wrap');
			
			if($i == count($ux_pb_meta) - 1){
				echo '</div></div>';
			}
		}
	}
}
add_action('ux-theme-single-pagebuilder', 'ux_pb_module_interface');

//pagebuilder module interface the_content
function ux_pb_module_interface_the_content($content){
	if(!function_exists('ux_interface_pagebuilder')){
		$ux_pb_switch = get_post_meta(get_the_ID(), 'ux-pb-switch', true);
		if($ux_pb_switch == 'pagebuilder'){
			$content  = '<div class="pagebuilder-wrap">';
			$content .= ux_pb_module_interface();
			$content .= '</div>';
		}
	}
	
	return $content;
}
add_filter('the_content', 'ux_pb_module_interface_the_content', 999);

//pagebuilder module fields interface
function ux_pb_module_fields_interface($moduleid, $itemid){
	$ux_pb_module_fields = ux_pb_module_fields();
	
	if(isset($ux_pb_module_fields[$moduleid])){
		$items = $ux_pb_module_fields[$moduleid]['item'];
		foreach($items as $item){
			$item_title = isset($item['title']) ? $item['title'] : false;
			$item_bind = isset($item['bind']) ? $item['bind'] : false;
			$item_description = isset($item['description']) ? $item['description'] : false;
			$item_control = isset($item['control']) ? $item['control'] : false;
			$item_control = $item_control ? 'data-control="' .esc_attr($item_control['name']). '" data-controlvalue="' .esc_attr($item_control['value']). '"' : false;
			$item_subcontrol = isset($item['subcontrol']) ? $item['subcontrol'] : false;
			$item_subcontrol_type = false;
			if($item_subcontrol){
				$item_subcontrol = explode('|', $item['subcontrol']);
				$item_subcontrol_name = $item_subcontrol[0];
				$item_subcontrol_type = $item_subcontrol[1];
			}
			$item_subcontrol = $item_subcontrol ? 'data-subcontrol="' .esc_attr($item_subcontrol_name). '"' : false;
			$item_subcontrol_type = $item_subcontrol_type ? 'data-subcontrol-type="' .esc_attr($item_subcontrol_type). '"' : false; 
			$item_modalbody = isset($item['modal-body']) ? 'data-modalbody="' .esc_attr($item['modal-body']). '"' : false;
			
			$item_twolevel = isset($item['two-level']) ? $item['two-level'] : false;
			$item_twolevel = $item_twolevel ? 'data-twolevel="' .esc_attr($item_twolevel). '"' : false;
			
			if($item['type'] == 'divider'){ ?>
            
                <div class="ux-pb-divider"></div>
            
            <?php }else{ ?>
            
                <div class="row ux-pb-module-field module-ajaxfield" data-name="<?php echo esc_attr($item['name']); ?>" data-type="<?php echo esc_attr($item['type']); ?>" <?php echo balanceTags($item_control); ?> <?php echo balanceTags($item_subcontrol); ?> <?php echo balanceTags($item_subcontrol_type); ?> <?php echo balanceTags($item_modalbody); ?> <?php echo balanceTags($item_twolevel); ?>>
                    
                    <?php if($item['type'] == 'message'){ ?>
                        <div class="col-xs-12">
                            <?php ux_pb_getfield($item, $itemid, $moduleid); ?>
                        </div>
                    <?php }else{ ?>
                        <div class="col-xs-4">
                            <h5><strong>
								<?php if($item['type'] == 'none'){
									echo '<span class="label label-primary">' . wp_kses_post($item_title) . '</span>';
								}else{
									echo esc_html($item_title);
								}?>
                            </strong></h5>
                            <p class="text-muted"><?php echo wp_kses_post($item_description); ?></p>
                        </div>
                        
                        <div class="col-xs-8">
                            <?php if($item_bind){
                                foreach($item_bind as $bind){
                                    if($bind['position'] == 'before'){
                                        ux_pb_getfield($bind, $itemid, $moduleid);
                                    }
                                }
                            }
                            
                            ux_pb_getfield($item, $itemid, $moduleid);
                            
                            if($item_bind){
                                foreach($item_bind as $bind){
                                    if($bind['position'] == 'after'){
                                        ux_pb_getfield($bind, $itemid, $moduleid);
                                    }
                                }
                            } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php
			}
		}
	}
}

//pagebuilder module pagenums
function ux_view_module_pagenums($itemid, $moduleid, $per_page, $count, $pagination, $exclude_ids=''){
	global $ux_pagebuilder; 
	$module_post = $ux_pagebuilder->item_postid($itemid);
	$per_page    = intval($per_page);
	$per_page    = $per_page == 0 ? 1 : $per_page;
	$page_paged  = $per_page != -1 ? ceil($count/$per_page) : 1;
	
	if(empty($module_post)){
		$module_post = $itemid;
	}
	
	$exclude_data = $exclude_ids != '' ? 'data_exclude="' .$exclude_ids. '"': false;
	
	switch($pagination){
		case 'page_number':
			if($page_paged > 1){ ?>
				<div class="clearfix pagenums"> 
                    <div class="pagination">
                        <?php
                        $i = 0;
                        for($i=1; $i<=$page_paged; $i++){
                            if($i == 1){
                                $current = 'current';
                            }else{
                                $current = '';
                            }
                            ?><a class="<?php echo sanitize_html_class($current); ?> pagenums-a inactive select_pagination not_pagination" data-post="<?php echo esc_attr($itemid); ?>" data-postid="<?php echo esc_attr($module_post); ?>" data-paged="<?php echo esc_attr($i); ?>" data-module="<?php echo esc_attr($moduleid); ?>" href="#" data-exclude="<?php echo esc_attr($exclude_ids); ?>"><?php echo esc_html($i); ?></a><?php
                        }

                        ?>

                    </div>
                </div><!--End pagenums-->
			<?php	
			}
			

		break;
		
		case 'twitter':
			$pagination_text = ux_get_option('theme_option_descriptions_pagination');
			$pagination_text = $pagination_text ? $pagination_text : __('LOAD MORE ARTICLES','ux');
			if($page_paged > 1){ ?>
                <div class="clearfix pagenums tw_style page_twitter" data-pagetext="<?php echo esc_attr($pagination_text); ?>">
                    <a class="tw-style-a not_pagination ux-btn" data-post="<?php echo esc_attr($itemid); ?>" data-postid="<?php echo esc_attr($module_post); ?>" data-paged="2" data-count="<?php echo esc_attr($page_paged); ?>" data-module="<?php echo esc_attr($moduleid); ?>" href="#" data-exclude="<?php echo esc_attr($exclude_ids); ?>"><?php echo esc_html($pagination_text); ?></a>
                </div>
			<?php
			}
		break;
		
		case 'infiniti_scroll': ?>
            <div class="clearfix pagenums tw_style infiniti_scroll">
                <a class="tw-style-a not_pagination" data-post="<?php echo esc_attr($itemid); ?>" data-postid="<?php echo esc_attr($module_post); ?>" data-paged="2" data-module="<?php echo esc_attr($moduleid); ?>" href="#"><?php esc_html_e('LOAD MORE','ux'); ?></a>
            </div>
        <?php
		break;
	}
}
//pagebuilder module portfolio col template
function ux_pb_module_portfolio_col_template($post_id, $layout, $inside_style){
	$layout_class = false;
	switch($layout){
		case 'col1': $layout_class = 'list-layout-col1-item'; break;
		case 'col2': $layout_class = 'list-layout-col2-item'; break;
		case 'col3': $layout_class = 'list-layout-col3-item'; break;
	}
	
	if($post_id){ 
		$item = get_post($post_id);
		
		$enable_video_cover = ux_get_post_meta($item->ID, 'theme_meta_enable_video_cover');
		$video_cover_alt_image = ux_get_post_meta($item->ID, 'theme_meta_video_cover_alt_image');
			
		$style = false;

		$learnmore = ux_get_option('theme_option_descriptions_portfolio_learnmore');
		$learnmore = $learnmore ? $learnmore : esc_attr__('LEARN MORE','ux');

		$bg_color  = ux_get_post_meta($item->ID, 'theme_meta_bg_color');
        $bg_color  = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
		
		if($enable_video_cover && $video_cover_alt_image){
			$style = 'background:url(' .$video_cover_alt_image. ') 50% 50% no-repeat; background-size:cover;';
		}elseif(has_post_thumbnail($item->ID)){    
			$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($item->ID), 'full');
			$style = 'background-image:url(' .$thumb[0]. ');';
		}  ?>
		<section class="<?php echo sanitize_html_class($layout_class); ?> list-layout-item" style="">
			<div class="list-layout-inside" style=" <?php echo esc_attr($inside_style); ?>">
				<div class="list-layout-image" style=" <?php echo esc_attr($style); ?>">
					<div class="list-layout-con <?php echo esc_attr($bg_color); ?>">
						<h1 class="list-layout-tit"><a class="list-layout-tit-a" href="<?php echo esc_url(get_permalink($item->ID)); ?>" title="<?php echo esc_attr(get_the_title($item->ID)); ?>"><?php echo esc_html(get_the_title($item->ID)); ?></a></h1>
						<div class="list-layout-des"><?php echo esc_html($item->post_excerpt); ?></div>
						<a href="<?php echo esc_url(get_permalink($item->ID)); ?>" title="<?php echo esc_attr(get_the_title($item->ID)); ?>" class="list-layout-more ux-btn"><?php echo balanceTags($learnmore); ?><span class="fa fa-long-arrow-right"></span></a>
					</div>
				</div>
                <?php if($enable_video_cover){
					$webm = ux_get_post_meta($item->ID, 'theme_meta_video_cover_webm');
					$mp4 = ux_get_post_meta($item->ID, 'theme_meta_video_cover_mp4');
					$ogg = ux_get_post_meta($item->ID, 'theme_meta_video_cover_ogg');
					$iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
					$iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
					$iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
					$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
					$webOS = stripos($_SERVER['HTTP_USER_AGENT'],"webOS"); 
					$ie9 = strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 9.0");
					?>
					
                    <div class="fullwrap-video">
                        <?php if(!$ie9 && !$iPod && !$iPhone && !$iPad && !$Android && !$webOS) { ?>
                        <video id="video-<?php echo esc_attr($item->ID); ?>" autoplay muted loop poster="<?php echo esc_url($thumb[0]); ?>" class="centered-ux video-tag">
                            <?php if($webm){ ?><source src="<?php echo esc_url($webm); ?>" type="video/webm"><?php } ?>
                            <?php if($mp4){ ?><source src="<?php echo esc_url($mp4); ?>" type="video/mp4"><?php } ?>
                            <?php if($ogg){ ?> <source src="<?php echo esc_url($ogg); ?>" type="video/ogg"><?php } ?>
                        </video>
                        <?php } ?>
                    </div>
				<?php } ?>
			</div>
		</section>
		<?php
	}
}

//pagebuilder plugin option
function ux_pb_interface_plugin_option(){
	$_uxnonce = (isset($_POST['_uxnonce'])) ? $_POST['_uxnonce'] : false;
	if(isset($_POST['action'])){
		if(!wp_verify_nonce($_uxnonce, admin_url('admin.php?page=bm-pagebuilder'))){
			die('warning'); 
		}else{
			if(isset($_POST['ux_google_map_apikey'])){
				update_option('ux_google_map_apikey', $_POST['ux_google_map_apikey']);
			}
		}
	} ?>
    
	<div class="wrap">
        <div class="icon32" id="icon-themes"><br></div>
        <h2>
            <?php esc_html_e('BM PageBuilder','ux') ?>
        </h2>
        
        <form action="<?php echo admin_url('admin.php?page=bm-pagebuilder'); ?>" method="post">
            <input type="hidden" name="action" value="save" />
            <input type="hidden" name="_uxnonce" value="<?php echo wp_create_nonce(admin_url('admin.php?page=bm-pagebuilder')); ?>" />
            <table class="form-table">
                <tbody>
                    <tr>
                        <?php $google_maps_apikey = get_option('ux_google_map_apikey'); ?>
                        <th scope="row"><label><?php esc_html_e('Google Maps Apikey','ux') ?></label></th>
                        <td><input name="ux_google_map_apikey" type="text" id="ux_google_map_apikey" value="<?php echo sanitize_text_field($google_maps_apikey); ?>" class="regular-text code">
                        <p class="description" id="home-description"><a href="https://developers.google.com/maps/documentation/javascript/"><?php esc_html_e('How to get Google Maps Api Key','ux') ?></a></p></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
        </form>
    </div>
<?php
}
?>