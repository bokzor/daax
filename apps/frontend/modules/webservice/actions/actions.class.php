<?php

/**
 * webservice actions.
 *
 * @package    spotiz
 * @subpackage webservice
 * "Adrien Bokor <adrien@bokor.be>"
 */
class webserviceActions extends sfActions {

	public function preExecute() {
		$this -> model = $this -> getRequest() -> getParameter( 'model' );

		if ( !class_exists( $this -> model ) )
			//$this -> forward('webservice', 'error');
			echo '';
	}

	public function executeList( sfWebRequest $request ) {
		if ( $request -> isMethod( sfRequest::POST ) )
			$this -> forward( 'webservice', 'create' );

		$this -> objects = Doctrine_Core::getTable( $this -> model ) -> findAll();
	}

	public function executeCreate( sfWebRequest $request ) {
		$formClass = $this -> model . "Form";
		$form = new $formClass( null, array(), false );

		$form -> bind( $request -> getParameter( $form -> getName() ), $request -> getFiles( $form -> getName() ) );
		$this -> form = $form;
		if ( $form -> isValid() ) {
			$this -> object = $form -> save();
			$this -> setTemplate( 'find' );
		}

	}

	public function executeGet( sfWebRequest $request ) {
		$id = $request -> getParameter( 'id' );
		$this -> object = Doctrine_Core::getTable( $this -> model ) -> findOneById( $id );
		$this -> forward404Unless( $this -> object );
		$this -> setTemplate( 'find' );

	}

	public function executeUpdate( sfWebRequest $request ) {
		$id = $request -> getParameter( 'id' );
		// on genere le nom du formulaire
		$formClass = $this -> model . "Form";
		// on recupere l'objet a modifier
		$this -> object = Doctrine_Core::getTable( $this -> model ) -> findOneById( $id );
		// on genere un nouvel objet form
		$form = new $formClass( $this -> object );
		$this -> forward404Unless( $this -> object );
		// on vérifie si le form est valide et on sauvegarde les modifs
		$form->bind( $request->getParameter( $form->getName() ) , $request->getFiles( $form->getName() ) );
	    if ( $form->isValid() ) {
	    	$this -> object = $form->save();
	    }

		// parametres des relations
		$rel = ( $request -> getPostParameter( 'rel' ) );

		if ( $this->model == 'article' ) {
			Doctrine_Query::create()->delete( 'ArticleElement' )->where( 'article_id = ?', $this -> object -> getId() ) -> execute();
			if ( isset( $rel['articleElement']['id'] ) and isset( $rel['articleElement']['deduire'] ) ) {
				$result = array_combine( $rel['articleElement']['id'], $rel['articleElement']['deduire'] );
				foreach ( $result as $id => $deduire ) {
					if ( $deduire>0 and $id >0 ) {
						$articleElement = new ArticleElement();
						$articleElement->setArticleId ( $this -> object -> getId() );
						$articleElement->setElementId( $id );
						$articleElement->setADeduire( $deduire );
						$articleElement->save();
					}
				}
			}
		}
		elseif ( $this->model == 'category' ) {
			Doctrine_Query::create()->delete( 'categoryImprimante' )->where( 'category_id = ?', $this -> object -> getId()) -> execute();
        	if ( isset( $rel['categoryImprimante']['id'] ) ) {
         		foreach ( $rel['categoryImprimante']['id'] as $id ) {
					if ( $id >0 ) {
						$categoryImprimante = new CategoryImprimante();
						$categoryImprimante->setCategoryId ( $this -> object -> getId() );
						$categoryImprimante->setImprimanteId( $id );
						$categoryImprimante->save();
					}
				}	
			}
		}

		$this -> setTemplate( 'find' );
	}

	public function executeDelete( sfWebRequest $request ) {
		$id = $request -> getParameter( 'id' );

		$this -> object = Doctrine_Core::getTable( $this -> model ) -> findOneById( $id );
		$this -> forward404Unless( $this -> object );
		$this -> object -> delete();

		$this -> setTemplate( 'single' );
	}

	public function executeError( sfWebRequest $request ) {
		$model = $request -> getParameter( 'model' );

		$this -> getResponse() -> setStatusCode( 500 );

		$this -> error = ( $model != null ) ? "Invalid model: " . $model : "Undefined model";
	}

}
