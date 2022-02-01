<?php

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

?>