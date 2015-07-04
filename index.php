<?php

	require 'src/autoload.php';

    use \Bitphp\Base\MvcServer;

	$app = new MvcServer();
	$app->run();