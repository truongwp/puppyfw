<?php
/**
 * Field image
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Class Image
 */
class Image extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-image">
			<div class="puppyfw-field puppyfw-image">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<div v-if="field.value.url" class="puppyfw-image-preview">
						<img :src="field.value.url" alt="">
					</div>

					<input type="url" size="50" :value="field.value.url" @input="field.value.url = $event.target.value">
					<button type="button" class="button button-secondary" @click="upload"><?php esc_html_e( 'Upload', 'puppyfw' ); ?></button>
					<button type="button" class="button button-secondary" v-if="field.value.url" @click="remove"><?php esc_html_e( 'Remove', 'puppyfw' ); ?></button>
					<input type="hidden" :value="field.value.id" @input="field.value.id = $event.target.value">

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
