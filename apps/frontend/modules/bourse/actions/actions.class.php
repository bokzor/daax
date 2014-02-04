<?php

/**
 * bourse actions.
 *
 * @package    spotiz
 * @subpackage bourse
 * @author     Adrien Bokor <adrien@bokor.be>
 */
class bourseActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex( sfWebRequest $request ) {


	}

	public function executeBourseJson( sfWebRequest $request ) {



		$this->getResponse()->setHttpHeader( 'Cache-Control', 'no-cache' );
		$this->getResponse()->setHttpHeader( 'Pragma', 'no-cache' );
		$this->getResponse()->setHttpHeader( 'Expires', 0 );
		$arrayBourse = array();
		$arrayTempo = array();
		$q = Doctrine_Manager::getInstance()->getCurrentConnection();
		$i = 0;

		$result = $q->execute( 'select id, prix, name from article order by name asc' );
		$articles = $result -> fetchAll();

		$result = $q->execute( 'select avg(total) as moyenne from(SELECT article_id, SUM(count) as total FROM article_commande  GROUP BY article_id) as A' );
		$result = $result -> fetchAll();
		if ( isset( $result[0] ) and $result[0]['moyenne'] != 0 ) {
			$moyenne =  $result[0]['moyenne'];
		}
		else {
			$moyenne = 1;
		}

		$result = $q->execute( 'SELECT article_id, SUM(count) as total FROM article_commande GROUP BY article_id' );
		$results = $result -> fetchAll();
		// on va reformater le tableau
		foreach($results as $result){
			if ( isset( $result['article_id'] ) ) {
				$total = $result['total'];
			}
			else {
				$total = 1;
			}
			$arrayTempo[$result['article_id']]['total'] = $total;
			$arrayTempo[$result['article_id']]['id'] = $result['article_id'];

		}


		foreach ( $articles as $article ) {
			if(isset($arrayTempo[$article['id']])){
				$total = $arrayTempo[$article['id']]['total'];
			}
			else{
				$total = 1;
			}
			$prix_base = $article['prix'];
			$prix_min = round( $prix_base - ( $prix_base/2.5 ), 1 );
			$index = round( ( $prix_min/4 ), 1 );
			$prix = round( ( $total/$moyenne * $index + $prix_min ), 1 );
			if ( $prix < $prix_min ) {
				$prix = $prix_min;
			}
			$arrayBourse[$i]['id'] = $article['id'];
			$arrayBourse[$i]['prixBase'] = $article['prix'];
			$arrayBourse[$i]['name'] = $article['name'];
			$arrayBourse[$i]['prix'] = $prix;				
			$arrayBourse[$i]['variation'] = round(abs(($article['prix'] - $prix)/ $article['prix'] * 100),1);				


			$i++;

		}

		return $this->renderText( json_encode( $arrayBourse ) );
	}




	// doit retourner le prix de la boisson
	public function executeCalculer( sfWebRequest $request ) {
		$id = intval( $request->getParameter( 'id' ) );
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

		return $this->renderText( $prix );
	}

	public function executeStart( sfWebRequest $request){
			$q = Doctrine_Manager::getInstance()->getCurrentConnection();
			$result = $q->execute( 'delete from commande');

			$result = $q->execute( 'SELECT id FROM article' );
			$results = $result -> fetchAll();
			$commande = new Commande();
			$commande -> setServerId(1);
			$commande -> setClientId(1);
			$commande -> setStatutId(5);
			$commande -> save();
			foreach($results as $result){
				$ac = new articleCommande();
				$ac -> setArticleId($result['id']);
				$ac -> setCommandeId($commande->getId());
				$ac -> setCount(1);
				$ac -> save();
			}

	}


}
