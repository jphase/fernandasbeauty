<?php $team_fields = get_post_meta( get_the_ID(), 'ci_cpt_team_fields', true ); ?>

<table class="item-meta">
	<tbody>
	<?php if ( has_term( '', 'team-category', get_the_ID() ) ): ?>
		<tr>
			<th><?php _e( 'Category', 'ci_theme' ); ?></th>
			<td><?php the_terms( get_the_ID(), 'team-category', '', ', ' ); ?></td>
		</tr>
	<?php endif; ?>

	<?php if ( ! empty( $team_fields ) && is_array( $team_fields ) ): ?>
		<?php foreach ( $team_fields as $field ) : ?>
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
