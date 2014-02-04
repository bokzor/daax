<?php
/**
 * article actions.
 *
 * @package    spotiz
 * @subpackage article
 * "Adrien Bokor <adrien@bokor.be>"
 */

class articleActions extends sfActions {
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public
	function executeListing( sfWebRequest $request ) {

		$this->articles = Doctrine::getTable( 'Article' )->createQuery( 'a' )->leftjoin( 'a.Category' )->execute();
	}
	function executeListingTest( sfWebRequest $request ) {

	}
	public
	function executeNew( sfWebRequest $request ) {

		$article = new Article();
		$this->form = new ArticleForm( $article );
		$this->setTemplate( 'update' );
	}
	public
	function executeCreate( sfWebRequest $request ) {

		$this->forward404Unless( $request->isMethod( sfRequest::POST ) );
		$this->form = new ArticleForm();
		$this->processForm( $request, $this->form );
		$this->setTemplate( 'update' );
		$this->redirect( '@gestion_article' );
	}
	public
	function executeEdit( sfWebRequest $request ) {

		$this->forward404Unless( $article = Doctrine_Core::getTable( 'Article' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object article does not exist (%s).', $request->getParameter( 'id' ) ) );
		$this -> articleElements = Doctrine::getTable( 'ArticleElement' )->createQuery( 'a' )->where( 'article_id = ?', $request->getParameter( 'id' ) ) -> execute();
		$this -> elements = Doctrine::getTable( 'Element' )->createQuery( 'a' )-> execute();
		$this->form = new ArticleForm( $article );
		$this->setTemplate( 'update' );
	}
	public
	function executeUpdate( sfWebRequest $request ) {

		$this->forward404Unless( $request->isMethod( sfRequest::POST ) || $request->isMethod( sfRequest::PUT ) );
		$this->forward404Unless( $article = Doctrine_Core::getTable( 'Article' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object article does not exist (%s).', $request->getParameter( 'id' ) ) );
		$this->form = new ArticleForm( $article );
		$this->processForm( $request, $this->form );
		$this->setTemplate( 'update' );
		$this->redirect( '@gestion_article' );
	}
	public
	function executeDelete( sfWebRequest $request ) {

		$this->forward404Unless( $article = Doctrine_Core::getTable( 'Article' )->find( array(
					$request->getParameter( 'id' )
				) ) , sprintf( 'Object article does not exist (%s).', $request->getParameter( 'id' ) ) );
		$article->delete();
		$this->redirect( '@gestion_article' );
	}
	protected
	function processForm( sfWebRequest $request, sfForm $form ) {

		$form->bind( $request->getParameter( $form->getName() ) , $request->getFiles( $form->getName() ) );

		if ( $form->isValid() ) {
			$article = $form->save();
			Doctrine_Query::create()->delete( 'ArticleElement' )->where( 'article_id = ?', $article->getId() ) -> execute();
			if ( isset( $_POST['id'] ) and isset( $_POST['deduire'] ) ) {
				$result = array_combine( $_POST['id'], $_POST['deduire'] );
				foreach ( $result as $id => $deduire ) {
					if ( $deduire>0 and $id >0 ) {
						$articleElement = new ArticleElement();
						$articleElement->setArticleId ( $article -> getId() );
						$articleElement->setElementId( $id );
						$articleElement->setADeduire( $deduire );
						$articleElement->save();
					}
				}
			}
		}
	}
	public
	function executeArticleElement( sfWebRequest $request ) {

		$this->c = intval( $request->getParameter( 'c' ) );
		$this->elements = Doctrine::getTable( 'Element' )->createQuery( 'a' )->orderBy('a.name') -> execute();
	}

	//calcul le prix, en fonction des promos, ou de si la bourse est activé
	public
	function executeCalculerPrix( sfWebRequest $request ) {

		$id = intval( $request->getParameter( 'id' ) );
		if(sfConfig::get('sf_environment') === 'bourse'){
			$q = Doctrine_Manager::getInstance()->getCurrentConnection();

			$result = $q->execute( 'SELECT article_id, SUM(count) as total FROM article_commande where article_id = '.$id.' GROUP BY article_id' );
			$result = $result -> fetchAll();
			if ( isset( $result[0] ) ) {
				$total = $result[0]['total'];
			}
			else {
				$total = 1;
			}
			$result = $q->execute( 'select avg(total) as moyenne from(SELECT article_id, SUM(count) as total FROM article_commande  GROUP BY article_id) as A' );
			$result = $result -> fetchAll();
			if ( isset( $result[0] ) and $result[0]['moyenne'] != 0 ) {
				$moyenne =  $result[0]['moyenne'];
			}
			else {
				$moyenne = 1;
			}
			$prix_base = Doctrine_Core::getTable( 'Article' ) -> findOneById( $id ) -> getPrix();
			$prix_min = round( $prix_base - ( $prix_base/2.5 ), 1 );
			$index = round( ( $prix_min/4 ), 1 );

			$prix = round( ( $total/$moyenne * $index + $prix_min ), 1 );

			if ( $prix < $prix_min ) {
				$prix = $prix_min;
			}				

		}else{
			$prix = Doctrine_Core::getTable( 'Article' ) -> findOneById( $id ) -> getPrix();
		}

		return $this->renderText( $prix );	
	}

}
