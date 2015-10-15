<?php
require $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

$body_type = filter_vehicle_taxonomies( 'bodytype', $_GET['bt'] );
	if ( $body_type ): $bt = $body_type;
	else: $bt ="";
	endif;
	
$transmission_type = filter_vehicle_taxonomies( 'transmissiontype', $_GET['tt'] );
	if ( $transmission_type ): $tt = $transmission_type;
	else: $tt ="";
	endif;
	
$engine_power = filter_vehicle_taxonomies( 'enginepower', $_GET['ep'] );
	if ( $engine_power ): $ep = $engine_power;
	else: $ep ="";
	endif;
	
$fuel_type = filter_vehicle_taxonomies( 'fueltype', $_GET['ft'] );
	if ( $fuel_type ): $ft = $fuel_type;
	else: $ft ="";
	endif;
	
// build the args for a new WP_Query Object		
$filter_args = array(
	'post_type' => 'vehicle_posts',
		'tax_query' => array( 
		'relation' => 'AND',
		$bt,$tt,$ep,$ft
	),
	'nopaging' => true
);

$results = new WP_Query( $filter_args );
// if there are results
if ( $results->have_posts() ) :
	// loop over the results to build the array to send to javascript
	while ( $results->have_posts() ) : $results->the_post();
		// get the model term
	 	$postTitle = get_the_title( $post->ID);
		$postPermalink = get_permalink();
		$postThumbnail = get_the_post_thumbnail( $post->ID, 'full', '' );
	 	if(has_post_thumbnail()): 
	 	$postThumbnail = $postThumbnail; 
		else: 
		$postThumbnail = '<img src="' . get_template_directory_uri() . '/custom-functions/images/no_photo.jpg";" >';
		endif; 
	 	
	 	// create an array with the model and url to the archive page
		$carModels[] = array(			
			'id' => $post->ID,			
			'title' => $postTitle,			
			'link' =>  $postPermalink,
			'thumbnail' => $postThumbnail
		 );
	endwhile;
else :
	// there are no results so return "-1"
	$carModels[] = -1;
endif;


// echo out the array json encoded
echo "[" . json_encode( $carModels ) . "]";
?>