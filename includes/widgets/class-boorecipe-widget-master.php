<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Boorecipe_Widget_Master
 *
 * @package  Boorecipe/includes/widgets
 * @version  1.0
 * @extends  WP_Widget
 *
 * Code borrowed from WooCommerce to make it easy to add widgets
 */
if ( ! class_exists( 'Boorecipe_Widget_Master' ) ) :
	/**
	 * Class Boorecipe_Widget_Master
	 */
	abstract class Boorecipe_Widget_Master extends WP_Widget {

		/**
		 * CSS class.
		 *
		 * @var string
		 */
		public $widget_cssclass;

		/**
		 * Widget description.
		 *
		 * @var string
		 */
		public $widget_description;

		/**
		 * Widget ID.
		 *
		 * @var string
		 */
		public $widget_id;

		/**
		 * Widget name.
		 *
		 * @var string
		 */
		public $widget_name;

		/**
		 * Settings.
		 *
		 * @var array
		 */
		public $settings;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$widget_ops = array(
				'classname'                   => $this->widget_cssclass,
				'description'                 => $this->widget_description,
				'customize_selective_refresh' => true,
			);

			parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );

			add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
			add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
			add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
		}

		/**
		 * Get cached widget.
		 *
		 * @param  array $args Arguments.
		 *
		 * @return bool true if the widget is cached otherwise false
		 */
		public function get_cached_widget( $args ) {
			$cache = wp_cache_get( $this->get_widget_id_for_cache( $this->widget_id ), 'widget' );

			if ( ! is_array( $cache ) ) {
				$cache = array();
			}

			if ( isset( $cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ] ) ) {
				echo $cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ]; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

				return true;
			}

			return false;
		}

		/**
		 * Cache the widget.
		 *
		 * @param  array $args Arguments.
		 * @param  string $content Content.
		 *
		 * @return string the content that was cached
		 */
		public function cache_widget( $args, $content ) {
			$cache = wp_cache_get( $this->get_widget_id_for_cache( $this->widget_id ), 'widget' );

			if ( ! is_array( $cache ) ) {
				$cache = array();
			}

			$cache[ $this->get_widget_id_for_cache( $args['widget_id'] ) ] = $content;

			wp_cache_set( $this->get_widget_id_for_cache( $this->widget_id ), $cache, 'widget' );

			return $content;
		}

		/**
		 * Flush the cache.
		 */
		public function flush_widget_cache() {
			foreach ( array( 'https', 'http' ) as $scheme ) {
				wp_cache_delete( $this->get_widget_id_for_cache( $this->widget_id, $scheme ), 'widget' );
			}
		}

		/**
		 * Output the html at the start of a widget.
		 *
		 * @param array $args Arguments.
		 * @param array $instance Instance.
		 */
		public function widget_start( $args, $instance ) {
			echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

			if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
				echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Output the html at the end of a widget.
		 *
		 * @param  array $args Arguments.
		 */
		public function widget_end( $args ) {
			echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Updates a particular instance of a widget.
		 *
		 * @see    WP_Widget->update
		 *
		 * @param  array $new_instance New instance.
		 * @param  array $old_instance Old instance.
		 *
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {

			$instance = $old_instance;

			if ( empty( $this->settings ) ) {
				return $instance;
			}

			// Loop settings and get values to save.
			foreach ( $this->settings as $key => $setting ) {
				if ( ! isset( $setting['type'] ) ) {
					continue;
				}

				// Format the value based on settings type.
				switch ( $setting['type'] ) {
					case 'number':
						$instance[ $key ] = absint( $new_instance[ $key ] );

						if ( isset( $setting['min'] ) && '' !== $setting['min'] ) {
							$instance[ $key ] = max( $instance[ $key ], $setting['min'] );
						}

						if ( isset( $setting['max'] ) && '' !== $setting['max'] ) {
							$instance[ $key ] = min( $instance[ $key ], $setting['max'] );
						}
						break;
					case 'textarea':
						$instance[ $key ] = wp_kses( trim( wp_unslash( $new_instance[ $key ] ) ), wp_kses_allowed_html( 'post' ) );
						break;
					case 'checkbox':
						$instance[ $key ] = empty( $new_instance[ $key ] ) ? 0 : 1;
						break;
					default:
						$instance[ $key ] = isset( $new_instance[ $key ] ) ? sanitize_text_field( $new_instance[ $key ] ) : $setting['std'];
						break;
				}

				/**
				 * Sanitize the value of a setting.
				 */
			}

			$this->flush_widget_cache();

			return $instance;
		}

		/**
		 * Outputs the settings update form.
		 *
		 * @see   WP_Widget->form
		 *
		 * @param array $instance Instance.
		 */
		public function form( $instance ) {

			if ( empty( $this->settings ) ) {
				return;
			}

			foreach ( $this->settings as $key => $setting ) {

				$class = isset( $setting['class'] ) ? $setting['class'] : '';
				$value = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting['std'];

				switch ( $setting['type'] ) {

					case 'text':
						?>
                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo sanitize_text_field( $setting['label'] ); ?></label>
                            <input class="widefat <?php echo esc_attr( $class ); ?>"
                                   id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                   name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>"
                                   type="text"
                                   value="<?php echo esc_attr( $value ); ?>"/>
                        </p>
						<?php
						break;

					case 'color':

						wp_enqueue_style( 'wp-color-picker' );
						wp_enqueue_script( 'wp-color-picker' );

						?>
                        <script type='text/javascript'>
                            jQuery(document).ready(function ($) {
                                $('.color-picker').wpColorPicker();
                            });

                            jQuery(document).ajaxComplete(function ($) {
                                $('.color-picker').wpColorPicker();
                            });
                        </script>
                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo sanitize_text_field( $setting['label'] ); ?></label>
                            <input class="widefat color-picker <?php echo esc_attr( $class ); ?>"
                                   id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                   name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>"
                                   type="text"
                                   value="<?php echo esc_attr( $value ); ?>"/>
                        </p>
						<?php
						break;

					case 'number':
						?>
                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                            <input class="widefat <?php echo esc_attr( $class ); ?>"
                                   id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                   name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="number"
                                   step="<?php echo esc_attr( $setting['step'] ); ?>"
                                   min="<?php echo esc_attr( $setting['min'] ); ?>"
                                   max="<?php echo esc_attr( $setting['max'] ); ?>"
                                   value="<?php echo esc_attr( $value ); ?>"/>
                        </p>
						<?php

						break;

					case 'select':
						?>
                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                            <select class="widefat <?php echo esc_attr( $class ); ?>"
                                    id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                    name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>">
								<?php foreach ( $setting['options'] as $option_key => $option_value ) : ?>
                                    <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $value ); ?>><?php echo esc_html( $option_value ); ?></option>
								<?php endforeach; ?>
                            </select>
                        </p>
						<?php
						break;

					case 'textarea':
						?>
                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                            <textarea class="widefat <?php echo esc_attr( $class ); ?>"
                                      id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                      name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" cols="20"
                                      rows="3"><?php echo esc_textarea( $value ); ?></textarea>
							<?php if ( isset( $setting['desc'] ) ) : ?>
                                <small><?php echo esc_html( $setting['desc'] ); ?></small>
							<?php endif; ?>
                        </p>
						<?php
						break;

					case 'checkbox':
						?>
                        <p>
                            <input class="checkbox <?php echo esc_attr( $class ); ?>"
                                   id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
                                   name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="checkbox"
                                   value="1" <?php checked( $value, 1 ); ?> />
                            <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                        </p>
						<?php
						break;

					// Default: run an action.
					default:
//					do_action( 'woocommerce_widget_field_' . $setting['type'], $key, $value, $setting, $instance );
						break;
				}
			}
		}

		/**
		 * Get widget id plus scheme/protocol to prevent serving mixed content from (persistently) cached widgets.
		 *
		 * @since  3.4.0
		 *
		 * @param  string $widget_id Id of the cached widget.
		 * @param  string $scheme Scheme for the widget id.
		 *
		 * @return string            Widget id including scheme/protocol.
		 */
		protected function get_widget_id_for_cache( $widget_id, $scheme = '' ) {
			if ( $scheme ) {
				$widget_id_for_cache = $widget_id . '-' . $scheme;
			} else {
				$widget_id_for_cache = $widget_id . '-' . ( is_ssl() ? 'https' : 'http' );
			}

			return $widget_id_for_cache;
		}
	}
endif;
