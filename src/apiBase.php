<?php
	namespace eNotasGW\Api;

	class eNotasGWApiBase {
		protected $proxy;

		public function __construct($proxy) {
			$this->proxy = $proxy;
		}

		protected function callOperation($operation) {
			return $this->proxy->doRequest($operation);
		}
	}
?>