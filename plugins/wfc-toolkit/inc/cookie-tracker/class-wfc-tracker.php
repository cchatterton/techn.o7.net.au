<?php
/**
 * @package WFC_Toolkit\Cookie_Tracker
 * 
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WFC_Tracker' ) ) :

/**
 * The cookie framework responsible for tracking user actions.
 * Tracked cookies depends on the usage.
 * 
 * @author Carl Ortiz (carl@alphasys.com.au)
 * 
 * @version 1.1.0
 */
final class WFC_Tracker {

	/**
	 * Version.
	 *
	 * @var string
	 */
	const VERSION = '1.1.0';

	/**
	 * Cookie prefix.
	 *
	 * @var string
	 */
	protected $prefix = 'wfc__';

	/**
	 * Name of the cookie table.
	 *
	 * @var string
	 */
	protected $cookie_tbl = 'cookie_tracker';

	/**
	 * Name of the cookie meta table.
	 *
	 * @var string
	 */
	protected $cookie_meta_tbl = 'cookie_tracker_meta';

	/**
	 * Cookie ID.
	 *
	 * @var string
	 */
	protected $cookie_id = '';

	/**
	 * List of the cookies.
	 *
	 * @var array
	 */
	protected $cookies = array();

	/**
	 * The client IP.
	 *
	 * @var string
	 */
	protected $ip = '';

	/**
	 * Cookie date.
	 *
	 * @var string
	 */
	protected $cookie_date = '0000-00-00 00:00:00';

	/**
	 * The single instance of this class.
	 *
	 * @var WFC_Tracker
	 * @static
	 */
	protected static $instance;

	/**
	 * Get the single instance of the class.
	 * 
	 * @static
	 * 
	 * @return WFC_Tracker
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Prevents cloning of an instance of the class via the clone operator.
	 */
	protected function __clone() {
	}

	/**
	 * Prevent unserializing of an instance of the class via the global function unserialize().
	 */
	protected function __wakeup() {
	}

	/**
	 * Initialize the class and set its properties.
	 * 
	 * @access protected
	 */
	protected function __construct() {

		$this->defines();

		if ( $this->is_enabled() ) {
			$this->includes();
			$this->create_database_tables();
			$this->init();
		}
	}

	/**
	 * Defines constant used in this file and it's required
	 * files.
	 * 
	 * @access protected
	 */
	protected function defines() {
		$this->define( 'WFC_TRACKER_DIR', dirname( __FILE__ ) );
	}

	/**
	 * Includes necessarry files.
	 * 
	 * @access protected
	 */
	protected function includes() {
		require WFC_TRACKER_DIR . '/functions.php';
	}

	/**
	 * Creates necessarry database tables.
	 * 
	 * @access protected
	 */
	protected function create_database_tables() {
		global $wpdb;

		$cookie_tbl = $wpdb->prefix . $this->cookie_tbl;
		$cookie_meta_tbl = $wpdb->prefix . $this->cookie_meta_tbl;
		$wpdb_collate = $wpdb->get_charset_collate();

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		if ( $wpdb->get_var("SHOW TABLES LIKE '$cookie_tbl'") != $cookie_tbl ) {
			$cookie_sql = "CREATE TABLE $cookie_tbl (
					id bigint(20) unsigned NOT NULL auto_increment,
					cookie varchar(255) NOT NULL,
					ip varchar(15) NOT NULL,
					cookie_date DATETIME NOT NULL,
					PRIMARY KEY  (id)
				) $wpdb_collate;";

			dbDelta( $cookie_sql );
		}

		if ( $wpdb->get_var("SHOW TABLES LIKE '$cookie_meta_tbl'") != $cookie_meta_tbl ) {
			$cookie_meta_sql = "CREATE TABLE $cookie_meta_tbl (
					id bigint(20) unsigned NOT NULL auto_increment,
					cookie_id bigint(20) unsigned NOT NULL DEFAULT 0,
					meta_key varchar(255) NOT NULL,
					meta_value longtext NOT NULL,
					index(cookie_id),
					index(meta_key),
					PRIMARY KEY  (id)
				) $wpdb_collate;";

			dbDelta( $cookie_meta_sql );
		}
	}

	/**
	 * Initializes the tracker.
	 * 
	 * @access protected
	 */
	protected function init() {

		if ( ! function_exists( 'is_user_logged_in' ) ) {
			require ABSPATH . 'wp-includes/pluggable.php';
		}

		if ( is_user_logged_in() && ! $this->track_loggedin_users() ) {
			return;
		}
		
		$cookie_id = $this->get_cookie_id();

		if ( ! $cookie_id ) {
			$cookie_id = $this->generate_cookie_id();
		}

		$this->cookie_id = $cookie_id;

		$this->ip = isset( $_SERVER[ 'REMOTE_ADDR' ] ) ? $_SERVER[ 'REMOTE_ADDR' ] : '';

		$cookie_date = $this->get_local_cookie( $this->prefix . 'd' );

		$this->cookie_date = $cookie_date != '' ? $cookie_date : date( 'Y-m-d H:i:s' );


		$this->set_local_cookie( $this->prefix, $this->cookie_id );
		$this->set_local_cookie( $this->prefix . 't', $this->cookie_date );
	}

	/**
	 * Adds cookie to the list.
	 * 
	 * @access protected
	 * 
	 * @param string $name Name of the cookie.
	 * @param mixed $value The value of the cookie.
	 * @param bool $save Whether to save to database.
	 */
	protected function add_cookie( $name, $value, $save = true ) {
		if ( $this->is_enabled() ) {
			$this->cookies[$name] = array(
				'value' 	=> $value,
				'save' 		=> $save
			);
		}
	}

	/**
	 * Check if the cookie name is not used
	 * in the core.
	 * 
	 * @param string $name Cookie name.
	 * 
	 * @return bool
	 */
	public function is_valid_cookie_name( $name ) {
		return ! in_array( $name, array( 'wfc__t', 'wfc__' ) );
	}

	/**
	 * Generates cookie ID.
	 * 
	 * @return string
	 */
	public function generate_cookie_id() {
		return md5( wp_generate_password( 32, false ) . $_SERVER[ 'HTTP_USER_AGENT' ] . $_SERVER[ 'REMOTE_ADDR' ] ); 
	}

	/**
	 * Set cookie and add to the cookie list.
	 * 
	 * @param string $name Cookie name.
	 * @param mixed $value Cookie value.
	 * @param bool $save Whether to save to database table.
	 */
	public function set_cookie( $name, $value, $save = true ) {
		if ( ! $this->is_enabled() ) {
			return;
		}

		if ( $this->is_valid_cookie_name( $name ) && ! empty( $this->cookie_id ) ) {
			$value = strval( $value );
			$isset = $this->set_local_cookie( $name, $value );

			if ( $isset ) {
				$this->add_cookie( $name, $value, $save );
			}
		}
	}

	/**
	 * Get the cookie expiration time.
	 * 
	 * @return int
	 */
	public function get_expiration() {
		$days = get_theme_mod( 'wfc_cookie_duration', 30 );
		$days = absint( $days );
		$expiration = time() + 86400 * $days;

		return $expiration;
	}

	/**
	 * Save the cookie including the custom cookies.
	 */
	public function save() {
		if ( ! $this->is_enabled() ) {
			return;
		}

		if ( empty( $this->cookie_id ) ) {
			return;
		}

		global $wpdb;

		$cookie_tbl = $wpdb->prefix . $this->cookie_tbl;
		$cookie_meta_tbl = $wpdb->prefix . $this->cookie_meta_tbl;

		$cookie_data = array();

		$cookie_data['cookie'] = $this->cookie_id;
		$cookie_data['cookie_date'] = $this->cookie_date;
		$cookie_data['ip'] = $this->ip;

		$cookie_record_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $cookie_tbl WHERE `cookie` = %s LIMIT 1", $this->cookie_id ) );

		if ( $cookie_record_id ) {

		} else {
			$wpdb->insert( $cookie_tbl, $cookie_data );
			$cookie_record_id = $wpdb->insert_id;
		}

		$cookie_record_id = absint( $cookie_record_id );

		if ( count( $this->cookies ) && $cookie_record_id ) {
			$insert = array();
			$update = array();

			$exist_cookie_meta = $wpdb->get_results( $wpdb->prepare(
				"SELECT id, meta_key FROM $cookie_meta_tbl WHERE meta_key IN (" . implode( ',', array_fill( 0, count( $this->cookies ), '%s' ) ) . ")",
				array_keys( $this->cookies )
			), ARRAY_A );

			$exist_cookie_meta = wp_list_pluck( $exist_cookie_meta, 'id', 'meta_key' );

			foreach ( $this->cookies as $meta_key => $meta_data ) {
				if ( isset( $meta_data['save'] ) && $meta_data['save'] === false ) {
					continue;
				}

				if ( isset( $exist_cookie_meta[ $meta_key ] ) ) {
					$update[] = array(
						'id' 			=> absint( $exist_cookie_meta[ $meta_key ] ),
						'meta_key' 		=> $meta_key,
						'meta_value' 	=> esc_attr( $meta_data['value'] )
					);
				} else {
					$insert[] = array(
						'meta_key' 		=> $meta_key,
						'meta_value' 	=> esc_attr( $meta_data['value'] )
					);
				}
			}

			if ( count( $insert ) ) {

				$insert_sql = "INSERT INTO $cookie_meta_tbl (cookie_id,meta_key,meta_value) VALUES ";

				foreach ( $insert as $values ) {
					$insert_sql .= $wpdb->prepare( "(%d, %s, %s),", $cookie_record_id, $values['meta_key'], $values['meta_value'] );
				}

				$insert_sql = substr( $insert_sql, 0, -1 );

				$wpdb->query( $insert_sql );
			}

			if ( count( $update ) ) {
				foreach ( $update as $values ) {
					$where = array();
					$where['id'] = $values['id'];
					$where['meta_key'] = $values['meta_key'];

					unset( $values['id'] );
					unset( $values['meta_key'] );

					$wpdb->update( $cookie_meta_tbl, $values, $where, array( '%s' ), array( '%d' ) );
					
				}
			}
		}
	}

	/**
	 * Whether to track logged in users.
	 * 
	 * @return bool
	 */
	public function track_loggedin_users() {
		return get_theme_mod( 'wfc_track_logged_in_users' );
	}

	/**
	 * Check cookie if exists.
	 * 
	 * @param string $name Cookie name.
	 * 
	 * @return bool
	 */
	public function check_cookie( $name ) {
		return isset( $_COOKIE[ $name ] );
	}

	/**
	 * Get the cookie ID.
	 * 
	 * @return string
	 */
	public function get_cookie_id() {
		return $this->get_local_cookie( $this->prefix );
	}

	/**
	 * Get cookie from the browser.
	 * 
	 * @param string $name Cookie name.
	 * 
	 * @return mixed
	 */
	public function get_local_cookie( $name ) {
		return $this->check_cookie( $name ) ? $_COOKIE[ $name ] : '';
	}

	/**
	 * Set cookie to the browser.
	 * 
	 * @param string $name Cookie name.
	 * @param mixed $value Cookie value.
	 * 
	 * @return bool
	 */
	public function set_local_cookie( $name, $value ) {
		if ( $this->is_enabled() ) {
			return setcookie( $name, $value, $this->get_expiration(), COOKIEPATH );
		}

		return false;
	}

	/**
	 * Used to define constant if not exists yet.
	 * 
	 * @param string $name Constant name.
	 * @param mixed $value Constant value.
	 */
	public function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Determines whether the cookie tracker is
	 * enabled or disabled.
	 * 
	 * @since 1.1.0
	 *
	 * @return bool
	 */
	public function is_enabled() {
		$is_enabled = ( bool ) get_theme_mod( 'enable_cookie_tracking', true ) && ! is_admin();

		/**
		 * Filter `wfc_is_cookie_tracker_enabled`.
		 * 
		 * Determines whether the cookie tracker is enabled.
		 * 
		 * @since 1.1.0
		 * 
		 * @param bool $is_enabled Whether cookie tracker is enabled.
		 */
		return ( bool ) apply_filters( 'wfc_is_cookie_tracker_enabled', $is_enabled );
	}

}

endif;

/**
 * Get the single instant of the Tracker.
 * 
 * @return WFC_Tracker
 */
function wfc_tracker() {
	return WFC_Tracker::get_instance();
}

// Store it the global variable.
$GLOBALS['wfc_tracker'] = wfc_tracker();