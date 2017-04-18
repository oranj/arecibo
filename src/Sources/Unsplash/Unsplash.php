<?php

namespace Arecibo\Sources\Unsplash;

use Arecibo\Sources\SourceInterface;
use Arecibo\AssetLoader\AssetLoaderInterface;
use Arecibo\Wallpaper\WallpaperInterface;
use Arecibo\Wallpaper\RemoteWallpaper;

class Unsplash implements SourceInterface {

	/** @var string */
	protected $domain;
	/** @var string */
	protected $handle;
	/** @var AssetLoader */
	protected $assetLoader;

	public function __construct( $handle, AssetLoaderInterface $assetLoader, $domain = "https://unsplash.com" ) {
		$this->handle = '@'.ltrim($handle, '@');
		$this->domain = rtrim($domain, '/').'/';
		$this->assetLoader  = $assetLoader;
	}

	public function identify() {
		return $this->domain . $this->handle;
	}

	/**
	 * Returns a list of optional wallpapers
	 * @return \Arecibo\Wallpaper\WallpaperInterface[]
	 */
	public function listWallpapers() {

		$contents = $this->assetLoader->loadAsset( $this->domain . $this->handle );

		preg_match_all('/\"raw\":\s*\"(.*?)\"/', $contents, $matches);

		$images = array_filter($matches[1], function( $url ) {
			return ! preg_match('/\\\\u/', $url );
		});

		$images = array_values(array_unique( $images ));
		$output = [];
		foreach ( $images as $image ) {
			$output[] = new RemoteWallpaper( $image, $this->assetLoader );
		}
		return $output;
	}

}
