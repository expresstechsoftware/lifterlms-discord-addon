<?php
// get all wordpress pages
function ets_learnpress_discord_pages_list( $ets_learnpress_discord_redirect_page_id=false ){
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
        $selected = ( esc_attr( $page->ID ) === $ets_learnpress_discord_redirect_page_id  ) ? ' selected="selected"' : '';
        $options .= '<option value="' . esc_attr( $page->ID ) . '" '. $selected .'> ' . $page->post_title . ' </option>';
    }
    
    return $options;
}

 function ets_get_learnpress_discord_formated_discord_redirect_url( $ets_lifterlms_discord_redirect_page_id ) {
    $url = esc_url( get_permalink( $ets_lifterlms_discord_redirect_page_id) );
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

function ets_lifterlms_discord_get_formatted_dm( $user_id, $membership, $message ) {

    global $wpdb;
	$user_obj                             = get_user_by( 'id', $user_id );
	$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
	$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
	$mapped_role_id                       = $ets_memberpress_discord_role_mapping[ 'course_id_' . $membership['product_id'] ];
	

    if ( is_array( $all_roles ) && array_key_exists( $mapped_role_id, $all_roles ) ) {
		$MEMBERSHIP_LEVEL = $all_roles[ $mapped_role_id ];
	} else {
		$MEMBERSHIP_LEVEL = '';
	}

}	// ets_lifterlms_discord_redirect_page_id
function ets_lifterlms_discord_check_saved_settings_status() {
	$ets_lifterlms_discord_client_id     = get_option( 'ets_lifterlms_discord_client_id' );
	$ets_lifterlms_discord_client_secret = get_option( 'ets_lifterlms_discord_client_secret' );
	$ets_lifterlms_discord_bot_token     = get_option( 'ets_lifterlms_discord_bot_token' );
	$ets_lifterlms_discord_redirect_url  = get_option( 'ets_lifterlms_discord_redirect_url' );
	$ets_lifterlms_discord_server_id     = get_option( 'ets_lifterlms_discord_server_id' );

	if ( $ets_lifterlms_discord_client_id && $ets_lifterlms_discord_client_secret && $ets_lifterlms_discord_bot_token && $ets_lifterlms_discord_redirect_url && $ets_lifterlms_discord_server_id ) {
			$status = true;
	} else {
			$status = false;
	}

		return $status;
}


?>