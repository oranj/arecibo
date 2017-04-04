<?php

namespace Arecibo\AssetLoader;

use Arecibo\Cache\CacheInterface;

class CachingVirtualProxy implements AssetLoaderInterface {

	/** @var AssetLoaderInterface */
	protected $proxy;
	/** @var CacheInterface */
	protected $cache;

	public function __construct( CacheInterface $cache, AssetLoaderInterface $proxy ) {
		$this->cache = $cache;
		$this->proxy = $proxy;
	}

	/**
	 * Loads an asset
	 * @param  string $path
	 * @return string
	 */
	public function loadAsset( $path ) {
		$key = md5( $path );
		if ( ! $this->cache->has( $key )) {
			$contents = $this->proxy->loadAsset( $path );
			$this->cache->set( $key, $contents );
		}
		return $this->cache->get( $key );
	}
}
