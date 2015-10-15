<?php /* Template Name: Filter Cars */ ?>
<?php get_header(); ?>
	
		<div id="primary">
			<div id="content" role="main">
					
						
						<style>
							#filter-cars div { clear: both; margin-bottom: 10px; border-bottom: 2px solid #b3b3b3; }
							#filter-cars div input[type=radio] { margin-right: 15px; }
						</style>		
						<form id="filter-cars">		
							<div>
								<label><strong>Body Type</strong></label><br>
								<?php get_vehicles_terms_for_filter( 'bodytype' ); ?>
							</div>
							<div>
								<label><strong>Transmission Type</strong></label><br>
								<?php get_vehicles_terms_for_filter( 'transmissiontype' ); ?>
							</div>
							<div>
								<label><strong>Engine Power</strong></label><br>
								<?php get_vehicles_terms_for_filter( 'enginepower' ); ?>
							</div>
							<div>
								<label><strong>Fuel Type</strong></label><br>
								<?php get_vehicles_terms_for_filter( 'fueltype' ); ?>
							</div>
						</form>
						
						<!-- Container for the DIV that will hold the results. You can put your "all models" list in UL -->
						<div id="car-results"></div>
					
				
			</div>
		</div>
		
<?php get_footer(); ?>