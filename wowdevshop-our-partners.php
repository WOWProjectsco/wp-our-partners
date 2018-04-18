<?php

/**
* Plugin Name: Our Partners
* Plugin URI: http://wowprojects.co
* Description: This plugin registers the 'partner' post type, it let's you manage your company partner profiles.
* Author: XicoOfficial
* Version: 1.3.2
* License: GPLv2
* Author URI: http://wowprojects.co
* Text Domain: our-partners-by-wowdevshop
* Domain Path: /languages/
*
* @package WordPress
* @subpackage WOWProjects_Our_Partners
* @author XicoOfficial
* @since 1.0.0
*/



/**
 * Tell WordPress to load a translation file if it exists for the user's language
 */
function wds_op_load_plugin_textdomain() {
    load_plugin_textdomain( 'our-partners-by-wowdevshop', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'wds_op_load_plugin_textdomain' );


require_once( 'pagetemplater.php' );


//
// Register Custom Partner Post Type
//
add_action('init', 'wds_op_create_post_type');

// Register custom post type  | Partners
function wds_op_create_post_type() {

    $labels = array(
        'name'              => __('Partners', 'our-partners-by-wowdevshop'),
        'singular_name'     => __('Partner', 'our-partners-by-wowdevshop'),
        'add_new'           => __('Add New', 'our-partners-by-wowdevshop'),
        'add_new_item'      => __('Add New Partner', 'our-partners-by-wowdevshop'),
        'edit_item'         => __('Edit Partner', 'our-partners-by-wowdevshop'),
        'new_item'          => __('New Partner', 'our-partners-by-wowdevshop'),
        'view_item'         => __('View Partner', 'our-partners-by-wowdevshop'),
        'search_items'      => __('Search Partner', 'our-partners-by-wowdevshop'),
        'not_found'         =>  __('Nothing found', 'our-partners-by-wowdevshop'),
        'not_found_in_trash' => __('Nothing found in Trash', 'our-partners-by-wowdevshop'),
        'parent_item_colon' => '',
        'archives'          => __('Partner Archives', 'our-partners-by-wowdevshop')
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
        'hierarchical' => true,
        'menu_position' => 7,
        'supports' => array('title', 'editor','thumbnail', 'excerpt', 'page-attributes'),
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
        'name'              => __( 'Partner Categories', 'our-partners-by-wowdevshop'),
        'singular_name'     => __( 'Partner Category', 'our-partners-by-wowdevshop' ),
        'search_items'      => __( 'Search Categories', 'our-partners-by-wowdevshop' ),
        'all_items'         => __( 'All Categories', 'our-partners-by-wowdevshop' ),
        'parent_item'       => __( 'Parent Category', 'our-partners-by-wowdevshop' ),
        'parent_item_colon' => __( 'Parent Category:', 'our-partners-by-wowdevshop' ),
        'edit_item'         => __( 'Edit Category', 'our-partners-by-wowdevshop' ),
        'update_item'       => __( 'Update Category', 'our-partners-by-wowdevshop' ),
        'add_new_item'      => __( 'Add New Category', 'our-partners-by-wowdevshop' ),
        'new_item_name'     => __( 'New Category Name', 'our-partners-by-wowdevshop' ),
        'menu_name'         => __( 'Partner Category', 'our-partners-by-wowdevshop' ),
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
          $title = __('Enter partner name', 'our-partners-by-wowdevshop');
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
        __('Partner Fields', 'our-partners-by-wowdevshop'), // $title
        'wds_op_show_fields', // $callback
        'partner', // $page
        'normal', // $context
        'high'); // $priority
}

// Field Array
$prefix = 'custom_';
$custom_meta_fields = array(
    array(
        'label' => __('Website', 'our-partners-by-wowdevshop'),
        'desc'  => '',
        'id'    => $prefix.'website',
        'type'  => 'url'
    ),
    array(
        'label' => __('Email', 'our-partners-by-wowdevshop'),
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





/**
 *
 */

add_filter( 'template_include', 'wds_op_include_template_function', 1 );

function wds_op_include_template_function( $template_path ) {
    if ( get_post_type() == 'partner' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-partner.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/includes/single-partner.php';
            }
        }
    }
    if ( get_post_type() == 'partner' ) {
        if ( is_archive() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'archive-partner.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/includes/archive-partner.php';
            }
        }
    }
    return $template_path;
}


/**
 * Filter the except length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 * @since 1.1.0
 */
function wds_op_custom_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'wds_op_custom_excerpt_length', 999 );


/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 * @since 1.3.0
 */
function wds_op_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'wds_op_excerpt_more', 20 );



