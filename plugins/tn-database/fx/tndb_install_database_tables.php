<?php

function install_database_tables() {

     echo 'hi';
     die();

 global $wpdb;
 $wpdb->show_errors();

 // create table tndb_records
 $tableName = $wpdb->prefix . 'tndb_records';
 $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
     `record_id` bigint(20) unsigned NOT NULL auto_increment,
     `record_type` varchar(255) default NULL,
     `parent_id` bigint(20) NOT NULL default '0',
     `request_time` varchar(255) NOT NULL default '',
     `http_user_agent` longtext,
     `remote_addr` varchar(255) default NULL,
     `remote_port` varchar(255) default NULL,
     PRIMARY KEY  (`record_id`)
     )ENGINE=MyISAM AUTO_INCREMENT=718 DEFAULT CHARSET=latin1 ;");

 // create table tbdb_values_snap
 $tableName = $wpdb->prefix . 'tndb_values_snap';
 $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
     `value_id` bigint(20) unsigned NOT NULL auto_increment,
     `record_id` bigint(20) NOT NULL default '0',
     `value_name` varchar(255) default NULL,
     `value` varchar(255) default NULL,
     PRIMARY KEY  (`value_id`)
     )ENGINE=MyISAM AUTO_INCREMENT=718 DEFAULT CHARSET=latin1 ;");

 // create table tndb_values_hist
 $tableName = $wpdb->prefix . 'tndb_values_hist';
 $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
     `value_id` bigint(20) NOT NULL,
     `record_id` bigint(20) NOT NULL default '0',
     `value_name` varchar(255) default NULL,
     `value_new` varchar(255) default NULL,
     `request_time` varchar(255) NOT NULL default '',
     `request_time_float` varchar(255) NOT NULL default ''
     )ENGINE=MyISAM;");

 $wpdb->hide_errors();



}

?>