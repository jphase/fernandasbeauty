<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_archive_options', 90);
	if( !function_exists('ci_add_tab_archive_options') ):
		function ci_add_tab_archive_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Archive Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;

	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );
	$ci_defaults['team_per_page'] = '12';
	$ci_defaults['team_isotope']  = '';
	$ci_defaults['team_masonry']  = '';
	$ci_defaults['team_columns']  = '3';

	$ci_defaults['services_per_page'] = '12';
	$ci_defaults['services_isotope']  = '';
	$ci_defaults['services_masonry']  = '';
	$ci_defaults['services_columns']  = '3';

	$ci_defaults['videos_per_page'] = '12';
	$ci_defaults['videos_isotope']  = '';
	$ci_defaults['videos_masonry']  = '';
	$ci_defaults['videos_columns']  = '3';

	$ci_defaults['galleries_per_page'] = '12';
	$ci_defaults['galleries_isotope']  = '';
	$ci_defaults['galleries_masonry']  = '';
	$ci_defaults['galleries_columns']  = '3';

	// Intercepts the request and injects the appropriate posts_per_page parameter according to the request.
	add_filter( 'pre_get_posts', 'ci_cpt_taxonomy_paging_request' );
	if( !function_exists('ci_cpt_taxonomy_paging_request') ):
	function ci_cpt_taxonomy_paging_request( $query ) {

		//We don't want to mess other templates/post types or with the admin panel.
		if( !is_tax() || is_admin() ) return $query;

		// Make sure we don't override any explicitly set posts_per_page
		if (isset($query->query_vars['posts_per_page'])) return $query;

		$num_of_pages = false;

		if ( is_tax( 'team-category' ) ) {
			$num_of_pages = intval( ci_setting( 'team_per_page' ) );
		} elseif ( is_tax( 'video-category' ) ) {
			$num_of_pages = intval( ci_setting( 'videos_per_page' ) );
		} elseif ( is_tax( 'gallery-category' ) ) {
			$num_of_pages = intval( ci_setting( 'galleries_per_page' ) );
		} elseif ( is_tax( 'service-category' ) ) {
			$num_of_pages = intval( ci_setting( 'services_per_page' ) );
		}

		// Assign a number only if a number was found;
		if ( $num_of_pages !== false && $num_of_pages > 0 ) {
			$query->set( 'posts_per_page', $num_of_pages );
		}

		return $query;
	}
	endif;

?>
<?php else: ?>

	<fieldset class="set">
		<legend><?php _e('Team', 'ci_theme'); ?></legend>
		<p class="guide"><?php _e( 'These settings affect the behaviour of the taxonomy listing pages (i.e. NOT listings created with a page template).', 'ci_theme' ); ?></p>
		<?php
			$options = array();
			for ( $i = 1; $i <= 4; $i++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'ci_theme' ), $i );
			}
			ci_panel_dropdown( 'team_columns', $options, __( 'Team listing columns:', 'ci_theme' ) );
		?>
		<fieldset class="mt20 mb20">
			<?php
				ci_panel_checkbox( 'team_isotope', 'on', __( 'Enable category filters (isotope effect).', 'ci_theme' ) );
				ci_panel_checkbox( 'team_masonry', 'on', __( 'Enable masonry layout.', 'ci_theme' ) );
			?>
		</fieldset>
		<?php ci_panel_input( 'team_per_page', __( 'Number of team members per page:', 'ci_theme' ) ); ?>
	</fieldset>


	<fieldset class="set">
		<legend><?php _e('Services', 'ci_theme'); ?></legend>
		<p class="guide"><?php _e( 'These settings affect the behaviour of the taxonomy listing pages (i.e. NOT listings created with a page template).', 'ci_theme' ); ?></p>
		<?php
			$options = array();
			for ( $i = 1; $i <= 4; $i++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'ci_theme' ), $i );
			}
			ci_panel_dropdown( 'services_columns', $options, __( 'Service category listing columns:', 'ci_theme' ) );
		?>
		<fieldset class="mt20 mb20">
			<?php
				ci_panel_checkbox( 'services_isotope', 'on', __( 'Enable category filters (isotope effect).', 'ci_theme' ) );
				ci_panel_checkbox( 'services_masonry', 'on', __( 'Enable masonry layout.', 'ci_theme' ) );
			?>
		</fieldset>
		<?php ci_panel_input( 'services_per_page', __( 'Number of services per page:', 'ci_theme' ) ); ?>
	</fieldset>


	<fieldset class="set">
		<legend><?php _e('Videos', 'ci_theme'); ?></legend>
		<p class="guide"><?php _e( 'These settings affect the behaviour of the taxonomy listing pages (i.e. NOT listings created with a page template).', 'ci_theme' ); ?></p>
		<?php
			$options = array();
			for ( $i = 1; $i <= 4; $i++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'ci_theme' ), $i );
			}
			ci_panel_dropdown( 'videos_columns', $options, __( 'Videos listing columns:', 'ci_theme' ) );
		?>
		<fieldset class="mt20 mb20">
			<?php
				ci_panel_checkbox( 'videos_isotope', 'on', __( 'Enable category filters (isotope effect).', 'ci_theme' ) );
				ci_panel_checkbox( 'videos_masonry', 'on', __( 'Enable masonry layout.', 'ci_theme' ) );
			?>
		</fieldset>
		<?php ci_panel_input( 'videos_per_page', __( 'Number of videos per page:', 'ci_theme' ) ); ?>
	</fieldset>

	<fieldset class="set">
		<legend><?php _e('Galleries', 'ci_theme'); ?></legend>
		<p class="guide"><?php _e( 'These settings affect the behaviour of the taxonomy listing pages (i.e. NOT listings created with a page template).', 'ci_theme' ); ?></p>
		<?php
			$options = array();
			for ( $i = 1; $i <= 4; $i++ ) {
				$options[ $i ] = sprintf( _n( '1 Column', '%s Columns', $i, 'ci_theme' ), $i );
			}
			ci_panel_dropdown( 'galleries_columns', $options, __( 'Galleries listing columns:', 'ci_theme' ) );
		?>
		<fieldset class="mt20 mb20">
			<?php
				ci_panel_checkbox( 'galleries_isotope', 'on', __( 'Enable category filters (isotope effect).', 'ci_theme' ) );
				ci_panel_checkbox( 'galleries_masonry', 'on', __( 'Enable masonry layout.', 'ci_theme' ) );
			?>
		</fieldset>
		<?php ci_panel_input( 'galleries_per_page', __( 'Number of galleries per page:', 'ci_theme' ) ); ?>
	</fieldset>

<?php endif; ?>