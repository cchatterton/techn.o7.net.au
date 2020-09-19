<?php


/**
 * Class Alphasys_Content_Management_Public
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Alphasys_Content_Management
 * @author     AlphaSys Pty. Ltd.  <https://alphasys.com.au>
 */
class Alphasys_Content_Management_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/alphasys-content-management-public.css', array(), $this->version, 'all' );

		// Panels CSS
		wp_enqueue_style( 
			'ascm-panels-public-css', 
			plugin_dir_url( __FILE__ ) . 'css/ascm-panels-public.css', 
			array('bootstrap'), 
			'', 
			'all' 
		);

		// Bootsrap CSS
		wp_register_style( 
			'bootstrap', 
			plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', 
			array(), 
			'', 
			'all' 
		);

		// Animate CSS
		wp_register_style( 
			'ascm-animate-css', 
			plugin_dir_url( __FILE__ ) . 'css/animate.css', 
			array(), 
			'', 
			'all' 
		);

		// owlcarousel CSS
		wp_register_style( 
			'ascm-owlcarousel-css', 
			plugin_dir_url( __FILE__ ) . '../assets/owlcarousel2/css/owl.carousel.min.css', 
			array(), 
			'', 
			'all' 
		);

		// owlcarousel theme CSS
		wp_register_style( 
			'ascm-owlcarousel-theme-css', 
			plugin_dir_url( __FILE__ ) . '../assets/owlcarousel2/css/owl.theme.default.min.css', 
			array(), 
			'', 
			'all' 
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/alphasys-content-management-public.js', array( 'jquery' ), $this->version, false );


		// Bootsrap JS
		wp_register_script( 
			'ascm-bootstrap-js', 
			plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', 
			array( 'jquery' ), 
			'', 
			false 
		);

		// owlcarousel JS
		wp_register_script( 
			'ascm-owlcarousel-js', 
			plugin_dir_url( __FILE__ ) . '../assets/owlcarousel2/js/owl.carousel.min.js', 
			array( 'jquery' ), 
			'', 
			false 
		);

	}

}
