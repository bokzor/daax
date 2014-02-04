<?php

/**
 * CommandesTransaction form base class.
 *
 * @method CommandesTransaction getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommandesTransactionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'transaction_id' => new sfWidgetFormInputHidden(),
      'commande_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'transaction_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('transaction_id')), 'empty_value' => $this->getObject()->get('transaction_id'), 'required' => false)),
      'commande_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('commande_id')), 'empty_value' => $this->getObject()->get('commande_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commandes_transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommandesTransaction';
  }

}
