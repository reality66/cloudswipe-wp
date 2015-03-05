<?php

function cc_primary_image_for_product( $post_id, $size = 'cc-gallery-full' ) {
    $primary_src = '';
    $images = cc_get_product_image_sources( $size, $post_id );
    CC_Log::write( 'Images: ' . print_r( $images, true ) );

    if ( is_array( $images ) ) {
        $primary_src = $images[0];
    }

    return $primary_src;
}

function cc_filter_product_single( $content ) {
    global $post;
    $post_type = get_post_type();

    if ( is_single() && 'cc_product' == $post_type ) {
        wp_enqueue_script( 'cc-gallery-toggle', CC_URL . 'resources/js/gallery-toggle.js', 'jquery' );
        $thumbs = cc_get_product_thumb_sources( 'cc-gallery-thumb', $post->ID );
        $images = cc_get_product_image_sources( 'cc-gallery-full', $post->ID );
        $data = array( 'images' => $images, 'thumbs' => $thumbs );
        $single_product_view = CC_View::get( CC_PATH . 'templates/partials/single-product.php', $data );
        $content = $single_product_view . $content;
    } 

    return $content;
}

add_filter( 'the_content', 'cc_filter_product_single' );
