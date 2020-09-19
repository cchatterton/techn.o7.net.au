<?php
/**
 * Class ASCM_BestBefore_Meta
 *
 * This class handles the meta data for ASCM BestBefore.
 *
 * @author Junjie Canonio <junjie@alphasys.com.au>
 *
 * @package  Alphasys_Content_Management
 * @LastUpdated  February 12, 2019
 * @since  1.0.0
 */
class ASCM_BestBefore_Meta{
	
	/**
	 * ASCM_BestBefore_Meta constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array($this, 'ascm_bestbefore_register_meta_boxes') );
		add_action( 'save_post' , array($this, 'ascm_bestbefore_register_save_postdata') );

		// Post Update Status cron scron callback
		add_action( 'ascm_bstbfr_updatepoststatus',  array($this, 'ascm_bestbefore_updatepoststatus') );

	}

	/**
	 * This function enqueue scripts and styles for ASCM Best Before Meta
  
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
     *
     *
	 * @LastUpdated  February 12, 2019
	 */
	public function ascm_bestbefore_meta_enqueue_scriptsstyles(){
		wp_enqueue_style( 
			'ascm-bestbefore-css', 
			plugin_dir_url( __FILE__ ) . '../../admin/css/ascm-best-before-admin.css', 
			array(), 
			'', 
			'all' 
		);

		wp_enqueue_script( 
			'ascm-bestbefore-js', 
			plugin_dir_url( __FILE__ ) . '../../admin/js/ascm-best-before-admin.js', 
			array( 'jquery' ), 
			'', 
			false 
		);

		wp_localize_script(
			'ascm-bestbefore-js',
			'ascm_bestbefore_scheduleoptions_param',
			array(
				'url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('ajax-nonce'),
				'logourl' => plugin_dir_url( __FILE__ ).'../../images/ascm.png'
			)
		);

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style( 'ascm-bestbefore-jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
	}

	/**
	 * This function handles the registration of meta boxes
	 *
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
     *
	 * @LastUpdated   February 4, 2019
	 */
	public function ascm_bestbefore_register_meta_boxes() {
		$pts = get_post_types( array( 'public' => true ) );
	    $exclude_pts = array(
	    	'attachment', 'ascm_panels', 'wfc_fundraising', 'pdwp_donation', 'wfc_donation_logs'
	    );
	    $pts = array_diff_key( $pts, array_flip( $exclude_pts ) );
	    add_meta_box( 
	    	'ascm_bestbefore_scheduleoptions', 
	    	__( 'Best Before - Post Options', 'ascm_bestbefore' ), 
	    	array( $this, 'ascm_bestbefore_scheduleoptions_callback' ),
	    	$pts,
	    	'side' 
	    );
	}

	/**
	 * This function is the callback function for 'ascm_bestbefore_scheduleoptions' meta box
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $post
	 *
	 * @LastUpdated   February 4, 2019
	 */
	public function ascm_bestbefore_scheduleoptions_callback( $post ) {
		$post_id = $post->ID;
		$user_id = get_current_user_id();


		$error = get_transient( "ascm_bb_scheduleoptions_errors_{$post_id}_{$user_id}" );
		if ($error != false) { 
			?>
		    <div class="error">
		        <p><?php echo $error->get_error_message(); ?></p>
		    </div>
		    <?php
		    delete_transient("ascm_bb_scheduleoptions_errors_{$post_id}_{$user_id}");
		}


		$this->ascm_bestbefore_meta_enqueue_scriptsstyles();

		$expdate_type = get_post_meta( $post->ID, 'ascm_bestbefore_expdate_type', true );
		$expdate_type = (!empty($expdate_type)) ? $expdate_type : 'never';
		$udpatestatus_schedule = get_post_meta( $post->ID, 'ascm_bestbefore_udpatestatus_schedule', true );
		$udpatestatus_schedule = !empty($udpatestatus_schedule) ? date("m/d/Y", $udpatestatus_schedule) : '';
		$specific_expdate = get_post_meta( $post->ID, 'ascm_bestbefore_specific_expdate', true );
		$expirepoststatus = get_post_meta( $post->ID, 'ascm_bestbefore_expirepoststatus', true );
		$expirepoststatus = (!empty($expirepoststatus)) ? $expirepoststatus : 'donotchange';

		?>
		<div class="ascm-bestbefore-scheduleoptions-main-cont">
			<div class="ascm-bestbefore-scheduleoptions-main-title">Expiration Schedule</div>
			<div class="ascm-bestbefore-scheduleoptions-sub-cont">
				<div class="ascm-bestbefore-scheduleoptions-field-cont" style="border-bottom: solid 1px #9993;">
					<div class="ascm-bestbefore-scheduleoptions-field-title">Expiry Date</div>
					<div>	
						<label>
							<input type="radio" name="ascm_bestbefore_expdate_type" value="never" <?php echo ($expdate_type == 'never') ? 'checked' : ''; ?> > Never
						</label>
						<label>	
							<input type="radio" name="ascm_bestbefore_expdate_type" value="3months" <?php echo ($expdate_type == '3months') ? 'checked' : ''; ?> > 3 Months From Now
						</label>	
						<label>
							<input type="radio" name="ascm_bestbefore_expdate_type" value="6months" <?php echo ($expdate_type == '6months') ? 'checked' : ''; ?> > 6 Months From Now
						</label>
						<label>
							<input type="radio" name="ascm_bestbefore_expdate_type" value="9months" <?php echo ($expdate_type == '9months') ? 'checked' : ''; ?> > 9 Months From Now
						</label>
						<label>	
							<input type="radio" name="ascm_bestbefore_expdate_type" value="specificdate" <?php echo ($expdate_type == 'specificdate') ? 'checked' : ''; ?> > Specific Date
						</label>
					</div>
				</div>
				<div id="ascm_bestbefore_specific_expdate_cont" class="ascm-bestbefore-scheduleoptions-field-cont" style="border-bottom: solid 1px #9993;">
					<div class="ascm-bestbefore-scheduleoptions-field-title">Expiry Specific Date</div>
					<div style="position: relative;">	
						<span id="ascm_bestbefore_cal_icon" class="dashicons dashicons-calendar-alt"></span>
						<input type="text" id="ascm_bestbefore_specific_expdate" name="ascm_bestbefore_specific_expdate" value="<?php echo $specific_expdate;?>" readonly>
					</div>
				</div>
				
				<div id="ascm_bestbefore_specific_expdate_cont" class="ascm-bestbefore-scheduleoptions-field-cont" style="border-bottom: solid 1px #9993;">
					<div class="ascm-bestbefore-scheduleoptions-field-title">Status Update Schedule</div>
					<div>	
						<input type="text" value="<?php echo $udpatestatus_schedule;?>" style="background-color: #f77d4d8a !important;">
					</div>
				</div>
				
				<div class="ascm-bestbefore-scheduleoptions-field-cont">
					<div class="ascm-bestbefore-scheduleoptions-field-title">Post Status When Expired</div>
					<div>	
						<label>
							<input type="radio" name="ascm_bestbefore_expirepoststatus" value="donotchange" <?php echo ($expirepoststatus == 'donotchange') ? 'checked' : ''; ?> > Do not change
						</label>
						<label>	
							<input type="radio" name="ascm_bestbefore_expirepoststatus" value="pending" <?php echo ($expirepoststatus == 'pending') ? 'checked' : ''; ?> >Set as Pending Review
						</label>	
						<label>	
							<input type="radio" name="ascm_bestbefore_expirepoststatus" value="draft" <?php echo ($expirepoststatus == 'draft') ? 'checked' : ''; ?> >Set as Draft
						</label>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * This function handles the save post expiration of ascm best before schedule
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $post_id
	 *
	 * @return bool
     *
     * @LastUpdated   February 4, 2019
	 */
	public function ascm_bestbefore_register_save_postdata($post_id){
		$error = false;

		$post_status =
		isset($_POST['post_status']) ? 
		$_POST['post_status'] : '';
	
		if (isset($_POST['ascm_bestbefore_expdate_type']) && !empty($post_status)) {

			$ascm_bestbefore_expdate_type =
			isset($_POST['ascm_bestbefore_expdate_type']) ? 
			$_POST['ascm_bestbefore_expdate_type'] : 'never';

			$ascm_bestbefore_specific_expdate =
			isset($_POST['ascm_bestbefore_specific_expdate']) ? 
			$_POST['ascm_bestbefore_specific_expdate'] : '';


			$ascm_bestbefore_expirepoststatus =
			isset($_POST['ascm_bestbefore_expirepoststatus']) ? 
			$_POST['ascm_bestbefore_expirepoststatus'] : 'donotchange';


			if ($ascm_bestbefore_expdate_type == 'specificdate' && empty($ascm_bestbefore_specific_expdate)) {
	       		$user_id = get_current_user_id();

	       		$error = new WP_Error();
				$error->add( 'form_error', __( "<b>Note:</b> 'Expiry Specific Date' is required if the 'Expiry Date' is set to 'Specific Date'.") );
				

	        	set_transient(
	        		"ascm_bb_scheduleoptions_errors_{$post_id}_{$user_id}", 
	        		$error, 
	        		12 * HOUR_IN_SECONDS
	        	);
	    	}else{

				if ($ascm_bestbefore_expdate_type == '3months') {
					$updatepoststatus_schedule = strtotime('+3 months');

				}elseif ($ascm_bestbefore_expdate_type == '6months') {
					$updatepoststatus_schedule = strtotime('+6 months');

				}elseif ($ascm_bestbefore_expdate_type == '9months') {
					$updatepoststatus_schedule = strtotime('+9 months');

				}elseif ($ascm_bestbefore_expdate_type == 'specificdate') {

					$updatepoststatus_schedule = strtotime($ascm_bestbefore_specific_expdate);
				}else{
					$updatepoststatus_schedule = '';
				}


				update_post_meta(
		            $post_id,
		            'ascm_bestbefore_expdate_type',
		           	$ascm_bestbefore_expdate_type
		        );

		        update_post_meta(
		            $post_id,
		            'ascm_bestbefore_udpatestatus_schedule',
		            $updatepoststatus_schedule
		        );

				update_post_meta(
		            $post_id,
		            'ascm_bestbefore_specific_expdate',
		            $ascm_bestbefore_specific_expdate
		        );

		        update_post_meta(
		            $post_id,
		            'ascm_bestbefore_expirepoststatus',
		            $ascm_bestbefore_expirepoststatus
		        );


		        if ($post_status == 'publish') {
		        	update_post_meta(
			            $post_id,
			            'ascm_bestbefore_postisexpired',
			            ''
			        );
		        }elseif ($post_status == 'draft' || $post_status == 'pending') {
		        	update_post_meta(
			            $post_id,
			            'ascm_bestbefore_postisexpired',
			            'yes'
			        );
		        }


//	        	$args = array(
//					'id' => $post_id,
//					'post_type' => get_post_type($post_id)
//				);
//		        if (!empty($updatepoststatus_schedule)) {
//		        	if (wp_next_scheduled( 'ascm_bstbfr_updatepoststatus', array($args) ) != false) {
//						wp_clear_scheduled_hook( 'ascm_bstbfr_updatepoststatus', array($args) );
//		        	}
//
//					wp_schedule_single_event(
//						$updatepoststatus_schedule,
//						'ascm_bstbfr_updatepoststatus',
//						array($args)
//					);
//		        }else{
//		        	wp_clear_scheduled_hook( 'ascm_bstbfr_updatepoststatus', array($args) );
//		        }

	    	}



		}

		return true;
	}

	/**
	 * Callback function for the update post status action hook.
	 *
	 * @author Junjie Canonio
	 *
	 * @param $datials
	 *
     * @LastUpdated   February 6, 2019
	 */
	public function ascm_bestbefore_updatepoststatus($datials) {

		$post_id = isset($datials['id']) ? $datials['id'] : '';	
		$expirepoststatus = get_post_meta( $post_id, 'ascm_bestbefore_expirepoststatus', true );
		$expirepoststatus = (!empty($expirepoststatus)) ? $expirepoststatus : 'donotchange';
		if(!empty($post_id) && !empty($expirepoststatus) && $expirepoststatus != 'donotchange'){
			wp_update_post(array('ID' => $post_id, 'post_status'   =>  $expirepoststatus));
			$post_status = get_post_status( $post_id );
			if ($post_status == 'draft' || $post_status == 'pending') {
				update_post_meta(
		            $post_id,
		            'ascm_bestbefore_postisexpired',
		            'yes'
		        );
			}

		}
	}
}