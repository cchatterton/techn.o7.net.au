<?php

defined('ABSPATH') or die('No script kiddie please!');

if (! class_exists('ASCM_Panels_CPTQueries')) {
	/**
	 * Class ASCM_Panels_CPTQueries
	 *
	 * This class post type query and constructs paginated detail on the posts queried.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @since  1.0.0
	 * @LastUpdated   June 27, 2019
	 */
	class ASCM_Panels_CPTQueries {

		/**
		 * Fetches Panel Posts.
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param array $panel
		 * @return array wp query with pagination
		 * @LastUpdated  June 27, 2019
		 */
		public static function get_posts($panel = []) {
			$offset = 0;

			$postgallery_posttype = isset($panel['data']['standard']['postgallery_posttype']) ? $panel['data']['standard']['postgallery_posttype'] : '';
			$postgallery_maxnumofitems = isset($panel['data']['standard']['postgallery_maxnumofitems']) ? $panel['data']['standard']['postgallery_maxnumofitems'] : '9';
			$postgallery_maxnumofitems = (int)$postgallery_maxnumofitems;
			$postgallery_orderby = isset($panel['data']['standard']['postgallery_orderby']) ? $panel['data']['standard']['postgallery_orderby'] : 'post_title';
			$postgallery_sortorder = isset($panel['data']['standard']['postgallery_sortorder']) ? $panel['data']['standard']['postgallery_sortorder'] : 'DESC';

			/*
			 * sanitizing variables
			 */
			$cpt = filter_var($postgallery_posttype, FILTER_SANITIZE_STRING);
			$ppp = filter_var($postgallery_maxnumofitems, FILTER_VALIDATE_INT);
			$offset = filter_var($offset, FILTER_VALIDATE_INT);
			$orderby = filter_var($postgallery_orderby, FILTER_SANITIZE_STRING);
			$sortorder = filter_var($postgallery_sortorder, FILTER_SANITIZE_STRING);

			/*
			 * pagination parameters
			 */
			if (get_query_var('paged')) {
				$paged = get_query_var('paged');
			} elseif (get_query_var('page')) {
				$paged = get_query_var('page');
			} else {
				$paged = 1;
			}

			$meta_query[] = array(

			);


			// Calculate term offset
			$offset = ( ( $paged - 1 ) * $ppp );
			$args = array(
				'posts_per_page' => $ppp,
				'post_status' => array('publish'),
				'paged' => $paged,
				'post_type' => $cpt,
				'orderby' => $orderby,
				'order' => $sortorder,
				's' => isset($_GET['ascmpsrch']) ? $_GET['ascmpsrch'] : '',
				//'meta_query' => $meta_query,
			);

			if ($offset !== null) {
				$args = array(
					'posts_per_page' => $ppp,
					'post_status' => array('publish'),
					'paged' => $paged,
					'post_type' => $cpt,
					'orderby' => $orderby,
					'order' => $sortorder,
					'offset' => $offset,
					's' => isset($_GET['ascmpsrch']) ? $_GET['ascmpsrch'] : '',
					//'meta_query' => $meta_query,
				);
			}


			/*
			 * querying/getting cart products
			 */
			$query = new WP_Query($args);

			/*
			 * get total number of cart products
			 */
			$post_count = $query->found_posts;

			/*
			 * calculating total page
			 */
			$max_num_pages = ceil($post_count / $ppp);
			// $max_num_pages = ceil( $post_count);

			return array(
				'query' => $query, // wp_query - total cart product
				'max_num_pages' => $max_num_pages, // total pages
				'post_count' => $post_count, //total post count
			);
		}
		
		/**
		 * Creates a pagination on Post Gallery page
		 *
		 * @author       Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array  $config
		 * @param         $args array
		 *
		 * @return string html - pagination
         *
         * @LastUpdated  July 1, 2019
		 */
		public static function render_postgallerypaginationelements($args = [], $config = []) {
			if (empty($config)){
				$config = array(
					'pageinfo' => array(
						'label' => 'Page',
						'class' => '',
					),
					'firstpage_btn' => array(
						'label' => 'FIRST',
						'class' => '',
					),
					'previouspage_btn' => array(
						'label' => 'PREV',
						'class' => '',
					),
					'pagenum_btn' => array(
						'range' => 3,
						'class' => '',
					),
					'nextpage_btn' => array(
						'label' => 'NEXT',
						'class' => '',
					),
					'lastpage_btn' => array(
						'label' => 'LAST',
						'class' => '',
					)
				);
			}

			$pagenum_btn_range = isset($config['pagenum_btn']['range']) ? $config['pagenum_btn']['range'] : 3;

			//Set defaults to use
			$defaults = [
				'query' => $GLOBALS['wp_query'],
				'previous_page_text' => __('&laquo;'),
				'next_page_text' => __('&raquo;'),
				'first_page_text' => __('First'),
				'last_page_text' => __('Last'),
				'next_link_text' => __('Older Entries'),
				'previous_link_text' => __('Newer Entries'),
				'show_posts_links' => false,
				'range' => $pagenum_btn_range,
			];

			// Merge default arguments with user set arguments
			$args = wp_parse_args($args, $defaults);

			if (get_query_var('paged')) {
				$current_page = get_query_var('paged');
			} elseif (get_query_var('page')) {
				$current_page = get_query_var('page');
			} else {
				$current_page = 1;
			}

			// Get the amount of pages from the query
			$max_pages = (is_object($args['query'])) ? (int)$args['query']->max_num_pages : (int)$args['query'];

			/*
			 * If $args['show_posts_links'] is set to false, numbered paginated links are returned
			 * If $args['show_posts_links'] is set to true, pagination links are returned
			 */
			if (false === $args['show_posts_links']) {

				// Don't display links if only one page exists
				if (1 === $max_pages) {
					$paginated_text = '';
				} else {

					/*
					 * For multi-paged queries, we need to set the variable ranges which will be used to check
					 * the current page against and according to that set the correct output for the paginated numbers
					 */
					$mid_range = (int)floor($args['range'] / 2);
					$start_range = range(1, $mid_range);
					$end_range = range(($max_pages - $mid_range + 1), $max_pages);
					$exclude = array_merge($start_range, $end_range);

					/*
					 * The amount of pages must now be checked against $args['range']. If the total amount of pages
					 * is less than $args['range'], the numbered links must be returned as is
					 *
					 * If the total amount of pages is more than $args['range'], then we need to calculate the offset
					 * to just return the amount of page numbers specified in $args['range']. This defaults to 5, so at any
					 * given instance, there will be 5 page numbers displayed
					 */
					$check_range = ($args['range'] > $max_pages) ? true : false;

					if (true === $check_range) {
						$range_numbers = range(1, $max_pages);
					} elseif (false === $check_range) {
						if (!in_array($current_page, $exclude)) {
							$range_numbers = range(($current_page - $mid_range), ($current_page + $mid_range));
						} elseif (in_array($current_page, $start_range) && ($current_page - $mid_range) <= 0) {
							$range_numbers = range(1, $args['range']);
						} elseif (in_array($current_page, $end_range) && ($current_page + $mid_range) >= $max_pages) {
							$range_numbers = range(($max_pages - $args['range'] + 1), $max_pages);
						}
					}

					/*
					 * The page numbers are set into an array through this foreach loop. The current page, or active page
					 * gets the class 'current' assigned to it. All the other pages get the class 'inactive' assigned to it
					 */
					foreach ($range_numbers as $v) {
						if ($v == $current_page) {
							$page_numbers[] = '<span class="ascm-panels-pg-pagination-btn-num-cur ascm-panels-pagination-btn-disabled"><a href="' . get_pagenum_link($v) . '" class="ascm-panels-pg-pagination-avoid-clicks"><span>' . $v . '</span></a></span>';
						} else {
							$page_numbers[] = '<span class="ascm-panels-pg-pagination-btn-num"><a href="' . get_pagenum_link($v) . '" class="ascm-panels-pg-pagination-allow-clicks"><span>' . $v . '</span></a></span>';
						}
					}

					/*
					 * All the texts are set here and when they should be displayed which will link back to:
					 * - $previous_page The previous page from the current active page
					 * - $next_page The next page from the current active page
					 * - $first_page Links back to page number 1
					 * - $last_page Links to the last page
					 */
					$dots_btn = '<a href="" style="pointer-events: none;">...</a>';

					/*
					 * Text to display before the page numbers
					 * This is set to the following structure:
					 * - Page X of Y
					 */
					$paginated_text = '<div class="ascm-panels-pg-pagination-main-cont">';

					foreach ($config as $key => $value){
						if($key == 'pageinfo'){
							$pageinfo_label = isset($value['label']) ? $value['label'] : '';
							$pageinfo_class = isset($value['class']) ? $value['class'] : '';

							$paginated_text .= '<span class="ascm-panels-pg-pagination-pageinfo '.$pageinfo_class.'">' . sprintf(__($pageinfo_label.'%s of %s'), $current_page, $max_pages) . '</span>';
						}

						if($key == 'firstpage_btn'){
							$firstpage_btn_label = isset($value['label']) ? $value['label'] : '';
							$firstpage_btn_class = isset($value['class']) ? $value['class'] : '';

							// First number
							$first_page_btn_en = '<span class="ascm-panels-pg-pagination-btn-first-page '.$firstpage_btn_class.'"><a href="' . get_pagenum_link(1) . '"><span>'.$firstpage_btn_label.'</span></a></span>';
							$first_page_btn_dis = '<span class="ascm-panels-pg-pagination-btn-first-page ascm-panels-pagination-btn-disabled '.$firstpage_btn_class.'"><a href="' . get_pagenum_link(1) . '"><span>'.$firstpage_btn_label.'</span></a></span>';
							$first_page = (!empty($range_numbers) && $current_page !== 1) ? $first_page_btn_en : $first_page_btn_dis;

							$paginated_text .= $first_page;
						}

						if($key == 'previouspage_btn') {
							$previouspage_btn_label = isset($value['label']) ? $value['label'] : '';
							$previouspage_btn_class = isset($value['class']) ? $value['class'] : '';

							// Previous Page
							$previous_page_btn_en = '<span class="ascm-panels-pg-pagination-btn-prev '.$previouspage_btn_class.'"><a href="' . get_pagenum_link($current_page - 1) . '"><span>'.$previouspage_btn_label.'</span></a></span>';
							$previous_page_btn_dis = '<span class="ascm-panels-pg-pagination-btn-prev ascm-panels-pagination-btn-disabled '.$previouspage_btn_class.'"><a href="' . get_pagenum_link($current_page - 1) . '"><span>'.$previouspage_btn_label.'</span></a></span>';
							$previous_page = ($current_page !== 1) ? $previous_page_btn_en : $previous_page_btn_dis;

							$paginated_text .= $previous_page;
						}

						if($key == 'pagenum_btn') {
							$pagenum_btn_class = isset($value['class']) ? $value['class'] : '';

							// Turn the array of page numbers into a string
							$numbers_string = implode('', $page_numbers);
							$paginated_text .= '<span class="ascm-panels-pg-pagination-btn-num-cont '.$pagenum_btn_class.'">'.$numbers_string.'</span>';
						}

						if($key == 'nextpage_btn') {
							$nextpage_btn_label = isset($value['label']) ? $value['label'] : '';
							$nextpage_btn_class = isset($value['class']) ? $value['class'] : '';

							// Next Page
							$next_page_btn_en = '<span class="ascm-panels-pg-pagination-btn-next '.$nextpage_btn_class.'"><a href="' . get_pagenum_link($current_page + 1) . '"><span>'.$nextpage_btn_label.'</span></a></span>';
							$next_page_btn_dis = '<span class="ascm-panels-pg-pagination-btn-next ascm-panels-pagination-btn-disabled '.$nextpage_btn_class.'"><a href="' . get_pagenum_link($current_page + 1) . '"><span>'.$nextpage_btn_label.'</span></a></span>';
							$next_page = ($current_page !== $max_pages) ? $next_page_btn_en : $next_page_btn_dis;

							$paginated_text .= $next_page;
						}

						if($key == 'lastpage_btn') {
							$lastpage_btn_label = isset($value['label']) ? $value['label'] : '';
							$lastpage_btn_class = isset($value['class']) ? $value['class'] : '';

							// Last number
							$last_page_btn_en = '<span class="ascm-panels-pg-pagination-btn-last-page '.$lastpage_btn_class.'"><a href="' . get_pagenum_link($max_pages) . '"><span>'.$lastpage_btn_label.'</span></a></span>';
							$last_page_btn_dis = '<span class="ascm-panels-pg-pagination-btn-last-page ascm-panels-pagination-btn-disabled '.$lastpage_btn_class.'"><a href="' . get_pagenum_link($max_pages) . '"><span>'.$lastpage_btn_label.'</span></a></span>';
							$last_page_btn = ($max_pages != $current_page) ? $last_page_btn_en : $last_page_btn_dis;

							$paginated_text .= $last_page_btn;
						}

					}

					$paginated_text .= '</div>';
				}

			} elseif (true === $args['show_posts_links']) {

				/*
				 * If $args['show_posts_links'] is set to true, only links to the previous and next pages are displayed
				 * The $max_pages parameter is already set by the function to accommodate custom queries
				 */
				$paginated_text = next_posts_link('<div class="next-posts-link">' . $args['next_link_text'] . '</div>', $max_pages);
				$paginated_text .= previous_posts_link('<div class="previous-posts-link">' . $args['previous_link_text'] . '</div>');

			}

			// Finally return the output text from the function
			echo $paginated_text;
		}


		/**
		 * Renders a pagination on Post Gallery Post list.
		 *
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param         $panel
		 * @param  array  $config
		 * @param  array  $args
		 *
		 * @return string html - pagination
		 * @LastUpdated   July 1, 2019
		 */
		public static function render_postgallerypostlist($args =[], $panel, $config = []){
			$panel_id = isset($panel['id']) ? $panel['id'] : '';

			$postgallery_itemsperrowlrg = isset($panel['data']['standard']['postgallery_itemsperrowlrg']) ? $panel['data']['standard']['postgallery_itemsperrowlrg'] : 'fourperrow';
			$postgallery_itemsperrowmed = isset($panel['data']['standard']['postgallery_itemsperrowmed']) ? $panel['data']['standard']['postgallery_itemsperrowmed'] : 'twoperrow';

			if ($postgallery_itemsperrowlrg == 'fourperrow'){
				$grid_class_lrg = 'col-lg-3 .col-xl-3';
			}elseif ($postgallery_itemsperrowlrg == 'threeperrow'){
				$grid_class_lrg = 'col-lg-4 col-xl-4';
			}elseif ($postgallery_itemsperrowlrg == 'twoperrow'){
				$grid_class_lrg = 'col-lg-6 col-xl-6';
			}else{
				$grid_class_lrg = 'col-lg-12 col-xl-12';
			}

			if ($postgallery_itemsperrowmed == 'twoperrow'){
				$grid_class_med = 'col-sm-6 col-md-6';
			}else{
				$grid_class_med = 'col-sm-12 col-md-12';
			}

			$grid_class = 'col-12 '.$grid_class_med.' '.$grid_class_lrg;
			
			$card_type = isset($panel['data']['custom']['ascm-panels-card-overwrite'][0]) ? $panel['data']['custom']['ascm-panels-card-overwrite'][0] : '';
			$card_file = sprintf( '%s/%s.php', wfc_get_cards_dir(), $card_type );
			$file_exists = file_exists ( $card_file );
			
			$posts = (isset($args['query']->posts) && !empty($args['query']->posts)) ? $args['query']->posts : array();
			?>
            <div id="<?php echo 'ascm-panels-postgallerylist-'.$panel_id; ?>" class="row ascm-panels-postgallerylist-cont <?php echo 'ascm-panels-postgallerylist-'.$panel_id; ?>">
				<?php foreach ($posts as $key => $value):
					$post_id = isset($value->ID) ? $value->ID : '';
					$post_title = isset($value->post_title) ? $value->post_title : '';
					$post_title = mb_strimwidth($post_title, 0, 30, '...');
					$post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
					$post_thumbnail_url = !empty($post_thumbnail_url) ? $post_thumbnail_url : 'https://via.placeholder.com/600x400';
					$post_content = isset($value->post_content) ? $value->post_content : '';
					$post_content = wp_trim_words($post_content, 20);
					$post_permalink = get_permalink($post_id);

					?>
                    <div id="<?php esc_html_e( 'ascm-panels-postgallerylist-item-'.$post_id, 'ascm' ); ?>" class="ascm-panels-postgallerylist-item <?php esc_html_e($grid_class, 'ascm'); ?>" post-id="<?php esc_html_e( $post_id, 'ascm' ); ?>">
                        
						<?php 
							if ( $card_type && function_exists ('wfc_get_card') ) : 
								if ( $file_exists ) :
									echo wfc_get_card( $card_type, $post_id );
								endif;
						?>
						<?php else : ?>
						
							<div class="ascm-panels-postgallerylist-item-sub-cont">
								<div class="ascm-panels-postgallerylist-item-featuredimg"><img src="<?php esc_html_e($post_thumbnail_url, 'ascm'); ?>"/></div>
								<div class="ascm-panels-postgallerylist-item-info">
									<div class="ascm-panels-postgallerylist-item-title"><span><?php esc_html_e($post_title, 'ascm'); ?></span></div>
									<div class="ascm-panels-postgallerylist-item-content"><span><?php esc_html_e($post_content, 'ascm'); ?></span></div>
									<div class="ascm-panels-postgallerylist-item-redirect"><a href="<?php esc_html_e($post_permalink, 'ascm') ?>">Read More</a> </div>
								</div>
							</div>
							
						<?php endif; ?>

                    </div>
		
				<?php endforeach; ?>
            </div>
			
			<?php
		}

		/**
		 * Create a search on Post Gallery.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $panel
		 * @param $args array
		 *
		 * @return string html - pagination
		 * @LastUpdated   July 1, 2019
		 */
		public static function render_postgallerysearchelements($args =[], $panel){
			global $wp;

			$search = isset($_GET['ascmpsrch']) ? $_GET['ascmpsrch'] : '';
			$page_url = home_url(add_query_arg( array(), $wp->request ));

			$page_url_withpagination = $page_url;

			$all_urlparam = $_GET;
			unset($all_urlparam['ascmpsrch']);
			unset($all_urlparam['page']);

			$all_urlparam_index = 0;
			foreach ($all_urlparam as $key => $value){
				if ($all_urlparam_index == 0){
					$page_url_withpagination .= '?'.$key.'='.$value;
				}else{
					$page_url_withpagination .= '&'.$key.'='.$value;
				}
				$all_urlparam_index = $all_urlparam_index + 1;
			}

			?>
            <div class="ascm-panels-postgallerysearch-main-cont">
                <div class="ascm-panels-postgallerysearch-sub-cont">

					<?php foreach ($args as $key => $value) : ?>
						<?php if($key == 'search_fld') :
							$searchfld_placeholder = isset($value['placeholder']) ? $value['placeholder'] : '';
							?>
                            <input type="text" id="ascm-panels-postgallerysearch-fld" placeholder="<?php echo esc_html($searchfld_placeholder) ?>" home-url-param-count="<?php echo count($all_urlparam); ?>" home-url="<?php echo $page_url_withpagination; ?>" value="<?php echo esc_html($search); ?>">
						<?php endif; ?>
						<?php if($key == 'search_btn') :
							$searchbtn_label = isset($value['label']) ? $value['label'] : 'Search';
							?>
                            <button id="ascm-panels-postgallerysearch-btn"><?php echo $searchbtn_label; ?></button>
						<?php endif; ?>
					<?php endforeach; ?>

                </div>
            </div>
            <script>
                jQuery(document).ready(function($){
                    $('#ascm-panels-postgallerysearch-btn').on('click', function() {
                        var postgallerysearch_homeurl = $('#ascm-panels-postgallerysearch-fld').attr('home-url');
                        var postgallerysearch_homeurl_param_count = $('#ascm-panels-postgallerysearch-fld').attr('home-url-param-count');
                        var postgallerysearch_val = $('#ascm-panels-postgallerysearch-fld').val();
                        if(postgallerysearch_val.length === 0) {
                            window.location.href = postgallerysearch_homeurl;
                        }else{
                            if (postgallerysearch_homeurl_param_count == 0 || postgallerysearch_homeurl_param_count == '0'){
                                window.location.href = postgallerysearch_homeurl + '?ascmpsrch=' + postgallerysearch_val;
                            }else {
                                window.location.href = postgallerysearch_homeurl + '&ascmpsrch=' + postgallerysearch_val;
                            }

                        }
                    });
                });
            </script>
			<?php
		}

	}
	new ASCM_Panels_CPTQueries();
}