<?php
/**
* Class ASCM_Repost_RelatedPostListShortcode
 *
* This class handles all functionalities for ascm Repost shortcode.
*
* @author Junie Canonio
* @since  1.0.0
* @LastUpdated   June 26, 2018
*/
class ASCM_Repost_RelatedPostListShortcode {
	
	/**
	 * ASCM_Repost_RelatedPostListShortcode constructor.
	 */
	public function __construct () {

		add_shortcode( 'ascm-repost', array( $this , 'relatedpostlist_shortcode') );

        add_filter( 'the_content', array($this, 'relocate_relatedpostlist_shortcode' ), 10 );
	}
	
	/**
	 * This function will create shortcode for ascm repost related post list.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param          $args
	 * @param  string  $content
	 * @param          $tag
	 *
	 * @return false|string
	 * @since  1.0.0
	 *
	 * @LastUpdated   April 2, 2019
	 */
    public function relatedpostlist_shortcode($args, $content = '', $tag){   
        
        $type = isset($args['type']) ? $args['type'] : '';
        $args['type'] = $type;
        if (!empty($type) && $type == 'relatedpostlist') {

            global $wp_query;
            $post_obj = $wp_query->get_queried_object();

            if (isset($post_obj->ID) && !empty($post_obj)) {

                $current_page_ID = $post_obj->ID;

                $page_for_posts = get_option( 'page_for_posts' );

                if ($current_page_ID != $page_for_posts) {


                    $ascm_mod_settings = get_option('ascm-mod-settings-repost');

                    $ascm_repost_relatedpostlist_fallback_img = 
                    isset($ascm_mod_settings['ascm-repost-relatedpostlist-fallback-img']) ? 
                    $ascm_mod_settings['ascm-repost-relatedpostlist-fallback-img'] : '';


                    $fallback_img = wp_get_attachment_url($ascm_repost_relatedpostlist_fallback_img);
                    $fallback_img = ($fallback_img != false) ? $fallback_img : 'https://via.placeholder.com/600x400';
                    $args['fallback_img'] = $fallback_img;

                    $ascm_repost_relatedpostlist_outercontclass = 
                    isset($ascm_mod_settings['ascm-repost-relatedpostlist-outercontclass']) ? 
                    $ascm_mod_settings['ascm-repost-relatedpostlist-outercontclass'] : '';
                    $args['outercontclass'] = $ascm_repost_relatedpostlist_outercontclass;

                    $ascm_repost_relatedpostlist_innercontclass = 
                    isset($ascm_mod_settings['ascm-repost-relatedpostlist-innercontclass']) ? 
                    $ascm_mod_settings['ascm-repost-relatedpostlist-innercontclass'] : '';
                    $args['innercontclass'] = $ascm_repost_relatedpostlist_innercontclass;

                    $title = isset($args['title']) ? $args['title'] : 'Related Post';
                    $title = !empty($title) ? $title : 'Related Post';
                    $title = str_replace("~"," ",$title);
                    $args['title'] = $title;
                    

                    $id = isset($args['id']) ? $args['id'] : '';
                    $args['id'] = $id;

                    $repost_template =
                    ASCM_Repost_RelatedPostListHelper::is_custom_template_exist('repost/relatedpostlist','main.php') ? 
                    ASCM_Repost_RelatedPostListHelper::get_template_file_dir('repost/relatedpostlist','main.php') : 
                    plugin_dir_path( __FILE__ ).'../../public/templates/repost/relatedpostlist/main.php';  

                    $ascm_repost_template = ASCM_Repost_RelatedPostListHelper::get_template(
                        $repost_template,
                        array(
                            'params' => array( 
                                'configs' => $args
                            )
                        )
                    );

                    return $ascm_repost_template;
                }
            }

        }
    }
	
	/**
	 * This function will relocate the relatedpostlist shortcode to the lowest part of the content.
	 *
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $content
	 *
	 * @return mixed|string
	 * @since  1.0.0
	 *
	 * @LastUpdated   April 10, 2019
	 */
    public function relocate_relatedpostlist_shortcode( $content ) {

        if( has_shortcode( $content, 'ascm-repost' ) ) {
            $shortcode_str = '';

            preg_match('/\[.*\]/', $content, $match);
            foreach ($match as $key => $value) {
                $shortcode = (String)$value; 
                if (strpos($shortcode, 'type=relatedpostlist') !== false) {
                    $content = str_replace($shortcode,'',$content);
                    $shortcode_str .= $shortcode;
                }
            }

            $content = $content . $shortcode_str; 
        }
        return $content;
    }

}
new ASCM_Repost_RelatedPostListShortcode();