<?php

/**
 * ArticleCommande form base class.
 *
 * @method ArticleCommande getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseArticleCommandeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'article_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'add_empty' => true)),
      'promo_id'         => new sfWidgetFormInputText(),
      'commande_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Commande'), 'add_empty' => true)),
      'count'            => new sfWidgetFormInputText(),
      'prix'             => new sfWidgetFormInputText(),
      'comment'          => new sfWidgetFormInputText(),
      'supplements_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Supplement')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'article_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'required' => false)),
      'promo_id'         => new sfValidatorInteger(array('required' => false)),
      'commande_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Commande'), 'required' => false)),
      'count'            => new sfValidatorInteger(array('required' => false)),
      'prix'             => new sfValidatorNumber(array('required' => false)),
      'comment'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'supplements_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Supplement', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('article_commande[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArticleCommande';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['supplements_list']))
    {
      $this->setDefault('supplements_list', $this->object->Supplements->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveSupplementsList($con);

    parent::doSave($con);
  }

  public function saveSupplementsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['supplements_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Supplements->getPrimaryKeys();
    $values = $this->getValue('supplements_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Supplements', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Supplements', array_values($link));
    }
  }

}
