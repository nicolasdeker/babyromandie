<?php
/**
 * Set up the default theme options
 *
 * @since 1.0.0
 */
function bavotasan_theme_options() {
	//delete_option( 'tonic_pro_theme_options' );
	$default_theme_options = array(
		'width' => '',
		'layout' => '2',
		'primary' => 'c8',
		'secondary' => 'c2',
		'tagline' => 'on',
		'display_author' => 'on',
		'display_date' => 'on',
		'display_comment_count' => 'on',
		'display_categories' => 'on',
		'link_color' => '#0088CC',
		'link_hover_color' => '#000000',
		'main_text_color' => '#444444',
		'nav_palette' => 'navbar-inverse',
		'headers_color' => '#333333',
		'excerpt_content' => 'excerpt',
		'read_more' => 'Read more &rarr;',
		'home_widget' =>'on',
		'home_posts' =>'on',
		'extended_footer_columns' => 'c4',
		'logo' => '',
		'copyright' => 'Copyright &copy; ' . date( 'Y' ) . ' <a href="' . home_url() . '">' . get_bloginfo( 'name' ) .'</a>. All Rights Reserved.',
		'main_text_font' => 'PT Sans, sans-serif',
		'headers_font' => 'Lato, sans-serif',
		'site_title_font' => 'Lobster, cursive',
		'site_description_font' => 'Quicksand, sans-serif',
		'post_title_font' => 'Lato, sans-serif',
		'post_meta_font' => 'Lato Light, sans-serif',
		'post_category_font' => 'Lato Light, sans-serif',
		'number_posts' => '1',
		'blog_url' => '',
		'jumbo_headline_title' => 'Jumbo Headline!',
		'jumbo_headline_text' => 'Got something important to say? Then make it stand out by using the jumbo headline option and get your visitor\'s attention right away.',
		'jumbo_headline_button_text' => '',
		'jumbo_headline_button_link' => '',
	);

	return get_option( 'tonic_pro_theme_options', $default_theme_options );
}

class Bavotasan_Customizer {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_sidebar' ) );
	}

	/**
	 * Add a 'customize' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
	    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'customize_theme', 'title' => __( 'Theme Options', 'tonic' ), 'href' => admin_url( 'customize.php' ) ) );
	}

	/**
	 * Add a 'customize' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_theme_page( __( 'Theme Options', 'tonic' ), __( 'Theme Options', 'tonic' ), 'edit_theme_options', 'customize.php', '' );
	}

	/**
	 * Adds theme options to the Customizer screen
	 *
	 * This function is attached to the 'customize_register' action hook.
	 *
	 * @param	class $wp_customize
	 *
	 * @since 1.0.0
	 */
	public function customize_register( $wp_customize ) {
		$bavotasan_theme_options = bavotasan_theme_options();

		$wp_customize->add_setting( 'tonic_pro_theme_options[tagline]', array(
			'default' => $bavotasan_theme_options['tagline'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_tagline', array(
			'label' => __( 'Display Tagline', 'tonic' ),
			'section' => 'title_tagline',
			'settings' => 'tonic_pro_theme_options[tagline]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[logo]', array(
			'default' => $bavotasan_theme_options['logo'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
			'label' => __( 'Site Logo', 'tonic' ),
			'section' => 'title_tagline',
			'settings' => 'tonic_pro_theme_options[logo]',
		) ) );

		// Layout section panel
		$wp_customize->add_section( 'bavotasan_layout', array(
			'title' => __( 'Layout', 'tonic' ),
			'priority' => 35,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[width]', array(
			'default' => $bavotasan_theme_options['width'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_width', array(
			'label' => __( 'Site Width', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[width]',
			'priority' => 10,
			'type' => 'select',
			'choices' => array(
				'' => '1200px',
				'w960' => __( '960px', 'tonic' ),
				'w640' => __( '640px', 'tonic' ),
				'wfull' => __( 'Full Width', 'tonic' ),
			),
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[layout]', array(
			'default' => $bavotasan_theme_options['layout'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_site_layout', array(
			'label' => __( 'Site Layout', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[layout]',
			'priority' => 15,
			'type' => 'radio',
			'choices' => array(
				'1' => __( '1 Sidebar - Left', 'tonic' ),
				'2' => __( '1 Sidebar - Right', 'tonic' ),
				'3' => __( '2 Sidebars - Left', 'tonic' ),
				'4' => __( '2 Sidebars - Right', 'tonic' ),
				'5' => __( '2 Sidebars - Separate', 'tonic' ),
				'6' => __( 'No Sidebars', 'tonic' )
			),
		) );

		$choices =  array(
			'c2' => '17%',
			'c3' => '25%',
			'c4' => '34%',
			'c5' => '42%',
			'c6' => '50%',
			'c7' => '58%',
			'c8' => '66%',
			'c9' => '75%',
			'c10' => '83%',
			'c12' => '100%',
		);

		$wp_customize->add_setting( 'tonic_pro_theme_options[primary]', array(
			'default' => $bavotasan_theme_options['primary'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_primary_column', array(
			'label' => __( 'Main Content', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[primary]',
			'priority' => 20,
			'type' => 'select',
			'choices' => $choices,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[secondary]', array(
			'default' => $bavotasan_theme_options['secondary'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_secondary_column', array(
			'label' => __( 'First Sidebar', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[secondary]',
			'priority' => 25,
			'type' => 'select',
			'choices' => $choices,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[jumbo_headline_title]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_title'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_title', array(
			'label' => __( 'Jumbo Headline Title', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[jumbo_headline_title]',
			'priority' => 26,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[jumbo_headline_text]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_text'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_text', array(
			'label' => __( 'Jumbo Headline Text', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[jumbo_headline_text]',
			'priority' => 27,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[jumbo_headline_button_text]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_button_text'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_button_text', array(
			'label' => __( 'Jumbo Headline Button Text', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[jumbo_headline_button_text]',
			'priority' => 28,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[jumbo_headline_button_link]', array(
			'default' => $bavotasan_theme_options['jumbo_headline_button_link'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_jumbo_headline_button_link', array(
			'label' => __( 'Jumbo Headline Button Link', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[jumbo_headline_button_link]',
			'priority' => 29,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[excerpt_content]', array(
			'default' => $bavotasan_theme_options['excerpt_content'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_excerpt_content', array(
			'label' => __( 'Post Content Display', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[excerpt_content]',
			'priority' => 30,
			'type' => 'radio',
			'choices' => array(
				'excerpt' => __( 'Teaser Excerpt', 'tonic' ),
				'content' => __( 'Full Content', 'tonic' ),
			),
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[read_more]', array(
			'default' => $bavotasan_theme_options['read_more'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_read_more', array(
			'label' => __( '"Read More" Text', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[read_more]',
			'priority' => 33,
			'type' => 'text',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[home_widget]', array(
			'default' => $bavotasan_theme_options['home_widget'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_home_widget', array(
			'label' => __( 'Display Home Page Top Widget Area', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[home_widget]',
			'priority' => 35,
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[home_posts]', array(
			'default' => $bavotasan_theme_options['home_posts'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_home_posts', array(
			'label' => __( 'Display Home Page Posts &amp; Sidebar', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[home_posts]',
			'priority' => 40,
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[number_posts]', array(
			'default' => $bavotasan_theme_options['number_posts'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_number_posts', array(
			'label' => __( 'Number of Posts on Home Page', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[number_posts]',
			'priority' => 45,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[blog_url]', array(
			'default' => $bavotasan_theme_options['blog_url'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_blog_url', array(
			'label' => __( 'Blog Page Template URL', 'tonic' ),
			'section' => 'bavotasan_layout',
			'settings' => 'tonic_pro_theme_options[blog_url]',
			'priority' => 55,
		) );

		// Fonts panel
		$mixed_fonts = array_merge( bavotasan_websafe_fonts() , bavotasan_google_fonts() );
		asort( $mixed_fonts );

		$wp_customize->add_section( 'bavotasan_fonts', array(
			'title' => __( 'Fonts', 'tonic' ),
			'priority' => 40,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[main_text_font]', array(
			'default' => $bavotasan_theme_options['main_text_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_main_text_font', array(
			'label' => __( 'Main Text', 'tonic' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'tonic_pro_theme_options[main_text_font]',
			'priority' => 10,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[headers_font]', array(
			'default' => $bavotasan_theme_options['headers_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_headers_font', array(
			'label' => __( 'Headers (h1, h2, h3, etc...)', 'tonic' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'tonic_pro_theme_options[headers_font]',
			'priority' => 15,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[site_title_font]', array(
			'default' => $bavotasan_theme_options['site_title_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_site_title_font', array(
			'label' => __( 'Site Title', 'tonic' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'tonic_pro_theme_options[site_title_font]',
			'priority' => 20,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[site_description_font]', array(
			'default' => $bavotasan_theme_options['site_description_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_site_description_font', array(
			'label' => __( 'Site Description', 'tonic' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'tonic_pro_theme_options[site_description_font]',
			'priority' => 25,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[post_title_font]', array(
			'default' => $bavotasan_theme_options['post_title_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_post_title_font', array(
			'label' => __( 'Post Title', 'tonic' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'tonic_pro_theme_options[post_title_font]',
			'priority' => 30,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[post_meta_font]', array(
			'default' => $bavotasan_theme_options['post_meta_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_meta_font', array(
			'label' => __( 'Post Meta', 'tonic' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'tonic_pro_theme_options[post_meta_font]',
			'priority' => 35,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[post_category_font]', array(
			'default' => $bavotasan_theme_options['post_category_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_post_category_font', array(
			'label' => __( 'Post Category', 'tonic' ),
			'section' => 'bavotasan_fonts',
			'settings' => 'tonic_pro_theme_options[post_category_font]',
			'priority' => 40,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		// Color panel
		$wp_customize->add_setting( 'tonic_pro_theme_options[headers_color]', array(
			'default' => $bavotasan_theme_options['headers_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headers_color', array(
			'label' => __( 'Headers (h1, h2, h3, etc...)', 'tonic' ),
			'section'  => 'colors',
			'settings' => 'tonic_pro_theme_options[headers_color]',
			'priority' => 20,
		) ) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[main_text_color]', array(
			'default' => $bavotasan_theme_options['main_text_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_text_color', array(
			'label' => __( 'Main Text Color', 'tonic' ),
			'section'  => 'colors',
			'settings' => 'tonic_pro_theme_options[main_text_color]',
			'priority' => 25,
		) ) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[link_color]', array(
			'default' => $bavotasan_theme_options['link_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
			'label' => __( 'Link Color', 'tonic' ),
			'section'  => 'colors',
			'settings' => 'tonic_pro_theme_options[link_color]',
			'priority' => 50,
		) ) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[link_hover_color]', array(
			'default' => $bavotasan_theme_options['link_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_hover_color', array(
			'label' => __( 'Link Hover Color', 'tonic' ),
			'section'  => 'colors',
			'settings' => 'tonic_pro_theme_options[link_hover_color]',
			'priority' => 55,
		) ) );

		// Nav panel
			$wp_customize->add_setting( 'tonic_pro_theme_options[nav_palette]', array(
			'default' => $bavotasan_theme_options['nav_palette'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_nav_palette', array(
			'label' => __( 'Nav Color', 'tonic' ),
			'section' => 'nav',
			'settings' => 'tonic_pro_theme_options[nav_palette]',
			'priority' => 40,
			'type' => 'select',
			'choices' => array(
				'' => __( 'Light', 'tonic' ),
				'navbar-inverse' => __( 'Dark', 'tonic' ),
			),
		) );

		// Posts panel
		$wp_customize->add_section( 'bavotasan_posts', array(
			'title' => __( 'Posts', 'tonic' ),
			'priority' => 45,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[display_categories]', array(
			'default' => $bavotasan_theme_options['display_categories'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_display_categories', array(
			'label' => __( 'Display Categories', 'tonic' ),
			'section' => 'bavotasan_posts',
			'settings' => 'tonic_pro_theme_options[display_categories]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[display_author]', array(
			'default' => $bavotasan_theme_options['display_author'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_display_author', array(
			'label' => __( 'Display Author', 'tonic' ),
			'section' => 'bavotasan_posts',
			'settings' => 'tonic_pro_theme_options[display_author]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[display_date]', array(
			'default' => $bavotasan_theme_options['display_date'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_display_date', array(
			'label' => __( 'Display Date', 'tonic' ),
			'section' => 'bavotasan_posts',
			'settings' => 'tonic_pro_theme_options[display_date]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[display_comment_count]', array(
			'default' => $bavotasan_theme_options['display_comment_count'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_display_comment_count', array(
			'label' => __( 'Display Comment Count', 'tonic' ),
			'section' => 'bavotasan_posts',
			'settings' => 'tonic_pro_theme_options[display_comment_count]',
			'type' => 'checkbox',
		) );

		// Footer panel
		$wp_customize->add_section( 'bavotasan_footer', array(
			'title' => __( 'Footer', 'tonic' ),
			'priority' => 50,
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[extended_footer_columns]', array(
			'default' => $bavotasan_theme_options['extended_footer_columns'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
		) );

		$wp_customize->add_control( 'bavotasan_extended_footer_columns', array(
			'label' => __( 'Extended Footer Columns', 'tonic' ),
			'section' => 'bavotasan_footer',
			'settings' => 'tonic_pro_theme_options[extended_footer_columns]',
			'priority' => 10,
			'type' => 'select',
			'choices' => array(
				'c12' => __( '1 Column', 'tonic' ),
				'c6' => __( '2 Columns', 'tonic' ),
				'c4' => __( '3 Columns', 'tonic' ),
				'c3' => __( '4 Columns', 'tonic' ),
				'c2' => __( '6 Columns', 'tonic' ),
			),
		) );

		$wp_customize->add_setting( 'tonic_pro_theme_options[copyright]', array(
			'default' => $bavotasan_theme_options['copyright'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'bavotasan_copyright', array(
			'label' => __( 'Copyright Notice', 'tonic' ),
			'section' => 'bavotasan_footer',
			'settings' => 'tonic_pro_theme_options[copyright]',
			'priority' => 20,
		) );

		if ( $wp_customize->is_preview() && ! is_admin() )
			add_action( 'wp_footer', array( $this, 'wp_footer' ), 21);
	}

	/**
	 * jQuery for Customizer screen
	 *
	 * @since 1.0.0
	 */
	public function wp_footer() {
		?>
<script>
( function($){
	wp.customize( 'tonic_pro_theme_options[extended_footer_columns]', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widget' ).removeClass( 'c2 c3 c4 c6 c12' ).addClass( to );
		} );
	} );
} )(jQuery)
</script>
		<?php
	}

	/**
	 * jQuery for Customizer screen
	 *
	 * This function is attached to the 'customize_controls_print_footer_scripts' action hook.
	 *
	 * @since Gridiculous Pro 1.0.0
	 */
	public function customize_sidebar() {
		?>
<script>
( function($){
	var start_value = $( 'input[name="_customize-radio-bavotasan_site_layout"]:checked' ).val();
	show_controls( start_value );
	$( 'input[name="_customize-radio-bavotasan_site_layout"]' ).change(function() {
		var value = $( 'input[name="_customize-radio-bavotasan_site_layout"]:checked' ).val();
		show_controls( value );
	});
	function show_controls( value ) {
		if ( 1 == value || 2 == value || 6 == value )
			$( '#customize-control-bavotasan_secondary_column' ).hide();
		else
			$( '#customize-control-bavotasan_secondary_column' ).show();
	}
} )(jQuery);
</script>
		<?php
	}
}
$bavotasan_customizer = new Bavotasan_Customizer;

/**
 * Prepare font CSS
 *
 * @param	string $font  The select font
 *
 * @since 1.0.0
 */
function bavotasan_prepare_font( $font ) {
	$font_family = ( 'Lato Light, sans-serif' == $font ) ? 'Lato' : $font;
	$font_family = ( 'Arvo Bold, serif' == $font ) ? 'Arvo' : $font_family;
	$font_weight = ( 'Lato Light, sans-serif' == $font ) ? ' font-weight: 300' : 'font-weight: normal';
	$font_weight = ( 'Lato, sans-serif' == $font ) ? ' font-weight: 400' : $font_weight;
	$font_weight = ( 'Lato Bold, sans-serif' == $font || 'Arvo Bold, serif' == $font ) ? ' font-weight: 900' : $font_weight;

	return 'font-family: ' . $font_family . '; ' . $font_weight;
}

if ( ! function_exists( 'bavotasan_websafe_fonts' ) ) :
/**
 * Array of websafe fonts
 *
 * @return	Array of fonts
 *
 * @since 1.0.0
 */
function bavotasan_websafe_fonts() {
    return array(
        'Arial, sans-serif' => 'Arial',
        '"Avant Garde", sans-serif' => 'Avant Garde',
        'Cambria, Georgia, serif' => 'Cambria',
        'Copse, sans-serif' => 'Copse',
        'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
        'Georgia, serif' => 'Georgia',
        '"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
        'Tahoma, Geneva, sans-serif' => 'Tahoma'
    );
}
endif;

if ( ! function_exists( 'bavotasan_google_fonts' ) ) :
/**
 * Array of Google Fonts
 *
 * @return	Array of fonts
 *
 * @since 1.0.0
 */
function bavotasan_google_fonts() {
    return array(
        'Arvo, serif' => 'Arvo *',
        'Arvo Bold, serif' => 'Arvo Bold *',
        'Copse, sans-serif' => 'Copse *',
        'Droid Sans, sans-serif' => 'Droid Sans *',
        'Droid Serif, serif' => 'Droid Serif *',
        'Exo, sans-serif' => 'Exo *',
        'Lato Light, sans-serif' => 'Lato Light *',
        'Lato, sans-serif' => 'Lato *',
        'Lato Bold, sans-serif' => 'Lato Bold *',
        'Lobster, cursive' => 'Lobster *',
        'Nobile, sans-serif' => 'Nobile *',
        'Open Sans, sans-serif' => 'Open Sans *',
        'Oswald, sans-serif' => 'Oswald *',
        'Pacifico, cursive' => 'Pacifico *',
        'Raleway, cursive' => 'Raleway *',
        'Rokkitt, serif' => 'Rokkit *',
        'Russo One, sans-serif' => 'Russo One *',
        'PT Sans, sans-serif' => 'PT Sans *',
        'Quicksand, sans-serif' => 'Quicksand *',
        'Quattrocento, serif' => 'Quattrocento *',
        'Ubuntu, sans-serif' => 'Ubuntu *',
        'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz *'
    );
}
endif;