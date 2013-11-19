<?php

/**
 * category actions.
 *
 * @package    spotiz
 * @subpackage category
 * @author     Adrien et Maxime
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public
	function executeNew( sfWebRequest $request ) {

		$category = new Category();
		$this->form = new CategoryForm( $category );
		$this->setTemplate( 'update' );
	}
	public
	function executeCreate( sfWebRequest $request ) {

		$this->forward404Unless( $request->isMethod( sfRequest::POST ) );
		$this->form = new CategoryForm();
		$this->processForm( $request, $this->form );
		$this->setTemplate( 'update' );
		$this->redirect( '@gestion_tools' );
	}
	public
	function executeEdit( sfWebRequest $request ) {

		$this->forward404Unless( $category = Doctrine_Core::getTable( 'Category' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object article does not exist (%s).', $request->getParameter( 'id' ) ) );
		$this -> categoryImprimantes = Doctrine::getTable( 'categoryImprimante' )->createQuery( 'a' )->where( 'category_id = ?', $request->getParameter( 'id' ) ) -> execute();
		$this -> imprimantes = Doctrine::getTable( 'Imprimante' )->createQuery( 'a' )-> execute();
		$this->form = new CategoryForm( $category );
		$this->setTemplate( 'update' );
	}
	public
	function executeUpdate( sfWebRequest $request ) {

		$this->forward404Unless( $request->isMethod( sfRequest::POST ) || $request->isMethod( sfRequest::PUT ) );
		$this->forward404Unless( $category = Doctrine_Core::getTable( 'Category' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object element does not exist (%s).', $request->getParameter( 'id' ) ) );
		$this->form = new CategoryForm( $category );
		$this->processForm( $request, $this->form );
		$this->setTemplate( 'update' );
		$this->redirect( '@gestion_tools' );
	}
	public
	function executeDelete( sfWebRequest $request ) {

		$this->forward404Unless( $category = Doctrine_Core::getTable( 'Category' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object element does not exist (%s).', $request->getParameter( 'id' ) ) );
		$category->delete();
		$this->redirect( '@gestion_tools' );
	}
	protected
	function processForm( sfWebRequest $request, sfForm $form ) {

		$form->bind( $request->getParameter( $form->getName() ) , $request->getFiles( $form->getName() ) );

		if ( $form->isValid() ) {
			$category = $form->save();
			Doctrine_Query::create()->delete( 'categoryImprimante' )->where( 'category_id = ?', $category->getId() ) -> execute();
			if ( isset( $_POST['id'] )) {
				foreach ( $_POST['id'] as $id) {
						$categoryImprimante = new CategoryImprimante();
						$categoryImprimante->setCategoryId ( $category -> getId() );
						$categoryImprimante->setImprimanteId( $id );
						$categoryImprimante->save();
				}
			}
		}
	}
	public
	function executeCategoryImprimante( sfWebRequest $request ) {

		$this->c = intval( $request->getParameter( 'c' ) );
		$this->imprimantes = Doctrine::getTable( 'Imprimante' )->createQuery( 'a' )->execute();
	}
}
