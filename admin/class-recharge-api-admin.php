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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
			'admin_ajax'                      => admin_url( 'admin-ajax.php' ),
			'is_admin'                        => is_admin(),
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
	 *
	 */
	public function add_new_api() {
		global $wpdb;
		if ( ! is_admin() ) {
			exit();
		}
		$url = $_POST['url'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$args = array(
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
				$body = json_decode( wp_remote_retrieve_body( $response_arr ) );
				// return array(
				// 	'status' => 'ok',
				// 	'token'  => $body->user_api_hash,
				// );
				$token = $body->user_api_hash;
				$table_api = $wpdb->prefix . 'recharge_user_api';
				$where_clause = "  WHERE `email` = '" . $email . "'";
				$sql_query    = "SELECT email FROM {$table_api} " . $where_clause . ' ;';
				$result = $wpdb->get_results( $sql_query, ARRAY_A );
				if ( is_array( $result ) && count( $result ) ) {
			
					return false;
				} else {
					$data = array(
						'email'    => $email,
						'hashed_password' => $password,
						'app'      => $url,
						'token'    => $token,
					);
			
					$wpdb->insert( $table_api, $data );
					return 'ok';
				
				}

			} else {
				return $response_arr['response'];
			}
		}

		exit();
	}

}
