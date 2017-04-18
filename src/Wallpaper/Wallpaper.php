<?php

namespace Arecibo\Wallpaper;

class Wallpaper implements WallpaperInterface {

	/** @var string */
	protected $contents;

	/** @var string */
	protected $sourceUrl;

	/**
	 * An object containing a contents to an image on the internet
	 * @param string $contents
	 */
	public function __construct( $sourceUrl, $contents ) {
		$this->sourceUrl = $sourceUrl;
		$this->contents = $contents;
	}

	/**
	 * Gets the local contents of the wallpaper
	 * @return string
	 */
	public function getContents() {
		return $this->contents;
	}

	public function getSourceUrl() {
		return $this->sourceUrl;
	}
}
