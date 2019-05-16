<?php
/*
Plugin Name: Enfold Custom Code
Description: Enfold Custom Code
Version:     1.0
Author:      InoPlugs
Plugin URI:  https://inoplugs.com
Author URI:  https://inoplugs.com
*/

/**
 * Changes the redirect URL for the Return To Shop button in the cart.
 *
 * @return string
 */
function wc_empty_cart_redirect_url() {
	return 'http://localhost:8888/Flume/merch/';
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );

?>
