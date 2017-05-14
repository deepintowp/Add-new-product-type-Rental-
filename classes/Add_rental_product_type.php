<?php

class Add_rental_product_type{
	private static $_instance = null;
	
	
	// Add rental type product 
	public function add_rental_product( $types ){

	
	$types[ 'rental' ] = __( 'Rental' );

	return $types;

	}
	//Show pricing field for rental prduct.
	
	public function rental_custom_js() {

	if ( 'product' != get_post_type() ) :
		return;
	endif;

	?><script type='text/javascript'>
		jQuery( document ).ready( function() {
			jQuery( '.options_group.pricing' ).addClass( 'show_if_rental' ).show();
		});
	</script><?php
	}
	
	/**
	 * Add a custom product tab.
	 */
	function add_rental_product_tabs( $tabs) {
		$tabs['rental'] = array(
			'label'		=> __( 'Rental', 'woocommerce' ),
			'target'	=> 'rental_options',
			'class'		=> array( 'show_if_rental', 'show_if_variable_rental'  ),
		);
		return $tabs;
	}

	
	
	
	//Initilization of this class
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new Add_rental_product_type();
		}
		return self::$_instance;
	}
	
	/**
 * Contents of the rental options product tab.
 */
function rental_options_product_tab_content() {
	global $post;
	?><div id='rental_options' class='panel woocommerce_options_panel'><?php
		?><div class='options_group'><?php
			woocommerce_wp_checkbox( array(
				'id' 		=> '_enable_option',
				'label' 	=> __( 'Enable rental option X', 'woocommerce' ),
			) );
			woocommerce_wp_text_input( array(
				'id'			=> '_text_input_y',
				'label'			=> __( 'What is the value of Y', 'woocommerce' ),
				'desc_tip'		=> 'true',
				'description'	=> __( 'A handy description field', 'woocommerce' ),
				'type' 			=> 'text',
			) );
		?></div>

	</div><?php
}

/**
 * Save the custom fields.
 */
function save_rental_option_field( $post_id ) {
	
	$rental_option = isset( $_POST['_enable_option'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_enable_option', $rental_option );
	
	if ( isset( $_POST['_text_input_y'] ) ) :
		update_post_meta( $post_id, '_text_input_y', sanitize_text_field( $_POST['_text_input_y'] ) );
	endif;
	
}
	
	/**
 * Hide Attributes data panel.
 */
function hide_attributes_data_panel( $tabs) {
	
	// Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
	$tabs['attribute']['class'][] = 'hide_if_rental hide_if_variable_rental';

	return $tabs;

}


	

}

	
	
	
	
	
	
	
	
	
