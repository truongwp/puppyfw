<?php
/**
 * HTML field
 *
 * @package PuppyFW\Fields
 * @since 0.1.2
 */

namespace PuppyFW\Fields;

/**
 * Class HTML
 */
class HTML extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-html">
			<div v-bind="field.attrs" v-html="field.content"></div>
		</script>
		<?php
	}
}
