<?php

// die('springt.');
$installer = $this;

$installer->startSetup();

/**
 * create recipe table
 */
$installer->run("

DROP TABLE IF EXISTS {$this->getTable('recipes')};

CREATE TABLE {$this->getTable('recipes')} (
  `recipe_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type_id` int(11) NOT NULL default '0',

  `description` varchar(255) NOT NULL default '',
  `ingredients` varchar(255) NOT NULL default '',
  `duration` int(8) NULL,
  `number_of_person` int(8) NULL,
  `author` varchar(255) NOT NULL default '',
  `video_url` varchar(255) NOT NULL default '',

  PRIMARY KEY (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

");

$installer->endSetup();
