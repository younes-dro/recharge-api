<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://github.com/younes-dro
 * @since      1.0.0
 *
 * @package    Recharge_Api
 * @subpackage Recharge_Api/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Recharge_Api
 * @subpackage Recharge_Api/includes
 * @author     Younes DRO <younesdro@gmail.com>
 */
class Recharge_Api_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_user_api  = $wpdb->prefix . 'recharge_user_api';
		$sql             = "CREATE TABLE IF NOT EXISTS $table_user_api (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            email varchar(50),                        
            hashed_password varchar(255),
            app varchar(100),
            token text,
			UNIQUE KEY id (id)
		) $charset_collate;";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		update_option( 'stargps_recharge_api_uuid_file_name', wp_generate_uuid4() );
	}

}
