<?php

	require 'bitphp/autoload.php';

    use \Bitphp\Base\MvcServer;

	$app = new MvcServer();
	$app->run();