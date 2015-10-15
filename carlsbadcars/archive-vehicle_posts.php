<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">
			
			<?php if($_GET): ?>	
			
			<?php
						
			$year = $_GET['_year'];
			$make = $_GET['_make'];
			$model = $_GET['_model'];
			
			$searchargs = array(
				'post_type' => 'vehicle_posts',				
				'meta_query' => array(
					array(
	           			'key' => '_year',
	           			'value' => $year,
	           			'compare' => 'LIKE'
					),
					array(
						'key' => '_make',
	           			'value' => $make,
	           			'compare' => 'LIKE'
					),
	           		array(
						'key' => '_model',
	           			'value' => $model,
	           			'compare' => 'LIKE'
					)
				)
			);
			
			
			$query = new WP_Query( $searchargs );
			?>	
			
			<?php // if there are results
			if ( $query->have_posts() ) : ?>
			
				<header class="page-header">
					<h1 class="page-title">Your Search Results for: <?php echo $year. ' ' .$make. ' ' .$model; ?></h1>
				</header>
				
				<?php twentyeleven_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'vehicle', 'homepage', get_post_format() );												
					?>
					
				<?php endwhile; ?>
				
				<?php else: ?>
				<header class="page-header">
					<h1 class="page-title">Your Search Results for: <?php echo $year. ' ' .$make. ' ' .$model; ?></h1>
				</header>				
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested vehicle. Perhaps searching again will help find it.', 'twentyeleven' ); ?></p>
						
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

				
				<?php endif; ?>
					
			<?php else: ?>
				
				<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">Our Inventory</h1>
				</header>

				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'vehicle', 'homepage', get_post_format() );
					?>

				<?php endwhile; ?>
				
				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
			
			<?php endif; ?>
			

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>