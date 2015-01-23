<?php

add_filter( 'template_include', 'cc_template_include' );

/**
 * Include the appropriate templates for cart66 products
 *
 * @param string $template The template to be included
 * @return string The path to the template to be included
 */
function cc_template_include( $template ) {
    $post_type = get_post_type();

    if ( is_single() && 'cc_product' == $post_type ) {
        $template = cc_get_template_part( 'single', 'product' );
    }

    CC_Log::write( "Considering which template to include:\nTemplate: " . $template . "\nPost type: " . $post_type );

    return $template;
}

