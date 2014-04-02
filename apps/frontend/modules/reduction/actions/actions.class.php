<?php

/**
 * reduction actions.
 *
 * @package    LiveOrder
 * @subpackage reduction
 * @author     Adrien Bokor <adrien@bokor.be>
 */
class reductionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  // function qui liste les groupes de reductions
  public function executeListing(sfWebRequest $request){
    $this->groupes = Doctrine::getTable( 'GroupeReduction' )->createQuery( 'a' ) -> execute();
  }
  // function qui liste les reductions d'un groupe
  public function executeListingReduction(sfWebRequest $request){
    $this->id = $request->getParameter('id');
    $this->reductionsArticle = Doctrine::getTable( 'Reduction' )->createQuery( 'r' ) -> leftjoin('r.Article a') -> where('groupe_id = ?', $this->id) -> andWhere('type = ?', 1) ->execute();
    $this->reductionsCommande = Doctrine::getTable( 'Reduction' )->createQuery( 'r' ) -> leftjoin('r.Article a') -> where('groupe_id = ?', $this->id) -> andWhere('type = ?', 2) ->execute();
  }




  // fonction qui permet d'ajouter un nouveau groupe de reduction
  public function executeNewGroupe(sfWebRequest $request){
    $this -> model = 'GroupeReduction';
    $groupe = new GroupeReduction();
    $this->form = new GroupeReductionForm($groupe);
    $this->setTemplate('updateGroupeReduction');    
  }

  // fonction qui valide le formulaire
  public function executeCreateGroupe( sfWebRequest $request ) {
    $this->forward404Unless( $request->isMethod( sfRequest::POST ) );
    $this -> form = new GroupeReductionForm();
    $result = $this->processForm( $request, $this->form );
    $this->setTemplate( 'updateGroupeReduction');
    $this->redirect( '@gestion_reduction');
  }

  //fonction qui edite les groupes de reductions
  public function executeEditGroupe(sfWebRequest $request){
    $this -> model = 'GroupeReduction';
    $this->forward404Unless( $groupe = Doctrine_Core::getTable( 'GroupeReduction' )->find( array(
          $request->getParameter( 'id' )
        ) ) , sprintf( 'Object article does not exist (%s).', $request->getParameter( 'id' ) ) );
    $this->form = new GroupeReductionForm( $groupe );
    $this->setTemplate( 'updateGroupeReduction' );
  }

  // fonction qui permet d'ajouter une nouvelle reduction sur un article
  public function executeNewArticle(sfWebRequest $request){
    $this -> model = 'reduction';
    $groupe_id = $request->getParameter('id');
    $reduction = new Reduction();
    $reduction -> setType(1);
    $reduction -> setGroupeId($groupe_id);
    $this->form = new ReductionForm($reduction);
    $this->setTemplate('updateArticle');    
  }

  // fonction qui permet d'ajouter une nouvelle reduction sur une commande
  public function executeNewCommande(sfWebRequest $request){
    $this -> model = 'reduction';
    $groupe_id = $request->getParameter('id');
    $reduction = new Reduction();
    $reduction->setType(2);
    $reduction -> setGroupeId($groupe_id);
    $this->form = new ReductionForm($reduction);
    $this->setTemplate('updateCommande');    
  }

   // fonction qui permet cree une nouvelle reduction
  public function executeCreateReduction(sfWebRequest $request){
    $this->forward404Unless( $request->isMethod( sfRequest::POST ) );
    $this -> form = new ReductionForm();
    $result = $this->processReductionForm( $request, $this->form );
    $this->setTemplate('updateArticle');    
  } 


  //fonction qui edite les reductions
  public function executeEditReduction(sfWebRequest $request){
    $this -> model = 'reduction';
    $this->forward404Unless( $reduction = Doctrine_Core::getTable( 'Reduction' )->find( array(
          $request->getParameter( 'id' )
        ) ) , sprintf( 'Object article does not exist (%s).', $request->getParameter( 'id' ) ) );
    $this->form = new ReductionForm( $reduction );
    if($reduction->getType()==1){
      $this->setTemplate( 'updateArticle' );
    }
    elseif($reduction->getType()==2){
      $this->setTemplate( 'updateCommande' );  
    }
  }

  public
  function executeUpdateReduction( sfWebRequest $request ) {
    $this->forward404Unless( $request->isMethod( sfRequest::POST ) || $request->isMethod( sfRequest::PUT ) );
    $this->forward404Unless( $reduction = Doctrine_Core::getTable( 'Reduction' )->find( array(
          $request->getParameter( 'id' )
        ) ) , sprintf( 'Object element does not exist (%s).', $request->getParameter( 'id' ) ) );
    $this->form = new ReductionForm( $reduction );
    $this->processReductionForm( $request, $this->form );

  }

  // fonction qui enregistre les données si le form est valide
  protected function processReductionForm( sfWebRequest $request, sfForm $form ) {
    $form->bind( $request->getParameter( $form->getName() ) , $request->getFiles( $form->getName() ) );
    if ( $form->isValid() ) {
      $form->save();
      $url = $this->generateUrl('listing_reduction', array('id' => $form->getObject()->getGroupeId() ) );
      $this->redirect($url);
    }else{
      if($form->getObject()->getType()==1){
        $this->setTemplate( 'updateArticle' );
      }
      elseif($form->getObject()->getType()==2){
        $this->setTemplate( 'updateCommande' );  
      }
    }
  }


  // fonction qui enregistre les données si le form est valide
  protected function processForm( sfWebRequest $request, sfForm $form ) {
    $form->bind( $request->getParameter( $form->getName() ) , $request->getFiles( $form->getName() ) );
    if ( $form->isValid() ) {
      $form->save();
    }
  }

  public function executeGetActiveReduction(sfWebRequest $request){
    $this -> date = date("Y-m-d", time());

    $this->objects = Doctrine::getTable('GroupeReduction') 
    -> createQuery('a') -> innerJoin('a.Reduction r') -> where('a.is_active = ?', 1) -> andWhere('r.is_publish = ?', 1)
    -> andWhere('r.always_activate = ? 
      or ( 
        (r.start_date <=  ? and r.end_date >= ?) 
      )', array(1, $this -> date, $this -> date))



    -> orderBy('r.article_id desc') -> execute(array(), Doctrine_Core::HYDRATE_ARRAY);
    $newArray = array();
    foreach($this->objects as &$groupe){
      foreach($groupe['Reduction'] as $reduction){
        $newArray[] = $reduction;
      }
    }


    return $this->renderText(json_encode($newArray, JSON_NUMERIC_CHECK));  
}

}
