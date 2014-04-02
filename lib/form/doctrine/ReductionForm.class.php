<?php

/**
 * Reduction form.
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReductionForm extends BaseReductionForm
{
  public function configure()
  {
    // change le type de l'input
    $this->widgetSchema['start_date'] = new sfWidgetFormInput();
    $this->widgetSchema['end_date'] = new sfWidgetFormInput();
    $this->widgetSchema['start_time'] = new sfWidgetFormInput();
    $this->widgetSchema['end_time'] = new sfWidgetFormInput();
    $this->widgetSchema['groupe_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['type'] = new sfWidgetFormInputHidden();
    // change les labels
    $this->widgetSchema['is_publish'] -> setLabel('Actif ?');
    $this->widgetSchema['nb_acheter'] -> setLabel('Nombre acheté');
    $this->widgetSchema['nb_offert'] -> setLabel('Nombre offert');
    $this->widgetSchema['new_price'] -> setLabel('Nouveau prix');
    $this->widgetSchema['pourcent_article'] -> setLabel('Pourcentage de réduction');
    $this->widgetSchema['auto_reduction'] -> setLabel('Réduction automatique');
    $this->widgetSchema['code'] -> setLabel('Code promo');
    $this->widgetSchema['always_activate'] -> setLabel('Toujours actif');
    $this->widgetSchema['start_date'] -> setLabel('Début promo');
    $this->widgetSchema['end_date'] -> setLabel('Fin promo');
    $this->widgetSchema['start_time'] -> setLabel('Tranche horaire');
    $this->widgetSchema['end_time'] -> setLabel(' ');

    $this -> widgetSchema['article_id'] = new sfWidgetFormDoctrineChoice( array( 
            'model' => $this->getRelatedModelName( 'Article' ), 
            'add_empty' => true, 
            'query' => Doctrine::getTable('Article')->createQuery('c')->orderBy('c.name ASC')
            ));


  }
}
