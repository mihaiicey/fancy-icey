<?php
/**
 * Fancy Icey Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fancy Icey
 */
require get_template_directory() . '/angus.php';
require get_template_directory().'/inc/woo-shop-modify.php';

function fancy_icey_load_theme_textdomain() {
    load_theme_textdomain( 'fancy-icey', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'fancy_icey_load_theme_textdomain' );

function fancy_icey_scripts(){
    wp_enqueue_style( 'fancy-icey-style', get_template_directory_uri().'/style.css', array(), filemtime(get_template_directory().'/style.css'), 'all' );
}
add_action( 'wp_enqueue_scripts', 'fancy_icey_scripts' );

function fancy_icey_config(){
    register_nav_menus(
        array(
            'fancy_icey_main_menu' => 'Main Menu',
            'fancy_icey_second_menu' => 'Second Menu'
        )
    );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 55,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'	=> 300,
        'product_grid' 			=> array(
            'default_rows'    => 10,
            'min_rows'        => 5,
            'max_rows'        => 10,
            'default_columns' => 3,
            'min_columns'     => 3,
            'max_columns'     => 3,
        )
    ) );
    remove_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    if ( ! isset( $content_width ) ) {
        $content_width = 600;
    }
}
add_action('after_setup_theme', 'fancy_icey_config', 0);

// modify theme mennu
function fancy_icey_nav_menu_colors( $atts, $item, $args ) {
    global $post;
    if( $args->theme_location == 'fancy_icey_main_menu' ) {
        if($item->menu_item_parent == 0) {
            if($post->post_title === $item->title){
                $atts['class'] = 'font-semibold px-1 py-0.5 text-pared border-solid border-2 border-pared px-[15px]';
            }else{
                $atts['class'] = 'font-semibold px-1 hover:text-pared';
            }
        }else{
            if($post->post_title === $item->title){
                $atts['class'] = 'px-1 py-0.5 text-pared ';
            }else{
                $atts['class'] = 'px-1 hover:text-pared';
            }
        }
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'fancy_icey_nav_menu_colors', 10, 3 );

function atg_menu_classes($classes, $item, $args) {
    if($args->theme_location == 'fancy_icey_main_menu') {
        $classes[] = 'px-2';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'atg_menu_classes', 1, 3);
