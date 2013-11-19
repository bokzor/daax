<?php

/**
 * Element form base class.
 *
 * @method Element getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseElementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'name'               => new sfWidgetFormInputText(),
      'img'                => new sfWidgetFormInputText(),
      'is_publish'         => new sfWidgetFormInputCheckbox(),
      'category_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'stock_minimum'      => new sfWidgetFormInputText(),
      'stock_actuel'       => new sfWidgetFormInputText(),
      'conditionnement_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Conditionnement'), 'add_empty' => true)),
      'fournisseur_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Fournisseur'), 'add_empty' => true)),
      'nombre_unite'       => new sfWidgetFormInputText(),
      'prix_achat'         => new sfWidgetFormInputText(),
      'reference'          => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'slug'               => new sfWidgetFormInputText(),
      'article_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'               => new sfValidatorString(array('max_length' => 100)),
      'img'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_publish'         => new sfValidatorBoolean(array('required' => false)),
      'category_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)),
      'stock_minimum'      => new sfValidatorNumber(array('required' => false)),
      'stock_actuel'       => new sfValidatorNumber(array('required' => false)),
      'conditionnement_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Conditionnement'), 'required' => false)),
      'fournisseur_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Fournisseur'), 'required' => false)),
      'nombre_unite'       => new sfValidatorNumber(array('required' => false)),
      'prix_achat'         => new sfValidatorNumber(array('required' => false)),
      'reference'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'slug'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'article_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Element', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('element[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Element';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['article_list']))
    {
      $this->setDefault('article_list', $this->object->Article->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveArticleList($con);

    parent::doSave($con);
  }

  public function saveArticleList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['article_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Article->getPrimaryKeys();
    $values = $this->getValue('article_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Article', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Article', array_values($link));
    }
  }

}
