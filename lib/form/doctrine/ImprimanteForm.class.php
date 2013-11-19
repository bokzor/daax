<?php

/**
 * Imprimante form.
 *
 * @package    spotiz
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImprimanteForm extends BaseImprimanteForm
{
  public function configure()
  {
  	$this->widgetSchema['facture']->setLabel('Imprimer facture');

  }
}
