<?php
/**
 * Field input
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Input class
 */
class Input extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-input">
			<div class="puppyfw-field puppyfw-input">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<input v-bind="field.attrs" :type="field.type" :id="field.id_attr" :value="field.value" @input="field.value = $event.target.value">

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
