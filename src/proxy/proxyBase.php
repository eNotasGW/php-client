<?php
	namespace eNotasGW\Api\Proxy;
	
	use \Exception as Exception;
	use eNotasGW\Api\Exceptions as Exceptions;
	
	abstract class proxyBase {
		public $executionCtx;

		public function __construct($executionCtx) {
		$this->executionCtx = (object)$executionCtx;
		}

		/**
		* Perform a request to the specified operation
		* @param array the operation info.
		*
		* For example:
		*
		* array(
		*   'path' => '/empresa/{empresaId}/certificadoDigital',
		*   'contentType' => 'multipart/form-data',
		*   'parameters' = array(
		  *     path => array(
		*       'empresaId' => '{24234-42342423-42442-43423}'
		*     ),
		*     form = array(
		*       'certificado' => $certificateRawData,
		*      'senha' => $certificatePassword
		*     )
		*  );
		*
		* @return $response
		*/
		public function doRequest($operation) {
			$operation = (object)$operation;
			$executionCtx = $this->executionCtx;
			$decodeResponse = (isset($operation->decodeResponse) ? $operation->decodeResponse : TRUE);

			$request = new \eNotasGW\Api\request();
			$request->url = $this->buildUrl($operation);

			if(!empty($operation->method)) {
				$request->method = $operation->method;
			}

			$request->headers = $this->getDefaultHeaders($operation);
			$request->contentType = (isset($operation->contentType) ? $operation->contentType : $executionCtx->defaultContentType);

			$this->appendParameters($request, $operation->parameters);
			$response = $this->sendRequest($request);

			if($response->code != 200) {			
				if($response->isEmpty() || $response->code == 404) {
					throw new Exceptions\requestException($response->code, $response->faultMessage, 
															$request->url, $response->body);
				}
				else {
					$errors = $response->getResponseData();
					
					switch($response->code) 
					{
						case 401:
							throw new Exceptions\invalidApiKeyException($response->code, $errors);
						case 403:
							throw new Exceptions\unauthorizedException($response->code, $errors);
						default:
							throw new Exceptions\apiException($response->code, $errors);
					}
				}
			}

			if($decodeResponse) {
				return $response->getResponseData();
			}

			return $response->body;
		}

		abstract protected function sendRequest($request);
	  
		private function getDefaultHeaders($operation) {
			$executionCtx = $this->executionCtx;

			$headers = array(
				'Accept: ' . $executionCtx->defaultContentType,
				'Authorization: Basic ' . $executionCtx->apiKey
			);

			return $headers;
		}
	  
		private function appendParameters($request, $params) {
			if(!empty($params['body'])) {
				$request->parameters = $params['body'];
			}
			else if(!empty($params['form'])) {
				$request->parameters = $params['form'];
				//force request to be a form-data
				$request->contentType = 'multipart/form-data';
			}
		}
	  
		private function buildUrl($operation) {
			$path = $operation->path;
			$params = $operation->parameters;

			if($params !== FALSE) {
				if(!empty($params['path'])) {
					$pathParams = $params['path'];

					foreach($pathParams as $name => $value) {
						$path = str_replace('{' . $name . '}', rawurlencode($value), $path);
					}
				}
			  
				if(!empty($params['query'])) {
					$path .= '?' . http_build_query($params['query']);
				}
			}

			return $this->executionCtx->baseUrl . $path;
		}
	}
?>
