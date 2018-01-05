<?php
/**
 * Page class
 *
 * @package PuppyFW
 */

namespace PuppyFW;

use PuppyFW\Fields\Field;

/**
 * Class Page
 */
class Page {

	/**
	 * Page type.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $type = 'options_page';

	/**
	 * Storage.
	 *
	 * @var Storages\Storage
	 */
	public $storage;

	/**
	 * Page data.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * List of fields.
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * List of fields array.
	 *
	 * @var array
	 */
	protected $fields_array = array();

	/**
	 * Default value of fields.
	 *
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * Class Page constructor.
	 *
	 * @param array $data Page data.
	 */
	public function __construct( $data ) {
		$this->init_storage();

		$data = $this->normalize( $data );
		$this->data = apply_filters( 'puppyfw_normalize_page_data', $data, $this );
	}

	/**
	 * Initializes storage.
	 *
	 * @since 1.0.0
	 */
	protected function init_storage() {
		$this->storage = new Storages\Option();
	}

	/**
	 * Prepares fields for rendering.
	 *
	 * @since 1.0.0
	 */
	protected function prepare_fields() {
		if ( empty( $this->data['fields'] ) ) {
			return;
		}

		$fields = $this->data['fields'];
		unset( $this->data['fields'] );

		if ( isset( $fields ) ) {
			foreach ( $fields as $field ) {
				$this->add_field( $field );
			}
		}
	}

	/**
	 * Gets page identity.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->data['menu_slug'];
	}

	/**
	 * Normalizes page data.
	 *
	 * @param  array $page_data Page data.
	 * @return array
	 */
	protected function normalize( $page_data ) {
		return puppyfw()->helper->normalize_page( $page_data );
	}

	/**
	 * Adds child field.
	 *
	 * @param array $field_data Field data.
	 * @return Field Field instance.
	 */
	public function add_field( $field_data ) {
		$field_data['page'] = $this;
		$field = FieldFactory::get_field( $field_data );

		// Add field.
		$this->fields[] = $field;

		return $field;
	}

	/**
	 * Adds default value.
	 *
	 * @param string $field_id Field ID.
	 * @param mixed  $value    Field default value.
	 */
	public function add_default( $field_id, $value ) {
		$this->defaults[ $field_id ] = $value;
	}

	/**
	 * Gets fields default value.
	 *
	 * @return array
	 */
	public function get_defaults() {
		return $this->defaults;
	}

	/**
	 * Gets page data.
	 *
	 * @return array
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * Adds hook for registering page.
	 */
	public function register() {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
	}

	/**
	 * Registers page.
	 */
	public function register_page() {
		if ( ! $this->data['parent_slug'] ) {
			$this->page_hook = add_menu_page(
				$this->data['page_title'],
				$this->data['menu_title'],
				$this->data['capability'],
				$this->data['menu_slug'],
				array( $this, 'render' ),
				$this->data['icon_url'],
				$this->data['position']
			);
		} else {
			$this->page_hook = add_submenu_page(
				$this->data['parent_slug'],
				$this->data['page_title'],
				$this->data['menu_title'],
				$this->data['capability'],
				$this->data['menu_slug'],
				array( $this, 'render' )
			);
		}

		add_action( "load-{$this->page_hook}", array( $this, 'load' ) );
	}

	/**
	 * Loads page.
	 */
	public function load() {
		$this->prepare_fields();

		/**
		 * Fires before rendering page.
		 *
		 * @since 0.2.0
		 *
		 * @param Page $page Page instance.
		 */
		do_action( 'puppyfw_before_page_rendering', $this );

		$this->fetch_fields_array();

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Fetches fields array.
	 */
	public function fetch_fields_array() {
		foreach ( $this->fields as $field ) {
			$this->fields_array[] = $field->to_array();
		}
	}

	/**
	 * Gets option value.
	 *
	 * @param  string $option_id Option ID.
	 * @return mixed
	 */
	public function get_option( $option_id ) {
		if ( empty( $this->fields ) ) {
			$this->prepare_fields();
		}

		$default_value = isset( $this->defaults[ $option_id ] ) ? $this->defaults[ $option_id ] : null;

		if ( $this->data['option_name'] ) {
			$options = $this->storage->get( $this->data['option_name'], array() );
			$value = isset( $options[ $option_id ] ) ? $options[ $option_id ] : $default_value;
		} else {
			$value = $this->storage->get( $option_id, $default_value );
		}

		/**
		 * Filters option value.
		 *
		 * @since 0.2.0
		 *
		 * @param mixed  $value     Option value.
		 * @param string $option_id Option ID.
		 * @param Page   $page      Option page instance.
		 */
		return apply_filters( 'puppyfw_get_option', $value, $option_id, $this );
	}

	/**
	 * Checks permission when save.
	 *
	 * @return true|WP_Error Return true on success, WP_Error object on failure.
	 */
	public function check_permission() {
		if ( ! current_user_can( $this->data['capability'] ) ) {
			return new \WP_Error( 'permission-denied', __( 'Permission denied!', 'puppyfw' ) );
		}
	}

	/**
	 * Render page.
	 */
	public function render() {
		?>
		<div class="wrap">
			<div id="puppyfw-app" class="puppyfw-page-<?php echo esc_attr( $this->get_id() ); ?>">
				<form>
					<div class="puppyfw">
						<div class="puppyfw__header">
							<div class="puppyfw__title">
								<?php echo esc_html( $this->data['page_title'] ); ?>
							</div>

							<div class="puppyfw__actions">
								<button type="button" class="button button-primary" @click="save"><?php esc_html_e( 'Save options', 'puppyfw' ); ?></button>
							</div>
						</div>

						<div class="puppyfw__content">
							<template v-if="notice.message">
								<div :class="'puppyfw-notice puppyfw-notice-' + notice.type">
									<span class="dashicons dashicons-yes" v-if="notice.type == 'success'"></span>
									<span class="dashicons dashicons-no" v-if="notice.type == 'error'"></span>
									{{ notice.message }}
								</div>
							</template>

							<template v-for="field in fields">
								<component :is="getComponentName(field.type)" :field="field" :key="field" v-show="field.visible"></component>
							</template>
						</div>

						<div class="puppyfw__footer">
							<div class="puppyfw__actions">
								<button type="button" class="button button-primary" @click="save"><?php esc_html_e( 'Save options', 'puppyfw' ); ?></button>

								<div class="puppyfw__credit">
									<a href="https://github.com/truongwp/puppyfw/" target="_blank">PuppyFW</a>
									by
									<a href="https://truongwp.com/" target="_blank">Truongwp</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * Checks if is setting page.
	 *
	 * @return boolean
	 */
	public function is_screen() {
		return is_admin() && get_current_screen()->id === $this->page_hook;
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue() {
		if ( ! $this->is_screen() ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_style( 'puppyfw-jquery-ui', PUPPYFW_URL . 'assets/lib/jquery-ui/jquery-ui.min.css', array(), '0.1.0' );

		wp_enqueue_style( 'puppyfw', PUPPYFW_URL . 'assets/css/puppyfw.css', array(), '0.4.3' );

		wp_enqueue_editor();
		wp_enqueue_media();

		wp_enqueue_script( 'wp-color-picker-alpha', PUPPYFW_URL . 'assets/js/lib/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '2.1.2', true );

		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'vue' );
		wp_enqueue_script( 'puppyfw' );

		puppyfw()->helper->enqueue_components();

		wp_enqueue_script(
			'puppyfw-page',
			PUPPYFW_URL . 'assets/js/page.js',
			array(
				'puppyfw',
				'jquery',
				'vue',
				'underscore',
				'editor',
				'jquery-ui-sortable',
				'wp-color-picker-alpha',
				'puppyfw-components',
			),
			'0.4.3',
			true
		);

		wp_localize_script( 'puppyfw-page', 'puppyfwPage', array(
			'pageData'  => $this->data,
			'fields'    => $this->fields_array,
			'restNonce' => wp_create_nonce( 'wp_rest' ),
			'endpoint'  => rest_url( REST::ROUTE_NAMESPACE . '/settings' ),
		) );
	}
}
