<?php 
/**
 * The template for displaying archive pages for the hf_product CPT
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package My_Custom_Plugin
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <div id="hf-product-filter">
            <label for="category-filter">Filter by Category:</label>
            <select name="category-filter" id="category-filter">
                <option value="">All</option>
                <?php
                    $categories = get_terms( 'category', array( 'hide_empty' => true ) );
                    foreach ( $categories as $category ) {
                        $count = $category->count;
                        echo '<option value="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . ' (' . $count . ')</option>';
                    }
                ?>
            </select>

            <label for="material-filter">Filter by Material:</label>
            <select name="material-filter" id="material-filter">
                <option value="">All</option>
                <?php
                    $materials = get_terms( 'material', array( 'hide_empty' => true ) );
                    foreach ( $materials as $material ) {
                        $count = $material->count;
                        echo '<option value="' . esc_attr( $material->slug ) . '">' . esc_html( $material->name ) . ' (' . $count . ')</option>';
                    }
                ?>
            </select>

            <label for="voltage-filter">Filter by Voltage:</label>
            <select name="voltage-filter" id="voltage-filter">
                <option value="">All</option>
                <?php
                    $voltages = get_terms( 'voltage', array( 'hide_empty' => true ) );
                    foreach ( $voltages as $voltage ) {
                        $count = $voltage->count;
                        echo '<option value="' . esc_attr( $voltage->slug ) . '">' . esc_html( $voltage->name ) . ' (' . $count . ')</option>';
                    }
                ?>
            </select>
        </div>

        <div id="hf-product-list">
            <?php
                $args = array(
                    'post_type' => 'hf_product',
                    'posts_per_page' => -1,
                );
                $hf_products = new WP_Query( $args );

                if ( $hf_products->have_posts() ) :
                    while ( $hf_products->have_posts() ) :
                        $hf_products->the_post();

                        echo '<div class="hf-product">';
                        echo '<h2>' . get_the_title() . '</h2>';
                        echo get_the_content();
                        echo '</div>';

                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No products found.</p>';
                endif;
            ?>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($) {
    $('#hf-product-filter select').change(function() {
        var category = $('#category-filter').val();
        var material = $('#material-filter').val();
        var voltage = $('#voltage-filter').val();

        $.ajax({
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            type: 'POST',
            data: {
                action: 'hf_product_filter',
                category: category,
                material: material,
                voltage: voltage
            },
            success: function(response) {
                $('#category-filter').html(response.data.category_options);
                $('#material-filter').html(response.data.material_options);
                $('#voltage-filter').html(response.data.voltage_options);
                $('#hf-product-list').html(response.data.products);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
</script>

<?php
get_footer();