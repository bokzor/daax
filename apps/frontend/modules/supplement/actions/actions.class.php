<?php

/**
 * supplement actions.
 *
 * @package    spotiz
 * @subpackage supplement
 * @author     Adrien Bokor <adrien@bokor.be>

 */
class supplementActions extends sfActions
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
