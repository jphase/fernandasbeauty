<?php
	$cpt_taxonomy = get_object_taxonomies( get_post_type() );
	if ( is_array( $cpt_taxonomy ) && count( $cpt_taxonomy ) > 0 ) {
		$cpt_taxonomy = $cpt_taxonomy[0];
	} else {
		$cpt_taxonomy = 'category';
	}

	switch( get_post_type() ) {
		case 'post':
			?>
			<div class="item-info">
				<p class="item-title-main"><?php the_title(); ?></p>
				<p class="item-byline"><?php echo get_the_date(); ?></p>
				<a class="btn item-btn" href="<?php the_permalink(); ?>"><?php echo ci_get_read_more_text( get_post_type() ); ?></a>
			</div>
			<?php
			break;
		case 'page':
			?>
			<div class="item-info">
				<p class="item-title-main"><?php the_title(); ?></p>
				<a class="btn item-btn" href="<?php the_permalink(); ?>"><?php echo ci_get_read_more_text( get_post_type() ); ?></a>
			</div>
			<?php
			break;
		case 'cpt_team':
			?>
			<div class="item-info">
				<p class="item-title-main"><?php the_title(); ?></p>
				<p class="item-byline"><?php echo strip_tags( get_the_term_list( get_the_ID(), $cpt_taxonomy, '', ', ' ) ); ?></p>
				<a class="btn item-btn" href="<?php the_permalink(); ?>"><?php echo ci_get_read_more_text( get_post_type() ); ?></a>
			</div>
			<?php
			break;
		case 'cpt_service':
			?>
			<div class="item-info">
				<p class="item-title-main"><?php the_title(); ?></p>
				<a class="btn item-btn" href="<?php the_permalink(); ?>"><?php echo ci_get_read_more_text( get_post_type() ); ?></a>
			</div>
			<?php
			break;
		case 'cpt_gallery':
			?>
			<div class="item-info">
				<p class="item-title-main"><?php the_title(); ?></p>
				<a class="btn item-btn" href="<?php the_permalink(); ?>"><?php echo ci_get_read_more_text( get_post_type() ); ?></a>
			</div>
			<?php
			break;
		case 'cpt_video':
			?>
			<div class="item-info">
				<p class="item-title-main"><?php the_title(); ?></p>
				<a class="btn item-btn" href="<?php the_permalink(); ?>"><?php echo ci_get_read_more_text( get_post_type() ); ?></a>
			</div>
			<?php
			break;
		case 'product':
			?>
			<div class="item-info">
				<p class="item-title-main"><?php the_title(); ?></p>
				<p class="item-byline">
					<?php woocommerce_template_loop_price(); ?>
					<?php
						/**
						 * woocommerce_before_shop_loop_item_title hook
						 *
						 * @hooked woocommerce_show_product_loop_sale_flash - 10
						 */
						do_action( 'woocommerce_before_shop_loop_item_title' );
					?>
				</p>
				<a class="btn item-btn" href="<?php the_permalink(); ?>"><?php echo ci_get_read_more_text( get_post_type() ); ?></a>
			</div>
			<?php
			break;
	}
?>

