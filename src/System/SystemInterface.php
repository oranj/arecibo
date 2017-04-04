<?php

namespace Arecibo\System;

use Arecibo\Wallpaper\WallpaperInterface;

interface SystemInterface {

	public function setWallpaper( WallpaperInterface $wallpaper );

}
