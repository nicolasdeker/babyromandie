<?php
/**
 * Template Name: Search Page Template
 *
 * Description: A page template that will display your latest posts
 *
 * @since 1.0.0
 */

get_header(); ?>

	<div id="primary" <?php bavotasan_primary_attr(); ?>>
		<?php
			global $query_string;

			$query_args = explode("&", $query_string);
			$search_query = array();

			foreach($query_args as $key => $string) {
				$query_split = explode("=", $string);
				$search_query[$query_split[0]] = urldecode($query_split[1]);
			} // foreach

			$search = new WP_Query($search_query);
		?>
		<?php get_search_form(); ?>
		<?php
			global $wp_query;
			$total_results = $wp_query->found_posts;
		?>

	</div><!-- #primary.c8 -->

<?php get_footer(); ?>