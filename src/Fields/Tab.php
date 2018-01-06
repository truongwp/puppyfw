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
	 * Check if this field has value.
	 *
	 * @var bool
	 */
	protected $has_value = false;

	/**
	 * Normalize field data.
	 *
	 * @param  array $field_data Field data.
	 * @return array
	 */
	protected function normalize( $field_data ) {
		$field_data = parent::normalize( $field_data );
		$field_data['vertical'] = ! empty( $field_data['vertical'] );
		return $field_data;
	}

	/**
	 * Adds tab.
	 *
	 * @since 0.3.0
	 *
	 * @param string $tab_id    Tab ID.
	 * @param string $tab_title Tab title.
	 */
	public function add_tab( $tab_id, $tab_title ) {
		$this->data['tabs'][ $tab_id ] = $tab_title;
	}

	/**
	 * Render js template.
	 */
	public function js_template() {
		?>
		<script type="text/x-template" id="puppyfw-field-template-tab">
			<div class="puppyfw-field puppyfw-field--fullwidth puppyfw-tab" :class="{ 'puppyfw-tab--vertical': field.vertical }" :id="field.id_attr">
				<ul class="puppyfw-tab__titles">
					<li v-for="(tab, index) in tabs" :key="tab.baseId" :class="{ 'active': tab.key == currentTab }">
						<a :href="'#' + getTabId(tab.key)" @click.prevent="activeTab(tab.key)">{{ tab.value }}</a>
					</li>
				</ul>

				<span class="controls"><slot name="controls"></slot></span>

				<div class="puppyfw-tab__panes">
					<template v-for="(tab, index) in tabs" :key="tab.baseId">
						<div :id="getTabId(tab.key)" class="puppyfw-tab__pane" v-show="tab.key == currentTab">
							<template v-for="childField in field.fields" :key="childField.id_attr" v-if="tab.key == childField.tab">
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
