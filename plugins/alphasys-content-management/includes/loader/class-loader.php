<?php

defined('ABSPATH') or die('No script kiddie please!');

if (! class_exists('ASCM_Loader')) {
	/**
	 * Class ASCM_Loader
	 */
	class ASCM_Loader {
		
		/**
         * Array of Available Loader Options
         *
		 * @var array $loaders
		 */
		private static $loaders = array(
            'ball_8bits',
            'ball_atom',
            'ball_beat',
            'ball_circus',
            'ball_climbing_dot',
            'ball_clip_rotate',
            'ball_clip_rotate_multiple',
            'ball_clip_rotate_pulse',
            'ball_elastic_dots',
            'ball_fall',
            'ball_fussion',
            'ball_grid_beat',
            'ball_grid_pulse',
            'ball_newton_cradle',
            'ball_pulse',
            'ball_pulse_rise',
            'ball_pulse_sync',
            'ball_rotate',
            'ball_running_dots',
            'ball_scale',
            'ball_scale_multiple',
            'ball_scale_pulse',
            'ball_scale_ripple',
            'ball_scale_ripple_multiply',
            'ball_spin',
            'ball_spin_clockwise',
            'ball_spin_clockwise_fade',
            'ball_spin_clockwise_fade_rotating',
            'ball_spin_fade',
            'ball_spin_fade_rotating',
            'ball_spin_rotate',
            'ball_square_clockwise_spin',
            'ball_square_spin',
            'ball_triangle_path',
            'ball_zigzag',
            'ball_zigzag_deflect',
            'cog',
            'cube_transition',
            'fire',
            'line_scale',
            'line_scale_party',
            'line_scale_pulse_out',
            'line_scale_pulse_out_rapid',
            'line_spin_clockwise_fade',
            'line_spin_clockwise_fade_rotating',
            'line_spin_fade',
            'line_spin_fade_rotating',
            'pacman',
            'square_jelly_box',
            'square_loader',
            'square_spin',
            'timer',
            'triangle_skew_spin',
        );
		
		/**
		 * ASCM_Loader constructor.
		 */
		public function __construct() {

            add_action('admin_enqueue_scripts', array($this, 'admin_enqueues'));

            add_action('admin_enqueue_scripts', array($this, 'shared_enqueues'));
            add_action('wp_enqueue_scripts', array($this, 'shared_enqueues'));

            add_action('wp_ajax_ascm_loader_preview', array($this, 'loader_preview_callback'));
            add_action('wp_ajax_nopriv_ascm_loader_preview', array($this, 'loader_preview_callback'));
        }
		
		
		function admin_enqueues() {

            wp_enqueue_script(
                'ascm-loader-awesome-js',
                plugin_dir_url( dirname( __FILE__)) . '../assets/js/ascm-loader-awesome.js'
            );
        }
		
		
		function shared_enqueues() {

            wp_enqueue_style(
                'ascm-loader-awesome',
                plugin_dir_url( dirname(__FILE__)) . '../assets/css/ascm-loader-awesome.css'
            );
        }
		
		
		function loader_preview_callback() {
            $loader = sanitize_text_field($_POST['loader']);
            $size = sanitize_text_field($_POST['size']);
            $color = sanitize_text_field($_POST['color']);

            self::loader($loader, $size, $color);

            wp_die();
        }
		
		/**Fetches all Loaders
         *
		 * @return array
		 */
		public static function get_loaders() {
            return self::$loaders;
        }
		
		/**
         * Responsible for returning the type of loader.
         *
		 * @param        $type
		 * @param        $size
		 * @param        $color
		 * @param  bool  $return
		 *
		 * @return false|string
		 */
		public static function loader($type, $size, $color, $return = false) {
            ob_start();
            call_user_func(array(self::class, "loader_$type"), '', $size, $color);
            $loader = ob_get_clean();

            if ($return) {
                return $loader;
            } else {
                echo $loader;
            }
        }
		
		/**
         * Defines the loader size.
         *
		 * @param $size
		 *
		 * @return string
		 */
		public static function loader_size($size) {
            switch ($size) {
                case 'small':
                    return 'la-sm';
                    break;
                case 'normal':
                    return '';
                    break;
                case 'medium':
                    return 'la-2x';
                    break;
                case 'large':
                    return 'la-3x';
                    break;
                default:
                    return '';
                    break;
            }
        }
		
		/**
         * Renders the loader_ball_8bits pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_8bits($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-8bits <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_atom pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_atom($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-atom <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_beat pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_beat($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-beat <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_circus pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_circus($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-circus <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_climbing_dot pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_climbing_dot($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-climbing-dot <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_clip_rotate pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_clip_rotate($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-clip-rotate <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_clip_rotate_multiple pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_clip_rotate_multiple($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-clip-rotate-multiple <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_clip_rotate_pulse pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_clip_rotate_pulse($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-clip-rotate-pulse <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_elastic_dots pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_elastic_dots($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-elastic-dots <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_fall pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_fall($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-fall <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_fussion pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_fussion($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-fussion <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_grid_beat pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_grid_beat($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-grid-beat <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_grid_pulse pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_grid_pulse($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-grid-pulse <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_newton_cradle pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_newton_cradle($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-newton-cradle <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_pulse pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_pulse($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-pulse <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_pulse_rise pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_pulse_rise($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-pulse-rise <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_pulse_sync pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_pulse_sync($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-pulse-sync <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_rotate pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_rotate($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-rotate <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_running_dots pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_running_dots($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-running-dots <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_scale pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_scale($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_scale_multiple pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_scale_multiple($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale-multiple <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_scale_pulse pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_scale_pulse($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale-pulse <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_scale_ripple pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_scale_ripple($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale-ripple <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_scale_ripple_multiply pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_scale_ripple_multiply($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale-ripple-multiple <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_spin pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_spin_clockwise pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_spin_clockwise($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-clockwise <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_spin_clckwise_fade pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_spin_clockwise_fade($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-clockwise-fade <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_spin_clockwise_fade_rotating pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_spin_clockwise_fade_rotating($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-clockwise-fade-rotating <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_spin_fade pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_spin_fade($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-fade <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_spin_fade_rotating pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_spin_fade_rotating($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-fade-rotating <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_spin_rotate pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_spin_rotate($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-rotate <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_square_clockwise_spin pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_square_clockwise_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-square-clockwise-spin <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_square_spin pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_square_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-square-spin <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_triangle_path pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_triangle_path($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-triangle-path <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_zigzag pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_zigzag($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-zig-zag <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_ball_zigzag_deflect pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_ball_zigzag_deflect($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-zig-zag-deflect <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_cog pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_cog($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-cog <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_cube_transition pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_cube_transition($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-cube-transition <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_fire pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_fire($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-fire <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_line_scale pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_line_scale($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-scale <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_line_scale_party pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_line_scale_party($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-scale-party <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_line_scale_pulse_out pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_line_scale_pulse_out($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-scale-pulse-out <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_line_scale_pulse_out_rapid pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_line_scale_pulse_out_rapid($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-scale-pulse-out-rapid <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_line_spin_clockwise_fade pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_line_spin_clockwise_fade($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-spin-clockwise-fade <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_line_spin_clockwise_fade_rotating pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_line_spin_clockwise_fade_rotating($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-spin-clockwise-fade-rotating <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_line_spin_fade pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_line_spin_fade($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-spin-fade <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_line_spin_fade_rotating pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_line_spin_fade_rotating($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-spin-fade-rotating <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_pacman pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_pacman($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-pacman <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_square_jelly_box pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_square_jelly_box($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-square-jelly-box <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_square_loader pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_square_loader($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-square-loader <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_square_spin pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_square_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-square-spin <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_timer pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_timer($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-timer <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
		
		/**
         * Renders the loader_triangle_skew_spin pre-loader.
         *
		 * @param  string  $active
		 * @param  string  $size
		 * @param  string  $color
		 */
		public static function loader_triangle_skew_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-triangle-skew-spin <?php esc_attr_e(self::loader_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}