<?php
/**
 * Field editor
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Class Editor
 */
class Editor extends Field {

	/**
	 * Normalize field data.
	 *
	 * @param  array $field_data Field data.
	 * @return array
	 */
	protected function normalize( $field_data ) {
		$field_data = parent::normalize( $field_data );

		if ( ! isset( $field_data['tinymce'] ) ) {
			$field_data['tinymce'] = false;
		}

		if ( ! isset( $field_data['quicktags'] ) ) {
			$field_data['quicktags'] = true;
		}

		if ( ! isset( $field_data['attrs']['rows'] ) ) {
			$field_data['attrs']['rows'] = 8;
		}

		if ( isset( $field_data['attrs']['class'] ) ) {
			$field_data['attrs']['class'] .= ' wp-editor-area';
		} else {
			$field_data['attrs']['class'] = 'wp-editor-area';
		}

		return $field_data;
	}

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-editor">
			<div class="puppyfw-field puppyfw-editor">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<textarea v-bind="field.attrs" :id="field.id_attr" :value="field.value" @input="field.value = $event.target.value"></textarea>

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
