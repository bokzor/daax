<?php

/**
 * Commande filter form base class.
 *
 * @package    LiveOrder
 * @subpackage filter
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCommandeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'server_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Server'), 'add_empty' => true)),
      'table_id'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'client_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'add_empty' => true)),
      'statut_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('StatutCommande'), 'add_empty' => true)),
      'total_commande'   => new sfWidgetFormFilterInput(),
      'total_prix_achat' => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'articles_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Article')),
      'transaction_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Transaction')),
    ));

    $this->setValidators(array(
      'server_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Server'), 'column' => 'id')),
      'table_id'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'client_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Client'), 'column' => 'id')),
      'statut_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('StatutCommande'), 'column' => 'id')),
      'total_commande'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_prix_achat' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'articles_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Article', 'required' => false)),
      'transaction_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Transaction', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commande_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addArticlesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ArticleCommande ArticleCommande')
      ->andWhereIn('ArticleCommande.article_id', $values)
    ;
  }

  public function addTransactionListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('CommandesTransaction.transaction_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Commande';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'server_id'        => 'ForeignKey',
      'table_id'         => 'Number',
      'client_id'        => 'ForeignKey',
      'statut_id'        => 'ForeignKey',
      'total_commande'   => 'Number',
      'total_prix_achat' => 'Number',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'articles_list'    => 'ManyKey',
      'transaction_list' => 'ManyKey',
    );
  }
}
