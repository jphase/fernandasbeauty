<h1 class="section-title">
	<?php
		if ( woocommerce_enabled() && is_woocommerce() ) {
			woocommerce_page_title();
		} elseif ( is_singular( 'cpt_service' ) || is_post_type_archive( 'cpt_service' ) ) {
			ci_e_setting( 'title_services' );
		} elseif ( is_singular( 'cpt_team' ) || is_post_type_archive( 'cpt_team' ) ) {
			ci_e_setting( 'title_team' );
		} elseif ( is_singular( 'cpt_gallery' ) || is_post_type_archive( 'cpt_gallery' ) ) {
			ci_e_setting( 'title_galleries' );
		} elseif ( is_singular( 'cpt_video' ) || is_post_type_archive( 'cpt_video' ) ) {
			ci_e_setting( 'title_videos' );
		} elseif ( is_page_template( 'template-blog-fullwidth.php' ) ) {
			ci_e_setting( 'title_blog' );
		} elseif ( is_page() ) {
			single_post_title();
		} elseif ( is_singular( 'post' ) or is_home() ) {
			ci_e_setting( 'title_blog' );
		} elseif ( is_archive() ) {
			the_archive_title();
		} elseif ( is_search() ) {
			_e( 'Search results', 'ci_theme' );
		} elseif ( is_404() ) {
			_e( 'Page not found! (404)', 'ci_theme' );
		}
	?>
</h1>