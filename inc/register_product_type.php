<?php 
// register rental product type
	 
function register_custom_product_type() {

	class WC_Product_Rental extends WC_Product {

	public function get_type( ) {

			return  'rental';

		}
	}
	
}
add_action( 'init', 'register_custom_product_type' );