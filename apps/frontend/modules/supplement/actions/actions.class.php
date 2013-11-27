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
	public
	function executeSupplement( sfWebRequest $request ){
		$id = $request->getParameter('id');
		if(!$this->getUser()->hasCredential('serveur'))
			$this->supplements = Doctrine::getTable('Supplement') -> createQuery('a')->where('category_id = ?', $id) -> orWhere('category_id is NULL') -> andWhere('visible_user = ?', 1) -> execute();
		else{
			$this->supplements = Doctrine::getTable('Supplement') -> createQuery('a')->where('category_id = ?', $id) -> orWhere('category_id is NULL') -> execute();
		}

	}
}
