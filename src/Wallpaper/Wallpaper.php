<?php

namespace Arecibo\Wallpaper;

class Wallpaper implements WallpaperInterface {

	/** @var string */
	protected $path;

	/**
	 * An object containing a path to an image on the internet
	 * @param string $path
	 */
	public function __construct( $path ) {
		$this->path = $path;
	}

	/**
	 * Gets the local path of the wallpaper
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

}
