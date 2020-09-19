<?php

/**
 * Class Alphasys_Content_Management
 *
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Alphasys_Content_Management
 * @author     AlphaSys Pty. Ltd.  <https://alphasys.com.au>
 */
class Alphasys_Content_Management {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Alphasys_Content_Management_Loader    $loader
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'alphasys-content-management';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Alphasys_Content_Management_Loader. Orchestrates the hooks of the plugin.
	 * - Alphasys_Content_Management_i18n. Defines internationalization functionality.
	 * - Alphasys_Content_Management_Admin. Defines all hooks for the admin area.
	 * - Alphasys_Content_Management_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-alphasys-content-management-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-alphasys-content-management-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-alphasys-content-management-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-alphasys-content-management-public.php';


		/**
		 * This option is from the general settings of ASCM
		 */
		$ascm_generaloptions = get_option('ascm_generaloptions');

		$ascm_enable_bestbefore = 
		isset($ascm_generaloptions['ascm_enable_bestbefore']) ? 
		$ascm_generaloptions['ascm_enable_bestbefore'] : 'off';
		if ($ascm_enable_bestbefore == 'on') {
			/**
			 * The class responsible for defining ASCM Best Before functionality.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/best-before/class-best-before-expire-post.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/best-before/class-best-before-meta.php';
			new ASCM_BestBefore_Meta();
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/best-before/class-best-dashboard-widget.php';
			new ASCM_BestBefore_DashboardWidget();

			$ascm_best_before_expirepost_schedule = wp_get_schedule( 'ascm_best_before_expirepost' );
			if($ascm_best_before_expirepost_schedule == false){
				wp_schedule_event(time(), 'daily', 'ascm_best_before_expirepost');
			}
			
		}else{
			wp_clear_scheduled_hook( 'ascm_best_before_expirepost' );
		}

		
		$ascm_enable_repost = 
		isset($ascm_generaloptions['ascm_enable_repost']) ? 
		$ascm_generaloptions['ascm_enable_repost'] : 'off';
		if ($ascm_enable_repost == 'on') {
			/**
			 * The class responsible for defining ASCM Repost functionality.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/repost/class-repost-helper.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/repost/class-repost-posttype.php';
			

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 
			'includes/repost/class-repost-relatedpostlist-helper.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 
			'includes/repost/class-repost-relatedpostlist-editorbutton.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 
			'includes/repost/class-repost-relatedpostlist-renderer.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 
			'includes/repost/class-repost-relatedpostlist-shortcode.php';

			//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'block/repost/repost.php';
		}

		$ascm_enable_panels = 
		isset($ascm_generaloptions['ascm_enable_panels']) ? 
		$ascm_generaloptions['ascm_enable_panels'] : 'off';
		if ($ascm_enable_panels == 'on') {
			/**
			 * The class responsible for defining ASCM Panels functionality.
			 */
	
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/panels/class-panels-posttype.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/panels/class-panels-editorbutton.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/panels/class-panels-shortcode.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/panels/class-panels-panelsonpages.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'block/panels/panels.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/panels/class-panels-helper.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/panels/class-panels-renderer.php';

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/panels/class-panels-cpt-queries.php';

		}

		if ( isset( $ascm_generaloptions['ascm_enable_magic_card'] ) && $ascm_generaloptions['ascm_enable_magic_card'] == 'on' ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/card/class-ascm-magic-card-cpt.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/card/functions.php';
		}

		// require_once plugin_dir_path(dirname(__FILE__)) . 'includes/loader/class-loader.php';
		// new ASCM_Loader();


		$this->loader = new Alphasys_Content_Management_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Alphasys_Content_Management_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Alphasys_Content_Management_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Alphasys_Content_Management_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wpdocs_register_my_custom_menu_page' );

		/**
		 * handle authorization and saving credentials action
		 */
		$this->loader->add_action( 'admin_post_nopriv_ascm_generaloptions', $plugin_admin, 'ascm_save_generaloptions' );
		$this->loader->add_action( 'admin_post_ascm_generaloptions', $plugin_admin, 'ascm_save_generaloptions' );

		/**
		 * handle Respost Settings Save
		 */
		$this->loader->add_action( 'wp_ajax_save_modsettings_repost', $plugin_admin, 'ascm_mod_settings_repost' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_modsettings_repost', $plugin_admin, 'ascm_mod_settings_repost' );

		$this->loader->add_action( 'wp_ajax_save_modsettings_repost', $plugin_admin, 'ascm_mod_settings_repost' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_modsettings_repost', $plugin_admin, 'ascm_mod_settings_repost' );

		$this->loader->add_action( 'wp_ajax_run_expire_post_batch', $plugin_admin, 'ascm_bestbefore_run_expire_post_batch' );
		$this->loader->add_action( 'wp_ajax_nopriv_run_expire_post_batch', $plugin_admin, 'ascm_bestbefore_run_expire_post_batch' );

		$this->loader->add_action( 'wp_ajax_save_modsettings_panels', $plugin_admin, 'ascm_mod_settings_panels' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_modsettings_panels', $plugin_admin, 'ascm_mod_settings_panels' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Alphasys_Content_Management_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Alphasys_Content_Management_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
