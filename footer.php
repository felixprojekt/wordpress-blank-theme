
			<footer class="footer" role="contentinfo">

				<?php if ( is_active_sidebar( 'widget-area-1' ) ) : ?>
					<div id="widget-area-1" class="footer-widget widget-area" role="complementary">
						<?php dynamic_sidebar( 'widget-area-1' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'widget-area-2' ) ) : ?>
					<div id="widget-area-2" class="footer-widget widget-area" role="complementary">
						<?php dynamic_sidebar( 'widget-area-2' ); ?>
					</div>
				<?php endif; ?>

				<p class="copyright">
					&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
				</p>
			</footer>
		</div>
		<?php
			if ( is_single() || is_page() ) {
				edit_post_link();
			}
		?>
		<?php wp_footer(); ?>
	</body>
</html>
