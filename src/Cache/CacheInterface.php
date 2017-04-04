<?php

namespace Arecibo\Cache;

interface CacheInterface {

	/**
	 * Checks if the cache has a value for the key
	 * @param  string  $key
	 * @return boolean
	 */
	public function has( $key );

	/**
	 * Gets the value of the key in the cache
	 * @param  string $key
	 * @return string
	 */
	public function get( $key );

	/**
	 * Stores data associated to a key
	 * @param string $key
	 * @param string $value
	 */
	public function set( $key, $value );

	/**
	 * Removes the key from the cache
	 * @param  string $key
	 */
	public function remove( $key );

}
