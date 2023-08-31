<?php
function display_custom_data() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'recharge_user_api';
	$data       = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );

	if ( $data ) {
		echo '<table class="wp-list-table widefat fixed">';
		echo '<thead><tr><th>Email</th><th>APP</th><th>Actions</th><th>Test</th></tr></thead>';
		echo '<tbody>';
		foreach ( $data as $row ) {
			echo '<tr>';
			// echo '<td>' . esc_html( $row['id'] ) . '</td>';
			echo '<td>' . esc_html( $row['email'] ) . '</td>';
			echo '<td>' . esc_html( $row['app'] ) . '</td>';
			echo '<td><a href="#" class="delete-row" data-id="' . esc_attr( $row['id'] ) . '">Delete</a></td>';
			echo '<td><input type="submit" value="Process" id="test-devices" data-url="' . $row['app'] . '" data-token="' . $row['token'] . '"></td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	} else {
		echo 'No data found.';
	}
}

?>
<div class="wrap">
<div>
	<?php display_custom_data(); ?>	
</div>
<div class="result-test"></div>
</div>
