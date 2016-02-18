<?php
add_action( 'init', 'ci_register_theme_styles' );
if ( ! function_exists( 'ci_register_theme_styles' ) ):
function ci_register_theme_styles() {
	//
	// Register all front-end and admin styles here. 
	// There is no need to register them conditionally, as the enqueueing can be conditional.
	//

	$font_url = '';
	/* translators: If there are characters in your language that are not supported by Montserrat or Lato, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat and Lato fonts: on or off', 'ci_theme' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Montserrat:400,700|Lato:300,400,400italic,700,700italic&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
	}
	wp_register_style( 'ci-google-font', $font_url, array() );

	wp_register_style( 'ci-base', get_child_or_parent_file_uri( '/css/base.css' ) );
	wp_register_style( 'ci-flexslider', get_child_or_parent_file_uri( '/css/flexslider.css' ) );
	wp_register_style( 'mmenu', get_child_or_parent_file_uri( '/css/mmenu.css' ) );
	wp_register_style( 'magnific', get_child_or_parent_file_uri( '/css/magnific.css' ), array(), '1.0.0' );
	wp_register_style( 'jquery-ui-style', get_child_or_parent_file_uri( '/css/admin/jquery-ui.css' ), array(), '1.10.4' );
	wp_register_style( 'stapel', get_child_or_parent_file_uri( '/css/stapel.css' ), array(), '1.0.0' );

	wp_register_style( 'ci-repeating-fields', get_child_or_parent_file_uri( '/css/admin/repeating-fields.css' ) );
	wp_register_style( 'ci-admin-widgets', get_child_or_parent_file_uri( '/css/admin/admin-widgets.css' ), array( 'ci-repeating-fields' ) );
	wp_register_style( 'ci-post-edit-screens', get_child_or_parent_file_uri( '/css/admin/post_edit_screens.css' ), array( 'ci-repeating-fields' ) );

	wp_register_style( 'ci-color-scheme', get_child_or_parent_file_uri( '/colors/' . ci_setting( 'stylesheet' ) ) );
	wp_register_style( 'ci-style', get_stylesheet_uri(), array(
		'ci-google-font',
		'ci-base',
		'ci-flexslider',
		'font-awesome',
		'mmenu',
		'stapel',
		'magnific'
	), CI_THEME_VERSION, 'screen' );

}
endif;


add_action( 'wp_enqueue_scripts', 'ci_enqueue_theme_styles' );
if ( ! function_exists( 'ci_enqueue_theme_styles' ) ) :
function ci_enqueue_theme_styles() {
	//
	// Enqueue all (or most) front-end styles here.
	//
	if( wp_style_is( 'woocommerce_prettyPhoto_css', 'enqueued' ) ) {
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	}

	wp_enqueue_style( 'ci-style' );
	wp_enqueue_style( 'ci-color-scheme' );
}
endif;


if ( ! function_exists( 'ci_enqueue_admin_theme_styles' ) ) :
add_action( 'admin_enqueue_scripts', 'ci_enqueue_admin_theme_styles' );
function ci_enqueue_admin_theme_styles() {
	global $pagenow;

	//
	// Enqueue here styles that are to be loaded on all admin pages.
	//

	if ( is_admin() and $pagenow == 'themes.php' and isset( $_GET['page'] ) and $_GET['page'] == 'ci_panel.php' ) {
		//
		// Enqueue here styles that are to be loaded only on CSSIgniter Settings panel.
		//
	}

	if ( in_array( $pagenow, array( 'widgets.php', 'customize.php' ) ) ) {
		wp_enqueue_style( 'ci-admin-widgets' );
	}

}
endif;
