<?php
/**
 * Builder fields
 *
 * @package PuppyFW\Builder
 */

namespace PuppyFW\Builder;

/**
 * Class Fields
 */
class Fields {

	/**
	 * Class init.
	 */
	public function init() {
		add_action( 'puppyfw_builder_fields_assets', array( $this, 'assets' ) );
		add_action( 'puppyfw_builder_fields_templates', array( $this, 'templates' ) );
	}

	/**
	 * Loads field assets.
	 */
	public function assets() {
		wp_enqueue_script( 'puppyfw-builder-fields', PUPPYFW_URL . 'assets/js/builder-fields.js', array( 'puppyfw-builder' ), '0.3.0', true );
	}

	/**
	 * Prints field templates.
	 */
	public function templates() {
		?>
		<script type="text/x-template" id="puppyfw-field-edit-checkbox-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<checkbox-control
					:id="field.baseId + '-default'"
					:label="puppyfw.i18n.builder.labels.default"
					:value="field.default"
					@changeValue="value => field.default = value"
				></checkbox-control>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-choice-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<?php FieldSettings::field_default(); ?>

				<select-control
					:id="field.baseId + '-data-source'"
					:label="puppyfw.i18n.builder.labels.dataSource"
					:value="field.data_source"
					:options="dataSource"
					@changeValue="value => field.data_source = value"
				></select-control>

				<template v-if="field.data_source == 'options'">
					<?php FieldSettings::field_options(); ?>
				</template>

				<template v-else v-if="field.data_source == 'post'">
					<text-control
						:id="field.baseId + '-post-type'"
						:label="puppyfw.i18n.builder.labels.postType"
						:value="field.post_type"
						@changeValue="value => field.post_type = value"
					></text-control>
				</template>

				<template v-else v-if="field.data_source == 'term'">
					<text-control
						:id="field.baseId + '-taxonomy'"
						:label="puppyfw.i18n.builder.labels.taxonomy"
						:value="field.taxonomy"
						@changeValue="value => field.taxonomy = value"
					></text-control>
				</template>

				<text-control
					v-if="supportNoneOption"
					:id="field.baseId + '-none-option'"
					:label="puppyfw.i18n.builder.labels.noneOption"
					:value="field.none_option"
					@changeValue="value => field.none_option = value"
				></text-control>

				<checkbox-control
					:id="field.baseId + '-inline'"
					:label="puppyfw.i18n.builder.labels.inline"
					:value="field.inline"
					@changeValue="value => field.inline = value"
				></checkbox-control>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-colorpicker-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<?php FieldSettings::field_default(); ?>

				<checkbox-control
					:id="field.baseId + '-alpha'"
					:label="puppyfw.i18n.builder.labels.alpha"
					:value="field.alpha"
					@changeValue="value => field.alpha = value"
				></checkbox-control>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-datepicker-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<?php FieldSettings::field_default(); ?>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-editor-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<textarea-control
					:id="field.baseId + '-default'"
					:label="puppyfw.i18n.builder.labels.default"
					:value="field.default"
					@changeValue="value => field.default = value"
				></textarea-control>

				<checkbox-control
					:id="field.baseId + '-quicktags'"
					:label="puppyfw.i18n.builder.labels.quicktags"
					:value="field.quicktags"
					@changeValue="value => field.quicktags = value"
				></checkbox-control>

				<checkbox-control
					:id="field.baseId + '-tinymce'"
					:label="puppyfw.i18n.builder.labels.tinymce"
					:value="field.tinymce"
					@changeValue="value => field.tinymce = value"
				></checkbox-control>

				<checkbox-control
					:id="field.baseId + '-media_buttons'"
					:label="puppyfw.i18n.builder.labels.mediaButtons"
					:value="field.media_buttons"
					@changeValue="value => field.media_buttons = value"
				></checkbox-control>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-email-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<email-control
					:id="field.baseId + '-default'"
					:label="puppyfw.i18n.builder.labels.default"
					:value="field.default"
					@changeValue="value => field.default = value"
				></email-control>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-group-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>

				<?php FieldSettings::child_fields_builder(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-html-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<textarea-control
					:id="field.baseId + '-content'"
					:label="puppyfw.i18n.builder.labels.content"
					:value="field.content"
					@changeValue="value => field.content = value"
				></textarea-control>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-image-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<?php FieldSettings::field_default(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-images-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-map-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<div class="t-field">
					<label class="t-label">{{ puppyfw.i18n.builder.labels.default }}</label>
					<div class="t-control">
						<puppyfw-element-map
							:lat="field.default.lat"
							:lng="field.default.lng"
							:formatted_address="field.default.formatted_address"
							@changeCenter="value => field.default = value"
						></puppyfw-element-map>
					</div>
				</div>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-number-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<number-control
					:id="field.baseId + '-default'"
					:label="puppyfw.i18n.builder.labels.default"
					:value="field.default"
					@changeValue="value => field.default = value"
				></number-control>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-tab-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<key-value-control
					:label="puppyfw.i18n.builder.labels.tabs"
					:add-label="puppyfw.i18n.builder.labels.addTab"
					:items="field.tabs"
					@changeValue="value => field.tabs = value"
				></key-value-control>

				<checkbox-control
					:id="field.baseId + '-vertical'"
					:label="puppyfw.i18n.builder.labels.vertical"
					:value="field.vertical"
					@changeValue="value => field.vertical = value"
				></checkbox-control>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>

				<?php FieldSettings::child_fields_builder(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-tel-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<number-control
					:id="field.baseId + '-default'"
					:label="puppyfw.i18n.builder.labels.default"
					:value="field.default"
					@changeValue="value => field.default = value"
				></number-control>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-text-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<?php FieldSettings::field_default(); ?>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-textarea-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<textarea-control
					:id="field.baseId + '-default'"
					:label="puppyfw.i18n.builder.labels.default"
					:value="field.default"
					@changeValue="value => field.default = value"
				></textarea-control>

				<?php FieldSettings::field_attrs(); ?>

				<?php FieldSettings::field_repeatable(); ?>

				<?php FieldSettings::field_tab(); ?>

				<?php FieldSettings::field_dependency(); ?>
			</div>
		</script>
		<?php
	}
}
