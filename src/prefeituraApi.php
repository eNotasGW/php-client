<?php
	namespace eNotasGW\Api;

	class prefeituraApi extends eNotasGWApiBase {
		public function __construct($proxy) {
			parent::__construct($proxy);
		}

		/**
		* Consulta as características de uma determinada prefeitura
		* 
		*@param int codigoIbge código ibge da cidade cuja a prefeitura será consultada
		*@return mixed contendo as características da prefeitura em questão
		*/
		public function consultar($codigoIbge) {
			return $this->callOperation(array(
				'path' => '/estados/cidades/{codigoIbge}/provedor',
				'parameters' => array(
					'path' => array(
						'codigoIbge' => $codigoIbge
					)
				)
			));
		}
	}
?>
