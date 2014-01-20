<?php

/**
 * sfGuardAuth actions.
 *
 * @package    LiveOrder
 * @subpackage sfGuardAuth
 * @author     Adrien Bokor <adrien@bokor.be>
 */
require_once sfConfig::get( 'sf_plugins_dir' ).'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php';

class sfGuardAuthActions extends BasesfGuardAuthActions
{
    public function executeHTTPSignin() {
        // get somme interesting stuff!
        $request = $this->getRequest();
        $response = $this->getResponse();
        $user = $this->getUser();

        $class = sfConfig::get( 'app_sf_guard_plugin_signin_form', 'sfGuardFormSignin' );
        $this -> form = new $class();
        $message = 'Authentification required';

        if ( isset( $_SERVER['PHP_AUTH_USER'] ) ) {
            $request -> setParameter( 'signin', array( 'username' => $_SERVER['PHP_AUTH_USER'], 'password' => $_SERVER['PHP_AUTH_PW'], ) );
        }
        $this -> form -> bind( $request -> getParameter( 'signin' ) );
        if ( $this -> form -> isValid() ) {
            $values = $this -> form -> getValues();
            $this -> getUser() -> signin( $values['user'], array_key_exists( 'remember', $values ) ? $values['remember'] : false );
            $this -> getUser() -> getGuardUser() -> setLastLogin( date( "Y-m-d H:i:s" ) );
            $this -> getUser() -> getGuardUser() -> save();
            foreach ( $values['user']->getGroups() as $group ) {
                foreach ( $group->getPermissions() as $permission ) {
                    $this->getUser()->addCredentials( $permission->getName() );
                }
            }
            return $this->renderText( 'logged' );
        }
        else {
            $header_message = "Basic realm=\"$message\"";
            $this -> getResponse() -> setStatusCode( 401 );
            $this -> getResponse() -> setHttpHeader( 'WWW_Authenticate', $header_message );
        }
    }

    public function executeFacebook() {
        $url = 'https://graph.facebook.com/me?access_token=' .$this->getRequest()->getParameter( 'accessToken' );
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $result = json_decode( curl_exec( $ch ), true );
        curl_close( $ch );

        // si il est déja connecté. On lie son compte facebook
        if ( $this->getUser()->isAuthenticated() ) {
            $this -> getUser() -> getGuardUser() -> setUid( $result['id'] );
            $this -> getUser() -> getGuardUser() -> save();
            return $this->renderText( 'logged' );
        }
        elseif(isset($result['id'])) {

            // on recherche l'utilisateur avec uid de facebook. Si on le trouve on l'identifie
            $user = Doctrine::getTable( 'sfGuardUser' )->findOneByUid( $result['id'] );
            if ( is_object( $user ) ) {
                $this -> getUser() -> signin( $user );
                $this -> getUser() -> getGuardUser() -> save();
            }
            // on regarde si on trouve l'utilisateur grace a son email
            elseif ( isset($result['email'] ) && $user = Doctrine::getTable( 'sfGuardUser' )->findOneByEmailAddress( $result['email'] ) ) 
            {
                $this -> getUser() -> signin( $user );
                $this -> getUser() -> getGuardUser() -> setUid( $result['id'] );
                $this -> getUser() -> getGuardUser() -> save();
            }
            // sinon on creer l'utilisateur
            else {
                $user = new sfGuardUser();
                $user->setUsername( $result['username'] );
                if ( $result['gender'] == 'male' ) {
                    $user->setGenre( 'M' );
                }else {
                    $user->setGenre( 'F' );
                }

                $url = 'http://graph.facebook.com/'.$result['id'].'/picture?width=400&height=400';
                $headers = get_headers($url, 1);
                $url = $headers['Location']; //image URL
                $name = sha1(time()).'.jpg';
                if(copy($url, sfConfig::get('sf_upload_dir') . '/avatar/'.$name.'.jpg')){
                    $user->setAvatar($name);
                }
                
                $user->setEmailAddress( $result['email'] );
                $user->setCity( $result['location']['name'] );
                $user->setFirstName( $result['first_name'] );
                $user->setLastName( $result['last_name'] );
                $user->setCountry( $result['hometown']['name'] );
                $user->setUid( $result['id'] );
                $myDateTime = DateTime::createFromFormat( 'm/d/Y', $result['birthday'] );
                $date = $myDateTime->format( 'y-m-d' );
                $user->setDateNaissance( $date );
                $user->setLastLogin( date( "Y-m-d H:i:s" ) );
                $user->setPassword( 'test' );
                $user->save();

                // on cree un nouveau groupe
                $group = new sfGuardUserGroup();
                $group->setUserId( $user->getId() );
                $group->setGroupId( 4 );
                $group->save();

                $this -> getUser() -> signin( $user );

            }

            // on attribue les permissions a l'utilisateur
            foreach ( $user->getGroups() as $group ) {
                foreach ( $group->getPermissions() as $permission ) {
                    $this->getUser()->addCredentials( $permission->getName() );
                }
            }

            return $this->renderText( 'logged' );

        }else{
            $header_message = "Basic realm=\"$message\"";
            $this -> getResponse() -> setStatusCode( 401 );
            $this -> getResponse() -> setHttpHeader( 'WWW_Authenticate', $header_message );
            return sfView::None;
        }
    }
}
