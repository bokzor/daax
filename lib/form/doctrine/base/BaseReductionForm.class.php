<?php

/**
 * Reduction form base class.
 *
 * @method Reduction getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseReductionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'article_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'add_empty' => true)),
      'groupe_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Groupe'), 'add_empty' => false)),
      'nb_acheter'        => new sfWidgetFormInputText(),
      'nb_offert'         => new sfWidgetFormInputText(),
      'new_price'         => new sfWidgetFormInputText(),
      'pourcent_article'  => new sfWidgetFormInputText(),
      'pourcent_commande' => new sfWidgetFormInputText(),
      'is_publish'        => new sfWidgetFormInputCheckbox(),
      'code'              => new sfWidgetFormInputText(),
      'always_activate'   => new sfWidgetFormInputCheckbox(),
      'auto_reduction'    => new sfWidgetFormInputCheckbox(),
      'start_date'        => new sfWidgetFormDate(),
      'end_date'          => new sfWidgetFormDate(),
      'start_time'        => new sfWidgetFormTime(),
      'end_time'          => new sfWidgetFormTime(),
      'type'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'article_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'required' => false)),
      'groupe_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Groupe'))),
      'nb_acheter'        => new sfValidatorInteger(array('required' => false)),
      'nb_offert'         => new sfValidatorInteger(array('required' => false)),
      'new_price'         => new sfValidatorInteger(array('required' => false)),
      'pourcent_article'  => new sfValidatorInteger(array('required' => false)),
      'pourcent_commande' => new sfValidatorInteger(array('required' => false)),
      'is_publish'        => new sfValidatorBoolean(array('required' => false)),
      'code'              => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'always_activate'   => new sfValidatorBoolean(array('required' => false)),
      'auto_reduction'    => new sfValidatorBoolean(array('required' => false)),
      'start_date'        => new sfValidatorDate(array('required' => false)),
      'end_date'          => new sfValidatorDate(array('required' => false)),
      'start_time'        => new sfValidatorTime(array('required' => false)),
      'end_time'          => new sfValidatorTime(array('required' => false)),
      'type'              => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('reduction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reduction';
  }

}
