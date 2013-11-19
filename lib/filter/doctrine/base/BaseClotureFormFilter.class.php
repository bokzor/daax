<?php

/**
 * Cloture filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseClotureFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nb_transaction_cash'    => new sfWidgetFormFilterInput(),
      'nb_transaction_cb'      => new sfWidgetFormFilterInput(),
      'nb_transaction_ecb'     => new sfWidgetFormFilterInput(),
      'total_transaction_cash' => new sfWidgetFormFilterInput(),
      'total_transaction_cb'   => new sfWidgetFormFilterInput(),
      'total_transaction_ecb'  => new sfWidgetFormFilterInput(),
      'id_user_record'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ServerRecord'), 'add_empty' => true)),
      'total_record'           => new sfWidgetFormFilterInput(),
      'server_id'              => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'nb_transaction_cash'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nb_transaction_cb'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nb_transaction_ecb'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_transaction_cash' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_transaction_cb'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_transaction_ecb'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_user_record'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ServerRecord'), 'column' => 'id')),
      'total_record'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'server_id'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('cloture_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cloture';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'nb_transaction_cash'    => 'Number',
      'nb_transaction_cb'      => 'Number',
      'nb_transaction_ecb'     => 'Number',
      'total_transaction_cash' => 'Number',
      'total_transaction_cb'   => 'Number',
      'total_transaction_ecb'  => 'Number',
      'id_user_record'         => 'ForeignKey',
      'total_record'           => 'Number',
      'server_id'              => 'Number',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
    );
  }
}
