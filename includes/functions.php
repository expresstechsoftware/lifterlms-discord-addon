<?php
function ets_lifterlms_discord_pages_list( $ets_lifterlms_discord_redirect_page_id ){
    $args = array(
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'hierarchical' => 1,
    'exclude' => '',
    'include' => '',
    'meta_key' => '',
    'meta_value' => '',
    'exclude_tree' => '',
    'number' => '',
    'offset' => 0,
    'post_type' => 'page',
    'post_status' => 'publish'
    );
    $pages = get_pages($args);

    $options = '<option value="" disabled>-</option>';
    foreach($pages as $page){ 
    $selected = ( esc_attr( $page->ID ) === $ets_lifterlms_discord_redirect_page_id  ) ? ' selected="selected"' : '';
    $options .= '<option data-page-url="' . ets_get_lifterlms_discord_formated_discord_redirect_url ( $page->ID ) .'" value="' . esc_attr( $page->ID ) . '" '. $selected .'> ' . $page->post_title . ' </option>';
}
    return $options;
}

/**
 *  Get-URL 
 */
function ets_get_lifterlms_discord_formated_discord_redirect_url( $page_id ) {
    
    $url = esc_url( get_permalink( $page_id) );
	$parsed = parse_url( $url, PHP_URL_QUERY );
	if ( $parsed === null ) {
		return $url .= '?via=lifterlms-discord';
	} else {
		if ( stristr( $url, 'via=lifterlms-discord' ) !== false ) {
			return $url;
		} else {
			return $url .= '&via=lifterlms-discord';
		}
	}
}

function ets_lifterlms_discord_get_current_screen_url()
{
    $parts = parse_url( home_url() );
    $current_uri = "{$parts['scheme']}://{$parts['host']}" . ( isset( $parts['port'] ) ? ':' . $parts['port'] : '' ) . add_query_arg( null, null );
        return $current_uri;
}

/**
 * Log API call response
 *
 * @param INT          $user_id
 * @param STRING       $api_url
 * @param ARRAY        $api_args
 * @param ARRAY|OBJECT $api_response
 */
function ets_lifterlms_discord_log_api_response( $user_id, $api_url = '', $api_args = array(), $api_response = '' ) {
	$log_api_response = get_option( 'ets_memberpress_discord_log_api_response' );
	if ( $log_api_response == true ) {
		$log_string  = '==>' . $api_url;
		$log_string .= '-::-' . serialize( $api_args );
		$log_string .= '-::-' . serialize( $api_response );
		ets_lifterlms_write_api_response_logs( $log_string, $user_id );
	}
}




/*function ets_lifterlms_discord_get_formatted_dm( $user_id, $message ) {
	global $wpdb;
	$user_obj                             = get_user_by( 'id', $user_id );
	$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
	$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
//	$mapped_role_id                     = $ets_lifterlms_discord_role_mapping[ 'course_id_' . $['course_id'] ];
	$MEMBER_USERNAME                      = $user_obj->user_login;
	$MEMBER_EMAIL                         = $user_obj->user_email;
	
	if ( is_array( $all_roles ) && array_key_exists( $mapped_role_id, $all_roles ) ) {
		$MEMBERSHIP_LEVEL = $all_roles[ $mapped_role_id ];
	} else {
		$MEMBERSHIP_LEVEL = '';
	}

	$SITE_URL  = get_bloginfo( 'url' );
	$BLOG_NAME = get_bloginfo( 'name' );
	  
	$find    = array(
		'[MEMBER_USERNAME]',
		'[MEMBER_EMAIL]',
		'[MEMBERSHIP_LEVEL]',
		'[SITE_URL]',
		'[BLOG_NAME]',
	);
	$replace = array(
		$MEMBER_USERNAME,
		$MEMBER_EMAIL,
		$MEMBERSHIP_LEVEL,
		$SITE_URL,
		$BLOG_NAME,
	);

	return str_replace( $find, $replace, $message );
}*/




?>