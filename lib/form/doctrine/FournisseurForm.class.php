<?php

/**
 * Fournisseur form.
 *
 * @package    spotiz
 * @subpackage form
 * "Adrien Bokor <adrien@bokor.be>"
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FournisseurForm extends BaseFournisseurForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);
  }
}
