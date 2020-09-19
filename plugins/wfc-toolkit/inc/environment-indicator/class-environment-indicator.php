<?php
/**
 * @package WFC_Toolkit\Environment_Indicator
 * 
 * @version 1.0.0
 */

/**
 * Adds indicator in the WordPress admin bar.
 */
class WFC_Enviroment_Indicator {

	/**
	 * The current environment.
	 *
	 * @var string
	 */
	protected $current_environment;

	/**
	 * Development environment value.
	 * 
	 * @var string
	 */
	const DEVELOPMENT = 'development';

	/**
	 * Staging environment value.
	 * 
	 * @var string
	 */
	const STAGING = 'staging';

	/**
	 * Live environment value.
	 * 
	 * @var string
	 */
	const LIVE = 'live';

	/**
	 * Adds all the necessary hooks for adding
	 * the indicator.
	 * 
	 * @param string $env The current environment.
	 */
	public function __construct( $env ) {
		$this->current_environment = $env;

		define( 'WFC_EI_VERSION', '1.0.0' );
		define( 'WFC_EI_CSS_URL', plugin_dir_url( __FILE__ ) . 'assets/css/' );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

		add_action( 'admin_bar_menu', array( $this, 'indicator' ), 32 );
	}

	/**
	 * Enqueue all necessary scripts and styles.
	 */
	public function enqueue() {
		wp_enqueue_style( 'wfct-ei', WFC_EI_CSS_URL . 'environment-indicator.css', array(), WFC_EI_VERSION );
	}

	/**
	 * Adds the indicator to the admin bar.
	 * 
	 * @param WP_Admin_Bar $wp_admin_bar The admin bar object.
	 */
	public function indicator( WP_Admin_Bar $wp_admin_bar ) {

		$environment = strtolower( $this->current_environment );

		if ( $environment != self::DEVELOPMENT && $environment != self::STAGING && $environment != self::LIVE ) {
			return;
		}

		$classes = array( 'wfct-ei' );

		switch ( $environment ) {
			case self::STAGING:
				$classes[] = 'wfct-ei-staging';
				break;

			case self::LIVE:
				$classes[] = 'wfct-ei-live';
				break;

			case self::DEVELOPMENT:
			default:
				$classes[] = 'wfct-ei-development';
				break;
		}

		$wp_admin_bar->add_menu( array(
			'id' => 'wfct-ei',
			'title' => esc_html( $environment ),
			'meta' => array(
				'class' => implode( ' ', $classes )
			)
		) );
	}
}

