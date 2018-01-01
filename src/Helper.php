<?php
/**
 * Helper functions
 *
 * @package PuppyFW
 * @since 1.0.0
 */

namespace PuppyFW;

/**
 * Helper class
 */
class Helper {

	/**
	 * Converts field type to camel case.
	 *
	 * @param  string $string String need to be converted.
	 * @return string
	 */
	public function to_camel_case( $string ) {
		$string = str_replace( array( '-', '_' ), ' ', $string );
		$string = ucwords( $string );
		$string = str_replace( ' ', '', $string );
		return $string;
	}

	/**
	 * Converts field type to snake case.
	 *
	 * @param  string $string String need to be converted.
	 * @return string
	 */
	public function to_snake_case( $string ) {
		$string = str_replace( array( '-', '_' ), ' ', $string );
		$string = ucwords( $string );
		$string = str_replace( ' ', '_', $string );
		return $string;
	}

	/**
	 * Gets field type mapping.
	 *
	 * @return array
	 */
	public function field_type_mapping() {
		return apply_filters( 'puppyfw_field_type_mapping', array(
			'text'        => 'input',
			'number'      => 'input',
			'email'       => 'input',
			'tel'         => 'input',
			'post_select' => 'select',
		) );
	}

	/**
	 * Gets field vue component mapping.
	 *
	 * @return array
	 */
	public function field_vue_component_mapping() {
		$mapping = $this->field_type_mapping();
		return apply_filters( 'puppyfw_field_vue_component_mapping', $mapping );
	}

	/**
	 * Gets mapped type.
	 *
	 * @param  string $type Field type.
	 * @return string
	 */
	public function get_mapped_type( $type ) {
		$types = $this->field_type_mapping();

		if ( isset( $types[ $type ] ) ) {
			return $types[ $type ];
		}

		return $type;
	}

	/**
	 * Gets page class.
	 *
	 * @param  array $page_data Page data.
	 * @return string
	 */
	public function get_page_class( $page_data ) {
		$page_class = '\\PuppyFW\\Page';
		$type = ! empty( $page_data['type'] ) ? $page_data['type'] : 'options_page';
		$type_class = $this->to_camel_case( $type );
		if ( class_exists( "\\PuppyFW\\{$type_class}" ) ) {
			$page_class = "\\PuppyFW\\{$type_class}";
		}

		/**
		 * Filters page class.
		 *
		 * @since 1.0.0
		 *
		 * @param string $page_class Page class.
		 * @param array  $page_data  Page data.
		 */
		return apply_filters( 'puppyfw_page_class', $page_class, $page_data );
	}

	/**
	 * Normalizes page data.
	 *
	 * @param  array $page_data Page data.
	 * @return array
	 */
	public function normalize_page( $page_data ) {
		$page_data['type'] = ! empty( $page_data['type'] ) ? $page_data['type'] : 'options_page';
		$method = array( $this, 'normalize_' . $page_data['type'] );

		/**
		 * Filters page normalize method.
		 *
		 * @since 1.0.0
		 *
		 * @param callable $method    Normalize method.
		 * @param array    $page_data Page data.
		 */
		$method = apply_filters( 'puppyfw_page_normalize_method', $method, $page_data );

		if ( is_callable( $method ) ) {
			return call_user_func( $method, $page_data );
		}

		$page_data = wp_parse_args( $page_data, array(
			'parent_slug' => '',
			'page_title'  => '',
			'menu_title'  => '',
			'capability'  => 'manage_options',
			'menu_slug'   => '',
			'icon_url'    => '',
			'position'    => 100,
			'option_name' => '',
		) );

		if ( ! $page_data['menu_slug'] ) {
			$page_data['menu_slug'] = $this->generate_page_id();
		}

		/**
		 * Filters normalized options page data.
		 *
		 * @since 1.0.0
		 *
		 * @param array $page_data Normalized options page data.
		 */
		return apply_filters( 'puppyfw_normalize_options_page', $page_data );
	}

	/**
	 * Normalizes meta box data.
	 *
	 * @param  array $page_data Page data.
	 * @return array
	 */
	public function normalize_meta_box( $page_data ) {
		$page_data = wp_parse_args( $page_data, array(
			'id'            => '',
			'title'         => '',
			'screen'        => 'post',
			'context'       => 'advanced',
			'priority'      => 'default',
			'callback_args' => array(),
			'option_name'   => '',
		) );

		$page_data['screen'] = (array) $page_data['screen'];
		if ( ! $page_data['id'] ) {
			$page_data['id'] = $this->generate_page_id();
		}

		/**
		 * Filters normalized meta box data.
		 *
		 * @since 1.0.0
		 *
		 * @param array $page_data Normalized meta box data.
		 */
		return apply_filters( 'puppyfw_normalize_meta_box', $page_data );
	}

	/**
	 * Generates a random page ID.
	 *
	 * @return string
	 */
	protected function generate_page_id() {
		return 'puppyfw-' . mt_rand( 100, 999 );
	}

	/**
	 * Loads vue components.
	 */
	public function enqueue_components() {
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDuOALLadUZV06Yroa1SonBWh5coy-RNZc&libraries=places', array(), false, true );
		wp_enqueue_script( 'puppyfw-components', PUPPYFW_URL . 'assets/js/components.js', array( 'vue', 'jquery-ui-datepicker' ), '0.1.0', true );

		add_action( 'admin_footer', array( $this, 'components_templates' ) );
	}

	/**
	 * Prints components templates.
	 */
	public function components_templates() {
		?>
		<script type="text/x-template" id="puppyfw-element-map-template">
			<div class="puppyfw-element-map">
				<input type="text" size="43" ref="search" :value="center.formatted_address">
				<button type="button" class="button button-secondary" @click="clearMap"><?php esc_html_e( 'Clear', 'puppyfw' ); ?></button>

				<div class="puppyfw-map-container" ref="map" style="height: 350px;">{{ error }}</div>
			</div>
		</script>
		<?php
	}

	/**
	 * Calls save hooks.
	 *
	 * @param array $page_data Page data.
	 * @param array $save_data Save data.
	 * @param array $args      Custom arguments.
	 */
	public function save_hooks( $page_data, $save_data, $args = array() ) {
		/**
		 * Fires when save option of a specific page type.
		 *
		 * @since 1.0.0
		 *
		 * @param array $page_data Page data.
		 * @param array $save_data Save data.
		 * @param array $args      Custom arguments.
		 */
		do_action( "puppyfw_save_option_{$page_data['type']}", $page_data, $save_data, $args );

		/**
		 * Fires when save option.
		 *
		 * @since 1.0.0
		 *
		 * @param array $page_data Page data.
		 * @param array $save_data Save data.
		 * @param array $args      Custom arguments.
		 */
		do_action( 'puppyfw_save_option', $page_data, $save_data, $args );
	}
}
