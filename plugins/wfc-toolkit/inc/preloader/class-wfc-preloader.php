<?php
/**
 * @package WFC_Toolkit\WFC_Preloader
 * @author AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if access directly.
}

if ( ! class_exists( 'WFC_Preloader' ) ) {
    class WFC_Preloader {

        /**
         * Constructor
         */
        public function __construct() {

            define( 'WFC_PL_DIR', plugin_dir_path( __FILE__ ) . '/' );
            define( 'WFC_PL_ASSETS', plugin_dir_url( __FILE__ ) . 'assets' );
            define( 'WFC_PL_CSS', WFC_PL_ASSETS . '/css' );
            define( 'WFC_PL_JS', WFC_PL_ASSETS . '/js' );

            require WFC_PL_DIR . 'class-wfc-preloader-spinners.php';


            add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueues' ) );

            add_action( 'wp_footer', array ($this, 'genesis_preloader_load' ) );
        }

        /**
         * Enqueues public styles and scripts
         */
        public function public_enqueues() {
            wp_enqueue_style(
                'wfc-preloader-css',
                WFC_PL_CSS . '/preloader.css'
            );

            wp_enqueue_script(
                'wfc-preloader-js',
                WFC_PL_JS . '/preloader.js',
                array('jquery'),
                '',
                true
            );

            $wfc_preloader_enable = wfc_toolkit_get_option( 'enable_preloader' ) ? 1 : 0;
            $wfc_preloader_image_id = wfc_toolkit_get_option( 'preloader_spinner_image' );
            $wfc_preloader_background_color = wfc_toolkit_get_option( 'preloader_background', '#000000' );
            wp_localize_script(
                'wfc-preloader-js',
                'wfc_preloader',
                array(
                    'enable' => $wfc_preloader_enable, 
                    'image' => $wfc_preloader_image_id,
                    'background_color' => $wfc_preloader_background_color,
                    'is_preload' => $this->genesis_preloader_load(true) !== null ? 1 : 0
                )
            );
        }

        /**
         * Return array of options saved for preloader on Customizer (get_theme_mod)(to be replaced)
         * 
         * @return array Array of preloader options
         */
        public static function wfc_preloader_options() {
            $wfc_preloader_enable = wfc_toolkit_get_option( 'enable_preloader', false );
            $wfc_preloader_page_selection = wfc_toolkit_get_option( 'preloader_page', 'all' );
            $wfc_preloader_pages_except = wfc_toolkit_get_option( 'preloader_page_except', array() );
            $wfc_preloader_selected_pages = wfc_toolkit_get_option( 'preloader_selected_page', array() );
            $wfc_preloader_spinner_type = wfc_toolkit_get_option( 'preloader_type', 'spinner' );
            $wfc_preloader_spinner = wfc_toolkit_get_option( 'preloader_spinner', 'line_scale' );
            $wfc_preloader_spinner_color = wfc_toolkit_get_option( 'preloader_spinner_color', '#ffffff' );
            $wfc_preloader_spinner_size = wfc_toolkit_get_option( 'preloader_spinner_size', 'small' );
            $wfc_preloader_image_id = wfc_toolkit_get_option( 'preloader_spinner_image' );
            $wfc_preloader_image_width = wfc_toolkit_get_option( 'preloader_spinner_width', 100 );
            $wfc_preloader_background_color = wfc_toolkit_get_option( 'preloader_background', '#000000' );
            $wfc_preloader_loading_text = wfc_toolkit_get_option( 'preloader_text', 'Loading...' );
            $wfc_preloader_loading_text_color = wfc_toolkit_get_option( 'preloader_text_color', '#ffffff' );
            $wfc_preloader_loading_text_size = wfc_toolkit_get_option( 'preloader_text_size', 10 );

            return array(
                'enable' => $wfc_preloader_enable,

                'page_selection' => $wfc_preloader_page_selection,
                'pages_except' => $wfc_preloader_pages_except,
                'selected_pages' => $wfc_preloader_selected_pages,

                'spinner_type' => $wfc_preloader_spinner_type,
                'spinner' => $wfc_preloader_spinner,
                'spinner_color' => $wfc_preloader_spinner_color,
                'spinner_size' => $wfc_preloader_spinner_size,

                'image_id' => $wfc_preloader_image_id,
                'image_width' => $wfc_preloader_image_width,

                'background_color' => $wfc_preloader_background_color,

                'loading_text' => $wfc_preloader_loading_text,
                'loading_text_color' => $wfc_preloader_loading_text_color,
                'loading_text_size' => $wfc_preloader_loading_text_size
            );
        }

        /**
         * Function that is hooked on 'genesis_before' hooked to render the preloader.
         */
        function genesis_preloader_load($check = false) {
            global $post;

            $wfc_preloader_options = $this->wfc_preloader_options();


            if ( ! $wfc_preloader_options['enable'] ) return false;

            if ($wfc_preloader_options['page_selection'] === 'page_except') {
                if (! in_array($post->ID, $wfc_preloader_options['pages_except'])) {
                    if ($check) return true;
                    else {
                        $this->preloader_markup();
                        return false;
                    }
                }
            } else if ($wfc_preloader_options['page_selection'] === 'selected_page') {
                if (in_array($post->ID, $wfc_preloader_options['selected_pages'])) {
                    if ($check) return true;
                    else {
                        $this->preloader_markup();
                        return false;
                    }
                }
            } else {
                if ($check) return true;
                else {
                    $this->preloader_markup();
                    return false;
                }
            }
        }

        /**
         * Contains HTML and some CSS markup to render the preloader with its applied preloader options
         */
        function preloader_markup() {
            $wfc_preloader_options = $this->wfc_preloader_options();
            ?>
            <?php if ($this->compatibility_check_for_ios()) : ?>
                <div id="wfc-preloader" class="pre-loading" style="background-color: <?php esc_attr_e($wfc_preloader_options['background_color']) ?>">
                    <div class="wfc-spinner-container">
                        <div class="wfc-spinner">
                            <?php
                            if ($wfc_preloader_options['spinner_type'] === 'spinner') {
                                WFC_Preloader_Spinners::spinner($wfc_preloader_options['spinner'], $wfc_preloader_options['spinner_size'], $wfc_preloader_options['spinner_color']);
                            } else if ($wfc_preloader_options['spinner_type'] === 'image') {
                                echo '<img src="' . $wfc_preloader_options['image_id'] . '" width="' . $wfc_preloader_options['image_width'] . '" />';
                            }
                            ?>
                        </div>
                        <div class="wfc-loading-text" style="color: <?php esc_attr_e($wfc_preloader_options['loading_text_color']); ?>; font-size: <?php esc_attr_e($wfc_preloader_options['loading_text_size']); ?>px;"><?php esc_html_e($wfc_preloader_options['loading_text']); ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php
        }

        /**
         * Check if iOS version if version is greater than 9, returns true if compatible, otherwise false
         * 
         * @return bool Returns true if compatible, otherwise false
         */
        private function compatibility_check_for_ios() {
            $reges = '/ip(?:hone|[ao]d); cpu os \K[\d_]+/i';
            preg_match($reges, $_SERVER['HTTP_USER_AGENT'], $matches, PREG_OFFSET_CAPTURE, 0);

            if (empty($matches))
                return true;

            $ios_version = $matches[0][0];
            $ios_version = (int)explode('_', $ios_version)[0];

            if ($ios_version === 0)
                return true;

            return $ios_version > 9;
        }

        /**
         * AJAX Preview for spinner preview on customizer
         */
        function update_spinner_preview() {
            if (! isset($_POST)) wp_die();

            $type = isset($_POST['type']) ? $_POST['type'] : '';

            $wfc_preloader_options = $this->wfc_preloader_options();
            WFC_Preloader_Spinners::spinner($type, $wfc_preloader_options['spinner_size'], $wfc_preloader_options['spinner_color']);

            wp_die();
        }
    }
}

new WFC_Preloader();