<?php
	namespace eNotasGW\Api;
	
	use \eNotasGW as eNotasGW;

	class response {
		/**
		* HTTP response code
		* @var int
		*/
		public $code = 200;

		/**
		* HTTP response body
		* @var mixed
		*/
		public $body;

		/**
		* "application/json" or "application/xml"
		* @var string
		*/
		public $contentType;

		/**
		* The fault message
		* @var string
		*/
		public $faultMessage;

		public function isEmpty() {
			return $this->body === FALSE;
		}

		public function getResponseData() {
			if($this->isEmpty()) {
				return NULL;
			}
			else {
				return $this->decodeResponse();
			}
		}

		private function decodeResponse() {
			$formatter = eNotasGW::getMediaFormatter($this->contentType);
			
			return $formatter->decode($this->body);
		}
	}
?>