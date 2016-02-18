<?php
	$service_fields = get_post_meta( get_the_ID(), 'ci_cpt_service_fields', true );
	$service_price  = get_post_meta( get_the_ID(), 'ci_cpt_service_price', true );
?>

<table class="item-meta">
	<tbody>
		<?php if ( has_term( '', 'service-category', get_the_ID() ) ): ?>
			<tr>
				<th><?php _e( 'Category', 'ci_theme' ); ?></th>
				<td><?php the_terms( get_the_ID(), 'service-category', '', ', ' ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( ! empty( $service_price ) ) : ?>
			<tr>
				<th><?php _e( 'Price:', 'ci_theme' ); ?></th>
				<td><?php echo esc_html( $service_price ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( ! empty( $service_fields ) && is_array( $service_fields ) ): ?>
			<?php foreach ( $service_fields as $field ): ?>
				<tr>
					<th><?php echo $field['title']; ?></th>
					<?php
						$td_class = '';
						if ( ci_is_repeating_button( $field['description'] ) ) {
							$td_class = 'class="action"';
						}
					?>
					<td <?php echo $td_class; ?>><?php echo $field['description']; ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
