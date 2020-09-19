<?php
/**
* Class ASCM_PanelsPanelsOnPages
* This class handles all functionalities for ascm panels Panels on Pages functionality.
*
* @author Junie Canonio
* @since  1.0.0
* @LastUpdated   May 9, 2019
*/
class ASCM_PanelsPanelsOnPages {
	
	/**
	 * ASCM_PanelsPanelsOnPages constructor.
	 */
	public function __construct () {
        add_action( 'the_content', array( $this, 'ascm_panels_insertpanelsonpage' ));
        add_action( 'wp_head', array( $this, 'ascm_panels_insertpanelsonpagescript' ));


        // Genesis Header
		add_action('genesis_before_header', array($this, 'ascm_panels_genesisbeforeheader'), 20);
        add_action('genesis_after_header', array($this, 'ascm_panels_genesisafterheader'), 20);

		// Genesis Content
		add_action('genesis_before_entry', array($this, 'ascm_panels_genesisbeforeentry'), 1);
		add_action('genesis_after_entry', array($this, 'ascm_panels_genesisafterentry'), 20);

		// Genesis Footer
        add_action('genesis_before_footer', array($this, 'ascm_panels_genesisbeforefooter'), 1);
		add_action('genesis_after_footer', array($this, 'ascm_panels_genesisafterfooter'), 1);
    }
	
	/**
	 * Insert Panel on Pages base on the settings on ASCM Panels "Panels on Pages" option.
	 *
	 * @author       Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $content
	 *
	 * @return string
	 * @since        1.0.0
	 *
	 * @LastUpdated  May 9, 2019
	 */
    public function ascm_panels_insertpanelsonpage($content){
 
        if (!is_admin()){
	        global $wp_query;
	        
	        if(isset($wp_query->post->ID)) {
		        
	            $pageinfo = ASCM_Panels_Helper::get_pageinfobyid( $wp_query->post->ID );
		
		        if ( isset( $pageinfo['post_data'] ) && ! empty( $pageinfo['post_data'] ) ) {
			
			        if ( isset( $pageinfo['afterheader'] ) && ! empty( $pageinfo['afterheader'] ) &&
			             is_array( $pageinfo['afterheader'] ) && has_action( 'genesis_init' ) == false ) {
				        $afterheader_content = '';
				        foreach ( $pageinfo['afterheader'] as $key => $afterheader_value ) {
					        $afterheader_content = $afterheader_content . $afterheader_value;
				        }
				
				        if ( ! empty( $afterheader_content ) ) {
					        $content = '<div id="ascm-panels-afterheader-cont" style="display: none;">' .
					                   do_shortcode( $afterheader_content ) . '</div>' . $content;
				        }
			        }
			
			        if ( isset( $pageinfo['beforecontent'] ) && ! empty( $pageinfo['beforecontent'] ) &&
			             is_array( $pageinfo['beforecontent'] ) && has_action( 'genesis_init' ) == false ) {
				        $beforecontent_content = '';
				        foreach ( $pageinfo['beforecontent'] as $key => $beforecontent_value ) {
					        $beforecontent_content = $beforecontent_content . $beforecontent_value;
				        }
				
				        if ( ! empty( $beforecontent_content ) ) {
					        $content =
						        '<div id="ascm-panels-beforecontent-cont">' . do_shortcode( $beforecontent_content ) . '</div>' .
						        $content;
				        }
			        }
			
			        if ( isset( $pageinfo['aftercontent'] ) && ! empty( $pageinfo['aftercontent'] ) &&
			             is_array( $pageinfo['aftercontent'] ) && has_action( 'genesis_init' ) == false ) {
				        $aftercontent_content = '';
				        foreach ( $pageinfo['aftercontent'] as $key => $aftercontent_value ) {
					        $aftercontent_content = $aftercontent_content . $aftercontent_value;
				        }
				
				        if ( ! empty( $aftercontent_content ) ) {
					        $content =
						        do_shortcode( $content ) . '<div id="ascm-panels-aftercontent-cont">' . $aftercontent_content .
						        '</div>';
				        }
			        }
			
			        if ( isset( $pageinfo['beforefooter'] ) && ! empty( $pageinfo['beforefooter'] ) &&
			             is_array( $pageinfo['beforefooter'] ) && has_action( 'genesis_init' ) == false ) {
				
				        $beforefooter_content = '';
				        foreach ( $pageinfo['beforefooter'] as $key => $beforefooter_value ) {
					        $beforefooter_content = $beforefooter_content . $beforefooter_value;
				        }
				
				        if ( ! empty( $beforefooter_content ) ) {
					        $content = $content . '<div id="ascm-panels-beforefooter-cont" style="display: none;">' .
					                   do_shortcode( $beforefooter_content ) . '</div>';
				        }
			        }
			
		        }
	        }
        }
       	return $content;

    }
	
	/**
	 * This function will insert the script script tags of the panel
	 *
	 * @author        Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $panel
	 *
	 * @since         1.0.0
	 * @LastUpdated   January 25, 2019
	 */
    public function ascm_panels_insertpanelsonpagescript($panel){
    	if (empty($panel) && has_action('genesis_init') == false) {
	    	?>
	    	 <script type="text/javascript">
	            jQuery(document).ready(function($){
	                
	                if ($('#ascm-panels-afterheader-cont').length) {
	                	if ($("header[class='site-header']").length) {
		                	var afterheader_elem = $('#ascm-panels-afterheader-cont').detach();
		                	$("header[class='site-header']").after(afterheader_elem);
		                	afterheader_elem.css('display', 'block');

	                	}
	                }

	                if ($('#ascm-panels-beforefooter-cont').length) {
	                	if ($("footer[class='site-footer']").length) {
		                	var beforefooter_elem = $('#ascm-panels-beforefooter-cont').detach();
		                	$("footer[class='site-footer']").before(beforefooter_elem);
		                	beforefooter_elem.css('display', 'block');
	                	}
	                }
	              
	            }); 
	        </script>
	    	<?php	
    	}

    }
	
	/**
	 * Insert panels before the header of the page base on the settings on ASCM Panels "Panels on Pages" option.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @since  1.0.0
     *
     * @LastUpdated  May 28, 2019
	 */
	public function ascm_panels_genesisbeforeheader() {
		global $wp_query;

		if (!isset($wp_query->post->ID)){
			return;
		}

		if ( is_search() || is_archive() ) {
			return;
		}

		$pageinfo = ASCM_Panels_Helper::get_pageinfobyid($wp_query->post->ID);

		if (isset($pageinfo['post_data']) && !empty($pageinfo['post_data']) && has_action('genesis_init')) {
			if(isset($pageinfo['genesisbeforeheader']) && !empty($pageinfo['genesisbeforeheader']) && is_array($pageinfo['genesisbeforeheader'])) {
				$genesisbeforeheader_content = '';
				foreach ($pageinfo['genesisbeforeheader'] as $key => $genesisbeforeheader_value) {
					$genesisbeforeheader_content = $genesisbeforeheader_content . $genesisbeforeheader_value;
				}

				if(!empty($genesisbeforeheader_content)) {
					echo do_shortcode($genesisbeforeheader_content);
				}
			}

		}
	}
	
	/**
	 * Insert panels after the header of the page base on the settings on ASCM Panels "Panels on Pages" option.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @since  1.0.0
     *
     * @LastUpdated  May 28, 2019
	 */
    public function ascm_panels_genesisafterheader() {
    	global $wp_query;

	    if (!isset($wp_query->post->ID)){
		    return;
	    }

	    if ( is_search() || is_archive() ) {
			return;
		}

		$pageinfo = ASCM_Panels_Helper::get_pageinfobyid($wp_query->post->ID);

        if (isset($pageinfo['post_data']) && !empty($pageinfo['post_data']) && has_action('genesis_init')) {

	    	if(isset($pageinfo['genesisafterheader']) && !empty($pageinfo['genesisafterheader']) && is_array($pageinfo['genesisafterheader'])) {
			    $genesisafterheader_content = '';
				foreach ($pageinfo['genesisafterheader'] as $key => $genesisafterheader_value) {
					$genesisafterheader_content = $genesisafterheader_content . $genesisafterheader_value;
				}

				if(!empty($genesisafterheader_content)) {
					echo do_shortcode($genesisafterheader_content);
				}
			}

	    }
    }
	
	/**
	 * Insert panels on header of content of the page base on the settings on ASCM Panels "Panels on Pages" option.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @since  1.0.0
     *
     * @LastUpdated  May 28, 2019
	 */
	public function ascm_panels_genesisbeforeentry() {
		global $wp_query;

		if (!isset($wp_query->post->ID)){
			return;
		}

		if ( is_search() || is_archive() ) {
			return;
		}

		$pageinfo = ASCM_Panels_Helper::get_pageinfobyid($wp_query->post->ID);

		if (isset($pageinfo['post_data']) && !empty($pageinfo['post_data']) && has_action('genesis_init')) {

			if(isset($pageinfo['genesisbeforeentry']) && !empty($pageinfo['genesisbeforeentry']) && is_array($pageinfo['genesisbeforeentry'])) {
				$genesisbeforeentry_content = '';
				foreach ($pageinfo['genesisbeforeentry'] as $key => $genesisbeforeentry_value) {
					$genesisbeforeentry_content = $genesisbeforeentry_content . $genesisbeforeentry_value;
				}

				if(!empty($genesisbeforeentry_content)) {
					echo do_shortcode($genesisbeforeentry_content);
				}
			}

		}
	}
	
	/**
	 * Insert panels on footer of content of the page base on the settings on ASCM Panels "Panels on Pages" option.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @since  1.0.0
     *
     * @LastUpdated   May 28, 2019
	 */
	public function ascm_panels_genesisafterentry() {
		global $wp_query;

		if (!isset($wp_query->post->ID)){
			return;
		}

		if ( is_search() || is_archive() ) {
			return;
		}

		$pageinfo = ASCM_Panels_Helper::get_pageinfobyid($wp_query->post->ID);

		if (isset($pageinfo['post_data']) && !empty($pageinfo['post_data']) && has_action('genesis_init')) {

			if(isset($pageinfo['genesisafterentry']) && !empty($pageinfo['genesisafterentry']) && is_array($pageinfo['genesisafterentry'])) {
				$genesisafterentry_content = '';
				foreach ($pageinfo['genesisafterentry'] as $key => $genesisafterentry_value) {
					$genesisafterentry_content = $genesisafterentry_content . $genesisafterentry_value;
				}

				if(!empty($genesisafterentry_content)) {
					echo do_shortcode($genesisafterentry_content);
				}
			}

		}
	}
	
	/**
	 * Insert panels before the footer of the page base on the settings on ASCM Panels "Panels on Pages" option.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
     *
	 * @since  1.0.0
     *
     * @LastUpdated   May 28, 2019
	 */
    public function ascm_panels_genesisbeforefooter() {
    	global $wp_query;

    	if (!isset($wp_query->post->ID)){
    	    return;
        }

        if ( is_search() || is_archive() ) {
			return;
		}

		$pageinfo = ASCM_Panels_Helper::get_pageinfobyid($wp_query->post->ID);

        if (isset($pageinfo['post_data']) && !empty($pageinfo['post_data']) && has_action('genesis_init')) {

	    	if(isset($pageinfo['genesisbeforefooter']) && !empty($pageinfo['genesisbeforefooter']) && is_array($pageinfo['genesisbeforefooter'])) {
				$genesisbeforefooter_content = '';
				foreach ($pageinfo['genesisbeforefooter'] as $key => $genesisbeforefooter_value) {
					$genesisbeforefooter_content = $genesisbeforefooter_content . $genesisbeforefooter_value;
				}

				if(!empty($genesisbeforefooter_content)) {
					echo do_shortcode($genesisbeforefooter_content);
				}
			}

	    }
    }
	
	/**
	 * Insert panels before the footer of the page base on the settings on ASCM Panels "Panels on Pages" option.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @since  1.0.0
     *
     * @LastUpdated   May 28, 2019
     *
	 */
	public function ascm_panels_genesisafterfooter() {
		global $wp_query;

		if (!isset($wp_query->post->ID)){
			return;
		}

		if ( is_search() || is_archive() ) {
			return;
		}

		$pageinfo = ASCM_Panels_Helper::get_pageinfobyid($wp_query->post->ID);

		if (isset($pageinfo['post_data']) && !empty($pageinfo['post_data']) && has_action('genesis_init')) {

			if(isset($pageinfo['genesisafterfooter']) && !empty($pageinfo['genesisafterfooter']) && is_array($pageinfo['genesisafterfooter'])) {
				$genesisafterfooter_content = '';
				foreach ($pageinfo['genesisafterfooter'] as $key => $genesisafterfooter_value) {
					$genesisafterfooter_content = $genesisafterfooter_content . $genesisafterfooter_value;
				}

				if(!empty($genesisafterfooter_content)) {
					echo do_shortcode($genesisafterfooter_content);
				}
			}

		}
	}

}
new ASCM_PanelsPanelsOnPages();

