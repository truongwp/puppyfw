<?php
/**
 * Html field
 *
 * @package PuppyFW\Fields
 * @since 0.1.2
 */

namespace PuppyFW\Fields;

/**
 * Class Html
 */
class Html extends Field {

	/**
	 * Check if this field has value.
	 *
	 * @var bool
	 */
	protected $has_value = false;

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
