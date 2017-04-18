<?php

namespace Arecibo\Sources\EarthView;

use Arecibo\Sources\SourceInterface;
use Arecibo\AssetLoader\AssetLoaderInterface;
use Arecibo\Wallpaper\WallpaperInterface;

class EarthView implements SourceInterface {

	/** @var string */
	protected $domain;
	/** @var string */
	protected $idFile;
	/** @var AssetLoader */
	protected $assetLoader;
	/** @var int[] */
	protected $ids;

	public function __construct( AssetLoaderInterface $assetLoader, $domain = "https://www.gstatic.com", $idFile = null ) {
		$this->idFile = empty( $idFile ) ? __DIR__.'/ids.json' : $idFile ;
		$this->domain = rtrim($domain, '/').'/';
		$this->assetLoader  = $assetLoader;

		// Request URL:https://www.gstatic.com/prettyearth/assets/data/6150.json

	}

	public function identify() {
		return $this->domain;
	}

	private function getIds() {
		if ( ! file_exists( $this->idFile )) {
			throw new \Exception("Could not open file: ".$this->idFile);
		}
		if ( empty( $this->ids )) {
			$this->ids = json_decode(file_get_contents( $this->idFile ), true);
		}
		return $this->ids;
	}

	/**
	 * Returns a list of optional wallpapers
	 * @return \Arecibo\Wallpaper\WallpaperInterface[]
	 */
	public function listWallpapers() {

		$ids = $this->getIds();
		$output = [];

		foreach ( $ids as $id ) {
			$image = $this->domain . 'prettyearth/assets/data/'.$id.'.json';
			$output[] = new EarthViewWallpaperProxy( $image, $this->assetLoader );
		}
		return $output;
	}

}
