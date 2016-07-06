<?php
	namespace eNotasGW\Api;

	class empresaApi extends eNotasGWApiBase {
		public function __construct($proxy) {
			parent::__construct($proxy);
		}
		
		/**
		 * Atualiza a logo da empresa
		 * 
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @param fileParameter $file imagem a ser utilizada como logo.
		 */
		public function atualizarLogo($idEmpresa, $file) {
			$this->callOperation(array(
				'method' => 'POST',
				'decodeResponse' => FALSE,
				'path' => '/empresas/{empresaId}/logo',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa
					),
					'form' => array(
						'logotipo' => $file
					)
				)
			));
		}
		
		/**
		 * Atualiza o certificado digital da empresa
		 * 
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @param fileParameter $file arquivo do certificado.
		 * @param string $pass senha do certificado.
		 */
		public function atualizarCertificado($idEmpresa, $file, $pass) {
			$this->callOperation(array(
				'method' => 'POST',
				'decodeResponse' => FALSE,
				'path' => '/empresas/{empresaId}/certificadoDigital',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa
					),
					'form' => array(
						'arquivo' => $file,
						'senha' => $pass
					)
				)
			));
		}
	}
?>
