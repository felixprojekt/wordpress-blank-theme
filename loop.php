<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail(array(120,120)); // Declare pixel size you need inside the array ?>
			</a>
		<?php endif; ?>

		<h2>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>

		<span class="date"><?php echo get_the_date(); ?></span>
		<span class="author"><?php _e( 'Published by', 'theme' ); ?> <?php the_author_posts_link(); ?></span>

		<?php html5wp_excerpt('html5wp_index'); // Build your custom callback length in functions.php ?>

	</article>

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'theme' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
