<?php
//
// Include all custom post types here (one custom post type per file)
//
add_action('after_setup_theme', 'ci_load_custom_post_type_files');
if( !function_exists('ci_load_custom_post_type_files') ):
function ci_load_custom_post_type_files() {
	$cpt_files = apply_filters('load_custom_post_type_files', array(
		'functions/post_types/post',
		'functions/post_types/page',
		'functions/post_types/slider',
		'functions/post_types/video',
		'functions/post_types/gallery',
		'functions/post_types/team',
		'functions/post_types/service',
	));
	foreach($cpt_files as $cpt_file) get_template_part($cpt_file);
}
endif;


add_action( 'init', 'ci_tax_create_taxonomies');
if( !function_exists('ci_tax_create_taxonomies') ):
function ci_tax_create_taxonomies() {
	//
	// Create all taxonomies here.
	//

	// Team > Category
	$labels = array(
		'name'              => _x( 'Team Categories', 'taxonomy general name', 'ci_theme' ),
		'singular_name'     => _x( 'Team Category', 'taxonomy singular name', 'ci_theme' ),
		'search_items'      => __( 'Search Team Categories', 'ci_theme' ),
		'all_items'         => __( 'All Team Categories', 'ci_theme' ),
		'parent_item'       => __( 'Parent Team Category', 'ci_theme' ),
		'parent_item_colon' => __( 'Parent Team Category:', 'ci_theme' ),
		'edit_item'         => __( 'Edit Team Category', 'ci_theme' ),
		'update_item'       => __( 'Update Team Category', 'ci_theme' ),
		'add_new_item'      => __( 'Add New Team Category', 'ci_theme' ),
		'new_item_name'     => __( 'New Team Category Name', 'ci_theme' ),
		'menu_name'         => __( 'Categories', 'ci_theme' ),
		'view_item'         => __( 'View Team Category', 'ci_theme' ),
		'popular_items'     => __( 'Popular Team Categories', 'ci_theme' ),
	);
	register_taxonomy( 'team-category', array( 'cpt_team' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'team-category', 'taxonomy slug', 'ci_theme' ) ),
	) );

	// Video > Category
	$labels = array(
		'name'              => _x( 'Video Categories', 'taxonomy general name', 'ci_theme' ),
		'singular_name'     => _x( 'Video Category', 'taxonomy singular name', 'ci_theme' ),
		'search_items'      => __( 'Search Video Categories', 'ci_theme' ),
		'all_items'         => __( 'All Video Categories', 'ci_theme' ),
		'parent_item'       => __( 'Parent Video Category', 'ci_theme' ),
		'parent_item_colon' => __( 'Parent Video Category:', 'ci_theme' ),
		'edit_item'         => __( 'Edit Video Category', 'ci_theme' ),
		'update_item'       => __( 'Update Video Category', 'ci_theme' ),
		'add_new_item'      => __( 'Add New Video Category', 'ci_theme' ),
		'new_item_name'     => __( 'New Video Category Name', 'ci_theme' ),
		'menu_name'         => __( 'Categories', 'ci_theme' ),
		'view_item'         => __( 'View Video Category', 'ci_theme' ),
		'popular_items'     => __( 'Popular Video Categories', 'ci_theme' ),
	);
	register_taxonomy( 'video-category', array( 'cpt_video' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'video-category', 'taxonomy slug', 'ci_theme' ) ),
	) );

	// Galleries > Category
	$labels = array(
		'name'              => _x( 'Gallery Categories', 'taxonomy general name', 'ci_theme' ),
		'singular_name'     => _x( 'Gallery Category', 'taxonomy singular name', 'ci_theme' ),
		'search_items'      => __( 'Search Gallery Categories', 'ci_theme' ),
		'all_items'         => __( 'All Gallery Categories', 'ci_theme' ),
		'parent_item'       => __( 'Parent Gallery Category', 'ci_theme' ),
		'parent_item_colon' => __( 'Parent Gallery Category:', 'ci_theme' ),
		'edit_item'         => __( 'Edit Gallery Category', 'ci_theme' ),
		'update_item'       => __( 'Update Gallery Category', 'ci_theme' ),
		'add_new_item'      => __( 'Add New Gallery Category', 'ci_theme' ),
		'new_item_name'     => __( 'New Gallery Category Name', 'ci_theme' ),
		'menu_name'         => __( 'Categories', 'ci_theme' ),
		'view_item'         => __( 'View Gallery Category', 'ci_theme' ),
		'popular_items'     => __( 'Popular Gallery Categories', 'ci_theme' ),
	);
	register_taxonomy( 'gallery-category', array( 'cpt_gallery' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'gallery-category', 'taxonomy slug', 'ci_theme' ) ),
	) );

	$labels = array(
		'name'              => _x( 'Service Categories', 'taxonomy general name', 'ci_theme' ),
		'singular_name'     => _x( 'Service Category', 'taxonomy singular name', 'ci_theme' ),
		'search_items'      => __( 'Search Service Categories', 'ci_theme' ),
		'all_items'         => __( 'All Service Categories', 'ci_theme' ),
		'parent_item'       => __( 'Parent Service Category', 'ci_theme' ),
		'parent_item_colon' => __( 'Parent Service Category:', 'ci_theme' ),
		'edit_item'         => __( 'Edit Service Category', 'ci_theme' ),
		'update_item'       => __( 'Update Service Category', 'ci_theme' ),
		'add_new_item'      => __( 'Add New Service Category', 'ci_theme' ),
		'new_item_name'     => __( 'New Service Category Name', 'ci_theme' ),
		'menu_name'         => __( 'Categories', 'ci_theme' ),
		'view_item'         => __( 'View Service Category', 'ci_theme' ),
		'popular_items'     => __( 'Popular Service Categories', 'ci_theme' ),
	);
	register_taxonomy( 'service-category', array( 'cpt_service' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'service-category', 'taxonomy slug', 'ci_theme' ) ),
	) );

	$labels = array(
		'name'              => _x( 'Slider Categories', 'taxonomy general name', 'ci_theme' ),
		'singular_name'     => _x( 'Slider Category', 'taxonomy singular name', 'ci_theme' ),
		'search_items'      => __( 'Search Slider Categories', 'ci_theme' ),
		'all_items'         => __( 'All Slider Categories', 'ci_theme' ),
		'parent_item'       => __( 'Parent Slider Category', 'ci_theme' ),
		'parent_item_colon' => __( 'Parent Slider Category:', 'ci_theme' ),
		'edit_item'         => __( 'Edit Slider Category', 'ci_theme' ),
		'update_item'       => __( 'Update Slider Category', 'ci_theme' ),
		'add_new_item'      => __( 'Add New Slider Category', 'ci_theme' ),
		'new_item_name'     => __( 'New Slider Category Name', 'ci_theme' ),
		'menu_name'         => __( 'Categories', 'ci_theme' ),
		'view_item'         => __( 'View Slider Category', 'ci_theme' ),
		'popular_items'     => __( 'Popular Slider Categories', 'ci_theme' ),
	);
	register_taxonomy( 'slider-category', array( 'cpt_slider' ), array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => _x( 'slider-category', 'taxonomy slug', 'ci_theme' ) ),
	) );

}
endif;

add_action('admin_enqueue_scripts', 'ci_load_post_scripts');
if( !function_exists('ci_load_post_scripts') ):
function ci_load_post_scripts($hook)
{
	//
	// Add here all scripts and styles, to load on all admin pages.
	//

	if(in_array($hook, array('post.php', 'post-new.php')) and in_array(get_post_type(), array('cpt_team', 'cpt_gallery', 'cpt_video', 'cpt_service', 'cpt_slider', 'post', 'page')) ) {
		//
		// Add here all scripts and styles, specific to post edit screens.
		//
		wp_enqueue_media();
		ci_enqueue_media_manager_scripts();

		wp_enqueue_script( 'jquery-gmaps-latlon-picker' );

		wp_enqueue_style( 'jquery-ui-style' );

		ci_localize_datepicker();

		wp_enqueue_style( 'ci-post-edit-screens' );
		wp_enqueue_script( 'ci-post-edit-scripts' );

	}
}
endif;

add_filter('request', 'ci_feed_request');
if( !function_exists('ci_feed_request') ):
function ci_feed_request( $qv ) {
	if ( isset( $qv['feed'] ) && !isset( $qv['post_type'] ) ) {

		$qv['post_type']   = array();
		$qv['post_type']   = get_post_types( $args = array(
			'public'   => true,
			'_builtin' => false
		) );
		$qv['post_type'][] = 'post';
	}

	return $qv;
}
endif;
