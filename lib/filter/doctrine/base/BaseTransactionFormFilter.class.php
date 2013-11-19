<?php

/**
 * Transaction filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTransactionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'server_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Server'), 'add_empty' => true)),
      'client_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'add_empty' => true)),
      'cash'           => new sfWidgetFormFilterInput(),
      'cb'             => new sfWidgetFormFilterInput(),
      'cashback'       => new sfWidgetFormFilterInput(),
      'ecb'            => new sfWidgetFormFilterInput(),
      'statut'         => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'commandes_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Commande')),
    ));

    $this->setValidators(array(
      'server_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Server'), 'column' => 'id')),
      'client_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Client'), 'column' => 'id')),
      'cash'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cb'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cashback'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ecb'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'statut'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'commandes_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Commande', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('transaction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCommandesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.CommandesTransaction CommandesTransaction')
      ->andWhereIn('CommandesTransaction.commande_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Transaction';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'server_id'      => 'ForeignKey',
      'client_id'      => 'ForeignKey',
      'cash'           => 'Number',
      'cb'             => 'Number',
      'cashback'       => 'Number',
      'ecb'            => 'Number',
      'statut'         => 'Number',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'commandes_list' => 'ManyKey',
    );
  }
}
