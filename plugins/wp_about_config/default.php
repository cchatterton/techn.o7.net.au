<?php

function defaults_for_config_type() {
	$defaults = array('boolean', 'css', 'group', 'integer', 'string');
	foreach ($defaults as $default) {
		if (!term_exists( $default, 'config_type' )) wp_insert_term( $default,  'config_type'  );
	} 
}
add_action('init', 'defaults_for_config_type');

?>