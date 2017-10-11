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
		wp_enqueue_script( 'puppyfw-builder-controls', PUPPYFW_URL . 'assets/js/builder-controls.js', array( 'puppyfw-builder' ), '0.3.0', true );
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
					<option v-for="(value, key) in options" :key="key" :value="key">{{ value }}</option>
				</select>
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-checkbox-control-tpl">
			<div class="t-field t-field--inline">
				<label :for="id" class="t-label">{{ label }}</label>
				<input type="checkbox" :id="id" :checked="value" @change="$emit('changeValue', $event.target.checked)">
			</div>
		</script>

		<script type="text/x-template" id="puppyfw-key-value-control-tpl">
			<div class="t-field t-field--inline">
				<label class="t-label">{{ label }}</label>
				<div>
					<div v-for="(option, index) in options" :key="index">
						<input type="text" placeholder="key" v-model="option.key">
						<input type="text" placeholder="value" v-model="option.value">
						<a href="#" @click.prevent="$emit('removeItem', index)">{{ puppyfw.i18n.builder.labels.remove }}</a>
					</div>
					<button type="button" class="button" @click="$emit('addItem')">{{ addLabel }}</button>
				</div>
			</div>
		</script>

		<!-- <script type="text/x-template" id="puppyfw-choice-control-tpl">
			<div class="t-field t-field--inline">
				<label class="t-label">{{ label }}</label>
				<div>
					<table>
						<thead>
							<tr>
								<th>{{ puppyfw.i18n.builder.labels.key }}</th>
								<th>{{ puppyfw.i18n.builder.labels.value }}</th>
								<th>{{ puppyfw.i18n.builder.labels.default }}</th>
								<th>&nbsp;</th>
							</tr>
						</thead>

						<tbody>
							<tr v-for="(option, index) in options" :key="index">
								<td>
									<input type="text" placeholder="key" v-model="option.key">
								</td>

								<td>
									<input type="text" placeholder="value" v-model="option.value">
								</td>

								<td>
									<input type="radio" :name="id">
								</td>

								<td>
									<a href="#" @click.prevent="$emit('removeItem', index)">{{ puppyfw.i18n.builder.labels.remove }}</a>
								</td>
							</tr>
						</tbody>
					</table>

					<button type="button" class="button" @click="$emit('addItem')">+ Add choice</button>
				</div>
			</div>
		</script> -->
		<?php
	}
}
