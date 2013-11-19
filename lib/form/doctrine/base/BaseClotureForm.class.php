<?php

/**
 * Cloture form base class.
 *
 * @method Cloture getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseClotureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'nb_transaction_cash'    => new sfWidgetFormInputText(),
      'nb_transaction_cb'      => new sfWidgetFormInputText(),
      'nb_transaction_ecb'     => new sfWidgetFormInputText(),
      'total_transaction_cash' => new sfWidgetFormInputText(),
      'total_transaction_cb'   => new sfWidgetFormInputText(),
      'total_transaction_ecb'  => new sfWidgetFormInputText(),
      'id_user_record'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ServerRecord'), 'add_empty' => true)),
      'total_record'           => new sfWidgetFormInputText(),
      'server_id'              => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nb_transaction_cash'    => new sfValidatorInteger(array('required' => false)),
      'nb_transaction_cb'      => new sfValidatorInteger(array('required' => false)),
      'nb_transaction_ecb'     => new sfValidatorInteger(array('required' => false)),
      'total_transaction_cash' => new sfValidatorInteger(array('required' => false)),
      'total_transaction_cb'   => new sfValidatorInteger(array('required' => false)),
      'total_transaction_ecb'  => new sfValidatorInteger(array('required' => false)),
      'id_user_record'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ServerRecord'), 'required' => false)),
      'total_record'           => new sfValidatorInteger(array('required' => false)),
      'server_id'              => new sfValidatorInteger(array('required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cloture[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cloture';
  }

}
