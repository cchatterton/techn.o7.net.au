<?php
/**
 * Class ASCM_BestBeforeExpirePost
 * This class handles all functionalities for ascm Best Before expire post functionality.
 *
 * @author Junie Canonio
 * @since  1.0.0
 * @LastUpdated   October 16, 2019
 */
class ASCM_BestBeforeExpirePost {

	/**
	 * ASCM_BestBeforeExpirePost constructor.
	 */
	public function __construct () {
		add_action('ascm_best_before_expirepost', array($this,'best_before_expirepost') );
	}

	public function best_before_expirepost() {
		$ascm_bestbefore_batch = get_option('ascm-best-before-postexpire-batch');
		$ascm_bestbefore_batch = empty($ascm_bestbefore_batch) || !array($ascm_bestbefore_batch) ? array() : $ascm_bestbefore_batch;

		$batch_status = isset($ascm_bestbefore_batch['batch_status']) ? $ascm_bestbefore_batch['batch_status'] : '';
		if($batch_status == 'done'){
			ASCM_BestBeforeExpirePost::ascm_bestbefore_expirepost_batch();
		}
	}

	/**
	 * Insert panels before the footer of the page base on the settings on ASCM Panels "Panels on Pages" option.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @since  1.0.0
	 *
	 * @LastUpdated   October 16, 2019
	 *
	 */
	public static function ascm_bestbefore_expirepost_batch() {

		global $wpdb;

		$query_count_str = "
		    SELECT 
		        {$wpdb->prefix}posts.ID
			FROM
				{$wpdb->prefix}posts,
				{$wpdb->prefix}postmeta as pm1,
				{$wpdb->prefix}postmeta as pm2,
				{$wpdb->prefix}postmeta as pm3
			WHERE {$wpdb->prefix}posts.post_status = 'publish'
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
		//$count = $wpdb->get_var($query_count_str);
		$count = $wpdb->get_results($query_count_str, OBJECT);
		$count = count($count);

		$record_limit = 50;
		$record_offset = 0;

		$numofbatchchunk = $count / $record_limit;
		$numofbatchchunk = ceil($numofbatchchunk);

		$current_batch_chunk = 0;

		$best_before_expirepost_batch_arr = array(
			'batch_status' => 'ongoing',
			'batch_progress' => 0,
			'current_batch_chunk' => $current_batch_chunk,
			'max_num_of_record_per_batch_chunk' => $record_limit,
			'num_of_records' => $count,
			'num_of_batch_chunk' => $numofbatchchunk,
			'process_started' => time(),
			'process_ended' => '',
			'batch_chunk_query' => array()
		);

		for ($j = 1; $j <= $numofbatchchunk; $j++) {
			$querystr = "
			    SELECT 
			        {$wpdb->prefix}posts.ID, 
			        {$wpdb->prefix}posts.post_date, 
			        {$wpdb->prefix}posts.post_date_gmt, 
			        {$wpdb->prefix}posts.post_title, 
			        {$wpdb->prefix}posts.post_status, 
			        {$wpdb->prefix}posts.post_name, 
			        {$wpdb->prefix}posts.post_modified, 
			        {$wpdb->prefix}posts.post_modified_gmt, 
			        {$wpdb->prefix}posts.post_type, 
			        pm1.meta_key AS pm1_meta_key, 
			        pm1.meta_value AS pm1_meta_value, 
			        pm2.meta_key AS pm2_meta_key, 
			        pm2.meta_value AS pm2_meta_value,
			        pm3.meta_key AS pm3_meta_key, 
			        pm3.meta_value AS pm3_meta_value
				FROM
					{$wpdb->prefix}posts,
					{$wpdb->prefix}postmeta as pm1,
					{$wpdb->prefix}postmeta as pm2,
					{$wpdb->prefix}postmeta as pm3
				WHERE {$wpdb->prefix}posts.post_status = 'publish'
					AND	pm1.post_id = {$wpdb->prefix}posts.ID
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
				LIMIT {$record_limit}
				OFFSET {$record_offset}
		    ";

			$best_before_expirepost_batch_arr['batch_chunk_query'][] = $querystr;
			$record_offset = $j * $record_limit;
		}

		update_option('ascm-best-before-postexpire-batch', $best_before_expirepost_batch_arr);
		//get_option('best_before_batch_expirepost');

		if(isset($best_before_expirepost_batch_arr['batch_chunk_query'][0]) && !empty($best_before_expirepost_batch_arr['batch_chunk_query'][0])){
			self::ascm_bestbefore_expirepost_batchchunck($best_before_expirepost_batch_arr['batch_chunk_query'][$current_batch_chunk]);
		}else{
			$best_before_expirepost_batch_arr = array(
				'batch_status' => 'no post to expire',
				'batch_progress' => 0,
				'current_batch_chunk' => $current_batch_chunk,
				'max_num_of_record_per_batch_chunk' => $record_limit,
				'num_of_records' => $count,
				'num_of_batch_chunk' => $numofbatchchunk,
				'process_started' => time(),
				'process_ended' => time(),
				'batch_chunk_query' => array()
			);

			update_option('ascm-best-before-postexpire-batch', $best_before_expirepost_batch_arr);
		}

	}


	public static function ascm_bestbefore_expirepost_batchchunck($current_query) {
		global $wpdb;

		$expirepost_batch_arr = get_option('ascm-best-before-postexpire-batch');
		if(is_array($expirepost_batch_arr) && !empty($expirepost_batch_arr)){

			$current_batch_chunk = isset($expirepost_batch_arr['current_batch_chunk']) ? $expirepost_batch_arr['current_batch_chunk'] : '';
			$record_limit = isset($expirepost_batch_arr['max_num_of_record_per_batch_chunk']) ? $expirepost_batch_arr['max_num_of_record_per_batch_chunk'] : '';
			$count = isset($expirepost_batch_arr['num_of_records']) ? $expirepost_batch_arr['num_of_records'] : '';
			$numofbatchchunk = isset($expirepost_batch_arr['num_of_batch_chunk']) ? $expirepost_batch_arr['num_of_batch_chunk'] : '';
			$process_started = isset($expirepost_batch_arr['process_started']) ? $expirepost_batch_arr['process_started'] : '';
			$batch_chunk_query = isset($expirepost_batch_arr['batch_chunk_query']) ? $expirepost_batch_arr['batch_chunk_query'] : array();

			$current_batch_chunk = (int)$current_batch_chunk + 1;

			if($current_batch_chunk == $numofbatchchunk && $current_batch_chunk != 1){

				$percent = $current_batch_chunk/$numofbatchchunk;
				$percent_friendly = number_format( $percent * 100, 2 ) . '%';

				$best_before_expirepost_batch_arr = array(
					'batch_status' => 'done',
					'batch_progress' => $percent_friendly,
					'current_batch_chunk' => $current_batch_chunk,
					'max_num_of_record_per_batch_chunk' => $record_limit,
					'num_of_records' => $count,
					'num_of_batch_chunk' => $numofbatchchunk,
					'process_started' => $process_started,
					'process_ended' => time(),
					'batch_chunk_query' => $batch_chunk_query
				);
				update_option('ascm-best-before-postexpire-batch', $best_before_expirepost_batch_arr);

				$query = '';

			}else if($current_batch_chunk == $numofbatchchunk && $current_batch_chunk == 1){

				$pageposts = $wpdb->get_results($current_query, OBJECT);

				if (!empty($pageposts)){
					foreach ($pageposts as $key => $value){
						if (time() > (int)$value->pm3_meta_value) {
							self::ascm_bestbefore_updatepoststatus($value);
						}
					}
				}

				$percent = $current_batch_chunk/$numofbatchchunk;
				$percent_friendly = number_format( $percent * 100, 2 ) . '%';

				$best_before_expirepost_batch_arr = array(
					'batch_status' => 'done',
					'batch_progress' => $percent_friendly,
					'current_batch_chunk' => $current_batch_chunk,
					'max_num_of_record_per_batch_chunk' => $record_limit,
					'num_of_records' => $count,
					'num_of_batch_chunk' => $numofbatchchunk,
					'process_started' => $process_started,
					'process_ended' => time(),
					'batch_chunk_query' => $batch_chunk_query
				);
				update_option('ascm-best-before-postexpire-batch', $best_before_expirepost_batch_arr);

				$query = isset($best_before_expirepost_batch_arr['batch_chunk_query'][$current_batch_chunk]) ? $best_before_expirepost_batch_arr['batch_chunk_query'][$current_batch_chunk] : '';

			} else{

				$pageposts = $wpdb->get_results($current_query, OBJECT);

				if (!empty($pageposts)){
					foreach ($pageposts as $key => $value){
						if (time() > (int)$value->pm3_meta_value) {
							self::ascm_bestbefore_updatepoststatus($value);
						}
					}
				}

				$percent = $current_batch_chunk/$numofbatchchunk;
				$percent_friendly = number_format( $percent * 100, 2 ) . '%';

				$best_before_expirepost_batch_arr = array(
					'batch_status' => 'ongoing',
					'batch_progress' => $percent_friendly,
					'current_batch_chunk' => $current_batch_chunk,
					'max_num_of_record_per_batch_chunk' => $record_limit,
					'num_of_records' => $count,
					'num_of_batch_chunk' => $numofbatchchunk,
					'process_started' => $process_started,
					'process_ended' => '',
					'batch_chunk_query' => $batch_chunk_query
				);
				update_option('ascm-best-before-postexpire-batch', $best_before_expirepost_batch_arr);

				$query = isset($best_before_expirepost_batch_arr['batch_chunk_query'][$current_batch_chunk]) ? $best_before_expirepost_batch_arr['batch_chunk_query'][$current_batch_chunk] : '';

			}

			if (!empty($query)){
				self::ascm_bestbefore_expirepost_batchchunck($query);
			}

		}

	}

	public static function ascm_bestbefore_updatepoststatus($datials) {

		$post_id = isset($datials->ID) ? $datials->ID : '';
		$expirepoststatus = isset($datials->pm2_meta_value) ? $datials->pm2_meta_value : '';
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
new ASCM_BestBeforeExpirePost();

