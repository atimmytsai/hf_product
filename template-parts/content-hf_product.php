<?php
/**
 * Template part for displaying hf_product custom post type.
 */

if (have_posts()) :
    while (have_posts()) : the_post();
        echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
    endwhile;
else :
    echo '<p>No products found</p>';
endif;
?>