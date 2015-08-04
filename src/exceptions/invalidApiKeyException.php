<?php
	namespace eNotasGW\Api\Exceptions;
	
	use \Exception as Exception;
	
	class invalidApiKeyException extends apiException {
		public function __construct($httpCode, $errors) {
			parent::__construct($httpCode, $errors);
		}
	}
?>