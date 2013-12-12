<?php

/**
 * ArticleElement form.
 *
 * @package    spotiz
 * @subpackage form
 * "Adrien Bokor <adrien@bokor.be>"
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ArticleElementForm extends BaseArticleElementForm
{
	public function configure() {
		unset( $this['article_id'] );

		$this -> widgetSchema['element_id'] = new sfWidgetFormDoctrineChoice( array( 
			'model' => $this->getRelatedModelName( 'Element' ), 
			'add_empty' => true, 
			'query' => Doctrine::getTable('Element')->createQuery('c')->orderBy('c.name ASC')))  ) );

	}
}
