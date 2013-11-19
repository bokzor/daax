<?php

require_once dirname(__FILE__) . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration {
	public function setup() {
		$this -> enablePlugins('sfDoctrinePlugin');
		$this -> enablePlugins('sfDoctrineGuardPlugin');
		$this -> enablePlugins('sfImageTransformPlugin');
		$this -> enablePlugins('sfTCPDFPlugin');
	}

	public function configureDoctrine(Doctrine_Manager $manager) {
		$manager -> setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true);
		if(extension_loaded('apc') && ini_get('apc.enabled')){
			$manager -> setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, new Doctrine_Cache_Apc());
		}
		
		$manager -> setCollate('utf8_unicode_ci');
		$manager -> setCharset('utf8');
		$manager -> setAttribute(Doctrine_Core::ATTR_USE_DQL_CALLBACKS, true);

	}

}
