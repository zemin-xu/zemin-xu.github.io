<?php
/**
 * Plugin Name: BM PageBuilder
 * Plugin URI: http://www.uiueux.com/
 * Description: Drag & Drop page builder with 20+ useful modules to build your pages/blogs.
 * Author: uiueux
 * Author URI: http://www.uiueux.com/ 
 * Version:  1.1.0
 * License:  You should have purchased a license from Themeforest, author:bwsm
 * Log: 
 * v1.1.0  20160428  [Add] Fullwidth Block  
 */
 
$uxPageBuilderVersion = "1.1.0";

if (!defined('ABSPATH')) exit;

class UX_PageBuilder{
	
	function __construct() {
		add_action('init', array( &$this, 'init'), 1000);
		add_action('admin_init', array( &$this, 'enqueue'), 1000);
	}
	
	function init() {
		add_action('wp_enqueue_scripts', array( &$this, 'theme_enqueue'), 100);
		add_action('wp_head',            array( &$this, 'theme_ajaxurl'), 1);
		add_action('save_post',          array( &$this, 'meta_save'));
		
		require_once dirname(__FILE__) . '/inc_php/ux-pb-interface.php';
		require_once dirname(__FILE__) . '/inc_php/ux-pb-config.php';
		require_once dirname(__FILE__) . '/inc_php/ux-pb-fields.php';
		require_once dirname(__FILE__) . '/inc_php/ux-pb-ajax.php';
		require_once dirname(__FILE__) . '/inc_php/ux-pb-animation.php';
		require_once dirname(__FILE__) . '/inc_php/ux-pb-modules.php';
		require_once dirname(__FILE__) . '/inc_php/ux-pb-import.php';
		require_once dirname(__FILE__) . '/inc_php/ux-theme-function.php';
		require_once dirname(__FILE__) . '/inc_php/ux-theme-register.php';
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		
		$ux_pb_modules = ux_pb_modules();
		if(count($ux_pb_modules) > 0){
			if(defined('DOING_AJAX') && isset($_POST['id'])){
				$moduleid = str_replace('module-', '', $_POST['id']);
				foreach($ux_pb_modules as $id => $modules){
					if($id == $moduleid){
						$file_name = $id . '.php';
						require_once plugin_dir_path( __FILE__ ) . 'modules/' . $file_name;
					}
				}
			}else{
				foreach($ux_pb_modules as $id => $modules){
					$file_name = $id . '.php';
					require_once plugin_dir_path( __FILE__ ) . 'modules/' . $file_name;
				}
			}
		}
		
		$this->register();
	}
	
	function enqueue() {
		wp_enqueue_style('ux-admin-bootstrap', plugins_url("css/bootstrap.css", __FILE__), array(), '3.0.2');
		wp_enqueue_style('ux-admin-bootstrap-theme', plugins_url("css/bootstrap-theme.css", __FILE__), array(), '3.0.2');
		wp_enqueue_style('ux-admin-bootstrap-switch', plugins_url("css/bootstrap-switch.css", __FILE__), array(), '1.8');
		wp_enqueue_style('ux-admin-bootstrap-datetimepicker', plugins_url("css/bootstrap-datetimepicker.min.css", __FILE__), array(), '0.0.1');
		wp_enqueue_style('ux-admin-icheck', plugins_url("css/icheck/all.css", __FILE__), array(), '0.9.1');
		wp_enqueue_style('font-awesome', plugins_url("css/font-awesome.min.css", __FILE__), array(), '4.0.3');
		
		wp_enqueue_style('ux-pb-style', plugins_url("css/pagebuilder.css", __FILE__), array(), '0.0.1');
		
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-draggable');
	
		$google_maps_apikey = get_option('ux_google_map_apikey'); 
		wp_enqueue_script('ux-pb-googlemap', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=' .$google_maps_apikey, array('jquery'), '3.0', false);
		wp_enqueue_script('ux-admin-bootstrap', plugins_url("js/bootstrap.min.js", __FILE__), array( 'jquery' ), '3.0.2', true);
		wp_enqueue_script('ux-admin-bootstrap-switch', plugins_url("js/bootstrap-switch.min.js", __FILE__), array( 'jquery' ), '1.8', true);
		wp_enqueue_script('ux-admin-bootstrap-datetimepicker', plugins_url("js/bootstrap-datetimepicker.js", __FILE__), array( 'jquery' ), '0.0.1', true);
		wp_enqueue_script('ux-admin-icheck', plugins_url("js/jquery.icheck.min.js", __FILE__), array( 'jquery' ), '0.9.1', true);
		wp_enqueue_script('ux-admin-isotope', plugins_url("js/jquery.isotope.min.js", __FILE__), array( 'jquery' ), '1.5.25', true);
		wp_enqueue_script('ux-pb-script', plugins_url("js/pagebuilder.js", __FILE__), array( 'jquery' ), '0.0.1', true);
		
		
		do_action('ux_pb_enqueue_scripts');
	}
	
	function theme_enqueue() {
		global $post;
		if($post){
			$ux_pb_switch = get_post_meta($post->ID, 'ux-pb-switch', true);
			if($ux_pb_switch == 'pagebuilder'){
				if($this->has_module('price') || ux_has_module('progress-bar')){
					wp_enqueue_style('ux-googlefont-lato', 'http://fonts.googleapis.com/css?family=Lato', array(), '1.0.0');
				}

				wp_enqueue_style('ux-interface-bootstrap', plugins_url("css/bootstrap-front.css", __FILE__), array(), '2.3.1');
				wp_enqueue_style('ux-interface-font-awesome', plugins_url("css/font-awesome.min.css", __FILE__), array(), '4.5.0');
				if(is_admin()) {
					wp_enqueue_style('ux-admin-theme-icons', plugins_url("css/icons.css", __FILE__), array(), '0.0.1');
				}
				wp_enqueue_style('ux-interface-photoswipe', plugins_url("css/photoswipe.css", __FILE__), array(), '4.0.5');
				wp_enqueue_style('ux-interface-photoswipe-default-skin', plugins_url("css/skin/photoswipe/default/default-skin.css", __FILE__), array(), '4.0.5');
				wp_enqueue_style('ux-interface-pagebuild', plugins_url("css/pagebuild.css", __FILE__), array(), '0.0.1');
				
				if($this->has_module('count-down')){
					wp_enqueue_script('ux-interface-countdown', plugins_url("js/jquery.countdown.min.js", __FILE__), array( 'jquery' ), '1.6.3', true);
				}
				if($this->has_module('progress-bar')){
					wp_enqueue_script('ux-interface-infographic', plugins_url("js/infographic.js", __FILE__), array( 'jquery' ), '1.7.0', true);
				}
				
				if($this->has_module('google-map')){
					$google_maps_apikey = get_option('ux_google_map_apikey'); 
					wp_enqueue_script('ux-interface-googlemap', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=' .$google_maps_apikey, array('jquery'), '3.0.0');
				}
	
				wp_enqueue_script('ux-interface-main', plugins_url("js/main.js", __FILE__), array( 'jquery' ), '0.0.1', true);
				wp_enqueue_script('ux-pb-theme-script', plugins_url("js/theme.pagebuilder.js", __FILE__), array( 'jquery' ), '0.0.1', true);
				
			}
		}
	}
	
	//pagebuilder register
	function register() {
		register_post_type('modules', array('label' => __('Modules (PageBuilder)','ux'), 'show_ui' => false));
		register_post_type('module_template', array('label' => __('Module Template (PageBuilder)','ux'), 'show_ui' => false));
		
		$ux_theme_register_post_type = ux_theme_register_other_post_type(array());
		foreach($ux_theme_register_post_type as $slug => $post_type){
			$labels = array(
				'name'               => $post_type['name'],
				'singular_name'      => $post_type['name'],
				'add_new'            => $post_type['add_new'],
				'add_new_item'       => $post_type['add_new_item'],
				'edit_item'          => $post_type['edit_item'],
				'new_item'           => $post_type['new_item'],
				'all_items'          => $post_type['name'],
				'view_item'          => $post_type['view_item'],
				'search_items'       => $post_type['search_items'],
				'not_found'          => $post_type['not_found'],
				'not_found_in_trash' => $post_type['not_found_in_trash'], 
				'parent_item_colon'  => '',
				'menu_name'          => $post_type['name']
			);
			
			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true, 
				'show_in_menu'       => true, 
				'query_var'          => true,
				'rewrite'            => array( 'slug' => $slug ),
				'capability_type'    => 'post',
				'has_archive'        => true, 
				'hierarchical'       => true,
				'menu_position'      => isset($post_type['menu_position']) ? $post_type['menu_position'] : false,
				'menu_icon'          => $post_type['menu_icon'],
				'supports'           => array( 'title', 'editor', 'thumbnail' )
			); 
			
			register_post_type($slug, $args);
		
			if(isset($post_type['remove_support'])){
				foreach($post_type['remove_support'] as $remove_support){
					remove_post_type_support( $slug, $remove_support );
				}
				
			}
			
			if(isset($post_type['cat_slug'])){
				$labels = array(   
					'name' => $post_type['cat_menu_name'], 
					'singular_name' => $post_type['cat_slug'], 
					'menu_name' => $post_type['cat_menu_name'],   
				);  
				
				register_taxonomy(   
					$post_type['cat_slug'],   
					array($slug),   
					array(   
						'hierarchical' => true,   
						'labels' => $labels,   
						'show_ui' => true,   
						'query_var' => true,   
						'rewrite' => array( 'slug' => $post_type['cat_slug'] ),   
					)   
				); 
			}
		}
	}
	
	//pagebuilder ajax
	function theme_ajaxurl() { ?>
		<script type="text/javascript">
		//<![CDATA[
		var AJAX_M = "<?php echo plugins_url("/inc_php/ux-pb-theme-ajax.php", __FILE__); ?>";
		//]]>
		</script>
	<?php
	}
	
	//pagebuilder itemid to postid
	function item_postid($itemid){
		$get_posts = get_posts(array(
			'posts_per_page' => -1,
			'name' => $itemid,
			'post_type' => 'modules'
		));
		
		$post_id = $get_posts ? $get_posts[0]->ID : false;
		return $post_id;
	}
	
	//pagebuilder has module
	function has_module($module){
		$return = false;
		if(is_singular('post') || is_page()){
		   global $post;
		   $ux_pb_meta = get_post_meta($post->ID, 'ux_pb_meta', true);
		   
		   if($ux_pb_meta){
			   $moduleid_date = array();
			   foreach($ux_pb_meta as $i => $wrap){
					$moduleid = isset($wrap['moduleid']) ? $wrap['moduleid'] : false;
					if($moduleid){
						$moduleid_date['w_' . $i] = $moduleid;
					}
					
					$items = isset($wrap['items']) ? $wrap['items'] : false;
					if($items){
						foreach($items as $item_num => $item){
							$moduleid = isset($item['moduleid']) ? $item['moduleid'] : false;
							
							if($moduleid){
								$moduleid_date['i_' . $i . '_' . $item_num] = $moduleid;
							}
						}
					}
			   }
			   if(in_array($module, $moduleid_date)){
				   $return = true;
			   }
		   }
		}
		
		return $return;
	}
	
	//pagebuilder meta save
	function meta_save($post_id) {  
		$ux_pb_meta = array('ux_pb_meta', 'ux-pb-switch');
		
		if(!isset($_POST['ux_pb_meta_box_nonce'])){
			$post_nonce = '';
		}else{
			$post_nonce = $_POST['ux_pb_meta_box_nonce'];
		}
		
		if (!wp_verify_nonce($post_nonce, ABSPATH))  
			return $post_id; 
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
			return $post_id;  
		
		if('page' == $_POST['post_type']){  
			if (!current_user_can('edit_page', $post_id))  
				return $post_id;  
			} elseif (!current_user_can('edit_post', $post_id)) {  
				return $post_id;  
		}
		
		foreach($ux_pb_meta as $meta){
			$old = get_post_meta($post_id, $meta, true);  
			$new = @$_POST[$meta];  
		
			if ($new && $new != $old) {  
				update_post_meta($post_id, $meta, $new);  
			} elseif ('' == $new && $old) {  
				delete_post_meta($post_id, $meta, $old);  
			}
		}
		
		return $post_id;
	}
	
	//pagebuilder box bgcolor
	function box_bgcolor(){ 
		$theme_color = ux_theme_color();
		foreach($theme_color as $color){ ?>
			<span data-id="<?php echo esc_attr($color['id']); ?>" data-rgb="<?php echo esc_attr($color['rgb']); ?>"></span>
		<?php	
		}
	}
	
}


function check_has_ux_pb(){
	if(!function_exists('ux_pb_module_interface')){

		define('UX_PAGEBUILDER_PLUGINS', dirname(__FILE__));
		if(!defined('UX_PAGEBUILDER')){
			define('UX_PAGEBUILDER', plugins_url("/", __FILE__));
		}

		$GLOBALS['ux_pagebuilder'] = new UX_PageBuilder();
	}
}
add_action('init', 'check_has_ux_pb', 999);



?>