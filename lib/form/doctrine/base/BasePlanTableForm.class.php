<?php

/**
 * PlanTable form base class.
 *
 * @method PlanTable getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePlanTableForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'description'   => new sfWidgetFormTextarea(),
      'visible'       => new sfWidgetFormInputCheckbox(),
      'width'         => new sfWidgetFormInputText(),
      'height'        => new sfWidgetFormInputText(),
      'background_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PlanTableBackground'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 100)),
      'description'   => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'visible'       => new sfValidatorBoolean(array('required' => false)),
      'width'         => new sfValidatorInteger(array('required' => false)),
      'height'        => new sfValidatorInteger(array('required' => false)),
      'background_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PlanTableBackground'), 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PlanTable', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('plan_table[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PlanTable';
  }

}
