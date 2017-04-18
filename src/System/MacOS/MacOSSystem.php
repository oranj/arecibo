<?php

namespace Arecibo\System\MacOS;

use Arecibo\System\SystemInterface;
use Arecibo\Wallpaper\WallpaperInterface;

class MacOSSystem implements SystemInterface {

	protected $cmdPath;

	public function __construct() {
		$this->cmdPath = realpath( __DIR__ . '/set_bg_cmd.scpt' );
	}

	public function setWallpaper( $path ) {
		exec('osascript "'.addslashes( $this->cmdPath ).'" "'. addslashes( $path ).'"');
	}
}
