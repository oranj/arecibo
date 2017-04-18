<?php

namespace Arecibo\Sources\Reddit;

use Arecibo\Sources\SourceInterface;
use Arecibo\AssetLoader\AssetLoaderInterface;
use Arecibo\Wallpaper\WallpaperInterface;
use Arecibo\Wallpaper\RemoteWallpaper;

class Reddit implements SourceInterface {

	/** @var string */
	protected $domain;
	/** @var string */
	protected $subreddit;
	/** @var AssetLoader */
	protected $assetLoader;

	public function __construct( $subreddit, AssetLoaderInterface $assetLoader, $domain = "https://www.reddit.com" ) {
		$this->subreddit = preg_replace('/\/?(r\/)([^\/]+)/', 'r/$2', $subreddit);
		$this->domain = rtrim($domain, '/').'/';
		$this->assetLoader  = $assetLoader;
	}

	public function identify() {
		return $this->domain . $this->subreddit;
	}

	/**
	 * Returns a list of optional wallpapers
	 * @return \Arecibo\Wallpaper\WallpaperInterface[]
	 */
	public function listWallpapers() {

		$path = $this->domain . $this->subreddit . '/top/.json';

		$contents = $this->assetLoader->loadAsset( $path );
		$data = json_decode( $contents, true );

		$images = array_map(function($child) {
			$url = $child['data']['url'];
			$extension = strtolower(pathinfo( $url, PATHINFO_EXTENSION ));
			if ( in_array( $extension, [ 'png', 'jpg', 'jpeg' ])) {
				return $url;
			}
			if ( preg_match( '/(\/|.)imgur\.com\//', $url )) {
				return $url .'.png';
			}
			return false;
		}, $data['data']['children']);

		$images = array_filter( $images );

		$images = array_values(array_unique( $images ));
		$output = [];
		foreach ( $images as $image ) {
			$output[] = new RemoteWallpaper( $image, $this->assetLoader );
		}
		return $output;
	}

}
