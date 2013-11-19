<?php

class BasesfGuardRegisterActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->getUser()->setFlash('notice', 'Vous êtes déjà enregistré et connecté !');
      $this->redirect('@homepage');
    }

    $this->form = new sfGuardRegisterForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
	  $this->getUser()->setFlash('error', $this->form['username']->getError('username').$this->form['email_address']->getError('email_adress'));
      if ($this->form->isValid())
      {
        $user = $this->form->save();
		$user->Profile->setIpInscription($_SERVER["HTTP_X_FORWARDED_FOR"]);
		function genere_passwd() { 
          $tpass=array(); 
          $id=0; 
          $taille=9; 
          // récupération des chiffres et lettre 
          for($i=48;$i<58;$i++) $tpass[$id++]=chr($i); 
          for($i=65;$i<91;$i++) $tpass[$id++]=chr($i); 
          for($i=97;$i<123;$i++) $tpass[$id++]=chr($i); 
          $passwd=""; 
          for($i=0;$i<$taille;$i++) { 
            $passwd.=$tpass[rand(0,$id-1)]; 
          } 
          return $passwd; 
        }
		$password=genere_passwd();
		//$message = $this->getMailer()->compose(
        //array('admin@spotiz.com' => 'Inscription Spotiz.com'),
        //$user->getEmailAddress(),
        //'Votre mot de passe - Spotiz.com',<<<EOF
//Votre compte a été activé.
 
//Votre mot de passe est : {$password}

//Votre nom d'utilisateur est : {$user->getUsername()}
 
//EOF
//    );
		//$mailBody = $this->getPartial('sfGuardRegister/inscriptionMail', array('password' => $password, 'user' => $user->getUsername()));
		//$message = $this->getMailer()->
 		//compose('admin@ergor.org', $user->getEmailAddress(), 'Inscription sur Ergor.org', '')->
 		//setBody($mailBody, 'text/html');
		//$this->getMailer()->send($message);
 
//$this->getMailer()->send($message);
		$user->SetPassword($password);
		$user->addGroupByName('utilisateur');
        $user->save();
       // $this->getUser()->signIn($user);
		$this->getUser()->setFlash('notice', 'Vous allez recevoir un mail avec votre mot de passe. Pensez a vérifier les spams.');
        $this->redirect('@homepage');
      }
	 $this->redirect('@homepage');
    }
  }
}