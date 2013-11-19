<?php

/**
 * Category form.
 *
 * @package    spotiz
 * @subpackage form
 * "Adrien Bokor <adrien@bokor.be>"
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class CategoryForm extends BaseCategoryForm
{
  public function configure()
  {
    // cree un widget pour representer les categories parentes
    $this->setWidget('parent', new sfWidgetFormDoctrineChoiceNestedSet(array(
      'model'     => 'Category',
      'add_empty' => true,
    )));

    // si la categorie a un parent on en fait le choix par defaut
    if ($this->getObject()->getNode()->hasParent())
    {
      $this->setDefault('parent', $this->getObject()->getNode()->getParent()->getId());
    }

    // permet à l'utilisateur de ne changer que le nom et les parents d'une categorie
    $this->useFields(array(
      'name',
      'parent',
      'is_publish',
    ));
    // les labels des champs
    $this->widgetSchema->setLabels(array(
      'name'   => 'Categorie',
      'parent' => 'Categorie parente',
      'is_publish' => 'Visible',
    ));
    // cree un validator qui evite qu'un enfant d'une categorie soit specifie comme etant son propre parent
    $this->setValidator('parent', new sfValidatorDoctrineChoiceNestedSet(array(
      'required' => false,
      'model'    => 'Category',
      'node'     => $this->getObject(),
    )));
    $this->getValidator('parent')->setMessage('node', 'Une catégorie ne peut être le descendant d\'elle même');
  }

  public function doSave($con = null)
  {
    // sauvegarde l'enregistrement
    parent::doSave($con);
    // si un parent a ete specifie, ajoute/déplace ce noeud pour etre l'enfant de ce parent
    if ($this->getValue('parent'))
    {
      $parent = Doctrine::getTable('Category')->findOneById($this->getValue('parent'));
      if ($this->isNew())
      {
        $this->getObject()->getNode()->insertAsLastChildOf($parent);
        $this->getObject()->setFatherId($this->getValue('parent'));
        $this->getObject()->save();

      }
      else
      {
        $this->getObject()->getNode()->moveAsLastChildOf($parent);
        $this->getObject()->setFatherId($this->getValue('parent'));
        $this->getObject()->save();


      }
    }
    // si aucun parent n'est specifie, ajoute/deplace ce noeud pour etre un nouveau noeud racine
    else
    {
      $categoryTree = Doctrine::getTable('Category')->getTree();
      if ($this->isNew())
      {
        $categoryTree->createRoot($this->getObject());
      }
      else
      {
        $this->getObject()->getNode()->makeRoot($this->getObject()->getId());
      }
    }
  }
}
