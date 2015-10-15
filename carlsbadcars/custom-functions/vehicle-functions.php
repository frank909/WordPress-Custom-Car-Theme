<?php

// Include the custom post, but only if it exists
if (file_exists(get_template_directory()   . '/custom-functions/vehicle-posts.php')):
	include_once(get_template_directory()   . '/custom-functions/vehicle-posts.php');
endif;

// register custom scripts
add_action( 'init', 'vehicles_register_scripts' );
function vehicles_register_scripts() {
	 wp_register_script( 'vehicles_scripts', get_bloginfo('template_url').'/custom-functions/js/scripts.js', array( 'jquery' ),'',true ); 
}

// enqueue custom scripts
add_action( 'wp_enqueue_scripts', 'vehicles_enqueue_scripts' );  
function vehicles_enqueue_scripts() {
	 wp_enqueue_script( 'vehicles_scripts' ); 
}

add_filter( 'manage_edit-vehicle_columns', 'add_columns_to_vehicles'  );
function add_columns_to_vehicles($defaults) {
    unset($defaults['date']);	
    unset($defaults['comments']);	
	$defaults['Model'] = __('Model');
	$defaults['BodyType'] = __('Body Type');
	$defaults['TransmissionType'] = __('Transmission Type');	
	$defaults['EnginePower'] = __('Engine Power');
	$defaults['FuelType'] = __('Fuel Type');
	return $defaults;
}

add_action('manage_vehicle_posts_custom_column', 'get_custom_vars_for_vehicles', 10, 2);
function get_custom_vars_for_vehicles($column_name, $id) {	
	$col_array = array(	
						'model' => 'Model',
						'bodytype' => 'BodyType',
						'transmissiontype' => 'TransmissionType',
						'enginepower' => 'EnginePower',
						'fueltype' => 'FuelType' 
						);
	foreach ( $col_array as $t => $c ) {
		if ( $column_name == $c) {
		 	$term = wp_get_object_terms( $id, $t );
		 	echo $term[0]->name;
			
		}
	}
}	 

function filter_vehicle_taxonomies( $taxonomy, $selection ) {
	$term_ids[] = (int)$selection;
	
	if ( $selection ) {
		$tax_array = array(
			'taxonomy' => $taxonomy,
			'field' => 'id',
			'terms' => $term_ids
		);	
	} else {
		$tax_array = array();
	}	
	
	return $tax_array;	
}

// Builds the list of terms as radio buttons
function get_vehicles_terms_for_filter( $taxonomy ) {	
	$terms = get_terms( $taxonomy, array( 'hide_empty' => false ) );
	foreach ( $terms as $term ) {
		echo "<label for=\"" . $term->term_id . "\">" . $term->name;
			echo "<input type=\"radio\" value=\"" . $term->term_id . "\" class=\"ajax-rb\" id=\"" . $term->term_id . "\" name=\"" . $taxonomy . "[]\" \>";
		echo "</label>";
	}

}

function get_video_id($url = '') {
	
	$embedded_id = wp_oembed_get($url);
	
	if ($embedded_id) {
		return $embedded_id;
	} 
	else if (preg_match('/^http\:\/\/(?:(?:[a-zA-Z0-9\-\_\.]+\.|)youtube\.com\/watch\?v\=|youtu\.be\/)([a-zA-Z0-9\-\_]+)/i', $url, $matches) > 0) {
        return $matches[1];
    }
    else if (preg_match('/^([a-zA-Z0-9\-\_]+)$/i', $url, $matches) > 0) {
        return $matches[1];
    }
	
	return esc_url_raw( $matches[1] );
}

function get_youtube_image($url) { 
	
	$youtube_id = get_video_id($url);
 
	// YouTube - get the corresponding thumbnail images	
	if($youtube_id)
		$video_thumb = "http://img.youtube.com/vi/".$youtube_id."/0.jpg";
 
	// return whichever thumbnail image you would like to retrieve
	return $video_thumb;
}


  
/**
 * Get an abbreviated content with custom lenth and more content
 */
function shorten_text($title, $max_char, $more_link_text = '...', $display = true) {
    $content = str_replace(']]>', ']]&gt;', $title);
    $content = strip_tags($content);

	if (isset($_GET['p']) && strlen($_GET['p']) > 0) 
	{
   		$output = $content; 
   	}
  	else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) 
	{
        $content = substr($content, 0, $espacio);
        $output = $content.$more_link_text;
   	}
   	else 
	{
		$output = $content;
	}
	
   	if ($display)
		echo $output;
	else
		return $output;
}

function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "". get_bloginfo('url')."/wp-content/plugins/images/noimages.jpg";
  }
  return $first_img;
}

function the_titlesmall($before = '', $after = '', $echo = true, $length = false) { $title = get_the_title();

	if ( $length && is_numeric($length) ) {
		$title = substr( $title, 0, $length );
	}

	if ( strlen($title)> 0 ) {
		$title = apply_filters('the_titlesmall', $before . $title . $after, $before, $after);
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}

/**
 * Get an abbreviated content with custom lenth and more content
 */
function the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '', $display = true) {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);
	
	$output = '';
   if (isset($_GET['p']) && strlen($_GET['p']) > 0) 
   {
      $output .= "<p>";
      $output .= $content;
      $output .= "&nbsp;<a rel='nofollow' href='";
      $output .= get_permalink();
      $output .= "'>".__('Read More', 'custom-post-type')." &rarr;</a>";
      $output .= "</p>";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) 
   {
        $content = substr($content, 0, $espacio);
        $content = $content;
        $output .= "<p>";
        $output .= $content;
        $output .= "...";
        $output .= "&nbsp;<a rel='nofollow' href='";
        $output .= get_permalink();
        $output .= "'>".$more_link_text."</a>";
        $output .= "</p>";
   }
   else 
   {
      $output .= "<p>";
      $output .= $content;
      $output .= "</p>";
   }
   
   if ($display)
		echo $output;
	else
		return $output;
}

/**
 * Display navigation to next/previous pages when applicable
 */
function content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="navnext">
			<h3 class="assistive-text"><?php _e( '', 'carlsbadcars' ); ?></h3>
			<div class="nav-previous"><?php previous_posts_link( __( '<span class="meta-nav"></span><img src="'.get_bloginfo('template_url').'/images/previouspages.png" />', 'carlsbadcars' ) ); ?></div>
			<div class="nav-next"><?php next_posts_link( __( '<span class="meta-nav"></span><img src="'.get_bloginfo('template_url').'/images/nextpages.png" />', 'carlsbadcars' ) ); ?>
	      </div>
		</nav><!-- #nav-above -->
	<?php endif;
}

function format_phone($phone)
{
	$phone = preg_replace("/[^0-9]/", "", $phone);

	if(strlen($phone) == 7)
		return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
	elseif(strlen($phone) == 10)
		return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
	else
		return $phone;	
}
/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 * @return string|bool URL or false when no link is present.
 */
function url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}




/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'Footer Area One' ) )
		$count++;

	if ( is_active_sidebar( 'Footer Area Two' ) )
		$count++;

	if ( is_active_sidebar( 'Footer Area Three' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

