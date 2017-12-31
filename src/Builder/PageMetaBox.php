<?php
/**
 * Page meta box
 *
 * @package PuppyFW\Builder
 */

namespace PuppyFW\Builder;

use PuppyFW\Helpers;

/**
 * Class PageMetaBox
 */
class PageMetaBox {

	/**
	 * Class init.
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
		$this->add_save_handle();
	}

	/**
	 * Gets supported post type.
	 *
	 * @return string
	 */
	protected function post_type() {
		return 'puppyfw_page';
	}

	/**
	 * Adds saving handle.
	 */
	protected function add_save_handle() {
		add_action( "save_post_{$this->post_type()}", array( $this, 'save' ) );
	}

	/**
	 * Removes saving handle.
	 */
	protected function remove_save_handle() {
		remove_action( "save_post_{$this->post_type()}", array( $this, 'save' ) );
	}

	/**
	 * Registers meta box.
	 *
	 * @param string $post_type Post type name.
	 */
	public function register( $post_type ) {
		if ( $this->post_type() !== $post_type ) {
			return;
		}

		add_meta_box(
			'puppyfw-page',
			__( 'Page settings', 'puppyfw' ),
			array( $this, 'render' ),
			$post_type,
			'side',
			'high'
		);
	}

	/**
	 * Renders meta box.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function render( $post ) {
		wp_nonce_field( 'puppyfw_page_meta_box', 'puppyfw_page_meta_box_nonce' );
		$page_data = $post->post_excerpt ? json_decode( html_entity_decode( $post->post_excerpt ), true ) : array();
		$page_data = puppyfw()->helper->normalize_page( $page_data );
		?>
		<p>
			<label for="puppyfw-page-title"><?php esc_html_e( 'Page title', 'puppyfw' ); ?></label>
			<input type="text" id="puppyfw-page-title" name="puppyfw_page[page_title]" class="widefat" value="<?php echo esc_attr( $page_data['page_title'] ); ?>" required>
		</p>

		<p>
			<label for="puppyfw-menu-title"><?php esc_html_e( 'Menu title', 'puppyfw' ); ?></label>
			<input type="text" id="puppyfw-menu-title" name="puppyfw_page[menu_title]" class="widefat" value="<?php echo esc_attr( $page_data['menu_title'] ); ?>" required>
		</p>

		<p>
			<label for="puppyfw-menu-slug"><?php esc_html_e( 'Menu slug', 'puppyfw' ); ?></label>
			<input type="text" id="puppyfw-menu-slug" name="puppyfw_page[menu_slug]" class="widefat" value="<?php echo esc_attr( $page_data['menu_slug'] ); ?>" required>
		</p>

		<p>
			<label for="puppyfw-capability"><?php esc_html_e( 'Capability', 'puppyfw' ); ?></label>
			<input type="text" id="puppyfw-capability" name="puppyfw_page[capability]" class="widefat" value="<?php echo esc_attr( $page_data['capability'] ); ?>" required>
		</p>

		<p>
			<label for="puppyfw-parent-slug"><?php esc_html_e( 'Parent slug', 'puppyfw' ); ?></label>
			<input type="text" id="puppyfw-parent-slug" name="puppyfw_page[parent_slug]" class="widefat" value="<?php echo esc_attr( $page_data['parent_slug'] ); ?>">
		</p>

		<p>
			<label for="puppyfw-icon-url"><?php esc_html_e( 'Icon url', 'puppyfw' ); ?></label>
			<input type="text" id="puppyfw-icon-url" name="puppyfw_page[icon_url]" class="widefat" value="<?php echo esc_attr( $page_data['icon_url'] ); ?>">
		</p>

		<p>
			<label for="puppyfw-position"><?php esc_html_e( 'Position', 'puppyfw' ); ?></label>
			<input type="number" id="puppyfw-position" name="puppyfw_page[position]" class="widefat" value="<?php echo intval( $page_data['position'] ); ?>">
		</p>

		<p>
			<label for="puppyfw-option-name"><?php esc_html_e( 'Option name', 'puppyfw' ); ?></label>
			<input type="text" id="puppyfw-option-name" name="puppyfw_page[option_name]" class="widefat" value="<?php echo esc_attr( $page_data['option_name'] ); ?>">
		</p>
		<?php
	}

	/**
	 * Saves data.
	 *
	 * @param int $post_id Post ID.
	 */
	public function save( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['puppyfw_page_meta_box_nonce'] ) ) {
			return;
		}

		$nonce = $_POST['puppyfw_page_meta_box_nonce']; // WPCS: sanitization, csrf ok.

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'puppyfw_page_meta_box' ) ) {
			return;
		}

		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( empty( $_POST['puppyfw_page'] ) ) {
			return;
		}

		$this->remove_save_handle();

		$page_data = wp_unslash( $_POST['puppyfw_page'] ); // WPCS: sanitization ok.
		$page_data = puppyfw()->helper->normalize_page( $page_data );
		$page_data = wp_json_encode( $page_data, JSON_UNESCAPED_UNICODE );

		wp_update_post( array(
			'ID'           => $post_id,
			'post_excerpt' => $page_data,
		) );

		$this->add_save_handle();
	}
}
