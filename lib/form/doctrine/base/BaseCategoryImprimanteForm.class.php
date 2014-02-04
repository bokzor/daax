<?php

/**
 * CategoryImprimante form base class.
 *
 * @method CategoryImprimante getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryImprimanteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'category_id'   => new sfWidgetFormInputHidden(),
      'imprimante_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'category_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('category_id')), 'empty_value' => $this->getObject()->get('category_id'), 'required' => false)),
      'imprimante_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('imprimante_id')), 'empty_value' => $this->getObject()->get('imprimante_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_imprimante[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryImprimante';
  }

}
