<?php

/*
Plugin Name: BM Shortcode
Plugin URI: http://www.uiueux.com/
Description: BM Shortcode
Author: Bwsm
Version: 1.0
Text Domain: ux
Domain Path: /languages/
Author URI: http://www.uiueux.com
*/

define('UX_THEME_SHORTCODES', untrailingslashit( plugins_url( '', __FILE__ ) ) );


//theme admin head
function ux_theme_admin_head(){ ?>
	<script type="text/javascript">
		var UX_THEME_SHORTCODES = "<?php echo UX_THEME_SHORTCODES; ?>";
	</script>
<?php }
add_action('admin_head', 'ux_theme_admin_head');



//Main class
class UxShortcodes {

    function __construct()
    {
    	require_once( 'theme-shortcodes.php' );
    	define('UX_TINYMCE_URI', untrailingslashit( plugins_url( '', __FILE__ ) ). '/tinymce');
		define('UX_TINYMCE_DIR', untrailingslashit( dirname( __FILE__ ) ).'/tinymce');
		define('UX_SHORTCODE_URI', untrailingslashit( plugins_url( '', __FILE__ ) ). '/');

        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('wp_ajax_fusion_shortcodes_popup', array(&$this, 'popup'));
	}

	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		add_action('wp_enqueue_scripts', array( &$this, 'ux_sc_enqueue_init'), 100);

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;

		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}

	}

	// --------------------------------------------------------------------------

	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array )
	{
		if( is_admin() ) {
			$plugin_array['ux_button'] = UX_TINYMCE_URI . '/plugin.js';
		}

		return $plugin_array;
	}

	// --------------------------------------------------------------------------

	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons )
	{
		array_push( $buttons, 'ux_button' );
		return $buttons;
	}

	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{
		// css
		wp_enqueue_style( 'ux-popup', UX_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		wp_enqueue_style( 'jquery.chosen', UX_TINYMCE_URI . '/css/chosen.css', false, '1.0', 'all' );
		wp_enqueue_style( 'wp-color-picker' );

		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-livequery', UX_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', UX_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', UX_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'jquery.chosen', UX_TINYMCE_URI . '/js/chosen.jquery.min.js', false, '1.0', false );
    	wp_enqueue_script( 'wp-color-picker' );

		wp_enqueue_script( 'ux-popup', UX_TINYMCE_URI . '/js/popup.js', false, '1.0', false );

		// Developer mode
		$dev_mode = current_theme_supports( 'ux_shortcodes_embed' );
		if( $dev_mode ) {
			$dev_mode = 'true';
		} else {
			$dev_mode = 'false';
		}

		wp_localize_script( 'jquery', 'UxShortcodes', array('plugin_folder' =>  UX_THEME_SHORTCODES, 'dev' => $dev_mode) );
	}
	function ux_sc_enqueue_init()
	{
		
		//global $post;
		
		//css
		wp_enqueue_style( 'ux-interface-shortcode-css', UX_SHORTCODE_URI . 'css/bm-shortcode.css', false, '1.0', 'all' );
		
		//js
		//if( has_shortcode( $post->post_content, 'ux_gallery') ) {
			wp_enqueue_script( 'jquery-collageplus', UX_SHORTCODE_URI . 'js/jquery.collageplus.min.js', array( 'jquery' ), '0.3.3', true);
		//}
		wp_enqueue_script( 'ux-shortcode-js', UX_SHORTCODE_URI . 'js/bm-shortcode.js', array( 'jquery' ), '1.0.0', true);

	}


	/**
	 * Popup function which will show shortcode options in thickbox.
	 *
	 * @return void
	 */
	function popup() {

		require_once( UX_TINYMCE_DIR . '/ux-sc.php' );

		die();

	}

}
$ux_shortcodes_obj = new UxShortcodes();
?>