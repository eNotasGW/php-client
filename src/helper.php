<?php
	namespace eNotasGW\Api;

	class eNotasGWHelper {
		public static function formatDate($date) {
			return $date->format('Y-m-d');
		}

		public static function formatDateTime($date) {
			return $date->format('Y-m-d H:i:s');
		}
	}
?>
