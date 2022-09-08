<?php
/**
 * Header file for the Fancy Icey WordPress theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fancy Icey
 */

?><!DOCTYPE html>

<html <?php language_attributes();?>>
<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php wp_head();?>
</head>
<body <?php body_class(); ?>
<div id="page" class="site">
    <header>
        <section class="top-bar bg-black">
            <div class="max-w-fit md:max-w-7xl m-auto flex flex-nowrap py-4">
                <div class="brand basis-16">
                    <?php
                    if ( function_exists( 'the_custom_logo' ) ) {
                        the_custom_logo();
                    }
                    ?>
                </div>
                <div class="navMenu mx-auto hidden basis-full lg:flex main-men text-white font-['Montserrat'] text-base items-center">
                    <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'fancy_icey_main_menu',
                                'menu_class' => 'flex marginauto'
                            )
                        );
                    ?>
                </div>
                <div class="cart m-auto text-white basis-16">
                    <?php echo do_shortcode('[customAngusMiniCart]'); ?>
                </div>
            </div>
        </section>
    </header>