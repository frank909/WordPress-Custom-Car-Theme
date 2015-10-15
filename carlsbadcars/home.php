<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>


		<div id="primary">
			<div id="content" role="main">

			<?php /* Start the Loop */ ?>
			
			<?php query_posts("post_type=vehicle_posts&taxonomy=vehicles&vehicles=sale&showposts=-1&order=DESC"); ?>
			
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'vehicle', 'homepage', get_post_format() ); 	?>				
			
			<?php endwhile; ?>
			
			<div style="clear:both;"></div>
			
			
			<?php rewind_posts(); ?>			
			
			<header class="entry-header">
				<h2 class="entry-title" style="margin:20px 0 0;border-bottom:1px solid #BC0B0B;">Inventory</h2>			
			</header>
			
			<?php /* Start the Loop */ ?>
			
			<?php query_posts("post_type=vehicle_posts&taxonomy=vehicles&vehicles=inventory&showposts=3&order=DESC"); ?>
						
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'vehicle', 'homepage', get_post_format() ); ?>				

			<?php endwhile; ?>
			<?php 	// todo: make the more cars link dynamically show 3 more cars at a time. 
					// something like a Scroller or slider with jQuery ?>	
			<a href="<?php get_bloginfo('url'); ?>/vehicles/">More Cars</a>
			
					
			
			
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>