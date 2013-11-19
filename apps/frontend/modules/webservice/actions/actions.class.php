<?php

/**
 * webservice actions.
 *
 * @package    spotiz
 * @subpackage webservice
 * "Adrien Bokor <adrien@bokor.be>"

 */
class webserviceActions extends sfActions {

	public function preExecute() {
		$this -> model = $this -> getRequest() -> getParameter('model');

		if (!class_exists($this -> model))
			//$this -> forward('webservice', 'error');
			echo '';
	}

	public function executeList(sfWebRequest $request) {
		if ($request -> isMethod(sfRequest::POST))
			$this -> forward('webservice', 'create');

		$this -> objects = Doctrine_Core::getTable($this -> model) -> findAll();
	}

	public function executeCreate(sfWebRequest $request) {
		$formClass = $this -> model . "Form";
		$form = new $formClass(null, array(), false);

		$form -> bind($request -> getParameter($form -> getName()), $request -> getFiles($form -> getName()));
		$this -> form = $form;
		if ($form -> isValid()){
			$this -> object = $form -> save();
			$this -> setTemplate('find');
		}
	
	}

	public function executeGet(sfWebRequest $request) {
		$id = $request -> getParameter('id');
		$this -> object = Doctrine_Core::getTable($this -> model) -> findOneById($id);
		$this -> forward404Unless($this -> object);
		$this -> setTemplate('find');

	}

	public function executeUpdate(sfWebRequest $request) {
		$id = $request -> getParameter('id');
		// This is used only to retrieve the form name
		$formClass = $this -> model . "Form";
		$form = new $formClass(null, array(), false);
		
		$this -> object = Doctrine_Core::getTable($this -> model) -> findOneById($id);
		$this -> forward404Unless($this -> object);
		$img = $this -> object -> getImg();
		$this -> object -> fromArray($request -> getPostParameter($form -> getName()));

		$this -> object -> save();
		if($this -> object -> getImg() =='')
			$this -> object -> setImg($img);
			$this -> object -> save();
		$this -> setTemplate('find');
	}

	public function executeDelete(sfWebRequest $request) {
		$id = $request -> getParameter('id');

		$this -> object = Doctrine_Core::getTable($this -> model) -> findOneById($id);
		$this -> forward404Unless($this -> object);
		$this -> object -> delete();

		$this -> setTemplate('single');
	}

	public function executeError(sfWebRequest $request) {
		$model = $request -> getParameter('model');

		$this -> getResponse() -> setStatusCode(500);

		$this -> error = ($model != null) ? "Invalid model: " . $model : "Undefined model";
	}

}
