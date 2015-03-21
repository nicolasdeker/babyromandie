<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @since 1.0.6
 */
$bavotasan_theme_options = bavotasan_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <?php get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content">
	        <?php
			if( has_post_thumbnail() && ! is_single() )
				the_post_thumbnail( 'large', array( 'class' => 'alignnone img-polaroid' ) );
			else
				the_content( $bavotasan_theme_options['read_more'] );
			?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article>