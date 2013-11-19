<?php

/**
 * PlanTableObject form base class.
 *
 * @method PlanTableObject getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePlanTableObjectForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'description'    => new sfWidgetFormTextarea(),
      'visible'        => new sfWidgetFormInputCheckbox(),
      'width'          => new sfWidgetFormInputText(),
      'height'         => new sfWidgetFormInputText(),
      'rotation'       => new sfWidgetFormInputText(),
      'statut'         => new sfWidgetFormInputText(),
      'plantable_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PlanTableObject'), 'add_empty' => true)),
      'x'              => new sfWidgetFormInputText(),
      'y'              => new sfWidgetFormInputText(),
      'locked'         => new sfWidgetFormInputCheckbox(),
      'zindex'         => new sfWidgetFormInputText(),
      'image_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ObjectImage'), 'add_empty' => true)),
      'elipse'         => new sfWidgetFormInputCheckbox(),
      'image_chair_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ObjectChairImage'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 100)),
      'description'    => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'visible'        => new sfValidatorBoolean(array('required' => false)),
      'width'          => new sfValidatorInteger(array('required' => false)),
      'height'         => new sfValidatorInteger(array('required' => false)),
      'rotation'       => new sfValidatorInteger(array('required' => false)),
      'statut'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'plantable_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PlanTableObject'), 'required' => false)),
      'x'              => new sfValidatorInteger(array('required' => false)),
      'y'              => new sfValidatorInteger(array('required' => false)),
      'locked'         => new sfValidatorBoolean(array('required' => false)),
      'zindex'         => new sfValidatorInteger(array('required' => false)),
      'image_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ObjectImage'), 'required' => false)),
      'elipse'         => new sfValidatorBoolean(array('required' => false)),
      'image_chair_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ObjectChairImage'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('plan_table_object[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlanTableObject';
  }

}
