<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/admin
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Lifterlms_Discord_Addon_Admin {

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

	/* 
		Adding child menu under top level lifterlms menu
	*/
	public function add_admin_menu() {
		add_submenu_page( 'lifterlms', __( 'Discord Settings', 'lifterlms-discord-addon' ), __( 'Discord Settings', 'lifterlms-discord-addon' ), 'manage_options', 'lifterlms-discord', array( $this, 'ets_lifterlms_discord_setting_page' ) );
	}

	/*
	Display application details
	*/
	public function ets_lifterlms_discord_setting_page(){
		require_once LIFTERLMS_PLUGIN_DIR.'admin/partials/lifterlms-discord-addon-admin-display.php';
	}


	public function ets_lifterlms_discord_save_application_details(){
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		
		$ets_lifterlms_discord_client_id = isset( $_POST['ets_lifterlms_discord_client_id'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_client_id'] ) ) : '';		
		$ets_lifterlms_discord_client_secret = isset( $_POST['ets_lifterlms_discord_client_secret'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_client_secret'] ) ) : '';		
		$ets_lifterlms_discord_redirect_page_id = isset( $_POST['ets_lifterlms_discord_redirect_page_id'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_redirect_page_id'] ) ) : '';	
		$ets_lifterlms_discord_bot_token = isset( $_POST['ets_lifterlms_discord_bot_token'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_bot_token'] ) ) : '';		
		$ets_lifterlms_discord_server_id = isset( $_POST['ets_lifterlms_discord_server_id'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_server_id'] ) ) : '';
		

			if ( wp_verify_nonce( $_POST['ets_lifterlms_discord_save_settings'], 'save_lifterlms_discord_settings' ) ) {
				
				if ( $ets_lifterlms_discord_client_id ) {
					update_option( 'ets_lifterlms_discord_client_id', $ets_lifterlms_discord_client_id );
				}

				if ( $ets_lifterlms_discord_client_secret ) {
					update_option( 'ets_lifterlms_discord_client_secret', $ets_lifterlms_discord_client_secret );
				}

				if ( $ets_lifterlms_discord_bot_token ) {
					update_option( 'ets_lifterlms_discord_bot_token', $ets_lifterlms_discord_bot_token );
				}

				if ( $ets_lifterlms_discord_redirect_page_id ) {
					
					update_option( 'ets_lifterlms_discord_redirect_page_id', $ets_lifterlms_discord_redirect_page_id );
				}

				if ( $ets_lifterlms_discord_server_id ) {
					update_option( 'ets_lifterlms_discord_server_id', $ets_lifterlms_discord_server_id );
				}

				$message = 'Your settings are saved successfully.';

				if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
					// This will delete Stale DM channels.
					delete_metadata( 'user', 0, '_ets_lifterlms_discord_dm_channel', '', true );
					$pre_location = $_SERVER['HTTP_REFERER'] . '&save_settings_msg=' . $message . '#mepr_general_settings';
					wp_safe_redirect( $pre_location );
		 		}
			}	
		}	

	/**
	 * Save plugin Advance settings.
	 *
	 * 
	 */

	public function ets_lifterlms_discord_advance_settings() {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}

		$set_job_cnrc = isset( $_POST['set_job_cnrc'] ) ? sanitize_textarea_field( trim( $_POST['set_job_cnrc'] ) ) : '';

		$set_job_q_batch_size = isset( $_POST['set_job_q_batch_size'] ) ? sanitize_textarea_field( trim( $_POST['set_job_q_batch_size'] ) ) : '';

		$retry_api_count = isset( $_POST['retry_api_count'] ) ? sanitize_textarea_field( trim( $_POST['retry_api_count'] ) ) : '';

		$ets_lifterlms_discord_send_expiration_warning_dm = isset( $_POST['ets_lifterlms_discord_send_expiration_warning_dm'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_send_expiration_warning_dm'] ) ) : false;

		$ets_lifterlms_discord_expiration_warning_message = isset( $_POST['ets_lifterlms_discord_expiration_warning_message'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_expiration_warning_message'] ) ) : '';

		$ets_lifterlms_discord_send_membership_expired_dm = isset( $_POST['ets_lifterlms_discord_send_membership_expired_dm'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_send_membership_expired_dm'] ) ) : false;

		$ets_lifterlms_discord_expiration_expired_message = isset( $_POST['ets_lifterlms_discord_expiration_expired_message'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_expiration_expired_message'] ) ) : '';

		$ets_lifterlms_discord_send_welcome_dm = isset( $_POST['ets_lifterlms_discord_send_welcome_dm'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_send_welcome_dm'] ) ) : false;

		$ets_lifterlms_discord_welcome_message = isset( $_POST['ets_lifterlms_discord_welcome_message'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_welcome_message'] ) ) : '';

		$ets_lifterlms_discord_send_membership_cancel_dm = isset( $_POST['ets_lifterlms_discord_send_membership_cancel_dm'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_send_membership_cancel_dm'] ) ) : '';

		$ets_lifterlms_discord_cancel_message = isset( $_POST['ets_lifterlms_discord_cancel_message'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_cancel_message'] ) ) : '';


		if ( isset( $_POST['advance_submit'] ) ) {

				if ( isset( $_POST['upon_failed_payment'] ) ) {
					update_option( 'ets_lifterlms_discord_payment_failed', true );
				} 
				else {
					update_option( 'ets_lifterlms_discord_payment_failed', false );
				}

				if ( isset( $_POST['log_api_res'] ) ) {
					update_option( 'ets_lifterlms_discord_log_api_response', true );
				} else {
					update_option( 'ets_lifterlms_discord_log_api_response', false );
				}


				if ( isset( $_POST['retry_failed_api'] ) ) {
					update_option( 'ets_lifterlms_retry_failed_api', true );
				} 
				else {
					update_option( 'ets_lifterlms_retry_failed_api', false );
				}


				if ( isset( $_POST['ets_lifterlms_discord_send_welcome_dm'] ) ) {
					update_option( 'ets_lifterlms_discord_send_welcome_dm', true );
				} else {
					update_option( 'ets_lifterlms_discord_send_welcome_dm', false );
				}

				if ( isset( $_POST['ets_lifterlms_discord_send_expiration_warning_dm'] ) ) {
					update_option( 'ets_lifterlms_discord_send_expiration_warning_dm', true );
				}
				 else {
					update_option( 'ets_lifterlms_discord_send_expiration_warning_dm', false );
				}


				if ( isset( $_POST['ets_lifterlms_discord_welcome_message'] ) && $_POST['ets_lifterlms_discord_welcome_message'] != '' ) {
					update_option( 'ets_lifterlms_discord_welcome_message', $ets_lifterlms_discord_welcome_message );
				} 
				else {
					update_option( 'ets_lifterlms_discord_expiration_warning_message', 'Your membership is expiring' );
				}

				if ( isset( $_POST['ets_lifterlms_discord_expiration_warning_message'] ) && $_POST['ets_lifterlms_discord_expiration_warning_message'] != '' ) {
					update_option( 'ets_lifterlms_discord_expiration_warning_message', $ets_lifterlms_discord_expiration_warning_message );
				}
				else {
					update_option( 'ets_lifterlms_discord_expiration_warning_message', 'Your membership is expiring' );
				}

				if ( isset( $_POST['ets_lifterlms_discord_expiration_expired_message'] ) && $_POST['ets_lifterlms_discord_expiration_expired_message'] != '' ) {
					update_option( 'ets_lifterlms_discord_expiration_expired_message', $ets_lifterlms_discord_expiration_expired_message );
				}
				 else {
					update_option( 'ets_lifterlms_discord_expiration_expired_message', 'Your membership is expired' );
				}

				if ( isset( $_POST['ets_lifterlms_discord_send_membership_expired_dm'] ) ) {
					update_option( 'ets_lifterlms_discord_send_membership_expired_dm', true );
				} 
				else {
					update_option( 'ets_lifterlms_discord_send_membership_expired_dm', false );
				}

				if ( isset( $_POST['ets_lifterlms_discord_send_membership_cancel_dm'] ) ) {
					update_option( 'ets_lifterlms_discord_send_membership_cancel_dm', true );
				} 
				else {
					update_option( 'ets_lifterlms_discord_send_membership_cancel_dm', false );
				}

				if ( isset( $_POST['ets_lifterlms_discord_cancel_message'] ) && $_POST['ets_lifterlms_discord_cancel_message'] != '' ) {
					update_option( 'ets_lifterlms_discord_cancel_message', $ets_lifterlms_discord_cancel_message );
				} else {
					update_option( 'ets_lifterlms_discord_cancel_message', 'Your membership is canceled' );
				}

				if ( isset( $_POST['set_job_cnrc'] ) ) {
					if ( $set_job_cnrc < 1 )
					 {
						update_option( 'ets_lifterlms_discord_job_queue_concurrency', 1 );
					} 
					else {
						update_option( 'ets_lifterlms_discord_job_queue_concurrency', $set_job_cnrc );
					}
				}

				if ( isset( $_POST['set_job_q_batch_size'] ) ) {
					if ( $set_job_q_batch_size < 1 ) {
						update_option( 'ets_lifterlms_discord_job_queue_batch_size', 1 );
					} 
					else {
						update_option( 'ets_lifterlms_discord_job_queue_batch_size', $set_job_q_batch_size );
					}
				}

				if ( isset( $_POST['ets_lifterlms_retry_api_count'] ) ) {
					if ( $retry_api_count < 1 ) {
						update_option( 'ets_lifterlms_retry_api_count', 1 );
					} else {
						update_option( 'ets_lifterlms_retry_api_count', $retry_api_count );
					}
				}
				$message = 'Your settings are saved successfully.';

				if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
					$pre_location = $_SERVER['HTTP_REFERER'] . '&save_settings_msg=' . $message . '#mepr_advance';
					wp_safe_redirect( $pre_location );
				}
			}	
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
		 * defined in Lifterlms_Discord_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lifterlms_Discord_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name . 'tabs_css', plugin_dir_url( __FILE__ ) . 'css/skeletabs.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-addon-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name."select2.css", plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
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
		 * defined in Lifterlms_Discord_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lifterlms_Discord_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name.'skeletabs.js', plugin_dir_url( __FILE__ ) . 'js/skeletabs.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-addon-admin.js', array( 'jquery' ), $this->version, true );
		

	}

}
