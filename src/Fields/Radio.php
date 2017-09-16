<?php
/**
 * Field radio
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Radio class
 */
class Radio extends Choice {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-radio">
			<div class="puppyfw-field puppyfw-radio">
				<label :for="'puppyfw-' + field.id" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control" :class="{ 'inline': field.inline }">
					<label v-for="option in field.options">
						<input type="radio" :value="option.key" v-model="field.value"> {{ option.value }}
					</label>

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
