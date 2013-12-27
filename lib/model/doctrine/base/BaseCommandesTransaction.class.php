<?php

/**
 * BaseCommandesTransaction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $transaction_id
 * @property integer $commande_id
 * @property Transaction $Transaction
 * @property Commande $Commande
 * 
 * @method integer              getTransactionId()  Returns the current record's "transaction_id" value
 * @method integer              getCommandeId()     Returns the current record's "commande_id" value
 * @method Transaction          getTransaction()    Returns the current record's "Transaction" value
 * @method Commande             getCommande()       Returns the current record's "Commande" value
 * @method CommandesTransaction setTransactionId()  Sets the current record's "transaction_id" value
 * @method CommandesTransaction setCommandeId()     Sets the current record's "commande_id" value
 * @method CommandesTransaction setTransaction()    Sets the current record's "Transaction" value
 * @method CommandesTransaction setCommande()       Sets the current record's "Commande" value
 * 
 * @package    LiveOrder
 * @subpackage model
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCommandesTransaction extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('commandes_transaction');
        $this->hasColumn('transaction_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('commande_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Transaction', array(
             'local' => 'transaction_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Commande', array(
             'local' => 'commande_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}