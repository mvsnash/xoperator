Xoperator para ZF2
=======================

Introduction
------------
O Xoperator é um simples módulo que possibilita ao adminstrador do site ter falicilidade e agilidade ao
administrar seus conteúdos. Ainda não é um CMS completo e o código não estar como eu dejeso, mas está funcionando
e estou trabalhando nisto e você pode também me ajudar contribuindo com o projeto isto é open source ou até mesmo
criando seu próprio projeto CMS baseado no Frameword da Zend.

Installation
------------
É importante que você saiba que o módulo Xoperator administra conteúdos do módulo Site, caso você tenha interesse
em usá-lo para administrar conteúdos de outro módulo veja como funciona no módulo Site.

Estou disponibilizando aqui um modelo para usar o Xoperator, você precisa apenas intalar o ZF2 e Doctrine
nas pasta "vendor".

1. Para funcionar corretamente verifique se os módulos abaixo existem na sua aplicação, veja em config/application.config.php:

	'modules' => array(
        'Site',
        'DoctrineModule',
        'DoctrineORMModule',
        'Xoperator',
    ),
	
2. Na pasta public da raiz principal verifique se existe duas pastas:

	public_site
	public_xoperator

3. Instale o banco de dados:

	A) No arquivo "config/autoload/global.php" insira:
	
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
	
	B) Crie um banco de dados no seu Mysql chamado "sitezf2_base" depois
	execute o comando SQL em "module/xoperator/data/schema.mysql.sql" no seu banco de dados.
	
	C) Primeiro login é  email: admin@admin.com  e  password: 123456 (Agora apage esta linha).
	
4.Para configurar nome do host, email de suporte e ourtra informações, veja o arquivo de configuração:

	module/Xoperator/config/settings/xoperator.config.php
	
5.Veja na imagem "module/xoperator/data/install.jpg" como ficará as pastas do seu projeto:

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
