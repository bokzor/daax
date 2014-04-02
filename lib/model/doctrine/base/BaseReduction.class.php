<?php

/**
 * BaseReduction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $article_id
 * @property integer $groupe_id
 * @property integer $nb_acheter
 * @property integer $nb_offert
 * @property integer $new_price
 * @property integer $pourcent_article
 * @property integer $pourcent_commande
 * @property boolean $is_publish
 * @property string $code
 * @property boolean $always_activate
 * @property boolean $auto_reduction
 * @property date $start_date
 * @property date $end_date
 * @property time $start_time
 * @property time $end_time
 * @property integer $type
 * @property GroupeReduction $Groupe
 * @property Article $Article
 * 
 * @method integer         getArticleId()         Returns the current record's "article_id" value
 * @method integer         getGroupeId()          Returns the current record's "groupe_id" value
 * @method integer         getNbAcheter()         Returns the current record's "nb_acheter" value
 * @method integer         getNbOffert()          Returns the current record's "nb_offert" value
 * @method integer         getNewPrice()          Returns the current record's "new_price" value
 * @method integer         getPourcentArticle()   Returns the current record's "pourcent_article" value
 * @method integer         getPourcentCommande()  Returns the current record's "pourcent_commande" value
 * @method boolean         getIsPublish()         Returns the current record's "is_publish" value
 * @method string          getCode()              Returns the current record's "code" value
 * @method boolean         getAlwaysActivate()    Returns the current record's "always_activate" value
 * @method boolean         getAutoReduction()     Returns the current record's "auto_reduction" value
 * @method date            getStartDate()         Returns the current record's "start_date" value
 * @method date            getEndDate()           Returns the current record's "end_date" value
 * @method time            getStartTime()         Returns the current record's "start_time" value
 * @method time            getEndTime()           Returns the current record's "end_time" value
 * @method integer         getType()              Returns the current record's "type" value
 * @method GroupeReduction getGroupe()            Returns the current record's "Groupe" value
 * @method Article         getArticle()           Returns the current record's "Article" value
 * @method Reduction       setArticleId()         Sets the current record's "article_id" value
 * @method Reduction       setGroupeId()          Sets the current record's "groupe_id" value
 * @method Reduction       setNbAcheter()         Sets the current record's "nb_acheter" value
 * @method Reduction       setNbOffert()          Sets the current record's "nb_offert" value
 * @method Reduction       setNewPrice()          Sets the current record's "new_price" value
 * @method Reduction       setPourcentArticle()   Sets the current record's "pourcent_article" value
 * @method Reduction       setPourcentCommande()  Sets the current record's "pourcent_commande" value
 * @method Reduction       setIsPublish()         Sets the current record's "is_publish" value
 * @method Reduction       setCode()              Sets the current record's "code" value
 * @method Reduction       setAlwaysActivate()    Sets the current record's "always_activate" value
 * @method Reduction       setAutoReduction()     Sets the current record's "auto_reduction" value
 * @method Reduction       setStartDate()         Sets the current record's "start_date" value
 * @method Reduction       setEndDate()           Sets the current record's "end_date" value
 * @method Reduction       setStartTime()         Sets the current record's "start_time" value
 * @method Reduction       setEndTime()           Sets the current record's "end_time" value
 * @method Reduction       setType()              Sets the current record's "type" value
 * @method Reduction       setGroupe()            Sets the current record's "Groupe" value
 * @method Reduction       setArticle()           Sets the current record's "Article" value
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReduction extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('reduction');
        $this->hasColumn('article_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('groupe_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('nb_acheter', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('nb_offert', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('new_price', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('pourcent_article', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('pourcent_commande', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('is_publish', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('code', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('always_activate', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('auto_reduction', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('start_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('end_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('start_time', 'time', null, array(
             'type' => 'time',
             ));
        $this->hasColumn('end_time', 'time', null, array(
             'type' => 'time',
             ));
        $this->hasColumn('type', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('GroupeReduction as Groupe', array(
             'local' => 'groupe_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Article', array(
             'local' => 'article_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}