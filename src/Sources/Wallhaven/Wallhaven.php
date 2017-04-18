<?php

namespace Arecibo\Sources\Wallhaven;

use Arecibo\Sources\SourceInterface;
use Arecibo\AssetLoader\AssetLoaderInterface;
use Arecibo\Wallpaper\WallpaperInterface;
use Arecibo\Wallpaper\RemoteWallpaper;

class Wallhaven implements SourceInterface {

	/** @var string */
	protected $domain;
	/** @var AssetLoader */
	protected $assetLoader;

	public function __construct( AssetLoaderInterface $assetLoader, $domain = "https://alpha.wallhaven.cc/" ) {
		$this->domain = rtrim($domain, '/').'/';
		$this->assetLoader  = $assetLoader;
	}

	public function identify() {
		return $this->domain;
	}

	/**
	 * Returns a list of optional wallpapers
	 * @return \Arecibo\Wallpaper\WallpaperInterface[]
	 */
	public function listWallpapers() {

		$path = $this->domain;

		$contents = $this->assetLoader->loadAsset( $path );

		preg_match_all( '/\/thumb\/small\/th-([^\"]+)"/', $contents, $matches );
		$images = array_map( function( $img ) {
			return 'https://wallpapers.wallhaven.cc/wallpapers/full/wallhaven-'.$img;
		}, $matches[1]);

		$images = array_values(array_unique( $images ));
		$output = [];
		foreach ( $images as $image ) {
			$output[] = new RemoteWallpaper( $image, $this->assetLoader );
		}
		return $output;
	}

}
