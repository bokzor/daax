<?php

require_once dirname(__FILE__).'/../lib/BasesfGuardRegisterComponents.class.php';

class sfGuardRegisterComponents extends BasesfGuardRegisterComponents
{
  public function executeRegister($request)
  {
    $class = sfConfig::get('app_sf_guard_plugin_register_form', 'sfGuardRegisterForm');
    $this->registerForm = new $class();
  }
}