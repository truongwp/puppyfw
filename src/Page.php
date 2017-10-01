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
	 * Page data.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Array of fields.
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Used field types.
	 *
	 * @var array
	 */
	public static $used_field_types = array();

	/**
	 * Class Page constructor.
	 *
	 * @param array $data Page data.
	 */
	public function __construct( $data ) {
		if ( empty( $data['menu_slug'] ) ) {
			_doing_it_wrong( __METHOD__, esc_html__( 'Menu slug must not be empty.', 'puppyfw' ), esc_html( PUPPYFW_VERSION ) );
			return;
		}

		$data = $this->normalize( $data );
		$this->data = apply_filters( 'puppyfw_normalize_page_data', $data, $this );
	}

	/**
	 * Normalizes page data.
	 *
	 * @param  array $page_data Page data.
	 * @return array
	 */
	protected function normalize( $page_data ) {
		return wp_parse_args( $page_data, array(
			'parent_slug' => '',
			'page_title'  => '',
			'menu_title'  => '',
			'capability'  => 'manage_options',
			'menu_slug'   => '',
			'icon_url'    => '',
			'position'    => 100,
			'fields'      => array(),
			'option_name' => '',
			'hide_header' => false,
		) );
	}

	/**
	 * Page init.
	 */
	public function init() {
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
		$this->build_fields();

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Builds fields array.
	 */
	protected function build_fields() {
		$this->fields = array();
		$fields_data = $this->data['fields'];

		foreach ( $fields_data as $field_data ) {
			$field_data['option_name'] = $this->data['option_name'];
			$field = FieldFactory::get_field( $field_data );
			$this->fields[] = $field->to_array();
		}

		unset( $this->data['fields'] );
	}

	/**
	 * Render page.
	 */
	public function render() {
		?>
		<div class="wrap">
			<div id="puppyfw-app" class="puppyfw-page-<?php echo esc_attr( $this->data['menu_slug'] ); ?>">
				<form>
					<div class="puppyfw">
						<?php if ( ! $this->data['hide_header'] ) : ?>
							<div class="puppyfw__header">
								<div class="puppyfw__title">
									<?php echo esc_html( $this->data['page_title'] ); ?>
								</div>

								<div class="puppyfw__actions">
									<button type="button" class="button button-primary" @click="save"><?php esc_html_e( 'Save options', 'puppyfw' ); ?></button>
								</div>
							</div>
						<?php endif; ?>

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
		return get_current_screen()->id === $this->page_hook;
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue() {
		if ( ! $this->is_screen() ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_editor();
		wp_enqueue_media();

		wp_enqueue_style( 'puppyfw-jquery-ui', PUPPYFW_URL . 'assets/lib/jquery-ui/jquery-ui.min.css', array(), '0.1.0' );

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-sortable' );

		wp_enqueue_style(
			'puppyfw',
			PUPPYFW_URL . 'assets/css/puppyfw.css',
			array(),
			'0.1.0'
		);

		wp_enqueue_script(
			'vue',
			PUPPYFW_URL . 'assets/js/lib/vue.min.js',
			array(),
			'2.4.4',
			true
		);

		wp_enqueue_script(
			'wp-color-picker-alpha',
			PUPPYFW_URL . 'assets/js/lib/wp-color-picker-alpha.min.js',
			array( 'wp-color-picker' ),
			'1.2.2',
			true
		);

		wp_enqueue_script(
			'puppyfw-components',
			PUPPYFW_URL . 'assets/js/components.js',
			array(
				'vue',
				'jquery-ui-datepicker',
			),
			'0.1.0',
			true
		);

		wp_enqueue_script(
			'puppyfw-core',
			PUPPYFW_URL . 'assets/js/core.js',
			array(
				'jquery',
				'vue',
				'underscore',
				'editor',
				'jquery-ui-sortable',
				'wp-color-picker-alpha',
				'puppyfw-components',
			),
			'0.1.0',
			true
		);

		wp_localize_script( 'puppyfw-core', 'PuppyFW', array(
			'pageData'  => $this->data,
			'fields'    => $this->fields,
			'restNonce' => wp_create_nonce( 'wp_rest' ),
			'endpoint'  => rest_url( REST::ROUTE_NAMESPACE . '/settings' ),
			'mapping'   => Helpers::field_vue_component_mapping(),
			'i18n'      => array(
				'saveError' => __( 'Some errors occur when save data.', 'puppyfw' ),
			),
		) );
	}
}
