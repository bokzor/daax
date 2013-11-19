<?php

/**
 * websocket actions.
 *
 * @package    spotiz
 * @subpackage websocket
 * @author     Adrien Bokor <adrien@bokor.be>

 */
class websocketActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  { 
	 $myWebServer = new MyWebServer(MyWebServer::ADDRESS_ANY, 8080);
	 $myWebServer->Start();
   $myWebServer->send('test');
  }

  public function executeTest(sfWebRequest $request){

  }
}



