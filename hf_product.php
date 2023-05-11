<?php
/*
Plugin Name: HF Product
Description: Creates a custom post type for HF Product with custom taxonomies and a filterable archive page.
Version: 1.0
Author: Your Atimmy Tsai
Author URI: saytimtim.com
*/

//
require_once('functions.php');

//
//Register Custom Post Type: HF Product
function hf_product_cpt() {
    $labels = array(
        'name' => _x('HF Products', 'Post Type General Name', 'textdomain'),
        'singular_name' => _x('HF Product', 'Post Type Singular Name', 'textdomain'),
        'menu_name' => __('HF Products', 'textdomain'),
        'all_items' => __('All HF Products', 'textdomain'),
        'view_item' => __('View HF Product', 'textdomain'),
        'add_new_item' => __('Add New HF Product', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'edit_item' => __('Edit HF Product', 'textdomain'),
        'update_item' => __('Update HF Product', 'textdomain'),
        'search_items' => __('Search HF Product', 'textdomain'),
        'not_found' => __('Not Found', 'textdomain'),
        'not_found_in_trash' => __('Not found in Trash', 'textdomain'),
    );
    
    $args = array(
        'label' => __('HF Product', 'textdomain'),
        'description' => __('Custom post type for HF Products', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('category', 'voltage', 'material', 'flange'),
        'public' => true,
        'menu_icon' => 'dashicons-admin-generic',
        'has_archive' => true,
        'rewrite' => array('slug' => 'hf-product'),
    );
    
    register_post_type('hf_product', $args);
}




function enqueue_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'hf-product-scripts', plugin_dir_url( __FILE__ ) . 'js/hf_product_scripts.js', array( 'jquery' ), '1.0', true );
    
    wp_localize_script('hf-product-scripts', 'hf_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));

}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

//hf-ajax



// Create custom taxonomies: Category, Voltage, Material, and Flange
// Create custom taxonomies: Category, Voltage, Material, and Flange
function hf_product_taxonomies() {
    // Category taxonomy
    $category_labels = array(
        'name' => __('Categories', 'textdomain'),
        'singular_name' => __('Category', 'textdomain'),
        'search_items' => __('Search Categories', 'textdomain'),
        'all_items' => __('All Categories', 'textdomain'),
        'parent_item' => __('Parent Category', 'textdomain'),
        'parent_item_colon' => __('Parent Category:', 'textdomain'),
        'edit_item' => __('Edit Category', 'textdomain'),
        'update_item' => __('Update Category', 'textdomain'),
        'add_new_item' => __('Add New Category', 'textdomain'),
        'new_item_name' => __('New Category Name', 'textdomain'),
        'menu_name' => __('Category', 'textdomain'),
    );
    $category_args = array(
        'hierarchical' => true,
        'labels' => $category_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'hf-product/category'),
    );
    register_taxonomy('category', array('hf_product'), $category_args);
    
    // Voltage taxonomy
    $voltage_labels = array(
        'name' => __('Voltage', 'textdomain'),
        'singular_name' => __('Voltage', 'textdomain'),
        'search_items' => __('Search Voltage', 'textdomain'),
        'all_items' => __('All Voltage', 'textdomain'),
        'edit_item' => __('Edit Voltage', 'textdomain'),
        'update_item' => __('Update Voltage', 'textdomain'),
        'add_new_item' => __('Add New Voltage', 'textdomain'),
        'new_item_name' => __('New Voltage Name', 'textdomain'),
        'menu_name' => __('Voltage', 'textdomain'),
    );
    $voltage_args = array(
        'hierarchical' => true,
        'labels' => $voltage_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'hf-product/voltage'),
    );
    register_taxonomy('voltage', array('hf_product'), $voltage_args);
    
    // Material taxonomy
    $material_labels = array(
        'name' => __('Material', 'textdomain'),
        'singular_name' => __('Material', 'textdomain'),
        'search_items' => __('Search Material', 'textdomain'),
        'all_items' => __('All Material', 'textdomain'),
        'edit_item' => __('Edit Material', 'textdomain'),
        'update_item' => __('Update Material', 'textdomain'),
        'add_new_item' => __('Add New Material', 'textdomain'),
        'new_item_name' => __('New Material Name', 'textdomain'),
        'menu_name' => __('Material', 'textdomain'),
    );
    $material_args = array(
        'hierarchical' => true,
        'labels' => $material_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'hf-product/material'),
    );
    register_taxonomy('material', array('hf_product'), $material_args);
    
    // Flange taxonomy
    $flange_labels = array(
        'name' => __('Flange', 'textdomain'),
        'singular_name' => __('Flange', 'textdomain'),
        'search_items' => __('Search Flange', 'textdomain'),
        'all_items' => __('All Flange', 'textdomain'),
        'edit_item' => __('Edit Flange', 'textdomain'),
        'update_item' => __('Update Flange', 'textdomain'),
        'add_new_item' => __('Add New Flange', 'textdomain'),
        'new_item_name' => __('New Flange Name', 'textdomain'),
        'menu_name' => __('Flange', 'textdomain'),
    );
    $flange_args = array(
        'hierarchical' => true,
        'labels' => $flange_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'hf-product/flange'),
    );
    register_taxonomy('flange', array('hf_product'), $flange_args);
}

// Pre-built terms for Voltage and Material taxonomies
// Add prebuilt terms to custom taxonomies
function hf_product_prebuilt_terms() {
    // Get category taxonomy
    $category = get_taxonomy('category');
    // Add prebuilt terms
    if (!term_exists('Igniter', $category->name)) {
        wp_insert_term('Igniter', $category->name);
    }
    if (!term_exists('Term 2', $category->name)) {
        wp_insert_term('Term 2', $category->name);
    }
    
    // Get voltage taxonomy
    $voltage = get_taxonomy('voltage');
    // Add prebuilt terms
    if (!term_exists('120V', $voltage->name)) {
        wp_insert_term('120V', $voltage->name);
    }
    if (!term_exists('200V', $voltage->name)) {
        wp_insert_term('200V', $voltage->name);
    }

    $material = get_taxonomy('material');

    if (!term_exists('Stainless Steel', $material->name)) {
        wp_insert_term('Stainless Steel', $material->name);
    }
}

// Set custom archive template for HF Product
function hf_product_archive_template($template) {
    if (is_post_type_archive('hf_product')) {
        $new_template = plugin_dir_path(__FILE__) . 'templates/archive-hf_product.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}


//

//

add_filter('archive_template', 'hf_product_archive_template');

// Hook the functions to the appropriate WordPress actions
add_action('init', 'hf_product_cpt');
add_action('init', 'hf_product_taxonomies');
add_action('init', 'hf_product_prebuilt_terms');
add_filter('template_include', 'hf_product_archive_template');

// 