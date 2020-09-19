<?php

defined('ABSPATH') or die('No script kiddie please!');

if (! class_exists('ASCM_Panels_Renderer')) {
	/**
	* Class ASCM_Panels_Renderer
	* Class for handling rendering functionalities on the template
	*
	* @author Junjie Canonio <junjie@alphasys.com.au>
	* @since  1.0.0
	* @LastUpdated  April 10, 2019
	*/
	class ASCM_Panels_Renderer{
		
		/**
		 * Initializes values and resources needed.
		 * LastUpdated : April 10, 2019
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 * @since  1.0.0
		 */
		public function __construct() {
		}
		
		/**
		 * Enqueues styles and scripts
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array  $styles   Array of styles slug name
		 * @param  array  $scripts  Array of scripts slug name
		 *
		 * @since  1.0.0
         *
         * @LastUpdated  April 10, 2019
		 */
		public static function enqueue_styles_scripts($styles, $scripts) {

			wp_register_script( 
				'ascm-panels-public-js', 
				plugin_dir_url( __FILE__ ) . '../../public/js/ascm-panels-public.js', 
				array( 'jquery' ), 
				'', 
				false 
			);

			if (is_array($styles) && ! empty($styles)) {
				foreach ($styles as $style) {
					wp_enqueue_style($style);
				}
			}

			if (is_array($scripts) && ! empty($scripts)) {
				foreach ($scripts as $script) {
					wp_enqueue_script($script);
				}
			}
		}
		
		/**
		 * Renders the panel custom CSS inside style tag
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
		 *
		 * @since  1.0.0
         *
         * @LastUpdated  April 15, 2019
		 */
		public static function render_customstyle($panel) {

			$panel_id = $panel['data']['post']->ID;
			?>
			<style id="<?php echo 'ascm-panel-customstyle-'.$panel_id.'-CSS'; ?>" type="text/css"><?php echo $panel['data']['standard']['csscode']; ?></style>
			<?php
		}
		
		/**
		 * Renders the panel background CSS inside style tag
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   April 15, 2019
		 */
		public static function render_backgroundstyle($panel) {

			$panel_id = $panel['data']['post']->ID;
			$panel_cont_class = '.ascm-panels-main-cont-'.$panel_id;
            $panel_sub_cont_class = '.ascm-panels-sub-cont-'.$panel_id;

			$post_thumbnail_url = get_the_post_thumbnail_url($panel_id, 'full');

			$displayclildrenas = isset($panel['data']['standard']['displayclildrenas']) ? $panel['data']['standard']['displayclildrenas'] : 'donothing';
			$displaytype = isset($panel['data']['standard']['displaytype']) ? $panel['data']['standard']['displaytype'] : 'fullwdth';

			$bg_img_opcty = isset($panel['data']['standard']['bg_img_opcty']) ? $panel['data']['standard']['bg_img_opcty'] : '1';

			$bg_img_anchor_hor = 
			isset($panel['data']['standard']['bg_img_anchor_hor']) ? $panel['data']['standard']['bg_img_anchor_hor'] : 'horizontal-center';

			$bg_img_anchor_ver = 
			isset($panel['data']['standard']['bg_img_anchor_ver']) ? $panel['data']['standard']['bg_img_anchor_ver'] : 'vertical-center';	

			$bg_clr = 
			isset($panel['data']['standard']['bg_clr']) ? $panel['data']['standard']['bg_clr'] : 'transparent';

            $max_width = '1100px';
            $padding = '0px';
            if (has_action('genesis_init')) {
                $max_width = get_theme_mod( 'max_row_width' );
	            $padding = '30px';
            }

			?>
			<style id="<?php echo 'ascm-panel-backgroundstyle-'.$panel_id.'-CSS'; ?>" type="text/css">
				<?php echo $panel_cont_class; ?> {
					position: relative;
				    background: <?php echo $bg_clr; ?>;
				}

				<?php echo $panel_cont_class.':before'; ?>{
				    content: ' ';
				    display: block;
				    position: absolute;
				    height: 100%;
				    z-index: 1;
				    opacity: <?php echo $bg_img_opcty; ?>;
				    background-image: url('<?php echo $post_thumbnail_url; ?>');
					background-position-x: <?php echo $bg_img_anchor_hor; ?>;
					background-position-y: <?php echo $bg_img_anchor_ver; ?>;
				    background-repeat: no-repeat;
				    -ms-background-size: cover;
				    -o-background-size: cover;
				    -moz-background-size: cover;
				    -webkit-background-size: cover;
				    background-size: cover;
                    <?php if($displaytype == 'containedimgandcont'): ?>
                    max-width: <?php echo $max_width; ?>;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    margin: auto;
                    <?php else: ?>
                    left: 0;
                    top: 0;
                    width: 100%;
                    <?php endif; ?>
				}

                #ascm-panels-genesisbeforeentry-cont <?php echo $panel_cont_class.':before'; ?>,
                #ascm-panels-genesisbeforeentry-cont <?php echo $panel_cont_class.':before'; ?>,
                #ascm-panels-genesisafterentry-cont <?php echo $panel_cont_class.':before'; ?> {
                    width: 100%;
                }

                <?php if($displayclildrenas == 'donothing') : ?>

                    <?php echo $panel_sub_cont_class; ?> {
                        position: relative;
                        z-index: 2;
                        <?php if($displaytype == 'fullwdthbgimgcontainedcont'): ?>                        
                        padding: 15px;
                        margin-left: auto;
                        margin-right: auto;
                        max-width: <?php echo $max_width; ?>;
                        <?php elseif($displaytype == 'containedimgandcont'): ?>
                        padding: 15px;
                        margin-left: auto;
                        margin-right: auto;
                        max-width: <?php echo $max_width; ?>;
                        <?php else: ?>
                        padding: 0;
                        margin-left: 0;
                        margin-right: 0;
                        max-width: 100%;
                        <?php endif; ?>
                    }

                    @media (min-width: 768px) {
                        <?php echo $panel_sub_cont_class; ?> {
                            padding-top: 20px;
                            padding-bottom: 20px;
                        }
                    }

                    @media (min-width: 992px) {
                        <?php echo $panel_sub_cont_class; ?> {
                            padding-top: <?php echo $padding; ?>;
                            padding-bottom: <?php echo $padding; ?>;
                        }
                    }

                    @media (min-width: 1200px) {
                        <?php echo $panel_sub_cont_class; ?> {
                            padding-top: <?php echo $padding; ?>;
                            padding-bottom: <?php echo $padding; ?>;
                        }
                    }
                <?php else: ?>
                    <?php echo $panel_sub_cont_class; ?> {
                        position: relative;
                        z-index: 2;
                        <?php if($displaytype == 'fullwdthbgimgcontainedcont'): ?>
                        margin-left: auto;
                        margin-right: auto;
                        max-width: <?php echo $max_width; ?>;
                        <?php elseif($displaytype == 'containedimgandcont'): ?>
                        margin-left: auto;
                        margin-right: auto;
                        max-width: <?php echo $max_width; ?>;
                        <?php else: ?>
                        margin-left: 0;
                        margin-right: 0;
                        max-width: 100%;
                        <?php endif; ?>
                    }
                <?php endif; ?>

			</style>
			<?php
		}
		
		/**
		 * Renders the panel half image recipe CSS inside style tag
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
		 * @since  1.0.0
         *
         *
         * @LastUpdated   May 14, 2019
		 */
		public static function render_halfimage_recipe_style($panel) {
			$panel_id = $panel['data']['post']->ID;
			$panel_main_cont_class = '.ascm-panels-main-cont-'.$panel_id;
			$panel_sub_cont_class = '.ascm-panels-sub-cont-'.$panel_id;

			$displaytype = isset($panel['data']['standard']['displaytype']) ? $panel['data']['standard']['displaytype'] : 'fullwdth';

			$halfimage_image = isset($panel['data']['standard']['halfimage_image']) ? $panel['data']['standard']['halfimage_image'] : '';
			$halfimage_image = wp_get_attachment_image_src($halfimage_image, 'full');
            $halfimage_image = isset($halfimage_image[0]) ? $halfimage_image[0] : '';

			$halfimage_containedimage = isset($panel['data']['standard']['halfimage_containedimage']) ? $panel['data']['standard']['halfimage_containedimage'] : 'off';

			$halfimage_imageposition = isset($panel['data']['standard']['halfimage_imageposition']) ? $panel['data']['standard']['halfimage_imageposition'] : 'left';

			$background_position_x = 'right';
			$content_padding = '0px 0px 0px 20px';
			if ($halfimage_imageposition == 'right') {
				$background_position_x = 'left';
                $content_padding = '0px 20px 0px 0px';
			}
			
			$max_width = '1100px';
			if (has_action('genesis_init')) {
				$max_width = get_theme_mod( 'max_row_width' );
			}

			?>
			<style id="<?php echo 'ascm-panel-halfimage-recipe-style-'.$panel_id.'-CSS'; ?>" type="text/css">
                <?php if($halfimage_containedimage != 'on'): ?>

                <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-main-cont {
                    pointer-events: none;
                    display: flex;

                    <?php if($displaytype == 'fullwdthbgimgcontainedcont'): ?>
                    margin-left: auto;
                    margin-right: auto;
                    <?php elseif($displaytype == 'containedimgandcont'): ?>
                    margin-left: auto;
                    margin-right: auto;
                    max-width: <?php echo $max_width; ?>;
                    <?php else: ?>
                    padding: 0;
                    margin-left: 0;
                    margin-right: 0;
                    max-width: 100%;
                    <?php endif; ?>

                    content: ' ';
                    position: absolute;
                    height: 100%;
                    z-index: 2;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    margin: auto;
                }

                <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont:before {
                    content: ' ';
                    display: block;
                    position: absolute;
                    left: 0;
                    <?php if ($halfimage_imageposition == 'right') : ?>
                    bottom: 0;
                    <?php else : ?>
                    top: 0;
                    <?php endif; ?>
                    width: 100%;
                    height: 250px;
                    z-index: 2;
                    background-image: url('<?php echo $halfimage_image; ?>');
                    background-position-x: <?php echo $background_position_x; ?>;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    -ms-background-size: cover;
                    -o-background-size: cover;
                    -moz-background-size: cover;
                    -webkit-background-size: cover;
                    background-size: cover;
                }

                @media (min-width: 768px) {
                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont {
                        pointer-events: none;
                        position: absolute;
                        content: ' ';
                        width: 100%;
                        height: 400px;
                        <?php if ($halfimage_imageposition == 'right') : ?>
                        right: 0;
                        bottom: 0;
                        <?php else : ?>
                        top: 0;
                        left: 0;
                        <?php endif; ?>
                    }

                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont:before {
                        content: ' ';
                        display: block;
                        position: absolute;
                        left: 0;
                        <?php if ($halfimage_imageposition == 'right') : ?>
                        bottom: 0;
                        <?php else : ?>
                        top: 0;
                        <?php endif; ?>
                        width: 100%;
                        height: 100%;
                        z-index: 2;
                        background-image: url('<?php echo $halfimage_image; ?>');
                        background-position-x: <?php echo $background_position_x; ?>;
                        background-position-y: center;
                        background-repeat: no-repeat;
                        -ms-background-size: cover;
                        -o-background-size: cover;
                        -moz-background-size: cover;
                        -webkit-background-size: cover;
                        background-size: cover;
                    }

                }

                @media (min-width: 992px) {
                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedcont-cont,
                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont {
                        content: ' ';
                        width: 50%;
                        height: 100%;
                    }

                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont {
                        position: relative;
                    }

                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont:before {
                        content: ' ';
                        display: block;
                        position: absolute;
                        <?php if ($halfimage_imageposition == 'right') : ?>
                        right: 0;
                        <?php else : ?>
                        left: 0;
                        <?php endif; ?>
                        top: 0;
                        width: 100%;
                        height: 100%;
                        z-index: 2;
                        background-image: url('<?php echo $halfimage_image; ?>');
                        background-position-x: <?php echo $background_position_x; ?>;
                        background-position-y: center;
                        background-repeat: no-repeat;
                        -ms-background-size: cover;
                        -o-background-size: cover;
                        -moz-background-size: cover;
                        -webkit-background-size: cover;
                        background-size: cover;
                    }

                }

                @media (min-width: 1200px) {
                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-main-cont {
                        pointer-events: none;
                        display: flex;

                        <?php if($displaytype == 'fullwdthbgimgcontainedcont'): ?>
                        margin-left: auto;
                        margin-right: auto;
                        <?php elseif($displaytype == 'containedimgandcont'): ?>
                        margin-left: auto;
                        margin-right: auto;
                        max-width: <?php echo $max_width; ?>;
                        <?php else: ?>
                        margin-left: 0;
                        margin-right: 0;
                        max-width: 100%;
                        <?php endif; ?>

                        content: ' ';
                        position: absolute;
                        height: 100%;
                        z-index: 2;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        margin: auto;
                    }


                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedcont-cont,
                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont {
                        content: ' ';
                        width: 50%;
                        height: 100%;
                    }

                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont {
                        position: relative;
                    }

                    <?php echo $panel_main_cont_class; ?> .ascm-panels-halfimage-notcontaindedimage-cont:before {
                        content: ' ';
                        display: block;
                        position: absolute;
                        <?php if ($halfimage_imageposition == 'right') : ?>
                        right: 0;
                        <?php else : ?>
                        left: 0;
                        <?php endif; ?>
                        top: 0;
                        width: 100%;
                        height: 100%;
                        z-index: 2;
                        background-image: url('<?php echo $halfimage_image; ?>');
                        background-position-x: <?php echo $background_position_x; ?>;
                        background-position-y: center;
                        background-repeat: no-repeat;
                        -ms-background-size: cover;
                        -o-background-size: cover;
                        -moz-background-size: cover;
                        -webkit-background-size: cover;
                        background-size: cover;
                    }

                }
                <?php endif; ?>


				<?php echo $panel_sub_cont_class; ?> {

					display: block;

                    <?php if($displaytype == 'fullwdthbgimgcontainedcont'): ?>
                    margin-left: auto;
                    margin-right: auto;
                    max-width: <?php echo $max_width; ?>;
                    <?php elseif($displaytype == 'containedimgandcont'): ?>
                    margin-left: auto;
                    margin-right: auto;
                    max-width: <?php echo $max_width; ?>;
                    <?php else: ?>
                    margin-left: 0;
                    margin-right: 0;
                    max-width: 100%;
                    <?php endif; ?>

				}

				<?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-image-cont:before {
				    content: ' ';
				    display: block;
				    position: absolute;
				    left: 0;
				    top: 0;
				    width: 100%;
				    height: 100%;
				    z-index: 2;
				    background-image: url('<?php echo $halfimage_image; ?>');
					background-position-x: <?php echo $background_position_x; ?>;
					background-position-y: center;
				    background-repeat: no-repeat;
				    -ms-background-size: cover;
				    -o-background-size: cover;
				    -moz-background-size: cover;
				    -webkit-background-size: cover;
				    background-size: cover;
				}

                <?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-image-cont {
                     width: 100%;
                     position: relative;
                     z-index: 2;
                     opacity: <?php echo $halfimage_containedimage != 'on' ? 0 : 1; ?>;
                     height: 250px;
                }

                <?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-content-cont {
                     width: 100%;
                     padding: 0px 0px 0px 0px;
                     z-index: 2;
                }

                @media (min-width: 768px) {
                    <?php echo $panel_sub_cont_class; ?> {
                        display: block;
                    }

                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-image-cont {
                        width: 100%;
                        height: 400px;
                    }

                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-content-cont {
                        width: 100%;
                        padding: 0px 0px 0px 0px;
                    }
                }

                @media (min-width: 992px) {
                    <?php echo $panel_sub_cont_class; ?> {
                        display: flex;
                    }

                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-image-cont {
                        width: 50%;
                        height: auto;
                    }

                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-content-cont {
                        width: 50%;
                        padding: <?php echo $content_padding; ?>;
                    }
                }

                @media (min-width: 1200px) {
                    <?php echo $panel_sub_cont_class; ?> {
                        display: flex;
                    }

                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-image-cont {
                        width: 50%;
                        height: auto;
                    }

                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-halfimage-content-cont {
                        width: 50%;
                        padding: <?php echo $content_padding; ?>;
                    }
                }

			</style>
			<?php
		}
		
		/**
		 * Renders the half image non contained image.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   April 10, 2019
		 */
		public static function render_halfimage_uncontainedimg($panel){
			$halfimage_imageposition = isset($panel['data']['standard']['halfimage_imageposition']) ? $panel['data']['standard']['halfimage_imageposition'] : 'left';
			$halfimage_containedimage = isset($panel['data']['standard']['halfimage_containedimage']) ? $panel['data']['standard']['halfimage_containedimage'] : 'off';
		    ?>

			<?php if($halfimage_imageposition == 'left' && $halfimage_containedimage != 'on') : ?>
                <div class="col-sm col-md col-lg ascm-panels-halfimage-notcontaindedimage-main-cont">
                    <div class="ascm-panels-halfimage-notcontaindedimage-cont"></div>
                    <div class="ascm-panels-halfimage-notcontaindedcont-cont"></div>
                </div>
			<?php endif; ?>

			<?php if($halfimage_imageposition == 'right' && $halfimage_containedimage != 'on') : ?>
                <div class="col-sm col-md col-lg ascm-panels-halfimage-notcontaindedimage-main-cont">
                    <div class="ascm-panels-halfimage-notcontaindedcont-cont"></div>
                    <div class="ascm-panels-halfimage-notcontaindedimage-cont"></div>
                </div>
			<?php endif; ?>

            <?php
		}
		
		/**
		 * Renders the title of the panel.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   April 10, 2019
		 */
		public static function render_title($panel) {

			$panel_id = isset($panel['id']) ? $panel['id'] : '';
			$title = isset($panel['data']['post']->post_title) ? $panel['data']['post']->post_title : '';
			$hidetitle = isset($panel['data']['standard']['hidetitle']) ? $panel['data']['standard']['hidetitle'] : '';

			if ($hidetitle != 'on') {
				?> 
				<h2 id="<?php echo 'ascm-panels-content-'.$panel_id ?>"><?php echo $title; ?></h2>
				<?php
			}

		}
		
		/**
		 * Renders the content of the panel.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   April 10, 2019
		 */
		public static function render_content($panel) {

			$panel_id = isset($panel['id']) ? $panel['id'] : '';

			$displayclildrenas = isset($panel['data']['standard']['displayclildrenas']) ? $panel['data']['standard']['displayclildrenas'] : 'donothing';
			
			$content = isset($panel['data']['post']->post_content) ? $panel['data']['post']->post_content : '';

            $content = apply_filters( 'the_content', $content );

			if ($displayclildrenas != 'donothing') {

				$panelchildren = array();

				// Query all ASCM Panels custom post 
				$query = new WP_Query(
				    array(
				      'post_type' => 'ascm_panels',
				      'post_status' => 'publish',
				      'posts_per_page' => -1,
				      'post_parent' => $panel_id
				    )
				);
				$ascm_panels_available = isset($query->posts) ?  $query->posts : array();
				foreach ($ascm_panels_available as $key => $value) {
					$panelchildren[$value->ID] = $value->menu_order;
				}
				asort($panelchildren);

				?>
                <div id="<?php echo 'ascm-panels-content-'.$panel_id; ?>" class="ascm-panels-parent-content <?php echo 'ascm-panels-content-'.$panel_id; ?>"><?php echo $content; ?></div>

				<div id="<?php echo 'ascm-panels-content-'.$panel_id; ?>" class="panel-content <?php echo 'ascm-panels-content-'.$panel_id; ?>">

					<?php if ($displayclildrenas == 'slider'): ?>
					<?php
						wp_enqueue_style(
							'ascm-panels-fontawesome-css',
							'https://use.fontawesome.com/releases/v5.8.1/css/all.css',
							array(),
							'',
							'all'
						);

						wp_enqueue_style('ascm-owlcarousel-css');
						wp_enqueue_style('ascm-owlcarousel-theme-css');
						wp_enqueue_script('ascm-owlcarousel-js');
					?>
						<div id="<?php echo 'ascm-panels-carousel-'.$panel_id.rand(0,999999999); ?>" class="ascm-owl-carousel-cont owl-carousel" ascm-carousel-id="true">
							<?php foreach ($panelchildren as $key => $value) : ?>
								<div id="<?php echo 'ascm-panels-childeasslide-'.$key; ?>" class="<?php echo 'ascm-panels-childeasslide-'.$key; ?>">
									<?php echo '[ascm-panels id='.$key.']'; ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>	


					<?php if ($displayclildrenas == 'tiles'): ?>
						<?php foreach ($panelchildren as $key => $value) : ?>
							<div id="<?php echo 'ascm-panels-childeastiles-'.$key; ?>" class="<?php echo 'ascm-panels-childeastiles-'.$key; ?>">
								<?php echo '[ascm-panels id='.$key.']'; ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

				</div>
				<?php

			}else{

                ?> 
                <div id="<?php echo 'ascm-panels-content-'.$panel_id; ?>" class="panel-content <?php echo 'ascm-panels-content-'.$panel_id; ?>"><?php echo $content; ?></div>
                <?php

            }

		}
		
		/**
		 * Renders the call to action button link of the panel
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   April 10, 2019
		 */
		public static function render_cta_link($panel) {
			$cta_url = 
			isset($panel['data']['standard']['cta_url']) ? 
			$panel['data']['standard']['cta_url'] : '';

			$cta_wrapppanel = 
			isset($panel['data']['standard']['cta_wrapppanel']) ? 
			$panel['data']['standard']['cta_wrapppanel'] : '';

			$cta_btntext = 
			isset($panel['data']['standard']['cta_btntext']) ? 
			$panel['data']['standard']['cta_btntext'] : '';

			if (!empty($cta_btntext)) {
                if ( $cta_wrapppanel !== 'on' ) {
                ?> 
                    <a href="<?php echo $cta_url; ?>" class="cta btn btn-primary"><?php echo $cta_btntext; ?></a>
                <?php
                } else {
                ?>
                    <span class="cta btn btn-primary"><?php echo $cta_btntext; ?></span>
                <?php    
                }
			}
		}
		
		/**
		 * Renders the list of recent posts of the panel that is using Recent Posts recipe.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $panel
		 * @param $recent_posts
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   May 17, 2019
		 */
		public static function render_recent_posts_list( $panel, $recent_posts ) {
			$panel_id = isset($panel['id']) ? $panel['id'] : '';

			$recentposts_category = isset($panel['data']['standard']['recentposts_category']) ? $panel['data']['standard']['recentposts_category'] : '';
			$recentposts_maxnumofitems = isset($panel['data']['standard']['recentposts_maxnumofitems']) ? $panel['data']['standard']['recentposts_maxnumofitems'] : '9';
			$recentposts_itemsperrowlrg = isset($panel['data']['standard']['recentposts_itemsperrowlrg']) ? $panel['data']['standard']['recentposts_itemsperrowlrg'] : 'fourperrow';
			$recentposts_itemsperrowmed = isset($panel['data']['standard']['recentposts_itemsperrowmed']) ? $panel['data']['standard']['recentposts_itemsperrowmed'] : 'twoperrow';

			if ($recentposts_itemsperrowlrg == 'fourperrow'){
				$grid_class_lrg = 'col-lg-3 .col-xl-3';
            }elseif ($recentposts_itemsperrowlrg == 'threeperrow'){
				$grid_class_lrg = 'col-lg-4 col-xl-4';
            }elseif ($recentposts_itemsperrowlrg == 'twoperrow'){
				$grid_class_lrg = 'col-lg-6 col-xl-6';
            }else{
				$grid_class_lrg = 'col-lg-12 col-xl-12';
            }

			if ($recentposts_itemsperrowmed == 'twoperrow'){
				$grid_class_med = 'col-sm-6 col-md-6';
			}else{
				$grid_class_med = 'col-sm-12 col-md-12';
			}

			$grid_class = 'col-12 '.$grid_class_med.' '.$grid_class_lrg;
			
			$card_type = isset($panel['data']['custom']['ascm-panels-card-overwrite'][0]) ? $panel['data']['custom']['ascm-panels-card-overwrite'][0] : '';
			$card_file = sprintf( '%s/%s.php', wfc_get_cards_dir(), $card_type );
			$file_exists = file_exists ( $card_file );
			
			?>
            <div id="<?php echo 'ascm-panels-recentpostslist-'.$panel_id; ?>" class="row ascm-panels-recentpostslist-cont <?php echo 'ascm-panels-recentpostslist-'.$panel_id; ?>">
                <?php foreach ($recent_posts as $key => $value):
                    $recentpost_id = isset($value->ID) ? $value->ID : '';
                    $recentpost_title = isset($value->post_title) ? $value->post_title : '';
	                $recentpost_title = mb_strimwidth($recentpost_title, 0, 30, '...');
                    $recentpost_thumbnail_url = get_the_post_thumbnail_url($recentpost_id, 'full');
	                $recentpost_thumbnail_url = !empty($recentpost_thumbnail_url) ? $recentpost_thumbnail_url : 'https://via.placeholder.com/600x400';
                    $recentpost_content = isset($value->post_content) ? $value->post_content : '';
                    $recentpost_content = wp_trim_words($recentpost_content, 20);
                    $recentpost_permalink = get_permalink($recentpost_id);

                ?>
				<div id="<?php esc_html_e( 'ascm-panels-recentpostslist-item-'.$recentpost_id, 'ascm' ); ?>" class="ascm-panels-recentpostslist-item <?php esc_html_e($grid_class, 'ascm'); ?>" post-id="<?php esc_html_e( $recentpost_id, 'ascm' ); ?>">
					
					<?php 
						if ( $card_type && function_exists ('wfc_get_card') ) : 
							if ( $file_exists ) :
								echo wfc_get_card( $card_type, $recentpost_id );
							endif;
					?>
					<?php else : ?>
					
					<div class="ascm-panels-recentpostslist-item-sub-cont">
						<div class="ascm-panels-recentpostslist-item-featuredimg"><img src="<?php esc_html_e($recentpost_thumbnail_url, 'ascm'); ?>"/></div>
						<div class="ascm-panels-recentpostslist-item-info">
							<div class="ascm-panels-recentpostslist-item-title"><span><?php esc_html_e($recentpost_title, 'ascm'); ?></span></div>
							<div class="ascm-panels-recentpostslist-item-content"><span><?php esc_html_e($recentpost_content, 'ascm'); ?></span></div>
							<div class="ascm-panels-recentpostslist-item-redirect"><a href="<?php esc_html_e($recentpost_permalink, 'ascm') ?>">Read More</a> </div>
						</div>
					</div>
					
					<?php endif; ?>
					
				</div>
                <?php endforeach; ?>
            </div>
            <?php
		}
		
		/**
		 * Renders the list of tile menu of the panel that is using Tile Menu recipe.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $panel
		 * @param $navmenuitems
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   May 20, 2019
		 */
		public static function render_tile_menu_list( $panel, $navmenuitems ) {
			$panel_id = isset($panel['id']) ? $panel['id'] : '';

			$tilemenu_navmenu = isset($panel['data']['standard']['tilemenu_navmenu']) ? $panel['data']['standard']['tilemenu_navmenu'] : '';
			$tilemenu_itemsperrowlrg = isset($panel['data']['standard']['tilemenu_itemsperrowlrg']) ? $panel['data']['standard']['tilemenu_itemsperrowlrg'] : 'fourperrow';
			$tilemenu_itemsperrowmed = isset($panel['data']['standard']['tilemenu_itemsperrowmed']) ? $panel['data']['standard']['tilemenu_itemsperrowmed'] : 'twoperrow';

			if ($tilemenu_itemsperrowlrg == 'fourperrow'){
				$grid_class_lrg = 'col-lg-3 .col-xl-3';
			}elseif ($tilemenu_itemsperrowlrg == 'threeperrow'){
				$grid_class_lrg = 'col-lg-4 col-xl-4';
			}elseif ($tilemenu_itemsperrowlrg == 'twoperrow'){
				$grid_class_lrg = 'col-lg-6 col-xl-6';
			}else{
				$grid_class_lrg = 'col-lg-12 col-xl-12';
			}

			if ($tilemenu_itemsperrowmed == 'twoperrow'){
				$grid_class_med = 'col-sm-6 col-md-6';
			}else{
				$grid_class_med = 'col-sm-12 col-md-12';
			}

			$grid_class = 'col-12 '.$grid_class_med.' '.$grid_class_lrg;
			
			$card_type = isset($panel['data']['custom']['ascm-panels-card-overwrite'][0]) ? $panel['data']['custom']['ascm-panels-card-overwrite'][0] : '';

			?>
            <div id="<?php echo 'ascm-panels-tilemenulist-'.$panel_id; ?>" class="row ascm-panels-tilemenulist-cont <?php echo 'ascm-panels-tilemenulist-'.$panel_id; ?>">
                <?php if (!empty($navmenuitems)): ?>
    				<?php foreach ($navmenuitems as $key => $value):
    					$tilemenuitem_id = isset($value->object_id) ? $value->object_id : '';
    					$tilemenuitem_title = isset($value->title) ? $value->title : '';
    					$tilemenuitem_thumbnail_url = get_the_post_thumbnail_url($tilemenuitem_id, 'full');
    					$tilemenuitem_thumbnail_url = !empty($tilemenuitem_thumbnail_url) ? $tilemenuitem_thumbnail_url : 'https://via.placeholder.com/600x400';

    					$tilemenuitem_permalink = get_permalink($tilemenuitem_id);
    					$tilemenuitem_menu_item_parent = isset($value->menu_item_parent) ? $value->menu_item_parent : '';
    					
						$menu_args = array( 
							'tilemenuitem_title' => $tilemenuitem_title,
							'tilemenuitem_thumbnail_url' => $tilemenuitem_thumbnail_url
						);
						
						?>
                        <?php if ($tilemenuitem_menu_item_parent == 0): ?>

                        <div id="<?php esc_html_e( 'ascm-panels-tilemenulist-item-'.$tilemenuitem_id, 'ascm' ); ?>" class="ascm-panels-tilemenulist-item <?php esc_html_e($grid_class, 'ascm'); ?>" post-id="<?php esc_html_e( $tilemenuitem_id, 'ascm' ); ?>">                            
							
								<?php 
									if ( $card_type && function_exists( 'wfc_get_card' ) ) : 
										if ( wfc_card_exists( $card_type ) ) :
											echo wfc_get_card( $card_type, $value->object_id, $menu_args );
										endif;
								?>
								<?php else : ?>
                                <a href="<?php esc_html_e($tilemenuitem_permalink, 'ascm') ?>">
                                    <div class="ascm-panels-tilemenulist-item-sub-cont">
                                        <div class="ascm-panels-tilemenulist-item-featuredimg"><img src="<?php esc_html_e($tilemenuitem_thumbnail_url, 'ascm'); ?>"/></div>
                                        <div class="ascm-panels-tilemenulist-item-info">
                                            <div class="ascm-panels-tilemenulist-item-title"><span><?php esc_html_e($tilemenuitem_title, 'ascm'); ?></span></div>
                                        </div>
                                    </div>
								</a>
								<?php endif; ?>
                        </div>
                        <?php endif; ?>
    				<?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php
		}
		
		/**
		 * Renders the video embed code of the panel that is using Video recipe.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  $panel
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   May 22, 2019
		 */
		public static function render_video_embed_code( $panel ) {
			$panel_id = isset($panel['id']) ? $panel['id'] : '';

			$video_videoembedcode = isset($panel['data']['standard']['video_videoembedcode']) ? $panel['data']['standard']['video_videoembedcode'] : '';
			?>
            <div id="<?php echo 'ascm-panels-videoembedcode-'.$panel_id; ?>" class="ascm-panels-videoembedcode-cont <?php echo 'ascm-panels-videoembedcode-'.$panel_id; ?>">
                <?php echo html_entity_decode(esc_html($video_videoembedcode, 'ascm')); ?>
            </div>
            <?php
		}
		
		/**
		 * Renders the panel half image recipe CSS inside style tag
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   May 14, 2019
		 */
		public static function render_withimage_recipe_style($panel) {
			$panel_id = $panel['data']['post']->ID;
			$panel_sub_cont_class = '.ascm-panels-sub-cont-'.$panel_id;

			$withimage_imageposition = isset($panel['data']['standard']['withimage_imageposition']) ? $panel['data']['standard']['withimage_imageposition'] : 'left';
			$withimage_wrapimagewithcont = isset($panel['data']['standard']['withimage_wrapimagewithcont']) ? $panel['data']['standard']['withimage_wrapimagewithcont'] : '';

			$img_margin = '0px 20px 0px 0px';
			$img_float = 'left';
			if ($withimage_imageposition == 'right') {
				$img_margin = '0px 0px 0px 20px';
				$img_float = 'right';
			}

			?>
			<?php if ($withimage_wrapimagewithcont == 'on'): ?>
            <style id="<?php echo 'ascm-panel-withimage-recipe-style-'.$panel_id.'-CSS'; ?>" type="text/css">

                <?php echo $panel_sub_cont_class; ?> .ascm-panels-withimage-img {
                    width: 100%;
                    float: none;
                    margin: 0px 0px 20px 0px;
                 }

                @media (min-width: 768px) {
                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-withimage-img{
                        width: 300px;
                        float: <?php echo $img_float; ?>;
                        margin: <?php echo $img_margin; ?>;
                    }
                }

                @media (min-width: 992px) {
                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-withimage-img{
                        width: 300px;
                        float: <?php echo $img_float; ?>;
                        margin: <?php echo $img_margin; ?>;
                    }
                }

                @media (min-width: 1200px) {
                    <?php echo $panel_sub_cont_class; ?> .ascm-panels-withimage-img{
                        width: 300px;
                        float: <?php echo $img_float; ?>;
                        margin: <?php echo $img_margin; ?>;
                    }
                }

            </style>
			<?php else: ?>
            <style id="<?php echo 'ascm-panel-withimage-recipe-style-'.$panel_id.'-CSS'; ?>" type="text/css">
                .ascm-panels-withimage-nonewrap .ascm-panels-withimage-nonewrap-content {
                    margin-right: 0px;
                    margin-left: 0px;
                }

                @media (min-width: 768px){
                    .ascm-panels-withimage-nonewrap .ascm-panels-withimage-nonewrap-content {
                        <?php if ($withimage_imageposition == 'right'): ?>
                        margin-right: 20px;
                        <?php else: ?>
                        margin-left: 20px;
                        <?php endif; ?>
                    }
                }

                @media (min-width: 992px) {
                    .ascm-panels-withimage-nonewrap .ascm-panels-withimage-nonewrap-content {
                        <?php if ($withimage_imageposition == 'right'): ?>
                        margin-right: 20px;
                        <?php else: ?>
                        margin-left: 20px;
                        <?php endif; ?>
                    }
                }

                @media (min-width: 1200px) {
                    .ascm-panels-withimage-nonewrap .ascm-panels-withimage-nonewrap-content {
                        <?php if ($withimage_imageposition == 'right'): ?>
                        margin-right: 20px;
                        <?php else: ?>
                        margin-left: 20px;
                        <?php endif; ?>
                    }
                }

            </style>
			<?php endif; ?>
			<?php
		}
		
		/**
		 * Renders the content of the panel.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $panel
		 *
         * @since  1.0.0
         *
         * @LastUpdated   June 3, 2019
		 */
		public static function render_withimage_content($panel) {
			$panel_id = isset($panel['id']) ? $panel['id'] : '';

			$withimage_image = isset($panel['data']['standard']['withimage_image']) ? $panel['data']['standard']['withimage_image'] : 'donothing';
			$withimage_image = wp_get_attachment_image_src($withimage_image, 'full');
			$withimage_image = isset($withimage_image[0]) ? $withimage_image[0] : '';
			$withimage_imageposition = isset($panel['data']['standard']['withimage_imageposition']) ? $panel['data']['standard']['withimage_imageposition'] : 'left';
			$withimage_wrapimagewithcont = isset($panel['data']['standard']['withimage_wrapimagewithcont']) ? $panel['data']['standard']['withimage_wrapimagewithcont'] : '';

			$content = isset($panel['data']['post']->post_content) ? $panel['data']['post']->post_content : '';

            $content = apply_filters( 'the_content', $content );
            ?>

            <?php if ($withimage_wrapimagewithcont == 'on'): ?>
                <div id="<?php echo 'ascm-panels-content-'.$panel_id; ?>" class="panel-content <?php echo 'ascm-panels-content-'.$panel_id; ?>"><img class="ascm-panels-withimage-img" src="<?php echo $withimage_image; ?>"><?php ASCM_Panels_Renderer::render_title($panel); ?><?php echo $content; ?></div>
				<?php ASCM_Panels_Renderer::render_cta_link($panel); ?>
            <?php else: ?>
                <div class="ascm-panels-withimage-nonewrap">
                    <?php if ($withimage_imageposition == 'left'): ?>
                    <div class="ascm-panels-withimage-nonewrap-image">
                        <img class="ascm-panels-withimage-img" src="<?php echo $withimage_image; ?>">
                    </div>
                    <?php endif; ?>

                    <div class="ascm-panels-withimage-nonewrap-content">
	                    <?php ASCM_Panels_Renderer::render_title($panel); ?>
                        <div id="<?php echo 'ascm-panels-content-'.$panel_id; ?>" class="panel-content<?php echo 'ascm-panels-content-'.$panel_id; ?>"><?php echo $content; ?></div>
	                    <?php ASCM_Panels_Renderer::render_cta_link($panel); ?>
                    </div>

	                <?php if ($withimage_imageposition == 'right'): ?>
                        <div class="ascm-panels-withimage-nonewrap-image">
                            <img class="ascm-panels-withimage-img" src="<?php echo $withimage_image; ?>">
                        </div>
	                <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php
		}

	}
	new ASCM_Panels_Renderer();
}		