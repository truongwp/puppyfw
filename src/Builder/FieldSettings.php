<?php

namespace PuppyFW\Builder;

/**
 * Class FieldSettings
 */
class FieldSettings {

	/**
	 * Field ID setting.
	 */
	public static function field_id() {
		?>
		<text-control
			:id="field.baseId + '-id'"
			:label="puppyfw.i18n.builder.labels.id"
			:value="field.id"
			@changeValue="value => field.id = value"
		></text-control>
		<?php
	}

	/**
	 * Field title setting.
	 */
	public static function field_title() {
		?>
		<text-control
			:id="field.baseId + '-title'"
			:label="puppyfw.i18n.builder.labels.title"
			:value="field.title"
			@changeValue="value => field.title = value"
		></text-control>
		<?php
	}

	/**
	 * Field description setting.
	 */
	public static function field_desc() {
		?>
		<textarea-control
			:id="field.baseId + '-desc'"
			:label="puppyfw.i18n.builder.labels.description"
			:value="field.desc"
			@changeValue="value => field.desc = value"
		></textarea-control>
		<?php
	}

	/**
	 * Field type setting.
	 */
	public static function field_type() {
		?>
		<select-control
			:id="field.baseId + '-type'"
			:label="puppyfw.i18n.builder.labels.type"
			:value="field.type"
			:options="puppyfw.builder.types"
			@changeValue="value => field.type = value"
		></select-control>
		<?php
	}

	/**
	 * Field default setting.
	 */
	public static function field_default() {
		?>
		<text-control
			:id="field.baseId + '-default'"
			:label="puppyfw.i18n.builder.labels.default"
			:value="field.default"
			@changeValue="value => field.default = value"
		></text-control>
		<?php
	}

	/**
	 * Field attributes setting.
	 */
	public static function field_attrs() {
		?>
		<key-value-control
			:label="puppyfw.i18n.builder.labels.attributes"
			:add-label="puppyfw.i18n.builder.labels.addAttribute"
			:items="field.attrs"
			:sortable="false"
			@changeValue="value => field.attrs = value"
		></key-value-control>
		<?php
	}

	/**
	 * Field js options setting.
	 */
	public static function field_js_options() {
		?>
		<key-value-control
			:label="puppyfw.i18n.builder.labels.js_options"
			:add-label="puppyfw.i18n.builder.labels.addOption"
			:items="field.js_options"
			:sortable="false"
			@changeValue="value => field.js_options = value"
		></key-value-control>
		<?php
	}

	/**
	 * Field options setting.
	 */
	public static function field_options() {
		?>
		<key-value-control
			:label="puppyfw.i18n.builder.labels.options"
			:add-label="puppyfw.i18n.builder.labels.addOption"
			:items="field.options"
			:sortable="false"
			@changeValue="value => field.options = value"
		></key-value-control>
		<?php
	}

	/**
	 * Field repeatable setting.
	 */
	public static function field_repeatable() {
		?>
		<checkbox-control
			:id="field.baseId + '-repeatable'"
			:label="puppyfw.i18n.builder.labels.repeatable"
			:value="field.repeatable"
			@changeValue="value => field.repeatable = value"
		></checkbox-control>
		<?php
	}

	/**
	 * Field tab setting.
	 */
	public static function field_tab() {
		?>
		<select-control
			v-show="tabs.length"
			:id="field.baseId + '-tab'"
			:label="puppyfw.i18n.builder.labels.tab"
			:value="field.tab"
			:options="tabs"
			@changeValue="value => field.tab = value"
		></select-control>
		<?php
	}

	/**
	 * Field dependency setting.
	 */
	public static function field_dependency() {
		?>
		<dependency-control
			:label="puppyfw.i18n.builder.labels.dependency"
			:addLabel="puppyfw.i18n.builder.labels.addRule"
			:rules="field.dependency"
			@changeValue="value => field.dependency = value"
		></dependency-control>
		<?php
	}

	/**
	 * Child fields builder setting.
	 */
	public static function child_fields_builder() {
		?>
		<div class="t-field t-field--inline">
			<label :for="field.baseId" class="t-label">{{ puppyfw.i18n.builder.labels.fields }}</label>
			<div class="t-control">
				<fields-builder :fields="field.fields" :tabs="field.tabs"></fields-builder>
			</div>
		</div>
		<?php
	}
}
