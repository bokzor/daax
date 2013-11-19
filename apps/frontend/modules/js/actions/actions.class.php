<?php

/**
 * js actions.
 *
 * @package    spotiz
 * @subpackage js
 * "Adrien Bokor <adrien@bokor.be>"

 */
class jsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
	$this->getResponse()->setContentType('text/javascript');

  }
}
