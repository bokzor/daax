<?php

/**
 * Reduction filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseReductionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'add_empty' => true)),
      'groupe_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Groupe'), 'add_empty' => true)),
      'nb_acheter'        => new sfWidgetFormFilterInput(),
      'nb_offert'         => new sfWidgetFormFilterInput(),
      'new_price'         => new sfWidgetFormFilterInput(),
      'pourcent_article'  => new sfWidgetFormFilterInput(),
      'pourcent_commande' => new sfWidgetFormFilterInput(),
      'is_publish'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'code'              => new sfWidgetFormFilterInput(),
      'always_activate'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'auto_reduction'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'start_date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'end_date'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'start_time'        => new sfWidgetFormFilterInput(),
      'end_time'          => new sfWidgetFormFilterInput(),
      'type'              => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'article_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Article'), 'column' => 'id')),
      'groupe_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Groupe'), 'column' => 'id')),
      'nb_acheter'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nb_offert'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'new_price'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pourcent_article'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pourcent_commande' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_publish'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'code'              => new sfValidatorPass(array('required' => false)),
      'always_activate'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'auto_reduction'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'start_date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'end_date'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'start_time'        => new sfValidatorPass(array('required' => false)),
      'end_time'          => new sfValidatorPass(array('required' => false)),
      'type'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('reduction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Reduction';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'article_id'        => 'ForeignKey',
      'groupe_id'         => 'ForeignKey',
      'nb_acheter'        => 'Number',
      'nb_offert'         => 'Number',
      'new_price'         => 'Number',
      'pourcent_article'  => 'Number',
      'pourcent_commande' => 'Number',
      'is_publish'        => 'Boolean',
      'code'              => 'Text',
      'always_activate'   => 'Boolean',
      'auto_reduction'    => 'Boolean',
      'start_date'        => 'Date',
      'end_date'          => 'Date',
      'start_time'        => 'Text',
      'end_time'          => 'Text',
      'type'              => 'Number',
    );
  }
}
