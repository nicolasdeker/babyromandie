<?php
class Bavotasan_Slider {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        add_action( 'wp_ajax_search_content', array( $this, 'search_content' ) );
        add_action( 'wp_ajax_add_delete_slide', array( $this, 'add_delete_slide' ) );
        add_action( 'wp_ajax_edit_slide', array( $this, 'edit_slide' ) );

		add_action( 'wp_ajax_slide_order', array( $this, 'slide_order' ) );

		// Setup default slides
        if ( ! get_option( 'tonic_slider' ) )
            add_option( 'tonic_slider', $this->default_slider_slides() );

       if ( ! get_option( 'tonic_slider_settings' ) )
            add_option( 'tonic_slider_settings', $this->default_settings() );
	}

	/**
	 * Add a 'Slider' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() ) {
	    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'slider', 'title' => __( 'Slider', 'tonic' ), 'href' => admin_url( 'themes.php?page=slider_page' ) ) );
	    }
	}

	/**
	 * Add a 'customize' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_theme_page( __( 'Home Page Slider', 'tonic' ), __( 'Slider', 'tonic' ), 'edit_theme_options', 'slider_page', array( $this, 'slider_page' ) );
	}

	/**
	 * Add JS file for admin slider page.
	 *
	 * This function is attached to the 'admin_enqueue_scripts' action hook.
	 *
	 * @param	$hook  The page template file for the current page
	 *
	 * @uses	wp_enqueue_script()
	 * @uses	BAVOTASAN_THEME_URL
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts( $hook ) {
		if ( 'appearance_page_slider_page' == $hook  ) {
		    wp_enqueue_script( 'slider_options_js', BAVOTASAN_THEME_URL . '/library/js/slider-admin.js', array( 'jquery', 'jquery-ui-sortable' ), '', true );
			wp_enqueue_style( 'slider_options_css', BAVOTASAN_THEME_URL . '/library/css/slider-admin.css', false, null, 'all' );
			wp_enqueue_style( 'font_awesome', 'http://netdna.bootstrapcdn.com/font-awesome/3.0/css/font-awesome.css', false, null, 'all' );
			wp_enqueue_media();
		}
	}

	/**
	 * Registering the settings for the Custom CSS editor
	 *
	 * This function is attached to the 'admin_init' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_init() {
		register_setting( 'tonic_slider', 'tonic_slider' );
		register_setting( 'tonic_slider_settings', 'tonic_slider_settings',  array( $this, 'bavotasan_slider_settings_validation' ) );

		add_settings_section( 'default', 'Default Settings', '__return_false', 'tonic_slider_settings' );
		add_settings_field( 'bavotasan_slider_settings_display', __( 'Display', 'tonic' ), array( $this, 'input_checkbox' ), 'tonic_slider_settings', 'default', array( 'key' => 'display' ) );
		add_settings_field( 'bavotasan_slider_settings_autoplay', __( 'Autoplay', 'tonic' ), array( $this, 'input_checkbox' ), 'tonic_slider_settings', 'default', array( 'key' => 'autoplay' ) );
		add_settings_field( 'bavotasan_slider_settings_interval', __( 'Interval', 'tonic' ), array( $this, 'input_regular' ), 'tonic_slider_settings', 'default', array( 'key' => 'interval', 'hint' => __( 'Time in milliseconds before the slides switch if Autoplay is checked.', 'tonic' ) ) );
	}

	/**
	 * Input field
	 *
	 * @since 1.0.0
	 */
	public function input_regular( $atts ) {
		$options = get_option( 'tonic_slider_settings' );
		$value = $options[$atts['key']];
		echo '<input value="' . $value . '" name="tonic_slider_settings[' . $atts['key'] . ']" type="type" />';
		if ( ! empty( $atts['hint'] ) ) echo '<p class="description">' . $atts['hint'] . '</p>';
	}

	/**
	 * Checkbox input
	 *
	 * @since 1.0.0
	 */
	public function input_checkbox( $atts ) {
		$options = get_option( 'tonic_slider_settings' );
		$value = $options[$atts['key']];
		echo '<input ' . checked( $value, true, false ) . ' value="1" name="tonic_slider_settings[' . $atts['key'] . ']" type="checkbox" />';
	}

	/**
	 * Default settings
	 *
	 * @since 1.0.0
	 */
	public function default_settings( $name = null ) {
		$default = array(
			'display' => '1',
			'autoplay' => '0',
			'interval' => '7500',
		);

		return ( $name ) ? $default[$name] : $default;
	}

	/**
	 * Slider page
	 *
	 * @since 1.0.0
	 */
	public function slider_page() {
		$slider_items = get_option( 'tonic_slider' );
		$count = ( empty( $slider_items ) ) ? 0 : count( $slider_items );
		?>
		<div class="wrap" id="slider-options">
			<?php screen_icon(); ?>
			<h2><?php echo get_admin_page_title(); ?></h2>
			<?php settings_errors(); ?>

			<form action="options.php" method="post">
				<?php settings_fields( 'tonic_slider_settings' ); ?>
				<?php do_settings_sections( 'tonic_slider_settings' ); ?>
				<?php submit_button(); ?>
			</form>

			<h3><?php _e( 'Add Post/Page to Slider', 'tonic' ); ?></h3>
			<form id="slider-form" method="post" action="" data-count="<?php echo $count; ?>">
				<?php wp_nonce_field( 'slider_nonce', 'slider_nonce' ); ?>
				<?php _e( 'Search by content:', 'tonic' ); ?>
				<input type="text" id="content_search" name="content_search" placeholder="<?php _e( 'Start typing...', 'tonic' ); ?>">
				<p id="content_search_results"></p>
				<?php submit_button( __( 'Add to Slider', 'tonic' ), 'submit', 'add_to_slider', '', array( 'disabled' => 'disabled' ) ); ?>
			</form>

			<p>&nbsp;</p>

			<h3 class="spinner-header"><?php _e( 'Current Slider Items', 'tonic' ); ?><span id="slider-spinner" class="spinner"></span></h3>
			<div id="admin-slides">
				<?php
				//delete_option( 'tonic_slider' );
				if ( ! empty( $slider_items ) ) {
					$count = 0;
					foreach( $slider_items as $slide ) {
						echo $this->format_slide( $slide, $count );
						$count++;
					}
				}
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Properly format each slide for display
	 *
	 * @since 1.0.0
	 */
	public function format_slide( $slide, $count ) {
		$return = '
		<div id="slide_' . $count . '" class="slide">
			<div class="icon"><i class="icon-move"></i></div>
			<div class="text">
				<p><strong>' . __( 'Title:', 'tonic' ) . '</strong><span class="item item-title">'. stripslashes( $slide['title'] ). '</span></p>
				<p><strong>' . __( 'Text:', 'tonic' ) . '</strong><span class="item item-excerpt">'. stripslashes(  $slide['excerpt'] ) . '</span></p>
				<p><strong>' . __( 'Link:', 'tonic' ) . '</strong><span class="item item-link">'. esc_url( $slide['link'] ) . '</span></p>
				<p><strong>' . __( 'Button:', 'tonic' ) . '</strong><span class="item item-button">'. stripslashes( $slide['button'] ) . '</span></p>

			</div>
			<div class="options"><a href="#" class="edit-slide" data-slide="' . $count . '">' . __( 'Edit', 'tonic' ) . '</a> | <a href="#" class="delete-slide" data-slide="' . $count . '">X</a></div>
		</div>';

		return $return;
	}

	/**
	 * The slider settings validation
	 *
	 * @since 1.0.0
	 */
	public function bavotasan_slider_settings_validation( $input ) {
		$input['display'] = ( empty( $input['display'] ) ) ? '' : (bool) $input['display'];
		$input['autoplay'] = ( empty( $input['autoplay'] ) ) ? '' : (bool) $input['autoplay'];
		$input['interval'] = ( empty( $input['interval'] ) ) ? '7500' : (int) $input['interval'];
		return $input;
	}

    /**
     * Search helper to return matched posts/pages
     *
     * @since 1.0.0
     */
    function search_content() {
        if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'slider_nonce' ) )
            return;

        $search_query = new WP_Query( array(
            'posts_per_page' => 5,
            'post_type' => array( 'post', 'page' ),
            's' => $_POST['query'],
            'fields' => array( 'id', 'post_title' ),
            'no_found_rows' => true
        ) );

        $data = '<em>' . __( 'Nothing found', 'tonic' ) . '</em>';
        $success = false;

        if ( $search_query->have_posts() ) {
        	$data = '<select name="search-results" id="search-results" style="height: auto; padding: 6px;" size="' . ( $search_query->post_count + 1 ) . '">';
            foreach ( $search_query->get_posts() as $recent ) {
            	$data .= '<option data-post_id="' . $recent->ID . '" value="' . $recent->ID . '">' . $recent->post_title . '</option>';
            }
            $data .= '</select>';
            $success = true;
        }

        echo json_encode( array(
        	'success' => $success,
        	'data' => $data
        ) );
        die();
    }

    /**
     * Adds a slide to a slider
     *
     * @since 1.0.0
     */
    public function add_delete_slide() {
        if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'slider_nonce' ) )
            return;

		$success = false;
		$data = __( 'There was an error. Please try again.', 'tonic' );

        $sliders = get_option( 'tonic_slider' , array() );

        if ( isset( $_POST['post_id'] ) ) {
	        $post_id = ( $_POST['post_id'] );
	        if ( 'add' == $_POST['a_or_d'] ) {
	        	$the_post = get_post( $post_id );
	            $new_slide = array( );
	            $new_slide['title'] = get_the_title( $post_id );
   				$excerpt = ( $the_post->post_excerpt ) ? $the_post->post_excerpt : $the_post->post_content;
	            $new_slide['excerpt'] = wp_trim_words( apply_filters( 'the_content', strip_shortcodes( $excerpt ) ), 30 );
	            $new_slide['button'] = 'Learn More';
	            $new_slide['link'] = get_permalink( $post_id );

	            $sliders[] = $new_slide;

				$data = $this->format_slide( $new_slide, $_POST['count'] );
			} else {
	            array_splice( $sliders, $post_id, 1 );
	            $data = '';
			}

            $success = true;
	        update_option( 'tonic_slider', $sliders );
	    }
        echo json_encode( array(
        	'success' => $success,
        	'data' => $data
        ) );

        die();
    }

    /**
     * Edit slide
     *
     * @since 1.0.0
     */
    public function edit_slide() {
        if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'slider_nonce' ) )
            return;

		$success = false;
		$data = __( 'There was an error. Please try again.', 'tonic' );

        $sliders = get_option( 'tonic_slider' , array() );

        if ( isset( $_POST['slide_id'] ) ) {
            $slide_id = $_POST['slide_id'];
            $sliders[$slide_id]['title'] = sanitize_text_field( $_POST['new_title'] );
            $sliders[$slide_id]['excerpt'] = sanitize_text_field( $_POST['new_excerpt'] );
            $sliders[$slide_id]['button'] = sanitize_text_field( $_POST['new_button'] );
            $sliders[$slide_id]['link'] = esc_url( $_POST['new_link'] );

			$data = $this->format_slide( $sliders[$slide_id], $slide_id );

            $success = true;
	        update_option( 'tonic_slider', $sliders );
	    }
        echo json_encode( array(
        	'success' => $success,
        	'data' => $data
        ) );

        die();
    }

	/**
	 * Reorder slides
	 *
	 * @since 1.0.0
	 */
	public function slide_order() {
		if ( ! empty( $_POST['nonce'] ) && ! wp_verify_nonce( $_POST['nonce'], 'slider_nonce' ) )
			return;

		if ( isset( $_POST['slide_order'] ) ) {
			$new_slide_array = array();
			$sliders = get_option( 'tonic_slider' );
			foreach ( $_POST['slide_order'] as $order ) {
				$order = str_replace( 'slide_', '', $order );
				$new_slide_array[] = $sliders[$order];
			}
			update_option( 'tonic_slider', $new_slide_array );
		}
		die();
	}

	/**
	 * Default slider slides
	 *
	 * @since 1.0.0
	 */
	public function default_slider_slides() {
		$slides = array(
			array(
				'title' => 'Example headline',
				'excerpt' => 'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Sed posuere consectetur est at lobortis. Sed posuere consectetur est at lobortis.',
				'link' => '#',
				'button' => 'Sign Up Today'
			),
			array(
				'title' => 'Another example headline',
				'excerpt' => 'Nulla vitae elit libero, a pharetra augue. Donec ullamcorper nulla non metus auctor fringilla. Etiam porta sem malesuada magna mollis euismod. Maecenas sed diam eget risus varius blandit.',
				'link' => '#',
				'button' => 'Learn More'
			),
			array(
				'title' => 'One more for good measure',
				'excerpt' => 'Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula.',
				'link' => '#',
				'button' => 'Check It Out'
			),
		);

		return $slides;
	}

	/**
	 * Display the slider
	 *
	 * @since 1.0.0
	 */
	public function display_slider() {
		$bavotasan_theme_options = bavotasan_theme_options();
		//delete_option( 'tonic_slider' );
		$slider_options = get_option( 'tonic_slider_settings' );
		$slider_items = get_option( 'tonic_slider' );
		$count = 1;
		if ( ! empty( $slider_items ) ) {
			$autoplay = ( $slider_options['autoplay'] ) ? 'hover' : 'false';
			?>
		<div id="myCarousel" class="c12 carousel slide" data-interval="<?php echo $slider_options['interval']; ?>" data-pause="<?php echo $autoplay; ?>">
			<div class="carousel-inner">
			<?php
			foreach( $slider_items as $slide ) {
				$active = ( 1 == $count ) ? ' active' : '';
				?>
				<div class="item<?php echo $active; ?>">
					<div class="container">
						<div class="carousel-caption grid <?php echo $bavotasan_theme_options['width']; ?>">
							<h1><a href="<?php echo esc_url( $slide['link'] ); ?>"><?php echo stripslashes( $slide['title'] ); ?></a></h1>
							<p class="lead"><?php echo stripslashes( $slide['excerpt'] ); ?></p>
							<a class="btn btn-large btn-primary" href="<?php echo esc_url( $slide['link'] ); ?>"><?php echo stripslashes( $slide['button'] ); ?></a>
						</div>
					</div>
				</div>
				<?php
				$count++;
			}
			?>
			</div>
			<a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="icon-chevron-left"></i></a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="icon-chevron-right"></i></a>
		</div>
			<?php
		}
	}
}
$bavotasan_slider = new Bavotasan_Slider;