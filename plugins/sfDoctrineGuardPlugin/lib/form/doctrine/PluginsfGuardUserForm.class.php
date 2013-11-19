<?php

/**
 * PluginsfGuardUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginsfGuardUserForm extends BasesfGuardUserForm
{
    public function setup()
    {
        parent::setup();
        
        unset($this['is_active'], $this['is_super_admin'], $this['updated_at'], $this['created_at'], $this['last_login'], $this['algorithm'], $this['password'], $this['salt'], $this['permissions_list']);
        
        $this->widgetSchema['avatar']    = new sfWidgetFormInputFileEditable(array(
            'file_src' => '/uploads/avatar/' . $this->getObject()->getAvatar(),
            'is_image' => true,
            'edit_mode' => !$this->isNew(),
            'with_delete' => false
        ));
        $this->validatorSchema['avatar'] = new sfValidatorFile(array(
            'required' => false,
            'mime_types' => 'web_images',
            'max_size' => '300000'
        ));
        
    }

    public function doSave($con = null)
    {
        if ($this->getValue('avatar')) {
            if (file_exists(sfConfig::get('sf_upload_dir') . '/avatar/' . $this->getObject()->getImg() and $this->getObject()->getImg() != NULL)) {
                unlink(sfConfig::get('sf_upload_dir') . '/avatar/' . $this->getObject()->getImg());
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
        
        $object->setImg(str_replace(sfConfig::get('sf_upload_dir') . '/avatar/', '', $object->getImg()));
        
        return $object;
    }
}
