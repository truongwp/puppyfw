<?php
/**
 * Field images
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Class Images
 */
class Images extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-images">
			<div class="puppyfw-field puppyfw-images">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<div class="puppyfw-images__preview">
						<div v-for="(item, index) in field.value" class="puppyfw-images__item" :key="item" :data-id="item.id">
							<img :src="item.url" alt="">
							<a href="#" class="puppyfw-images__remove" @click.prevent="remove(index)"><span class="puppyfw-remove"></span></a>
						</div>
					</div>

					<button type="button" class="button button-secondary" @click="upload"><?php esc_html_e( '+ Add image', 'puppyfw' ); ?></button>
					<button type="button" class="button button-secondary" v-if="field.value.length" @click="removeAll"><?php esc_html_e( 'Remove all', 'puppyfw' ); ?></button>

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
