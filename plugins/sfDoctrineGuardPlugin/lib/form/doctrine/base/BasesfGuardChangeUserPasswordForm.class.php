<?php

/**
 * BasesfGuardChangeUserPasswordForm for changing a users password
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: BasesfGuardChangeUserPasswordForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class BasesfGuardChangeUserPasswordForm extends BasesfGuardUserForm
{
  public function setup()
  {
    parent::setup();

    $this->useFields(array('password'));

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword(array(), array('placeholder' => 'Mot de passe'));
    $this->validatorSchema['password']->setOption('required', true);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword(array(), array('placeholder' => 'Mot de passe'));
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
    $this->validatorSchema['password_again']->setOption('required', true);
    $this->widgetSchema->setLabel('password_again', 'Retapez le mot de passe :');
    $this->widgetSchema->setLabel('password', 'Mot de passe :');

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
  }
}