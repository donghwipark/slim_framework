<?php

use Slim\Factory\AppFactory;

require 'container.php';

// Create App
$app = AppFactory::create();

require 'web.php';
require 'middleware.php';

