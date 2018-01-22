<?php
/**
 * Builder controls
 *
 * @package PuppyFW\Builder
 */

namespace PuppyFW\Builder;

/**
 * Class Controls
 */
class Controls {

	/**
	 * Class init.
	 */
	public function init() {
		add_action( 'puppyfw_builder_controls_assets', array( $this, 'assets' ) );
		add_action( 'puppyfw_builder_controls_templates', array( $this, 'templates' ) );
	}

	/**
	 * Loads control assets.
	 */
	public function assets() {
		wp_enqueue_script( 'puppyfw-builder-controls', PUPPYFW_URL . 'assets/js/builder/builder-controls.js', array( 'puppyfw-builder' ), '0.3.0', true );
	}

	/**
	 * Prints control templates.
	 */
	public function templates() {
		?>
		<script type="text/x-template" id="puppyfw-text-control-tpl">
			<div class="t-field t-field--inline">
				<label :for="id" class="t-label">{{ label }}</label>
				<input type="text" :id="id" class="t-control" :value="value" @input="$emit('changeValue', $event.target.value)">
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-email-control-tpl">
			<div class="t-field t-field--inline">
				<label :for="id" class="t-label">{{ label }}</label>
				<input type="email" :id="id" class="t-control" :value="value" @input="$emit('changeValue', $event.target.value)">
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-number-control-tpl">
			<div class="t-field t-field--inline">
				<label :for="id" class="t-label">{{ label }}</label>
				<input type="number" :id="id" class="t-control" :value="value" @input="$emit('changeValue', $event.target.value)">
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-textarea-control-tpl">
			<div class="t-field t-field--inline">
				<label :for="id" class="t-label">{{ label }}</label>
				<textarea :id="id" class="t-control" :value="value" @input="$emit('changeValue', $event.target.value)"></textarea>
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-select-control-tpl">
			<div class="t-field t-field--inline">
				<label :for="id" class="t-label">{{ label }}</label>
				<select :id="id" class="t-control" :value="value" @input="$emit('changeValue', $event.target.value)">
					<option v-for="(option, index) in stateOptions" :key="option.baseId" :value="option.key">{{ option.value }}</option>
				</select>
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-checkbox-control-tpl">
			<div class="t-field t-field--inline">
				<label :for="id" class="t-label">{{ label }}</label>
				<div class="t-control">
					<input type="checkbox" :id="id" :checked="value" @change="$emit('changeValue', $event.target.checked)">
				</div>
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-key-value-control-tpl">
			<div class="t-field t-field--inline">
				<label class="t-label">{{ label }}</label>
				<div>
					<div class="key-value-items">
						<div v-for="(item, index) in stateItems" :key="item.baseId" class="key-value-item t-control-group t-control-group--inline">
							<span class="key-value-move dashicons dashicons-menu" v-if="sortable"></span>
							<input type="text" placeholder="key" v-model="item.key">
							<input type="text" placeholder="value" v-model="item.value">
							<a href="#" @click.prevent="removeItem(index)">{{ puppyfw.i18n.builder.labels.remove }}</a>
						</div>
					</div>

					<button type="button" class="button" @click="addItem">{{ addLabel }}</button>
				</div>
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-dependency-control-tpl">
			<div class="t-field t-field--inline">
				<label class="t-label">{{ label }}</label>
				<div>
					<p>
						<?php
						printf(
							/* translators: 1: {{{true}}}, 2: true, 3: {{{false}}}, 4: false, 5: ||| */
							esc_html__( 'Use %1$s for %2$s, %3$s for %4$s and %5$s for array separator.', 'puppyfw' ),
							'<code>{{\'{{{\'}}true}}}</code>',
							'<code>true</code>',
							'<code>{{\'{{{\'}}false}}}</code>',
							'<code>false</code>',
							'<code>|||</code>'
						);
						?>
					</p>

					<div class="key-value-items">
						<div v-for="(rule, index) in stateRules" :key="rule.baseId" class="key-value-rule t-control-group t-control-group--inline">
							<input type="text" placeholder="key" v-model="rule.key">

							<select v-model="rule.operator">
								<option value="==">==</option>
								<option value="!=">!=</option>
								<option value="<">&lt;</option>
								<option value=">">&gt;</option>
								<option value="<=">&lt;=</option>
								<option value=">=">&gt;=</option>
								<option value="CONTAIN">CONTAIN</option>
								<option value="NOT CONTAIN">NOT CONTAIN</option>
								<option value="EMPTY">EMPTY</option>
								<option value="NOT EMPTY">NOT EMPTY</option>
								<option value="IN">IN</option>
								<option value="NOT IN">NOT IN</option>
							</select>

							<input type="text" placeholder="value" v-model="rule.value">
							<a href="#" @click.prevent="removeRule(index)">{{ puppyfw.i18n.builder.labels.remove }}</a>
						</div>
					</div>

					<button type="button" class="button" @click="addRule">{{ addLabel }}</button>
				</div>
			</div>
		</script>
		<?php
	}
}
