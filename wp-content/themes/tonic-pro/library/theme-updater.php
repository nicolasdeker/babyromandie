<?php
class Bavotasan_Theme_Updater {
	public function __construct() {
		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'theme_updater' ) );
	}

	/**
	 * Functionality to hook in the WordPress theme updater.
	 *
	 * This function is attached to the 'pre_set_site_transient_update_themes' filter hook.
	 *
	 * @since 1.0.0
	 */
	public function theme_updater( $checked_data ) {
		global $wp_version;

		$blog_url = home_url();
		$request = array(
			'slug' => BAVOTASAN_THEME_FILE,
			'code' => BAVOTASAN_THEME_CODE,
			'version' => BAVOTASAN_THEME_VERSION
		);

		$send_for_check = array(
			'body' => array(
				'action' => 'theme_update',
				'request' => serialize( $request ),
				'api-key' => md5( $blog_url )
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . $blog_url
		);

		$raw_response = wp_remote_post( 'https://themes.bavotasan.com/updater.php', $send_for_check );
		if ( ! is_wp_error( $raw_response ) && ( $raw_response['response']['code'] == 200 ) )
			$response = unserialize( $raw_response['body'] );

		if ( ! empty( $response ) )
			$checked_data->response[BAVOTASAN_THEME_FILE] = $response;

		return $checked_data;
	}
}
$bavotasan_theme_updater = new Bavotasan_Theme_Updater;

if ( is_admin() )
	$current = get_transient( 'update_themes' );