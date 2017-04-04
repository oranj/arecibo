<?php

namespace Arecibo\Cache;

use Arecibo\AssetStorage\AssetStorageInterface;

class AssetStorageCache implements CacheInterface {

	const KEY_EXPIRES = 'expires';

	protected $assetStorage;
	protected $digestFile;
	protected $digest;
	protected $ttl;

	public function __construct( AssetStorageInterface $assetStorage, $ttl ) {
		$this->digestFile = 'digest.json';
		$this->ttl = $ttl;
		$this->assetStorage = $assetStorage;
		if ( ! $this->assetStorage->exists( $this->digestFile )) {
			$this->digest = [];
			$this->storeDigest();
		} else {
			$this->loadDigest();
		}
	}

	protected function storeDigest() {
		$this->assetStorage->write( $this->digestFile, json_encode( $this->digest, JSON_PRETTY_PRINT ));
	}

	protected function loadDigest() {
		$this->digest = json_decode($this->assetStorage->read( $this->digestFile ), true);
	}

	/**
	 * Checks if the cache has a value for the key
	 * @param  string  $key
	 * @return boolean
	 */
	public function has( $key ) {
		if ( ! array_key_exists( $key, $this->digest )) {
			return false;
		}
		if ( time() < $this->digest[$key][ self::KEY_EXPIRES ]) {
			return true;
		}
		$this->remove( $key );
		return false;
	}
	/**
	 * Removes the key from the cache
	 * @param  string $key
	 */
	public function remove( $key ) {
		if ( $this->assetStorage->exists( $key )) {
			$this->assetStorage->remove( $key );
		}
		unset($this->digest[ $key ]);
	}

	/**
	 * Gets the value of the key in the cache
	 * @param  string $key
	 * @return string
	 */
	public function get( $key ) {
		return $this->assetStorage->read( $key );
	}

	/**
	 * Stores data associated to a key
	 * @param string $key
	 * @param string $value
	 */
	public function set( $key, $value ) {
		$this->digest[ $key ] = [
			self::KEY_EXPIRES => time() + $this->ttl
		];
		$this->storeDigest();
		$this->assetStorage->write(	$key, $value );
	}


}
