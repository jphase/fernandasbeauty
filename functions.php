<?php
add_action( 'wp_enqueue_scripts', 'fernandas_styles' );
function fernandas_styles() {
	// Styles
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

	// Scripts
}
