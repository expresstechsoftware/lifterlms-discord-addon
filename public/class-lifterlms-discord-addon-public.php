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

		wp_enqueue_script( $this->plugin_name. 'public_js', plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-addon-public.js', array( 'jquery' ), $this->version, false );
		$script_params = array(
			'admin_ajax'                           => admin_url( 'admin-ajax.php' ),
			'permissions_const'                    => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
			'ets_lifterlms_discord_public_nonce' => wp_create_nonce( 'ets-lifterlms-discord-public-ajax-nonce' ),
		);
		
		wp_localize_script( $this->plugin_name . 'public_js', 'etslifterlmspublicParams', $script_params );

	}
        // for understanding........................
	    // wp_enqueue_style($this->plugin_name . 'public_css');
		// wp_enqueue_style($this->plugin_name . 'font_awesome_css');
		// wp_enqueue_script($this->plugin_name . 'public_js');

	public function ets_lifterlms_discord_add_connect_button() {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		$user_id                              = sanitize_text_field( trim( get_current_user_id() ) );
		$student = llms_get_student();
		$access_token                         = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$allow_none_member                    = sanitize_text_field( trim( get_option( 'ets_lifterlms_allow_none_member' ) ) );
		$default_role                         = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
		$ets_lifterlms_discord_role_mapping   = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
		$mapped_role_names                    = array();

		//print_r($user_id)."</br>";
		//print_r($default_role );
		$courses = $student->get_courses(array('limit'=>1999));
		print_r($courses);
		if ( $courses && is_array( $all_roles ) ) {
			echo $courses;
			foreach ( $courses['results'] as $course_id ) {
				if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'course_id_' . $course_id, $ets_lifterlms_discord_role_mapping ) ) {
					
					$mapped_role_id = $ets_lifterlms_discord_role_mapping[ 'course_id_' . $course_id ];
					if ( array_key_exists( $mapped_role_id, $all_roles ) ) {
						array_push( $mapped_role_names, $all_roles[ $mapped_role_id ] );
					}
				}
			}
		}
		$default_role_name = '';
		if ( 'none' !== $default_role && is_array( $all_roles ) && array_key_exists( $default_role, $all_roles ) ) {
			$default_role_name = $all_roles[ $default_role ];
		}


		
			if ( $access_token ) {
				?>
		<section class="llms-sd-section llms-my-memberships">
				<label class="ets-connection-lbl"><?php echo __( 'Discord connection', 'lifterlms-discord-add-on' ); ?></label></br>
				<a href="#" class="ets-btn btn-disconnect" id="disconnect-discord" data-user-id="<?php echo esc_attr( $user_id ); ?>"><?php echo __( 'Disconnect From Discord ', 'lifterlms-discord-add-on' ); ?><i class='fab fa-discord'></i></a>
				<span class="ets-spinner"></span>
				
				
				<?php
			} elseif ( current_user_can( 'lifterlms_authorized' ) && $mapped_role_names || $allow_none_member == 'yes' ) {
				?>
				</br>
				
				<h3 class="llms-sd-section-title"><?php echo __( 'Discord Connection', 'lifterlms-discord-add-on' ); ?></h3>
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
			</section>
				<?php
			}
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
// ets_memberpress_discord_redirect_url
			

			if ( isset( $_GET['code'] ) && isset( $_GET['via'] ) ) {

				$code     = sanitize_text_field( $_GET['code'] );
				$response = $this->ets_lifterlms_create_discord_auth_token( $code, $user_id );
				
				if ( ! empty( $response ) && ! is_wp_error( $response ) ) {
					
					$res_body              = json_decode( wp_remote_retrieve_body( $response ), true );
					$discord_exist_user_id = sanitize_text_field( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) );
					
					if ( is_array( $res_body ) ) {
						if ( array_key_exists( 'access_token', $res_body ) ) {
							
							$access_token = sanitize_text_field( $res_body['access_token'] );
							update_user_meta( $user_id, '_ets_lifterlms_discord_access_token', $access_token );
							
							if ( array_key_exists( 'refresh_token', $res_body ) ) {
								$refresh_token = sanitize_text_field( $res_body['refresh_token'] );
								update_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', $refresh_token );
							}

							if ( array_key_exists( 'expires_in', $res_body ) ) {
								$expires_in = $res_body['expires_in'];
								$date       = new DateTime();
								$date->add( DateInterval::createFromDateString( '' . $expires_in . ' seconds' ) );
								$token_expiry_time = $date->getTimestamp();
								update_user_meta( $user_id, '_ets_lifterlms_discord_expires_in', $token_expiry_time );
							}
					       // Not call............. 
						   $user_body = $this->get_discord_current_user( $access_token );

						   if ( is_array( $user_body ) && array_key_exists( 'discriminator', $user_body ) ) {
							$discord_user_number           = $user_body['discriminator'];
							$discord_user_name             = $user_body['username'];
							$discord_user_name_with_number = $discord_user_name . '#' . $discord_user_number;
							update_user_meta( $user_id, '_ets_lifterlms_discord_username', $discord_user_name_with_number );
						  }

						  if ( is_array( $user_body ) && array_key_exists( 'id', $user_body ) ) {

							$_ets_lifterlms_discord_user_id = sanitize_text_field( $user_body['id'] );
							
							if ( $discord_exist_user_id === $_ets_lifterlms_discord_user_id ) {
									if ( ! empty( $_ets_lifterlms_discord_role_id ) && $_ets_lifterlms_discord_role_id['role_id'] != 'none' ) {
										//$this->memberpress_delete_discord_role( $user_id, $_ets_lifterlms_discord_role_id['role_id'] );
									}
								
							}
							update_user_meta( $user_id, '_ets_lifterlms_discord_user_id', $_ets_lifterlms_discord_user_id );
							$this->ets_lifterlms_discord_add_member_in_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token );
						} 

						}
					}
				}// res

		}
	}

	}

	public function ets_lifterlms_discord_add_member_in_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token ) {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}

		$allow_none_member = sanitize_text_field( get_option( 'ets_lifterlms_allow_none_member' ) );
		if ('yes' === $allow_none_member ) {
			// It is possible that we may exhaust API rate limit while adding members to guild, so handling off the job to queue.
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_handle_add_member_to_guild', array( $_ets_lifterlms_discord_user_id, $user_id, $access_token ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}
	}







	/**
	 * Create authentication token for discord API
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

	/**
	 * Disconnect user from discord
	 *
	 * @param NONE
	 * @return OBJECT JSON response
	 */


	public function ets_lifterlms_disconnect_from_discord() {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		if ( isset( $_POST['ets_lifterlms_discord_public_nonce'] ) && ! wp_verify_nonce( $_POST['ets_lifterlms_discord_public_nonce'], 'ets-lifterlms-discord-public-ajax-nonce' ) ) {
				wp_send_json_error( 'You do not have sufficient rights', 403 );
				exit();
		}
		$user_id = sanitize_text_field( $_POST['user_id'] );
		if ( $user_id ) {
			//$this->memberpress_delete_member_from_guild( $user_id, false );
			delete_user_meta( $user_id, '_ets_lifterlms_discord_access_token' );
		}
		$event_res = array(
			'status'  => 1,
			'message' => 'Successfully disconnected',
		);
		echo wp_json_encode( $event_res );
		die();
	}

	/**
	 * Get Discord user details from API
	 *
	 * @param STRING $access_token
	 * @return OBJECT REST API response
	 */

	public function get_discord_current_user( $access_token ) {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		$user_id = get_current_user_id();

		$discord_cuser_api_url = LIFTERLMS_DISCORD_API_URL . 'users/@me';
		$param                 = array(
			'headers' => array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);
		$user_response         = wp_remote_get( $discord_cuser_api_url, $param );
		//ets_lifterlms_discord_log_api_response( $user_id, $discord_cuser_api_url, $param, $user_response );

		$response_arr = json_decode( wp_remote_retrieve_body( $user_response ), true );
		write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
		$user_body = json_decode( wp_remote_retrieve_body( $user_response ), true );
		return $user_body;


	}




	}


