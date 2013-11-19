<?php

/**
 * sfGuardRegisterForm for registering new users
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: BasesfGuardChangeUserPasswordForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardRegisterForm extends BasesfGuardRegisterForm
{
  /**
   * @see sfForm
   */
   

  public function configure()
  {
	    exit();
  	$this->useFields(array('username', 'email_address'));
	
	$this->validatorSchema['email_address'] = new sfValidatorAnd(array(
    $this->validatorSchema['email_address'], new sfValidatorEmail(array(), array('invalid' => 'The email address is invalid.')),
	
	
    ));
   
   
    $this->validatorSchema['username'] = new sfValidatorAnd(array(
	$this->validatorSchema['username'], new sfValidatorString(array('required' => true, 'min_length' => 4, 'max_length' => 14)),
	new sfValidatorRegex(array('pattern' => '/^[a-zA-Z0-9-]+$/')), new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username') ),
	array(
        'invalid' => 'A user with that username already exists'
         )
      ))
  );
    $this->validatorSchema['username']->setMessage('required', 'A username is required.  ');
    $this->validatorSchema['email_address']->setMessage('required', 'A email is required.  ');
	
    $this->widgetSchema->setNameFormat('register[%s]');
	
	$this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(
      array(
        'model' => 'sfGuardUser',
        'column' => array('email_address'),
        'throw_global_error' => false
     ),
      array(
        'invalid' => 'A user with that email address already exists'
         )
      )
	  

    );
	

	
		
  }
}