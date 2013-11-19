<?php
/**
 * Article form.
 *
 * @package    spotiz
 * @subpackage form
 * "Adrien Bokor <adrien@bokor.be>"
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class ArticleForm extends BaseArticleForm {
    public 
    function configure() {

        unset($this['created_at'], $this['updated_at'], $this['slug']);
        
        $this->widgetSchema['img'] = new sfWidgetFormInputFileEditable(array(
            'file_src' => '/uploads/articles/' . $this->getObject()->getImg() ,
            'is_image' => true,
            'edit_mode' => !$this->isNew() ,
            'with_delete' => false,
        ));
        $this->validatorSchema['img'] = new sfValidatorFile(array(
            'required' => false,
            'mime_types' => 'web_images',
            'max_size' => '30000000'
        ));

        // les labels
        $this->widgetSchema['img']->setLabel('Image');
        $this->widgetSchema['prix']->setLabel('Prix de vente');
        $this->widgetSchema['category_id']->setLabel('Categorie');

    }
    public 
    function doSave($con = null) {

        
        
        if ($this->getValue('img')) {
            
            if (file_exists(sfConfig::get('sf_upload_dir') . '/articles/' . $this->getObject()->getImg() and $this->getObject()->getImg() != NULL)) {
                unlink(sfConfig::get('sf_upload_dir') . '/articles/' . $this->getObject()->getImg());
            }
            $file = $this->getValue('img');
            $filename = sha1($file->getOriginalName()) . $file->getExtension($file->getOriginalExtension());
            $file->save(sfConfig::get('sf_upload_dir') . '/articles/' . $filename);
        }
        return parent::doSave($con);
    }
    public 
    function updateObject($values = null) {

        $object = parent::updateObject($values);
        
        if ($object->getImg() and $object->getImg() != NULL) $object->setImg(str_replace(sfConfig::get('sf_upload_dir') . '/articles/', '', $object->getImg()));
        return $object;
    }
}
