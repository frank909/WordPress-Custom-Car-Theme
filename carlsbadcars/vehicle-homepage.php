<?php
/**
 * The template for displaying vehicle inventory.
 *
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<?php
$year = get_post_meta($post->ID, '_year', true);
$make = get_post_meta($post->ID, '_make', true);
$model = get_post_meta($post->ID, '_model', true);
$submodel = get_post_meta($post->ID, '_submodel', true);
$price = get_post_meta($post->ID, '_price', true);
$nophoto = get_template_directory_uri() . "/custom-functions/images/no_photo.jpg";
?>

<?php if(is_tax("vehicles","sale")): ?>

	<div style="min-height:140px;text-align:center;float:left;margin:0 0 10px;">		
		<a href="<?php the_permalink(); ?>">
		<?php if(has_post_thumbnail()): the_post_thumbnail(); 
			else: ?><img src="<?php echo $nophoto; ?>" /><?php endif; ?></a>
	    <div style="width:190px;">
		    <?php //echo $year . ' ' . $make . ' ' .  $model . ' ' . $submodel; ?>
		    <?php the_title(); ?>	     
			<h3><?php echo $price; ?></h3>
		</div>
		<?php //<div class="clear"></div> ?>
	</div>

<?php else: ?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<a href="<?php the_permalink(); ?>" style="display:block;float:left;margin-right:10px;">			
				<?php if(has_post_thumbnail()): the_post_thumbnail(); 
				else: ?><img src="<?php echo $nophoto; ?>" /><?php endif; ?>
			</a>			
		    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		    <br>
		    <?php echo $price; ?>		    
	    	<div class="clear"></div> 
	 	</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
<?php endif;?>


					

				