<?php
	namespace eNotasGW\Api;

	class nfeApi extends eNotasGWApiBase {
		public function __construct($proxy) {
			parent::__construct($proxy);
		}
		
		/**
		 * Emite uma Nota Fiscal
		 * 
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @param mixed $dadosNFe dados da NFe a ser emitida
		 * @return string $nfeId retorna o id único da NFe no eNotas GW
		 */
		public function emitir($idEmpresa, $dadosNFe) {
			$result = $this->callOperation(array(
				'method' => 'POST',
				'path' => '/empresas/{empresaId}/nfes',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa
					),
					'body' => $dadosNFe
				)
			));

			return $result->nfeId;
		}
		
		/**
		 * Cancela uma determinada Nota Fiscal
		 * @param string $nfeId Identificador Único da Nota Fiscal
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @return string $nfeId retorna o id único da NFe no eNotas GW
		 */
		public function cancelar($idEmpresa, $nfeId) {
			$result = $this->callOperation(array(
				'method' => 'DELETE',
				'path' => '/empresas/{empresaId}/nfes/{nfeId}',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'nfeId' => $nfeId
					)
				)
			));
			
			return $result->nfeId;
		}
		
		/**
		 * Cancela uma determinada Nota Fiscal
		 * @param string $idExterno id externo (mapeamento com sistema de origem)
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @return string $nfeId retorna o id único da NFe no eNotas GW
		 */
		public function cancelarPorIdExterno($idEmpresa, $idExterno) {
			$result = $this->callOperation(array(
				'method' => 'DELETE',
				'path' => '/empresas/{empresaId}/nfes/porIdExterno/{idExterno}',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'idExterno' => $idExterno
					)
				)
			));
			
			return $result->nfeId;
		}

		/**
		 * Consulta uma Nota Fiscal pelo Identificador Único
		 * 
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @param string $nfeId Identificador Único da Nota Fiscal
		 * @return	mixed $dadosNFe	retorna os dados da nota como um array
		 */
		public function consultar($idEmpresa, $nfeId) {
			return $this->callOperation(array(
			  'path' => '/empresas/{empresaId}/nfes/{nfeId}',
			  'parameters' => array(
					'path' => array(
						'empresaId' => $idEmpresa,
						'nfeId' => $nfeId
					)
				)
			));
		}

		/**
		 * Consulta uma Nota Fiscal pelo seu id externo (id de mapeamento com sistema de origem)
		 * 
		 * @param string $idEmpresa id da empresa para a qual a nota será emitida
		 * @param string $idExterno id externo (mapeamento com sistema de origem)
		 * @return	mixed $dadosNFe	retorna os dados da nota como um array
		 */
		public function consultarPorIdExterno($idEmpresa, $idExterno) {
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/nfes/porIdExterno/{idExterno}',
				'parameters' => array(
					'path' => array(
						'empresaId' => $idEmpresa,
						'idExterno' => $idExterno
					)
				)
			));
		}

		/**
		* Consulta notas fiscais emitidas em um determinado período
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param int $pageNumber numero da página no qual a pesquisa será feita
		* @param int $pageSize quantidade de registros por página
		* @param string $dataInicial data inicial para pesquisa
		* @param string $dataFinal data final para pesquisa
		* @return searchResult	$listaNFe retorna uma lista contendo os registros encontrados na pesquisa
		*/
		public function consultarPorPeriodo($idEmpresa, $pageNumber, $pageSize, $dataInicial, $dataFinal) {
			$dataInicial = eNotasGWHelper::formatDateTime($dataInicial);
			$dataFinal = eNotasGWHelper::formatDateTime($dataFinal);
		
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/nfes',
				'parameters' => array(
					'path' => array(
						'empresaId' => $idEmpresa
					),
					'query' => array(
						'pageNumber' => $pageNumber,
						'pageSize' => $pageSize,
						'filter' => "dataCriacao ge '{$dataInicial}' and dataCriacao le '{$dataFinal}'"
					)
				)
			));
		}
		
		/**
		* Download do xml de uma Nota Fiscal identificada pelo seu Identificador Único
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param string $nfeId Identificador Único da Nota Fiscal
		* @return string xml da nota fiscal
		*/
		public function downloadXml($idEmpresa, $nfeId) {
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/nfes/{nfeId}/xml',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'nfeId' => $nfeId
					)
				)
			));
		}
		
		/**
		* Download do pdf de uma Nota Fiscal identificada pelo seu id externo (mapeamento com sistema de origem)
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param string $nfeId Identificador Único da Nota Fiscal
		* @return os bytes do arquivo pdf
		*/
		public function downloadPdf($idEmpresa, $nfeId) {
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/nfes/{nfeId}/pdf',
				'decodeResponse' => FALSE,
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'nfeId' => $nfeId
					)
				)
			));
		}
		
		/**
		* Download do xml de uma Nota Fiscal identificada pelo seu id externo (mapeamento com sistema de origem)
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param string $idExterno id externo (mapeamento com sistema de origem)
		* @return string xml da nota fiscal
		*/
		public function downloadXmlPorIdExterno($idEmpresa, $idExterno) {
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/nfes/porIdExterno/{idExterno}/xml',
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'idExterno' => $idExterno
					)
				)
			));
		}
		
		/**
		* Download do xml de uma Nota Fiscal identificada pelo seu id externo (mapeamento com sistema de origem)
		* 
		* @param string $idEmpresa id da empresa para a qual a nota será emitida
		* @param string $idExterno id externo (mapeamento com sistema de origem)
		* @return os bytes do arquivo pdf
		*/
		public function downloadPdfPorIdExterno($idEmpresa, $idExterno) {
			return $this->callOperation(array(
				'path' => '/empresas/{empresaId}/nfes/porIdExterno/{idExterno}/pdf',
				'decodeResponse' => FALSE,
				'parameters' => array(
					'path' => array(
					  'empresaId' => $idEmpresa,
					  'idExterno' => $idExterno
					)
				)
			));
		}
	}
?>
