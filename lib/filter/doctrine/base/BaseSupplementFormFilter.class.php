<?php

/**
 * Supplement filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSupplementFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fois_prix'              => new sfWidgetFormFilterInput(),
      'plus_prix'              => new sfWidgetFormFilterInput(),
      'is_publish'             => new sfWidgetFormFilterInput(),
      'category_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'slug'                   => new sfWidgetFormFilterInput(),
      'article_commandes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ArticleCommande')),
    ));

    $this->setValidators(array(
      'name'                   => new sfValidatorPass(array('required' => false)),
      'fois_prix'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'plus_prix'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_publish'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'category_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'slug'                   => new sfValidatorPass(array('required' => false)),
      'article_commandes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ArticleCommande', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('supplement_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addArticleCommandesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('ArticleCommandeSupplement.article_commande_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Supplement';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'name'                   => 'Text',
      'fois_prix'              => 'Number',
      'plus_prix'              => 'Number',
      'is_publish'             => 'Number',
      'category_id'            => 'ForeignKey',
      'slug'                   => 'Text',
      'article_commandes_list' => 'ManyKey',
    );
  }
}
