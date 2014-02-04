<?php

/**
 * BaseSession
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $id
 * @property string $sess
 * @property integer $time
 * 
 * @method string  getId()   Returns the current record's "id" value
 * @method string  getSess() Returns the current record's "sess" value
 * @method integer getTime() Returns the current record's "time" value
 * @method Session setId()   Sets the current record's "id" value
 * @method Session setSess() Sets the current record's "sess" value
 * @method Session setTime() Sets the current record's "time" value
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSession extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('session');
        $this->hasColumn('id', 'string', 32, array(
             'type' => 'string',
             'primary' => true,
             'length' => 32,
             ));
        $this->hasColumn('sess', 'string', 4000, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 4000,
             ));
        $this->hasColumn('time', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}