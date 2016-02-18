<?php
if ( ! class_exists( 'CI_Widget_Callout' ) ):
class CI_Widget_Callout extends WP_Widget {

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'Displays a callout box.', 'ci_theme' ) );
		$control_ops = array( /*'width' => 400, 'height' => 350 */ );
		parent::__construct( 'ci-callout', __( '-= CI Callout =-', 'ci_theme' ), $widget_ops, $control_ops );

		add_action( 'admin_enqueue_scripts', array( &$this, '_enqueue_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		/**
		 * Filter the content of the Text widget.
		 *
		 * @since 2.3.0
		 *
		 * @param string    $widget_text The widget content.
		 * @param WP_Widget $instance    WP_Widget instance.
		 */
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

		$btn_url        = $instance['btn_url'];
		$btn_text       = $instance['btn_text'];
		$parallax       = $instance['parallax'];
		$parallax_speed = $instance['parallax_speed'];

		echo $args['before_widget'];

		$data_speed = !empty($parallax) ? ' data-speed="'.($parallax_speed/10).'" ' : '';

		if ( in_array( $id, array( 'frontpage-widgets', 'inner-sidebar' ) ) ) {
			?>
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
			<?php
		}

		?>
		<div class="widget-wrap <?php echo $parallax; ?>" <?php echo $data_speed; ?>>
			<p class="widget-callout-title"><?php echo esc_html( $text ); ?></p>

			<a class="btn btn-inverted" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
		</div>
		<?php

		if ( in_array( $id, array( 'frontpage-widgets', 'inner-sidebar' ) ) ) :
			?>
					</div>
				</div>
			</div>
			<?php
		endif;

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed

		$instance['btn_url']  = esc_url_raw( $new_instance['btn_url'] );
		$instance['btn_text'] = esc_html( $new_instance['btn_text'] );


		$instance['color']             = ci_sanitize_hex_color( $new_instance['color'] );
		$instance['background_color']  = ci_sanitize_hex_color( $new_instance['background_color'] );
		$instance['background_image']  = esc_url_raw( $new_instance['background_image'] );
		$instance['background_repeat'] = in_array( $new_instance['background_repeat'], array( 'repeat', 'no-repeat', 'repeat-x', 'repeat-y' ) ) ? $new_instance['background_repeat'] : 'repeat';
		$instance['parallax']          = ci_sanitize_checkbox( $new_instance['parallax'], 'parallax' );
		$instance['parallax_speed']    = round( floatval( $new_instance['parallax_speed'] ), 1 );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'text'              => '',
			'btn_url'           => '',
			'btn_text'          => '',
			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
			'parallax'          => '',
			'parallax_speed'    => 4,
		) );

		$text     = esc_html( $instance['text'] );
		$btn_url  = esc_url( $instance['btn_url'] );
		$btn_text = esc_html( $instance['btn_text'] );

		$color             = $instance['color'];
		$background_color  = $instance['background_color'];
		$background_image  = $instance['background_image'];
		$background_repeat = $instance['background_repeat'];
		$parallax          = $instance['parallax'];
		$parallax_speed    = $instance['parallax_speed'];

		?>
		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'ci_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('btn_url'); ?>"><?php _e('Button URL:', 'ci_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('btn_url'); ?>" name="<?php echo $this->get_field_name('btn_url'); ?>" type="text" value="<?php echo esc_url($btn_url); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('btn_text'); ?>"><?php _e('Button Text:', 'ci_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('btn_text'); ?>" name="<?php echo $this->get_field_name('btn_text'); ?>" type="text" value="<?php echo esc_attr($btn_text); ?>" /></p>


		<fieldset class="ci-collapsible">
			<legend><?php _e('Custom Colors', 'ci_theme'); ?> <i class="dashicons dashicons-arrow-down"></i></legend>
			<div class="elements">
				<p><label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Foreground Color:', 'ci_theme'); ?></label><input id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" type="text" value="<?php echo esc_attr($color); ?>" class="colorpckr widefat" /></p>
				<p><label for="<?php echo $this->get_field_id('background_color'); ?>"><?php _e('Background Color:', 'ci_theme'); ?></label><input id="<?php echo $this->get_field_id('background_color'); ?>" name="<?php echo $this->get_field_name('background_color'); ?>" type="text" value="<?php echo esc_attr($background_color); ?>" class="colorpckr widefat" /></p>
				<p class="ci-collapsible-media"><label for="<?php echo $this->get_field_id('background_image'); ?>"><?php _e('Background Image:', 'ci_theme'); ?></label><input id="<?php echo $this->get_field_id('background_image'); ?>" name="<?php echo $this->get_field_name('background_image'); ?>" type="text" value="<?php echo esc_attr($background_image); ?>" class="uploaded widefat" /><a href="#" class="button ci-upload"><?php _e('Upload', 'ci_theme'); ?></a></p>
				<p>
					<label for="<?php echo $this->get_field_id('background_repeat'); ?>"><?php _e('Background Repeat:', 'ci_theme'); ?></label>
					<select id="<?php echo $this->get_field_id('background_repeat'); ?>" class="widefat" name="<?php echo $this->get_field_name('background_repeat'); ?>">
						<option value="repeat" <?php selected('repeat', $background_repeat); ?>><?php _e('Repeat', 'ci_theme'); ?></option>
						<option value="repeat-x" <?php selected('repeat-x', $background_repeat); ?>><?php _e('Repeat Horizontally', 'ci_theme'); ?></option>
						<option value="repeat-y" <?php selected('repeat-y', $background_repeat); ?>><?php _e('Repeat Vertically', 'ci_theme'); ?></option>
						<option value="no-repeat" <?php selected('no-repeat', $background_repeat); ?>><?php _e('No Repeat', 'ci_theme'); ?></option>
					</select>
				</p>

				<p><label for="<?php echo $this->get_field_id('parallax'); ?>"><input type="checkbox" name="<?php echo $this->get_field_name('parallax'); ?>" id="<?php echo $this->get_field_id('parallax'); ?>" value="parallax" <?php checked($parallax, 'parallax');?> /><?php _e('Parallax effect (requires a background image).', 'ci_theme'); ?></label></p>
				<p><label for="<?php echo $this->get_field_id('parallax_speed'); ?>"><?php _e('Parallax speed (1-8):', 'ci_theme'); ?></label><input id="<?php echo $this->get_field_id('parallax_speed'); ?>" name="<?php echo $this->get_field_name('parallax_speed'); ?>" type="number" min="1" max="8" step="1" value="<?php echo esc_attr($parallax_speed); ?>" class="widefat" /></p>

			</div>
		</fieldset>
		<?php
	}

	static function _enqueue_admin_scripts() {
		global $pagenow;

		if ( in_array( $pagenow, array( 'widgets.php', 'customize.php' ) ) ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_media();
			ci_enqueue_media_manager_scripts();
		}
	}

	function enqueue_custom_css() {
		$settings = $this->get_settings();

		if( empty( $settings ) )
			return;

		foreach( $settings as $instance_id => $instance ) {
			$id = $this->id_base.'-'.$instance_id;

			if ( !is_active_widget( false, $id, $this->id_base ) ) {
				continue;
			}

			$sidebar_id      = false; // Holds the sidebar id that the widget is assigned to.
			$sidebar_widgets = wp_get_sidebars_widgets();
			if ( !empty( $sidebar_widgets ) ) {
				foreach ( $sidebar_widgets as $sidebar => $widgets ) {
					// We need to check $widgets for emptiness due to https://core.trac.wordpress.org/ticket/14876
					if ( !empty( $widgets ) && array_search( $id, $widgets ) !== false ) {
						$sidebar_id = $sidebar;
					}
				}
			}

			$color             = $instance['color'];
			$background_color  = $instance['background_color'];
			$background_image  = $instance['background_image'];
			$background_repeat = $instance['background_repeat'];

			$css = '';
			$padding_css = '';

			if( !empty( $color ) ) {
				$css .= 'color: ' . $color . '; ';
			}
			if( !empty( $background_color ) ) {
				$css .= 'background-color: ' . $background_color . '; ';
			}
			if( !empty( $background_image ) ) {
				$css .= 'background-image: url(' . esc_url($background_image) . ');';
				$css .= 'background-repeat: ' . $background_repeat . ';';
			}

			if( !empty( $background_color ) or !empty( $background_image ) ) {
				if( !in_array( $sidebar_id, array( 'frontpage-widgets', 'inner-sidebar' ) ) ) {
					$padding_css .= 'padding: 25px 15px; ';
				}
			}

			if ( !empty( $css ) || !empty( $padding_css ) ) {
				$css = '#' . $id . ' .widget-wrap { ' . $css . $padding_css . ' } ' . PHP_EOL;
				wp_add_inline_style('ci-style', $css);
			}

		}

	}
}

endif; // !class_exists

register_widget( 'CI_Widget_Callout' );
