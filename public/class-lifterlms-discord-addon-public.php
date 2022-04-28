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
		wp_enqueue_style( $this->plugin_name . 'public_css', plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-public.min.css', array(), $this->version, 'all' );
	
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
		wp_enqueue_script( $this->plugin_name . 'public_js', plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-public.min.js', array( 'jquery' ), $this->version, false );

		$script_params = array(
			'admin_ajax'                           => admin_url( 'admin-ajax.php' ),
			'permissions_const'                    => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
			'ets_lifterlms_discord_public_nonce' => wp_create_nonce( 'ets-lifterlms-discord-public-ajax-nonce' ),
		);
		wp_localize_script( $this->plugin_name . 'public_js', 'etsLifterlmspublicParams', $script_params );
	}

	/**
	 * Add discord connection buttons.
	 *
	 * @since    1.0.0
	 */
	public function ets_lifterlms_discord_add_connect_button() {

	if(is_user_logged_in()){
		$user_id                              = sanitize_text_field( get_current_user_id() );
		$access_token                         = sanitize_text_field( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) );
		$allow_none_member                    = sanitize_text_field( get_option( 'ets_lifterlms_allow_none_member' ) );
		$default_role                         = sanitize_text_field( get_option( 'ets_lifterlms_discord_default_role_id' ) );
		$ets_lifterlms_discord_role_mapping   = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
		$mapped_role_names                    = array();
        $student                              = llms_get_student();
		$courses = $student->get_courses();
		
		if ( $courses && is_array( $all_roles ) ) {
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
				<label class="ets-connection-lbl">
					<?php echo __( 'Discord connection', 'lifterlms-discord-addon' ); ?>
				</label><br>

				<a href="#" class="ets-btn btn-disconnect" id="disconnect-discord" data-user-id="<?php echo esc_attr( $user_id ); ?>"><?php echo __( 'Disconnect From Discord ', 'lifterlms-discord-addon' ); ?><i class='fab fa-discord'></i></a>
				<section class="llms-sd-section llms-my-memberships">
				
				<?php if ( $mapped_role_names ) { ?>
					<p class="ets_assigned_role">
					<?php
					echo __( 'Following Roles will be assigned to you in Discord: ', 'lifterlms-discord-addon' );
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
			} elseif ( $mapped_role_names || $allow_none_member == 'yes' ) {
				?>
				<label class="ets-connection-lbl"><br>
					<?php echo __( 'Discord connection', 'lifterlms-discord-addon' ); ?>
				</label><br>
				<a href="?action=lifterlms-discord-login" class="btn-connect ets-btn" ><?php echo __( 'Connect To Discord', 'lifterlms-discord-addon' ); ?> <i class='fab fa-discord'></i></a>
				
			<section class="llms-sd-section llms-my-memberships">
				
				<?php if ( $mapped_role_names ) { ?>
					<p class="ets_assigned_role">
					<?php
					echo __( 'Following Roles will be assigned to you in Discord: ', 'lifterlms-discord-addon' );
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
}
	/**
	 *  initialize discord authentication.
	 * 
	 *
	 */

	public function ets_lifterlms_discord_login() {
		if(isset($_GET['action']) && $_GET['action']=='lifterlms-discord-login'){
			$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize';
			$params                    = array(
				'client_id'            => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
				'permissions'          => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
				'scope'                => LIFTERLMS_DISCORD_OAUTH_SCOPES,
				'guild_id'             => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) ),
				'disable_guild_select' => 'true',
				'redirect_uri'         => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_redirect_url' ) ) ),
				'response_type'        => 'code',
			);

			$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );
			wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
			exit;
		}

		if ( isset( $_GET['code'] ) && isset( $_GET['via'] ) && $_GET['via'] =='lifterlms-discord' ) {

			$user_id = get_current_user_id();
			$code    = sanitize_text_field( trim( $_GET['code'] ) );
			$response = $this->ets_lifterlms_discord_auth_token( $code, $user_id );

			/* Get_responce* */

			if ( ! empty( $response ) ) {	
				$res_body              = json_decode( wp_remote_retrieve_body( $response ), true );
				$discord_exist_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
				
				if ( is_array( $res_body ) ) {
					if ( array_key_exists( 'access_token', $res_body ) ) {
						$access_token = sanitize_text_field( trim( $res_body['access_token'] ) );
						update_user_meta( $user_id, '_ets_lifterlms_discord_access_token', $access_token );
						
						if ( array_key_exists( 'refresh_token', $res_body ) ) {
							$refresh_token = sanitize_text_field( trim( $res_body['refresh_token'] ) );
							update_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', $refresh_token );
						}
						if ( array_key_exists( 'expires_in', $res_body ) ) {
							$expires_in = $res_body['expires_in'];
							$date       = new DateTime();
							$date->add( DateInterval::createFromDateString( '' . $expires_in . ' seconds' ) );
							$token_expiry_time = $date->getTimestamp();
							update_user_meta( $user_id, '_ets_lifterlms_discord_expires_in', $token_expiry_time );
						}
        /*  function call */
						$user_body = $this->get_discord_current_user_id( $access_token );
						
						if ( is_array( $user_body ) && array_key_exists( 'discriminator', $user_body ) ) {
							$discord_user_number           = $user_body['discriminator'];
							$discord_user_name             = $user_body['username'];
							$discord_user_name_with_number = $discord_user_name . '#' . $discord_user_number;
							update_user_meta( $user_id, '_ets_lifterlms_discord_username', $discord_user_name_with_number );
						}
						if ( is_array( $user_body ) && array_key_exists( 'id', $user_body ) ) {
							$_ets_lifterlms_discord_user_id = sanitize_text_field( trim( $user_body['id'] ) );
							update_user_meta( $user_id, '_ets_lifterlms_discord_user_id', $_ets_lifterlms_discord_user_id );
						/*
							call function ets_lifterlms_discord_add_member_in_guild()
						 */	
							
						 	//$this->ets_lifterlms_discord_as_handler_add_member_to_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token );
							$this->ets_lifterlms_discord_add_member_in_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token );
							
						
						}
					}
				}
			}
	  }
}
	/**
	 * Method to add new members to discord guild.
	 *
	 *  $_ets_lifterlms_discord_user_id
	 *  $user_id
	 *  $access_token
	 */

	public function ets_lifterlms_discord_add_member_in_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token ) {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		$allow_none_member = sanitize_text_field( get_option( 'ets_lifterlms_allow_none_member' ) );
		if ( 'yes' === $allow_none_member ) {	
				as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_handle_add_member_to_guild', array( $_ets_lifterlms_discord_user_id, $user_id, $access_token ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}
	}


	public function ets_lifterlms_discord_as_handler_add_member_to_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token ) {
		if ( get_userdata( $user_id ) === false ) {
			return;
		}
		$guild_id                                = sanitize_text_field( get_option( 'ets_lifterlms_discord_server_id' ) );
		$discord_bot_token                       = sanitize_text_field( get_option( 'ets_lifterlms_discord_bot_token' ) );
		$default_role                            = sanitize_text_field( get_option( 'ets_lifterlms_discord_default_role_id' ) );
		$ets_lifterlms_discord_role_mapping    = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$ets_lifterlms_discord_send_welcome_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_welcome_dm' ) ) );
		//$mapped_role_names                    = array();
		//$mapped_role_id                            = '';
		$discord_roles                           = array();
		$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
		$student                              = llms_get_student($user_id);
		$courses = $student->get_courses();

		$guilds_memeber_api_url = LIFTERLMS_DISCORD_API_URL . 'guilds/' . $guild_id . '/members/' . $_ets_lifterlms_discord_user_id;
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
		
		if ( $courses && is_array( $all_roles ) ) {
			foreach ( $courses['results'] as $course_id ) {
				if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'course_id_' . $course_id, $ets_lifterlms_discord_role_mapping ) ) {
					$mapped_role_id = $ets_lifterlms_discord_role_mapping[ 'course_id_' . $course_id ];
						$this->ets_lifterlms_discord_as_handler_put_memberrole( $user_id, $mapped_role_id );
					}
			}
		}
		if ( $default_role && 'none' !== $default_role && isset( $user_id ) ) {
			$this->ets_lifterlms_discord_as_handler_put_memberrole( $user_id, $default_role );
			update_user_meta( $user_id, '_ets_lifterlms_discord_default_role_id', $default_role );
		}

		// Send welcome message.
		if ( true == $ets_lifterlms_discord_send_welcome_dm ) {
			//$this->ets_lifterlms_discord_handler_send_dm( $user_id, 'welcome' );
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_send_welcome_dm', array( $user_id, 'welcome' ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}
		
	} 
	/**
	 * Action Schedule handler for mmeber change role discord.
	 * $user_id
	 * $role_id
	 * API response
	 */
	public function ets_lifterlms_discord_as_handler_put_memberrole( $user_id, $role_id ) {
		
		$access_token                     = sanitize_text_field( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) );	
		$guild_id                         = sanitize_text_field( get_option( 'ets_lifterlms_discord_server_id' ) );	
		$_ets_lifterlms_discord_user_id = sanitize_text_field( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) );
		$discord_bot_token                = sanitize_text_field( get_option( 'ets_lifterlms_discord_bot_token' ) );	
		$discord_change_role_api_url      = LIFTERLMS_DISCORD_API_URL . 'guilds/' . $guild_id . '/members/' . $_ets_lifterlms_discord_user_id . '/roles/' . $role_id;

		if ( $access_token && $_ets_lifterlms_discord_user_id ) {
			$param = array(
				'method'  => 'PUT',
				'headers' => array(
					'Content-Type'   => 'application/json',
					'Authorization'  => 'Bot ' . $discord_bot_token,
					'Content-Length' => 0,
				),
			);
			
			$response = wp_remote_get( $discord_change_role_api_url, $param );
			$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );	
		}
	}
     /**
	 *  Responce/auth_token
	 *
	 */
	public function ets_lifterlms_discord_auth_token( $code, $user_id ) {
	
		$response              = '';
		$refresh_token         = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', true ) ) );
		$token_expiry_time     = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_expires_in', true ) ) );
		$discord_token_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/token';

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
		return $response;
	}

	/**
	 * Get Discord user details from API
	 *
	 */
	public function get_discord_current_user_id( $access_token ) {
		
		$user_id = get_current_user_id();

		$discord_cuser_api_url = LIFTERLMS_DISCORD_API_URL . 'users/@me';
		$param                 = array(
			'headers' => array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);
		$user_response         = wp_remote_get( $discord_cuser_api_url, $param );

		$response_arr = json_decode( wp_remote_retrieve_body( $user_response ), true );
		$user_body = json_decode( wp_remote_retrieve_body( $user_response ), true );
		return $user_body;
		
	}

	/**
	 * Disconnect user from discord
	 *
	 */
	public function ets_lifterlms_disconnect_from_discord() {
		if ( is_user_logged_in() ) {
				/*
				Check for nonce security here
				*/
					if ( isset( $_POST['ets_lifterlms_discord_public_nonce'] ) && ! wp_verify_nonce( $_POST['ets_lifterlms_discord_public_nonce'], 'ets-lifterlms-discord-public-ajax-nonce' ) ) {
							wp_send_json_error( 'You do not have sufficient rights', 403 );
							exit();
					}
					$ets_lifterlms_discord_kick_upon_disconnect  = sanitize_text_field( get_option( 'ets_lifterlms_discord_kick_upon_disconnect' ) );
					$user_id = sanitize_text_field( $_POST['user_id'] );

					if ( $user_id ) {

						 if(!$ets_lifterlms_discord_kick_upon_disconnect == true) {
							$this->ets_lifterlms_discord_as_handler_delete_member_from_guild( $user_id );
						} 
						/*Delete all usermeta related to discord connection*/
						delete_user_meta( $user_id, '_ets_lifterlms_discord_user_id' );
						delete_user_meta( $user_id, '_ets_lifterlms_discord_access_token' );
						delete_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token' );
						delete_user_meta( $user_id, '_ets_lifterlms_discord_default_role_id' );
						delete_user_meta( $user_id, '_ets_lifterlms_discord_username' );
						delete_user_meta( $user_id, '_ets_lifterlms_discord_expires_in' );
					}
					
					$event_res = array(
						'status'  => 1,
						'message' => 'Successfully disconnected',
					);
					echo wp_json_encode( $event_res );
					die();
		}
		else{
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
	}	


		/**
	 * AS Handling member delete from huild
	 *
	 * @param INT  $user_id
	 * @param BOOL $is_schedule
	 * @return OBJECT API response
	 */
	public function ets_lifterlms_discord_as_handler_delete_member_from_guild( $user_id ) {
		$guild_id                         = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) );
		$discord_bot_token                = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );
		$_ets_lifterlms_discord_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$guilds_delete_memeber_api_url    = LIFTERLMS_DISCORD_API_URL . 'guilds/' . $guild_id . '/members/' . $_ets_lifterlms_discord_user_id;
		$guild_args                       = array(
			'method'  => 'DELETE',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
		);
		$guild_response   = wp_remote_post( $guilds_delete_memeber_api_url, $guild_args );
		$response_arr = json_decode( wp_remote_retrieve_body( $guild_response ), true );
		
	}


	public function ets_lifterlms_discord_handler_send_dm( $user_id, $type = 'warning', $attempt = null ) {
		
		$discord_user_id                                   = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$discord_bot_token                                 = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );
		$ets_lifterlms_discord_welcome_message            = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_welcome_message' ) ) );
		//$ets_lifterlms_discord_cancel_message             = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_cancel_message' ) ) );
		$ets_lifterlms_discord_quiz_complete            = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_quiz_complete' ) ) );
		$ets_lifterlms_discord_failed_Quiz            = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_failed_Quiz' ) ) );
		$ets_lifterlms_discord_paas_quiz            = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_paas_quiz' ) ) );
		$ets_lifterlms_discord_attempt            = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_attempt' ) ) );
		
		
		// Check if DM channel is already created for the user.
		$user_dm = get_user_meta( $user_id, '_ets_lifterlms_discord_dm_channel', true );

		if ( ! isset( $user_dm['id'] ) || false === $user_dm || empty( $user_dm ) ) {
			$this->ets_lifterlms_discord_create_member_dm_channel( $user_id );
			$user_dm       = get_user_meta( $user_id, '_ets_lifterlms_discord_dm_channel', true );
			$dm_channel_id = $user_dm['id'];
		} else {
			$dm_channel_id = $user_dm['id'];
		}
		
		if ( 'welcome' === $type ) {
			$message = $this->ets_lifterlms_discord_get_formatted_dm($user_id, $ets_lifterlms_discord_welcome_message);
		}

		if ( 'complete' === $type ) {
			$message = $this->ets_lifterlms_discord_get_formatted_dm($user_id, $ets_lifterlms_discord_quiz_complete);
			
		}
		if ( 'failed' === $type ) {
			$message = $this->ets_lifterlms_discord_get_formatted_dm($user_id, $ets_lifterlms_discord_failed_Quiz);
		}

		if ( 'passed' === $type ) {
			$message = $this->ets_lifterlms_discord_get_formatted_dm($user_id, $ets_lifterlms_discord_paas_quiz );
		}

		if ( 'attempt' === $type ) {
			$message = $this->format_Quiz_DM_message($user_id, $attempt, $ets_lifterlms_discord_attempt);
			//$message = $this->ets_lifterlms_discord_get_formatted_dm($user_id, $ets_lifterlms_discord_attempt );
		}

		
		$creat_dm_url = LIFTERLMS_DISCORD_API_URL . '/channels/' . $dm_channel_id . '/messages';
		$dm_args      = array(
			'method'  => 'POST',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
			'body'    => wp_json_encode(
				array(
					'content' => sanitize_text_field( trim( wp_unslash( $message ) ) ),
				)
			),
		);


		$dm_response  = wp_remote_post( $creat_dm_url, $dm_args );
		$dm_response_body = json_decode( wp_remote_retrieve_body( $dm_response ), true );

	}


	public function ets_lifterlms_discord_create_member_dm_channel( $user_id ) {

		$discord_user_id       = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$discord_bot_token     = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );
		$create_channel_dm_url = LIFTERLMS_DISCORD_API_URL . '/users/@me/channels';
		$dm_channel_args       = array(
			'method'  => 'POST',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
			'body'    => wp_json_encode(
				array(
					'recipient_id' => $discord_user_id,
				)
			),
		);

		$created_dm_response = wp_remote_post( $create_channel_dm_url, $dm_channel_args );
	
		$response_arr = json_decode( wp_remote_retrieve_body( $created_dm_response ), true );
		if ( is_array( $response_arr ) && ! empty( $response_arr ) ) {

			update_user_meta( $user_id, '_ets_lifterlms_discord_dm_channel', $response_arr );
		}
		return $response_arr;
	}


	public function ets_lifterlms_discord_get_formatted_dm( $user_id, $message ) {
		global $wpdb;
		$user_obj                             = get_user_by( 'id', $user_id );
		$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
		
		$MEMBER_USERNAME                      = $user_obj->user_login;
		$MEMBER_EMAIL                         = $user_obj->user_email;
		$SITE_URL  = get_bloginfo( 'url' );
		$BLOG_NAME = get_bloginfo( 'name' );

		$find    = array(
			'[MEMBER_USERNAME]',
			'[MEMBER_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);

		$replace = array(
			$MEMBER_USERNAME,
			$MEMBER_EMAIL,
			$SITE_URL,
			$BLOG_NAME,	
		);
		return str_replace( $find, $replace, $message );
	}


    public function format_Quiz_DM_message( $user_id, $attempt, $message ) {
		$QUIZ_NAME = get_post($attempt->get( 'quiz_id' ))->post_title;
		$QUIZ_GRADE = $attempt->get( 'grade' );
		$QUIZ_STATUS = $attempt->get( 'status' );
		$SITE_URL  = get_bloginfo( 'url' );
		$BLOG_NAME = get_bloginfo( 'name' );

		$find    = array(
			'[QUIZ_NAME]',
			'[QUIZ_GRADE]',
			'[QUIZ_STATUS]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);

		$replace = array(
			$QUIZ_NAME,
			$QUIZ_GRADE,
			$QUIZ_STATUS,
			$SITE_URL,
			$BLOG_NAME,	
		);
		return str_replace( $find, $replace, $message );
	}

	public function ets_lifterlms_complete_quiz( $user_id, $quiz_id ) {
		if(is_user_logged_in()) {
	    	//$this->ets_lifterlms_discord_handler_send_dm( $user_id, 'complete' );
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_complete_quiz', array( $user_id, 'complete' ), LIFTERLMS_DISCORD_AS_GROUP_NAME );

		}
	}

	public function ets_lifterlms_quiz_failed( $user_id, $quiz_id ) {
		if(is_user_logged_in()) {
			$this->ets_lifterlms_discord_handler_send_dm( $user_id, 'failed' );
		}
	}

	public function ets_lifterlms_quiz_passed( $user_id, $quiz_id ) {
		if(is_user_logged_in()) {
			//$this->ets_lifterlms_discord_handler_send_dm( $user_id, 'passed');

			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_complete_quiz', array( $user_id, 'passed' ), LIFTERLMS_DISCORD_AS_GROUP_NAME );

		}
	}

	public function ets_llms_single_quiz_attempt_results_main ( $attempt ) {
		if(is_user_logged_in()) {
			//print_r($attempt);
			//$this->format_Quiz_DM_message( $user_id, $attempt);
			$this->ets_lifterlms_discord_handler_send_dm( $user_id,  'attempt', $attempt);
		}
	}


	public function ets_lifterlms_discord_reschedule_failed_action( $action_id, $e, $context ) {
		
		print_r($action_id);
		print_r($e);
		print_r($context);
		
	}
	
}
