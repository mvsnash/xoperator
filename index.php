<?php
/**
 * This file call index.php of the paste public.
 */

require 'public/index.php';

require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
