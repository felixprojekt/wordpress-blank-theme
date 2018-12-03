			<!-- footer -->
			<footer class="footer" role="contentinfo">

				<?php if ( is_active_sidebar( 'widget-area-1' ) ) : ?>
					<div id="footer-widget-1" class="footer-widget widget-area" role="complementary">
						<?php dynamic_sidebar( 'footer-widget-1' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'widget-area-2' ) ) : ?>
					<div id="footer-widget-2" class="footer-widget widget-area" role="complementary">
						<?php dynamic_sidebar( 'footer-widget-2' ); ?>
					</div>
				<?php endif; ?>

				<!-- copyright -->
				<p class="copyright">
					&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
				</p>
				<!-- /copyright -->

			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->
		
		<?php edit_post_link(); ?>

		<?php wp_footer(); ?>

	</body>
</html>
