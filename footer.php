<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Liner_Hu
 * @since Liner Hu 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer class="footerContainer">
		<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
		<div class="ftrwidgetContainer">
			<div class="container">
				<div class="row vertical-align"><?php dynamic_sidebar( 'sidebar-4' ); ?></div>
			</div>
		</div>
		<?php endif; ?>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
