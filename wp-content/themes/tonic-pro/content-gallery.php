<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @since 1.0.6
 */
$bavotasan_theme_options = bavotasan_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <?php get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content">
	        <?php
			if ( is_single() ) {
				the_content( '' );
			} else {
				if ( has_post_thumbnail() )
					$image_img_tag = wp_get_attachment_image( get_post_thumbnail_id(), 'large', false, array( 'class' => 'img-polaroid' ) );

				global $post;
				$images = get_children( array(
					'post_parent' => $post->ID,
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'numberposts' => 100
				) );

				if ( ! empty( $images ) ) {
					$total_images = count( $images );
					$image = array_shift( $images );
					$image_img_tag = ( empty( $image_img_tag ) ) ? wp_get_attachment_image( $image->ID, 'large', false, array( 'class' => 'img-polaroid' ) ) : $image_img_tag;
				} else {
					preg_match( '/\[gallery.*ids=.(.*).\]/', $post->post_content, $ids );
					$total_images = count( explode( ',', $ids[1] ) );
				}
				?>
				<a class="gallery-thumb alignnone" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
				<p class="gallery-text"><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo &rarr;</a>', 'This gallery contains <a %1$s>%2$s photos &rarr;</a>', $total_images, 'tonic' ), 'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'tonic' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						number_format_i18n( $total_images ) ); ?></em></p>
					<?php
			}
			?>
	    </div><!-- .entry-content -->
	</article>