<?php
function custom_mini_cart() {
    ob_start();
    echo '
        <a href='.wc_get_cart_url().' class="relative">
            <img src=' . get_template_directory_uri() . "/images/cart.svg" . ' 
                 alt=' . esc_html__("Cart", "fancy-icey") . ' 
                 width="25" height="25"/>
            <span class="badge">'. WC()->cart->get_cart_contents_count() .'</span>
        </a>
        <div id="popUpCart" class="relative minicart bg-white">
            <div class="text-black z-50 pt-2">';
                woocommerce_mini_cart();
    echo '</div></div>';

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'customAngusMiniCart', 'custom_mini_cart' );


//<div id="popUpCart" class="relative">
//            <div class="absolute top-0 right-0 bg-white text-black">
//'.woocommerce_mini_cart().'
//            </div>
//        </div>
//echo '<a href="#" class="dropdown-back" data-toggle="dropdown"> ';
//echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
//echo '<div class="basket-item-count" style="display: inline;">';
//echo '<span class="cart-items-count count">';
//echo WC()->cart->get_cart_contents_count();
//echo '</span>';
//echo '</div>';
//echo '</a>';
//echo '<ul class="dropdown-menu dropdown-menu-mini-cart">';
//echo '<li> <div class="widget_shopping_cart_content">';
//woocommerce_mini_cart();
//echo '</div></li></ul>';
