<?php
/**
 * The template for displaying content in the single-vehicle_posts.php template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div style="float:left;width:150px;"><?php the_post_thumbnail(); ?></div>
	
	<header class="entry-header">		
		
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<h3>Sale Price: <?php echo get_post_meta($post->ID, '_price', true); ?></h3>		
	</header><!-- .entry-header -->

	<div class="entry-content">
		
		<?php the_content(); ?>
		<?php	
				$pmeta = get_post_meta($post->ID, '_year', true);  					
				$pmeta .= ' ' . get_post_meta($post->ID, '_make', true);  					
				$pmeta .= ' ' .get_post_meta($post->ID, '_model', true);
				$pmeta .= ' ' .get_post_meta($post->ID, '_submodel', true); 
		?>
		<?php echo $pmeta; ?>
		
	</div><!-- .entry-content -->

	<div class="clear"></div>
</article><!-- #post-<?php the_ID(); ?> -->
