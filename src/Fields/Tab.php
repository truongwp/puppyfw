<?php
/**
 * Field tab
 *
 * @package PuppyFW\Fields
 */

namespace PuppyFW\Fields;

/**
 * Tab class
 */
class Tab extends Field {

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-tab">
			<div class="puppyfw-field puppyfw-field--fullwidth puppyfw-tab" :id="field.id_attr">
				<ul class="puppyfw-tab__titles">
					<li v-for="(tab, key) in field.tabs" :class="{ 'active': key == currentTab }">
						<a :href="'#' + getTabId(key)" @click.prevent="activeTab(key)">{{ tab }}</a>
					</li>
				</ul>

				<span class="controls"><slot name="controls"></slot></span>

				<div class="puppyfw-tab__panes">
					<template v-for="(tab, key) in field.tabs">
						<div :id="getTabId(key)" class="puppyfw-tab__pane" v-show="key == currentTab">
							<template v-for="childField in field.fields" v-if="key == childField.tab">
								<component :is="getComponentName(childField.type)" :field="childField" v-show="childField.visible"></component>
							</template>
						</div>
					</template>
				</div>
			</div>
		</script>
		<?php
	}
}
