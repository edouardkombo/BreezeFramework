<?php
namespace core;
use core\App as App;

/**
 * Define events before or after httpRequests
 * Your security intelligence must be implemented here
 * 
 * @package core
 * @author Edouard Kombo <edouard.kombo@gmail.com>
 *
 */
class Intercept{
	

	/**
	 * Before htppRequests
	 */
	static function before(){
		/*
		//Clean PHP Environment and variables 
		App::call('xss.manager');
		
		//initialize session
		App::call('session.manager');
		
		//Protect against CSRF attacks
		$csrf = App::call('csrf.manager');
		$csrf::generate();
		$csrf::check($_POST);
		$csrf::check($_GET);
		$csrf::check($_REQUEST);
		$csrf::generate(); //Generate a new token				
		*/
	}

	/**
	 * After httpRequests
	 * 
	 * @return multiple:string|array
	 */
	static function after(){
		//Datas to get after all operations
		
		/*
		 * BY EXAMPLE 
		$session = App::getContainer('session.manager');
		$session->start();
		
		$request = App::getContainer('request.manager');
		
		if($request->getGet('language')){
			$session->set('language', $request->getGet('language'));
			$request->redirect('self');
		}
		*/
	}
}