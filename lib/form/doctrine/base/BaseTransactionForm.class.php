<?php

/**
 * Transaction form base class.
 *
 * @method Transaction getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTransactionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'server_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Server'), 'add_empty' => false)),
      'client_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'add_empty' => true)),
      'cash'           => new sfWidgetFormInputText(),
      'cb'             => new sfWidgetFormInputText(),
      'cashback'       => new sfWidgetFormInputText(),
      'ecb'            => new sfWidgetFormInputText(),
      'statut'         => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'commandes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Commande')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'server_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Server'))),
      'client_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'required' => false)),
      'cash'           => new sfValidatorInteger(array('required' => false)),
      'cb'             => new sfValidatorInteger(array('required' => false)),
      'cashback'       => new sfValidatorInteger(array('required' => false)),
      'ecb'            => new sfValidatorInteger(array('required' => false)),
      'statut'         => new sfValidatorInteger(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'commandes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Commande', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Transaction';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['commandes_list']))
    {
      $this->setDefault('commandes_list', $this->object->Commandes->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCommandesList($con);

    parent::doSave($con);
  }

  public function saveCommandesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['commandes_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Commandes->getPrimaryKeys();
    $values = $this->getValue('commandes_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Commandes', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Commandes', array_values($link));
    }
  }

}
