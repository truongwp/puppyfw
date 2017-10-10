<?php
/**
 * Builder meta box
 *
 * @package PuppyFW\Builder
 */

namespace PuppyFW\Builder;

/**
 * Class BuilderMetaBox
 */
class BuilderMetaBox {

	/**
	 * Class init.
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ), 20 );
		add_action( 'admin_footer', array( $this, 'js_templates' ) );
	}

	/**
	 * Gets supported post type.
	 *
	 * @return string
	 */
	protected function post_type() {
		return 'puppyfw_page';
	}

	/**
	 * Registers meta box.
	 *
	 * @param string $post_type Post type.
	 */
	public function register( $post_type ) {
		if ( $this->post_type() !== $post_type ) {
			return;
		}
		add_meta_box(
			'puppyfw-page-builder',
			__( 'Fields builder', 'puppyfw' ),
			array( $this, 'render' ),
			$post_type,
			'advanced'
		);
	}

	/**
	 * Renders meta box.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function render( $post ) {
		$fields = $post->post_content ? json_decode( html_entity_decode( $post->post_content ), true ) : array();
		?>
		<input type="hidden" id="field-data" value="<?php echo esc_attr( wp_json_encode( $fields ) ); ?>">

		<div id="puppyfw-builder">
			{{ fields }}

			<input type="hidden" name="post_content" :value="JSON.stringify(fields)">

			<fields-builder
				:fields="fields"
			></fields-builder>
		</div>
		<?php
	}

	/**
	 * Checks if is builder page.
	 *
	 * @return bool
	 */
	protected function is_active() {
		return $this->post_type() === get_current_screen()->id;
	}

	/**
	 * Enqueues css and js.
	 */
	public function enqueue() {
		if ( ! $this->is_active() ) {
			return;
		}

		wp_enqueue_style( 'puppyfw-builder', PUPPYFW_URL . 'assets/css/builder.css', array(), '0.3.0' );

		wp_enqueue_script( 'puppyfw-builder', PUPPYFW_URL . 'assets/js/builder.js', array( 'puppyfw' ), '0.3.0', true );

		/**
		 * Hook for enqueuing builder controls assets.
		 *
		 * @since 0.3.0
		 */
		do_action( 'puppyfw_builder_controls_assets' );

		/**
		 * Hook for enqueuing builder fields assets.
		 *
		 * @since 0.3.0
		 */
		do_action( 'puppyfw_builder_fields_assets' );

		wp_enqueue_script( 'puppyfw-builder-app', PUPPYFW_URL . 'assets/js/builder-app.js', array( 'puppyfw-builder', 'vue' ), '0.3.0', true );
	}

	/**
	 * Prints js templates.
	 */
	public function js_templates() {
		if ( ! $this->is_active() ) {
			return;
		}

		/**
		 * Hook for priting builder controls js templates.
		 *
		 * @since 0.3.0
		 */
		do_action( 'puppyfw_builder_controls_templates' );

		/**
		 * Hook for priting builder fields js templates.
		 *
		 * @since 0.3.0
		 */
		do_action( 'puppyfw_builder_fields_templates' );
		?>
		<script type="text/x-template" id="puppyfw-fields-builder-tpl">
			<div class="fields-builder">
				<field-item
					v-for="field in fields"
					:key="field.baseId"
					:field="field"
					@removeField="removeField(field)"
					@cloneField="cloneField(field)"
				></field-item>

				<button type="button" class="button" @click="addField"><?php esc_html_e( '+ Add field', 'puppyfw' ); ?></button>
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-field-item-tpl">
			<div class="field">
				<field-item-heading
					:field="field"
					@toggleEditing="toggleEditing"
					@removeField="$emit('removeField')"
					@cloneField="$emit('cloneField')"
				></field-item-heading>

				<component :is="puppyfw.helper.getTypeEditComponent(field.type)" :field="field" v-show="editing"></component>
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-field-item-heading-tpl">
			<div class="field__heading" @click.prevent="$emit('toggleEditing')">
				<div>
					<div class="field__title">{{ field.title }}</div>
					<div class="field__id">ID: {{ field.id }}</div>
				</div>

				<div>
					<span class="field__type">{{ field.type }}</span>
					<span class="field__control">
						<a href="#" class="edit"><?php esc_html_e( 'Edit', 'puppyfw' ); ?></a> |
						<a href="#" class="clone" @click.prevent.stop="$emit('cloneField')"><?php esc_html_e( 'Clone', 'puppyfw' ); ?></a> |
						<a href="#" class="remove" @click.prevent.stop="$emit('removeField')"><?php esc_html_e( 'Delete', 'puppyfw' ); ?></a>
					</span>
				</div>
			</div>
		</script>
		<?php
	}
}
