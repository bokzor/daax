<?php

class ybRunTaskListener {
    static $logs = array();

    static public function runTaskMethod(sfEvent $event) {
        if('runTask' == $event['method']) {
            // called runtask within an action
            self::runTask($event);
            return true;
        }
        // this is not runTask, letting the dispatcher doing it's job
        return false;
    }

    static protected function runTask(sfEvent $event) {
        $parameters = $event->getParameters();

        // the command name
        $method = $parameters['arguments'][0];
        $dispatcher = $dispatcher = sfContext::getInstance()->getEventDispatcher();

        // changing from web to symfony root path
        chdir(sfConfig::get('sf_root_dir'));
        // creating a sfSymfonyCommandApplication just to be able to call getTaskToExecute
        // the sfSymfonyCommandApplication WANTS the symfony_lib_dir
        $baseTask = new sfSymfonyCommandApplication($dispatcher, new sfFormatter(), array('symfony_lib_dir' => sfConfig::get('sf_lib_dir')));
        // default args
        $parameters['options']      = array_key_exists(1, $parameters['arguments']) ? $parameters['arguments'][1] : array();
        $parameters['attributes']   = array_key_exists(2, $parameters['arguments']) ? $parameters['arguments'][2] : array();

        // magic: returning the task we want to launch
        $task = $baseTask->getTaskToExecute($method);
        $msg = '';
        try {
            $ret = $task->run($parameters['options'], $parameters['attributes']);
        } catch(sfException $e) {
            //$e->getMessage();
            //$msg = $e->getMessage();
            $event->setReturnValue($e);
        }
        //$event->setReturnValue(implode("\n", self::$logs)."\n".$msg);
        return $event;
    }

/*
 *  disabled, didn't find yet a way to get and return logs in a proper way ..
 *
    static public function _logSection(sfEvent $event) {
        self::_logSection($event);
        return true;
    }


    static public function logSection(sfEvent $event) {
        $parameters = $event->getParameters();
        sfContext::getInstance()->getLogger()->info($parameters[0]);
        self::$logs[] = $parameters[0];
        echo 'called ...';
        //return $event;
        return true;
    }
*/
}
