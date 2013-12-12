<?php

/**
 * BasesfGuardUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $email_address
 * @property string $avatar
 * @property string $first_name
 * @property string $last_name
 * @property string $tel
 * @property string $country
 * @property string $street
 * @property integer $postal_code
 * @property string $city
 * @property enum $genre
 * @property string $username
 * @property string $algorithm
 * @property string $salt
 * @property string $password
 * @property boolean $is_active
 * @property boolean $is_super_admin
 * @property timestamp $last_login
 * @property string $tva
 * @property date $date_naissance
 * @property integer $credit
 * @property integer $identifiant
 * @property integer $code
 * @property Doctrine_Collection $Groups
 * @property Doctrine_Collection $Permissions
 * @property Doctrine_Collection $sfGuardUserGroup
 * @property Doctrine_Collection $sfGuardUserPermission
 * @property sfGuardRememberKey $RememberKeys
 * @property sfGuardForgotPassword $ForgotPassword
 * @property Doctrine_Collection $Server
 * @property Doctrine_Collection $Client
 * @property Doctrine_Collection $ServerRecord
 * @property Doctrine_Collection $ServerCloture
 * 
 * @method string                getEmailAddress()          Returns the current record's "email_address" value
 * @method string                getAvatar()                Returns the current record's "avatar" value
 * @method string                getFirstName()             Returns the current record's "first_name" value
 * @method string                getLastName()              Returns the current record's "last_name" value
 * @method string                getTel()                   Returns the current record's "tel" value
 * @method string                getCountry()               Returns the current record's "country" value
 * @method string                getStreet()                Returns the current record's "street" value
 * @method integer               getPostalCode()            Returns the current record's "postal_code" value
 * @method string                getCity()                  Returns the current record's "city" value
 * @method enum                  getGenre()                 Returns the current record's "genre" value
 * @method string                getUsername()              Returns the current record's "username" value
 * @method string                getAlgorithm()             Returns the current record's "algorithm" value
 * @method string                getSalt()                  Returns the current record's "salt" value
 * @method string                getPassword()              Returns the current record's "password" value
 * @method boolean               getIsActive()              Returns the current record's "is_active" value
 * @method boolean               getIsSuperAdmin()          Returns the current record's "is_super_admin" value
 * @method timestamp             getLastLogin()             Returns the current record's "last_login" value
 * @method string                getTva()                   Returns the current record's "tva" value
 * @method date                  getDateNaissance()         Returns the current record's "date_naissance" value
 * @method integer               getCredit()                Returns the current record's "credit" value
 * @method integer               getIdentifiant()           Returns the current record's "identifiant" value
 * @method integer               getCode()                  Returns the current record's "code" value
 * @method Doctrine_Collection   getGroups()                Returns the current record's "Groups" collection
 * @method Doctrine_Collection   getPermissions()           Returns the current record's "Permissions" collection
 * @method Doctrine_Collection   getSfGuardUserGroup()      Returns the current record's "sfGuardUserGroup" collection
 * @method Doctrine_Collection   getSfGuardUserPermission() Returns the current record's "sfGuardUserPermission" collection
 * @method sfGuardRememberKey    getRememberKeys()          Returns the current record's "RememberKeys" value
 * @method sfGuardForgotPassword getForgotPassword()        Returns the current record's "ForgotPassword" value
 * @method Doctrine_Collection   getServer()                Returns the current record's "Server" collection
 * @method Doctrine_Collection   getClient()                Returns the current record's "Client" collection
 * @method Doctrine_Collection   getServerRecord()          Returns the current record's "ServerRecord" collection
 * @method Doctrine_Collection   getServerCloture()         Returns the current record's "ServerCloture" collection
 * @method sfGuardUser           setEmailAddress()          Sets the current record's "email_address" value
 * @method sfGuardUser           setAvatar()                Sets the current record's "avatar" value
 * @method sfGuardUser           setFirstName()             Sets the current record's "first_name" value
 * @method sfGuardUser           setLastName()              Sets the current record's "last_name" value
 * @method sfGuardUser           setTel()                   Sets the current record's "tel" value
 * @method sfGuardUser           setCountry()               Sets the current record's "country" value
 * @method sfGuardUser           setStreet()                Sets the current record's "street" value
 * @method sfGuardUser           setPostalCode()            Sets the current record's "postal_code" value
 * @method sfGuardUser           setCity()                  Sets the current record's "city" value
 * @method sfGuardUser           setGenre()                 Sets the current record's "genre" value
 * @method sfGuardUser           setUsername()              Sets the current record's "username" value
 * @method sfGuardUser           setAlgorithm()             Sets the current record's "algorithm" value
 * @method sfGuardUser           setSalt()                  Sets the current record's "salt" value
 * @method sfGuardUser           setPassword()              Sets the current record's "password" value
 * @method sfGuardUser           setIsActive()              Sets the current record's "is_active" value
 * @method sfGuardUser           setIsSuperAdmin()          Sets the current record's "is_super_admin" value
 * @method sfGuardUser           setLastLogin()             Sets the current record's "last_login" value
 * @method sfGuardUser           setTva()                   Sets the current record's "tva" value
 * @method sfGuardUser           setDateNaissance()         Sets the current record's "date_naissance" value
 * @method sfGuardUser           setCredit()                Sets the current record's "credit" value
 * @method sfGuardUser           setIdentifiant()           Sets the current record's "identifiant" value
 * @method sfGuardUser           setCode()                  Sets the current record's "code" value
 * @method sfGuardUser           setGroups()                Sets the current record's "Groups" collection
 * @method sfGuardUser           setPermissions()           Sets the current record's "Permissions" collection
 * @method sfGuardUser           setSfGuardUserGroup()      Sets the current record's "sfGuardUserGroup" collection
 * @method sfGuardUser           setSfGuardUserPermission() Sets the current record's "sfGuardUserPermission" collection
 * @method sfGuardUser           setRememberKeys()          Sets the current record's "RememberKeys" value
 * @method sfGuardUser           setForgotPassword()        Sets the current record's "ForgotPassword" value
 * @method sfGuardUser           setServer()                Sets the current record's "Server" collection
 * @method sfGuardUser           setClient()                Sets the current record's "Client" collection
 * @method sfGuardUser           setServerRecord()          Sets the current record's "ServerRecord" collection
 * @method sfGuardUser           setServerCloture()         Sets the current record's "ServerCloture" collection
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasesfGuardUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sf_guard_user');
        $this->hasColumn('email_address', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('avatar', 'string', 255, array(
             'type' => 'string',
             'default' => 'default.png',
             'length' => 255,
             ));
        $this->hasColumn('first_name', 'string', 30, array(
             'type' => 'string',
             'length' => 30,
             ));
        $this->hasColumn('last_name', 'string', 30, array(
             'type' => 'string',
             'length' => 30,
             ));
        $this->hasColumn('tel', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('country', 'string', 30, array(
             'type' => 'string',
             'length' => 30,
             ));
        $this->hasColumn('street', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('postal_code', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('city', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('genre', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'M',
              1 => 'F',
             ),
             ));
        $this->hasColumn('username', 'string', 128, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 128,
             ));
        $this->hasColumn('algorithm', 'string', 128, array(
             'type' => 'string',
             'default' => 'sha1',
             'notnull' => true,
             'length' => 128,
             ));
        $this->hasColumn('salt', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('password', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             ));
        $this->hasColumn('is_super_admin', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('last_login', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('tva', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('date_naissance', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('credit', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('identifiant', 'integer', null, array(
             'type' => 'integer',
             'unique' => true,
             ));
        $this->hasColumn('code', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'unique' => true,
             'length' => 4,
             ));


        $this->index('is_active_idx', array(
             'fields' => 
             array(
              0 => 'is_active',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('sfGuardGroup as Groups', array(
             'refClass' => 'sfGuardUserGroup',
             'local' => 'user_id',
             'foreign' => 'group_id'));

        $this->hasMany('sfGuardPermission as Permissions', array(
             'refClass' => 'sfGuardUserPermission',
             'local' => 'user_id',
             'foreign' => 'permission_id'));

        $this->hasMany('sfGuardUserGroup', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('sfGuardUserPermission', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasOne('sfGuardRememberKey as RememberKeys', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasOne('sfGuardForgotPassword as ForgotPassword', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Commande as Server', array(
             'local' => 'id',
             'foreign' => 'server_id'));

        $this->hasMany('Commande as Client', array(
             'local' => 'id',
             'foreign' => 'client_id'));

        $this->hasMany('Cloture as ServerRecord', array(
             'local' => 'id',
             'foreign' => 'id_user_record'));

        $this->hasMany('Cloture as ServerCloture', array(
             'local' => 'id',
             'foreign' => 'server_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}