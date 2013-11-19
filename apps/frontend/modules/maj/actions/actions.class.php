<?php

/**
 * maj actions.
 *
 * @package    spotiz
 * @subpackage maj
 * @author     Adrien Bokor <adrien@bokor.be>
 */
class majActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeBackup( sfWebRequest $request ) {

		$q = Doctrine::getTable( 'Category' )->createQuery( 'a' );
		$category = $q->fetchArray();

		print_r( $category );
		file_put_contents( sfConfig::get( 'sf_config_dir' ).'/doctrine/schemadsqd.yml', <<<EOF
Product:
  columns:
    name:           { type: string(255), notnull: true }
    price:          { type: decimal, notnull: true }

ProductPhoto:
  columns:
    product_id:     { type: integer }
    filename:       { type: string(255) }
    caption:        { type: string(255), notnull: true }
  relations:
    Product:
      alias:        Product
      foreignType:  many
      foreignAlias: Photos
      onDelete:     cascade
EOF
		);


	}
}
