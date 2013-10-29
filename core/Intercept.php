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
		
		//Your security code here
	}

	/**
	 * After httpRequests
	 * 
	 * @return multiple:string|array
	 */
	static function after(){
		
		//Your code here
	}
}