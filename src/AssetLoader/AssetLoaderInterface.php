<?php

namespace Arecibo\AssetLoader;

interface AssetLoaderInterface {

	/**
	 * Loads an asset
	 * @param  string $path
	 * @return string
	 */
	public function loadAsset( $path );

}
