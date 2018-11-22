<?php get_header(); ?>

<main role="main">
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php if ( has_post_thumbnail()) : ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
			<?php endif; ?>

			<h1>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h1>

			<span class="date"><?php echo get_the_date() ?></span>
			<span class="author"><?php _e( 'Published by', 'theme' ); ?> <?php the_author_posts_link(); ?></span>
			<span class="comments"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'theme' ), __( '1 Comment', 'theme' ), __( '% Comments', 'theme' )); ?></span>

			<?php the_content(); ?>

			<?php the_tags( __( 'Tags: ', 'theme' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

			<p><?php _e( 'Categorised in: ', 'theme' ); the_category(', '); // Separated by commas ?></p>

			<p><?php _e( 'This post was written by ', 'theme' ); the_author(); ?></p>

			<?php comments_template(); ?>

		</article>

	<?php endwhile; ?>

	<?php else: ?>
		<article>
			<h1><?php _e( 'Sorry, nothing to display.', 'theme' ); ?></h1>
		</article>
	<?php endif; ?>

	</section>
</main>

<?php get_footer(); ?>
