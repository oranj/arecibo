<?php

$root = realpath( dirname( __DIR__ ));

include "$root/vendor/autoload.php";

( new \Autoload\Psr4Autoloader( "Arecibo", "$root/src" ) )->register();
