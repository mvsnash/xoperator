<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 * ATTENTION:
 * to make the original rows before desmarke and delete
 * the file index.php and .htaccess of the paste root
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
//BEFORE: require 'init_autoloader.php';

// Run the application!
//BEFORE: Zend\Mvc\Application::init(require 'config/application.config.php')->run();

//@alterado para direcionar para site principal
if(strstr($_SERVER['REQUEST_URI'],'/public')){

    $explode = explode('/public', $_SERVER['REQUEST_URI']);
    
    if(count($explode) <= 2):
    
        header('Location: ../', true);
    
    endif;
    
}