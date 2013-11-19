<?php

/**
 * home actions.
 *
 * @package    spotiz
 * @subpackage home
 * "Adrien Bokor <adrien@bokor.be>"

 */
class homeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('commande', 'index');
  }
  
  public function executeInscription(sfWebRequest $request)
  {
    //$this->forward('commande', 'index');
    $this -> form = new sfGuardRegisterForm();
  }
  
}
