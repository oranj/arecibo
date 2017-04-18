<?php

namespace Arecibo\Wallpaper;

use Arecibo\AssetLoader\AssetLoaderInterface;
use Arecibo\AssetStorage\AssetStorageInterface;

class RemoteWallpaper implements WallpaperInterface {

	/** @var string  */
	protected $sourceUrl;

	/** @var AssetLoaderInterface */
	protected $assetLoader;

	public function __construct( $sourceUrl, AssetLoaderInterface $assetLoader ) {

		$this->sourceUrl = $sourceUrl;
		$this->assetLoader = $assetLoader;

	}

	public function getSourceUrl() {
		return $this->sourceUrl;
	}

	public function getContents() {
		return $this->assetLoader->loadAsset( $this->sourceUrl );
	}

}