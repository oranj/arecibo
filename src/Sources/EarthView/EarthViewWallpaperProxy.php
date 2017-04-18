<?php

namespace Arecibo\Sources\EarthView;

use Arecibo\AssetLoader\AssetLoaderInterface;
use Arecibo\AssetStorage\AssetStorageInterface;
use Arecibo\Wallpaper\WallpaperInterface;

class EarthViewWallpaperProxy implements WallpaperInterface {

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
		$contents = $this->assetLoader->loadAsset( $this->sourceUrl );
		$data = json_decode( $contents, true );
		$dataUri = $data[ 'dataUri' ];

		$encoded = substr( $dataUri, strpos( $dataUri, ',' ) + 1);

		return base64_decode( $encoded );
	}

}