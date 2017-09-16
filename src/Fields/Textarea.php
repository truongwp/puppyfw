<?php
/**
 * Field textarea
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Textarea class
 */
class Textarea extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-textarea">
			<div class="puppyfw-field puppyfw-textarea">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<textarea v-bind="field.attrs" :id="field.id_attr" :value="field.value" @input="field.value = $event.target.value"></textarea>

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions">
					<slot name="controls"></slot>
				</div>
			</div>
		</script>
		<?php
	}
}
