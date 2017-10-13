<?php
/**
 * Field input
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Map class
 */
class Map extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-map">
			<div class="puppyfw-field puppyfw-map">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<puppyfw-element-map
						:lat="field.value.lat"
						:lng="field.value.lng"
						:formatted_address="field.value.formatted_address"
						@changeCenter="value => field.value = value"
					></puppyfw-element-map>

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
