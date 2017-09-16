<?php
/**
 * Field checkbox
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Checkbox class
 */
class Checkbox extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-checkbox">
			<div class="puppyfw-field puppyfw-checkbox">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<input type="checkbox" :id="field.id_attr" value="1" v-model="field.value">

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
