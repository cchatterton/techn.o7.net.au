<?php
/**
 * @package WFC_Toolkit\WFC_Preloader_Spinners
 * @author AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if access directly.
}

if ( ! class_exists( 'WFC_Preloader_Spinners' ) ) {
    class WFC_Preloader_Spinners {

        /**
         * Static values for the spinners
         *
         * @var $spinners Array values of spinners.
         */
        private static $spinners = array(
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
         * Constructor.
         */
        public function __construct() {

            add_action('admin_enqueue_scripts', array($this, 'admin_enqueues'));
            add_action('wp_enqueue_scripts', array($this, 'public_enqueues'));
        }

        /**
         * Enqueue the preloader spinner css on admin.
         */
        function admin_enqueues() {
            wp_enqueue_style(
                'wfc-preload-spinners-css',
                WFC_PL_CSS . '/preloader-spinners.css'
            );
        }

        /**
         * Enqueue the preloader spinner css on front end.
         */
        function public_enqueues() {
            wp_enqueue_style(
                'wfc-preload-spinners-css',
                WFC_PL_CSS . '/preloader-spinners.css'
            );
        }

        /**
         * Call the active spinner type.
         *
         * @param string  $active  The spinner type which is set to active.
         */
        public static function spinners($active = null) {
            foreach (self::$spinners as $spinner) {
                call_user_func(
                    array(self::class, "spinner_$spinner"),
                    $spinner === $active ? 'active' : ''
                );
            }
        }

        /*public static function get_spinners_array() {
            $spinners = null;
            foreach (self::$spinners as $spinner) {
                $spinners[$spinner] = ucwords(str_replace('_', ' ', $spinner));
            }

            return $spinners;
        }*/

        /**
         * Display the spinner on previews.
         *
         * @param      string  $type   The type of the spinner to display.
         * @param      <type>  $size   The size of the spinner to display.
         * @param      string  $color  The color of the spinner to display.
         */
        public static function spinner($type, $size, $color = '#ffffff') {
            call_user_func(array(self::class, "spinner_$type"), '', $size, $color);
        }

        /**
         * Call a spinner class to render using a preset size.
         *
         * @param      string  $size   The preset size of the spinner.
         *
         * @return     string  The class to be used based on the preset size.
         */
        public static function spinner_size($size) {
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
         * Render the spinner type ball 8bits.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_8bits($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-8bits <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball atom.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_atom($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-atom <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball beat.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_beat($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-beat <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball circus.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_circus($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-circus <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball climbing dot.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_climbing_dot($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-climbing-dot <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball clip rotate.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_clip_rotate($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-clip-rotate <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball clip rotate multiple.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_clip_rotate_multiple($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-clip-rotate-multiple <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball clip roate pulse.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_clip_rotate_pulse($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-clip-rotate-pulse <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball elastic dots.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_elastic_dots($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-elastic-dots <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball fall.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_fall($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-fall <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball fussion.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_fussion($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-fussion <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball grid beat.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_grid_beat($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-grid-beat <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball grid pulse.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_grid_pulse($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-grid-pulse <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball newton cradle.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_newton_cradle($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-newton-cradle <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball pulse.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_pulse($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-pulse <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball pulse rise.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_pulse_rise($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-pulse-rise <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball pulse sync.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_pulse_sync($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-pulse-sync <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball rotate.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_rotate($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-rotate <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball running dots.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_running_dots($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-running-dots <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball scale.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_scale($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball scale multiple.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_scale_multiple($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale-multiple <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball scale pulse.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_scale_pulse($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale-pulse <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball scale ripple.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_scale_ripple($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale-ripple <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball scale ripple multiply.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_scale_ripple_multiply($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-scale-ripple-multiple <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball spin.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball spin clockwise.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_spin_clockwise($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-clockwise <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball spin clockwise fade.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_spin_clockwise_fade($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-clockwise-fade <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball spin clockwise fade rotating.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_spin_clockwise_fade_rotating($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-clockwise-fade-rotating <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball spin fade.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_spin_fade($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-fade <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball spin fade rotating.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_spin_fade_rotating($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-fade-rotating <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball spin rotate.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_spin_rotate($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-spin-rotate <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball square clockwise spin.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_square_clockwise_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-square-clockwise-spin <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball square pin.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_square_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-square-spin <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type ball triangle path.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_triangle_path($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-triangle-path <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball zigzag.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_zigzag($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-zig-zag <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type ball zigzag deflect.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_ball_zigzag_deflect($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-ball-zig-zag-deflect <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type cog.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_cog($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-cog <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type cube transition.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_cube_transition($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-cube-transition <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type fire.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_fire($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-fire <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type line scale.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_line_scale($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-scale <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type line scale party.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_line_scale_party($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-scale-party <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type line scale pulse out.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_line_scale_pulse_out($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-scale-pulse-out <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type line scale pulse out rapid.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_line_scale_pulse_out_rapid($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-scale-pulse-out-rapid <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type line spin clockwise fade.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_line_spin_clockwise_fade($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-spin-clockwise-fade <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type line spin clockwise fade rotating.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_line_spin_clockwise_fade_rotating($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-spin-clockwise-fade-rotating <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type line spin fade.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_line_spin_fade($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-spin-fade <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type line spin fade rotating.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_line_spin_fade_rotating($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-line-spin-fade-rotating <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type pacman.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_pacman($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-pacman <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
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
         * Render the spinner type square jelly box.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_square_jelly_box($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-square-jelly-box <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type square loader.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_square_loader($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-square-loader <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type square spin.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_square_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-square-spin <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type timer.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_timer($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-timer <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Render the spinner type triangle skew spin.
         *
         * @param      string  $active  The active status of the spinner.
         * @param      string  $size    The size for the spinner.
         * @param      string  $color   The fill color for the spinner.
         */
        public static function spinner_triangle_skew_spin($active = '', $size = '', $color = '#ffffff') {
            ?>
            <div class="item-inner <?php esc_attr_e($active); ?>">
                <div class="item-loader-container">
                    <div class="la-triangle-skew-spin <?php esc_attr_e(self::spinner_size($size)); ?>" style="color: <?php esc_attr_e($color); ?>;">
                        <div></div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

new WFC_Preloader_Spinners();