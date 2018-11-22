<?php get_header(); ?>
<main role="main">
	<section>
		<article id="post-404">
			<h1><?php _e( 'Page not found', 'theme' ); ?></h1>
			<h2>
				<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'theme' ); ?></a>
			</h2>
		</article>
	</section>
</main>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
