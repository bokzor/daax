<?php

/**
 * imprimante actions.
 *
 * @package    spotiz
 * @subpackage imprimante
 * @author     Adrien Bokor <adrien@bokor.be>

 */
class imprimanteActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
}
