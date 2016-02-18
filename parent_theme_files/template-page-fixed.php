<?php
/*
* Template Name: Page with fixed layout
*/
?>

<?php get_header(); ?>

<main id="main">
	<div class="container">
		<div class="row">
			<?php
				$layout     = get_post_meta( get_queried_object_id(), 'page_layout', true );
				$classes    = '';
				$sb_classes = '';

				switch ( $layout ) {
					case 'left':
						$classes    = 'col-md-8 col-sm-7 col-md-push-4 col-sm-push-5';
						$sb_classes = 'col-md-4 col-sm-5 col-md-pull-8 col-sm-pull-7';
						break;
					case 'right':
						$classes    = 'col-md-8 col-sm-7';
						$sb_classes = 'col-md-4 col-sm-5';
						break;
					case 'full':
						$classes = 'col-xs-12';
						break;
				}
			?>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="<?php echo esc_attr( $classes ); ?>">

					<?php get_template_part( 'inc_section_titles' ); ?>

					<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
						<?php if ( ci_has_image_to_show() ) : ?>
							<figure class="entry-thumb">
								<a href="<?php echo esc_url( ci_get_featured_image_src( 'large' ) ); ?>" data-rel="prettyPhoto">
									<?php
										if ( 'full' == $layout ) {
											ci_the_post_thumbnail_full();
										} else {
											ci_the_post_thumbnail();
										}
									?>

								</a>
							</figure>
						<?php endif; ?>

						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>
					</article>

					<?php comments_template(); ?>
				</div>
			<?php endwhile; endif; ?>

			<?php if ( 'full' != $layout ): ?>
				<div class="<?php echo esc_attr( $sb_classes ); ?>">
					<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>