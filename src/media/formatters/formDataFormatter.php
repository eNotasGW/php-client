<?php
	namespace eNotasGW\Api\Media\Formatters;

	class formDataFormatter extends formatterBase {
		private static $_notAllowedChars = array("\0", "\"", "\r", "\n");

		public function encode($objData, &$contentType) {
			$body = array();
			$boundary = '---------------------' . md5(mt_rand() . microtime());
			$contentType =  'Content-Type: multipart/form-data; boundary=' . $boundary;

		  if(is_array($objData)) {
			foreach($objData as $name => $value) {
				$name = $this->removeNotAllowedChars($name);

				if(is_a($value, 'eNotasGW\Api\fileParameter')) {
					$this->appendFileParameter($value, $body);   
				}
				else {
					$this->appendParameter($name, $value, $body);
				}
			}
		  }
		  
		  $body[] = "\r\n--" . $boundary . "--\r\n";
		  
		  return $body;
		}

		private function appendParameter($name, $value, $body) {
			$body[] = implode("\r\n", array(
				"Content-Disposition: form-data; name=\"{$name}\"",
				'',
				filter_var($value, FILTER_SANITIZE_STRING), 
			));
		}

		private function appendFileParameter($file, $body) {    
			$fileName = $file->name;

			$body[] = implode("\r\n", array(
				"Content-Disposition: form-data; name=\"{$fileName}\"; filename=\"{$fileName}\"",
				'Content-Type: ' . (isset($file->contentType) ? $file->contentType : 'application/octet-stream'),
				'',
				$file->rawData, 
			));
		}

		private function removeNotAllowedChars($name) {
			return str_replace($self::_notAllowedChars, "_", $name);
		}

		public function decode($encodedData) {
			throw new Exception('This method is not supported');
		}
	}
?>