<?php

/**
 * fournisseur actions.
 *
 * @package    spotiz
 * @subpackage fournisseur
 * "Adrien Bokor <adrien@bokor.be>"
 */
class fournisseurActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public
	function executeNew( sfWebRequest $request ) {

		$fournisseur = new Fournisseur();
		$this->form = new FournisseurForm( $fournisseur );
		$this->setTemplate( 'update' );
	}
	public
	function executeCreate( sfWebRequest $request ) {

		$this->forward404Unless( $request->isMethod( sfRequest::POST ) );
		$this->form = new FournisseurForm();
		$this->processForm( $request, $this->form );
		$this->setTemplate( 'update' );
		$this->redirect( '@gestion_tools' );
	}
	public
	function executeEdit( sfWebRequest $request ) {

		$this->forward404Unless( $fournisseur = Doctrine_Core::getTable( 'Fournisseur' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object article does not exist (%s).', $request->getParameter( 'id' ) ) );
		$this->form = new FournisseurForm( $fournisseur );
		$this->setTemplate( 'update' );
	}
	public
	function executeUpdate( sfWebRequest $request ) {

		$this->forward404Unless( $request->isMethod( sfRequest::POST ) || $request->isMethod( sfRequest::PUT ) );
		$this->forward404Unless( $fournisseur = Doctrine_Core::getTable( 'Fournisseur' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object element does not exist (%s).', $request->getParameter( 'id' ) ) );
		$this->form = new FournisseurForm( $fournisseur );
		$this->processForm( $request, $this->form );
		$this->setTemplate( 'update' );
		$this->redirect( '@gestion_tools' );
	}
	public
	function executeDelete( sfWebRequest $request ) {

		$this->forward404Unless( $fournisseur = Doctrine_Core::getTable( 'Fournisseur' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object element does not exist (%s).', $request->getParameter( 'id' ) ) );
		$fournisseur->delete();
		$this->redirect( '@gestion_tools' );
	}
	protected
	function processForm( sfWebRequest $request, sfForm $form ) {

		$form->bind( $request->getParameter( $form->getName() ) , $request->getFiles( $form->getName() ) );

		if ( $form->isValid() ) {
			$fournisseur = $form->save();
		}
	}
}
