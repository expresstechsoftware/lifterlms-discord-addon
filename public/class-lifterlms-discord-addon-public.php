<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/public
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Lifterlms_Discord_Addon_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-addon-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-addon-public.js', array( 'jquery' ), $this->version, false );
		
	}


	public function ets_lifterlms_discord_add_connect_button() {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		wp_enqueue_style($this->plugin_name . 'public_css');
		wp_enqueue_style($this->plugin_name . 'font_awesome_css');
		wp_enqueue_script($this->plugin_name . 'public_js');
		$user_id                              = sanitize_text_field( trim( get_current_user_id() ) );
		$access_token                         = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$allow_none_member                    = sanitize_text_field( trim( get_option( 'ets_lifterlms_allow_none_member' ) ) );
		$default_role                         = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
		$ets_lifterlms_discord_role_mapping   = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
		$mapped_role_names                    = array();
		if ( $active_memberships && is_array( $all_roles ) ) {
			foreach ( $active_memberships as $active_membership ) {
				if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'level_id_' . $active_membership->product_id, $ets_lifterlms_discord_role_mapping ) ) {
					$mapped_role_id = $ets_lifterlms_discord_role_mapping[ 'level_id_' . $active_membership->product_id ];
					if ( array_key_exists( $mapped_role_id, $all_roles ) ) {
						array_push( $mapped_role_names, $all_roles[ $mapped_role_id ] );
					}
				}
			}
		}

	}

	public function ets_memberpress_show_discord_button() {
		echo do_shortcode( '[mepr_discord_button]' );
	}


	

    public function ets_lifterlms_discord_as_handler_add_member_to_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token, $active_memberships ) {
		
		if ( get_userdata( $user_id ) === false ) {
			return;
		}
		$guild_id                                = sanitize_text_field( get_option( 'ets_lifterlms_discord_server_id' ) );
		$discord_bot_token                       = sanitize_text_field( get_option( 'ets_lifterlms_discord_bot_token' ) );
		$default_role                            = sanitize_text_field( get_option( 'ets_lifterlms_discord_default_role_id' ) );
		$ets_lifterlms_discord_role_mapping    = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$discord_role                            = '';
		$discord_roles                           = array();

		if ( is_array( $active_memberships ) ) {
			foreach ( $active_memberships as $active_membership ) {
				if ( is_array( $ets_memberpress_discord_role_mapping ) && array_key_exists( 'level_id_' . $active_membership['product_id'], $ets_memberpress_discord_role_mapping ) ) {
						$discord_role = sanitize_text_field( trim( $ets_memberpress_discord_role_mapping[ 'level_id_' . $active_membership['product_id'] ] ) );
						array_push( $discord_roles, $discord_role );
				}
			}
		}

		$guilds_memeber_api_url = MEMBERPRESS_DISCORD_API_URL . 'guilds/' . $guild_id . '/members/' . $_ets_memberpress_discord_user_id;
		$guild_args             = array(
			'method'  => 'PUT',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
			'body'    => wp_json_encode(
				array(
					'access_token' => $access_token,
				)
			),
		);
		$guild_response         = wp_remote_post( $guilds_memeber_api_url, $guild_args );
		ets_memberpress_discord_log_api_response( $user_id, $guilds_memeber_api_url, $guild_args, $guild_response );
		if ( ets_memberpress_discord_check_api_errors( $guild_response ) ) {

			$response_arr = json_decode( wp_remote_retrieve_body( $guild_response ), true );
			write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			// this should be catch by Action schedule failed action.
			throw new Exception( 'Failed in function ets_as_handler_add_member_to_guild' );
		}
		foreach ( $discord_roles as $key => $discord_role ) {
			$assigned_role = array(
				'role_id' => $discord_role,
				'product_id'  => $active_memberships[ $key ]['product_id'],
			);
			update_user_meta( $user_id, '_ets_memberpress_discord_role_id_for_' . $active_memberships[ $key ]['txn_number'], $assigned_role );
			if ( $discord_role && $discord_role != 'none' && isset( $user_id ) ) {
				$this->put_discord_role_api( $user_id, $discord_role );
			}
		}

		if ( $default_role && 'none' !== $default_role && isset( $user_id ) ) {
			$this->put_discord_role_api( $user_id, $default_role );
			update_user_meta( $user_id, '_ets_memberpress_discord_default_role_id', $default_role );
		}
		if ( empty( get_user_meta( $user_id, '_ets_memberpress_discord_join_date', true ) ) ) {
			update_user_meta( $user_id, '_ets_memberpress_discord_join_date', current_time( 'Y-m-d H:i:s' ) );
		}


	}





}
