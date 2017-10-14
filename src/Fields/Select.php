<?php
/**
 * Field select
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Select class
 */
class Select extends Choice {

	/**
	 * Flag to check if field support none option.
	 *
	 * @var bool
	 */
	protected $support_none_option = true;

	/**
	 * Normalize field data.
	 *
	 * @param  array $field_data Field data.
	 * @return array
	 */
	protected function normalize( $field_data ) {
		$field_data = parent::normalize( $field_data );

		if ( ! empty( $field_data['multiple'] ) ) {
			$field_data['attrs']['multiple'] = true;
		}

		return $field_data;
	}

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-select">
			<div class="puppyfw-field puppyfw-select">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<select v-bind="field.attrs" :id="field.id_attr" v-model="field.value" @input="field.value = $event.target.value">
						<template v-for="option in field.options">
							<option :value="option.key">{{ option.value }}</option>
						</template>
					</select>

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
