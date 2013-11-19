<?php

/**
 * Commande form base class.
 *
 * @method Commande getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommandeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'server_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Server'), 'add_empty' => false)),
      'table_id'         => new sfWidgetFormInputText(),
      'client_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'add_empty' => true)),
      'statut_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('StatutCommande'), 'add_empty' => false)),
      'total_commande'   => new sfWidgetFormInputText(),
      'total_prix_achat' => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'articles_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
      'transaction_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Transaction')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'server_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Server'))),
      'table_id'         => new sfValidatorInteger(),
      'client_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'required' => false)),
      'statut_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('StatutCommande'), 'required' => false)),
      'total_commande'   => new sfValidatorNumber(array('required' => false)),
      'total_prix_achat' => new sfValidatorNumber(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'articles_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
      'transaction_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Transaction', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commande[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commande';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['articles_list']))
    {
      $this->setDefault('articles_list', $this->object->Articles->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['transaction_list']))
    {
      $this->setDefault('transaction_list', $this->object->Transaction->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveArticlesList($con);
    $this->saveTransactionList($con);

    parent::doSave($con);
  }

  public function saveArticlesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['articles_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Articles->getPrimaryKeys();
    $values = $this->getValue('articles_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Articles', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Articles', array_values($link));
    }
  }

  public function saveTransactionList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['transaction_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Transaction->getPrimaryKeys();
    $values = $this->getValue('transaction_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Transaction', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Transaction', array_values($link));
    }
  }

}
