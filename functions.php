<?php

function hf_product_filter() {
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $material = isset($_POST['material']) ? $_POST['material'] : '';
    $voltage = isset($_POST['voltage']) ? $_POST['voltage'] : '';

    $tax_query = array('relation' => 'AND');
    $taxonomies = array(
        'category' => $category,
        'material' => $material,
        'voltage' => $voltage
    );

    foreach ($taxonomies as $taxonomy => $terms_string) {
        if (!empty($terms_string)) {
            $terms = explode(',', $terms_string);
            $tax_query[] = array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $terms,
                'operator' => 'IN',
            );
        }
    }

    $args = array(
        'post_type' => 'hf_product',
        'tax_query' => $tax_query,
        'posts_per_page' => -1,
    );

    $hf_products = new WP_Query( $args );

    $category_options = '<option value="">All</option>';
    $material_options = '<option value="">All</option>';
    $voltage_options = '<option value="">All</option>';

    // Get the available terms for each taxonomy based on the current filter
    $category_terms = get_terms( array(
        'taxonomy' => 'category',
        'hide_empty' => true,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'hf_product',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'hf_product',
                'value' => '',
                'compare' => '=',
            ),
            array(
                'key' => 'hf_product',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    ) );

    foreach ( $category_terms as $cat ) {
        $cat_count = $cat->count;
        $selected = ( $cat->slug == $category ) ? ' selected' : '';
        $category_options .= '<option value="' . esc_attr( $cat->slug ) . '"' . $selected . '>' . esc_html( $cat->name ) . ' (' . $cat_count . ')</option>';
    }

    $material_terms = get_terms( array(
        'taxonomy' => 'material',
        'hide_empty' => true,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'hf_product',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'hf_product',
                'value' => '',
                'compare' => '=',
            ),
            array(
                'key' => 'hf_product',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    ) );

    foreach ( $material_terms as $mat ) {
        $mat_count = $mat->count;
        $selected = ( $mat->slug == $material ) ? ' selected' : '';
        $material_options .= '<option value="' . esc_attr( $mat->slug ) . '"' . $selected . '>' . esc_html( $mat->name ) . ' (' . $mat_count . ')</option>';
    }

    $voltage_terms = get_terms( array(
        'taxonomy' => 'voltage',
        'hide_empty' => true,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'hf_product',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'hf_product',
                'value' => '',
                'compare' => '=',
            ),
            array(
                'key' => 'hf_product',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    ) );

    foreach ( $voltage_terms as $volt ) {
        $volt_count = $volt->count;
        $selected = ( $volt->slug == $voltage ) ? ' selected' : '';
        $voltage_options .= '<option value="' . esc_attr( $volt->slug ) . '"' . $selected . '>' . esc_html( $volt->name ) . ' (' . $volt_count . ')</option>';
    }

    $products = '';

    if ( $hf_products->have_posts() ) :
        while ( $hf_products->have_posts() ) :
            $hf_products->the_post();
            $products .= '<div class="hf-product">';
            $products .= '<h2>' . get_the_title() . '</h2>';
            $products .= get_the_content();
            $products .= '</div>';
        endwhile;
        wp_reset_postdata();
    else :
        $products .= '<p>No products found.</p>';
    endif;

    $data = array(
        'category_options' => $category_options,
        'material_options' => $material_options,
        'voltage_options' => $voltage_options,
        'products' => $products,
    );

    wp_send_json_success( $data );
}

add_action( 'wp_ajax_hf_product_filter', 'hf_product_filter' );
add_action( 'wp_ajax_nopriv_hf_product_filter', 'hf_product_filter' );


function hf_update_filter_options() {
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $material = isset($_POST['material']) ? $_POST['material'] : '';
    $voltage = isset($_POST['voltage']) ? $_POST['voltage'] : '';

    $term_query = array('relation' => 'AND');

    $taxonomies = array(
        'category' => $category,
        'material' => $material,
        'voltage' => $voltage
    );

    foreach ($taxonomies as $taxonomy => $terms_string) {
        if (!empty($terms_string)) {
            $terms = explode(',', $terms_string);
            $term_query[] = array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $terms,
                'operator' => 'IN',
            );
        }
    }

    $args = array(
        'post_type' => 'hf_product',
        'tax_query' => $term_query,
        'posts_per_page' => -1,
    );

    $hf_products = new WP_Query( $args );

    $category_options = '<option value="">All</option>';
    $material_options = '<option value="">All</option>';
    $voltage_options = '<option value="">All</option>';

    $category_terms = get_terms( array(
        'taxonomy' => 'category',
        'hide_empty' => true,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'hf_product',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'hf_product',
                'value' => '',
                'compare' => '=',
            ),
            array(
                'key' => 'hf_product',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    ) );

    foreach ( $category_terms as $cat ) {
        $cat_count = $cat->count;
        $selected = ( $cat->slug == $category ) ? ' selected' : '';
        $category_options .= '<option value="' . esc_attr( $cat->slug ) . '"' . $selected . '>' . esc_html( $cat->name ) . ' (' . $cat_count . ')</option>';
    }

    $material_terms = get_terms( array(
        'taxonomy' => 'material',
        'hide_empty' => true,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'hf_product',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'hf_product',
                'value' => '',
                'compare' => '=',
            ),
            array(
                'key' => 'hf_product',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    ) );

    foreach ( $material_terms as $mat ) {
        $mat_count = $mat->count;
        $selected = ( $mat->slug == $material ) ? ' selected' : '';
        $material_options .= '<option value="' . esc_attr( $mat->slug ) . '"' . $selected . '>' . esc_html( $mat->name ) . ' (' . $mat_count . ')</option>';
    }

    $voltage_terms = get_terms( array(
        'taxonomy' => 'voltage',
        'hide_empty' => true,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'hf_product',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'hf_product',
                'value' => '',
                'compare' => '=',
            ),
            array(
                'key' => 'hf_product',
                'value' => '1',
                'compare' => '=',
            ),
        ),
    ) );

    foreach ( $voltage_terms as $volt ) {
        $volt_count = $volt->count;
        $selected = ( $volt->slug == $voltage ) ? ' selected' : '';
        $voltage_options .= '<option value="' . esc_attr( $volt->slug ) . '"' . $selected . '>' . esc_html( $volt->name ) . ' (' . $volt_count . ')</option>';
    }

    $data = array(
        'category_options' => $category_options,
        'material_options' => $material_options,
        'voltage_options' => $voltage_options,
    );

    wp_send_json_success( $data );
}

add_action( 'wp_ajax_hf_update_filter_options', 'hf_update_filter_options' );
add_action( 'wp_ajax_nopriv_hf_update_filter_options', 'hf_update_filter_options' );

?>