<?php
/**
 * Builder tools meta box
 *
 * @package PuppyFW\Builder
 */

namespace PuppyFW\Builder;

use PuppyFW\Helpers;

/**
 * Class ToolsMetaBox
 */
class ToolsMetaBox {

	/**
	 * Class init.
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
		add_action( 'puppyfw_builder_assets', array( $this, 'enqueue' ) );
		add_action( 'admin_init', array( $this, 'generate_export_file' ) );
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
	 * Registers meta box.
	 *
	 * @param string $post_type Post type name.
	 */
	public function register( $post_type ) {
		if ( $this->post_type() !== $post_type ) {
			return;
		}

		add_meta_box(
			'puppyfw-builder-tools',
			__( 'Tools', 'puppyfw' ),
			array( $this, 'render' ),
			$post_type,
			'normal',
			'high'
		);
	}

	/**
	 * Renders meta box.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function render( $post ) {
		$export_url = admin_url( '/' );
		$export_url = add_query_arg( array(
			'action' => 'puppyfw-builder-export',
			'id'     => $post->ID,
		), $export_url );
		?>
		<div id="puppyfw-builder-tools">
			<div class="t-field t-field--inline">
				<label class="t-label"><?php esc_html_e( 'Export', 'puppyfw' ); ?></label>
				<div class="t-control">
					<button type="button" class="button" id="puppyfw-copy-code" data-alt-text="<?php esc_html_e( 'Copied!', 'puppyfw' ); ?>"><?php esc_html_e( 'Copy code', 'puppyfw' ); ?></button>
					<a href="<?php echo esc_url( $export_url ); ?>" class="button" target="_blank"><?php esc_html_e( 'Download export file', 'puppyfw' ); ?></a>
					<br>
					<span class="description"><?php esc_html_e( 'You must save options page before exporting.', 'puppyfw' ); ?></span>
					<input type="hidden" id="puppyfw-exported-code" :value="JSON.stringify( $data )">
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Enqueues assets.
	 */
	public function enqueue() {
		wp_enqueue_script( 'clipboard', PUPPYFW_URL . 'assets/js/lib/clipboard.min.js', array(), '1.7.1', true );
		wp_enqueue_script( 'puppyfw-builder-tools', PUPPYFW_URL . 'assets/js/builder-tools.js', array( 'puppyfw-builder-app', 'clipboard' ), '0.4.0', true );
	}

	/**
	 * Generates export file.
	 */
	public function generate_export_file() {
		if ( empty( $_GET['action'] ) || 'puppyfw-builder-export' !== $_GET['action'] || empty( $_GET['id'] ) ) {
			return;
		}

		$post = get_post( $_GET['id'] ); // WPCS: sanitization ok.
		if ( 'puppyfw_page' !== $post->post_type ) {
			return;
		}

		$filename = sprintf(
			'puppyfw-builder-%s-%s.json',
			$post->post_name,
			date( 'Y-m-d-H-i-s' )
		);
		header( 'Content-disposition: attachment; filename=' . $filename );
		header( 'Content-type: application/json' );
		echo $post->post_content; // WPCS: xss ok.
		exit;
	}
}
