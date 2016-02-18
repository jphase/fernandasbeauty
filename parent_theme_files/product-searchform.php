<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" method="get" role="search">
	<div>
		<label for="s" class="screen-reader-text"><?php _e( 'Search for:', 'ci_theme' ); ?></label>
		<input type="text" id="s" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search for Products', 'ci_theme' ); ?>" />
		<button class="searchsubmit" type="submit"><i class="fa fa-search"></i><span class="screen-reader-text"><?php _e( 'Search Products', 'ci_theme' ); ?></span></button>
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>