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
	 * MetaBox constructor.
	 *
	 * @param array $data Meta box data.
	 */
	public function __construct( $data ) {
		parent::__construct( $data );
		if ( ! empty( $data['post_id'] ) ) {
			$this->storage->set_post_id( $data['post_id'] );
		}
	}

	/**
	 * Gets meta box identity.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->data['id'];
	}

	/**
	 * Initializes storage.
	 */
	protected function init_storage() {
		$this->storage = new Storages\PostMeta();
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
			array( $this, 'render_meta_box' ),
			$this->data['screen'],
			$this->data['context'],
			$this->data['priority'],
			$this->data['callback_args']
		);
	}

	/**
	 * Render meta box.
	 *
	 * @param \WP_Post $post Post object.
	 */
	public function render_meta_box( $post ) {
		?>
		<div id="puppyfw-app" class="puppyfw-page-<?php echo esc_attr( $this->get_id() ); ?>">
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
				</div>
			</div>

			<input type="hidden" name="_puppyfw_page_data" value="<?php echo esc_attr( wp_json_encode( $this->data ) ); ?>">
			<input type="hidden" name="_puppyfw_save_data" :value="JSON.stringify(getSaveData())">
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
		$this->storage->set_post_id( $this->get_post_id() );
		parent::load();
	}

	/**
	 * Gets post ID in edit post page.
	 * This is copy from `wp-admin\post.php` file.
	 *
	 * @return int
	 */
	protected function get_post_id() {
		if ( isset( $_GET['post'] ) ) {
			$post_id = (int) $_GET['post'];
		} elseif ( isset( $_POST['post_ID'] ) ) { // WPCS: csrf ok.
			$post_id = (int) $_POST['post_ID'];
		} else {
			$post_id = 0;
		}
		return $post_id;
	}

	/**
	 * Checks if is setting page.
	 *
	 * @return boolean
	 */
	public function is_screen() {
		return is_admin() && in_array( get_current_screen()->id, $this->data['screen'] );
	}

	/**
	 * Checks permission when save.
	 *
	 * @return true|WP_Error Return true on success, WP_Error object on failure.
	 */
	public function check_permission() {
		// TODO.
		return true;
	}
}
