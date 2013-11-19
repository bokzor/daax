<?php

/**
 * Category form base class.
 *
 * @method Category getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'img'              => new sfWidgetFormInputText(),
      'father_id'        => new sfWidgetFormInputText(),
      'is_publish'       => new sfWidgetFormInputCheckbox(),
      'slug'             => new sfWidgetFormInputText(),
      'root_id'          => new sfWidgetFormInputText(),
      'lft'              => new sfWidgetFormInputText(),
      'rgt'              => new sfWidgetFormInputText(),
      'level'            => new sfWidgetFormInputText(),
      'imprimantes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Imprimante')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 100)),
      'img'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'father_id'        => new sfValidatorInteger(array('required' => false)),
      'is_publish'       => new sfValidatorBoolean(array('required' => false)),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'root_id'          => new sfValidatorInteger(array('required' => false)),
      'lft'              => new sfValidatorInteger(array('required' => false)),
      'rgt'              => new sfValidatorInteger(array('required' => false)),
      'level'            => new sfValidatorInteger(array('required' => false)),
      'imprimantes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Imprimante', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Category', 'column' => array('name'))),
        new sfValidatorDoctrineUnique(array('model' => 'Category', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['imprimantes_list']))
    {
      $this->setDefault('imprimantes_list', $this->object->Imprimantes->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveImprimantesList($con);

    parent::doSave($con);
  }

  public function saveImprimantesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['imprimantes_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Imprimantes->getPrimaryKeys();
    $values = $this->getValue('imprimantes_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Imprimantes', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Imprimantes', array_values($link));
    }
  }

}
