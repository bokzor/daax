<?php

/**
 * default actions.
 *
 * @package    spotiz
 * @subpackage default
 * "Adrien Bokor <adrien@bokor.be>"

 */
class defaultActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request) {

	}

	public function executeSecure() {
		//return sfVIEW::NONE;
	}

	public function executeError404() {
		 
	}

}

/**
 * Error page for page not found (404) error
 *
 */
