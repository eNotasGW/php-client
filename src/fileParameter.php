<?php
	namespace eNotasGW\Api;

	class fileParameter {
		public static function fromPath($path, $contentType, $fileName) {
			$rawData = file_get_contents($path);

			return self::fromRawData($rawData, $contentType, $fileName);
		}

		public static function fromRawData($rawData, $contentType, $fileName) {
			$file = new fileParameter();
			$file->rawData = $rawData;
			$file->contentType = $contentType;
			$file->name = $fileName;
		  
			return $file;
		}

		private function __contruct() {
		}

		/**
		* File name
		* @var string
		*/
		public $name;

		/**
		* The file content type, for example: "image/jpeg"
		* @var string
		*/
		public $contentType;

		/**
		* The file Raw Data (bytes)
		* @var array
		*/
		public $rawData;
	}
?>