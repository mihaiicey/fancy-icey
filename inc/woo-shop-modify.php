<?php
function fancy_icey_shop_actions(){
    if(is_shop()){
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
        remove_action('woocommerce_archive_description','woocommerce_taxonomy_archive_description');
        remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
        remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);

/*
 * Shows the title before image
 */
    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
    add_action('woocommerce_before_shop_loop_item_title','fancy_icey_custom_product_archive_title', 1);
    }
    function fancy_icey_custom_product_archive_title(){
        global $product;
        echo '<span class="text-2xl uppercase font-bold">'.$product->get_name().'</span>';
    }
/*
 * Change form "SALE" to "%"
 */
    add_filter( 'woocommerce_sale_flash', 'add_percentage_to_sale_badge', 20, 3 );
    function add_percentage_to_sale_badge( $html, $post, $product ) {

        if( $product->is_type('variable')){
            $percentages = array();

            // Get all variation prices
            $prices = $product->get_variation_prices();

            // Loop through variation prices
            foreach( $prices['price'] as $key => $price ){
                // Only on sale variations
                if( $prices['regular_price'][$key] !== $price ){
                    // Calculate and set in the array the percentage for each variation on sale
                    $percentages[] = round( 100 - ( floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100 ) );
                }
            }
            // We keep the highest value
            $percentage = max($percentages) . '%';

        } elseif( $product->is_type('grouped') ){
            $percentages = array();

            // Get all variation prices
            $children_ids = $product->get_children();

            // Loop through variation prices
            foreach( $children_ids as $child_id ){
                $child_product = wc_get_product($child_id);

                $regular_price = (float) $child_product->get_regular_price();
                $sale_price    = (float) $child_product->get_sale_price();

                if ( $sale_price != 0 || ! empty($sale_price) ) {
                    // Calculate and set in the array the percentage for each child on sale
                    $percentages[] = round(100 - ($sale_price / $regular_price * 100));
                }
            }
            // We keep the highest value
            $percentage = max($percentages) . '%';

        } else {
            $regular_price = (float) $product->get_regular_price();
            $sale_price    = (float) $product->get_sale_price();

            if ( $sale_price != 0 || ! empty($sale_price) ) {
                $percentage    = round(100 - ($sale_price / $regular_price * 100)) . '%';
            } else {
                return $html;
            }
        }
        return '<span class="onsale">' . $percentage . '</span>';
    }

}
add_action('wp','fancy_icey_shop_actions');