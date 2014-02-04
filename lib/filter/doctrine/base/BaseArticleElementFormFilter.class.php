<?php

/**
 * ArticleElement filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseArticleElementFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'a_deduire'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'a_deduire'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('article_element_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArticleElement';
  }

  public function getFields()
  {
    return array(
      'article_id' => 'Number',
      'element_id' => 'Number',
      'a_deduire'  => 'Number',
    );
  }
}
