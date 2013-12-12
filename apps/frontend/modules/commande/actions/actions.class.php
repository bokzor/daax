<?php
/**
 * commande actions.
 *
 * @package    spotiz
 * @subpackage commande
 * @author     Adrien et Maxime
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class commandeActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        
        $q1 = Doctrine::getTable('Category')->createQuery('a')->leftjoin('a.Article c')->orderBy('c.name asc')->where('a.is_publish = ?', 1);
       // $q1->useResultCache(true, 3600, 'articles');
        $this->categories  = $q1->execute();
         
        $q2 = Doctrine::getTable('Article')->createQuery('a')->orderBy('a.count desc')->limit('16');
       // $q2->useResultCache(true, 3600, 'top_articles');
        $this->tops = $q2->execute(); 

    }
    public function executePayment(sfWebRequest $request)
    {
        
    }
    // fonction pour ajouter un commentaire a un article
    public function executeCommentaire(sfWebRequest $request)
    {
        
    }
    public function executeNew(sfWebRequest $request)
    {
        
        $articles     = $request->getParameter('commande');
        $articleTick = array();


        $commande     = new Commande();
        $total_commande   = 0;
        $total_prix_achat = 0;

        // on recupere le numéro de la table
        $tableId = intval($request->getParameter('table_id'));
        $commande->setTableId($tableId);
        
        // on recupere l'id de la personne connectée si c'est pas un serveur
        
        if (!$this->getUser()->hasCredential('serveur')) {
            
            // on set le client
            $commande->setClientId($this->getUser()->getGuardUser()->getId());
            $commande->setServerId($this->getUser()->getGuardUser()->getId());
        } else {
            $commande->setServerId($this->getUser()->getGuardUser()->getId());
        }
        
        // la commande n'est pas payée
        $commande->setStatutId(1);
        $commande->save();


        // on parcours les articles et on rassemble les memes.
        foreach ($articles as $article) {
            // on initialise l'inder supplements
            if(!isset($article['supplements']))
                $article['supplements'] = array();
            $add = false;
            // si il y a deja un article du meme nom sans supplement, on incremente le count
            for($i=0; $i< sizeOf($articleTick); $i++){
                if($articleTick[$i]['name'] == $article['name'] && ((count($articleTick[$i]['supplements']) == 0 && count($article['supplements']) == 0) || $articleTick[$i]['supplements'] == $article['supplements'])){
                    $articleTick[$i]['count']++;
                    $add = true;
                }
            }
            if($add == false){
                $articleTick[] = $article;
            }
        }

        // on parcours les articles et on calcule le total de la commande
        foreach($articleTick as $articleArray){   

            $total_prix_supplement = 0;
            $count = $articleArray['count'];

            if($count<1){
                $count = 1;
            }

            // on retrouve l'objet article en fonction de son id
            $article = Doctrine::getTable('Article')->findOneById($articleArray['id_article']);

            if(isset($articleArray['supplements'])){
                // on va parcourir les suppléments pour ajouter le prix final
                foreach($articleArray['supplements'] as $supplement){
                    $total_prix_supplement += ($supplement['fois_prix'] * $article->getPrix() - $article->getPrix() + $supplement['plus_prix']) * $count ;
                }
            }

            // on incremente le nombres de fois que l'article a été acheté.
            $article->setCount($article->getCount() + $count);
            $article->save();
            
            // on remplit le tableau pour imprimer la facture
            $imprimantes = $article->getCategory()->getImprimantes();
            foreach($imprimantes as $imprimante){
                $articlesInvoice[$imprimante->getSlug()][] = array(
                    'name' => $article->getName(),
                    'count' => $count,
                    'prix' => $article->getPrix(),
                    'supplements' => $articleArray['supplements'],
                );
            }        
            // on augmente le total de la commande
            $total_commande += $article->getPrix() * $count;
            $total_commande += $total_prix_supplement;
            
            // on augmente le prix d'achat de la commande
            $total_prix_achat += commandeActions::prixAchat($article) * $count;
            
            //on insert la nouvelle commande en base de donnée
            $articleCommande = new ArticleCommande();
            $articleCommande->setCommandeId($commande->getId());
            $articleCommande->setArticleId($article->getId());
            $articleCommande->setCount($count);
            if (isset($articleArray['comment']))
                $articleCommande->setComment($articleArray['comment']);
            $articleCommande->setPrix($article->getPrix());
            $articleCommande->save();

            //on enregistre les Supplements en base de donnée
            foreach($articleArray['supplements'] as $supplement){
                $articleCommandeSupplement = new ArticleCommandeSupplement();
                $articleCommandeSupplement->setArticleCommandeId($articleCommande->getId());
                $articleCommandeSupplement->setSupplementId($supplement['id']);
                $articleCommandeSupplement->save();
            }
        }

        // on recupere le prenom du serveur pour mettre sur le ticket de la commande
        $serveurName = $this->getUser()->getGuardUser()->getFirstName();

        // on isole les différentes imprimantes
        $keysPrinter = array_unique(array_keys($articlesInvoice));

        //on envois les articles a chaques imprimantes correspondantes
        foreach($keysPrinter as $slugPrinter){
            // array avec les infos necessaire a l'impression
            $arrayInfoPrint = array();

            $arrayInfoPrint['serveur'] = $serveurName;
            $arrayInfoPrint['table_id'] = $request->getParameter('table_id');
            $arrayInfoPrint['cash'] = $request->getParameter('cash'); 
            $arrayInfoPrint['bancontact'] = $request->getParameter('bancontact');
            $arrayInfoPrint['cashback'] = $request->getParameter('cashback');
            $arrayInfoPrint['total'] = $total_commande;
            //on recupere l'objet imprimante
            $imprimante = Doctrine::getTable('Imprimante')->findOneBySlug($slugPrinter);
            if(is_object($imprimante)){
                $arrayInfoPrint['printer'] = $imprimante->getName();
                $arrayInfoPrint['articles'] = $articlesInvoice[$imprimante->getSlug()];

                new InvoiceBasseCour($arrayInfoPrint);
            }
        }

        
      
        // si on a reçu l'argent, la commande est payée   a revoir !!!    
        if ($request->getParameter('cash') + $request->getParameter('bancontact') - $request->getParameter('cashback') >= $total_commande) {
            $commande->setStatutId(2);
            $transaction = new Transaction();
            $transaction->setServerId($this->getUser()->getGuardUser()->getId());
            $transaction->setCb($request->getParameter('bancontact'));
            $transaction->setCash($request->getParameter('cash'));
            $transaction->setCashback($request->getParameter('cashback'));
            $transaction->save();
            $commandeTransaction = new CommandesTransaction();
            $commandeTransaction->setTransactionId($transaction->getId());
            $commandeTransaction->setCommandeId($commande->getId());
            $commandeTransaction->save();
        }
        // on set le prix total de la commande
        $commande->setTotalCommande($total_commande);          
        // on set le prix d'achat total de la commande
        $commande->setTotalPrixAchat($total_prix_achat);
        $commande->save();
        self::ModifierStock($commande, '-');
        
        return sfView::NONE;
    }
    

    
    // cree une nouvelle transaction et met le statut de la commmande a payé.
    public function executeArchiver(sfWebRequest $request)
    {
        
        $table_id = $request->getParameter('table_id');
        $commande_id = $request->getParameter('commande_id');

        // on crée une nouvelle transaction
        $transaction = new Transaction();
        $transaction->setServerId($this->getUser()->getGuardUser()->getId());
        $transaction->setEcb($request->getParameter('bancontact'));
        $transaction->setCash($request->getParameter('cash'));
        $transaction->setCashback($request->getParameter('cashback'));
        $transaction->save();

        // si il y a une table id on recupere toutes les commandes assosciées a cette table et on met les commandes payées
        if($table_id > 0){
            $commandes = Doctrine::getTable('Commande')->createQuery('a')-> whereIn('statut_id', array(1,2,5)) -> andWhere('a.table_id = ?', $table_id) ->execute();
            Doctrine_Query::create()->update('Commande q')->set('q.statut_id', '2')->where('q.table_id = ?', $table_id)->execute();
        }
        elseif($commande_id > 0){
            $commandes = Doctrine::getTable('Commande')->createQuery('a')-> whereIn('statut_id', array(1,2,5)) -> andWhere('a.id = ?', $commande_id) ->execute();
            Doctrine_Query::create()->update('Commande q')->set('q.statut_id', '2')->where('q.id = ?', $commande_id)->execute();
        }
        
        // on crée les transactions par rapport aux commande et on set les commande a payées
        foreach($commandes as $commande){
            $commandeTransaction = new CommandesTransaction();
            $commandeTransaction->setTransactionId($transaction->getId());
            $commandeTransaction->setCommandeId($commande->getId());
            $commandeTransaction->save();
        }

        $this->ImprimerCommande($commandes);

        return sfView::NONE;
    }

    // retourne le prix d'un achat d'un articles en fonction de ses éléments
    private function prixAchat(Article $article)
    {
        
        $articleElements = $article->getArticleElement();
        $prixAchat       = 0;
        foreach ($articleElements as $articleElement) {
            $element = Doctrine::getTable('element')->findOneById($articleElement->getElementId());
            
            // si c'est un conditionnement a l'unité
            
            if ($element->getConditionnementId() == 2) {
                $prixAchat += $element->getPrixAchat();
            }
            
            // si c'est au litre
            elseif ($element->getConditionnementId() == 1) {
                $prixAchat += $element->getPrixAchat() / ($element->getNombreUnite() / $articleElement->getADeduire());
            }
        }
        return $prixAchat;
    }

    public 
    // fonction qui récupere les articles d'une table
        function executeGet(sfWebRequest $request)
    {
        
        $table_id  = $request->getParameter('table_id');
        $commandes = Doctrine::getTable('Commande')->createQuery('a')->where('a.table_id = ?', $table_id)->leftjoin('a.Articles')->leftjoin('a.ArticleCommande b')->andwhere('a.statut_id != ?', 2)->andwhere('a.statut_id != ?', 5)->leftjoin('a.Articles')->leftJoin('b.Supplements s') -> execute();
        $new_array = self::executeJson($commandes);
        return $this->renderText(json_encode($new_array));
    }
    
    // fonction qui récupere une commande en fonction de son id
    function executeGetOne(sfWebRequest $request)
    {   
        $commandes = Doctrine::getTable('Commande')->createQuery('a')->where('a.id = ?', $request->getParameter('id'))->leftjoin('a.Articles') -> leftjoin('a.ArticleCommande b')->leftJoin('b.Supplements s') ->leftjoin('a.Articles')->execute();
        $new_array = self::executeJson($commandes);
        return $this->renderText(json_encode($new_array));
    }
    public 
    //fonction qui traite les données et qui les renvoit sous forme json
        function executeJson($commandes)
    {
        $new_array['total_commande'] = 0;
        foreach($commandes as $commande){
            $new_array['statut_commande'] = $commande->getStatutId();;
            $new_array['total_commande'] += $commande->getTotalCommande();
            if (!isset($table_id))
                            $table_id = $commande->getTableId();
            foreach($commande->getArticleCommande() as $articleCommande){
                $new_array['articles'][] = array(
                                           'name' => $articleCommande->getArticle()->getName(), 
                                           'prix' => $articleCommande->getArticle()->getPrix(),
                                           'id'   => $articleCommande->getArticle()->getId(),
                                           'supplements' => $articleCommande->getSupplements()->toArray(),
                                           'count'  => $articleCommande->getCount()
                                           );
            }
        }
        return $new_array;
    }
    public 
    // fonction qui liste les commandes d'un client ou toutes les commandes
        function executeListing(sfWebRequest $request)
    {
        if (!$this->getUser()->hasCredential('serveur')) {
            $this->commandes = Doctrine::getTable('Commande')->createQuery('c')->leftjoin('c.Server')->leftjoin('c.Client cl')->orderBy('created_at desc')->where('cl.id = ?', $this->getUser()->getGuardUser()->getId())->limit(100)->execute();
        } else {
            $this->commandes = Doctrine::getTable('Commande')->createQuery('c')->leftjoin('c.Server')->leftjoin('c.Client')->orderBy('created_at desc')->limit(100)->execute();
        }
        if ($this->getUser()->hasCredential('manager')) {
            $this->clotures = Doctrine::getTable('Cloture')->createQuery('c')->leftjoin('c.ServerRecord')->leftjoin('c.ServerCloture cl')->orderBy('created_at desc')->limit(100)->execute();
        }
    }
    private function ImprimerCommande(Doctrine_Collection $commandes = null)
    {

        $total_commande = 0;
        $table_id = null;
        $arrayInfoPrint = array();
        if($commandes) {
            // on parcours toutes les commandes
            foreach($commandes as $commande){
                // on ajoute le total de la commande au total global
                $total_commande += $commande->getTotalCommande();
                // si on a n'a pas de table id on rajoute celui assoscié a une commande (logiquement c'est le meme)
                if($table_id == null)
                    $table_id = $commande->getTableId();
                foreach($commande->getArticleCommande() as $articleCommande){
                    $arrayInfoPrint['articles'][] = array(
                                               'name' => $articleCommande->getArticle()->getName(), 
                                               'prix' => $articleCommande->getArticle()->getPrix(),
                                               'id'   => $articleCommande->getArticle()->getId(),
                                               'supplements' => $articleCommande->getSupplements()->toArray(),
                                               'count'  => $articleCommande->getCount()
                                               );
                }
            }
           // on recupere les imprimantes qui doivent imprimer les factures
           $imprimantes = Doctrine::getTable('Imprimante')->createQuery('c')->where('facture = ?', 1) -> execute();

        }   
            // le nom du server qui a demander l'impression de la facture
            $serveurName = $this->getUser()->getGuardUser()->getFirstName();
        
            $arrayInfoPrint['serveur'] = $serveurName;
            $arrayInfoPrint['table_id'] = $table_id;
            $arrayInfoPrint['total'] = $total_commande;

            foreach($imprimantes as $imprimante){
                $arrayInfoPrint['printer'] = $imprimante -> getName();
                new InvoiceBasseCour($arrayInfoPrint);
            }
    }
    
    // fonction qui ma modifier le stock, ajouter ou retirer les elements d'une commande
    private function ModifierStock(Commande $commande, $operation = "+")
    {
        // on parcourt tout les articles d'une commande
        $articlesCommande = Doctrine_Core::getTable('ArticleCommande')->createQuery('c')->leftjoin('c.Article')->where('commande_id = ?', $commande->getId())->execute();
        foreach ($articlesCommande as $articleCommande) {
            $elements = Doctrine_Core::getTable('ArticleElement')->createQuery('c')->where('article_id = ?', $articleCommande->getArticleId())->execute();
            
            // on parcourt tout les elements d'un article
            foreach ($elements as $articleElement) {
                $aDeduire = $articleElement->getADeduire();
                
                // on recupere l'élément grace a son id
                $element = Doctrine::getTable('Element')->findOneById($articleElement->getElementId());
                
                // on augmente le stock
                if ($operation == "+")
                    $newStock = $element->getStockActuel() + ($articleCommande->getCount() * $aDeduire);
                //on diminue le stock
                elseif ($operation == "-")
                    $newStock = $element->getStockActuel() - ($articleCommande->getCount() * $aDeduire);
                
                if ($operation == '-' or $operation == '+')
                    $q = Doctrine_Query::create()->update('Element a')->set('a.stock_actuel', '?', $newStock)->where('a.id = ?', $element->getId())->execute();
            }
        }
    }
    public 
    // fonction qui imprime une commande en fonction de son id
        function executeImprimerCommandes(sfWebRequest $request)
    {
        $id = $request->getParameter('id');
        $commandes = Doctrine::getTable('Commande')->createQuery('a')-> whereIn('a.id ', $id) ->execute();
        $this->ImprimerCommande($commandes);
        return sfView::NONE;
    }
    
    // fonction qui change le statut d'une commande
    public function executeSetStatut(sfWebRequest $request)
    {
        
        $id = $request->getParameter('id');
        $this->forward404Unless($article = Doctrine_Core::getTable('Commande')->findOneById($id), sprintf('Object article does not exist (%s).', $request->getParameter('id')));
        $article->setStatutId($request->getParameter('statut'));
        $article->save();
        return sfView::NONE;
    }
    
    //fonction qui supprime une commande
    public function executeDelete(sfWebRequest $request)
    {
        // on recupere la commande si elle existe
        $this->forward404Unless($commande = Doctrine_Core::getTable('Commande')->findOneByIdAndStatutId($request->getParameter('id'), 1), sprintf('Object article does not exist (%s).', $request->getParameter('id')));
        
        if ($commande->getStatutId() == 1)
        // on rajoute au stock si elle n'a pas été payée
            commandeActions::ModifierStock($commande, '+');
        $commande->delete();
        $this->redirect('@gestion_commande');
    }
    public function executeTest(sfWebRequest $request)
    {
    

    }
    
    // fonction qui renvois les commandes en cours
    public function executeLiveJson(sfWebRequest $request)
    {
        
        $this->getResponse()->setHttpHeader("Cache-Control", "no-cache");
        $this->getResponse()->setHttpHeader("Pragma", "no-cache");
        $this->getResponse()->setHttpHeader("Expires", 0);
        $arrayCommande = array();
        $i             = 0;
        
        $server_id = $this->getUser()->getGuardUser()->getId();
        if ($request->getParameter('type') == 'general') {
            if (!$this->getUser()->hasCredential('serveur')) {
            $commandes = Doctrine_Core::getTable('Commande')->createQuery('commande')->leftjoin('commande.Client client')->leftjoin('commande.Server server')->whereIn('commande.statut_id', array(3,4))->andwhere('commande.client_id = ?', $server_id)->execute();
            }
            else{
            $commandes = Doctrine_Core::getTable('Commande')->createQuery('commande')->leftjoin('commande.Client client')->leftjoin('commande.Server server')->whereIn('commande.statut_id', array(1,3,4))->execute();               
            }
            
        } elseif ($request->getParameter('type') == 'mobile') {
            if (!$this->getUser()->hasCredential('serveur')) {
                $commandes = Doctrine_Core::getTable('Commande')->createQuery('commande')->leftjoin('commande.Client client')->leftjoin('commande.Server server')->where('commande.statut_id = ?', 4)->andwhere('commande.client_id = ?', $server_id)->execute();
            } else {
                $commandes = Doctrine_Core::getTable('Commande')->createQuery('commande')->leftjoin('commande.Client client')->leftjoin('commande.Server server')->where('commande.statut_id = ?', 4)->execute();
            }
        }
        if (isset($commandes))
            foreach ($commandes as $commande) {
                $arrayCommande[$i]['id']           = $commande->getId();
                $arrayCommande[$i]['table_id']     = $commande->getTableId();
                if(is_object($commande->getClient())){
                    $arrayCommande[$i]['clientPrenom'] = $commande->getClient()->getFirstName();
                    $arrayCommande[$i]['clientNom']    = $commande->getClient()->getLastName();
                }
                $arrayCommande[$i]['serverPrenom'] = $commande->getServer()->getFirstName();
                $arrayCommande[$i]['serverNom']    = $commande->getServer()->getLastName();
                $arrayCommande[$i]['statut_id']    = $commande->getStatutId();
                $i++;
            }
        return $this->renderText(json_encode($arrayCommande));
    }
    
    public function executeFullLive(sfWebRequest $request)
    {
        $this -> imprimantes = Doctrine_Core::getTable('Imprimante') -> createQuery('a') -> execute();
        
        
    }
    # fonction qui cloture la caisse 
    public function executeCloture(sfWebRequest $request)
    {
        $user_id                = $this->getUser()->getGuardUser()->getId();
        $nb_transaction_cash    = 0;
        $nb_transaction_cb      = 0;
        $nb_transaction_ecb     = 0;
        $total_transaction_cash = 0;
        $total_transaction_cb   = 0;
        $total_transaction_ecb  = 0;
        $transactions           = Doctrine_Core::getTable('Transaction')->createQuery('transaction')->where('statut = ?', 0)->execute();
        $max_record             = Doctrine_Core::getTable('Cloture')->createQuery('cloture')->select('max(total_record), id_user_record')->fetchOne();

        // on verifie qu'il y a de nouvelles transactions
        if(count($transactions)){
            // on boucle toutes les transactions et on augmente les compteurs
            foreach ($transactions as $transaction) {
                if ($transaction->getCash() > 0) {
                    $nb_transaction_cash++;
                    $total_transaction_cash += $transaction->getCash();
                }
                if ($transaction->getCb() > 0) {
                    $nb_transaction_cb++;
                    $total_transaction_cb += $transaction->getCb();
                }
                if ($transaction->getEcb() > 0) {
                    $nb_transaction_ecb++;
                    $total_transaction_ecb += $transaction->getEcb();
                }
                if (!isset($records[$transaction->getServerId()])) {
                    $records[$transaction->getServerId()] = 0;
                }
                $records[$transaction->getServerId()] += $transaction->getCash() + $transaction->getCb() + $transaction->getEcb();
            }
            $user_id_record = null;
            // si il n'y a pas de record, on le set a 0
            if(!is_object($max_record)){
                $total_record = 0;
            }
            else{
                $total_record = $max_record->getTotalRecord();
                $user_id_record = $max_record->getIdUserRecord();
            }
            if (isset($records)) {
                foreach ($records as $id => $record) {
                    if ($record > $total_record) {
                        $user_id_record = $id;
                        $total_record = $record;
                    }
                }
            }

            // on set dit que les transactions ont été cloturées
            Doctrine_Query::create()->update('Transaction a')->set('a.statut', '?', 1)->where('a.statut = ?', 0)->execute();

            $serveurName = Doctrine_Core::getTable('sfGuardUser')->createQuery('user')->select('first_name')->where('id = ?', $user_id_record)->fetchOne();
            
            $cloture = new Cloture();
            $cloture->setNbTransactionCash($nb_transaction_cash);
            $cloture->setTotalTransactionCash($total_transaction_cash);
            $cloture->setNbTransactionCb($nb_transaction_cb);
            $cloture->setTotalTransactionCb($total_transaction_cb);
            $cloture->setNbTransactionEcb($nb_transaction_ecb);
            $cloture->setTotalTransactionEcb($total_transaction_ecb);
            $cloture->setIdUserRecord($user_id_record);
            $cloture->setTotalRecord($total_record);
            $cloture->setServerId($user_id);
            $cloture->save();
            
            new CloturePdf('P', 'pt', 'LETTER', $serveurName, $total_transaction_cash, $total_transaction_ecb, $total_transaction_cb, $nb_transaction_cash, $nb_transaction_ecb, $nb_transaction_cb, $total_record);
        }
        return sfView::NONE;
    }
    // fonction qui renvois les commandes en cours   
    public function executeFullLiveJson(sfWebRequest $request)
    {
        
        $id = $request->getParameter('id');
        
        
        $this->getResponse()->setHttpHeader('Cache-Control', 'no-cache');
        $this->getResponse()->setHttpHeader('Pragma', 'no-cache');
        $this->getResponse()->setHttpHeader('Expires', 0);
        $arrayCommande = array();
        $i             = 0;
        
        $q = Doctrine::getTable('Commande')->createQuery('a')->leftjoin('a.Articles ar')->leftjoin('ar.ArticleCommande b')->leftjoin('ar.Category ca') ->leftjoin('ca.Imprimantes im') -> leftJoin('b.Supplements s') -> leftjoin('a.Client client')->leftjoin('a.Server server')->whereIn('a.statut_id', array(
            1,
            3
        ));
        $commandes = $q -> execute();

        
        //
        
        foreach ($commandes as $commande) {
            $arrayCommande[$i]['id']           = $commande->getId();
            $arrayCommande[$i]['table_id']     = $commande->getTableId();
            if(is_object($commande->getClient())){
                $arrayCommande[$i]['clientPrenom'] = $commande->getClient()->getFirstName();
                $arrayCommande[$i]['clientNom']    = $commande->getClient()->getLastName();
            }
            $arrayCommande[$i]['serverPrenom'] = $commande->getServer()->getFirstName();
            $arrayCommande[$i]['serverNom']    = $commande->getServer()->getLastName();
            $arrayCommande[$i]['statut_id']    = $commande->getStatutId();
            $j                                 = 0;
            foreach ($commande->getArticleCommande() as $articleCommande) {
                $arrayCommande[$i]['ArticleCommandes'][$j]['count']       = $articleCommande->getCount();
                $arrayCommande[$i]['ArticleCommandes'][$j]['name']        = $articleCommande->getArticle()->getName();
                $arrayCommande[$i]['ArticleCommandes'][$j]['article_id']  = $articleCommande->getArticleId();
                $arrayCommande[$i]['ArticleCommandes'][$j]['commande_id'] = $articleCommande->getCommandeId();
                $arrayCommande[$i]['ArticleCommandes'][$j]['supplements'] = $articleCommande->getSupplements()->toArray();
               
                // On va générer un tableau recapitulatif du nombre d'articles a faire.
                if (!isset($arrayTotal[$articleCommande->getArticleId()])) {
                    $arrayTotal[$articleCommande->getArticleId()]['id']    = $articleCommande->getArticleId();
                    $arrayTotal[$articleCommande->getArticleId()]['count'] = $articleCommande->getCount();
                    $arrayTotal[$articleCommande->getArticleId()]['name']  = $articleCommande->getArticle()->getName();
                } else {
                    $arrayTotal[$articleCommande->getArticleId()]['count'] = $arrayTotal[$articleCommande->getArticleId()]['count'] + $articleCommande->getCount();
                }
                
                $j++;
            }
            $i++;
        }
        if (isset($arrayTotal)) {
            self::aasort($arrayTotal, 'count');
            $arrayJson['total']    = array_values(array_reverse($arrayTotal));
            $arrayJson['commande'] = $arrayCommande;
            return $this->renderText(json_encode($arrayJson));
        }
        
    }
    
    public function aasort(&$array, $key)
    {
        $sorter = array();
        $ret    = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }
    
    
    
}
