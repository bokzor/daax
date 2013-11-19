<?php

/**
 * stat actions.
 *
 * @package    spotiz
 * @subpackage stat
 * "Adrien Bokor <adrien@bokor.be>"

 */
class statActions extends sfActions {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        if (!$request -> getParameter('date-debut')) {
            // si pas de date recue on set pour le mois en cours
            $startTime = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), 1, date('Y')));
            $endTime = date("Y-m-d H:i:s", time());
            $this -> dateDebut = date("m/d/Y", strtotime($startTime));

            $this -> dateFin = date("m/d/Y", time());
            $this -> heureDebut = '00:00';
            $this -> heureFin = '23:59';
        } else {
            $this -> dateDebut = $request -> getParameter('date-debut');
            $this -> dateFin = $request -> getParameter('date-fin');
            $this -> heureDebut = $request -> getParameter('heure-debut');
            $this -> heureFin = $request -> getParameter('heure-fin');

            $startTime = date("Y-m-d H:i:s", strtotime($request -> getParameter('date-debut')));
            $endTime = date("Y-m-d H:i:s", strtotime($request -> getParameter('date-fin') . ' 23:59'));

        }


        // on va creer les tableaux pour chaques serveurs.
        $serveurArray = array();
        $statValue = array();
        if($request->getParameter('serveur_id')){
            foreach($request->getParameter('serveur_id') as $serveur_id){
                $serveurArray[$serveur_id] = Doctrine::getTable('Commande') -> createQuery('c')
                 ->leftjoin('c.Server s')
                 -> select('s.first_name, c.*, sum(c.total_commande) as total_commande, 
                 sum(c.total_prix_achat) as total_prix_achat, DATE_FORMAT(c.created_at, \'%m-%d-%Y\') as date, 
                 DATE_FORMAT(c.created_at, \'%d/%m\') as jour') 
                 -> where('c.created_at <= ?', $endTime) -> andWhere('c.created_at >= ?', $startTime) 
                 -> andwhere('DATE_FORMAT(c.created_at, \'%H:%i\') >= ?', $this -> heureDebut) 
                 -> andwhere('DATE_FORMAT(c.created_at, \'%H:%i\') <= ?', $this -> heureFin) 
                 -> andWhere('c.statut_id = 2')
                 -> andWhere('c.server_id = ?', $serveur_id) 
                 -> orderBy('jour ASC')
                 -> groupBy('date') -> execute();     
            }
        }
        $serveurArray['total'] = Doctrine::getTable('Commande') -> createQuery('c')
                 -> select('sum(total_commande) as total_commande, sum(total_prix_achat) as total_prix_achat, 
                 DATE_FORMAT(c.created_at, \'%m-%d-%Y\') as date, DATE_FORMAT(c.created_at, \'%d/%m\') as jour') 
                 -> where('created_at <= ?', $endTime) -> andWhere('created_at >= ?', $startTime) 
                 -> andwhere('DATE_FORMAT(created_at, \'%H:%i\') >= ?', $this -> heureDebut) 
                 -> andwhere('DATE_FORMAT(created_at, \'%H:%i\') <= ?', $this -> heureFin) 
                 -> andWhere('statut_id = 2') 
                 -> orderBy('jour ASC')
                 -> groupBy('date') -> execute();     

        // tableau des dates pour les statistiques
        $date = $this -> dateDebut;
        $end_date = $this -> dateFin;
        $intervale = '';
        // on boucle sur la date tant qu'elle est inférieur a la data limite
        while (strtotime($date) <= strtotime($end_date)) {
            $dateJava = date("d/m", strtotime($date)) . '';
            $dateJavaArray[]=$dateJava;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $intervale .= "'$dateJava',";
        }
        //print_r($dateJavaArray);
        foreach($serveurArray as $serveur_id => $values){
            $statValue[$serveur_id][]='';
            foreach($dateJavaArray as $value){
                $statValue[$serveur_id][]=$value;
            }
             $name = false;
             foreach($values as $value){
                 if($name==false){
                     if($value->getServer() and $value->getServer()->getFirstName() !=''){
                        $statValue[$serveur_id][0] = '\''.$value->getServer()->getFirstName().'\'';
                         $name = true;
                     }
                     else{
                        $statValue[$serveur_id][0] = '\'Total\'';
                         $name = true;
                     }
                 }
                 if($key = array_search($value->getJour(), $statValue[$serveur_id])){
                     $statValue[$serveur_id][$key] = $value -> getTotalCommande();
                 }

             } 
            $i=0;
            foreach($statValue[$serveur_id] as $value){
                if(strpos($value, '/')){
                    $statValue[$serveur_id][$i]=0;
                }
                $i++;
            }     
        } 

        $this -> statValue = $statValue;
        $this -> intervale = $intervale;


        // on regarde quel est le dernier jour du mois en cours
        $mois = mktime(0, 0, 0, $month = date("n", time()), 1, date("Y", time()));
        $this -> lastday = date("t", $mois);

        // on regarde quel est le dernier jour du mois prochain
        $this -> lastDayPreviousMonth = date('t', strtotime('last day of previous month'));

        $commandeDuMois = Doctrine::getTable('Commande') -> createQuery('c') 
        -> select('sum(total_commande) as total_commande, sum(total_prix_achat) as total_prix_achat, statut_id')
        -> where('created_at <= ?', $endTime) -> andWhere('created_at >= ?', $startTime)
        -> andwhere('DATE_FORMAT(created_at, \'%H:%i\') >= ?', $this -> heureDebut) 
        -> andwhere('DATE_FORMAT(created_at, \'%H:%i\') <= ?', $this -> heureFin) -> andWhere('statut_id = 2') -> limit(1) -> execute();

        $commandeDuMoisOffert = Doctrine::getTable('Commande') -> createQuery('c') 
        -> select('sum(total_commande) as total_commande, sum(total_prix_achat) as total_prix_achat, statut_id')
        -> where('created_at <= ?', $endTime) -> andWhere('created_at >= ?', $startTime)
        -> andwhere('DATE_FORMAT(created_at, \'%H:%i\') >= ?', $this -> heureDebut) 
        -> andwhere('DATE_FORMAT(created_at, \'%H:%i\') <= ?', $this -> heureFin) -> andWhere('statut_id = 5') -> limit(1) -> execute();        
        $commandeDuMoisOffert = $commandeDuMoisOffert -> toArray();

        $this -> chiffreAffaire += $commandeDuMois[0]['total_commande'];
        $this -> prixTotal += $commandeDuMois[0]['total_prix_achat'];
        $this -> prixTotal += $commandeDuMoisOffert[0]['total_prix_achat'];

        $this -> serveurs = Doctrine::getTable('sfGuardUser') -> createQuery('c') -> leftjoin('c.Groups g') -> where('g.id != ?', 4) -> execute();

    }

}
