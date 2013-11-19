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
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: BasesfGuardAuthActions.class.php 23800 2009-11-11 23:30:50Z Kris.Wallsmith $
 */
class BasesfGuardAuthActions extends sfActions
{
  public function executeSignin( $request ) {
    $this->serveurs = Doctrine::getTable('sfGuardUser') -> createQuery('a') -> leftjoin('a.sfGuardUserGroup sg') -> where('sg.group_id = ?', 3) -> groupBy('a.id') -> execute();
    $user = $this->getUser();
    if ( $user->isAuthenticated() ) {
        return $this->renderText( 'logged' );
    }

    $class = sfConfig::get( 'app_sf_guard_plugin_signin_form', 'sfGuardFormSignin' );
    $this->form = new $class();

    if ( $request->isMethod( 'post' ) ) {

      $this->form->bind( $request->getParameter( 'signin' ) );
      if ( $this->form->isValid() ) {
        $values = $this->form->getValues();
        
        $this->getUser()->signin( $values['user'], array_key_exists( 'remember', $values ) ? $values['remember'] : false );
        $group_id = array();
        foreach ( $values['user']->getGroups() as $group ) {
          foreach ( $group->getPermissions() as $permission ) {
            $this->getUser()->addCredentials( $permission->getName() );
          }
        }
        // always redirect to a URL set in app.yml
        // or to the referer
        // or to the homepage
        $signinUrl = sfConfig::get( 'app_sf_guard_plugin_success_signin_url', $user->getReferer( $request->getReferer() ) );
        return $this->renderText( 'logged' );
        //return $this->redirect($user->getReferer($request->getReferer()));
      }

    }
    else {
      if ( $request->isXmlHttpRequest() ) {
        $this->getResponse()->setHeaderOnly( true );
        $this->getResponse()->setStatusCode( 401 );

        return sfView::NONE;
      }

      // if we have been forwarded, then the referer is the current URL
      // if not, this is the referer of the current request
      $user->setReferer( $this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer() );

      $module = sfConfig::get( 'sf_login_module' );
      if ( $this->getModuleName() != $module ) {
        return $this->redirect( $module.'/'.sfConfig::get( 'sf_login_action' ) );
      }

      $this->getResponse()->setStatusCode( 401 );
    }
    $this->setLayout( false );
  }

  public function executeSignout( $request ) {
    $this->getUser()->signOut();

    //$signoutUrl = sfConfig::get('app_sf_guard_plugin_success_signout_url', $request->getReferer());

    $this->redirect( '@homepage' );
  }

  public function executeSecure( $request ) {
    $this->getResponse()->setStatusCode( 403 );
    $this->setLayout( false );

  }

  public function executePassword( $request ) {
    throw new sfException( 'This method is not yet implemented.' );
  }
}
