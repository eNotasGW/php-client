<?php
	namespace eNotasGW\Api\Exceptions;
	
	use \Exception as Exception;
	
	class apiException extends Exception {
		public $errors;

		public function __construct($httpCode, $errors) {
			$this->errors = $errors;
			$message = $this->formatMessage();
			
			parent::__construct($message, $httpCode, null);
		}
  
		protected function formatMessage() {	
			$message = '';
			$padding = '';

			if(is_array($this->errors)){
				foreach ($this->errors as &$error) {
					$message .= $padding . "{$error->codigo} - {$error->mensagem}";
					$padding = PHP_EOL;
				}
			} else {
				$message .= $padding . "{$this->errors->Message}";
				$padding = PHP_EOL;
			}
			
			return $message;
		}
	}
?>