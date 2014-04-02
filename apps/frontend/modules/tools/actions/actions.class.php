<?php

/**
 * tools actions.
 *
 * @package    spotiz
 * @subpackage tools
 * "Adrien Bokor <adrien@bokor.be>"
 */
class toolsActions extends sfActions
{


  public function preExecute() {
    $this -> model = $this -> getRequest() -> getParameter( 'model' );

    if ( !class_exists( $this -> model ) and $this->  getRequest() -> getParameter( 'action' ) != 'listing' )
      $this -> getResponse() -> setStatusCode( 500 );
    $this -> error = ( $this->model != null ) ? "Invalid model: " . $this->model : "Undefined model";
    return $this->renderText( $this->error );
  }

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public
  function executeListing( sfWebRequest $request ) {

    $this->categories = Doctrine::getTable( 'Category' )->createQuery( 'a' )-> addOrderBy( 'root_id asc' ) -> addOrderBy( 'lft asc' ) ->execute();
    $this->fournisseurs = Doctrine::getTable( 'Fournisseur' )->createQuery( 'a' )->execute();
    $this->imprimantes = Doctrine::getTable( 'Imprimante' )->createQuery( 'a' )->execute();
    $this->supplements = Doctrine::getTable( 'Supplement' )->createQuery( 'a' )->execute();

  }

  public
  function executeNew( sfWebRequest $request ) {
    ${$this->model} = new $this -> model();
    $classForm = $this -> model . 'Form';
    $this->form = new $classForm( ${$this->model} );
    $this->setTemplate( 'new', $this->model );
  }
  public
  function executeCreate( sfWebRequest $request ) {

    $this->forward404Unless( $request->isMethod( sfRequest::POST ) );
    $classForm = $this -> model . 'Form';
    $this -> form = new $classForm();
    $this->processForm( $request, $this->form );
    $this->setTemplate( 'update', $this->model );
    //$this->redirect( '@gestion_'.$this -> model );
  }
  public
  function executeEdit( sfWebRequest $request ) {
    $this->forward404Unless( ${$this->model} = Doctrine_Core::getTable( $this -> model )->find( array(
          $request->getParameter( 'id' )
        ) ) , sprintf( 'Object article does not exist (%s).', $request->getParameter( 'id' ) ) );
    if ( $this->model=='article' ) {
      $this -> articleElements = Doctrine::getTable( 'ArticleElement' )->createQuery( 'a' )->where( 'article_id = ?', $request->getParameter( 'id' ) ) -> execute();
      $this -> elements = Doctrine::getTable( 'Element' )->createQuery( 'a' )-> execute();
    }
    if ( $this->model=='category' ) {
      $this -> categoryImprimantes = Doctrine::getTable( 'categoryImprimante' )->createQuery( 'a' )->where( 'category_id = ?', $request->getParameter( 'id' ) ) -> execute();
      $this -> imprimantes = Doctrine::getTable( 'Imprimante' )->createQuery( 'a' )-> execute();

    }
    $classForm = $this -> model . 'Form';
    $this->form = new $classForm( ${$this->model} );
    $this->setTemplate( 'update', $this->model );
  }
  public
  function executeUpdate( sfWebRequest $request ) {
    $this->forward404Unless( $request->isMethod( sfRequest::POST ) || $request->isMethod( sfRequest::PUT ) );
    $this->forward404Unless( ${$this->model} = Doctrine_Core::getTable( $this -> model )->find( array(
          $request->getParameter( 'id' )
        ) ) , sprintf( 'Object element does not exist (%s).', $request->getParameter( 'id' ) ) );
    $classForm = $this -> model . 'Form';
    $this->form = new $classForm( ${$this->model} );
    $this->processForm( $request, $this->form );
    $this->setTemplate( 'update', $this->model );
    $this->redirect( '@gestion_'.$this -> model );
  }
  public
  function executeDelete( sfWebRequest $request ) {
    $this->forward404Unless( ${$this->model} = Doctrine_Core::getTable( $this->model )->find( array(
          $request->getParameter( 'id' )
        ) ) , sprintf( 'Object element does not exist (%s).', $request->getParameter( 'id' ) ) );
    ${$this->model}->delete();
    $this->redirect( '@gestion_'.$this -> model );
  }
  protected
  function processForm( sfWebRequest $request, sfForm $form ) {
    $form->bind( $request->getParameter( $form->getName() ) , $request->getFiles( $form->getName() ) );
    if ( $form->isValid() ) {
      ${$this->model} = $form->save();

      // parametres des relations
      $rel = ( $request -> getPostParameter( 'rel' ) );

      if ( $this->model == 'article' ) {
        Doctrine_Query::create()->delete( 'ArticleElement' )->where( 'article_id = ?', ${$this->model}->getId() ) -> execute();
      if ( isset( $rel['articleElement']['id'] ) and isset( $rel['articleElement']['deduire'] ) ) {
        $result = array_combine( $rel['articleElement']['id'], $rel['articleElement']['deduire'] );
          foreach ( $result as $id => $deduire ) {
            if ( $deduire>0 and $id >0 ) {
              $articleElement = new ArticleElement();
              $articleElement->setArticleId ( ${$this->model} -> getId() );
              $articleElement->setElementId( $id );
              $articleElement->setADeduire( $deduire );
              $articleElement->save();
            }
          }
        }
      }
      elseif ( $this->model == 'category' ) {

        Doctrine_Query::create()->delete( 'categoryImprimante' )->where( 'category_id = ?', $category->getId() ) -> execute();
        if ( isset( $rel['categoryImprimante']['id'] ) ) {
          foreach ( $rel['categoryImprimante']['id'] as $id ) {
            if ( $id >0 ) {
              $categoryImprimante = new CategoryImprimante();
              $categoryImprimante->setCategoryId ( $category -> getId() );
              $categoryImprimante->setImprimanteId( $id );
              $categoryImprimante->save();
            }
          }
        }
      }


    }
  }
  public function executeError( sfWebRequest $request ) {

  }

}
