<?php
/**
* Class ASCM_PanelsEditorButton
* This class handles all functionalities for ASCM Panels editor buttons.
*
* @author Junie Canonio
* @since  1.0.0
* @LastUpdated   January 29, 2019
*/
class ASCM_PanelsEditorButton {

	public function __construct() {
		add_filter("mce_external_plugins", array( $this, "enqueue_plugin_scripts") );
		add_filter("mce_buttons", array( $this, "register_buttons_editor"));
	}

	/**
	 * This function will enqueue the plugin script of ASCM Plugins editor plugin to mce
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $plugin_array
	 *
	 * @return mixed
	 * @since  1.0.0
	 */
	public function enqueue_plugin_scripts($plugin_array){
		global $post;
		$post_type = isset($post->post_type) ? $post->post_type : '';
		$post_type = (String)$post_type;
		if ('ascm_panels' == $post_type) {
		}else{
			?>
			<input id="ascm-panels-logo" type="hidden" value="<?php echo plugin_dir_url( __FILE__ ).'../../images/panel-20.png';?>">
			<?php

			wp_enqueue_style( 
				'ascm-panels-css', 
				plugin_dir_url( __FILE__ ) . '../../admin/css/ascm-panels-editorbutton.css', 
				array(), 
				'', 
				'all' 
			);

			$query = new WP_Query(
			    array(
			      'post_type' => 'ascm_panels',
			      'post_status' => 'publish',
			      'posts_per_page' => -1
			    )
			);
			$ascm_panels_available = isset($query->posts) ?  $query->posts : array();
			
			ob_start();
			?>
			<div id="ascm-panels-metaopt-main-cont" style="display: none;">
				<div id="ascm-panels-metaopt-sub-cont">
					<div id="ascm-panels-metaopt-header-cont">
						<span>Select a panel : </span>
					</div>	
					<div id="ascm-panels-metaopt-content-cont">
						<select id="ascm-panels-metaopt-select">
							<?php
							foreach ($ascm_panels_available as $key => $value) {
								$ascm_panel_title = isset($value->post_title) ? $value->post_title : 'No Tile';
								$ascm_panel_id = isset($value->ID) ? $value->ID : '';
								if(!empty($ascm_panel_id)){
									?>
									<option value="[ascm-panels id=<?php echo $ascm_panel_id;?>]"><?php echo $ascm_panel_title;?></option>
									<?php		
								}
							}
							?>
						</select>
					</div>	
					<div id="ascm-panels-metaopt-footer-cont">
						<span id="ascm-panels-metaopt-apply-btn">Apply</span>
						<span id="ascm-panels-metaopt-cancel-btn">Cancel</span>
					</div>
				</div>
			</div>	

			<?php
			ob_end_flush();

	    	//enqueue TinyMCE plugin script with its ID.
	    	$plugin_array["ascm_panels_button_plugin"] =  plugin_dir_url(__FILE__) . "../../admin/js/ascm-panels-editorbutton.js";
		}

	    return $plugin_array;
	}

	/**
	 * This function will register the ASCM Panels editor button.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $buttons
	 *
	 * @return mixed
	 * @since  1.0.0
     *
     * @LastUpdated   January 25, 2019
	 */
	public function register_buttons_editor($buttons){
		$post_type = isset($post->post_type) ? $post->post_type : '';
		$post_type = (String)$post_type; 
		if ('ascm_panels' == $post_type) {
		}else{
	    	//register buttons with their id.
	    	array_push($buttons, "ascm_panels_button");
	    }

	    return $buttons;
	}
}
new ASCM_PanelsEditorButton();