<?php

function add_record($record_type){

	global $wpdb;
	$wpdb->show_errors();

	// add the record
 $tableName = $wpdb->prefix . 'tndb_records';
 $wpdb->query("INSERT INTO `$tableName` (
		`record_type`,
		`request_time`,
		`http_user_agent`,
		`remote_addr`,
		`remote_port`
		)
VALUES (
		'$record_type',
		'$_SERVER[REQUEST_TIME]',
		'$_SERVER[HTTP_USER_AGENT]',
		'$_SERVER[REMOTE_ADDR]',
		'$_SERVER[REMOTE_PORT]'
)");

 $wpdb->hide_errors();

}

?>