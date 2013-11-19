<?php
/**
 * utilisateur actions.
 *
 * @package    spotiz
 * @subpackage utilisateur
 * "Adrien Bokor <adrien@bokor.be>"

 */

class utilisateurActions extends sfActions {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public 
    function executeIndex(sfWebRequest $request) {

	$this->forward('default', 'module');
    }
    public 
    function executeListing(sfWebRequest $request) {

	$this->utilisateurs = Doctrine::getTable('sfGuardUser')->createQuery('a')->leftjoin('a.Groups')->execute();
    }
    public 
    function executeNew(sfWebRequest $request) {

	$utilisateur = new sfGuardUser();
	$this->form = new sfGuardRegisterForm($utilisateur);
	$this->setTemplate('update');
    }
    public 
    function executeCreate(sfWebRequest $request) {

	$this->forward404Unless($request->isMethod(sfRequest::POST));
	$this->form = new sfGuardRegisterForm();
	$this->processForm($request, $this->form);
	$this->setTemplate('update');
	
	if ($this->getUser()->isAuthenticated()) {
	    $this->redirect('@gestion_utilisateur');
	} else {
	    $this->redirect('@homepage');
	}
    }
    public 
    function executeEdit(sfWebRequest $request) {

	$this->forward404Unless($utilisateur = Doctrine_Core::getTable('sfGuardUser')->find(array(
	    $request->getParameter('id')
	)) , sprintf('Object article does not exist (%s).', $request->getParameter('id')));
	$this->form = new sfGuardRegisterForm($utilisateur);
	$this->setTemplate('update');
    }
    public 
    function executeUpdate(sfWebRequest $request) {


	//$this -> forward404Unless($request -> isMethod(sfRequest::POST) || $request -> isMethod(sfRequest::PUT));
	$this->forward404Unless($utilisateur = Doctrine_Core::getTable('sfGuardUser')->find(array(
	    $request->getParameter('id')
	)) , sprintf('Object article does not exist (%s).', $request->getParameter('id')));
	$this->form = new sfGuardRegisterForm($utilisateur);
	$this->processForm($request, $this->form);
	$this->setTemplate('update');
	$this->redirect('@gestion_utilisateur');
    }
    public 
    function executeDelete(sfWebRequest $request) {

	$request->checkCSRFProtection();
	$this->forward404Unless($utilisateur = Doctrine_Core::getTable('sfGuardUser')->find(array(
	    $request->getParameter('id')
	)) , sprintf('Object article does not exist (%s).', $request->getParameter('id')));
	$utilisateur->delete();
	$this->redirect('@gestion_utilisateur');
    }
    protected 
    function processForm(sfWebRequest $request, sfForm $form) {

	$form->bind($request->getParameter($form->getName()) , $request->getFiles($form->getName()));
	
	if ($form->isValid()) {
	    $utilisateur = $form->save();
	    $articles = Doctrine_Core::getTable('SfGuardUserGroup')->createQuery('c')->where('user_id = ?', $utilisateur->getId())->andwhere('group_id = ?', 4)->execute();
	    
	    if ($articles->count() == 0) {
		$userGroup = new sfGuardUserGroup();
		$userGroup->setUserId($utilisateur->getId());
		$userGroup->setGroupId(4);
		$userGroup->save();
	    }
	}
    }
}
