<?php
class Bavotasan_Custom_Metaboxes {
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	/**
	 * Add option for full width posts & pages
	 *
	 * This function is attached to the 'add_meta_boxes' action hook.
	 *
	 * @since 1.0.0
	 */
	public function add_meta_boxes() {
		add_meta_box( 'layout-options', __( 'Layout', 'tonic' ), array( $this, 'layout_option' ), 'post', 'side', 'high' );
		add_meta_box( 'layout-options', __( 'Layout', 'tonic' ), array( $this, 'layout_option' ), 'page', 'side', 'high' );
	}

	public function layout_option( $post ) {
		$layout = get_post_meta( $post->ID, 'bavotasan_single_layout', true );

		// Use nonce for verification
		wp_nonce_field( 'bavotasan_nonce', 'bavotasan_nonce' );

		echo '<input id="bavotasan_single_layout" name="bavotasan_single_layout" type="checkbox" ' . checked( $layout, 'on', false ) . ' /> <label for="bavotasan_single_layout">' . __( 'Display at full width', 'tonic' ) . '</label>';
	}

	/**
	 * Save post custom fields
	 *
	 * This function is attached to the 'save_post' action hook.
	 *
	 * @since 1.0.0
	 */
	public function save_post( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( ! empty( $_POST['bavotasan_nonce'] ) && ! wp_verify_nonce( $_POST['bavotasan_nonce'], 'bavotasan_nonce' ) )
			return;

		if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		}

		$layout = ( empty( $_POST['bavotasan_single_layout'] ) ) ? '' : $_POST['bavotasan_single_layout'];
		if ( $layout )
			update_post_meta( $post_id, 'bavotasan_single_layout', $layout );
		else
			delete_post_meta( $post_id, 'bavotasan_single_layout' );
	}
}
$bavotasan_custom_metaboxes = new Bavotasan_Custom_Metaboxes;