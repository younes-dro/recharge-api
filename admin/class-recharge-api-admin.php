<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/younes-dro
 * @since      1.0.0
 *
 * @package    Recharge_Api
 * @subpackage Recharge_Api/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Recharge_Api
 * @subpackage Recharge_Api/admin
 * @author     Younes DRO <younesdro@gmail.com>
 */
class Recharge_Api_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Recharge_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Recharge_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/recharge-api-admin.css', array(), $this->version, 'all' );
		wp_register_style( $this->plugin_name . '-tab-css', RECHARGE_API_PLUGIN_URL . 'admin/css/skeletabs.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Recharge_Api_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Recharge_Api_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/recharge-api-admin.js', array( 'jquery' ), $this->version, false );

		wp_register_script( $this->plugin_name . '-tabs-js', RECHARGE_API_PLUGIN_URL . 'admin/js/skeletabs.js', array( 'jquery' ), $this->version, false );

		$script_params = array(
			'admin_ajax'         => admin_url( 'admin-ajax.php' ),
			'is_admin'           => is_admin(),
			'rechrage_api_nonce' => wp_create_nonce( 'recharge-api-ajax-nonce' ),
		);
		wp_localize_script( $this->plugin_name, 'RechargeApiParams', $script_params );

	}

	/**
	 * Add Menu items
	 *
	 * @since    1.0.0
	 */
	public function recharge_api_add_settings_menu() {
		add_menu_page( esc_html__( 'Recharge API', 'stargps-devices-management' ), 'Recharge API', 'publish_pages', 'recharge-api', array( $this, 'display_settings_page' ), RECHARGE_API_PLUGIN_URL . 'admin/images/logo.ico' );
	}

	/**
	 * Callback to Display settings page
	 *
	 * @since    1.0.0
	 */
	public function display_settings_page() {
		wp_enqueue_script( $this->plugin_name . '-tabs-js' );
		// wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( $this->plugin_name );

		wp_enqueue_style( $this->plugin_name . '-tab-css' );
		// wp_enqueue_style( 'jquery-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
		// wp_enqueue_script( 'postbox' );
		wp_enqueue_style( $this->plugin_name );

		require_once RECHARGE_API_PLUGIN_DIR_PATH . 'admin/partials/recharge-api-admin-display.php';

	}

	/**
	 *  Add new User API
	 */
	public function add_new_api() {
		global $wpdb;
		if ( ! is_admin() ) {
			return 'not admin';
			exit();
		}
		$url      = $_POST['url'];
		$email    = $_POST['email'];
		$password = $_POST['password'];
		$args     = array(
			'headers' => array(
				'method'        => 'GET',
				'Authorization' => 'Basic',
				'Content-Type'  => 'multipart/form-data',
			),
			'body'    => array(
				'email'    => $email,
				'password' => $password,
			),
		);

		$response_arr = wp_remote_get( $url . '/api/login', $args );
		if ( is_array( $response_arr ) ) {
			if ( $response_arr['response']['code'] === 200 ) {
				$body         = json_decode( wp_remote_retrieve_body( $response_arr ) );
				$token        = $body->user_api_hash;
				$table_api    = $wpdb->prefix . 'recharge_user_api';
				$where_clause = "  WHERE `app` = '" . $url . "' and `email` = '" . $email . "'";
				$sql_query    = "SELECT email FROM {$table_api} " . $where_clause . ' ;';
				$result       = $wpdb->get_results( $sql_query, ARRAY_A );

				if ( is_array( $result ) && count( $result ) ) {
					echo '<h1>The user already exits for this API endpoint URL</h1>';

				} else {
					$data = array(
						'email'           => $email,
						'hashed_password' => $password,
						'app'             => $url,
						'token'           => $token,
					);

					$wpdb->insert( $table_api, $data );
					echo '<h2>The API endpoint URL has been registered</h2>';
					exit();

				}
			} else {

				if ( array_key_exists( 'code', $response_arr['response'] ) ) {
					if ( $response_arr['response']['code'] == 401 ) {
						echo '<h2 class="unauthorized">Unauthorized</h2>';
					} else {
						var_dump( $response_arr['response']['code'] );
					}
				}
			}
		} else {

			echo '<h2>The API endpoint URL is wrong</h2>';
		}

		exit();
	}

	/**
	 * Delete USER API
	 */
	public function delete_user_api_row() {

		if ( isset( $_POST['row_id'] ) ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'recharge_user_api';

			$row_id = intval( $_POST['row_id'] );

			$wpdb->delete( $table_name, array( 'id' => $row_id ) );
		}
		exit();
	}

	/**
	 *
	 */

	public function save_sms_gateway_settings() {

		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		$api_url          = isset( $_POST['set-the-sms-gateway-api-url'] ) ? sanitize_text_field( trim( $_POST['set-the-sms-gateway-api-url'] ) ) : '';
		$api_key          = isset( $_POST['set-the-sms-gateway-api-key'] ) ? sanitize_text_field( trim( $_POST['set-the-sms-gateway-api-key'] ) ) : '';
		$device_name      = isset( $_POST['set-the-sms-gateway-device-name'] ) ? sanitize_text_field( trim( $_POST['set-the-sms-gateway-device-name'] ) ) : '';
		$ussd_recharge    = isset( $_POST['set-the-ussd-code-for-recharge'] ) ? sanitize_text_field( trim( $_POST['set-the-ussd-code-for-recharge'] ) ) : '';
		$ussd_balance     = isset( $_POST['set-the-ussd-code-for-balance-check'] ) ? sanitize_text_field( trim( $_POST['set-the-ussd-code-for-balance-check'] ) ) : '';
		$email_recipients = isset( $_POST['set-the-users-for-email-notifications'] ) ? sanitize_text_field( trim( $_POST['set-the-users-for-email-notifications'] ) ) : '';
		$ets_current_url  = sanitize_text_field( trim( $_POST['current_url'] ) );

		if ( $_POST['action'] == 'save_sms_gateway_settings' ) {

			if ( $api_url ) {
				update_option( 'set-the-sms-gateway-api-url', $api_url );
			}

			if ( $api_key ) {
				update_option( 'set-the-sms-gateway-api-key', $api_key );
			}

			if ( $device_name ) {
				update_option( 'set-the-sms-gateway-device-name', $device_name );
			}

			if ( $ussd_recharge ) {
				update_option( 'set-the-ussd-code-for-recharge', $ussd_recharge );
			}

			if ( $ussd_balance ) {
				update_option( 'set-the-ussd-code-for-balance-check', $ussd_balance );
			}

			if ( $email_recipients ) {
				update_option( 'set-the-users-for-email-notifications', $email_recipients );
			}

			$pre_location = $ets_current_url . '#settings';
			wp_safe_redirect( $pre_location );

		}

	}


	public function manual_recharge_request() {

		$prefix  = '*139*';
		$tel     = $_POST['formData']['tel'];
		$montant = $_POST['formData']['montant'];
		$code    = ( isset( $_POST['formData']['code'] ) && ! empty( trim( $_POST['formData']['code'] ) ) ) ? '*' . trim( $_POST['formData']['code'] ) : '';

		$command = $prefix . $tel . '*' . $montant . $code . '#';
		echo 'Command to send: <b>' . $command . '<b></b><br>';

		$device_name = sanitize_text_field( trim( get_option( 'set-the-sms-gateway-device-name' ) ) );
		$deviceID    = ( isset( $device_name ) ) ? $device_name : 11;

		try {
			$ussdRequest = sendUssdRequest( $command, $deviceID );

			echo '<pre>';

			var_dump( $ussdRequest );
			echo '</pre>';

		} catch ( Exception $e ) {

			echo $e->getMessage();

		}

		exit();
	}

	public function check_solde() {

		/**
		 * 1 - response  String start with   : 'Un SMS vous sera envoyé dans queslques secondes'
		 * 2 - Save log status.
		 *
		 * 3 -  $msgs = getMessagesByStatus( 'Received', 8, 0, time() - 86400 )
		 *      . Check msgs['deliveredDate'] >  ussdRequest['responseDate']
		 *      . $msgs['message'] String start with  'Votre solde ...'
		 * 4 - Get the the solde from the message
		 * 5 - if the slode < 500 dh => send notificatioj to list Email
		 */

		 $deviceID = $_POST['device_id'];

		 $code_ussd_balance = sanitize_text_field( trim( get_option( 'set-the-ussd-code-for-balance-check' ) ) );
		// $request = '*130#';

		try {

			$ussdRequest = sendUssdRequest( $code_ussd_balance, $deviceID );

			$id              = $ussdRequest['ID'];
			$callbackMessage = getUssdRequestByID( $id );

			while ( is_null( $callbackMessage['response'] ) ) {

				$callbackMessage = getUssdRequestByID( $id );

			}

			if ( str_starts_with( $callbackMessage['response'], 'Un SMS vous sera' ) ) {

				// Save Log
				try {
					$msgs = getMessagesByStatus( 'Received', $deviceID, 0, time() - 86400 );

					if ( is_array( $msgs ) && count( $msgs ) > 0 ) {

						foreach ( $msgs as $msg ) {

							// $delivered    = new DateTime( $msg['deliveredDate'] );
							// $responsedate = new DateTime( $callbackMessage['responseDate'] );

							$delivered    = strtotime( $msg['deliveredDate'] );
							$responsedate = strtotime( $callbackMessage['responseDate'] );

							if ( $delivered < $responsedate ) {
								$extracted_numbers = array();
								if ( str_starts_with( $msg['message'], 'Votre solde' ) ) {
									$pattern = '/\d+(\.\d+)?/';
									preg_match( $pattern, $msg['message'], $matches );
									if ( ! empty( $matches ) ) {
										$extracted_numbers[] = $matches[0];
										// echo $number . '<br>';
									}
									// echo '<pre>';
									// echo $msg['message'];
									// echo '</pre>';

								} else {

									// echo '<pre>';
									// echo $msg['message'];
									// echo '</pre>';
								}
							} else {
								echo '<br>';
								echo 'False date';
							}
						}
						if ( is_array( $extracted_numbers ) && count( $extracted_numbers ) ) {
							$lowest_number = min( $extracted_numbers );
							echo $lowest_number;
						} else {
							echo '<pre>';
							var_dump( $extracted_numbers );
							echo '</pre>';
						}
					} else {
						echo 'False : un sms ....';
					}
				} catch ( Exception $e ) {
					echo $e->getMessage();
				}
			} else {
				echo 'Un SMS vous sera....... FALSE ! ';
			}
		} catch ( Exception $e ) {
			echo $e->getMessage();
		}

		exit();
	}

	/**
	 * To remove : juste for test prupose
	 *
	 * @return void
	 */
	public function test_devices() {

		$token = $_POST['token'];
		$url   = $_POST['url'];

		$api_url      = $url . '/api/get_devices';
		$query_params = array(
			'lang'          => 'en',
			'user_api_hash' => $token,
		);

		$request_url = add_query_arg( $query_params, $api_url );
		$response    = wp_remote_get( $request_url );

		$response_code = wp_remote_retrieve_response_code( $response );
		if ( $response_code == 401 ) {
			echo '<h2>Unauthorized</h2>';
			exit();
		}

		if ( is_array( $response ) && ! is_wp_error( $response ) ) {

			$response_body  = wp_remote_retrieve_body( $response );
			$response_array = json_decode( $response_body, true );

			if ( is_array( $response_array ) && $response_array !== null ) {
				/**
				 * To check if there is more group
				 * for this exmple we only retrieve the fisrt 0 index
				 */
				$items = $response_array[0]['items'];

				foreach ( $items as $item ) {
					$device_data = $item['device_data'];
					if ( $device_data['active'] ) {
						// Save Entry log : Active status Column, value YES
						if ( ! $device_data['deleted'] ) {
							// Save Entry log : Expired Column, value No

							$current_timestamp = time();
							$next_30_days      = strtotime( '+30 days', $current_timestamp );
							$entry_timestamp   = $item['timestamp'];
							if ( $entry_timestamp <= $next_30_days ) {
								// Save entry log : Log NUMBER_OF_DAYS since the last connection under LAST_CONNECTED column

								$current_timestamp = time();
								$eighty_days_ago   = strtotime( '-80 days', $current_timestamp );
								$vin               = $device_data['vin'];
								$date_string       = substr( $vin, 0, 10 );
								$date_timestamp    = strtotime( $date_string );
								if ( $date_timestamp <= $eighty_days_ago ) {
									// Save entry log: Log NUMBER_OF_DAYS since the last recharge under LAST_RECHARGED column

									// Execute SSD
									echo 'Exceute USSD for device : ' . $item['name'];
									echo '<br>';

								} else {
									// Save entry log : Log NUMBER_OF_DAYS since the last recharge under LAST_RECHARGED column
									continue;
								}
							} else {
								// Save entry log : Log NUMBER_OF_DAYS since the last connection under LAST_CONNECTED column
								continue;
							}
						} else {
							// Save Entry log : Expired Column, value YES
							continue;
						}
					} else {

						// Save Entry log : Active status Column
						echo 'not Active';
						continue;
					}
				}
			} else {
				echo 'Failed to decode JSON response.';
			}
		}

		exit();
	}
}
