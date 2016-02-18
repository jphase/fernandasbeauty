<?php
if ( ! class_exists( 'CI_Contact_Info' ) ):
class CI_Contact_Info extends WP_Widget {

	function __construct() {
		$widget_ops  = array( 'description' => __( 'Displays address, telephone and a contact e-mail.', 'ci_theme' ) );
		$control_ops = array( /*'width' => 300, 'height' => 400*/ );
		parent::__construct( 'ci-contact-info', $name = __( '-= CI Contact Info =-', 'ci_theme' ), $widget_ops, $control_ops );
	}


	function widget( $args, $instance ) {
		extract( $args );
		$title     = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$address   = $instance['address'];
		$telephone = $instance['telephone'];
		$email     = $instance['email'];

		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;

		?>
		<ul class="ci-contact-info">
			<?php if ( ! empty( $address ) ) : ?>
				<li><i class="fa fa-building"></i> <?php echo esc_html( $address ); ?></li>
			<?php endif; ?>

			<?php if ( ! empty( $telephone ) ) : ?>
				<li><i class="fa fa-phone-square"></i> <?php echo esc_html( $telephone ); ?></li>
			<?php endif; ?>

			<?php if ( ! empty( $email ) ) : ?>
				<li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
			<?php endif; ?>
		</ul>
		<?php

		echo $after_widget;

	} // widget

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['address']   = sanitize_text_field( $new_instance['address'] );
		$instance['telephone'] = sanitize_text_field( $new_instance['telephone'] );
		$instance['email']     = sanitize_text_field( $new_instance['email'] );

		return $instance;
	} // save

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'     => '',
			'address'   => '',
			'telephone' => '',
			'email'     => '',
		) );

		$title     = $instance['title'];
		$address   = $instance['address'];
		$telephone = $instance['telephone'];
		$email     = $instance['email'];

		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ci_theme' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat"/></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'address' ); ?>">
				<?php _e( 'Address:', 'ci_theme' ); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'address' ); ?>"
			     name="<?php echo $this->get_field_name( 'address' ); ?>" type="text"
			     value="<?php echo esc_attr( $address ); ?>" class="widefat"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'telephone' ); ?>">
				<?php _e( 'Telephone No:', 'ci_theme' ); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'telephone' ); ?>"
			     name="<?php echo $this->get_field_name( 'telephone' ); ?>" type="text"
			     value="<?php echo esc_attr( $telephone ); ?>" class="widefat"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>">
				<?php _e( 'Email:', 'ci_theme' ); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'email' ); ?>"
			     name="<?php echo $this->get_field_name( 'email' ); ?>" type="text"
			     value="<?php echo esc_attr( $email ); ?>" class="widefat"/>
		</p>

	<?php
	} // form
} // class

endif; // class_exists

register_widget( 'CI_Contact_Info' );
