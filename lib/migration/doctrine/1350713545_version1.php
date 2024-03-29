<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version1 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('dpstream', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'id_ergor' => 
             array(
              'type' => 'integer',
              'unique' => '1',
              'length' => '8',
             ),
             'url_dp' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'done' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'default' => '0',
              'length' => '8',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('dpstream');
    }
}