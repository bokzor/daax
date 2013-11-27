<?php
/**
 * Element form.
 *
 * @package    spotiz
 * @subpackage form
 * "Adrien Bokor <adrien@bokor.be>"
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class ElementForm extends BaseElementForm {
    public 
    function configure() {

        unset($this['created_at'], $this['updated_at'], $this['slug']);
        
        $this->widgetSchema['img'] = new sfWidgetFormInputFileEditable(array(
            'file_src' => '/uploads/elements/' . $this->getObject()->getImg() ,
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
        $this->widgetSchema['prix_achat']->setLabel('Prix d\'achat');
        $this->widgetSchema['nombre_unite']->setLabel('Quantité du conditionnement en litre ou unité');
        $this->widgetSchema['category_id']->setLabel('Categorie');

    }
    public 
    function doSave($con = null) {

        
        if ($this->getValue('stock_id')) $this->getObject()->setStockId($this->getValue('stock_id'));
        
        if ($this->getValue('img')) {
            
            if (file_exists(sfConfig::get('sf_upload_dir') . '/elements/' . $this->getObject()->getImg() and $this->getObject()->getImg() != NULL)) {
                unlink(sfConfig::get('sf_upload_dir') . '/elements/' . $this->getObject()->getImg());
            }
            $file = $this->getValue('img');
            $filename = sha1($file->getOriginalName()) . $file->getExtension($file->getOriginalExtension());
            $file->save(sfConfig::get('sf_upload_dir') . '/elements/' . $filename);
        }
        return parent::doSave($con);
    }
    public 
    function updateObject($values = null) {

        $object = parent::updateObject($values);
        
        if ($object->getImg() and $object->getImg() != NULL) $object->setImg(str_replace(sfConfig::get('sf_upload_dir') . '/elements/', '', $object->getImg()));
        return $object;
    }
}
