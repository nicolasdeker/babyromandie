<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @since 1.0.6
 */
$bavotasan_theme_options = bavotasan_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h3 class="post-format"><i class="icon-link"></i><?php _e( 'Link', 'tonic' ); ?></h3>

	    <div class="entry-content">
		    <?php the_content( $bavotasan_theme_options['read_more'] ); ?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article>