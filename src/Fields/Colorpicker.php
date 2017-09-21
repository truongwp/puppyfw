<?php
/**
 * Colorpicker field
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Class Colorpicker
 */
class Colorpicker extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-colorpicker">
			<div class="puppyfw-field puppyfw-colorpicker">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<input v-bind="field.attrs" class="puppyfw-colorpicker-input" :data-alpha="field.alpha" :id="field.id_attr" type="text" :value="field.value" @input="field.value = $event.target.value">

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
