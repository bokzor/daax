<?php

/**
 * ArticleCommande filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseArticleCommandeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'add_empty' => true)),
      'commande_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Commande'), 'add_empty' => true)),
      'count'            => new sfWidgetFormFilterInput(),
      'prix'             => new sfWidgetFormFilterInput(),
      'supplements_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Supplement')),
    ));

    $this->setValidators(array(
      'article_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Article'), 'column' => 'id')),
      'commande_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Commande'), 'column' => 'id')),
      'count'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'prix'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'supplements_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Supplement', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('article_commande_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addSupplementsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ArticleCommandeSupplement ArticleCommandeSupplement')
      ->andWhereIn('ArticleCommandeSupplement.supplement_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'ArticleCommande';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'article_id'       => 'ForeignKey',
      'commande_id'      => 'ForeignKey',
      'count'            => 'Number',
      'prix'             => 'Number',
      'supplements_list' => 'ManyKey',
    );
  }
}
