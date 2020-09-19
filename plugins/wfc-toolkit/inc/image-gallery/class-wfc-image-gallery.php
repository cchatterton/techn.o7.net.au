<?php
/**
 * @package WFC_Toolkit\Image_Gallery
 * 
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Extends the default image gallery
 * features in WordPress.
 */
class WFC_Image_Gallery {

	/**
	 * Initializes the class.
	 */
	public function __construct() {

		define( 'WFC_IG_VERSION', '1.0.0' );

		define( 'WFC_IG_URL', plugin_dir_url( __FILE__ ) );
		define( 'WFC_IG_ADMIN_CSS_URL', WFC_IG_URL . 'admin/css/' );
		define( 'WFC_IG_ADMIN_JS_URL', WFC_IG_URL . 'admin/js/' );
		define( 'WFC_IG_ADMIN_IMG', WFC_IG_URL . 'admin/img/' );
		define( 'WFC_IG_PUBLIC_CSS_URL', WFC_IG_URL . 'public/css/' );
		define( 'WFC_IG_PUBLIC_JS_URL', WFC_IG_URL . 'public/js/' );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueues' ) );
		add_action( 'wp_enqueue_scripts', array($this, 'public_enqueues' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 1 );
		add_action( 'save_post', array( $this, 'save_post_meta' ) );

	}

	/**
	 * Adds meta box for the settings in both
	 * post and page post type.
	 */
	public function add_meta_box() {
		add_meta_box(
			'wfc-image-gallery',
			esc_html__( 'Image Gallery Settings', 'wfc-toolkit' ),
			array( $this, 'meta_box_markup_callback'),
			array( 'post', 'page' ),
			'side'
		);
	}

	/**
	 * Enqueue scripts and styles for admin.
	 */
	public function admin_enqueues() {

		wp_enqueue_style(
			'wfc-ig-image-gallery',
			WFC_IG_ADMIN_CSS_URL . 'image-gallery.css'
		);

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script(
			'wfc-ig-image-gallery',
			WFC_IG_ADMIN_JS_URL . 'image-gallery.js',
			array( 'jquery', 'wp-blocks' ),
			WFC_IG_VERSION
		);
	}

	/**
	 * Enqueue scripts and styles for public pages.
	 */
	public function public_enqueues() {
		wp_enqueue_style(
			'wfc-ig-image-gallery',
			WFC_IG_PUBLIC_CSS_URL . 'image-gallery.css'
		);

		wp_enqueue_script(
			'isotope',
			WFC_IG_PUBLIC_JS_URL . 'isotope.pkgd.min.js',
			array( 'jquery' ),
			WFC_IG_VERSION
		);
		wp_enqueue_script(
			'imagesloaded',
			WFC_IG_PUBLIC_JS_URL . 'imagesloaded.pkgd.min.js',
			array( 'jquery' ),
			WFC_IG_VERSION
		);
		wp_enqueue_script(
			'wfc-ig-image-gallery',
			WFC_IG_PUBLIC_JS_URL . 'image-gallery.js',
			array( 'jquery' ),
			WFC_IG_VERSION
		);

		global $post;

		if ( isset( $post ) ) {
			$col_count_sm = get_post_meta( $post->ID, 'wfc_ig_col_sm', true );
			$col_count_md = get_post_meta( $post->ID, 'wfc_ig_col_md', true );
			$col_count_lg = get_post_meta( $post->ID, 'wfc_ig_col_lg', true );
			$display_type = get_post_meta( $post->ID, 'wfc_ig_display_type', true );

			wp_localize_script( 'wfc-ig-image-gallery', 'wfcImageGalleryConfig', array(
				'colCountSmall' => $col_count_sm,
				'colCountMedium' => $col_count_md,
				'colCountLarge' => $col_count_lg,
				'displayType' => $display_type
			) );
		}
	}

	/**
	 * Renders the settings in meta box.
	 * 
	 * @param WP_Post $post Current post where the meta box is.
	 */
	public function meta_box_markup_callback( $post ) {

		$col_count_sm = get_post_meta( $post->ID, 'wfc_ig_col_sm', true );
		$col_count_md = get_post_meta( $post->ID, 'wfc_ig_col_md', true );
		$col_count_lg = get_post_meta( $post->ID, 'wfc_ig_col_lg', true );
		$display_type = get_post_meta( $post->ID, 'wfc_ig_display_type', true );

		$col_count_sm = ! empty( $col_count_sm ) ? $col_count_sm : 1;
		$col_count_md = ! empty( $col_count_md ) ? $col_count_md : 2;
		$col_count_lg = ! empty( $col_count_lg ) ? $col_count_lg : 3;
		$display_type = ! empty( $display_type ) ? $display_type : 'equalize';
		?>
		<div class="wfcg-wp-image-gallery-settings-container">
			<div class="wfcg-wp-image-gallery-row-count-container">
				<label>Column Count (Small)</label>
				<div class="wfcg-slider-container">
					<input class="wfcg-slider" type="range" min="1" max="6" value="<?php esc_attr_e( $col_count_sm ); ?>" class="wfcg-slider" name="wfc_ig_col_sm" data-orientation="horizontal" />
					<div class="slider-ui"></div>
				</div>
			</div>

			<hr>

			<div class="wfcg-wp-image-gallery-row-count-container">
				<label>Column Count (Medium)</label>
				<div class="wfcg-slider-container">
					<input class="wfcg-slider" type="range" min="1" max="6" value="<?php esc_attr_e( $col_count_md ); ?>" class="wfcg-slider" name="wfc_ig_col_md" data-orientation="horizontal" />
					<div class="slider-ui"></div>
				</div>
			</div>

			<hr>

			<div class="wfcg-wp-image-gallery-row-count-container">
				<label>Column Count (Large)</label>
				<div class="wfcg-slider-container">
					<input class="wfcg-slider" type="range" min="1" max="6" value="<?php esc_attr_e( $col_count_lg ); ?>" class="wfcg-slider" name="wfc_ig_col_lg" data-orientation="horizontal" />
					<div class="slider-ui"></div>
				</div>
			</div>

			<hr>

			<div class="wfcg-wp-image-gallery-display-type-container">
				<label>Display type</label>
				<div class="wfcg-select-display-type-container">
					<label>
						<input type="radio" name="wfc_ig_display_type" value="equalize" <?php checked( $display_type, 'equalize' ); ?> />
						<img src="<?php esc_attr_e( WFC_IG_ADMIN_IMG . 'equalize.png' ); ?>" />
					</label>
					<label>
						<input type="radio" name="wfc_ig_display_type" value="masonry" <?php checked( $display_type, 'masonry' ) ?> />
						<img src="<?php esc_attr_e( WFC_IG_ADMIN_IMG . 'masonry.png' ); ?>" />
					</label>
				</div>
			</div>

			<small>(<strong>Note:</strong> This overrides the image gallery's column count.)</small>
		</div>
		<?php
	}

	/**
	 * Save the image gallery settings
	 * on post meta.
	 * 
	 * @param int $post_id The current post ID.
	 */
	public function save_post_meta( $post_id ) {
		global $typenow;

		if ( $typenow === 'page' || $typenow === 'post' ) {
			$col_count_sm = isset( $_POST[ 'wfc_ig_col_sm' ] ) ? $_POST[ 'wfc_ig_col_sm' ] : 3;
			$col_count_md = isset( $_POST[ 'wfc_ig_col_md' ] ) ? $_POST[ 'wfc_ig_col_md' ] : 3;
			$col_count_lg = isset( $_POST[ 'wfc_ig_col_lg' ] ) ? $_POST[ 'wfc_ig_col_lg' ] : 3;
			$display_type = isset( $_POST[ 'wfc_ig_display_type' ] ) ? $_POST[ 'wfc_ig_display_type' ] : 'equalize';

			update_post_meta( $post_id, 'wfc_ig_col_sm', $col_count_sm );
			update_post_meta( $post_id, 'wfc_ig_col_md', $col_count_md );
			update_post_meta( $post_id, 'wfc_ig_col_lg', $col_count_lg );
			update_post_meta( $post_id, 'wfc_ig_display_type', $display_type );
		}

		remove_action( 'save_post', array( $this, 'save_post_meta' ) );
	}
}

new WFC_Image_Gallery();