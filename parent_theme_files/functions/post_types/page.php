<?php
//
// Page listing template meta box
//

add_action( 'admin_init', 'ci_add_page_listing_meta' );
add_action( 'save_post', 'ci_update_page_listing_meta' );

if ( ! function_exists( 'ci_add_page_listing_meta' ) ):
function ci_add_page_listing_meta() {
	add_meta_box( 'ci_page_fixed_tpl_meta', __( 'Fixed layout', 'ci_theme' ), 'ci_add_page_fixed_tpl_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'ci_page_team_listing_meta', __( 'Team Listing Options', 'ci_theme' ), 'ci_add_page_team_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'ci_page_services_listing_meta', __( 'Services Listing Options', 'ci_theme' ), 'ci_add_page_services_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'ci_page_galleries_listing_meta', __( 'Galleries Listing Options', 'ci_theme' ), 'ci_add_page_galleries_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'ci_page_videos_listing_meta', __( 'Videos Listing Options', 'ci_theme' ), 'ci_add_page_videos_listing_meta_box', 'page', 'normal', 'high' );
	add_meta_box( 'ci_page_front_template_meta', __( 'Frontpage Options', 'ci_theme' ), 'ci_add_page_frontpage_meta_box', 'page', 'normal', 'high' );
}
endif;

if ( ! function_exists( 'ci_update_page_listing_meta' ) ):
function ci_update_page_listing_meta( $post_id ) {
	if ( !ci_can_save_meta('page') ) return;

	update_post_meta( $post_id, 'page_layout', sanitize_key( $_POST['page_layout'] ) );

	update_post_meta( $post_id, 'team_listing_columns', intval( $_POST['team_listing_columns'] ) );
	update_post_meta( $post_id, 'team_listing_masonry', ci_sanitize_checkbox( $_POST['team_listing_masonry'] ) );
	update_post_meta( $post_id, 'team_listing_isotope', ci_sanitize_checkbox( $_POST['team_listing_isotope'] ) );
	update_post_meta( $post_id, 'team_listing_posts_per_page', intval( $_POST['team_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'services_listing_columns', intval( $_POST['services_listing_columns'] ) );
	update_post_meta( $post_id, 'services_listing_masonry', ci_sanitize_checkbox( $_POST['services_listing_masonry'] ) );
	update_post_meta( $post_id, 'services_listing_isotope', ci_sanitize_checkbox( $_POST['services_listing_isotope'] ) );
	update_post_meta( $post_id, 'services_listing_posts_per_page', intval( $_POST['services_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'galleries_listing_columns', intval( $_POST['galleries_listing_columns'] ) );
	update_post_meta( $post_id, 'galleries_listing_masonry', ci_sanitize_checkbox( $_POST['galleries_listing_masonry'] ) );
	update_post_meta( $post_id, 'galleries_listing_isotope', ci_sanitize_checkbox( $_POST['galleries_listing_isotope'] ) );
	update_post_meta( $post_id, 'galleries_listing_posts_per_page', intval( $_POST['galleries_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'videos_listing_columns', intval( $_POST['videos_listing_columns'] ) );
	update_post_meta( $post_id, 'videos_listing_masonry', ci_sanitize_checkbox( $_POST['videos_listing_masonry'] ) );
	update_post_meta( $post_id, 'videos_listing_isotope', ci_sanitize_checkbox( $_POST['videos_listing_isotope'] ) );
	update_post_meta( $post_id, 'videos_listing_posts_per_page', intval( $_POST['videos_listing_posts_per_page'] ) );

	update_post_meta( $post_id, 'base_slider_category', intval( $_POST['base_slider_category'] ) );
}
endif;

if ( ! function_exists( 'ci_add_page_fixed_tpl_meta_box' ) ):
function ci_add_page_fixed_tpl_meta_box( $object, $box ) {
	ci_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		ci_metabox_open_tab( false );
			ci_metabox_guide( __( 'Select the desired layout of this page. This option overrides the global layout of your website, so it will always be shown according to your selected option below.', 'ci_theme' ) );
			$options = array(
				'left'  => __( 'Sidebar on the left', 'ci_theme' ),
				'right' => __( 'Sidebar on the right', 'ci_theme' ),
				'full'  => __( 'Full width - No sidebar', 'ci_theme' ),
			);
			ci_metabox_dropdown( 'page_layout', $options, __( 'Fixed page layout', 'ci_theme' ) );
		ci_metabox_close_tab();
	?></div><?php

	ci_bind_metabox_to_page_template( 'ci_page_fixed_tpl_meta', 'template-page-fixed.php', 'page_tpl_fixed_metabox' );
}
endif;

if ( ! function_exists( 'ci_add_page_team_listing_meta_box' ) ):
function ci_add_page_team_listing_meta_box( $object, $box ) {
	ci_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		ci_metabox_open_tab( false );
			$options = array();
			for ( $i = 1; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'ci_theme' ), $i );
			}
			ci_metabox_dropdown( 'team_listing_columns', $options, __( 'Team listing columns:', 'ci_theme' ) );
			ci_metabox_checkbox( 'team_listing_masonry', 'on', __( 'Masonry effect (not applicable to 1 column layout).', 'ci_theme' ) );
			ci_metabox_checkbox( 'team_listing_isotope', 'on', __( 'Isotope effect (ignores <em>Items per page</em> setting.', 'ci_theme' ) );
			ci_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>all items</strong>>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'ci_theme' ), get_option( 'posts_per_page' ) ) );
			ci_metabox_input( 'team_listing_posts_per_page', __( 'Items per page:', 'ci_theme' ) );
		ci_metabox_close_tab();
	?></div><?php

	ci_bind_metabox_to_page_template( 'ci_page_team_listing_meta', 'template-listing-team.php', 'team_listing_metabox' );
}
endif;

if ( ! function_exists( 'ci_add_page_services_listing_meta_box' ) ):
function ci_add_page_services_listing_meta_box( $object, $box ) {
	ci_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		ci_metabox_open_tab( false );
			$options = array();
			for ( $i = 1; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'ci_theme' ), $i );
			}
			ci_metabox_dropdown( 'services_listing_columns', $options, __( 'Services listing columns:', 'ci_theme' ) );
			ci_metabox_checkbox( 'services_listing_masonry', 'on', __( 'Masonry effect (not applicable to 1 column layout).', 'ci_theme' ) );
			ci_metabox_checkbox( 'services_listing_isotope', 'on', __( 'Isotope effect (ignores <em>Items per page</em> setting.', 'ci_theme' ) );
			ci_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>>all items</strong>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'ci_theme' ), get_option( 'posts_per_page' ) ) );
			ci_metabox_input( 'services_listing_posts_per_page', __( 'Items per page:', 'ci_theme' ) );
		ci_metabox_close_tab();
	?></div><?php

	ci_bind_metabox_to_page_template( 'ci_page_services_listing_meta', 'template-listing-services.php', 'services_listing_metabox' );
}
endif;

if ( ! function_exists( 'ci_add_page_galleries_listing_meta_box' ) ):
function ci_add_page_galleries_listing_meta_box( $object, $box ) {
	ci_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		ci_metabox_open_tab( false );
			$options = array();
			for ( $i = 1; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'ci_theme' ), $i );
			}
			ci_metabox_dropdown( 'galleries_listing_columns', $options, __( 'Galleries listing columns:', 'ci_theme' ) );
			ci_metabox_checkbox( 'galleries_listing_masonry', 'on', __( 'Masonry effect (not applicable to 1 column layout).', 'ci_theme' ) );
			ci_metabox_checkbox( 'galleries_listing_isotope', 'on', __( 'Isotope effect (ignores <em>Items per page</em> setting.', 'ci_theme' ) );
			ci_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>all items</strong>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'ci_theme' ), get_option( 'posts_per_page' ) ) );
			ci_metabox_input( 'galleries_listing_posts_per_page', __( 'Items per page:', 'ci_theme' ) );
		ci_metabox_close_tab();
	?></div><?php

	ci_bind_metabox_to_page_template( 'ci_page_galleries_listing_meta', 'template-listing-galleries.php', 'galleries_listing_metabox' );
}
endif;

if ( ! function_exists( 'ci_add_page_videos_listing_meta_box' ) ):
function ci_add_page_videos_listing_meta_box( $object, $box ) {
	ci_prepare_metabox( 'page' );

	?><div class="ci-cf-wrap"><?php
		ci_metabox_open_tab( false );
			$options = array();
			for ( $i = 1; $i <= 4; $i ++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'ci_theme' ), $i );
			}
			ci_metabox_dropdown( 'videos_listing_columns', $options, __( 'Videos listing columns:', 'ci_theme' ) );
			ci_metabox_checkbox( 'videos_listing_masonry', 'on', __( 'Masonry effect (not applicable to 1 column layout).', 'ci_theme' ) );
			ci_metabox_checkbox( 'videos_listing_isotope', 'on', __( 'Isotope effect (ignores <em>Items per page</em> setting.', 'ci_theme' ) );
			ci_metabox_guide( sprintf( __( 'Set the number of items per page that you want to display. Setting this to <strong>-1</strong> will show <strong>all items</strong>, while setting it to zero or leaving it empty, will follow the global option set from <em>Settings -> Reading</em>, currently set to <strong>%s items per page</strong>.', 'ci_theme' ), get_option( 'posts_per_page' ) ) );
			ci_metabox_input( 'videos_listing_posts_per_page', __( 'Items per page:', 'ci_theme' ) );
		ci_metabox_close_tab();
	?></div><?php

	ci_bind_metabox_to_page_template( 'ci_page_videos_listing_meta', 'template-listing-videos.php', 'videos_listing_metabox' );
}
endif;

if ( ! function_exists( 'ci_add_page_frontpage_meta_box' ) ):
function ci_add_page_frontpage_meta_box( $object, $box ) {
	ci_prepare_metabox( 'page' );

	$category = get_post_meta( $object->ID, 'base_slider_category', true );

	?><div class="ci-cf-wrap"><?php
		ci_metabox_open_tab( false );
			ci_metabox_guide( __( "Select the base slideshow category. Only items of the selected category will be displayed. If you don't select one (i.e. empty), slides from all categories will be shown.", 'ci_theme' ) );
			?><p><label for="base_slider_category"><?php _e( 'Base category:', 'ci_theme' ); ?></label> <?php
			wp_dropdown_categories( array(
				'selected'         => $category,
				'id'               => 'base_slider_category',
				'name'             => 'base_slider_category',
				'show_option_none' => ' ',
				'taxonomy'         => 'slider-category',
				'hierarchical'     => 1,
				'show_count'       => 1,
				'hide_empty'       => 0
			) );
			?></p><?php
		ci_metabox_close_tab();
	?></div><?php

	ci_bind_metabox_to_page_template( 'ci_page_front_template_meta', 'template-frontpage.php', 'page_front_template_metabox' );
}
endif;
