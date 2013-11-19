<?php

/**
 * PlanTableObject filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePlanTableObjectFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'    => new sfWidgetFormFilterInput(),
      'visible'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'width'          => new sfWidgetFormFilterInput(),
      'height'         => new sfWidgetFormFilterInput(),
      'rotation'       => new sfWidgetFormFilterInput(),
      'statut'         => new sfWidgetFormFilterInput(),
      'plantable_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PlanTableObject'), 'add_empty' => true)),
      'x'              => new sfWidgetFormFilterInput(),
      'y'              => new sfWidgetFormFilterInput(),
      'locked'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'zindex'         => new sfWidgetFormFilterInput(),
      'image_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ObjectImage'), 'add_empty' => true)),
      'elipse'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'image_chair_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ObjectChairImage'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'description'    => new sfValidatorPass(array('required' => false)),
      'visible'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'width'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'height'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rotation'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'statut'         => new sfValidatorPass(array('required' => false)),
      'plantable_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PlanTableObject'), 'column' => 'id')),
      'x'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'y'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'locked'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'zindex'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'image_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ObjectImage'), 'column' => 'id')),
      'elipse'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'image_chair_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ObjectChairImage'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('plan_table_object_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlanTableObject';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'name'           => 'Text',
      'description'    => 'Text',
      'visible'        => 'Boolean',
      'width'          => 'Number',
      'height'         => 'Number',
      'rotation'       => 'Number',
      'statut'         => 'Text',
      'plantable_id'   => 'ForeignKey',
      'x'              => 'Number',
      'y'              => 'Number',
      'locked'         => 'Boolean',
      'zindex'         => 'Number',
      'image_id'       => 'ForeignKey',
      'elipse'         => 'Boolean',
      'image_chair_id' => 'ForeignKey',
    );
  }
}
