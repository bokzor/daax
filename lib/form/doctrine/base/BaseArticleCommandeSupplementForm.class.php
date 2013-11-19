<?php

/**
 * ArticleCommandeSupplement form base class.
 *
 * @method ArticleCommandeSupplement getObject() Returns the current form's model object
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseArticleCommandeSupplementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_commande_id' => new sfWidgetFormInputHidden(),
      'supplement_id'       => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'article_commande_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('article_commande_id')), 'empty_value' => $this->getObject()->get('article_commande_id'), 'required' => false)),
      'supplement_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('supplement_id')), 'empty_value' => $this->getObject()->get('supplement_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('article_commande_supplement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArticleCommandeSupplement';
  }

}
