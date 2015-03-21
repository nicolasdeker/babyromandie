<?php
class Bavotasan_Pointers {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Setting up the pointers array
	 *
	 * @since 1.0.0
	 *
	 * @return	array
	 */
	public function pointers() {
		$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
		$prefix = BAVOTASAN_THEME_CODE . str_replace( '.', '', BAVOTASAN_THEME_VERSION ) . '_';

		$custom_css_pointer_content = '<h3>' . __( 'Custom CSS Editor', 'tonic' ) . '</h3>';
		$custom_css_pointer_content .= '<p>' . sprintf( __( 'Take %s to the next level of customization with the Custom CSS Editor. Style your site without having to worry about loosing your changes when you update.', 'tonic'), '<strong>' . BAVOTASAN_THEME_NAME . '</strong>' ) . '</p>';

		$bavotasan_theme_options_pointer_content = '<h3>' . __( 'Theme Options', 'tonic' ) . '</h3>';
		$bavotasan_theme_options_pointer_content .= '<p>' . sprintf( __( 'The greatest thing about %s is all of its amazing theme options. Take total control over the look and design of your site with a few clicks.', 'tonic'), '<strong>' . BAVOTASAN_THEME_NAME . '</strong>' ) . '</p>';

		$layout_options_pointer_content = '<h3>' . __( 'Full Width Option', 'tonic' ) . '</h3>';
		$layout_options_pointer_content .= '<p>' . __( 'If you want this post/page to expand the full width of your site, check the box above and the sidebar(s) will be removed.', 'tonic') . '</p>';

		return array(
			$prefix . 'custom_css' => array(
				'content' => $custom_css_pointer_content,
				'anchor_id' => '#menu-appearance',
				'edge' => 'left',
				'align' => 'center',
				'active' => ( ! in_array( $prefix . 'custom_css', $dismissed ) )
			),
			$prefix . 'theme_options' => array(
				'content' => $bavotasan_theme_options_pointer_content,
				'anchor_id' => '#wp-admin-bar-bavotasan_toolbar',
				'edge' => 'top',
				'align' => 'left',
				'active' => ( ! in_array( $prefix . 'theme_options', $dismissed ) )
			),
			$prefix . 'layout_options' => array(
				'content' => $layout_options_pointer_content,
				'anchor_id' => '#layout-options',
				'edge' => 'top',
				'align' => 'right',
				'active' => ( ! in_array( $prefix . 'layout_options', $dismissed ) )
			),
		);
	}

	/**
	 * Pointers conditional check
	 *
	 * @since 1.0.0
	 *
	 * @return	boolean
	 */
	public function pointers_check() {
		$pointers = $this->pointers();
		foreach ( $pointers as $pointer => $array ) {
			if ( $array['active'] )
				return true;
		}
	}

	/**
	 * Add tooltip pointers to show off certain elements in the admin
	 *
	 * This function is attached to the 'admin_enqueue_scripts' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {
		if ( $this->pointers_check() ) {
			add_action( 'admin_print_footer_scripts', array( $this, 'admin_print_footer_scripts' ) );

			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_style( 'wp-pointer' );
		}
	}

	/**
	 * Add tooltip pointer script to admin footer
	 *
	 * This function is attached to the 'admin_print_footer_scripts' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_print_footer_scripts() {
		$pointers = $this->pointers();
		?>
<script>
/* <![CDATA[ */
( function($) {
	<?php
	foreach ( $pointers as $pointer => $array ) {
		if ( $array['active'] ) {
			?>
		    $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
		        content: '<?php echo $array['content']; ?>',
		        position: {
		            edge: '<?php echo $array['edge']; ?>',
		            align: '<?php echo $array['align']; ?>'
		        },
		        close: function() {
		            $.post( ajaxurl, {
		                pointer: '<?php echo $pointer; ?>',
		                action: 'dismiss-wp-pointer'
		            } );
		        }
		    } ).pointer( 'open' );
	    	<?php
	    }
	}
	?>
} )(jQuery);
/* ]]> */
</script>
		<?php
	}
}
$bavotasan_pointers = new Bavotasan_Pointers;