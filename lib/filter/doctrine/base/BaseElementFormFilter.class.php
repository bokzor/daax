<?php

/**
 * Element filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseElementFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'img'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_publish'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'category_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'stock_minimum'      => new sfWidgetFormFilterInput(),
      'stock_actuel'       => new sfWidgetFormFilterInput(),
      'conditionnement_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Conditionnement'), 'add_empty' => true)),
      'fournisseur_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fournisseur'), 'add_empty' => true)),
      'nombre_unite'       => new sfWidgetFormFilterInput(),
      'prix_achat'         => new sfWidgetFormFilterInput(),
      'reference'          => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'               => new sfWidgetFormFilterInput(),
      'article_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
    ));

    $this->setValidators(array(
      'name'               => new sfValidatorPass(array('required' => false)),
      'img'                => new sfValidatorPass(array('required' => false)),
      'is_publish'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'category_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'stock_minimum'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'stock_actuel'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'conditionnement_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Conditionnement'), 'column' => 'id')),
      'fournisseur_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Fournisseur'), 'column' => 'id')),
      'nombre_unite'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'prix_achat'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'reference'          => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'               => new sfValidatorPass(array('required' => false)),
      'article_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('element_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addArticleListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ArticleElement ArticleElement')
      ->andWhereIn('ArticleElement.article_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Element';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'name'               => 'Text',
      'img'                => 'Text',
      'is_publish'         => 'Boolean',
      'category_id'        => 'ForeignKey',
      'stock_minimum'      => 'Number',
      'stock_actuel'       => 'Number',
      'conditionnement_id' => 'ForeignKey',
      'fournisseur_id'     => 'ForeignKey',
      'nombre_unite'       => 'Number',
      'prix_achat'         => 'Number',
      'reference'          => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'slug'               => 'Text',
      'article_list'       => 'ManyKey',
    );
  }
}
