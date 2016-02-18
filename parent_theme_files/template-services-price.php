<?php
/*
* Template Name: Services listing with pricing
*/
?>

<?php get_header(); ?>

<?php
	$has_sidebar = false;

	if ( is_active_sidebar( 'service-sidebar' ) ) {
		$has_sidebar = true;
	}
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<main id="main">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h3 class="section-title"><?php the_title(); ?></h3>

					<?php $content = get_the_content(); ?>
					<?php if ( ! empty ( $content ) ): ?>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>

					<div class="row">
						<div class="<?php echo esc_attr( $has_sidebar ? 'col-md-8' : 'col-xs-12' ); ?>">
							<?php
								$args = array(
									'post_type'      => 'cpt_service',
									'posts_per_page' => - 1
								);

								$services = new WP_Query( $args );
							?>
							<?php if ( $services->have_posts() ) : while ( $services->have_posts() ) : $services->the_post(); ?>
								<?php $service_price = get_post_meta( get_the_ID(), 'ci_cpt_service_price', true ); ?>
								<article class="item-media">
									<div class="row">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="col-sm-3">
												<figure class="item-media-thumb">
													<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'ci_square' ); ?></a>
												</figure>
											</div>
										<?php endif; ?>

										<div class="<?php echo esc_attr( has_post_thumbnail() ? 'col-sm-9' : 'col-xs-12' ); ?>">
											<h2 class="entry-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												<span class="item-price"><?php echo esc_html( $service_price ); ?></span>
											</h2>
											<?php the_excerpt(); ?>
										</div>
									</div>
								</article>

							<?php endwhile; endif; wp_reset_postdata(); ?>
						</div>

						<?php if ( $has_sidebar ) : ?>
							<div class="col-md-4">
								<?php dynamic_sidebar( 'service-sidebar' ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>