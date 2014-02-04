<?php

/**
 * Category filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCategoryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'img'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'father_id'        => new sfWidgetFormFilterInput(),
      'is_publish'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'slug'             => new sfWidgetFormFilterInput(),
      'root_id'          => new sfWidgetFormFilterInput(),
      'lft'              => new sfWidgetFormFilterInput(),
      'rgt'              => new sfWidgetFormFilterInput(),
      'level'            => new sfWidgetFormFilterInput(),
      'imprimantes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Imprimante')),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'img'              => new sfValidatorPass(array('required' => false)),
      'father_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_publish'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'slug'             => new sfValidatorPass(array('required' => false)),
      'root_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'imprimantes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Imprimante', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addImprimantesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.CategoryImprimante CategoryImprimante')
      ->andWhereIn('CategoryImprimante.imprimante_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'img'              => 'Text',
      'father_id'        => 'Number',
      'is_publish'       => 'Boolean',
      'slug'             => 'Text',
      'root_id'          => 'Number',
      'lft'              => 'Number',
      'rgt'              => 'Number',
      'level'            => 'Number',
      'imprimantes_list' => 'ManyKey',
    );
  }
}
