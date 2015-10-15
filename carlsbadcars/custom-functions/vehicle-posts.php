<?php
/*
Description: Enables the creation of standard custom post types for use within the Vehicle Posts.
Version: 0.1
Author: Frank Thoeny
TODO: Need to add an options panel to turn on/off the Custom Post Types
*/

class Vehicle_Posts {
			
	const VEHICLE_POST_TYPE = 'vehicle_posts';
	
	/**
	 * Function to Create All of the Post Types needed for Custom Framework
	 */
	function create_custom_post_types() {
		// TODO: Include an option to allow end users the ability to turn on/off each post type.
		// Conditional statement would be placed here to check if each post type was enabled		
		self::register_custom_post_type();
	}
	
	/**
	 * On Activation of Rewrite Rules will be flushed so that new Post Type permalinks will be active preventing a 404
	 */
	function flush_rewrite_rules() {
		self::create_custom_post_types();
		flush_rewrite_rules();
	}	
	
	
	/** 
	 * Register Vehicle Custom Post Type and Vehicle Custom Taxonomy
	 */
	function register_custom_post_type() {
		register_post_type(self::VEHICLE_POST_TYPE, array(
			'labels' => array(
				'name' => 'Vehicles',
				'singular_name' => 'Vehicle',
				'add_new' => 'Add Vehicle',
				'add_new_item' => 'Add New Vehicle',
				'edit_item' => 'Edit Vehicle',
				'new_item' => 'New Vehicle',
				'view_item' => 'View Vehicle',
				'search_items' => 'Search Vehicles',
				'not_found' => 'No vehicles found',
				'not_found_in_trash' => 'No vehicles found in trash',
			),
			'menu_icon' => get_bloginfo('template_url'). '/custom-functions/images/vehicle.png',
			'rewrite' => array('slug' => 'vehicles'),
			'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
			'capability_type' => 'page',
    		'has_archive' => true, 
			'public' => true,
			'publicly_queryable' => true,
            'show_ui' => true,
            //'menu_position' => 500, 
		));
		
		register_taxonomy('vehicles', self::VEHICLE_POST_TYPE, array(
			'label' => __('Vehicle Categories'), 
		 	'singular_name' => _('Vehicle Category'), 
			'hierarchical' => true,			
			'show_in_nav_menus' => true,			 
		 	'update_count_callback' => '_update_post_term_count', 
			'query_var' =>  true,			
		));
		
		register_taxonomy('model', self::VEHICLE_POST_TYPE, array(
			'label' => __('Model'), 
		 	'singular_name' => _('Model'), 
			'hierarchical' => true,			
			'show_in_nav_menus' => true,			 
		 	'update_count_callback' => '_update_post_term_count', 
			'query_var' =>  true,
			'rewrite' => array('slug' => 'model'),
			'args' => array( 'orderby' => 'term_order' ),
			'sort' => true,			
		));
		
		register_taxonomy('bodytype', self::VEHICLE_POST_TYPE, array(
			'label' => __('Body Type'), 
		 	'singular_name' => _('Body Type'), 
			'hierarchical' => true,			
			'show_in_nav_menus' => true,			 
		 	'update_count_callback' => '_update_post_term_count', 
			'query_var' =>  true,
			'rewrite' => array('slug' => 'bodytype'),
			'args' => array( 'orderby' => 'term_order' ),
			'sort' => true,			
		));
		
		register_taxonomy('transmissiontype', self::VEHICLE_POST_TYPE, array(
			'label' => __('Transmission Type'), 
		 	'singular_name' => _('Transmission Type'), 
			'hierarchical' => true,			
			'show_in_nav_menus' => true,			 
		 	'update_count_callback' => '_update_post_term_count', 
			'query_var' =>  true,
			'rewrite' => array('slug' => 'transmissiontype'),
			'args' => array( 'orderby' => 'term_order' ),
			'sort' => true,			
		));
		
		register_taxonomy('enginepower', self::VEHICLE_POST_TYPE, array(
			'label' => __('Engine Power'), 
		 	'singular_name' => _('Engine Power'), 
			'hierarchical' => true,			
			'show_in_nav_menus' => true,			 
		 	'update_count_callback' => '_update_post_term_count', 
			'query_var' =>  true,
			'rewrite' => array('slug' => 'enginepower'),
			'args' => array( 'orderby' => 'term_order' ),
			'sort' => true,			
		));
		
		register_taxonomy('fueltype', self::VEHICLE_POST_TYPE, array(
			'label' => __('Fuel Type'), 
		 	'singular_name' => _('Fuel Type'), 
			'hierarchical' => true,			
			'show_in_nav_menus' => true,			 
		 	'update_count_callback' => '_update_post_term_count', 
			'query_var' =>  true,
			'rewrite' => array('slug' => 'fueltype'),
			'args' => array( 'orderby' => 'term_order' ),
			'sort' => true,			
		));
		
		register_taxonomy('safety', self::VEHICLE_POST_TYPE, array(
			'label' => __('Safety'), 
		 	'singular_name' => _('Safety'), 
			'hierarchical' => true,			
			'show_in_nav_menus' => true,			 
		 	'update_count_callback' => '_update_post_term_count', 
			'query_var' =>  true,
			'rewrite' => array('slug' => 'safety'),
			'args' => array( 'orderby' => 'term_order' ),
			'sort' => true,			
		));
		
		// Currently No Meta Boxes to Add - Register the car Meta Boxes
		add_action('admin_menu', array('VEHICLE_META_BOXES', 'add_custom_boxes'));
	
		// Currently No Meta Boxes to Add - Save the Data from the Testimonial Meta Boxes
		add_action('save_post', array('VEHICLE_META_BOXES', 'save_postdata'), 1, 2);
		
	}

}
add_action('init', array('Vehicle_Posts', 'create_custom_post_types'), 5);
register_activation_hook(__FILE__, array('Vehicle_Posts', 'flush_rewrite_rules') );

