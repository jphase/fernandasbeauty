<?php
if ( ! class_exists( 'CI_Widget_Text' ) ):
class CI_Widget_Text extends WP_Widget {

	public function __construct() {
		$widget_ops  = array( 'description' => __( 'Aligned arbitrary text or HTML.', 'ci_theme' ) );
		$control_ops = array( /*'width' => 400, 'height' => 350 */ );
		parent::__construct( 'ci-text', __( '-= CI Text =-', 'ci_theme' ), $widget_ops, $control_ops );

		add_action( 'admin_enqueue_scripts', array( &$this, '_enqueue_admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_custom_css' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		/**
		 * Filter the content of the Text widget.
		 *
		 * @since 2.3.0
		 *
		 * @param string    $widget_text The widget content.
		 * @param WP_Widget $instance    WP_Widget instance.
		 */
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

		$align = $instance['align'];
		$parallax       = $instance['parallax'];
		$parallax_speed = $instance['parallax_speed'];

		echo $args['before_widget'];

		$data_speed = !empty($parallax) ? ' data-speed="'.($parallax_speed/10).'" ' : '';

		?>
		<div class="widget-wrap <?php echo $parallax; ?>" <?php echo $data_speed; ?>><?php

	if ( in_array( $id, array( 'frontpage-widgets', 'inner-sidebar' ) ) ) {
		?>
		<div class="container"><?php
	}

		?>
		<div class="row">
			<div class="col-xs-12">
				<?php
					if ( ! empty( $title ) ) {
						echo $args['before_title'] . $title . $args['after_title'];
					}
				?>
				<div
					class="ci-text-widget <?php echo esc_attr( $align ); ?>"><?php echo ! empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
			</div>
		</div>

		<?php
	if ( in_array( $id, array( 'frontpage-widgets', 'inner-sidebar' ) ) ) :
		?>
		</div>
	<?php endif; ?>
		</div>
		<?php

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = ! empty( $new_instance['filter'] );

		$instance['align'] = in_array( $new_instance['align'], array( 'text-left', 'text-center', 'text-right', 'text-justify' ) ) ? $new_instance['align'] : 'text-left';

		$instance['no_bottom_margin']  = ci_sanitize_checkbox( $new_instance['no_bottom_margin'] );
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
			'title' => '',
			'text'  => '',
			'align' => 'text-left',
			'no_bottom_margin'  => '',
			'color'             => '',
			'background_color'  => '',
			'background_image'  => '',
			'background_repeat' => 'repeat',
			'parallax'          => '',
			'parallax_speed'    => 4,
		) );

		$title = strip_tags( $instance['title'] );
		$text  = esc_textarea( $instance['text'] );
		$align = $instance['align'];

		$no_bottom_margin = $instance['no_bottom_margin'];
		$color             = $instance['color'];
		$background_color  = $instance['background_color'];
		$background_image  = $instance['background_image'];
		$background_repeat = $instance['background_repeat'];
		$parallax          = $instance['parallax'];
		$parallax_speed    = $instance['parallax_speed'];

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ci_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs', 'ci_theme'); ?></label></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'align' ); ?>"><?php _e( 'Align text:', 'ci_theme' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'align' ); ?>" name="<?php echo $this->get_field_name( 'align' ); ?>" class="widefat">
				<option value="text-left" <?php selected( $align, 'text-left' ); ?>><?php echo esc_html_x( 'Left', 'text align', 'ci_theme' ); ?></option>
				<option value="text-center" <?php selected( $align, 'text-center' ); ?>><?php echo esc_html_x( 'Center', 'text align', 'ci_theme' ); ?></option>
				<option value="text-right" <?php selected( $align, 'text-right' ); ?>><?php echo esc_html_x( 'Right', 'text align', 'ci_theme' ); ?></option>
				<option value="text-justify" <?php selected( $align, 'text-justify' ); ?>><?php echo esc_html_x( 'Justify', 'text align', 'ci_theme' ); ?></option>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id('no_bottom_margin'); ?>"><input type="checkbox" name="<?php echo $this->get_field_name('no_bottom_margin'); ?>" id="<?php echo $this->get_field_id('no_bottom_margin'); ?>" value="on" <?php checked($no_bottom_margin, 'on'); ?> /><?php _e('Reduce bottom margin.', 'ci_theme'); ?></label></p>

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

			$no_bottom_margin  = $instance['no_bottom_margin'];
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

			if( 'on' == $no_bottom_margin && in_array( $sidebar_id, array( 'frontpage-widgets', 'inner-sidebar' ) ) ) {
				$padding_css .= 'padding-bottom: 0; margin-bottom: 0; ';
			}

			if ( !empty( $css ) || !empty( $padding_css ) ) {
				$css = '#' . $id . ' .widget-wrap { ' . $css . $padding_css . ' } ' . PHP_EOL;
				wp_add_inline_style('ci-style', $css);
			}

		}

	}
}

endif; // class_exists

register_widget( 'CI_Widget_Text' );
