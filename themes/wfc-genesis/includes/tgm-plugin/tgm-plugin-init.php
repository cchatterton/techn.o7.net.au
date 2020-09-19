<?php
/**
 * WFC Genesis.
 *
 * This file adds TGM Plugin Activation support to the WFC Genesis Child Theme.
 *
 * @package WFC_Genesis/Core
 * @author  AlphaSys
 */

if ( defined( 'WFC_ENV' ) && strtolower( WFC_ENV ) === 'development' ) :

	require_once get_stylesheet_directory() . '/includes/tgm-plugin/tgm-plugin.php';

	add_action( 'tgmpa_register', function() {

		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// Content Management
			array(
				'name'      => 'WP Smush',
				'slug'      => 'wp-smushit',
				'required'  => true,
			),
			array(
				'name'      => 'Duplicate Post',
				'slug'      => 'duplicate-post',
				'required'  => true,
			),
			array(
				'name'      => 'Yoast SEO',
				'slug'      => 'wordpress-seo',
				'required'  => true,
			),
			array(
				'name'      => 'Redirection',
				'slug'      => 'redirection',
				'required'  => true,
			),

			// Information Architecture
			array(
				'name'      => 'CPT-onomies',
				'slug'      => 'cpt-onomies',
				'required'  => true,
			),

			// Access Authority
			array(
				'name'      => 'Adminimize',
				'slug'      => 'adminimize',
				'required'  => true,
			),
			array(
				'name'      => 'Capability Manager Enhanced',
				'slug'      => 'capability-manager-enhanced',
				'required'  => true,
			),
			array(
				'name'      => 'Stream',
				'slug'      => 'stream',
				'required'  => true,
			),

			// Diagnostic
			array(
				'name'      => 'Transients Manager',
				'slug'      => 'transients-manager',
				'required'  => false,
			),
			array(
				'name'      => 'WP Mail SMTP',
				'slug'      => 'wp-mail-smtp',
				'required'  => false,
			),

			// Utility
			array(
				'name' 		=> 'NS Cloner – Site Copier',
				'slug' 		=> 'ns-cloner-site-copier',
				'required' 	=> false,
			),
			array(
				'name' 		=> 'Query Monitor',
				'slug' 		=> 'query-monitor',
				'required' 	=> false,
			),
			array(
				'name'               => 'WP Migrate DB Pro', // The plugin name.
				'slug'               => 'wp-migrate-db-pro', // The plugin slug (typically the folder name).
				'source'             => get_stylesheet_directory() . '/includes/tgm-plugin/plugins/wp-migrate-db-pro.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			),
			array(
				'name' 		=> 'Post Type Switcher',
				'slug' 		=> 'post-type-switcher',
				'required' 	=> false,
			),
			array(
				'name' 		=> 'Regenerate Thumbnails',
				'slug' 		=> 'regenerate-thumbnails',
				'required' 	=> false,
			),
			array(
				'name'               => 'WP Offload Media Lite', // The plugin name.
				'slug'               => 'amazon-s3-and-cloudfront', // The plugin slug (typically the folder name).
				'source'             => get_stylesheet_directory() . '/includes/tgm-plugin/plugins/amazon-s3-and-cloudfront.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			),

			// Security, Backup + Recovery
			array(
				'name' 		=> 'Sucuri Security',
				'slug' 		=> 'sucuri-scanner',
				'required' 	=> false,
			),
			array(
				'name' 		=> 'Updraft Plus',
				'slug' 		=> 'updraftplus',
				'required' 	=> false,
			),
		);

		// Don't show notice for ACF when using ACF Pro.
		if ( ! file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'advanced-custom-fields-pro/acf.php' ) ) {
			$plugins[] = array(
				'name'      => 'Advanced Custom Fields',
				'slug'      => 'advanced-custom-fields',
				'required'  => true,
			);
		}

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'wfc-genesis',           // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'genesis',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'strings'      => array(
				'page_title'                      => __( 'Install Required Plugins', 'wfc-genesis' ),
				'menu_title'                      => __( 'Required Plugins', 'wfc-genesis' ),
				'installing'                      => __( 'Installing Plugin: %s', 'wfc-genesis' ),
				'updating'                        => __( 'Updating Plugin: %s', 'wfc-genesis' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'wfc-genesis' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'wfc-genesis'
				),
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'wfc-genesis'
				),
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'wfc-genesis'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'wfc-genesis'
				),
				'notice_can_activate_required'    => _n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'wfc-genesis'
				),
				'notice_can_activate_recommended' => _n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'wfc-genesis'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'wfc-genesis'
				),
				'update_link'                     => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'wfc-genesis'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'wfc-genesis'
				),
				'return'                          => __( 'Return to Required Plugins Installer', 'wfc-genesis' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'wfc-genesis' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'wfc-genesis' ),
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'wfc-genesis' ),
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'wfc-genesis' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'wfc-genesis' ),
				'dismiss'                         => __( 'Dismiss this notice', 'wfc-genesis' ),
				'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'wfc-genesis' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'wfc-genesis' ),
				'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			)
		);

		tgmpa( $plugins, $config );
	} );

endif;