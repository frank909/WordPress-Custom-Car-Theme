<?php

class VEHICLE_META_BOXES {
	
	/** 
	 * Adds all of the Meta Boxes that are used by the Associate Custom Post Type
	 */
	function add_custom_boxes() {
		if( function_exists( 'add_meta_box' )) {
			add_meta_box( 'vehicle_info', __( 'Vehicle Information', 'custom_post_types' ), array('VEHICLE_META_BOXES', 'vehicle_info'), Vehicle_Posts::VEHICLE_POST_TYPE, 'normal', 'high' );
		}
	}
	
	/** 
	 * Displays all of the Contact Information Fields for the Associate Custom Post Type
	 */
	function vehicle_info() {
		global $post;
		
		// Use nonce for verification ... ONLY USE ONCE!
		echo '<input type="hidden" name="pw_noncename" id="pw_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		
		echo '<label for="_year">' . __("Year:", 'custom_post_types' ) . '</label><br />';
		echo '<input style="width: 95%;" type="text" name="_year" value="'.get_post_meta($post->ID, '_year', true).'" /><br /><br />';
		
		echo '<label for="_make">' . __("Make:", 'custom_post_types' ) . '</label><br />';
		echo '<input style="width: 95%;" type="text" name="_make" value="'.get_post_meta($post->ID, '_make', true).'" /><br /><br />';
		
		echo '<label for="_model">' . __("Model:", 'custom_post_types' ) . '</label><br />';
		echo '<input style="width: 95%;" type="text" name="_model" value="'.get_post_meta($post->ID, '_model', true).'" /><br /><br />';
		
		echo '<label for="_submodel">' . __("Sub-Model:", 'custom_post_types' ) . '</label><br />';
		echo '<input style="width: 95%;" type="text" name="_submodel" value="'.get_post_meta($post->ID, '_submodel', true).'" /><br /><br />';
	
		echo '<label for="_price">' . __("Price:", 'custom_post_types' ) . '</label><br />';
		echo '<input style="width: 95%;" type="text" name="_price" value="'.get_post_meta($post->ID, '_price', true).'" /><br /><br />';
	}
	
	/** 
	 * Saves all of the Vehicles Meta Box field information
	 */
	function save_postdata($post_id, $post) {
		
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( empty($_POST['pw_noncename']) || !wp_verify_nonce( $_POST['pw_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
		}
	
		// Is the user allowed to edit the post or page?
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post->ID ))
			return $post->ID;
		} else {
			if ( !current_user_can( 'edit_post', $post->ID ))
			return $post->ID;
		}
	
		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		
		// If there is no post order set then assign a value of 100000
		$mydata['_order'] = get_post_meta($post->ID, '_order', true) ? get_post_meta($post->ID, '_order', true) : 100000;
		
		// If _year is not set then set to the Post Title
		$mydata['_make'] = $_POST['_make'] ? $_POST['_make'] : get_the_title($post->ID);
		
		// If any value is not set then do not save data in array
		if($_POST['_year']) $mydata['_year'] = $_POST['_year'];
		if($_POST['_model']) $mydata['_model'] = $_POST['_model'];
		if($_POST['_submodel']) $mydata['_submodel'] = $_POST['_submodel'];
		if($_POST['_price']) $mydata['_price'] = $_POST['_price'];
		
		// Add values of $mydata as custom fields
		if ($mydata) : // Make sure $mydata has values
			foreach ($mydata as $key => $value) { //Let's cycle through the $mydata array!
				if( $post->post_type == 'revision' ) return; //don't store custom data twice
				$value = implode(',', (array)$value); //if $value is an array, make it a CSV (unlikely)
				if(get_post_meta($post->ID, $key, FALSE)) { //if the custom field already has a value
					update_post_meta($post->ID, $key, $value);
				} else { //if the custom field doesn't have a value
					add_post_meta($post->ID, $key, $value);
				}
				if(!$value) delete_post_meta($post->ID, $key); //delete if blank
			}
		endif;
	}

}
?>