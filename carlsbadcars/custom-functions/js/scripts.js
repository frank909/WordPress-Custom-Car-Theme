jQuery(document).ready(function() {

	var unique = Math.floor(Math.random()*999999);
	
	// for each checkbox with the class "ajax-cb"
	jQuery('.ajax-rb').each(function() {
		
		// when it is clicked...
		jQuery(this).click(function() {
			
			var unique = Math.floor(Math.random()*999999);					
			// create an array to hold the car tax values
			var bt = [];
			var tt = [];
			var ep = [];
			var ft = [];
											
			// push all the values of the currently checked boxes onto the tax arrays
			jQuery("input[name='bodytype[]']:checked").each(function(){bt.push(jQuery(this).val());});
			jQuery("input[name='transmissiontype[]']:checked").each(function(){tt.push(jQuery(this).val());});
			jQuery("input[name='enginepower[]']:checked").each(function(){ep.push(jQuery(this).val());});
			jQuery("input[name='fueltype[]']:checked").each(function(){ft.push(jQuery(this).val());});
			
			jQuery.ajax({
				
				// load the url that contains the php file that will do the post searching
				url: "/wp-content/themes/carlsbadcars/custom-functions/includes/filter.php?bt=" + bt +"&tt=" + tt + "&ep=" + ep + "&ft=" + ft + "&t=" + unique,
				async: false,
				cache: false,
				type: 'GET',
				success: function(data) {
					
					//on success get ahold of the UL and remove all the children
					jQuery('#car-results').children().remove();		
								
					// parse out the results of the ajax file requested			
					var results = jQuery.parseJSON(data);
					console.log( results );
					if ( results[0] != -1 ) {
						// loop through the results
						for ( var i = 0; i < results[0].length; i++ ) {	
							// and append each result as an LI
							var html = '';
							html += '<article id="post-' + results[0][i].id + '">';							
							html += '	<div class="entry-content">';
							html += '		<a href="' + results[0][i].link + '"  style="display:block;float:left;margin-right:10px;">';
							html += results[0][i].thumbnail;
							html += '		</a>';
							html += '		<a href="' + results[0][i].link + '">';
							html += results[0][i].title;							
							html += '		</a>';
							html += '	</div><!-- .entry-content -->';
							html += '<div class="clear"></div>';
							html += '</article><!-- #post-<?php the_ID(); ?> -->';
							
							jQuery('#car-results').append(html);
						}	
					} else {
						jQuery('#car-results').append('<div>There are no results.</div>');					
					}	
								
				}
				
			});	
			
		});
		
	});		

});