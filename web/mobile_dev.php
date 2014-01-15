<?php
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR', 'fra');
// this check prevents access to debug front controllers that are deployed by accident to production servers.
// feel free to remove this, extend it or make something more sophisticated.

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('mobile', 'prod', true);
sfContext::createInstance($configuration)->dispatch();


