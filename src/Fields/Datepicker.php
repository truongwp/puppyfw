<?php
/**
 * Datepicker field
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Class Datepicker
 */
class Datepicker extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-datepicker">
			<div class="puppyfw-field puppyfw-datepicker">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<puppyfw-datepicker-input
						v-bind="field.attrs"
						:value="field.value"
						:options="field.js_options"
						@changed-date="(value) => { field.value = value }"
					></puppyfw-datepicker-input>

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
