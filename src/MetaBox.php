<?php
/**
 * Meta box class
 *
 * @package PuppyFW
 * @since 1.0.0
 */

namespace PuppyFW;

/**
 * MetaBox class
 */
class MetaBox extends Page {
	
	/**
	 * Page type.
	 *
	 * @var string
	 */
	public $type = 'meta_box';

	/**
	 * Gets meta box identity.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->data['id'];
	}

	/**
	 * Registers meta box.
	 */
	public function register() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );

		add_action( 'load-post.php', array( $this, 'load' ) );
		add_action( 'load-post-new.php', array( $this, 'load' ) );
	}

	/**
	 * Register meta box.
	 *
	 * @param string $post_type Post type.
	 */
	public function register_meta_box( $post_type ) {
		if ( ! in_array( $post_type, $this->data['screen'] ) ) {
			return;
		}

		add_meta_box(
			$this->data['id'],
			$this->data['title'],
			array( $this, 'render' ),
			$this->data['screen'],
			$this->data['context'],
			$this->data['priority'],
			$this->data['callback_args']
		);
	}

	/**
	 * Render meta box.
	 */
	public function render() {
		?>
		<div id="puppyfw-app" class="puppyfw-page-<?php echo esc_attr( $this->get_id() ); ?>">
			<form>
				<div class="puppyfw">
					<div class="puppyfw__content">
						<template v-if="notice.message">
							<div :class="'puppyfw-notice puppyfw-notice-' + notice.type">
								<span class="dashicons dashicons-yes" v-if="notice.type == 'success'"></span>
								<span class="dashicons dashicons-no" v-if="notice.type == 'error'"></span>
								{{ notice.message }}
							</div>
						</template>

						<template v-for="field in fields">
							<component :is="getComponentName(field.type)" :field="field" :key="field" v-show="field.visible"></component>
						</template>

						<input type="hidden" name="puppyfw_save_data" :value="JSON.stringify(getSaveData())">
					</div>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Loads page.
	 */
	public function load() {
		if ( ! $this->is_screen() ) {
			return;
		}
		parent::load();
		
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Checks if is setting page.
	 *
	 * @return boolean
	 */
	public function is_screen() {
		return in_array( get_current_screen()->id, $this->data['screen'] );
	}
	
	public function save( $post_id ) {
		
	}
}
