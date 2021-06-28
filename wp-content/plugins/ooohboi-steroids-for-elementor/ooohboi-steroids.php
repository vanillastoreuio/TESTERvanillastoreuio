<?php
/**
 * Plugin Name: OoohBoi Steroids for Elementor
 * Description: An awesome set of tools, options and settings that expand Elementor defaults. Instead of creating new Elementor Widgets, these act like an upgrade of existing options or the self-standing panels.
 * Version:     1.7.7
 * Author:      OoohBoi
 * Author URI:  https://www.youtube.com/c/OoohBoi
 * Text Domain: ooohboi-steroids
 * Domain Path: /lang
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main OoohBoi Steroids Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class OoohBoi_Steroids { 

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.7.7';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.5.11';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	*/
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var OoohBoi_Steroids The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Library globals
	 * 
	 * @since 1.7.3
	 *
	 * @access private
	 * @static
	 *
	 * @var OoohBoi_Steroids The single instance of the class.
	 */
	private static $sfe_lib_locomotive = 0;
	public static $sfe_lib_locomotive_multiplier = 1;
	public static $sfe_lib_locomotive_tablet = 0;
	public static $sfe_lib_locomotive_mobile = 0; 
	public static $sfe_lib_allow_refresh = 0;
	private static $sfe_lib_scroll_trigger = 0;
	private static $sfe_lib_scroll_to = 0;
	private static $sfe_lib_motion_path = 0;
	private static $sfe_lib_gsap = 0;
	private static $sfe_remove_locomotive_section_attribute = 0;
	private static $sfe_lib_barba = 0;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return OoohBoi_Steroids An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	
	public function __construct() {	
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'ooohboi-steroids', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by 'plugins_loaded' action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version			
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// admin styles
		add_action( 'admin_enqueue_scripts', function() {
			wp_enqueue_style(
				'ooohboi-steroids-admin', 
				plugins_url( 'assets/css/admin.css', __FILE__ ),
				[],
				self::VERSION . '17052021'
			);
		} );

		// load common stuff functions
		require plugin_dir_path( __FILE__ ) . 'inc/exopite-simple-options/exopite-simple-options-framework-class.php';
		require plugin_dir_path( __FILE__ ) . 'inc/common-functions.php';

		// init EXOPIT ---------------------------------------------------------->
		$ob_settings_options = get_exopite_sof_option( 'steroids_for_elementor' );

		if( $ob_settings_options ) {
			// ... Locomotive Scroll
			if( isset( $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_scroll' ] ) && $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_scroll' ] && 'yes' === $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_scroll' ] ) self::$sfe_lib_locomotive = 1;
			// multiplier
			if( isset( $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_multiplier' ] ) && $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_multiplier' ] ) {
				$the_multiplier = $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_multiplier' ];
				if( ( $the_multiplier >= -10 ) && ( $the_multiplier <= 10 ) ) self::$sfe_lib_locomotive_multiplier = $the_multiplier;
			}
			// devices
			if( isset( $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_devices' ] ) && $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_devices' ] && in_array( 'allow-tablet', $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_devices' ] ) ) self::$sfe_lib_locomotive_tablet = 1;
			if( isset( $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_devices' ] ) && $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_devices' ] && in_array( 'allow-mobile', $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_devices' ] ) ) self::$sfe_lib_locomotive_mobile = 1;
			// allow refresh on resize
			if( isset( $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_allow_refresh' ] ) && $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_allow_refresh' ] && 'yes' === $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_allow_refresh' ] ) self::$sfe_lib_allow_refresh = 1;
			// remove section attributes
			if( isset( $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_remove_section_attribute' ] ) && $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_remove_section_attribute' ] && 'yes' === $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_remove_section_attribute' ] ) self::$sfe_remove_locomotive_section_attribute = 1;
			// ... GSAP 
			if( isset( $ob_settings_options[ 'ob_use_gsap' ] ) && $ob_settings_options[ 'ob_use_gsap' ] && 'yes' === $ob_settings_options[ 'ob_use_gsap' ] ) self::$sfe_lib_gsap = 1;
			// ... Scroll Trigger 
			if( isset( $ob_settings_options[ 'ob_use_scroll_trigger' ] ) && $ob_settings_options[ 'ob_use_scroll_trigger' ] && 'yes' === $ob_settings_options[ 'ob_use_scroll_trigger' ] ) self::$sfe_lib_scroll_trigger = 1;
			// ... Scroll To 
			if( isset( $ob_settings_options[ 'ob_use_scroll_to' ] ) && $ob_settings_options[ 'ob_use_scroll_to' ] && 'yes' === $ob_settings_options[ 'ob_use_scroll_to' ] ) self::$sfe_lib_scroll_to = 1;
			// ... Motion Path
			if( isset( $ob_settings_options[ 'ob_use_motion_path' ] ) && $ob_settings_options[ 'ob_use_motion_path' ] && 'yes' === $ob_settings_options[ 'ob_use_motion_path' ] ) self::$sfe_lib_motion_path = 1;
			// ... Barba
			if( isset( $ob_settings_options[ 'ob_use_barba' ] ) && $ob_settings_options[ 'ob_use_barba' ] && 'yes' === $ob_settings_options[ 'ob_use_barba' ] ) self::$sfe_lib_barba = 1;
		}

		// Editor Styles
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'ooohboi_register_styles_editor' ] );

		// Register/Enqueue Scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'ooohboi_register_scripts_front' ] );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'ooohboi_register_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', function() { 

			// locomotive scroll
			if( 1 === self::$sfe_lib_locomotive ) {
				wp_enqueue_style( 'locomotive-scroll-css' ); 
				wp_enqueue_script( 'locomotive-scroll-js' ); 
				wp_enqueue_script( 'locomotive-scroll-ctrl' );
				// things to pass to the js
				$device_settings = array( 
					'scroll_multiplier' => self::$sfe_lib_locomotive_multiplier, 
					'allow_tablet' => self::$sfe_lib_locomotive_tablet, 
					'allow_mobile' => self::$sfe_lib_locomotive_mobile, 
					'allow_refresh' => self::$sfe_lib_allow_refresh, 
					'remove_section_attribute' => self::$sfe_remove_locomotive_section_attribute, 
				); 
				wp_localize_script( 'locomotive-scroll-ctrl', 'device_settings', $device_settings );
			}
			// ssfe_lib_gsap 
			if( 1 === self::$sfe_lib_gsap ) {
				wp_enqueue_script( 'gsap-js' );  
			}
			// scroll trigger 
			if( 1 === self::$sfe_lib_scroll_trigger ) {
				wp_enqueue_script( 'scroll-trigger-js' ); 
			}
			// scroll to 
			if( 1 === self::$sfe_lib_scroll_to ) {
				wp_enqueue_script( 'scroll-to-js' ); 
			}
			// motion path
			if( 1 === self::$sfe_lib_motion_path ) {
				wp_enqueue_script( 'motion-path-js' ); 
			}
			// barba
			if( 1 === self::$sfe_lib_barba ) {
				wp_enqueue_script( 'barba-js' ); 
			}
			// plugin stuff
			wp_enqueue_style( 'ooohboi-steroids-styles' ); 
			wp_enqueue_script( 'ooohboi-steroids' ); 
		} );

		// editor preview styles
		add_action( 'elementor/preview/enqueue_styles', function() {
			wp_enqueue_style(
				'ooohboi-steroids-preview',
				plugins_url( 'assets/css/preview.css', __FILE__ ),
				[ 'editor-preview' ],
				self::VERSION . '28042021'
			);
		} ); 

		// init extensions
		self::ooohboi_init_extensions( $ob_settings_options );

	}

	/*
		* Init Extensions
		*
		* @since 1.4.8				
		*
		* @access public
	*/
	public function ooohboi_init_extensions( $ob_settings_options ) {

		// Include extension classes
		self::ooohboi_take_steroids();

		if( ! $ob_settings_options ) {
			OoohBoi_Harakiri::init(); // OoohBoi Harakiri
			OoohBoi_Overlay_Underlay::init(); // OoohBoi Overlay Underlay
			OoohBoi_Overlaiz::init(); // OoohBoi Overlaiz
			OoohBoi_Paginini::init(); // OoohBoi Paginini
			OoohBoi_Breaking_Bad::init(); // OoohBoi Breaking Bad
			OoohBoi_Glider::init(); // OoohBoi Glider Slider
			OoohBoi_PhotoGiraffe::init(); // OoohBoi PhotoGiraffe
			OoohBoi_Teleporter::init(); // OoohBoi Teleporter
			OoohBoi_SearchCop::init(); // OoohBoi Search Cop
			OoohBoi_Videomasq::init(); // OoohBoi Videomasq
			OoohBoi_Butter_Button::init(); // OoohBoi Butter Button
			OoohBoi_Perspektive::init(); // OoohBoi Perspektive 
			OoohBoi_Shadough::init(); // OoohBoi Shadough 
			OoohBoi_PhotoMorph::init(); // OoohBoi PhotoMorph
			OoohBoi_Commentz::init(); // OoohBoi Commentz 
			OoohBoi_SpaceRat::init(); // OoohBoi SpaceRat 
			OoohBoi_Imbox::init(); // OoohBoi Imbox 
			OoohBoi_Icobox::init(); // OoohBoi Icobox 
			OoohBoi_Hover_Animator::init(); // OoohBoi Hover Animator 
			OoohBoi_Kontrolz::init(); // OoohBoi Kontrolz 
			OoohBoi_Widget_Stalker::init(); // OoohBoi Widget Stalker 
			OoohBoi_Pseudo::init(); // OoohBoi Pseudo 
		} else {
			if( $ob_settings_options[ 'ob_use_harakiri' ] && 'yes' === $ob_settings_options[ 'ob_use_harakiri' ] ) OoohBoi_Harakiri::init(); // OoohBoi Harakiri
			if( $ob_settings_options[ 'ob_use_poopart' ] && 'yes' === $ob_settings_options[ 'ob_use_poopart' ] ) OoohBoi_Overlay_Underlay::init(); // OoohBoi Overlay Underlay
			if( $ob_settings_options[ 'ob_use_overlaiz' ] && 'yes' === $ob_settings_options[ 'ob_use_overlaiz' ] ) OoohBoi_Overlaiz::init(); // OoohBoi Overlaiz
			if( $ob_settings_options[ 'ob_use_paginini' ] && 'yes' === $ob_settings_options[ 'ob_use_paginini' ] ) OoohBoi_Paginini::init(); // OoohBoi Paginini
			if( $ob_settings_options[ 'ob_use_breakingbad' ] && 'yes' === $ob_settings_options[ 'ob_use_breakingbad' ] ) OoohBoi_Breaking_Bad::init(); // OoohBoi Breaking Bad
			if( $ob_settings_options[ 'ob_use_glider' ] && 'yes' === $ob_settings_options[ 'ob_use_glider' ] ) OoohBoi_Glider::init(); // OoohBoi Glider Slider
			if( $ob_settings_options[ 'ob_use_photogiraffe' ] && 'yes' === $ob_settings_options[ 'ob_use_photogiraffe' ] ) OoohBoi_PhotoGiraffe::init(); // OoohBoi PhotoGiraffe 
			if( $ob_settings_options[ 'ob_use_teleporter' ] && 'yes' === $ob_settings_options[ 'ob_use_teleporter' ] ) OoohBoi_Teleporter::init(); // OoohBoi Teleporter
			if( $ob_settings_options[ 'ob_use_searchcop' ] && 'yes' === $ob_settings_options[ 'ob_use_searchcop' ] ) OoohBoi_SearchCop::init(); // OoohBoi Search Cop
			if( $ob_settings_options[ 'ob_use_videomasq' ] && 'yes' === $ob_settings_options[ 'ob_use_videomasq' ] ) OoohBoi_Videomasq::init(); // OoohBoi Videomasq
			if( $ob_settings_options[ 'ob_use_butterbutton' ] && 'yes' === $ob_settings_options[ 'ob_use_butterbutton' ] ) OoohBoi_Butter_Button::init(); // OoohBoi Butter Button 
			if( $ob_settings_options[ 'ob_use_perspektive' ] && 'yes' === $ob_settings_options[ 'ob_use_perspektive' ] ) OoohBoi_Perspektive::init(); // OoohBoi Perspektive 
			if( $ob_settings_options[ 'ob_use_shadough' ] && 'yes' === $ob_settings_options[ 'ob_use_shadough' ] ) OoohBoi_Shadough::init(); // OoohBoi Shadough 
			if( $ob_settings_options[ 'ob_use_photomorph' ] && 'yes' === $ob_settings_options[ 'ob_use_photomorph' ] ) OoohBoi_PhotoMorph::init(); // OoohBoi PhotoMorph
			if( $ob_settings_options[ 'ob_use_commentz' ] && 'yes' === $ob_settings_options[ 'ob_use_commentz' ] ) OoohBoi_Commentz::init(); // OoohBoi Commentz 
			if( $ob_settings_options[ 'ob_use_spacerat' ] && 'yes' === $ob_settings_options[ 'ob_use_spacerat' ] ) OoohBoi_SpaceRat::init(); // OoohBoi SpaceRat 
			if( $ob_settings_options[ 'ob_use_imbox' ] && 'yes' === $ob_settings_options[ 'ob_use_imbox' ] ) OoohBoi_Imbox::init(); // OoohBoi Imbox 
			if( $ob_settings_options[ 'ob_use_icobox' ] && 'yes' === $ob_settings_options[ 'ob_use_icobox' ] ) OoohBoi_Icobox::init(); // OoohBoi Icobox 
			if( $ob_settings_options[ 'ob_use_hoveranimator' ] && 'yes' === $ob_settings_options[ 'ob_use_hoveranimator' ] ) OoohBoi_Hover_Animator::init(); // OoohBoi Hover Animator 
			if( $ob_settings_options[ 'ob_use_kontrolz' ] && 'yes' === $ob_settings_options[ 'ob_use_kontrolz' ] ) OoohBoi_Kontrolz::init(); // OoohBoi Kontrolz 
			if( $ob_settings_options[ 'ob_use_widgetstalker' ] && 'yes' === $ob_settings_options[ 'ob_use_widgetstalker' ] ) OoohBoi_Widget_Stalker::init(); // OoohBoi Widget Stalker 
			if( $ob_settings_options[ 'ob_use_pseudo' ] && 'yes' === $ob_settings_options[ 'ob_use_pseudo' ] ) OoohBoi_Pseudo::init(); // OoohBoi Pseudo 

			// include libraries that involve editor controls; Locomotive Scroll...
			if( $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_scroll' ] && 'yes' === $ob_settings_options[ 'fieldset_locomotive' ][ 'ob_use_locomotive_scroll' ] ) new OoohBoi_Locomotion();
		}
		
	}
	/*
		* Init styles for Elementor Editor
		*
		* Include css files and register them
		*
		* @since 1.0.0				
		*
		* @access public
	*/
	public function ooohboi_register_styles_editor() {
		
		wp_enqueue_style( 'ooohboi-steroids-styles-editor', plugins_url( 'assets/css/editor.css', __FILE__ ), [ 'elementor-editor' ], self::VERSION . '28042021' );

	}

	/*
		* Init styles
		*
		* Include css files and register them
		*
		* @since 1.0.0				
		*
		* @access public
	*/
	public function ooohboi_register_styles() {

		// locomotive scroll
		if( 1 === self::$sfe_lib_locomotive ) { 
			wp_register_style( 'locomotive-scroll-css', plugins_url( 'lib/locomotive_scroll/locomotive-scroll.min.css', __FILE__ ), [ 'ooohboi-steroids-styles' ], self::VERSION );
		}
		// -----------------------------

		wp_register_style( 'ooohboi-steroids-styles', plugins_url( 'assets/css/main.css', __FILE__ ), NULL, self::VERSION . '03052021' );

	}

	/*
		* Init Scripts
		*
		* Include js files and register them
		*
		* @since 1.0.0				
		*
		* @access public
	*/
	public function ooohboi_register_scripts_front() {

		$ele_is_preview = \Elementor\Plugin::$instance->preview->is_preview_mode(); 
		
		wp_register_script( 'ooohboi-steroids', plugins_url( 'assets/js/ooohboi-steroids-min.js', __FILE__ ), [ 'jquery' ], self::VERSION . '08062021a', true );

		// locomotive scroll
		if( 1 === self::$sfe_lib_locomotive ) {
			wp_register_script( 'locomotive-scroll-js', plugins_url( 'lib/locomotive_scroll/locomotive-scroll.min.js', __FILE__ ), [], self::VERSION . '28042021', true ); 
			wp_register_script( 'locomotive-scroll-ctrl', plugins_url( 'assets/js/ooohboi-libs-locomotion.js', __FILE__ ), [ 'locomotive-scroll-js' ], self::VERSION . '30042021', true ); 
		}
		// gsap
		if( 1 === self::$sfe_lib_gsap && ! $ele_is_preview ) {
			wp_register_script( 'gsap-js', plugins_url( 'lib/gsap/gsap.min.js', __FILE__ ), [], self::VERSION, true ); 
		}
		// scroll trigger
		if( 1 === self::$sfe_lib_scroll_trigger && ! $ele_is_preview ) {
			wp_register_script( 'scroll-trigger-js', plugins_url( 'lib/scrolltrigger/ScrollTrigger.min.js', __FILE__ ), [], self::VERSION, true ); 
		}
		// scroll to
		if( 1 === self::$sfe_lib_scroll_to && ! $ele_is_preview ) {
			wp_register_script( 'scroll-to-js', plugins_url( 'lib/scroll_to/ScrollToPlugin.min', __FILE__ ), [], self::VERSION, true ); 
		}
		// scroll motion path
		if( 1 === self::$sfe_lib_motion_path && ! $ele_is_preview ) {
			wp_register_script( 'motion-path-js', plugins_url( 'lib/motion_path/MotionPathPlugin.min.js', __FILE__ ), [], self::VERSION, true ); 
		}
		// barba
		if( 1 === self::$sfe_lib_barba && ! $ele_is_preview ) {
			wp_register_script( 'barba-js', plugins_url( 'lib/barba/barba.min.js', __FILE__ ), [], self::VERSION, true ); 
		}
		// -----------------------------

	}

	/**
	 *
	 * Include extensions
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public static function ooohboi_take_steroids() {
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-overlay-underlay.php'; // OoohBoi Overlay Underlay
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-overlaiz.php'; // OoohBoi Overlaiz
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-harakiri.php'; // OoohBoi Harakiri
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-paginini.php'; // OoohBoi Paginini
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-breaking-bad.php'; // OoohBoi Breaking Bad
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-glider.php'; // OoohBoi Glider Slider
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-photogiraffe.php'; // OoohBoi PhotoGiraffe
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-teleporter.php'; // OoohBoi Teleporter
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-searchcop.php'; // OoohBoi Search Cop
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-videomasq.php'; // OoohBoi Video Masq
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-butter-button.php'; // OoohBoi Butter Button 
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-perspektive.php'; // OoohBoi Perspektive 
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-shadough.php'; // OoohBoi Shadough
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-photomorph.php'; // OoohBoi PhotoMorph
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-commentz.php'; // OoohBoi Commentz
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-spacerat.php'; // OoohBoi SpaceRat
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-imbox.php'; // OoohBoi Imbox 
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-icobox.php'; // OoohBoi Icobox
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-hover-animator.php'; // OoohBoi Hover Animator
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-kontrolz.php'; // OoohBoi Kontrolz
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-widget-stalker.php'; // OoohBoi Widget Stalker 
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-pseudo.php'; // OoohBoi Pseudo
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-locomotion.php'; // OoohBoi Locomotion
	}

}

OoohBoi_Steroids::instance();