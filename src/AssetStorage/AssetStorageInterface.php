<?php

namespace Arecibo\AssetStorage;

interface AssetStorageInterface {

	public function exists( $path );
	public function read( $path );
	public function write( $path, $contents );
	public function remove( $path );

}
