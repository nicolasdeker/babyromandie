<?php
/**
 * Template Name: Blog Page Template
 *
 * Description: A page template that will display your latest posts
 *
 * @since 1.0.0
 */

get_header(); ?>

	<div id="primary" <?php bavotasan_primary_attr(); ?>>

		<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$wp_query = new WP_Query( array(
			'paged' => $paged,
			'ignore_sticky_posts' => 1,
		) );

		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;

			bavotasan_pagination();
		else :
			get_template_part( 'content', 'none' );
		endif;

		wp_reset_query();
		?>

	</div><!-- #primary.c8 -->

<?php get_footer(); ?>