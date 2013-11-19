<?php

/**
 * BasePlanTableImage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $img
 * @property integer $category_id
 * @property PlanTableImageCategory $Category
 * @property Doctrine_Collection $PlanTable
 * @property Doctrine_Collection $PlanTableObject
 * 
 * @method string                 getName()            Returns the current record's "name" value
 * @method string                 getImg()             Returns the current record's "img" value
 * @method integer                getCategoryId()      Returns the current record's "category_id" value
 * @method PlanTableImageCategory getCategory()        Returns the current record's "Category" value
 * @method Doctrine_Collection    getPlanTable()       Returns the current record's "PlanTable" collection
 * @method Doctrine_Collection    getPlanTableObject() Returns the current record's "PlanTableObject" collection
 * @method PlanTableImage         setName()            Sets the current record's "name" value
 * @method PlanTableImage         setImg()             Sets the current record's "img" value
 * @method PlanTableImage         setCategoryId()      Sets the current record's "category_id" value
 * @method PlanTableImage         setCategory()        Sets the current record's "Category" value
 * @method PlanTableImage         setPlanTable()       Sets the current record's "PlanTable" collection
 * @method PlanTableImage         setPlanTableObject() Sets the current record's "PlanTableObject" collection
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePlanTableImage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('plan_table_image');
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('img', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('category_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('PlanTableImageCategory as Category', array(
             'local' => 'category_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('PlanTable', array(
             'local' => 'id',
             'foreign' => 'background_id'));

        $this->hasMany('PlanTableObject', array(
             'local' => 'id',
             'foreign' => 'image_id'));
    }
}