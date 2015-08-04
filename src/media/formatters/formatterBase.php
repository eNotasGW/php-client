<?php
	namespace eNotasGW\Api\Media\Formatters;

	abstract class formatterBase {
		abstract public function encode($objData, &$contentType);
		abstract public function decode($encodedData);
	}
?>