<?php

/**
 * BaseArticleCommandeSupplement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $article_commande_id
 * @property integer $supplement_id
 * @property ArticleCommande $ArticleCommande
 * @property Supplement $Supplement
 * 
 * @method integer                   getArticleCommandeId()   Returns the current record's "article_commande_id" value
 * @method integer                   getSupplementId()        Returns the current record's "supplement_id" value
 * @method ArticleCommande           getArticleCommande()     Returns the current record's "ArticleCommande" value
 * @method Supplement                getSupplement()          Returns the current record's "Supplement" value
 * @method ArticleCommandeSupplement setArticleCommandeId()   Sets the current record's "article_commande_id" value
 * @method ArticleCommandeSupplement setSupplementId()        Sets the current record's "supplement_id" value
 * @method ArticleCommandeSupplement setArticleCommande()     Sets the current record's "ArticleCommande" value
 * @method ArticleCommandeSupplement setSupplement()          Sets the current record's "Supplement" value
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseArticleCommandeSupplement extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('article_commande_supplement');
        $this->hasColumn('article_commande_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('supplement_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ArticleCommande', array(
             'local' => 'article_commande_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Supplement', array(
             'local' => 'supplement_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}