<?php

namespace Arecibo\AssetStorage;

class AssetStorage implements AssetStorageInterface {

	protected $directory;

	public function __construct( $directory ) {
		if ( ! file_exists( $directory ) && ! is_dir( $directory )) {
			mkdir( $directory );
			// throw new \Exception( "Invalid cache directory: `" . $directory ."`. Please make sure this path exists" );
		}
		$this->directory = realpath( $directory );
	}

	public function fullPath( $path ) {
		return $this->directory . '/' . trim( $path, '/' );
	}

	public function exists( $path ) {
		return file_exists( $this->fullPath( $path ));
	}

	public function read( $path ) {
		return file_get_contents( $this->fullPath( $path ));
	}

	public function write( $path, $contents ) {
		return file_put_contents( $this->fullPath( $path ), $contents);
	}

	public function remove( $path ) {
		unlink( $this->fullPath( $path ) );
	}

}
