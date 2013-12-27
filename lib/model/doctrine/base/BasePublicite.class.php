<?php

/**
 * BasePublicite
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $message
 * @property boolean $selected
 * 
 * @method string    getMessage()  Returns the current record's "message" value
 * @method boolean   getSelected() Returns the current record's "selected" value
 * @method Publicite setMessage()  Sets the current record's "message" value
 * @method Publicite setSelected() Sets the current record's "selected" value
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePublicite extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('publicite');
        $this->hasColumn('message', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('selected', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}