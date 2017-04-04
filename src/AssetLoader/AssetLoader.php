<?php

namespace Arecibo\AssetLoader;

class AssetLoader implements AssetLoaderInterface {

	/**
	 * Loads an asset
	 * @param  string $path
	 * @return string
	 */
	public function loadAsset( $path ) {
		return file_get_contents( $path );
	}
}
