<?php
/**
* Class ASCM_PanelsShortcode
* This class handles all functionalities for ascm panels shortcode.
*
* @author Junie Canonio
* @since  1.0.0
* @LastUpdated   June 26, 2018
*/
class ASCM_PanelsShortcode {
	public function __construct () {
		add_shortcode( 'ascm-panels', array( $this , 'ascm_panels_contentshortcode') );
    }
	
	/**
	 * This function will create shortcode for ascm panels
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $form
	 *
	 * @return string
	 * @since  1.0.0
	 *
	 * @LastUpdated   January 25, 2019
	 */
    public function ascm_panels_contentshortcode($form){
	    global $wp;
	    $home_url_donation = home_url( $wp->request );

	    if (isset($form['id']) && !empty($form['id']) && strpos($home_url_donation, 'wp-json') == false) {
	    	
		    if (!is_admin()) {
			    $panel_id = isset($form['id']) ? $form['id'] : '';
			    if (!empty($panel_id)) {

				    $data = ASCM_Panels_Helper::get_panel_data($panel_id);

				    $panelascontent = isset($data['standard']['panelascontent']) ? $data['standard']['panelascontent'] : '';
				    $recipe = isset($data['standard']['recipe']) ? $data['standard']['recipe'] : '';
				    $recipe_type = isset($data['standard']['recipe_type']) ? $data['standard']['recipe_type'] : '';
				    $cta_url = isset($data['standard']['cta_url']) ? $data['standard']['cta_url'] : '';
				    $cta_wrapppanel = isset($data['standard']['cta_wrapppanel']) ? $data['standard']['cta_wrapppanel'] : '';

				    if ($panelascontent == 'on') {

					    $content = isset($data['post']->post_content) ? $data['post']->post_content : '';

				    } else {

					    if (empty($recipe)) {
						    return '';
					    }

					    /**
					     * necessary parameters for template
					     */
					    $form_body = array(
						    'panel' => array(
							    'id' => $panel_id,
							    'data' => $data,
						    ),
					    );

					    $content = ASCM_Panels_Helper::get_template($recipe, $form_body);

					    if (!empty($cta_url) && $cta_wrapppanel == 'on' && $recipe_type == 'default') {
						    $content = '<a href="' . $cta_url . '">' . $content . '</a>';
					    }

				    }

				    self::ascm_panels_insertstyleandscript(array(
					    'id' => $panel_id,
					    'data' => $data,
				    ));

				    return do_shortcode($content);
			    }
		    }
	    }
    }
	
	/**
	 * This function will insert the style and script tags of the panels rendered
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param  array  $panel
	 *
	 * @return void
	 * @since  1.0.0
	 *
	 * @LastUpdated   January 25, 2019
	 */
    public function ascm_panels_insertstyleandscript($panel){

        if (!empty($panel['id'])) {
            $panel_id = isset($panel['id']) ? $panel['id'] : '';

            $data = isset($panel['data']) ? $panel['data'] : array();

            $panelascontent = isset($data['standard']['panelascontent']) ? $data['standard']['panelascontent'] : '';
            $displayclildrenas = isset($data['standard']['displayclildrenas']) ? $data['standard']['displayclildrenas'] : 'donothing';
            $recipe = isset($data['standard']['recipe']) ? $data['standard']['recipe'] : '';
	        $recipe_type = isset($data['standard']['recipe_type']) ? $data['standard']['recipe_type'] : '';

            if ($panelascontent != 'on') {


                ASCM_Panels_Renderer::render_backgroundstyle($panel);

                if ($recipe_type == 'half_image') {
                    ASCM_Panels_Renderer::render_halfimage_recipe_style($panel);
                } elseif ($recipe_type == 'with_image') {
		            ASCM_Panels_Renderer::render_withimage_recipe_style($panel);
	            }

            }

            ASCM_Panels_Renderer::render_customstyle($panel);

        }
    }

}
new ASCM_PanelsShortcode();
