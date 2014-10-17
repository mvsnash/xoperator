/*model SQL for the site*/

/*creating table for users of the site*/
/*@See
	first user is:
    email: admin@admin.com
    password: 123456
*/
CREATE TABLE IF NOT EXISTS `xopuser`
(
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username`      VARCHAR(255) DEFAULT NULL UNIQUE,
    `email`         VARCHAR(255) DEFAULT NULL UNIQUE,
    `display_name`  VARCHAR(50) DEFAULT NULL,
    `password`      VARCHAR(300) NOT NULL,
    `date` TIMESTAMP NOT NULL,
    `status`         SMALLINT UNSIGNED
) ENGINE=InnoDB CHARSET="utf8";

INSERT INTO `xopuser` (`id`, `username`, `email`, `display_name`, `password`, `date`, `status`) VALUES
(1, 'Administrador', 'admin@admin.com', NULL, '1745fd4371fb78aa084937da6cc5e39f9a3fe9d68870d5870553d5322ddefeeeCYGaWDmqW+AgqY1WNeevc8VN/HBpYK8ysC9b8wpaeog=', '', '1');

/*creating table for librarys of the site*/
CREATE TABLE IF NOT EXISTS `xoplibrary`
(
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `file_name`      VARCHAR(255) DEFAULT NULL UNIQUE,
    `file_image`      VARCHAR(300) DEFAULT NULL,
    `description`   VARCHAR(255) DEFAULT NULL,
    `date` TIMESTAMP NOT NULL,
    `status`         SMALLINT UNSIGNED
) ENGINE=InnoDB CHARSET="utf8";

INSERT INTO `xoplibrary` (`id`, `file_name`, `file_image`, `description`, `date`, `status`) VALUES
(1, 'file test', 'foto.jpg', 'description do first file','null','1');


/*creating table for configuration of the site*/
CREATE TABLE IF NOT EXISTS `xoparticles` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT(11) DEFAULT NULL,
  `title` VARCHAR(150) DEFAULT NULL,
  `url` VARCHAR(150) DEFAULT NULL,
  `id_image` VARCHAR(50) DEFAULT NULL,
  `text` TEXT DEFAULT NULL,
  `comments` INT(1) DEFAULT NULL,
  `tags` VARCHAR(300) DEFAULT NULL,
  `description` VARCHAR(300) DEFAULT NULL,
  `category` INT(11) DEFAULT NULL,
  `date` TIMESTAMP NOT NULL,
  `level` INT(2) DEFAULT NULL,
  `language` VARCHAR(30) DEFAULT NULL,
  `status` SMALLINT UNSIGNED
  
) ENGINE=MyISAM DEFAULT CHARSET="utf8";

INSERT INTO `xoparticles` (`id`, `id_user`, `title`, `url`, `id_image`, `text`, `comments`, `tags`, `description`, `category`, `date`, `level`, `language`, `status`) VALUES
(
1,
1,
'Article test one',
'article-test-one',
'[1]',
'This is the text of the first article test, this article is in the
database table in articles may be added to our catalog this photo tags,
file and descriptions para head for search engines how Google, Yahoo,
Bing and others. Also this article may be altered or deleted by the
administrator of contents. In xoperator administrator you will see this.',
0,
'tag, text, first article',
'Descriptions for head for search engines how Google, Yahoo, Bing and others',
'null',
'',
1,
'portuguese',
'1'
);


INSERT INTO `xoparticles` (`id`, `id_user`, `title`, `url`, `id_image`, `text`, `comments`, `tags`, `description`, `category`, `date`, `level`, `language`, `status`) VALUES
(
2,
1,
'Article test two',
'article-test-two',
'[1]',
'Second article test, this article is in the database table in articles may be added
to our catalog this photo tags, file and descriptions para head for search engines
how Google, Yahoo, Bing and others. Also this article may be altered or deleted by the
administrator of contents. In xoperator administrator you will see this.',
0,
'tag, text, second article',
'Descriptions for head for search engines how Google, Yahoo, Bing and others',
'null',
'',
1,
'portuguese',
'1'
);

INSERT INTO `xoparticles` (`id`, `id_user`, `title`, `url`, `id_image`, `text`, `comments`, `tags`, `description`, `category`, `date`, `level`, `language`, `status`) VALUES
(
3,
1,
'Article test three',
'article-test-three',
'[1]',
'Third article test, this article is in the database table in articles may be added
to our catalog this photo tags, file and descriptions para head for search engines
how Google, Yahoo, Bing and others. Also this article may be altered or deleted by the
administrator of contents. In xoperator administrator you will see this.',
0,
'tag, text, third article',
'Descriptions for head for search engines how Google, Yahoo, Bing and others',
'null',
'',
1,
'portuguese',
'1'
);

/*creating table for menus of the site*/
CREATE TABLE IF NOT EXISTS `xopmenus`
(
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `menu`      VARCHAR(255) DEFAULT NULL UNIQUE,
    `modules`      VARCHAR(255) DEFAULT NULL,
    `description`   VARCHAR(255) DEFAULT NULL,
    `id_user`   INT(11) DEFAULT NULL,
    `block`   VARCHAR(255) DEFAULT NULL,
    `date` TIMESTAMP NOT NULL
) ENGINE=InnoDB CHARSET="utf8";

INSERT INTO `xopmenus` (`id`, `menu`, `modules`, `description`, `id_user`, `block`, `date`) VALUES
(1, 'Main', '', 'menu main of the system','1','','');

/*creating table for links menus of the site*/
CREATE TABLE IF NOT EXISTS `xoplinksmenus`
(
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_menu`      INT(11) DEFAULT NULL UNIQUE,
    `value`   VARCHAR(255) DEFAULT NULL,
    `link`   VARCHAR(500) DEFAULT NULL,
    `description`   VARCHAR(255) DEFAULT NULL,    
    `id_user`   INT(11) DEFAULT NULL,    
    `date` TIMESTAMP NOT NULL
) ENGINE=InnoDB CHARSET="utf8";

INSERT INTO `xoplinksmenus` (`id`, `id_menu`, `value`, `link`, `description`, `id_user`, `date`) VALUES
(1, '1', 'First', 'article-test-one','','1','');