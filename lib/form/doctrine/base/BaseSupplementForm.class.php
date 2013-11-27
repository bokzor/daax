<?php

/**
 * Supplement form base class.
 *
 * @method Supplement getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSupplementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'name'                   => new sfWidgetFormInputText(),
      'fois_prix'              => new sfWidgetFormInputText(),
      'plus_prix'              => new sfWidgetFormInputText(),
      'is_publish'             => new sfWidgetFormInputText(),
      'category_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'visible_user'           => new sfWidgetFormInputCheckbox(),
      'slug'                   => new sfWidgetFormInputText(),
      'article_commandes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ArticleCommande')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                   => new sfValidatorString(array('max_length' => 100)),
      'fois_prix'              => new sfValidatorNumber(array('required' => false)),
      'plus_prix'              => new sfValidatorNumber(array('required' => false)),
      'is_publish'             => new sfValidatorInteger(array('required' => false)),
      'category_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)),
      'visible_user'           => new sfValidatorBoolean(array('required' => false)),
      'slug'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'article_commandes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ArticleCommande', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Supplement', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('supplement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Supplement';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['article_commandes_list']))
    {
      $this->setDefault('article_commandes_list', $this->object->ArticleCommandes->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveArticleCommandesList($con);

    parent::doSave($con);
  }

  public function saveArticleCommandesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['article_commandes_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ArticleCommandes->getPrimaryKeys();
    $values = $this->getValue('article_commandes_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ArticleCommandes', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ArticleCommandes', array_values($link));
    }
  }

}
