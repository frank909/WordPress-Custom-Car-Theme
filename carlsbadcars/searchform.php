<?php wp_reset_query(); ?>
<?php 

global $post;	
		
$year_options = '';
$make_options = '';
$model_options = '';

$searchargs = array(
				'post_type' => 'vehicle_posts',
			);
			
			
$query = new WP_Query( $searchargs );

while ( $query->have_posts() ) : $query->the_post(); 
	
	$year = get_post_meta($post->ID, '_year', true);	
	$make = get_post_meta($post->ID, '_make', true);
	$model = get_post_meta($post->ID, '_model', true);
	
	$year_options .= '<option value="' . $year . '">' . $year . '</option>';
	$make_options .= '<option value="' . $make . '">' . $make . '</option>';
	$model_options .= '<option value="' . $model . '">' . $model . '</option>';
 
endwhile; 

?>
	
<style type="text/css">
		#searchform {position:absolute; top:0;padding:10px; width:200px; background:#222;}
		#searchform label{float:left;padding:4px;color:#eee;}
		#searchform select{width:140px;padding:4px;border:1px solid #EE0000;}
		
</style>
<form role="search" method="get" id="searchform" action="<?php echo get_bloginfo( 'url' ); ?>/vehicles/">
			
	<div>
        <div>
        	<label for="_year">Year:</label>
        	<select id="_year" name="_year">
        		<option value=""> </option>        		
        		<?php echo $year_options; ?>        		
        	</select>
        </div>
        
		<div>
			<label for="_make">Make:</label>
			<select id="_make" name="_make">
				<option value=""> </option>				
				<?php echo $make_options; ?>
			</select>
		</div>
		
		<div>
			<label for="_model">Model:</label>
			<select id="_model" name="_model">
				<option value=""> </option>				
				<?php echo $model_options; ?>
			</select>
		</div>
				
		<div><input type="submit" value="Find a Car" /></div>
		
     </div>
   
</form>
<?php wp_reset_query(); ?>
