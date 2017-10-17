<?php
/**
 * Field repeatable
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

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
					<component :is="getComponentName(cField.type)" :field="cField" v-show="field.visible">
						<a class="puppyfw-repeatable-remove" href="#" slot="controls" @click.prevent="removeItem(index)"><span class="puppyfw-remove"></span></a>
					</component>
				</div>

				<button type="button" class="button puppyfw-repeatable__button" @click="addItem"><?php esc_html_e( '+ Add', 'puppyfw' ); ?></button>
			</div>
		</script>
		<?php
	}
}
