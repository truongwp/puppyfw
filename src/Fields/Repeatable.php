<?php
/**
 * Field repeatable
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

use PuppyFW\FieldFactory;

/**
 * Repeatable class
 */
class Repeatable extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-repeatable">
			<div class="puppyfw-field puppyfw-field--fullwidth puppyfw-repeatable" :id="field.id_attr">
				<div v-for="(cField, index) in field.repeatFields" class="puppyfw-repeatable__item" :data-index="index" :key="cField.id_attr">
					<component :is="getComponentName(cField.type)" :field="cField">
						<a class="puppyfw-repeatable-remove" href="#" slot="controls" @click.prevent="removeItem(index)"><span class="puppyfw-remove"></span></a>
					</component>
				</div>

				<button type="button" class="button puppyfw-repeatable__button" @click="addItem"><?php esc_html_e( '+ Add', 'puppyfw' ); ?></button>
			</div>
		</script>
		<?php
	}

	/**
	 * Converts field to array.
	 * This method will be called recursive.
	 *
	 * @return array
	 */
	public function to_array() {
		$data = parent::to_array();

		if ( empty( $data ) ) {
			return $data;
		}

		$repeat_field = $data;
		$repeat_field['page'] = $this->page;
		$repeat_field['type'] = $repeat_field['repeat_field_type'];
		unset( $repeat_field['repeat_field_type'] );
		$repeat_field['repeatable'] = false;
		$repeat_field = FieldFactory::get_field( $repeat_field );
		$data['repeat_field'] = $repeat_field->to_array();

		return $data;
	}
}
