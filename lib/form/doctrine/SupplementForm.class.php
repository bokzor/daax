<?php

/**
 * Supplement form.
 *
 * @package    spotiz
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SupplementForm extends BaseSupplementForm
{
  public function configure()
  {
    // les labels des champs
    $this->widgetSchema->setLabels(array(
      'fois_prix'   => 'Multipler le prix de départ',
      'plus_prix' => 'Ajouter au prix de départ',
      'name' => 'Supplément',
      'category_id' => 'Catégorie'
    ));
  }
}
