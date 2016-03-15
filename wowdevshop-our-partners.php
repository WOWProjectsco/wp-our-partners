<?php

/**
* Plugin Name: Our Partners
* Plugin URI: http://wowdevshop.com
* Description: This plugin registers the 'partner' post type, it let's you manage your company partner profiles.
* Author: XicoOfficial
* Version: 1.1.0
* License: GPLv2
* Author URI: http://wowdevshop.com
* Text Domain: our-partners-by-wowdevshop
*
* @package WordPress
* @subpackage WowDevShop_Our_Partners
* @author XicoOfficial
* @since 1.0.0
*/


/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/



//
// Register Custom Partner Post Type
//
add_action('init', 'wds_op_create_post_type');

// Register custom post type  | Partners
function wds_op_create_post_type() {

    $labels = array(
        'name' => _x('Partners', 'Partners', 'partners'),
        'singular_name' => _x('Partner', 'Partner', 'partner'),
        'add_new' => _x('Add New', 'partner'),
        'add_new_item' => __('Add New Partner'),
        'edit_item' => __('Edit Partner'),
        'new_item' => __('New Partner'),
        'view_item' => __('View Partner'),
        'search_items' => __('Search Partner'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => '',
        'archives' => __('Partner Archives', 'partners')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'taxonomies' => array('partner-category' ),
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => 'dashicons-nametag',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 7,
        'supports' => array('title', 'editor','thumbnail', 'excerpt', 'custom_fields', 'page_attributes'),
        'has_archive' => true
      );

    register_post_type( 'partner' , $args );
}


// hook into the init action and call create_partner_taxonomies when it fires
add_action( 'init', 'wds_op_create_custom_taxonomy', 0 );

// Create own taxonomies for the post type "partner"
function wds_op_create_custom_taxonomy() {
    //Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Partner Categories', 'Partner Categories', 'partner-categories' ),
        'singular_name'     => _x( 'Partner Category', 'Partner Category', 'partner-category' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Partner Category' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'public'            => true,
        'rewrite'           => array( 'slug' => 'partner-category' ),
    );

    register_taxonomy( 'partner-category', array( 'partner' ), $args );
}



function wds_op_change_title_text( $title ){
     $screen = get_current_screen();

     if  ( 'partner' == $screen->post_type ) {
          $title = 'Enter partner name';
     }

     return $title;
}

add_filter( 'enter_title_here', 'wds_op_change_title_text' );



//
// Add Custom Data Fields to the add/edit post page
//
add_action('add_meta_boxes', 'wds_op_add_fields');

// Add the Meta Box
function wds_op_add_fields() {
    add_meta_box(
        'partner_fields', // $id
        'Partner Fields', // $title
        'wds_op_show_fields', // $callback
        'partner', // $page
        'normal', // $context
        'high'); // $priority
}

// Field Array
$prefix = 'custom_';
$custom_meta_fields = array(
    array(
        'label'=> 'Website',
        'desc'  => '',
        'id'    => $prefix.'website',
        'type'  => 'url'
    ),
    array(
        'label'=> 'Email',
        'desc'  => '',
        'id'    => $prefix.'email',
        'type'  => 'email'
    )
);

// The Callback
function wds_op_show_fields() {
global $custom_meta_fields, $post;
// Use nonce for verification
wp_nonce_field( basename( __FILE__ ), 'partner_fields_nonce' );

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // case items will go here
                    // url
                    case 'url':
                        echo '<input type="url" name="'.$field['id'].'" id="'.$field['id'].'" value="'.esc_url($meta).'" size="30" />
                            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                    // email
                    case 'email':
                        echo '<input type="email" name="'.$field['id'].'" id="'.$field['id'].'" value="'.esc_textarea($meta).'" size="30" />
                            <br /><span class="description">'.$field['desc'].'</span>';
                    break;
                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

//
// Save the Data
//
add_action('save_post', 'wds_op_save_custom_meta');

function wds_op_save_custom_meta($post_id) {
    global $custom_meta_fields;

    // verify nonce
    if (!isset($_POST['partner_fields_nonce']) || !wp_verify_nonce($_POST['partner_fields_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }

    // loop through fields and save the data
    //
    foreach ($custom_meta_fields as $field) {

        switch ($field['id']) {
            case 'custom_website':
                $old = get_post_meta($post_id, $field['id'], true);
                $new = esc_url($_POST[$field['id']]);
                if ($new && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
                break;
            case 'custom_email':
                $old = get_post_meta($post_id, $field['id'], true);
                $new = sanitize_email($_POST[ $field['id']]);
                if ($new && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
                break;
            default:
                $old = get_post_meta($post_id, $field['id'], true);
                $new = sanitize_text_field($_POST[$field['id']]);
                if ($new && $new != $old) {
                    update_post_meta($post_id, $field['id'], $new);
                } elseif ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
                break;
        }

    } // end foreach
}



//
// Customize the columnts display
//
//
add_action("manage_posts_custom_column", "wds_op_custom_columns");
add_filter("manage_partner_posts_columns", "wds_op_columns");

function wds_op_columns($columns) //this function display the columns headings
{
    $columns = array(
        "cb" => '<input type="checkbox" />',
        "title" => "Name",
        "website" => "Website",
        "date" => "Date"
    );
    return $columns;
}

function wds_op_custom_columns($column)
{
    global $post;
    if ("ID" == $column) echo $post->ID; //displays title
    elseif ("website" == $column) echo $post->custom_website; //shows up the post website.
}






/**
 *
 */

add_filter( 'template_include', 'include_template_function', 1 );

function include_template_function( $template_path ) {
    if ( get_post_type() == 'partner' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-partner.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/includes/templates/single-partner.php';
            }
        }
    }
    if ( get_post_type() == 'partner' ) {
        if ( is_archive() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-partner.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/includes/templates/archive-partner.php';
            }
        }
    }
    return $template_path;
}
