<?php

/**
 * Class Alphasys_Content_Management_Admin
 *
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Alphasys_Content_Management
 * @author     AlphaSys Pty. Ltd.  <https://alphasys.com.au>
 */
class Alphasys_Content_Management_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		
		wp_register_style( 
			'ascm-repost-relatedpostlist-editorbutton-css', 
			plugin_dir_url( __FILE__ ) . 'css/ascm-repost-relatedpostlist-editorbutton.css', 
			array(), 
			'', 
			'all' 
		);	

		wp_register_style( 
			'ascm-grid-system-admin-css', 
			plugin_dir_url( __FILE__ ) . 'css/grid-system-admin.css', 
			array(), 
			'', 
			'all' 
		);

		wp_register_style( 
			'ascm-animate-css', 
			plugin_dir_url( __FILE__ ) . 'css/animate.css', 
			array(), 
			'', 
			'all' 
		);

		wp_register_style( 
			'ascm-tagging-css', 
			plugin_dir_url( __FILE__ ) . '../assets/css/tagging.css', 
			array(), 
			'', 
			'all' 
		);

		wp_register_style( 
			'ascm-codemirror-css', 
			plugin_dir_url( __FILE__ ) . '../assets/codemirror-5.45.0/lib/codemirror.css', 
			array(), 
			'', 
			'all' 
		);

		wp_register_style( 
			'ascm-codemirror-darcula-theme-css', 
			plugin_dir_url( __FILE__ ) . '../assets/codemirror-5.45.0/theme/darcula.css', 
			array(), 
			'', 
			'all' 
		);


		wp_register_style( 
			'ascm-admin-css', 
			plugin_dir_url( __FILE__ ) . 'css/alphasys-content-management-admin.css', 
			array(), 
			$this->version, 
			'all' 
		);

		wp_register_style( 
			'ascm-panels-admin-css', 
			plugin_dir_url( __FILE__ ) . 'css/ascm-panels-admin.css', 
			array(), 
			$this->version, 
			'all' 
		);

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {


		wp_register_script( 
			'ascm-repost-relatedpostlist-editorbutton-js', 
			plugin_dir_url( __FILE__ ) . 'js/ascm-repost-relatedpostlist-editorbutton.js', 
			array( 'jquery' ), 
			'',
			true
		);
		
		wp_enqueue_script( 
			'ascm-tagging-min-js', 
			plugin_dir_url( __FILE__ ) . '../assets/js/tagging.min.js', 
			array( 'jquery' ), 
			'',
			true
		);

		wp_enqueue_script( 
			'ascm-codemirror-js', 
			plugin_dir_url( __FILE__ ) . '../assets/codemirror-5.45.0/lib/codemirror.js', 
			array( 'jquery' ), 
			'',
			true
		);

		wp_enqueue_script( 
			'ascm-codemirror-javascript-mode-js', 
			plugin_dir_url( __FILE__ ) . '../assets/codemirror-5.45.0/mode/javascript/javascript.js', 
			array( 'jquery' ), 
			'',
			true
		);

		wp_enqueue_script( 
			'ascm-codemirror-css-mode-js', 
			plugin_dir_url( __FILE__ ) . '../assets/codemirror-5.45.0/mode/css/css.js', 
			array( 'jquery' ), 
			'',
			true
		);

		wp_enqueue_script(
			'ascm-codemirror-htmlmixed-mode-js',
			plugin_dir_url( __FILE__ ) . '../assets/codemirror-5.45.0/mode/htmlmixed/htmlmixed.js',
			array( 'jquery' ),
			'',
			true
		);

		wp_enqueue_script(
			'ascm-codemirror-xml-mode-js',
			plugin_dir_url( __FILE__ ) . '../assets/codemirror-5.45.0/mode/xml/xml.js',
			array( 'jquery' ),
			'',
			true
		);

		// Register sortable js script
		wp_register_script( 
			'ascm-sortable-js', 
			plugin_dir_url( __FILE__ ) . '../assets/sortable/js/Sortable.min.js', 
			array( 'jquery' ), 
			'',
			true
		);

		wp_register_script( 
			'ascm-panels-admin-js', 
			plugin_dir_url( __FILE__ ) . 'js/ascm-panels-admin.js', 
			array(), 
			$this->version,
			true
		);

		wp_register_script( 
			'ascm-admin-js', 
			plugin_dir_url( __FILE__ ) . 'js/alphasys-content-management-admin.js', 
			array( 'jquery' ), 
			$this->version,
			true
		);
		
		
	}
	
	/**
	 * Registers the main menu and submenu for ASCM.
	 *
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @return void
     *
     * @LastUpdated   February 13, 2019
	 */
	public function wpdocs_register_my_custom_menu_page() {
	    add_menu_page(
	        __( 'ASCM', 'ascm' ),
	        __( 'ASCM', 'ascm' ),
	        'manage_options',
	        'ascm-menu',
	        array( $this, 'ascm_main_admin_page' ),
	        plugin_dir_url( __FILE__ ).'../images/ascm.png',	
	        
	    );
	}
	
	/**
	 * This is the callback function for ASCM main menu page
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @return void
     *
     * @LastUpdated   February 13, 2019
	 */
	public function ascm_main_admin_page(){

		// enqueue wordpress CSS ===============
		wp_enqueue_style( 'ascm-admin-css' );

		wp_enqueue_style( 'ascm-panels-admin-css' );

		wp_enqueue_style(
			'ascm-best-before-admin-css',
			plugin_dir_url( __FILE__ ) . 'css/ascm-best-before-admin.css',
			array(),
			$this->version,
			'all'
		);

		wp_enqueue_style(
            'fontawesome',
            'https://use.fontawesome.com/releases/v5.8.1/css/all.css',
            array(),
            $this->version,
            'all'
        );

	
		wp_enqueue_style('ascm-animate-css');
		wp_enqueue_style('ascm-grid-system-admin-css');

		

		// enqueue wordpress JS ===============
		wp_enqueue_script( 'ascm-admin-js' );


		// enqueue panel admin JS ===============
		wp_enqueue_script( 'ascm-panels-admin-js' );

		// Fetch all id of pages an store to hidden field

		$allavailablepages_arr = array();
		$allavailablepages_str = '';
		if (class_exists('ASCM_Panels_Helper')) {
			$allavailablepages = ASCM_Panels_Helper::get_allavailablepages();
			if (!empty($allavailablepages) && is_array($allavailablepages)){
				foreach ($allavailablepages as $key => $value) {
					array_push($allavailablepages_arr , $key);
				}
			}
        }


		if(has_action('genesis_init') == false){
            $genesis_detected = false;
        }else{
			$genesis_detected = true;
        }

		wp_localize_script( 
			'ascm-panels-admin-js', 
			'ascm_modsettings_panels_param', 
			array(
				'url'     	 => admin_url('admin-ajax.php'),
				'plugin_url' => trailingslashit( plugin_dir_url( __FILE__ ) ),
        		'nonce'      => wp_create_nonce('ajax-nonce'),
        		'allavailablepages_arr' => $allavailablepages_arr,
                'genesis_detected' => $genesis_detected
			)
		);
		

		// enqueue repost admin JS ===============
		wp_enqueue_script( 
			'ascm-repost-admin-js', 
			plugin_dir_url( __FILE__ ) . 'js/ascm-repost-admin.js', 
			array( 'jquery' ), 
			$this->version,
			true
		);
		wp_localize_script( 
			'ascm-repost-admin-js', 
			'ascm_modsettings_repost_param', 
			array(
				'url'     	 => admin_url('admin-ajax.php'),
				'plugin_url' => trailingslashit( plugin_dir_url( __FILE__ ) ),
        		'nonce'      => wp_create_nonce('ajax-nonce'),
			)
		);

		// enqueue best before admin JS ===============
		wp_enqueue_script(
			'ascm-best-before-admin-js',
			plugin_dir_url( __FILE__ ) . 'js/ascm-best-before-admin.js',
			array( 'jquery' ),
			$this->version,
			true
		);
		wp_localize_script(
			'ascm-best-before-admin-js',
			'ascm_modsettings_bestbefore_param',
			array(
				'url'     	 => admin_url('admin-ajax.php'),
				'plugin_url' => trailingslashit( plugin_dir_url( __FILE__ ) ),
				'nonce'      => wp_create_nonce('ajax-nonce'),
			)
		);


		// enqueue color picker ==============
		wp_enqueue_script( 'wp-color-picker' ); 

		// enqueue sortable ==============
		wp_enqueue_script('ascm-sortable-js'); 


		// enqueue Wordpress utility ==============
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_media();

		require_once('partials/alphasys-content-management-admin-display.php');
	}
	
	/**
	 * This is the callback function for ASCM Repost page
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @return void
     *
     * @LastUpdated   February 13, 2019
	 */
	public function ascm_repost_page(){
		$post_type = 'ascm_repost';
		$url = admin_url().'/edit.php?post_type='.$post_type;
		?><script>location.href='<?php echo $url;?>';</script><?php
	}
	
	/**
	 * This is the callback function for ASCM Panels page
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @LastUpdated  February 13, 2019
	 */
	public function ascm_panels_page(){
		$post_type = 'ascm_panels';
		$url = admin_url().'/edit.php?post_type='.$post_type;
		?><script>location.href='<?php echo $url;?>';</script><?php
	}
	
	/**
	 * Callback  function for saving general options AJAX process.
	 *
	 * @author   Junjie Canonio <junjie@alphasys.com.au>
	 * @return 	 void
	 * @since    1.0.0
     *
     * @LastUpdated   April 28, 2020
	 */
	public function ascm_save_generaloptions() {
		if( isset( $_POST['action'] ) && $_POST['action'] == 'ascm_generaloptions' ) {
			/**
			* grab and save creditials
			*/
			$ascm_enable_bestbefore = isset($_POST['ascm_enable_bestbefore']) ? $_POST['ascm_enable_bestbefore'] : 'off'; 
			$ascm_enable_repost = isset($_POST['ascm_enable_repost']) ? $_POST['ascm_enable_repost'] : 'off';
			$ascm_enable_panels = isset($_POST['ascm_enable_panels']) ? $_POST['ascm_enable_panels'] : 'off';
			$ascm_enable_magic_card = isset($_POST['ascm_enable_magic_card']) ? $_POST['ascm_enable_magic_card'] : 'off';

			update_option( 'ascm_generaloptions', array(
				'ascm_enable_bestbefore' => $ascm_enable_bestbefore,
				'ascm_enable_repost' => $ascm_enable_repost,
				'ascm_enable_panels' => $ascm_enable_panels,
				'ascm_enable_magic_card' => $ascm_enable_magic_card,
			) );

			header('Location: ' . get_site_url() . '/wp-admin/admin.php?page=ascm-menu');
		}
	}

	/**
	 * Callback function for updating ASCM Best Before run expire post.
	 *
	 * @author   Junjie Canonio <junjie@alphasys.com.au>
	 * @return void
	 * @since    1.0.0
	 *
	 * @LastUpdated   October 26, 2019
	 */
	public function ascm_bestbefore_run_expire_post_batch() {
		if( isset( $_POST['action'] ) && $_POST['action'] == 'run_expire_post_batch' ) {

			if( isset( $_POST['action_type'] ) && $_POST['action_type'] == 'excute' ) {
				ASCM_BestBeforeExpirePost::ascm_bestbefore_expirepost_batch();

				wp_send_json(array(
					'status'   => 'success',
					'_POST' => $_POST,
				));
			}

			if( isset( $_POST['action_type'] ) && $_POST['action_type'] == 'fetch' ) {
				$ascm_bestbefore_batch = get_option('ascm-best-before-postexpire-batch');

				wp_send_json(array(
					'status' => 'success',
					'bestbefore_batch' => $ascm_bestbefore_batch,
					'_POST' => $_POST,
				));

			}
		}

	}

	/**
	 * Callback function for updating ASCM Repost Module Settings.
	 *
	 * @author   Junjie Canonio <junjie@alphasys.com.au>
	 * @return void
	 * @since    1.0.0
     *
     * @LastUpdated   March 26, 2019
	 */
	public function ascm_mod_settings_repost() {
		if( isset( $_POST['action'] ) && $_POST['action'] == 'save_modsettings_repost' ) {
			/*
			* grab and save module settings
			*/
			$ascm_enable_bestbefore = 
			isset($_POST['modsettings']) ? $_POST['modsettings'] : array(); 
			

			update_option( 'ascm-mod-settings-repost', $ascm_enable_bestbefore );

			wp_send_json(array(
                'status'   => 'success',
                '_POST' => $_POST,
            ));
		}
	}
	
	/**
	 * Callback function for updating ASCM Panels Module Settings.
	 *
	 * @author   Junjie Canonio <junjie@alphasys.com.au>
	 * @return void
	 * @since    1.0.0
     *
     * @LastUpdated   May 8, 2019
	 */
	public function ascm_mod_settings_panels() {
		if( isset( $_POST['action'] ) && $_POST['action'] == 'save_modsettings_panels' ) {
			/*
			* grab and save module settings
			*/
			$page_id = isset($_POST['page_id']) ? $_POST['page_id'] : '';

			if (!empty($page_id)) {

			    // Standard Elements
				$afterheader_panels = isset($_POST['afterheader_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['afterheader_panels']) : array();
				$beforecontent_panels = isset($_POST['beforecontent_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['beforecontent_panels']) : array();
				$aftercontent_panels = isset($_POST['aftercontent_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['aftercontent_panels']) : array();
				$beforefooter_panels = isset($_POST['beforefooter_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['beforefooter_panels']) : array();
		
				update_post_meta(
		            $page_id,
		            'ascm-panels-afterheader',
		           	$afterheader_panels
		        );

		        update_post_meta(
		            $page_id,
		            'ascm-panels-beforecontent',
		           	$beforecontent_panels
		        );

		        update_post_meta(
		            $page_id,
		            'ascm-panels-aftercontent',
		           	$aftercontent_panels
		        );

		        update_post_meta(
		            $page_id,
		            'ascm-panels-beforefooter',
		           	$beforefooter_panels
		        );

		        // Genesis Elements
				$genesisbeforeheader_panels = isset($_POST['genesisbeforeheader_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['genesisbeforeheader_panels']) : array();
				$genesisafterheader_panels = isset($_POST['genesisafterheader_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['genesisafterheader_panels']) : array();
				$genesisbeforeentry_panels = isset($_POST['genesisbeforeentry_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['genesisbeforeentry_panels']) : array();
				$genesisafterentry_panels = isset($_POST['genesisafterentry_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['genesisafterentry_panels']) : array();
				$genesisbeforefooter_panels = isset($_POST['genesisbeforefooter_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['genesisbeforefooter_panels']) : array();
				$genesisafterfooter_panels = isset($_POST['genesisafterfooter_panels']) ? self::ascm_sanizitize_arrayofstrings($_POST['genesisafterfooter_panels']) : array();

				// Genesis Header
				update_post_meta(
					$page_id,
					'ascm-panels-genesisbeforeheader',
					$genesisbeforeheader_panels
				);
				update_post_meta(
					$page_id,
					'ascm-panels-genesisafterheader',
					$genesisafterheader_panels
				);

				// Genesis Content
				update_post_meta(
					$page_id,
					'ascm-panels-genesisbeforeentry',
					$genesisbeforeentry_panels
				);
				update_post_meta(
					$page_id,
					'ascm-panels-genesisafterentry',
					$genesisafterentry_panels
				);

				// Genesis Footer
				update_post_meta(
					$page_id,
					'ascm-panels-genesisbeforefooter',
					$genesisbeforefooter_panels
				);
				update_post_meta(
					$page_id,
					'ascm-panels-genesisafterfooter',
					$genesisafterfooter_panels
				);

			}
			

			// update_option( 'ascm-mod-settings-repost', $ascm_enable_bestbefore );

			wp_send_json(array(
                'status'   => 'success',
                '_POST' => $_POST,
            ));
		}
	}
	
	/**
	 * Sanitizes ASCM Array of String values.
	 *
	 * @author   Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param
	 *
	 * @return array
	 * @since    1.0.0
     *
     * @LastUpdated   May 8, 2019
	 */
	public static function ascm_sanizitize_arrayofstrings($array) {
	    $sanitized_array = array();
	    if (is_array($array)){
	        foreach ($array as $key => $value){
		        $sanitized_array[$key] = filter_var ( $value, FILTER_SANITIZE_STRING);
            }
        }

	    if (!empty($sanitized_array)){
		    return $sanitized_array;
        }else{
		    return $array;
        }
	}


}
