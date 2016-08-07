<?php
$installer = $this;
$installer->startSetup();
$installer->run("
     ALTER TABLE {$this->getTable('recipes')} ADD COLUMN `product_ids` TEXT NOT NULL;
");
$installer->endSetup();
