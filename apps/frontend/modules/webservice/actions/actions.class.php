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
		$referer = parse_url($_SERVER['HTTP_REFERER']);
		$scheme = $referer['scheme'];
		$referer = $referer['host'];
		$response = $this->getResponse();
		$response->setHttpHeader('Access-Control-Allow-Origin', $scheme.'://'.$referer);
		$response->setHttpHeader('Access-Control-Allow-Credentials', 'true');
	
		if( $this -> getRequest() -> getParameter( 'model' )) {
			$this -> model = $this -> getRequest() -> getParameter( 'model' );

			if ( !class_exists( $this -> model ) )
				//$this -> forward('webservice', 'error');
				echo '';
		}
		if($this -> model == 'utilisateur'){
			$this -> model = 'sfGuardRegister';
		}
	}

	public function executeGetInfos( sfWebRequest $request){
		$infos = array();
		$infos['server_id'] = $this->getUser()->getGuardUser()->getId();

		return $this->renderText(json_encode($infos));

	}



	public function executeList( sfWebRequest $request ) {
		if ( $request -> isMethod( sfRequest::POST ) )
			$this -> forward( 'webservice', 'create' );
		if($this -> model == 'article'){
			$this -> objects = Doctrine::getTable( $this -> model )->createQuery('a') 
			-> leftjoin('a.Category') -> execute(array(), Doctrine_Core::HYDRATE_ARRAY);
			foreach($this->objects as &$object){
				$object['category'] = $object['Category']['name'];
				$object['id_article'] = $object['id'];
				unset($object['id']);				
				unset($object['Category']);
				unset($object['description']);
			}
		}elseif($this->model = 'category'){
			$this -> objects = Doctrine::getTable( $this -> model )->createQuery('a') 
			-> execute(array(), Doctrine_Core::HYDRATE_ARRAY);	
		}

		return $this->renderText(json_encode($this -> objects, JSON_NUMERIC_CHECK));

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

	public function executeUser(sfWebRequest $request){
			$user = Doctrine::getTable('sfGuardUser')->createQuery('a')-> where('id = ?', $this->getUser()->getGuardUser()->getId())
			-> execute(array(), Doctrine_Core::HYDRATE_ARRAY);
			$object = array();
			if(count($user) === 1){
				$user = $user[0];
				$object['hash'] = $user['salt'];
				$object['first_name'] = $user['first_name'];
				$object['last_name'] = $user['last_name'];
				$object['avatar'] = $user['avatar'];
			}
		return $this->renderText(json_encode($object, JSON_NUMERIC_CHECK));
	}

	public function executeUsers(sfWebRequest $request){
			$users = Doctrine::getTable('sfGuardUser')->createQuery('a') -> select('a.id, a.first_name, a.last_name, a.avatar, a.credit, a.username')
			-> execute(array(), Doctrine_Core::HYDRATE_ARRAY);
			$object = array();
			foreach($users as &$object){
				$object['name'] = $object['first_name'] . ' ' . $object['last_name'];
				unset($object['id']);
			}
		return $this->renderText(json_encode($users, JSON_NUMERIC_CHECK));
	}


}
