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
	 * Enqueues custom scripts and styles.
	 */
	public function enqueue() {
		wp_enqueue_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDuOALLadUZV06Yroa1SonBWh5coy-RNZc&libraries=places', array(), false, true );
	}

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-map">
			<div class="puppyfw-field puppyfw-map">
				<label :for="field.id_attr" class="puppyfw-field__label">{{ field.title }}</label>

				<div class="puppyfw-field__control">
					<input type="text" size="43" ref="searchInput" :value="field.value ? field.value.formatted_address : ''">
					<button type="button" class="button button-secondary" @click="clearMap"><?php esc_html_e( 'Clear', 'puppyfw' ); ?></button>

					<div class="puppyfw-map-container" ref="map">{{ error }}</div>

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>

				<div class="puppyfw-field__actions"><slot name="controls"></slot></div>
			</div>
		</script>
		<?php
	}
}
