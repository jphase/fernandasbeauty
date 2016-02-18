<?php
if ( ! class_exists( 'CI_Newsletter' ) ):
class CI_Newsletter extends WP_Widget {

	function __construct() {
		$widget_ops  = array( 'description' => __( 'Displays a Newsletter form for your users to register.', 'ci_theme' ) );
		$control_ops = array( /*'width' => 300, 'height' => 400*/ );
		parent::__construct( 'ci-newsletter', $name = __( '-= CI Newsletter =-', 'ci_theme' ), $widget_ops, $control_ops );
	}


	function widget( $args, $instance ) {
		extract( $args );
		$title       = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$button      = $instance['button'];
		$description = $instance['description'];

		echo $before_widget;

		if ( ci_setting( 'newsletter_action' ) != '' ):
			?>
			<form action="<?php echo esc_url( ci_setting( 'newsletter_action' ) ); ?>" method="post" class="ci-newsletter-form">
				<?php echo $before_title; ?>
				<label for="<?php echo esc_attr( ci_setting( 'newsletter_email_id' ) ); ?>"><?php echo $title; ?></label>
				<?php echo $after_title; ?>

				<p><?php echo $description; ?></p>

				<div class="input-group">
					<p><input type="email" name="<?php echo esc_attr( ci_setting( 'newsletter_email_name' ) ); ?>"
					       id="<?php echo esc_attr( ci_setting( 'newsletter_email_id' ) ); ?>"
					       placeholder="<?php esc_attr_e( 'Your e-mail', 'ci_theme' ); ?>"></p>
					<button type="submit" class="btn"><?php echo esc_html( $button ); ?></button>
				</div>
				<?php echo ci_newsletter_hidden_fields(); ?>
			</form>
		<?php
		endif;

		echo $after_widget;

	} // widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']       = sanitize_text_field( $new_instance['title'] );
		$instance['button']      = sanitize_text_field( $new_instance['button'] );
		$instance['description'] = sanitize_text_field( $new_instance['description'] );

		return $instance;
	} // save

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'            => __( 'Subscribe to our newsletter', 'ci_theme' ),
			'description'      => __( 'Stay up to date!', 'ci_theme' ),
			'button'           => __( 'Subscribe now', 'ci_theme' ),
			'no_bottom_margin' => ''
		) );

		$title       = $instance['title'];
		$button      = $instance['button'];
		$description = $instance['description'];

		?>
		<p><?php _e( "The widget will display a newsletter form which will redirect on your custom URL supplied in the Theme Options. It is required that you set up your newsletter options in the Theme Settings for it to display.", 'ci_theme' ); ?></p>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ci_theme' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p>

		<p><label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:', 'ci_theme' ); ?></label><input
				id="<?php echo $this->get_field_id( 'description' ); ?>"
				name="<?php echo $this->get_field_name( 'description' ); ?>" type="text"
				value="<?php echo esc_attr( $description ); ?>" class="widefat"/></p>

		<p><label><?php _e( 'Subscribe button text:', 'ci_theme' ); ?></label><input
				id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>"
				type="text" value="<?php echo esc_attr( $button ); ?>" class="widefat"/></p>

	<?php
	} // form
} // class

endif; // class_exists

register_widget( 'CI_Newsletter' );
