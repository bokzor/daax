<?php

/**
 * GroupeReduction form.
 *
 * @package    LiveOrder
 * @subpackage form
 * @author     Adrien Bokor <adrien@bokor.be>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GroupeReductionForm extends BaseGroupeReductionForm
{
  public function configure()
  {
    $this->widgetSchema['name']->setLabel('Nom');
    $this->widgetSchema['is_active']->setLabel('Actif ?');
  }
}
