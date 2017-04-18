<?php

namespace Arecibo;

use Arecibo\Sources\SourceInterface;
use Arecibo\System\SystemInterface;
use Arecibo\AssetLoader\AssetLoaderInterface;
use Arecibo\AssetStorage\AssetStorageInterface;
use Arecibo\Wallpaper\Wallpaper;
use Arecibo\Wallpaper\WallpaperInterface;

class Arecibo {

	/** @var SourceInterface[] */
	protected $sources = array();

	/** @var SystemInterface */
	protected $system;

	/** @var AssetLoaderInterface */
	protected $assetLoader;

	/** @var AssetStorageInterface */
	protected $assetStorage;

	/** @var int */
	protected $minimumWidth = 0;

	/** @var int */
	protected $maximumHeight = 0;

	public function __construct( SystemInterface $system, AssetLoaderInterface $assetLoader, AssetStorageInterface $assetStorage ) {
		$this->system       = $system;
		$this->assetLoader  = $assetLoader;
		$this->assetStorage = $assetStorage;
	}

	public function addSource( SourceInterface $source ) {
		$this->sources[] = $source;
	}

	public function setMinimumSize( $width, $height ) {
		$this->minimumWidth = $width;
		$this->minimumHeight = $height;
	}

	public function getRandomWallpaper() {
		$source = $this->sources[ array_rand( $this->sources ) ];
		echo "Using source: ". $source->identify() . "\n";
		$wallpapers = $source->listWallpapers();

		if ( empty( $wallpapers )) {
			throw new \Exception("No wallpapers found");
		}

		return $wallpapers[ array_rand( $wallpapers )];
	}

	protected function storeWallpaper( WallpaperInterface $wallpaper ) {
		$key = md5( $wallpaper->getSourceUrl() );
		if ( ! $this->assetStorage->exists( $key )) {
			$this->assetStorage->write( $key, $wallpaper->getContents() );
		}
		return $this->assetStorage->fullPath( $key );
	}

	public function setRandomWallpaper() {
		$wallpaper = $this->getRandomWallpaper();
		$path = $this->storeWallpaper( $wallpaper );

		list ($width, $height) = getimagesize( $path );

		if ( $width < $this->minimumWidth || $height < $this->minimumHeight ) {
			throw new \Exception("Image too small.");
		}

		$this->system->setWallpaper( $path );
	}

	public function runOnTimer( $seconds ) {
		while ( true ) {
			try {
				$this->setRandomWallpaper();
				sleep( $seconds );
			} catch ( \Exception $e ){
				echo $e->getMessage(), PHP_EOL;
			}
		}
	}
}
