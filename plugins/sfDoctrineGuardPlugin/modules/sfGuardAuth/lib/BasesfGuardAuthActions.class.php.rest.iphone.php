<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 23800 2009-11-11 23:30:50Z Kris.Wallsmith $
 */
class BasesfGuardAuthActions extends sfActions {
	public function executeSignin($request) {
		$user = $this -> getUser();
		if ($user -> isAuthenticated()) {
			return $this -> redirect($user -> getReferer($request -> getReferer()));
		}

		$class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
		$this -> form = new $class();
		$message = 'Authentification required';

		if (isset($_SERVER['PHP_AUTH_USER'])) {
			$request -> setParameter('signin', array('username' => $_SERVER['PHP_AUTH_USER'], 'password' => $_SERVER['PHP_AUTH_PW'], ));
		}
			$this -> form -> bind($request -> getParameter('signin'));
			if ($this -> form -> isValid()) {
				$values = $this -> form -> getValues();
				$this -> getUser() -> signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);
				$this -> getUser() -> getGuardUser() -> setLastLogin(date("Y-m-d H:i:s"));
				$this -> getUser() -> getGuardUser() -> save();
				$this -> forward($request -> getParameter('module'), $request->getParameter('action'));
			}
			else{
				return($this->form); 
				//$header_message = "Basic realm=\"$message\"";
				//$this -> getResponse() -> setStatusCode(401);
				//$this -> getResponse() -> setHttpHeader('WWW_Authenticate', $header_message);								
			}

		return sfView::NONE;

	}

	public function executeSignout($request) {
		$this -> getUser() -> signOut();

		$signoutUrl = sfConfig::get('app_sf_guard_plugin_success_signout_url', $request -> getReferer());

		$this -> redirect('' != $signoutUrl ? $signoutUrl : '@home');
	}

	public function executeSecure()
	  {
	    if (!$this->getUser()->hasAttribute("secure_referer"))
	        $this->getUser()->setAttribute("secure_referer", $this->getRequest()->getReferer());
	 
	 
	    if (isset($_SERVER['PHP_AUTH_USER']))
	    {
	        if ($this->getUser()->tryLogin($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']))
	        {
	           $this->redirect($this->getUser()->getAttribute("secure_referer"));
	        }
	    }
	 
	        $this->getResponse()->setHttpHeader('WWW-Authenticate',  'Basic realm="Member Area"');
	        $this->getResponse()->setStatusCode('401');
	        $this->sendHttpHeaders();
	        return sfView::NONE;
	  }

	public function executePassword($request) {
		throw new sfException('This method is not yet implemented.');
	}

}
