<?php
/**
 * Post meta storage
 *
 * @package PuppyFW\Storages
 * @since 1.0.0
 */

namespace PuppyFW\Storages;

/**
 * PostMeta class
 */
class PostMeta implements Storage {
    
    /**
     * Post ID.
     *
     * @var int
     */
    protected $post_id = 0;
    
    /**
     * PostMeta constructor.
     * 
     * @param int $post_id Post ID.
     */
    public function __construct( $post_id = '' ) {
        if ( $post_id ) {
            $this->set_post_id( $post_id );
        }
    }
    
    /**
     * Sets post ID.
     * 
     * @param int $post_id Post ID.
     */
    public function set_post_id( $post_id ) {
        $this->post_id = intval( $post_id );
    }

	/**
	 * Adds a value.
	 *
	 * @param string $name  Name.
	 * @param mixed  $value Value.
	 */
	public function add( $name, $value ) {
		return add_post_meta( $this->post_id, $name, $value );
	}

	/**
	 * Updates a value.
	 *
	 * @param string $name  Name.
	 * @param mixed  $value Value.
	 */
	public function update( $name, $value ) {
		return update_post_meta( $this->post_id, $name, $value );
	}

	/**
	 * Gets a value.
	 *
	 * @param string $name    Name.
	 * @param mixed  $default Default value.
	 * @return mixed          Value.
	 */
	public function get( $name, $default = '' ) {
		$value = get_post_meta( $this->post_id, $name, true );
		if ( ! $this->post_id || '' === $value ) {
		    $value = $default;
		}
		return $value;
	}

	/**
	 * Deletes a value.
	 *
	 * @param string $name Name.
	 */
	public function delete( $name ) {
		return delete_post_meta( $this->post_id, $name );
	}
}
