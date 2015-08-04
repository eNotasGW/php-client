<?php
	namespace eNotasGW\Api\Exceptions;
	
	use \Exception as Exception;
	
	class unauthorizedException extends apiException {	
		public function __construct($httpCode, $errors) {
			parent::__construct($httpCode, $errors);
		}
	}
?>