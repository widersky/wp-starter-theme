<?php

/**
 * 
 *  Feel free to enable / disable things here
 * 
 */


// Disable admin bar visibility
show_admin_bar( false );


// Disable Gutenberg from admin panel...
add_filter('use_block_editor_for_post', '__return_false');


// ... and frontend head
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}


// Enable post thumbnails in theme
add_theme_support('post-thumbnails'); 


// Additional thumbnails sizes (name, x, y, hardmode?)
add_image_size('sidebar-thumb', 640, 480, true);


// Add title tag support
add_theme_support('title-tag');


// Register custom menus
register_nav_menus(array(
    'top'    => __('Main menu', 'wpst-theme'),
    'footer' => __('Footer menu', 'wpst-theme')
));


// Add custom file types to upload
function addFileTypes($fileTypes) {
    $fileTypes['svg'] = 'image/svg+xml';
    return $fileTypes;
}
add_filter('upload_mimes', 'addFileTypes', 1, 1);


// Register styles and scripts
function enqueueStyles() {
    $version = '0.2';
    $mainJS = get_template_directory_uri() . '/js/dist/main.js';
    $mainCSS = get_template_directory_uri() . '/css/dist/main.min.css';

    wp_enqueue_style('style', $mainCSS, $version, true);
    wp_enqueue_script('script', $mainJS, $version, true);
}
add_action('wp_enqueue_scripts', 'enqueueStyles');


/**
 * 
 *  Safety things
 * 
 */


// Remove WordPress errors on login page
function removeWPLoginErrors() {
    return 'Something is wrong!';
}
add_filter('login_errors', 'removeWPLoginErrors');


// Remove crap from head
remove_action('wp_head', 'rsd_link');// Windows Live Writer remove
remove_action('wp_head', 'wlwmanifest_link');// Windows Live Writer remove
remove_action('wp_head', 'wp_generator');// Remove WP version


// remove Emojis
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');


// remove dns-prefetch
remove_action( 'wp_head', 'wp_resource_hints', 2 );


// Remove the REST API endpoint and other related things
remove_action('rest_api_init', 'wp_oembed_register_route'); // endpoint
remove_action('wp_head', 'rest_output_link_wp_head'); // rel='https://api.w.org/' out from head
remove_action('wp_head', 'wp_oembed_add_discovery_links'); // REST from default filters
remove_action('template_redirect', 'rest_output_link_header', 11); // REST link out from head
