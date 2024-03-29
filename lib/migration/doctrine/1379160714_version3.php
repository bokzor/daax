<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version3 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('sf_guard_user', 'sf_guard_user_group_id_sf_guard_group_id');
    }

    public function down()
    {
        $this->createForeignKey('sf_guard_user', 'sf_guard_user_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_user_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             ));
    }
}