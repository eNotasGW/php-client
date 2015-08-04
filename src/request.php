<?php
	namespace eNotasGW\Api;

	use \eNotasGW as eNotasGW;
	
	class request {
		/**
		* The url to access on this Request
		* @var string
		*/
		public $url;

		/**
		* The HTTP method to use on this Request. Should be one of 'GET', 'POST', 'PUT' or 'DELETE'
		* @var string
		*/
		public $method = 'GET';

		/**
		* "application/json" or "application/xml"
		* @var string
		*/
		public $accept;

		/**
		* "application/json", "application/xml" or "multipart/form-data"
		* @var string
		*/
		public $contentType;

		/**
		* HTTP Request headers.
		* @var array
		*/
		public $headers = array();

		/**
		* HTTP request params.
		* @var array
		*/
		public $parameters = array(); 

		/**
		* HTTP request timeout.
		* @var int
		*/
		public $timeout = 30000;

		public function setParameter($name, $value) {
			$this->parameters[$name] = $value;
		}

		public function getParameter($name) {
			return $this->parameters[$name];
		}

		public function getRequestBody() {	
			if(empty($this->parameters)) {
				return NULL;
			}
			else {
				return $this->encodeRequestParameters();
			}
		}

		public function encodeRequestParameters() {
			$contentType = $this->contentType;
			$formatter = eNotasGW::getMediaFormatter($contentType);

			if($formatter !== FALSE) {
				$result = $formatter->encode($this->parameters, $contentType);
				$this->contentType = $contentType;
			  
				return $result;              
			}
			  
			return $this->parameters;
		}
	}
?>