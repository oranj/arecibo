<?php

namespace Arecibo\Sources;

interface SourceInterface {

	/** \Arecibo\Wallpaper\WallpaperInterface[] */
	public function listWallpapers();

	/** string */
	public function identify();

}
