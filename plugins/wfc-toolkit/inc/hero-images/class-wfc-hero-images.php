<?php
/**
 * @package WFC_Toolkit\WFC_Hero_Images
 * @author AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if access directly.
}

if ( ! class_exists( 'WFC_Hero_Images' ) ) {
	
	class WFC_Hero_Images {
		/**
		 * Constructor
		 */
		public function __construct() {

			define( 'WFC_HI_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/' );
			define( 'WFC_HI_CSS', WFC_HI_ASSETS . 'css/' );
			define( 'WFC_HI_JS', WFC_HI_ASSETS . 'js/' );
			define( 'WFC_HI_IMG', WFC_HI_ASSETS . 'img/' );

			add_action( 'admin_enqueue_scripts', array( $this, 'wfc_hero_admin_scripts' ), 10, 1 );

			add_action( 'add_meta_boxes', array( $this, 'wfc_hero_register_meta_box' ), 1 );

			add_filter( 'wfc_hero_render_metabox_sm_btn', array( $this, 'wfc_hero_append_sm_ctrl' ), 10, 2 );
			add_filter( 'wfc_hero_render_metabox_md_btn', array( $this, 'wfc_hero_append_md_ctrl' ), 10, 2 );
			add_filter( 'wfc_hero_render_metabox_lg_btn', array( $this, 'wfc_hero_append_lg_ctrl' ), 10, 2 );

			add_action( 'wfc_heroimages_before_save_postdata', array( $this, 'wfc_hero_save_custom_fields' ), 10, 2 );
			add_action( 'save_post', array($this, 'wfc_hero_save_postdata') );

			add_action( 'save_post', array( $this, 'wfc_hero_save_revision' ), 999 );
			add_action( 'wp_restore_post_revision', array( $this, 'wfc_hero_restore_revision' ), 10, 2 );
			add_filter( '_wp_post_revision_fields', array( $this, 'wfc_hero_revision_fields' ), 10, 2 );
			add_filter( '_wp_post_revision_field_wfc_heroimages_small', array( $this, 'wfc_hero_revision_field_heroimages_small' ), 10, 3 );
			add_filter( '_wp_post_revision_field_wfc_heroimages_medium', array( $this, 'wfc_hero_revision_field_heroimages_medium' ), 10, 3 );
			add_filter( '_wp_post_revision_field_wfc_heroimages_large', array( $this, 'wfc_hero_revision_field_heroimages_large' ), 10, 3 );
		}

		/**
		 * Set the post types where hero is visible.
		 *
		 * @return     array  The post types where hero is visible.
		 */
		public static function wfc_hero_posttype_visibility() {
			return array_merge(
				array( 'post', 'page' ),
				get_post_types( array(
					'public' => true,
					'show_ui' => true,
					'_builtin' => false
				) )
			);
		}

		/**
		 * Add the Hero Images Metabox
		 */
		public function wfc_hero_register_meta_box() {
			$post_types = self::wfc_hero_posttype_visibility();

			foreach ( $post_types as $key => $post_type ) {
				add_meta_box( 
					'wfc-hero-metabox',
					esc_html__( 'Hero Images', 'wfc-toolkit' ),
					array( $this, 'wfc_hero_callback' ),
					$post_type,
					'side'
				);
			}
		}

		/**
		 * The callback function for registering the hero image metabox.
		 *
		 * @param      object  $post   The post
		 */
		public function wfc_hero_callback( $post ) {

			$wfc_heroimages_small = get_post_meta( $post->ID, 'wfc_heroimages_small', true );
			$wfc_heroimages_small_width = get_post_meta( $post->ID, 'wfc_heroimages_small_width', true );
			$wfc_heroimages_small_height = get_post_meta( $post->ID, 'wfc_heroimages_small_height', true );

			$wfc_heroimages_medium = get_post_meta( $post->ID, 'wfc_heroimages_medium', true );
			$wfc_heroimages_medium_width = get_post_meta( $post->ID, 'wfc_heroimages_medium_width', true );
			$wfc_heroimages_medium_height = get_post_meta( $post->ID, 'wfc_heroimages_medium_height', true );

			$wfc_heroimages_large = get_post_meta( $post->ID, 'wfc_heroimages_large', true );
			$wfc_heroimages_large_width = get_post_meta( $post->ID, 'wfc_heroimages_large_width', true );
			$wfc_heroimages_large_height = get_post_meta( $post->ID, 'wfc_heroimages_large_height', true );
			
			$wfc_hero_type = get_post_meta( $post->ID, 'wfc_hero_type', true );
			$wfc_hero_cta_url = get_post_meta( $post->ID, 'wfc_hero_cta_url', true );
			$wfc_hero_cta_label = get_post_meta( $post->ID, 'wfc_hero_cta_label', true );		
			$wfc_adaptive_image = get_post_meta( $post->ID, 'wfc_adaptive_image', true );		
			
			?>
			<div class="wfc-heroimages-main-container">
				<div class="wfc-heroimages-sub-container">
				
					<div class="herotype-wrapper">
						<label for="herotype">Hero Type</label>
						<select id="wfc-hero-type" name="wfc_hero_type">
						  <option value="hero-knife-edge" <?php echo $wfc_hero_type == 'hero-knife-edge' ? 'selected' : ''; ?> >Knife-edge</option>
						  <option value="hero-w-cta" <?php echo $wfc_hero_type == 'hero-w-cta' ? 'selected' : ''; ?> >With CTA</option>
						  <option value="hero-simple" <?php echo $wfc_hero_type == 'hero-simple' ? 'selected' : ''; ?> >Simple</option>
						</select>
					</div>
					
					<div class="with-cta-wrapper">
						<div>
							<label>CTA URL</label>
						</div>
						<div>
							<input type="text" name="wfc_hero_cta_url" id="wfc-hero-cta-url" value="<?php echo $wfc_hero_cta_url ?>"></input>
						</div>
						<div>
							<label>CTA Label</label>
						</div>
						<div>
							<input type="text" name="wfc_hero_cta_label" id="wfc-hero-cta-label" value="<?php echo $wfc_hero_cta_label ?>"></input>
						</div>						
					</div>
					
					<div class="adaptive-image-wrapper">
						<label><input type="checkbox" name="wfc_adaptive_image" value="isAdaptive" <?php echo ! empty( $wfc_adaptive_image ) ? 'checked' : '' ?> > Adaptive Images </label>
					</div>
					<div class="adaptive-image-container">
						<div class="wfc-heroimages-mediaupdloader-container">
							<label id="wfc-heroimages-small-label" class="wfc-heroimages-field-title"><?php _e( 'Small Devices', 'wfc-toolkit' )?></label>
							<div>
								<input type="hidden" name="wfc_heroimages_small_width" id="wfc-heroimages-small-width" value="<?php echo esc_attr( $wfc_heroimages_small_width ); ?>" readonly/>
								<input type="hidden" name="wfc_heroimages_small_height" id="wfc-heroimages-small-height" value="<?php echo esc_attr( $wfc_heroimages_small_height ); ?>" readonly/>

								<input type="url" class="large-text" name="wfc_heroimages_small" id="wfc-heroimages-small" value="<?php echo esc_attr( $wfc_heroimages_small ); ?>"/>
								<div style="padding: 5px 0px !important;">
									<div class="wfc-hi-button wfc-uploadmedia-btn" id="events_video_upload_btn" data-media-uploader-target="#wfc-heroimages-small"><?php _e( 'Upload Media', 'wfc-toolkit' )?></div>
									<div class="wfc-hi-button wfc-previewmedia-btn" data-media-preview-target="#wfc-heroimages-preview-small"><?php _e( 'Preview', 'wfc-toolkit' )?></div>
									<div class="wfc-hi-button wfc-clearmedia-btn" data-media-cancel-target="#wfc-heroimages-small"><?php _e( 'Clear', 'wfc-toolkit' )?></div>
									<?php echo apply_filters( 'wfc_hero_render_metabox_sm_btn', '', $post ); ?>
								</div>
							</div>
							<div id="wfc-heroimages-preview-small" class="wfc-heroimages-preview-main-cont" preview-cont="true">
								<div id="wfc-heroimages-preview-small-sub-cont" class="wfc-heroimages-preview-sub-cont">
									
									<img id="wfc-heroimages-small-img" src="<?php echo esc_attr( $wfc_heroimages_small ); ?>">
								</div>
							</div>
						</div>
					
					
						<div class="wfc-heroimages-mediaupdloader-container">
							<label id="wfc-heroimages-medium-label" class="wfc-heroimages-field-title"><?php _e( 'Medium Devices', 'wfc-toolkit' )?></label>
							<div>
								<input type="hidden" name="wfc_heroimages_medium_width" id="wfc-heroimages-medium-width" value="<?php echo esc_attr( $wfc_heroimages_medium_width ); ?>" readonly/>
								<input type="hidden" name="wfc_heroimages_medium_height" id="wfc-heroimages-medium-height" value="<?php echo esc_attr( $wfc_heroimages_medium_height ); ?>" readonly/>

								<input type="url" class="large-text" name="wfc_heroimages_medium" id="wfc-heroimages-medium" value="<?php echo esc_attr( $wfc_heroimages_medium ); ?>"/>
								<div style="padding: 5px 0px !important;">
									<div class="wfc-hi-button wfc-uploadmedia-btn" id="events_video_upload_btn" data-media-uploader-target="#wfc-heroimages-medium"><?php _e( 'Upload Media', 'wfc-toolkit' )?></div>
									<div class="wfc-hi-button wfc-previewmedia-btn" data-media-preview-target="#wfc-heroimages-preview-medium"><?php _e( 'Preview', 'wfc-toolkit' )?></div>
									<div class="wfc-hi-button wfc-clearmedia-btn" data-media-cancel-target="#wfc-heroimages-medium"><?php _e( 'Clear', 'wfc-toolkit' )?></div>
									<?php echo apply_filters( 'wfc_hero_render_metabox_md_btn', '', $post ); ?>
								</div>
							</div>
							<div id="wfc-heroimages-preview-medium" class="wfc-heroimages-preview-main-cont" preview-cont="true">
								<div id="wfc-heroimages-preview-medium-sub-cont" class="wfc-heroimages-preview-sub-cont">
									<img id="wfc-heroimages-medium-img" src="<?php echo esc_attr( $wfc_heroimages_medium ); ?>">
								</div>
							</div>
						</div>
					</div>

					<div class="wfc-heroimages-mediaupdloader-container">
						<label id="wfc-heroimages-large-label" class="wfc-heroimages-field-title"><?php _e( 'Large Devices', 'wfc-toolkit' )?></label>
						<div>
							<input type="hidden" name="wfc_heroimages_large_width" id="wfc-heroimages-large-width" value="<?php echo esc_attr( $wfc_heroimages_large_width ); ?>" readonly/>
							<input type="hidden" name="wfc_heroimages_large_height" id="wfc-heroimages-large-height" value="<?php echo esc_attr( $wfc_heroimages_large_height ); ?>" readonly/>

							<input type="url" class="large-text" name="wfc_heroimages_large" id="wfc-heroimages-large" value="<?php echo esc_attr( $wfc_heroimages_large ); ?>"/>
							<div style="padding: 5px 0px !important;">
								<div class="wfc-hi-button wfc-uploadmedia-btn" id="events_video_upload_btn" data-media-uploader-target="#wfc-heroimages-large"><?php _e( 'Upload Media', 'wfc-toolkit' )?></div>
								<div class="wfc-hi-button wfc-previewmedia-btn" data-media-preview-target="#wfc-heroimages-preview-large"><?php _e( 'Preview', 'wfc-toolkit' )?></div>
								<div class="wfc-hi-button wfc-clearmedia-btn" data-media-cancel-target="#wfc-heroimages-large"><?php _e( 'Clear', 'wfc-toolkit' )?></div>
							    <?php echo apply_filters( 'wfc_hero_render_metabox_lg_btn', '', $post ); ?>
							</div>
						</div>
						<div id="wfc-heroimages-preview-large" class="wfc-heroimages-preview-main-cont" preview-cont="true">
							<div id="wfc-heroimages-preview-large-sub-cont" class="wfc-heroimages-preview-sub-cont">
								
								<img id="wfc-heroimages-large-img" src="<?php echo esc_attr( $wfc_heroimages_large ); ?>">
							</div>
						</div>
					</div>
					<?php wp_nonce_field( 'wfc_heroimages_save', 'wfc_heroimages_nonce' ); ?>
				</div>
			</div>
			<?php
		}

		/**
		 * Enquue admin scripts and styles
		 *
		 * @param      string $hook The current admin page
		 */
		public function wfc_hero_admin_scripts( $hook ) {
			global $typenow;

			$post_types = self::wfc_hero_posttype_visibility();

			if ( in_array( $typenow, $post_types ) ) {
				wp_enqueue_media();

				wp_register_script(
					'wfc-heroimages-js',
					WFC_HI_JS . 'hero-images.js',
					array( 'jquery' )
				);

				wp_localize_script( 'wfc-heroimages-js', 'meta_image',
					array(
						'title' => __( 'Choose or Upload Media', 'wfc-toolkit' ),
						'button' => __( 'Use this media', 'wfc-toolkit' ),
					)
				);

				wp_localize_script(
					'wfc-heroimages-js',
					'wfc_heroimages_param',
					array(
						'url' => admin_url('admin-ajax.php'),
						'nonce' => wp_create_nonce('ajax-nonce'),
						'logourl' => WFCT_IMG_URL . 'webforce-connect.png'
					)
				);

				wp_enqueue_script( 'wfc-heroimages-js' );

				wp_enqueue_style( 
			    	'wfc-heroimages-js-css', 
			    	WFC_HI_CSS . 'hero-images.css',
			    	array(), 
			    	null, 
			    	'all' 
			    );
			}
		}

		/**
		 * Check if the nonce is set and verify it, and save/update the meta of the post.
		 *
		 * @param      int  $post_id  The post id.
		 */
		public function wfc_hero_save_postdata( $post_id ) {
			global $typenow;

			if ( ! isset( $_POST['wfc_heroimages_nonce'] ) || ! wp_verify_nonce( $_POST['wfc_heroimages_nonce'], 'wfc_heroimages_save' ) ) {
				return;
			}

			$post_types = self::wfc_hero_posttype_visibility();

			if ( in_array( $typenow, $post_types ) ) {

				do_action( 'wfc_heroimages_before_save_postdata', $post_id, $_POST );

				$wfc_heroimages_small =
				isset($_POST['wfc_heroimages_small']) ? $_POST['wfc_heroimages_small'] : '';
				$wfc_heroimages_small_width =
				isset($_POST['wfc_heroimages_small_width']) ? $_POST['wfc_heroimages_small_width'] : '';
				$wfc_heroimages_small_height =
				isset($_POST['wfc_heroimages_small_height']) ? $_POST['wfc_heroimages_small_height'] : '';


				$wfc_heroimages_medium =
				isset($_POST['wfc_heroimages_medium']) ? $_POST['wfc_heroimages_medium'] : '';
				$wfc_heroimages_medium_width =
				isset($_POST['wfc_heroimages_medium_width']) ? $_POST['wfc_heroimages_medium_width'] : '';
				$wfc_heroimages_medium_height =
				isset($_POST['wfc_heroimages_medium_height']) ? $_POST['wfc_heroimages_medium_height'] : '';


				$wfc_heroimages_large =
				isset($_POST['wfc_heroimages_large']) ? $_POST['wfc_heroimages_large'] : '';
				$wfc_heroimages_large_width =
				isset($_POST['wfc_heroimages_large_width']) ? $_POST['wfc_heroimages_large_width'] : '';
				$wfc_heroimages_large_height =
				isset($_POST['wfc_heroimages_large_height']) ? $_POST['wfc_heroimages_large_height'] : '';

				$wfc_hero_type = isset( $_POST['wfc_hero_type']) ? $_POST['wfc_hero_type'] : '';
				$wfc_hero_cta_url = isset( $_POST['wfc_hero_cta_url']) ? $_POST['wfc_hero_cta_url'] : '';
				$wfc_hero_cta_label = isset( $_POST['wfc_hero_cta_label']) ? $_POST['wfc_hero_cta_label'] : '';
				$wfc_adaptive_image = isset( $_POST['wfc_adaptive_image']) ? $_POST['wfc_adaptive_image'] : '';
				
				update_post_meta(
		            $post_id,
		            'wfc_heroimages_small',
		           	$wfc_heroimages_small
		        );
		        update_post_meta(
		            $post_id,
		            'wfc_heroimages_small_width',
		           	$wfc_heroimages_small_width
		        );
		        update_post_meta(
		            $post_id,
		            'wfc_heroimages_small_height',
		           	$wfc_heroimages_small_height
		        );

		        update_post_meta(
		            $post_id,
		            'wfc_heroimages_medium',
		           	$wfc_heroimages_medium
		        );
		        update_post_meta(
		            $post_id,
		            'wfc_heroimages_medium_width',
		           	$wfc_heroimages_medium_width
		        );
		        update_post_meta(
		            $post_id,
		            'wfc_heroimages_medium_height',
		           	$wfc_heroimages_medium_height
		        );

		        update_post_meta(
		            $post_id,
		            'wfc_heroimages_large',
		           	$wfc_heroimages_large
		        );
		        update_post_meta(
		            $post_id,
		            'wfc_heroimages_large_width',
		           	$wfc_heroimages_large_width
		        );
		        update_post_meta(
		            $post_id,
		            'wfc_heroimages_large_height',
		           	$wfc_heroimages_large_height
		        );
				
				update_post_meta(
		            $post_id,
		            'wfc_hero_type',
		           	$wfc_hero_type
		        );				
				update_post_meta(
		            $post_id,
		            'wfc_hero_cta_url',
		           	$wfc_hero_cta_url
		        );
				update_post_meta(
		            $post_id,
		            'wfc_hero_cta_label',
		           	$wfc_hero_cta_label
		        );
				update_post_meta(
		            $post_id,
		            'wfc_adaptive_image',
		           	$wfc_adaptive_image
		        );
			}
		}

		/**
		 * Save the custom fields added to the metabox.
		 *
		 * @param      int  $post_id    The post identifier
		 * @param      object  $post_data  The post data
		 */
		public function wfc_hero_save_custom_fields( $post_id, $post_data ) {
			$config = array(
				'wfc_heroimages_small-xpos',
				'wfc_heroimages_small-ypos',
				'wfc_heroimages_medium-xpos',
				'wfc_heroimages_medium-ypos',
				'wfc_heroimages_large-xpos',
				'wfc_heroimages_large-ypos'
			);

			foreach ( $config as $key => $val ) {
				update_post_meta( 
					$post_id, 
					$val, 
					( isset( $post_data[ $val ] ) ? $post_data[ $val ] : '' )
				);
			}
		}

		/**
		 * The horizontal and vertical custom fields to the metabox on sm
		 */
		public function wfc_hero_append_sm_ctrl( $output, $post ) {

			$config = array(
				'Horizontal' => array(
					'key'		=> 'small-xpos',
					'value'		=> get_post_meta( $post->ID, 'wfc_heroimages_small-xpos', true )
				),
				'Vertical'	=> array(
					'key'		=> 'small-ypos',
					'value'		=> get_post_meta( $post->ID, 'wfc_heroimages_small-ypos', true )
				)
			);

			return $this->wfc_render_heroimage_metabox_ctrls( $config );
		}

		/**
		 * The horizontal and vertical custom fields to the metabox on md
		 */
		public function wfc_hero_append_md_ctrl( $output, $post ) {

			$config = array(
				'Horizontal' => array(
					'key'		=> 'medium-xpos',
					'value'		=> get_post_meta( $post->ID, 'wfc_heroimages_medium-xpos', true )
				),
				'Vertical'	=> array(
					'key'		=> 'medium-ypos',
					'value'		=> get_post_meta( $post->ID, 'wfc_heroimages_medium-ypos', true )
				)
			);

			return $this->wfc_render_heroimage_metabox_ctrls( $config );
		}

		/**
		 * The horizontal and vertical custom fields to the metabox on lg
		 */
		public function wfc_hero_append_lg_ctrl( $output, $post ) {

			$config = array(
				'Horizontal' => array(
					'key'		=> 'large-xpos',
					'value'		=> get_post_meta( $post->ID, 'wfc_heroimages_large-xpos', true )
				),
				'Vertical'	=> array(
					'key'		=> 'large-ypos',
					'value'		=> get_post_meta( $post->ID, 'wfc_heroimages_large-ypos', true )
				)
			);

			return $this->wfc_render_heroimage_metabox_ctrls( $config );
		}

		/**
		 * Render the metabox controls.
		 *
		 * @param      array  $config  The configuration
		 *
		 * @return     string  HTML Output of the custom fields.
		 */
		public function wfc_render_heroimage_metabox_ctrls( $config ) {
            $output = '';
            
            $config['Horizontal']['settings'] = array(
                ''      => '--Select--', 
                'top'   => 'Top', 
                '25%'   => '25%', 
                'center'=> 'Center', 
                '75%'   => '75%', 
                'bottom'=> 'Bottom'
            );
            
            $config['Vertical']['settings'] = array(
                ''      => '--Select--', 
                'left'  => 'left', 
                '25%'   => '25%', 
                'center'=> 'Center', 
                '75%'   => '75%', 
                'right' => 'Right'
            );
            
            foreach($config as $c_key => $c_val) {
                $output .= '<label class="wfc-heroimages-pos-ctrl">';
                    $output .= $c_key;
                    $output .= '<select name="wfc_heroimages_' . $c_val['key'] . '" class="wfc-heroimages-' . $c_val['key'] . '">';
                        foreach($c_val['settings'] as $set_key => $set_val) {
                            $output .= '<option value="'. $set_key .'" '. selected( $c_val['value'], $set_key, false ) .'>'. $set_val .'</option>';
                        }
                    $output .= '</select>';
                $output .= '</label>';
            }
            
            return $output;
        }

        /**
		 * A helper function for getting the url from the post meta boxes
		 * 
		 * @param int $post_id The post id
		 * @param string $size The size to use for the image
		 * 
		 * @return string $wfc_heroimages_url The url of the image
		 */
		public static function get_wfc_hero_meta_img_url( $post_id, $size ) {
		    $wfc_heroimages_url = '';
		    
		    if ($size == 'small') {
				$wfc_heroimages_url = get_post_meta($post_id, 'wfc_heroimages_small', true);
			} elseif($size == 'medium') {
				$wfc_heroimages_url = get_post_meta($post_id, 'wfc_heroimages_medium', true);
			}else{
				$wfc_heroimages_url = get_post_meta($post_id, 'wfc_heroimages_large', true);
			}
            
            return $wfc_heroimages_url;
		}

		/**
		 * Fetch and return the hero images url base on the param given.
		 * 
		 * @param      int 								$post_id 			The post id
		 * @param      string(small, medium, large) 	$size 				Optional. The size to use for the image.
		 * 
		 * @return     string 							$wfc_heroimages_url	The url of the image.
		 */				
		public static function get_img_url( $post_id, $size = 'large' ) {

			// Get the image url from the local post
			$wfc_img_url = self::get_wfc_hero_meta_img_url( $post_id, $size );

			// Get the image from the parent post if there is no hero image set on the local post
			if ( empty( $wfc_img_url ) ) {
				$post_parent_id = wp_get_post_parent_id( $post_id );

				if ( $post_parent_id != 0 && $post_parent_id != false ) {
					$wfc_img_url = self::get_wfc_hero_meta_img_url( $post_parent_id, $size ); 
				}
			}

			// Get the image using get_page_by_path($post->post_type) if there is no hero image set on the parent post
			if ( empty( $wfc_img_url ) ) {

				if ( is_archive() ) {
					global $post_type;
					
					$archive_page = get_page_by_path( $post_type );

					if ( ! empty( $archive_page ) ) {
						$wfc_img_url = self::get_wfc_hero_meta_img_url( $archive_page->ID, $size );
					}
					
				} elseif ( is_search() ) {
					$post_type = 'search';
					$search_page = get_page_by_path( $post_type );

					if ( ! empty( $search_page ) ) {
						$wfc_img_url = self::get_wfc_hero_meta_img_url( $search_page->ID, $size );
					}
				} elseif ( is_home() ) {
					$blog_page = get_option( 'page_for_posts' );

					if ( $blog_page ) {
						$wfc_img_url = self::get_wfc_hero_meta_img_url( $blog_page, $size );
					}
				} else {
					$post_type = get_post_type( $post_id );
					$same_page = get_page_by_path( $post_type );

					if ( ! empty( $same_page ) ) {
						$wfc_img_url = self::get_wfc_hero_meta_img_url( $same_page->ID, $size );
					}
				}
			}

			// Get the image from the front page if there is no image set from using get_page_by_path($post->post_type)
			if ( empty( $wfc_img_url ) ) {
			    
				$frontpage_id = get_option( 'page_on_front' );
				
				if ( ! empty( $frontpage_id ) ) {
					$wfc_img_url = self::get_wfc_hero_meta_img_url( $frontpage_id, $size );	
				}
			}

			// Get the image from the customizer if there is no image set from the front page
			if ( empty( $wfc_img_url ) ) {
				$wfc_img_url = get_theme_mod( 'default_image' );
			}

			//Get the image from the included default if there is no image set from the customizer
		   if ( empty( $wfc_img_url ) ) {
				$wfc_img_url = WFCT_IMG_URL . 'fail-graceful-large.png';
			}

			return $wfc_img_url;
		}

		/**
         *  This is a fork of WFC_Hero_Images::get_img_url
         *  @param  $post_id int                             required    the post id.
         *  @param  $pos     string(x, y)                    optional    the position to retrieve.
         *  @param  $size    string(small, medium, large)    optional    the image size position.
         *  @return string   the image position.
         */
        public static function get_img_pos( $post_id, $pos = 'x', $size = 'large', $de = 'center' ) {
          	
            $orientation = '';

			// get pos on the Post
			$orientation = get_post_meta( $post_id, "wfc_heroimages_{$size}-{$pos}pos", true );
			
			// get from parent post
			if ( empty( $orientation ) ) {
				$post_parent_id = wp_get_post_parent_id( $post_id );
				
				if ( $post_parent_id != 0 && $post_parent_id != false ) {
					$orientation = get_post_meta( $post_parent_id, "wfc_heroimages_{$size}-{$pos}pos", true );
				}
			}

			// get from post with same slug
			if ( empty( $orientation ) ) {
				
				global $wp_query;

				if ( is_post_type_archive() ) {
					$post_type = $wp_query->query;
					$post_type = $post_type['post_type'];
					$archive_page = get_page_by_path( $post_type );

					if ( ! empty( $archive_page ) ) {
						$orientation = get_post_meta( $archive_page->ID, 'wfc_heroimages_{$size}-{$pos}pos', true );
					}
				} elseif ( is_search() ) {
					$post_type = 'search';
					$search_page = get_page_by_path( $post_type );

					if ( ! empty( $search_page ) ) {
						$orientation = get_post_meta( $search_page->ID, 'wfc_heroimages_{$size}-{$pos}pos', true );
					}
				} else {
					$post_type = get_post_type( $post_id );
					$same_page = get_page_by_path( $post_type );

					if ( ! empty( $same_page ) ) {
						$orientation = get_post_meta( $same_page->ID, 'wfc_heroimages_{$size}-{$pos}pos', true );
					}
				}
			}

			// get from front page
			if ( empty( $orientation ) ) {
				$frontpage_id = get_option( 'page_on_front' );
				
		 		if ( $frontpage_id ) {
					$orientation = get_post_meta( $frontpage_id, 'wfc_heroimages_{$size}-{$pos}pos', true );
				}
			}
			
			// default position
			if ( empty( $orientation ) ) {
				$orientation = $de;
			}
            
			return $orientation; 
        }

        /**
		 * Save the revision of the heroimages meta
		 */
		public function wfc_hero_save_revision( $post_id ) {

			$is_revision = wp_is_post_revision( $post_id );

			if ( $is_revision ) {
				$tracked_metas = array( 'wfc_heroimages_small', 'wfc_heroimages_medium', 'wfc_heroimages_large' );
				$original_post = get_post( $is_revision );
				$metas_to_insert = array();

				foreach ( $tracked_metas as $meta ) {
					$metas_to_insert[$meta] = get_post_meta( $original_post->ID, $meta, true );
				}

				foreach ($metas_to_insert as $key => $meta_value) {
					if ( false !== $meta_value ) {
						$test = add_metadata( 'post', $post_id, $key, $meta_value );
					}					
				}
			} 
		}

		/**
		 * Revert to correct revision of the meta field when post is reverted
		 */
		public function wfc_hero_restore_revision( $post_id, $revision_id ) {
			$post = get_post( $post_id );
			$revision = get_post( $revision_id );
			$tracked_metas = array( 'wfc_heroimages_small', 'wfc_heroimages_medium', 'wfc_heroimages_large' );
			$metas_from_revision = array();

			foreach ( $tracked_metas as $meta ) {
				$metas_from_revision[$meta] = get_metadata( 'post', $revision->ID, $meta, true );
			}

			foreach ( $metas_from_revision as $key => $meta_value ) {
				if ( false !== $meta_value ) {
					update_post_meta( $post_id, $key, $meta_value );
				} else {
					delete_post_meta( $post_id, $key );
				}
			}
		}

		/**
		 * Display the meta on the revisions screen
		 * 
		 * @return array The revision fields to display
		 */
		public function wfc_hero_revision_fields( $fields ) {

			$tracked_metas = array( 
				'wfc_heroimages_small' => 'WFC HeroImages - Small',
				'wfc_heroimages_medium' => 'WFC HeroImages - Medium',
				'wfc_heroimages_large' => 'WFC HeroImages - Large'
			);

			foreach ( $tracked_metas as $key => $meta ) {
				$fields[$key] = $meta;
			}

			return $fields;
		}

		/**
		 * Display the wfc_heroimages_small meta field on the revisions screen
		 * 
		 * @return string The metadata value
		 */
		public function wfc_hero_revision_field_heroimages_small( $value, $field, $post ) {

			return get_metadata( 'post', $post->ID, 'wfc_heroimages_small', true );
		}

		/**
		 * Display the wfc_heroimages_medium meta field on the revisions screen
		 * 
		 * @return string The metadata value
		 */
		public function wfc_hero_revision_field_heroimages_medium( $value, $field, $post ) {

			return get_metadata( 'post', $post->ID, 'wfc_heroimages_medium', true );
		}

		/**
		 * Display the wfc_heroimages_large meta field on the revisions screen
		 * 
		 * @return string The metadata value
		 */
		public function wfc_hero_revision_field_heroimages_large( $value, $field, $post ) {

			return get_metadata( 'post', $post->ID, 'wfc_heroimages_large', true );
		}

	}
}

new WFC_Hero_Images();
