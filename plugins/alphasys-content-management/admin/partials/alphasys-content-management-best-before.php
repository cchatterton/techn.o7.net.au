<?php

if(isset($_GET['abort']) && $_GET['abort'] == '1'){
	delete_option('ascm-best-before-postexpire-batch');
}

$ascm_bestbefore_batch = get_option('ascm-best-before-postexpire-batch');
$ascm_bestbefore_batch = empty($ascm_bestbefore_batch) || !array($ascm_bestbefore_batch) ? array() : $ascm_bestbefore_batch;

$batch_progress = isset($ascm_bestbefore_batch['batch_progress']) ? $ascm_bestbefore_batch['batch_progress'] : '0.00%';
$batch_progress = !empty($batch_progress) ? $batch_progress : '0.00%';
$num_of_records = isset($ascm_bestbefore_batch['num_of_records']) ? $ascm_bestbefore_batch['num_of_records'] : '';
$batch_status = isset($ascm_bestbefore_batch['batch_status']) ? $ascm_bestbefore_batch['batch_status'] : '';

$process_started = isset($ascm_bestbefore_batch['process_started']) ? $ascm_bestbefore_batch['process_started'] : '';
$process_started = !empty($process_started) ? date("Y-m-d H:i:s", $process_started) : '';
$process_ended = isset($ascm_bestbefore_batch['process_ended']) ? $ascm_bestbefore_batch['process_ended'] : '';
$process_ended = !empty($process_ended) ? date("Y-m-d H:i:s", $process_ended) : '';

$runexpirepostbatch_btn_status = '';
if($batch_status == 'ongoing'){
    $runexpirepostbatch_btn_status = 'ascm-bestbefore-runexpirepostbatch-btn-disabled';
}
if(isset($_GET['debug']) && $_GET['debug'] == '1') {
	global $wpdb;
	$query_count_str = "
        SELECT
            {$wpdb->prefix}posts.ID
        FROM
            {$wpdb->prefix}posts,
            {$wpdb->prefix}postmeta as pm1,
            {$wpdb->prefix}postmeta as pm2,
            {$wpdb->prefix}postmeta as pm3
        WHERE post_status = 'publish'
            AND pm1.post_id = {$wpdb->prefix}posts.ID
            AND pm2.post_id = {$wpdb->prefix}posts.ID
            AND pm3.post_id = {$wpdb->prefix}posts.ID
            AND pm1.meta_key = 'ascm_bestbefore_expdate_type'
            AND pm1.meta_value != 'never'
            AND pm2.meta_key = 'ascm_bestbefore_expirepoststatus'
            AND pm2.meta_value != 'donotchange'
            AND pm3.meta_key = 'ascm_bestbefore_udpatestatus_schedule'
            AND pm3.meta_value != ''
            AND post_type NOT IN ('attachment', 'ascm_panels', 'wfc_fundraising', 'pdwp_donation', 'wfc_donation_logs')
        GROUP BY ID
        ORDER BY post_date ASC
    ";
	$count = $wpdb->get_results($query_count_str, OBJECT);
	var_dump(count($count));
	print_r($ascm_bestbefore_batch);
}
//ASCM_BestBeforeExpirePost::ascm_bestbefore_expirepost_batch();



//$querystr = "
//			    SELECT
//			        {$wpdb->prefix}posts.ID,
//			        {$wpdb->prefix}posts.post_date,
//			        {$wpdb->prefix}posts.post_date_gmt,
//			        {$wpdb->prefix}posts.post_title,
//			        {$wpdb->prefix}posts.post_status,
//			        {$wpdb->prefix}posts.post_name,
//			        {$wpdb->prefix}posts.post_modified,
//			        {$wpdb->prefix}posts.post_modified_gmt,
//			        {$wpdb->prefix}posts.post_type,
//			        pm1.meta_key AS pm1_meta_key,
//			        pm1.meta_value AS pm1_meta_value,
//			        pm2.meta_key AS pm2_meta_key,
//			        pm2.meta_value AS pm2_meta_value,
//			        pm3.meta_key AS pm3_meta_key,
//			        pm3.meta_value AS pm3_meta_value
//				FROM
//					{$wpdb->prefix}posts,
//					{$wpdb->prefix}postmeta as pm1,
//					{$wpdb->prefix}postmeta as pm2,
//					{$wpdb->prefix}postmeta as pm3
//				WHERE {$wpdb->prefix}posts.post_status = 'publish'
//					AND	pm1.post_id = {$wpdb->prefix}posts.ID
//					AND pm2.post_id = {$wpdb->prefix}posts.ID
//					AND pm3.post_id = {$wpdb->prefix}posts.ID
//					AND pm1.meta_key = 'ascm_bestbefore_expdate_type'
//					AND pm1.meta_value != 'never'
//					AND pm2.meta_key = 'ascm_bestbefore_expirepoststatus'
//					AND pm2.meta_value != 'donotchange'
//					AND pm3.meta_key = 'ascm_bestbefore_udpatestatus_schedule'
//					AND pm3.meta_value != ''
//					AND post_type NOT IN ('attachment', 'ascm_panels', 'wfc_fundraising', 'pdwp_donation', 'wfc_donation_logs')
//					GROUP BY ID
//				ORDER BY post_date ASC
//		    ";
//$pageposts = $wpdb->get_results($querystr, OBJECT);
//print_r($pageposts);
?>
<div id="ascm-mod-settings-main-cont-bestbefore" class="ascm-mod-settings-main-cont">
    <div id="ascm-mod-settings-sub-cont-bestbefore" class="ascm-mod-settings-sub-cont">
        <div id="ascm-mod-settings-fields-cont-bestbefore" class="ascm-mod-settings-fields-cont">

            <div class="ascm-mod-settings-section-title"><?php _e( 'Daily Batch Inspection ', 'ascm' ); ?></div>

            <div class="ascm-mod-settings-field-cont ascm-field-col s12 m12 l12">
                <div id="ascm-bestbefore-myProgress">
                    <div id="ascm-bestbefore-myBar-progress-label"></div>
                    <div id="ascm-bestbefore-myBar"></div>
                </div>
            </div>
            <div class="ascm-mod-settings-field-cont ascm-field-col s12 m12 l12 ascm-bestbefore-expirepost-batch-status">
                <div class="ascm-field-col s12 m12 l9">

                    <div>
                        <span><b>Process Status : </b> <span id="ascm-bestbefore-expirepost-batch-status-label"></span></span>
                    </div>
                    <div>
                        <span><b>Number of Posts : </b> <span id="ascm-bestbefore-expirepost-batch-numpost-label"></span></span>
                    </div>
                    <div>
                        <span><b>Process Started : </b> <span id="ascm-bestbefore-expirepost-batch-started-label"></span></span>
                    </div>
                    <div>
                        <span><b>Process Ended : </b> <span id="ascm-bestbefore-expirepost-batch-ended-label"></span></span>
                    </div>

                </div>
                <div class="ascm-field-col s12 m12 l3">
                    <div>
                        <span id="ascm-bestbefore-runexpirepostbatch-btn" class="ascm-bestbefore-runexpirepostbatch-btn <?php echo esc_html__( $runexpirepostbatch_btn_status,'ascm' ); ?>"><?php _e( 'Run Expire Post Batch', 'ascm' ); ?></span>
                    </div>
                    <div id="ascm-mod-settings-expirepost-loading-cont-bestbefore" class="ascm-mod-bestbefore-expirepost-loading-cont ascm-hidden">
                        <i class="fa fa fa-spinner fa-spin fa-2x"></i>
                        <span style="padding: 5px;"><?php _e( 'Batch in progress', 'ascm' ); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="ascm-field-col s12 m12 l12">
            <div id="ascm-mod-settings-loading-cont-bestbefore" class="ascm-mod-settings-loading-cont ascm-hidden">
                <i class="fa fa fa-spinner fa-spin fa-2x"></i>
                <span style="padding: 5px;"><?php _e( 'Saving', 'ascm' ); ?> . . . . . </span>
            </div>
            <div class="ascm-mod-settings-btn-cont">
                <span id="ascm-mod-settings-cancel-btn-bestbefore" class="ascm-mod-settings-cancel-btn"><?php _e( 'Cancel', 'ascm' ); ?></span>
            </div>
        </div>
    </div>
</div>