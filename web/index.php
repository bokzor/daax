<?php
ini_set(‘memory_limit’,’128M’);
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR', 'fra');

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
sfContext::createInstance($configuration)->dispatch();

