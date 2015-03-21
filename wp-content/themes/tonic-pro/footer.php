<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main, .grid and #page div elements.
 *
 * @since 1.0.0
 */
$bavotasan_theme_options = bavotasan_theme_options();

		/* Do not display sidebars if full width option selected on single
		   post/page templates */
		if ( is_bavotasan_full_width() ) {
			if ( 5 != $bavotasan_theme_options['layout'] )
				get_sidebar();
			get_sidebar( 'second' );
		}
		?>
	</div> <!-- #main.row -->
</div> <!-- #page.grid -->

<footer id="footer" role="contentinfo">
	<div id="footer-content" class="grid <?php echo $bavotasan_theme_options['width']; ?>">
		<div class="row">
			<?php dynamic_sidebar( 'extended-footer' ); ?>
		</div><!-- .row -->

		<div class="row">
			<p class="copyright c12">
				<?php $class = ( is_active_sidebar( 'extended-footer' ) ) ? ' active' : ''; ?>
				<span class="line<?php echo $class; ?>"></span>
				<span class="fl"><?php echo $bavotasan_theme_options['copyright']; ?></span>
				<span class="credit-link fr"><i class="icon-leaf"></i><?php printf( __( '%s created by %s.', 'tonic' ), BAVOTASAN_THEME_NAME, '<a href="https://themes.bavotasan.com">c.bavota</a>' ); ?></span>
			</p><!-- .c12 -->
		</div><!-- .row -->
	</div><!-- #footer-content.grid -->
</footer><!-- #footer -->

<?php wp_footer(); ?>
<!-- <?php echo BAVOTASAN_THEME_NAME; ?> created by c.bavota - https://themes.bavotasan.com -->
</body>
</html>