<?php

/**
 * Article form base class.
 *
 * @method Article getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseArticleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'img'           => new sfWidgetFormInputText(),
      'is_publish'    => new sfWidgetFormInputCheckbox(),
      'category_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'prix'          => new sfWidgetFormInputText(),
      'description'   => new sfWidgetFormTextarea(),
      'temps_prepa'   => new sfWidgetFormInputText(),
      'count'         => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'slug'          => new sfWidgetFormInputText(),
      'commande_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Commande')),
      'elements_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Element')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 100)),
      'img'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_publish'    => new sfValidatorBoolean(array('required' => false)),
      'category_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)),
      'prix'          => new sfValidatorNumber(array('required' => false)),
      'description'   => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'temps_prepa'   => new sfValidatorInteger(array('required' => false)),
      'count'         => new sfValidatorInteger(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'slug'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'commande_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Commande', 'required' => false)),
      'elements_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Element', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Article', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('article[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Article';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['commande_list']))
    {
      $this->setDefault('commande_list', $this->object->Commande->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['elements_list']))
    {
      $this->setDefault('elements_list', $this->object->Elements->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCommandeList($con);
    $this->saveElementsList($con);

    parent::doSave($con);
  }

  public function saveCommandeList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['commande_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Commande->getPrimaryKeys();
    $values = $this->getValue('commande_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Commande', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Commande', array_values($link));
    }
  }

  public function saveElementsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['elements_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Elements->getPrimaryKeys();
    $values = $this->getValue('elements_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Elements', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Elements', array_values($link));
    }
  }

}
