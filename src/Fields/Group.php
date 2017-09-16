<?php
/**
 * Field group
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Group class
 */
class Group extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-group">
			<div class="puppyfw-field puppyfw-field--fullwidth puppyfw-group" :id="field.id_attr">
				<div class="puppyfw-group__title">
					<span class="title">{{ field.title }}</span>
					<span class="controls"><slot name="controls"></slot></span>
				</div>

				<div class="puppyfw-group__container">
					<template v-for="childField in field.fields">
						<component :is="getComponentName(childField.type)" :field="childField" :key="childField" v-show="childField.visible"></component>
					</template>

					<div class="puppyfw-field__desc" v-if="field.desc">{{ field.desc }}</div>
				</div>
			</div>
		</script>
		<?php
	}
}
