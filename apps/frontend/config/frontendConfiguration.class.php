<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
  	$this->dispatcher->connect( 'presta_sitemap.generate_urls', array( 'sitemapUtils', 'generateSitemapEntries' ) );
	
  }
}
