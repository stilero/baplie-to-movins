CREATE TABLE IF NOT EXISTS `#__convert_bapliemovins_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `params` text,
  `description` text,
  `created` datetime DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

