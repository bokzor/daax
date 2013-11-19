<?php

/**
 * ybRunTaskPlugin configuration.
 *
 * @package     ybRunTaskPlugin
 * @subpackage  config
 * @author      Your name here
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class ybRunTaskPluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '0.1.2';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect('component.method_not_found', array('ybRunTaskListener', 'runTaskMethod'));
    //if(null != sfConfig::get('sf_app')) { // disabled, not a good way to gets logs ...
    //    $this->dispatcher->connect('command.log', array('ybRunTaskListener', 'logSection'));
    //}
  }
}
