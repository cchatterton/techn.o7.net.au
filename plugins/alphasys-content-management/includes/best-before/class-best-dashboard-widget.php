<?php
/**
 * Class ASCM_BestBefore_DashboardWidget
 *
 * This class handles the Dashboard widget for ASCM BestBefore.
 *
 * @author Junjie Canonio <junjie@alphasys.com.au>
 *
 * @LastUpdated   February 12, 2019
 *
 * @since  1.0.0
 */
class ASCM_BestBefore_DashboardWidget{

    public function __construct() {
        add_action( 'wp_dashboard_setup', array($this, 'ascm_add_dashboard_widget_expired_posts') );
    }
	
	/**
	 * This function register the Best Before expired post dashboard widget.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @LastUpdated   February 8, 2019
	 * @since  1.0.0
	 */
    public function ascm_add_dashboard_widget_expired_posts() {
        $logo_url = plugin_dir_url( __FILE__ ).'../../images/ascm.png';
        $logo_url = '<img id="ascm_logo" src="'.$logo_url.'">';
        wp_add_dashboard_widget(
            'ascm_expired_posts',
            $logo_url.'Best Before - Expired Post',
            array($this, 'ascm_dashboard_widget_expired_posts_content')
        );  
    }
	
	/**
	 * This function is the callback function for register the Best Before expired post dashboard widget.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
     *
	 * @LastUpdated   February 8, 2019
     *
	 * @since  1.0.0
	 */
    public function ascm_dashboard_widget_expired_posts_content() {
        // Make sure that just publicly visible post types are queried
        $pts = get_post_types( array( 'public' => true ) );
        $exclude_pts = array( 'attachment' );
        $pts = array_diff_key( $pts, array_flip( $exclude_pts ) );
        $args = array(
            'post_status' => array( 'publish', 'draft', 'pending' ),
            'post_type' => $pts,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'       => 'ascm_bestbefore_expdate_type',
                    'compare'   => 'IN',
                    'value'     => array( '3months', '6months', '9months', 'specificdate' )
                ),
                array(
                    'key'       => 'ascm_bestbefore_postisexpired',
                    'compare'   => '=',
                    'value'     => 'yes'
                )         
            )
        );
        $expired_posts_query = new WP_Query( $args );
        $maybe_expired_posts = $expired_posts_query->get_posts();
        $expired_posts = array();

        // Validate each posts if they're expired or not.
        if ( count( $maybe_expired_posts ) ) {
            foreach ( $maybe_expired_posts as $maybe_expired_post ) {
                $expdate_type = get_post_meta( $maybe_expired_post->ID, 'ascm_bestbefore_expdate_type', true );
                $expdate_type = (!empty($expdate_type)) ? $expdate_type : 'never';
                $specific_expdate = get_post_meta( $maybe_expired_post->ID, 'ascm_bestbefore_specific_expdate', true );

                if ($expdate_type != 'never' && isset($maybe_expired_post->post_type)) {
                    if (!isset ($expired_posts[$maybe_expired_post->post_type])) {
                        $expired_posts[ $maybe_expired_post->post_type ] = array();
                    }
                    array_push( $expired_posts[$maybe_expired_post->post_type] , $maybe_expired_post );
                }
            }
        }
        ?>
        <style>
            #ascm_logo{
                vertical-align: middle !important;
                margin-top: -3px;
                margin-right: 7px;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-note-cont{
                display: block;
                margin-bottom: 10px;
                color: #00000080 !important;
                display: inline-block !important;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-expired-posts-list ul.ascm_bestbefore-expired-posts-by-pt {
                padding-left: 10px;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-post-type {
                background: linear-gradient(45deg, #fea576, #fe7e75) !important;
                color: #FFFFFF !important;
                font-weight: 500 !important;
                padding: 5px 10px !important;
                margin-bottom: 10px;
                display: block;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-expired-posts-by-pt {
                margin-bottom: 10px;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-expired-posts-by-pt:last-child {
                margin-bottom: 0;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-expired-post {
                display: flex;
                padding-bottom: 6px;
                border-bottom: solid 1px #eee;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-expired-post:last-child {
                border-bottom: none;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-expired-post-link,
            .ascm_bestbefore-expired-post-title,
            .ascm_bestbefore-expired-post-status {
                margin-right: 10px;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
            .ascm_bestbefore-expired-post-status {
                flex: 1;
                text-align: right;
                transition: 300ms ease-out !important;
                -moz-transition: 300ms ease-out !important;
            }
        </style>
        <?php if ( count( $expired_posts ) ) : ?>
            <span class="ascm_bestbefore-note-cont"><b>Note : </b>These are the posts that have already expired and needs to be updated.</span>
            <ul class="ascm_bestbefore-expired-posts-list">
                <?php foreach ( $expired_posts as $pt => $expired_posts_by_pt ) : $pt = get_post_type_object( $pt ); ?>
                    <strong class="ascm_bestbefore-post-type"><?php echo isset( $pt->labels->name ) ? $pt->labels->name : 'Noname'; ?></strong>
                    <ul class="ascm_bestbefore-expired-posts-by-pt">
                        <?php foreach ( $expired_posts_by_pt as $expired_post ) : ?>
                            <li class="ascm_bestbefore-expired-post">
                                <a class="ascm_bestbefore-expired-post-link" href="<?php echo esc_url( get_edit_post_link( $expired_post ) ); ?>">
                                    <strong>#<?php echo $expired_post->ID; ?></strong>
                                </a>
                                <span class="ascm_bestbefore-expired-post-title">
                                    <a class="ascm_bestbefore-expired-post-link" href="<?php echo esc_url( get_edit_post_link( $expired_post ) ); ?>">
                                        <span><?php echo $expired_post->post_title; ?></span>
                                    </a>
                                </span>
                                <span class="ascm_bestbefore-expired-post-status"><i><?php echo $expired_post->post_status; ?></i></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>
                <i>All <strong>posts</strong> are updated.</i>
            </p>
        <?php endif; ?>
        <?php
    }
}