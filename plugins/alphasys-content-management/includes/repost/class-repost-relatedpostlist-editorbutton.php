<?php
/**
* Class ASCM_Repost_RelatedPostListEditorButton
 *
* This class handles all functionalities for ASCM Repost editor buttons
*
* @author Junie Canonio
* @since  1.0.0
* @LastUpdated   April 2, 2019
*/
class ASCM_Repost_RelatedPostListEditorButton {

	public function __construct() {
		add_filter("mce_external_plugins", array( $this, "enqueue_plugin_scripts") );	 
		add_filter("mce_buttons", array( $this, "register_buttons_editor"));
	}
	
	/**
	 * This function will enqueue the plugin script of ASCM Repost editor plugin to mce.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $plugin_array
	 *
	 * @return mixed
	 * @since  1.0.0
     *
     * @LastUpdated   April 2, 2019
	 */
	public function enqueue_plugin_scripts($plugin_array){
		global $post;
		$post_type = isset($post->post_type) ? $post->post_type : '';
		$post_type = (String)$post_type;
		if ( $post_type == 'post' || $post_type == 'ascm_repost' ) {
			?>
			<input id="ascm-repost-logo" type="hidden" value="<?php echo plugin_dir_url( __FILE__ ).'../../images/repost-20.png';?>">
			<?php

			wp_enqueue_style( 'ascm-repost-relatedpostlist-editorbutton-css' );
			wp_enqueue_script( 'ascm-repost-relatedpostlist-editorbutton-js' );

			wp_enqueue_script( 'ascm-tagging-min-js' );
			wp_enqueue_style('ascm-tagging-css');

			wp_enqueue_style('ascm-grid-system-admin-css');
			
			ob_start();
			?>
			<div id="ascm-repost-relatedpostlist-main-cont" style=" display: none;">
				<div id="ascm-repost-relatedpostlist-sub-cont">
					<div id="ascm-repost-relatedpostlist-header-cont">
						<span><?php _e( 'Related Post', 'ascm' ); ?></span>
					</div>
					
					<div id="ascm-repost-relatedpostlist-content-cont" class="ascm-repost-relatedpostlist-field-cont ascm-container">
						<div class="ascm-field-col s12 m12 l12">	
							<label><?php _e( 'Title', 'ascm' ); ?> : </label>
							<input type="text" id="ascm-repost-relatedpostlist-title"/>
						</div>	
						<div class="ascm-field-col s12 m12 l12">
							<label><?php _e( 'Post ID', 'ascm' ); ?></label>
							<div id="ascm-repost-relatedpostlist-postid"></div>
						</div>

					</div>


					<div id="ascm-repost-relatedpostlist-footer-cont">
						<span id="ascm-repost-relatedpostlist-apply-btn"><?php _e( 'Apply', 'ascm' ); ?></span>
						<span id="ascm-repost-relatedpostlist-cancel-btn"><?php _e( 'Cancel', 'ascm' ); ?></span>
					</div>

				</div>
			</div>	
			<script type="text/javascript">
				jQuery(document).ready(function($){

				    if ($("#ascm-repost-relatedpostlist-postid").length) {
				        //  JS for ASCM repost custom categories

				        var relatedpostlist_options = {
				            "no-duplicate": true,
				            "tags-input-name": "ascm-repost-relatedpostlist-postid",
				            "edit-on-delete": false,
				            "tags-limit" : 10,
				            "tag-char": "ID",
				            "forbidden-chars" : ["~","!","@","$","%","^","&","*","(",")","_","+","`","-","=","q","w","e","r","t","y","u","i","o","p","{","[","]","}","a","s","d","f","g","h","j","k","l",":",";","'",'"',"|","z","x","c","v","b","n","m","<",",",".",">","/","?"]
				        };
				        var ascm_tagging = $("#ascm-repost-relatedpostlist-postid").tagging(relatedpostlist_options);
				    }
				});
			</script>
			<?php
			ob_end_flush();

	    	//enqueue TinyMCE plugin script with its ID.
	    	$plugin_array["ascm_repost_button_plugin"] =  plugin_dir_url(__FILE__) . "../../admin/js/ascm-repost-relatedpostlist-editorbutton.js";
		}else{
		}

	    return $plugin_array;
	}
	
	/**
	 * This function will register the ASCM Repost editor button.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $buttons
	 *
	 * @return mixed
	 * @since  1.0.0
     *
     * @LastUpdated   April 2, 2019
	 */
	public function register_buttons_editor($buttons){
		$post_type = isset($post->post_type) ? $post->post_type : '';
		$post_type = (String)$post_type; 
		if ('ascm_repost' == $post_type) {
		}else{
	    	//register buttons with their id.
	    	array_push($buttons, "ascm_repost_button");
	    }

	    return $buttons;
	}
}
new ASCM_Repost_RelatedPostListEditorButton();