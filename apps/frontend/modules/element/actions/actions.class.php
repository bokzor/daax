<?php
/**
 * stock actions.
 *
 * @package    spotiz
 * @subpackage stock
 * "Adrien Bokor <adrien@bokor.be>"

 */

class elementActions extends sfActions {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public 
    function executeListing(sfWebRequest $request) {

	$this->elements = Doctrine::getTable('Element')->createQuery('a')->leftjoin('a.Conditionnement') -> leftjoin('a.Category')->execute();
    }
    public 
    function executeNew(sfWebRequest $request) {

	$element = new Element();
	$this->form = new ElementForm($element);
	$this->setTemplate('update');
    }
    public 
    function executeCreate(sfWebRequest $request) {

	$this->forward404Unless($request->isMethod(sfRequest::POST));
	$this->form = new ElementForm();
	$this->processForm($request, $this->form);
	$this->setTemplate('update');
	$this->redirect('@gestion_stock');
    }
    public 
    function executeEdit(sfWebRequest $request) {

	$this->forward404Unless($element = Doctrine_Core::getTable('Element')->find(array(
	    $request->getParameter('id')
	)) , sprintf('Object article does not exist (%s).', $request->getParameter('id')));
	$this->form = new ElementForm($element);
	$this->setTemplate('update');
    }
    public 
    function executeUpdate(sfWebRequest $request) {

	$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
	$this->forward404Unless($element = Doctrine_Core::getTable('Element')->find(array(
	    $request->getParameter('id')
	)) , sprintf('Object element does not exist (%s).', $request->getParameter('id')));
	$this->form = new ElementForm($element);
	$this->processForm($request, $this->form);
	$this->setTemplate('update');
	$this->redirect('@gestion_stock');
    }
    public 
    function executeDelete(sfWebRequest $request) {

	$this->forward404Unless($element = Doctrine_Core::getTable('Element')->find(array(
	    $request->getParameter('id')
	)) , sprintf('Object element does not exist (%s).', $request->getParameter('id')));
	$element->delete();
	$this->redirect('@gestion_stock');
    }
    protected 
    function processForm(sfWebRequest $request, sfForm $form) {

	$form->bind($request->getParameter($form->getName()) , $request->getFiles($form->getName()));
	
	if ($form->isValid()) {
	    $element = $form->save();
	}
    }
}
