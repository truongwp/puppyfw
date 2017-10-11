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

				<key-value-control
					:label="puppyfw.i18n.builder.labels.options"
					:add-label="puppyfw.i18n.builder.labels.addOption"
					:options="field.options"
					@addItem="addOption"
					@removeItem="index => removeOption(index)"
				></key-value-control>
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
