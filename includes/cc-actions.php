<?php

/**
 * Return true if the global $post is a WP_Post and the content contains a cc_product shortcode
 *
 * @return boolean
 */
function cc_page_has_products() {
    $has_products = false;
    global $post;

    if( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'cc_product' ) ) {
        $has_products = true;
    }

    return $has_products;
}

/**
 * Enqueue the javascript file used for client side product loading
 *
 * This script is only enqued if:
 *   - the product loader type is client
 *   - the $post is a WP_Post
 *   - the post's content has the shortcode cc_product
 */
function cc_enqueue_cart66_wordpress_js() {
    $product_loader = CC_Admin_Setting::get_option( 'cart66_main_settings', 'product_loader' );
    if( 'client' == $product_loader && cc_page_has_products() ) {
        $cloud = new CC_Cloud_API_V1();
        $source = $cloud->protocol . 'manage.' . $cloud->app_domain . '/assets/cart66.wordpress.js';
        wp_enqueue_script('cart66-wordpress', $source, 'jquery', '1.0', true);
    }
}

/**
 * Enque javascript to implement ajax add to cart
 *
 * The script is only enqued if :
 *   - the $post is a WP_Post
 *   - the post's content has the shortcode cc_product
 */
function cc_enqueue_ajax_add_to_cart() {
    if( cc_page_has_products() ) {
        wp_enqueue_script(
            'cc-add-to-cart',
            CC_URL . 'resources/js/add-to-cart.js',
            array( 'jquery' )
        );
        $ajax_url = admin_url('admin-ajax.php');
        wp_localize_script('cc-add-to-cart', 'cc_cart', array('ajax_url' => $ajax_url));
    }
}

/**
 * Enque cart66 styles for basic product layout
 */
function cc_enqueue_cart66_styles() {
    wp_enqueue_style('cart66-wp', CC_URL . 'resources/css/cart66-wp.css');
}
