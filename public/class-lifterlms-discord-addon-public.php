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

		//$courses = get_course_id();

		print_r($all_roles);
		//print_r($courses);


		// if ( $courses && is_array( $all_roles ) ) {
		// 	foreach ( $active_memberships as $active_membership ) {
		// 		if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'course_id' . $active_membership->product_id, $ets_lifterlms_discord_role_mapping ) ) {
		// 			$mapped_role_id = $ets_lifterlms_discord_role_mapping[ 'course_id' . $active_membership->product_id ];
		// 			if ( array_key_exists( $mapped_role_id, $all_roles ) ) {
		// 				array_push( $mapped_role_names, $all_roles[ $mapped_role_id ] );
		// 			}
		// 		}
		// 	}
		// }

		// $default_role_name = '';
		// if ( 'none' !== $default_role && is_array( $all_roles ) && array_key_exists( $default_role, $all_roles ) ) {
		// 	$default_role_name = $all_roles[ $default_role ];
		// }

		//if ( ets_lifterlms_discord_check_saved_settings_status() ) {
			if ( $access_token ) {
				?>
				<label class="ets-connection-lbl"><?php echo __( 'Discord connection', 'lifterlms-discord-add-on' ); ?></label>
				<a href="#" class="ets-btn btn-disconnect" id="disconnect-discord" data-user-id="<?php echo esc_attr( $user_id ); ?>"><?php echo __( 'Disconnect From Discord ', 'lifterlms-discord-add-on' ); ?><i class='fab fa-discord'></i></a>
				<span class="ets-spinner"></span>
				<?php
			} elseif ( current_user_can( 'lifterlms_authorized' ) && $mapped_role_names || $allow_none_member == 'yes' ) {
				?>
				</br>
				<label class="ets-connection-lbl"><?php echo __( 'Discord connection', 'lifterlms-discord-add-on' ); ?></label>
				<a href="?action=lifterlms-discord-login" class="btn-connect ets-btn" ><?php echo __( 'Connect To Discord', 'lifterlms-discord-add-on' ); ?> <i class='fab fa-discord'></i></a>
				
				<?php if ( $mapped_role_names ) { ?>
					<p class="ets_assigned_role">
					<?php
					echo __( 'Following Roles will be assigned to you in Discord: ', 'lifterlms-discord-add-on' );
					foreach ( $mapped_role_names as $mapped_role_name ) {
						echo esc_html( $mapped_role_name ) . ', ';
					}
					if ( $default_role_name ) {
						echo esc_html( $default_role_name );
					}
					?>
					</p>
				<?php } ?>
				
				<?php
			}
		//


	}

	public function ets_lifterlms_discord_discord_api_callback() {
		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			if ( isset( $_GET['action'] ) && 'lifterlms-discord-login' === $_GET['action'] ) {
				$params                    = array(
					'client_id'     => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
					'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_redirect_url' ) ) ),
					'response_type' => 'code',
					'scope'         => 'identify email connections guilds guilds.join messages.read',
				);
				$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );
 
				wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
				exit;
			}
			if ( isset( $_GET['action'] ) && 'discord-connectToBot' === $_GET['action'] ) {
				$params                    = array(
					'client_id'   => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
					'permissions' => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
					'scope'       => 'bot',
					'guild_id'    => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) ),
				);
				$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );

				wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
				exit;
			}

			

			if ( isset( $_GET['code'] ) && isset( $_GET['via'] ) ) {

				//$membership_private_obj = ets_memberpress_discord_get_active_memberships( $user_id );
				//$active_memberships     = array();
				//if ( ! empty( $membership_private_obj ) ) {
					//foreach ( $membership_private_obj as $memberships ) {
						//$membership_arr = array(
						//	'product_id' => $memberships->product_id,
						//	'txn_number' => $memberships->trans_num,
						//	'created_at' => $memberships->created_at,
						//	'expires_at' => $memberships->expires_at,
						//);
						//array_push( $active_memberships, $membership_arr );
					//}
				$code     = sanitize_text_field( $_GET['code'] );
				print_r($code);
				$response = $this->ets_lifterlms_create_discord_auth_token( $code, $user_id );
				print_r($response);
		}
	}

	}

	/**
	 * Create authentication token for discord API
	 *
	 * @param STRING $code
	 * @param INT    $user_id
	 * @return OBJECT API response
	 */

	public function ets_lifterlms_create_discord_auth_token( $code, $user_id ) {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		// stop users who having the direct URL of discord Oauth.
		$allow_none_member = sanitize_text_field( trim( get_option( 'ets_lifterlms_allow_none_member' ) ) );
		if ( empty( $active_memberships ) && 'no' === $allow_none_member ) {
			return;
		}

		$response              = '';
		$refresh_token         = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', true ) ) );
		$token_expiry_time     = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_expires_in', true ) ) );
		$discord_token_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/token';
		
		if ( $refresh_token ) {
			$date              = new DateTime();
			$current_timestamp = $date->getTimestamp();

			if ( $current_timestamp > $token_expiry_time ) {
				$args     = array(
					'method'  => 'POST',
					'headers' => array(
						'Content-Type' => 'application/x-www-form-urlencoded',
					),
					'body'    => array(
						'client_id'     => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
						'client_secret' => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_secret' ) ) ),
						'grant_type'    => 'refresh_token',
						'refresh_token' => $refresh_token,
						'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_redirect_url' ) ) ),
						'scope'         => LIFTERLMS_DISCORD_OAUTH_SCOPES,
					),
				);
				$response = wp_remote_post( $discord_token_api_url, $args );
				ets_lifterlms_discord_log_api_response( $user_id, $discord_token_api_url, $args, $response );
				if ( ets_lifterlms_discord_check_api_errors( $response ) ) {
					$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
					write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				}
			}
		} else {
			$args     = array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type' => 'application/x-www-form-urlencoded',
				),
				'body'    => array(
					'client_id'     => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
					'client_secret' => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_secret' ) ) ),
					'grant_type'    => 'authorization_code',
					'code'          => $code,
					'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_redirect_url' ) ) ),
					'scope'         => LIFTERLMS_DISCORD_OAUTH_SCOPES,
				),
			);
			$response = wp_remote_post( $discord_token_api_url, $args );

		}

		return $response;
	}


	}


