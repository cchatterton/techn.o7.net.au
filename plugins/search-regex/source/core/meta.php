<?php

namespace SearchRegex;

use SearchRegex\Search_Source;

abstract class Source_Meta extends Search_Source {
	public function get_columns() {
		$columns = [
			'meta_key',
			'meta_value',
		];

		return $columns;
	}

	public function get_column_label( $column ) {
		$labels = [
			'meta_key' => __( 'Name', 'search-regex' ),
			'meta_value' => __( 'Value', 'search-regex' ),
		];

		if ( isset( $labels[ $column ] ) ) {
			return $labels[ $column ];
		}

		return $column;
	}

	public function get_table_id() {
		return 'meta_id';
	}

	public function get_title_column() {
		return 'meta_key';
	}

	/**
	 * Return the meta object ID name
	 *
	 * @return String
	 */
	abstract public function get_meta_object_id();

	/**
	 * Return the meta table name
	 *
	 * @return String
	 */
	abstract public function get_meta_table();

	public function save( $row_id, $column_id, $content ) {
		global $wpdb;

		if ( $column_id === 'meta_key' ) {
			$content = sanitize_key( $content );

			return parent::save( $row_id, $column_id, strlen( $content ) === 0 ? $column_id : $content );
		}

		// Known values
		// phpcs:ignore
		$existing = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$this->get_table_name()} WHERE meta_id=%d", $row_id ), ARRAY_A );

		if ( $existing && update_metadata( $this->get_meta_table(), $existing[ $this->get_meta_object_id() ], $existing['meta_key'], $content, $existing['meta_value'] ) ) {
			return true;
		}

		return new \WP_Error( 'searchregex', 'Failed to update meta data: ' . $this->get_meta_table() );
	}
}
