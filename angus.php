<?php
function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );

add_filter( 'woocommerce_checkout_fields' , 'icey_remove_billing_postcode_checkout' );

function icey_remove_billing_postcode_checkout( $fields ) {
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['shipping']['shipping_postcode']);
  unset($fields['shipping']['shipping_address_2']);
  return $fields;
}

//// Editare camp firma

add_filter( 'woocommerce_default_address_fields' , 'icey_rename_state_province', 9999 );

function icey_rename_state_province( $fields ) {
    $fields['company']['label'] = 'Nume firma + CIF + J';
	$fields['address_1']['label'] = 'Adresă completă -  Nume stradă, număr bloc/casă, etaj, apartament';
	$fields['country']['label'] = 'Țara';
    return $fields;
}


/**
 *POLITICA GDPR
 */

add_action( 'woocommerce_review_order_before_submit', 'bbloomer_add_checkout_privacy_policy', 9 );

function bbloomer_add_checkout_privacy_policy() {

woocommerce_form_field( 'privacy_policy', array(
   'type'          => 'checkbox',
   'class'         => array('form-row privacy form-row validate-required terms wc-terms-and-conditions'),
   'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
   'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox checkbox-sign'),
   'required'      => true,
   'label'         => 'Sunt de acord cu prelucrarea datelor, conform <a href="/gdpr/">GDPR</a>',
));

}

// Show notice if customer does not tick

add_action( 'woocommerce_checkout_process', 'bbloomer_not_approved_privacy' );

function bbloomer_not_approved_privacy() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
        wc_add_notice( __( 'Trebuie sa fii de acord cu politca GDPR' ), 'error' );
    }
}

// add_action('admin_init', function () {
//     // Redirect any user trying to access comments page
//     global $pagenow;

//     if ($pagenow === 'edit-comments.php') {
//         wp_redirect(admin_url());
//         exit;
//     }

//     // Remove comments metabox from dashboard
//     remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

//     // Disable support for comments and trackbacks in post types
//     foreach (get_post_types() as $post_type) {
//         if (post_type_supports($post_type, 'comments')) {
//             remove_post_type_support($post_type, 'comments');
//             remove_post_type_support($post_type, 'trackbacks');
//         }
//     }
// });

// Close comments on the front-end
// add_filter('comments_open', '__return_false', 20, 2);
// add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
// add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
// add_action('admin_menu', function () {
//     remove_menu_page('edit-comments.php');
// });

// Remove comments links from admin bar
// add_action('init', function () {
//     if (is_admin_bar_showing()) {
//         remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
//     }
// });

/* STIL PAGINA ADMIN */

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
.wp-pointer-right {
position: absolute;
    width: 369px !important;
    left: 1400px !important;
}

  </style>';
}

function wpb_login_logo() { ?>
    <style type="text/css">
body {background: #000000 !important;}
.login #backtoblog a, .login #nav a {
    text-decoration: none;
    color: #ffffff !important;
}
.login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
 color: #E42312 !important;
}

.wp-core-ui .button-primary {
    background: #000000 !important;
    border-color: #000000 !important;
    color: #fff !important;
	font-weight: 500;
		}

        #login h1 a, .login h1 a {
            background-image: url(https://test.premiumangus.ro/wp-content/uploads/2020/03/KPA-logo-1-90x130-1.png);
        height:100px;
        width:auto;
        padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'wpb_login_logo' );

function custom_admin_logo(){
    echo '
        <style type="text/css">
            #wp-admin-bar-wp-logo .ab-icon:before{ content:"" !important; }
            #wp-admin-bar-wp-logo .ab-icon{ background-image: url(/wp-content/uploads/2020/02/favicon-96x96-1.png) !important; }
        </style>
    ';
}
add_action( 'admin_head', 'custom_admin_logo' );

/*
add_action( 'woocommerce_email_before_order_table', 'icey_add_content_specific_email', 20, 4 );
function icey_add_content_specific_email( $order, $sent_to_admin, $plain_text, $email ) {
   if ( $email->id == 'customer_processing_order' ) {
	echo "<p><strong>În contextul evoluției răspândirii infecției cu virusul COVID-19 în România, partenerul nostru care realizează transportul pachetelor Premium Angus a creat noi reguli de livrare a pachetelor la dvs.   Cutia de stiropor și bateria de răcire din imaginea de mai jos, vor rămâne la dvs., urmând ca acestea să fie preluate de la dvs. de către curier, în ziua următoare livrării.</strong></p>
<p><strong>Mai multe detalii despre modul de operare și măsurile de prevenție în momentul livrării vi le vom comunica telefonic înainte de livrarea pachetului.</strong></p>";
}
}
add_action( 'woocommerce_email_before_order_table', 'icey_add_content_specific_emaila', 20, 4 );
function icey_add_content_specific_emaila( $order, $sent_to_admin, $plain_text, $email ) {
if ( $email->id == 'customer_on_hold_order' ) {
	echo "<p><strong>În contextul evoluției răspândirii infecției cu virusul COVID-19 în România, partenerul nostru care realizează transportul pachetelor Premium Angus a creat noi reguli de livrare a pachetelor la dvs.   Cutia de stiropor și bateria de răcire din imaginea de mai jos, vor rămâne la dvs., urmând ca acestea să fie preluate de la dvs. de către curier, în ziua următoare livrării.</strong></p>
<p><strong>Mai multe detalii despre modul de operare și măsurile de prevenție în momentul livrării vi le vom comunica telefonic înainte de livrarea pachetului.</strong></p>";
}
}
*/

function themeslug_enqueue_script() {
    wp_enqueue_script( 'jquery-v-2', 'http://code.jquery.com/jquery-2.1.3.min.js', false );
}

add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_script' );






add_filter('wpseo_premium_post_redirect_slug_change', '__return_true' );
add_filter('wpseo_premium_term_redirect_slug_change', '__return_true' );
add_filter('wpseo_enable_notification_post_trash', '__return_false');
add_filter('wpseo_enable_notification_post_slug_change', '__return_false');
add_filter('wpseo_enable_notification_term_slug_change','__return_false');


function wpse_enqueue_page_template_styles() {
    if ( is_page_template( 'custompage.php' ) ) {
        wp_enqueue_style( 'page-template', get_template_directory_uri() . '/css/customstyle.css' );
    }
}
add_action( 'wp_enqueue_scripts', 'wpse_enqueue_page_template_styles' );


// Eliminare buton "Adauga in cos"
add_action('woocommerce_product_options_general_product_data', 'product_custom_fields_add');
function product_custom_fields_add(){
    global $post;

    echo '<div class="product_custom_field">';

    // Custom Product Checkbox Field
    woocommerce_wp_checkbox( array(
        'id'        => '_no_addcart_product',
        'desc'      => __('show or hide add to cart', 'woocommerce'),
        'label'     => __('Ascunde Adaugare In Cos', 'woocommerce'),
        'desc_tip'  => 'true'
    ));

    echo '</div>';
}

// Save Checkbox
add_action('woocommerce_process_product_meta', 'product_custom_fields_save');
function product_custom_fields_save($post_id){
    // Custom Product Text Field
    $no_addcart_product = isset( $_POST['_no_addcart_product'] ) ? 'yes' : 'no';
        update_post_meta($post_id, '_no_addcart_product', esc_attr( $no_addcart_product ));
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'replacing_add_to_cart_button', 10, 2 );
function replacing_add_to_cart_button( $button, $product ) {
    if (  $product->get_meta('_no_addcart_product') === 'yes' ) {
        $button_text = __("View product", "woocommerce");
        $button = '<a class="button" href="'. $product->get_permalink().'">' . $button_text.'</a>';
    }
    return $button;
}


/// Elimina pretul din catalog
//
//// Eliminare buton "Adauga in cos"
add_action('woocommerce_product_options_general_product_data', 'product_custom_price_field');
function product_custom_price_field(){
    global $post;

    echo '<div class="product_custom_field">';

    // Custom Product Checkbox Field
    woocommerce_wp_checkbox( array(
        'id'        => '_no_price_product',
        'desc'      => __('Afiseaza sau ascunde pretul', 'woocommerce'),
        'label'     => __('Ascunde pretul produsului', 'woocommerce'),
        'desc_tip'  => 'true'
    ));

    echo '</div>';
}


// Save Checkbox
add_action('woocommerce_process_product_meta', 'product_custom_price_field_save');
function product_custom_price_field_save($post_id){
    // Custom Product Text Field
    $no_price_product = isset( $_POST['_no_price_product'] ) ? 'yes' : 'no';
        update_post_meta($post_id, '_no_price_product', esc_attr( $no_price_product ));
}

add_filter( 'woocommerce_product_get_price', 'replacing_price_button', 10, 2 );
function replacing_price_button( $price, $product ) {
    if (  $product->get_meta('_no_price_product') === 'yes' ) {
        $price = '';
    }
    return $price;

}

/// ADAUGARE "Cerere Oferta"


/*
add_filter('woocommerce_after_shop_loop_item', 'adaugare_mesaj', 10);
function adaugare_mesaj(){
	if ($product->get_meta('_no_price_product') === 'yes' ) {
	echo '<a style="color:#f44336;font-size: 18px;font-weight: 600;" href="'. $product->get_permalink().'">Cere ofertă personalizată</a>';
	}
}

/**

 * Eliminare plata cu cardul si transfer bancar pentru categoria YourPack

*/
add_filter( 'woocommerce_available_payment_gateways', 'disable_payment_method_for_yourpack');

function disable_payment_method_for_yourpack( $gateways ) {
    if ( is_admin() ) return $gateways;
    if ( ! is_checkout() ) return $gateways;
    $category_ids = get_terms( array( 'taxonomy' => 'product_cat', 'slug' => array('yourpack'), 'fields' => 'ids' ) );
 	print_r($category_ids);
    $found_yourpack = false;

    foreach ( WC()->cart->get_cart() as $item ) {
        $product = $item['data'];
        if ( in_array( $category_ids[0], $product->get_category_ids() ) ) {
            echo ' a intrat';
            $found_yourpack = true;
        }
    }
    if($found_yourpack) {
        unset( $gateways['euplatesc'], $gateways['bacs'] );
    } else {
        unset( $gateways['cheque'],  $gateways['offline_gateway']); // Disable payment gateway 'cod' when product has one of the categories
    }
    return $gateways;
}


add_action( 'template_redirect', 'rp_callback' );
function rp_callback() {
  if ( is_cart()) {
		$cat_check = false;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$product = $cart_item['data'];
			if ( has_term( 'yourpack', 'product_cat', $product->id ) ) {
				$cat_check = true;
				break;
			}
		}
		if ( $cat_check ) {
			$checkPricePack = 499;
			global $woocommerce;
			$subtotal = $woocommerce->cart->subtotal;
				if( $subtotal <= $checkPricePack){
					echo '
					<style>
						.yourpackcheck{display:none !important;}
					</style>
					';
				}
		}
  }
}


/// Schimbare status la cerere oferta

add_action( 'woocommerce_thankyou', 'cheque_payment_method_order_status_to_processing', 10, 1 );
function cheque_payment_method_order_status_to_processing( $order_id ) {
    if ( ! $order_id )
        return;
    $order = wc_get_order( $order_id );
    // Updating order status to processing for orders delivered with Cheque payment methods.
    if (  get_post_meta($order->id, '_payment_method', true) == 'cheque' )
        $order->update_status( 'cerere-oferta' );
}

/**
 * Holiday text message product page
 */
// add_action('woocommerce_after_add_to_cart_form', 'product_page_holidays');
// function product_page_holidays(){
// 	$defaultLang = pll_current_language( );
// 	if($defaultLang == 'ro'){
// 		echo '<p>Începând din <b>20 decembrie nu se vor mai onora comenzile plasate</b> pe site-ul nostru până după Sărbători. Puteți plasa comanda dar, aceasta va fi livrată începând cu data de 05.01.2022.<br> Vă mulțumim pentru înțelegere. </p>';
// 	}else{
// 		echo '<p>From <b>December 20, orders placed on our website will not be honored until after the holidays.</b> You can place your order but it will be delivered starting with 05.01.2022.<br> Thank you for understanding. </p>';
// 	}
// }
//
add_filter('woocommerce_sale_flash', 'lw_hide_sale_flash');
function lw_hide_sale_flash()
{
return false;
}


// Add ALT to images WOOCOMMERCE
add_filter('wp_get_attachment_image_attributes', 'change_attachement_image_attributes', 20, 2);

function change_attachement_image_attributes( $attr, $attachment ){
    // Get post parent
    $parent = get_post_field( 'post_parent', $attachment);

    // Get post type to check if it's product
    $type = get_post_field( 'post_type', $parent);
    if( $type != 'product' ){
        return $attr;
    }

    /// Get title
    $title = get_post_field( 'post_title', $parent);

    $attr['alt'] = $title;
    $attr['title'] = $title;

    return $attr;
}