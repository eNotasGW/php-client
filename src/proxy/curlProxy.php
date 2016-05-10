<?php
	namespace eNotasGW\Api\Proxy;

	class curlProxy extends proxyBase {
		public function __construct($executionCtx) {
			parent::__construct($executionCtx);
		}

		protected function sendRequest($request) {
			$method = strtoupper($request->method);
			$options = array(
				CURLOPT_URL => $request->url,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_TIMEOUT => $request->timeout,
				CURLOPT_SSL_VERIFYHOST => 2,
				CURLOPT_SSL_VERIFYPEER => TRUE,
				CURLOPT_CAINFO => $this->executionCtx->trustedCAListPath
			);
		  
			switch($method) {
				case 'POST':
					$options[CURLOPT_POST] = 1;
					$this->setRequestBody($request, $options);
					break;
				case 'PUT':
					$this->setRequestBody($request, $options);
				case 'DELETE':
					$options[CURLOPT_CUSTOMREQUEST] = $method;
					break;
				default:
					break;
			}
		  
		    //workaround to remove Expectation -> "Expect: 100-continue" that can be a problem in some networks
			$request->headers[] = 'Expect:';
			$request->headers[] = 'Content-Type: ' . $request->contentType;
			$options[CURLOPT_HTTPHEADER] = $request->headers;
			
			$ch = curl_init();
			curl_setopt_array($ch, $options);

			$response = new \eNotasGW\Api\response();
			$response->body = curl_exec($ch);
			$response->contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
			$response->code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if($response->code != 200 && $response->isEmpty()) {
				$response->faultMessage = curl_error($ch);
			}

			return $response;
		}

		private function setRequestBody($request, &$options) {
			$body = $request->getRequestBody();
			$options[CURLOPT_POSTFIELDS] = $body;
		  
			if(is_string($body)) {
				$request->headers[] = 'Content-Length: ' . strlen($body);
			}
		}
	}
?>
