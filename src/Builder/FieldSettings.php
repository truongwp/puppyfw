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
			:options="field.attrs"
			:sortable="false"
			@addItem="addAttr"
			@removeItem="index => removeAttr(index)"
		></key-value-control>
		<?php
	}

	/**
	 * Child fields builder setting.
	 */
	public static function child_fields_builder() {
		?>
		<fields-builder :fields="field.fields"></fields-builder>
		<?php
	}
}
