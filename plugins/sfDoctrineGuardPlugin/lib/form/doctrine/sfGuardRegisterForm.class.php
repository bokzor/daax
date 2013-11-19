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
        
        $this->validatorSchema['avatar'] = new sfValidatorFile(array(
            'required' => false,
            'mime_types' => 'web_images',
            'max_size' => '3000000'
        ));
        $this->widgetSchema['avatar']    = new sfWidgetFormInputFileEditable(array(
            'file_src' => '/uploads/avatar/' . $this->getObject()->getAvatar(),
            'is_image' => true,
            'edit_mode' => !$this->isNew(),
            'with_delete' => false
        ));
        
        //$this -> validatorSchema['username'] = new sfValidatorAnd( array($this -> validatorSchema['username'], new sfValidatorString( array('required' => true, 'min_length' => 4, 'max_length' => 14)), new sfValidatorRegex( array('pattern' => '/^[a-zA-Z0-9-]+$/')), new sfValidatorDoctrineUnique( array('model' => 'sfGuardUser', 'column' => array('username')), array('invalid' => 'Ce nom d\'utilisateur est déjà prit.'))));
        $this->widgetSchema->setNameFormat('register[%s]');
        $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array(
            'model' => 'sfGuardUser',
            'column' => array(
                'email_address'
            ),
            'throw_global_error' => false
        ), array(
            'invalid' => 'Cette adresse email est déjà prise.'
        )));
        
        // les labels des champs
        $this->widgetSchema->setLabels(array(
            'first_name' => 'Prenom',
            'last_name' => 'Nom',
            'city' => 'Ville',
            'username' => 'Pseudo',
            'password' => 'Mot de passe',
            'password_again' => 'Mot de passe',
            'email_address' => 'Email',
            'street' => 'Rue',
            'tel' => 'Télephone',
            'postal_code' => 'Code postal',
            'groups_list' => 'Groupes',
            'country' => 'Pays',
        ));
        
    }
    
    
    public function doSave($con = null)
    {
        
        if ($this->getValue('avatar')) {
            
            if (file_exists(sfConfig::get('sf_upload_dir') . '/avatar/' . $this->getObject()->getAvatar() and $this->getObject()->getAvatar() != NULL)) {
                unlink(sfConfig::get('sf_upload_dir') . '/avatar/' . $this->getObject()->getAvatar());
            }
            $file     = $this->getValue('avatar');
            $filename = sha1($file->getOriginalName()) . $file->getExtension($file->getOriginalExtension());
            $file->save(sfConfig::get('sf_upload_dir') . '/avatar/' . $filename);
        }
        return parent::doSave($con);
    }
    public function updateObject($values = null)
    {
        
        $object = parent::updateObject($values);
        
        if ($object->getAvatar() and $object->getAvatar() != NULL)
            $object->setAvatar(str_replace(sfConfig::get('sf_upload_dir') . '/avatar/', '', $object->getAvatar()));
        return $object;
    }
}
