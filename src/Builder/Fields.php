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
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-checkbox-list-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<?php FieldSettings::field_default(); ?>

				<?php FieldSettings::field_options(); ?>
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-colorpicker-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

				<?php FieldSettings::field_desc(); ?>

				<?php FieldSettings::field_default(); ?>

				<?php FieldSettings::field_attrs(); ?>
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

				<?php FieldSettings::field_attrs(); ?>
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
			</div>
		</script>


		<script type="text/x-template" id="puppyfw-field-edit-group-tpl">
			<div class="field__edit">
				<?php FieldSettings::field_type(); ?>

				<?php FieldSettings::field_id(); ?>

				<?php FieldSettings::field_title(); ?>

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
			</div>
		</script>
		<?php
	}
}