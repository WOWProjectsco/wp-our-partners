<?php

/**
* Plugin Name: Our Partners
* Plugin URI: http://wowdevshop.com
* Description: This plugin registers the 'partner' post type, it let's you manage your company partner profiles.
* Author: XicoOfficial
* Version: 1.0.0
* License: GPLv2
* Author URI: http://wowdevshop.com
* Text Domain: our-partners-by-wowdevshop
*
* @package WordPress
* @subpackage WowDevShop_Our_Partners
* @author XicoOfficial
* @since 1.0.0
*/


add_action('init', 'wds_our_partners_register');

// Register custom post type  | Partners
function wds_our_partners_register() {

    $labels = array(
        'name' => _x('Partners', 'post type general name'),
        'singular_name' => _x('Partner', 'post type singular name'),
        'add_new' => _x('Add New', 'partner'),
        'add_new_item' => __('Add New Partner'),
        'edit_item' => __('Edit Partner'),
        'new_item' => __('New Partner'),
        'view_item' => __('View Partner'),
        'search_items' => __('Search Partner'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => 'dashicons-nametag',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 7,
        'supports' => array('title','thumbnail')
      );

    register_post_type( 'partners' , $args );
}

?>
