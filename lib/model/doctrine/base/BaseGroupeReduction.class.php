<?php

/**
 * BaseGroupeReduction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property boolean $is_active
 * @property Doctrine_Collection $Reduction
 * 
 * @method string              getName()      Returns the current record's "name" value
 * @method boolean             getIsActive()  Returns the current record's "is_active" value
 * @method Doctrine_Collection getReduction() Returns the current record's "Reduction" collection
 * @method GroupeReduction     setName()      Sets the current record's "name" value
 * @method GroupeReduction     setIsActive()  Sets the current record's "is_active" value
 * @method GroupeReduction     setReduction() Sets the current record's "Reduction" collection
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGroupeReduction extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('groupe_reduction');
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 100,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Reduction', array(
             'local' => 'id',
             'foreign' => 'groupe_id'));
    }
}