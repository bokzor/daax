<?php

/**
 * BaseConditionnement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $Element
 * 
 * @method string              getName()    Returns the current record's "name" value
 * @method Doctrine_Collection getElement() Returns the current record's "Element" collection
 * @method Conditionnement     setName()    Sets the current record's "name" value
 * @method Conditionnement     setElement() Sets the current record's "Element" collection
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseConditionnement extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('conditionnement');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Element', array(
             'local' => 'id',
             'foreign' => 'conditionnement_id'));
    }
}