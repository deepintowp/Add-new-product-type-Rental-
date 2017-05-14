<?php 
/**
 * @package Rental Product
 */
/*
Plugin Name:Rental Product
Plugin URI: http://wordpress.org/rental-product
Description: Add Video To product
Version: 1.0.0
Author: Subhasish Manna
Author URI: http://http://b.subho.host22.com/
License: GPLv2 or later
Text Domain: pr-path
*/
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
if (version_compare(get_bloginfo('version'), '4.2', '<=')) {
    echo 'need wp 4.2 at least';
	exit;
}
/**
 * Check if WooCommerce is active
 **/
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
     echo 'need to activate WC';
	exit;
}
//constants
define('RP_PATH', plugin_dir_path(__FILE__) );

//include classes by autoload
include(RP_PATH.'inc/register_product_type.php');
spl_autoload_register(function($classname){
	$path = RP_PATH.'classes/'.$classname.'.php';
	
	if(file_exists($path)){
		require_once($path);
	}
	
	
});

/*====================
hooks
=======================*/

//add_action('init', 'register_rental_product_type');
if(is_admin() ) {
	//register product type first
	
	//if product type registered
	
		$add_pro_type =  Add_rental_product_type::getInstance();
		// Add rental product Type
		add_filter( 'product_type_selector', array($add_pro_type, 'add_rental_product') );
		//Show pricing field for rental product 
		add_action( 'admin_footer', array($add_pro_type, 'rental_custom_js') );
		
		// Show tab for rental product 
		add_filter( 'woocommerce_product_data_tabs', array($add_pro_type, 'add_rental_product_tabs') );
	
		// add field to rental tab
		add_action( 'woocommerce_product_data_panels', array($add_pro_type, 'rental_options_product_tab_content') );
	
		add_action( 'woocommerce_process_product_meta_rental',  array($add_pro_type,'save_rental_option_field')  );
		add_action( 'woocommerce_process_product_meta_variable_rental',  array($add_pro_type,'save_rental_option_field' ) );	
	
		//hide other tab 
		add_filter( 'woocommerce_product_data_tabs', array($add_pro_type,'hide_attributes_data_panel') );
	
	
	
	
}else{
	
	add_filter( 'woocommerce_single_product_image_thumbnail_html', 'print_product_type_rental');
	
	function print_product_type_rental($content){
		if(get_product( get_the_ID() )->is_type('rental')){return '<div class="product_type_rental">Rental</div>'.$content; }
	}
}


