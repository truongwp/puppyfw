<?php
/**
 * Field checkbox list
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * CheckboxList class
 */
class CheckboxList extends Choice {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-checkbox-list">
			<div class="puppyfw-field puppyfw-checkbox-list">
				<label :for="'puppyfw-' + field.id" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control" :class="{ 'inline': field.inline }">
					<label v-for="option in field.options" :key="option.baseId">
						<input type="checkbox" :value="option.key" v-model="field.value"> {{ option.value }}
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
