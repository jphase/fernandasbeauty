<?php
//
// Uncomment one of the following two. Their functions are in panel/generic.php
//
add_action('wp_enqueue_scripts', 'ci_enqueue_modernizr');
//add_action('wp_enqueue_scripts', 'ci_print_html5shim');

// This function lives in panel/generic.php
// add_action('wp_footer', 'ci_print_selectivizr', 100);


add_action( 'init', 'ci_register_theme_scripts' );
if ( ! function_exists( 'ci_register_theme_scripts' ) ) :
function ci_register_theme_scripts() {
	//
	// Register all scripts here, both front-end and admin.
	// There is no need to register them conditionally, as the enqueueing can be conditional.
	//

	wp_register_script( 'jquery-superfish', get_child_or_parent_file_uri( '/js/superfish.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-flexslider', get_child_or_parent_file_uri( '/js/jquery.flexslider.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-magnific-popup', get_child_or_parent_file_uri( '/js/jquery.magnific-popup.js' ), array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'jquery-isotope', get_child_or_parent_file_uri( '/js/jquery.isotope.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-mmenu', get_child_or_parent_file_uri( '/js/jquery.mmenu.min.all.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-matchHeight', get_child_or_parent_file_uri( '/js/jquery.matchHeight-min.js' ), array( 'jquery' ), false, true );
	wp_register_script( 'jquery-parallax', get_child_or_parent_file_uri( '/js/jquery.parallax-1.1.3.js' ), array( 'jquery' ), '1.1.3', true );
	wp_register_script( 'stapel', get_child_or_parent_file_uri( '/js/jquery.stapel.js' ), array( 'jquery' ), '1.0.0', true );

	wp_register_script( 'jquery-gmaps-latlon-picker', get_child_or_parent_file_uri( '/js/admin/jquery-gmaps-latlon-picker.js' ), array( 'jquery', 'google-maps' ), CI_THEME_VERSION, true );
	wp_register_script( 'ci-post-edit-scripts', get_child_or_parent_file_uri( '/js/admin/post-edit-scripts.js' ), array( 'jquery' ), CI_THEME_VERSION, true );
	wp_register_script( 'ci-admin-widgets', get_child_or_parent_file_uri( '/js/admin/admin-widgets.js' ), array( 'jquery' ), CI_THEME_VERSION, true );

	wp_register_script( 'ci-front-scripts', get_child_or_parent_file_uri( '/js/scripts.js' ), array(
		'jquery',
		'jquery-superfish',
		'jquery-mmenu',
		'jquery-flexslider',
		'jquery-matchHeight',
		'jquery-fitVids',
		'jquery-magnific-popup',
		'jquery-isotope',
		'jquery-parallax',
		'stapel'
	), CI_THEME_VERSION, true );
}
endif;

add_action( 'wp_enqueue_scripts', 'ci_enqueue_theme_scripts' );
if ( ! function_exists( 'ci_enqueue_theme_scripts' ) ) :
function ci_enqueue_theme_scripts() {
	//
	// Enqueue all (or most) front-end scripts here.
	// They can be also enqueued from within template files.
	//
	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );

	if ( wp_script_is( 'prettyPhoto', 'enqueued' ) ) {
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
	}

	wp_enqueue_script( 'ci-front-scripts' );

	$params['theme_url'] = get_template_directory_uri();
	$params['slider_auto'] = ( ci_setting( 'slider_auto' ) == 'enabled' ? true : false );


	$params['slider_autoslide'] = ci_setting( 'slider_autoslide' ) == 'enabled' ? true : false;
	$params['slider_effect']    = ci_setting( 'slider_effect' );
	$params['slider_direction'] = ci_setting( 'slider_direction' );
	$params['slider_duration']  = (string) ci_setting( 'slider_duration' );
	$params['slider_speed']     = (string) ci_setting( 'slider_speed' );
	wp_localize_script( 'ci-front-scripts', 'ThemeOption', $params );

	if ( ci_setting( 'google_maps_api_enable' ) == 'on' ) {
		wp_enqueue_script( 'google-maps' );
	}


}
endif;


add_action( 'admin_enqueue_scripts', 'ci_enqueue_admin_theme_scripts' );
if ( ! function_exists( 'ci_enqueue_admin_theme_scripts' ) ) :
function ci_enqueue_admin_theme_scripts() {
	global $pagenow;

	//
	// Enqueue here scripts that are to be loaded on all admin pages.
	//

	if ( is_admin() and $pagenow == 'themes.php' and isset( $_GET['page'] ) and $_GET['page'] == 'ci_panel.php' ) {
		//
		// Enqueue here scripts that are to be loaded only on CSSIgniter Settings panel.
		//

	}

	if ( in_array( $pagenow, array( 'widgets.php', 'customize.php' ) ) ) {
		//ci_enqueue_media_manager_scripts();
		wp_enqueue_script( 'ci-admin-widgets' );
		$params['no_posts_found'] = __('No posts found.', 'ci_theme');
		$params['ajaxurl'] = admin_url( 'admin-ajax.php' );
		wp_localize_script( 'ci-admin-widgets', 'ThemeWidget', $params );

	}

}
endif;
