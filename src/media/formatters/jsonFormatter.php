<?php
	namespace eNotasGW\Api\Media\Formatters;

	class jsonFormatter extends formatterBase {
		public function encode($objData, &$contentType) {
			$contentType = 'application/json';

			return json_encode($objData);
		}

		public function decode($encodedData) {
			return json_decode($encodedData);
		}
	}
?>