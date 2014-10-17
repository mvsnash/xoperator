Xoperator for ZF2
=======================

Introduction
------------
The Xoperator is a simple module that enables the site admin have falicilidade and agility to 
manage their content. Not yet a full CMS and code dejeso not be like me, but it is working 
and am working on it and you can also help me contribute to the project that is open source or even 
creating your own CMS project based on Zend Framework 2.

Installation
------------
It is important that you know that Xoperator module manages content of the module website, if you are interested 
using it to manage content from another module see how it works on the module website. 

I am providing here a model to use Xoperator, you need only intalar the ZF2 and Doctrine 
the "vendor" folder.

1. To work properly check below modules exist in your application, see for "config/application.config.php":

	'modules' => array(
        'Site',
        'DoctrineModule',
        'DoctrineORMModule',
        'Xoperator',
    ),
	
2. Public folder in the main root check if there are two folders:

	public_site
	public_xoperator

3. Install the database:

	A) In "config/autoload/global.php" file insert:
	
	return array(
    
     'service_manager' => array(
         'factories' => array(
             'Zend\Db\Adapter\Adapter'
                     => 'Zend\Db\Adapter\AdapterServiceFactory',
         ),
     ),
     'doctrine' => array(
        'connection' => array(
                    'driver'    => 'pdo_mysql',
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'sitezf2_base'
            )
        
     ),
	);
	
	B) Create a database in your MYSQL called "sitezf2_base" after 
	run the SQL command "module/xoperator/data/schema.mysql.sql" in your database.
	
	C) First login is  email: admin@admin.com  and  password: 123456 (Now delete this line).
	
4. To configure the host name, email support and ourtra information, see the configuration file:

	module/Xoperator/config/settings/xoperator.config.php
	
5. See the image "module/xoperator/data/install.jpg" how will the folders of your project:

Using Git submodules
--------------------
Alternatively, you can install using native git submodules:

    git clone git://github.com/zendframework/xoperator.git --recursive

Web Server Setup
----------------

### PHP CLI Server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-tutorial.localhost
        DocumentRoot /path/to/zf2-tutorial/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/zf2-tutorial/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
