<?php
	namespace eNotasGW\Api;

	class servicosMunicipaisApi extends eNotasGWApiBase {
		public function __construct($proxy) {
			parent::__construct($proxy);
		}

		/**
		* Consulta notas fiscais emitidas em um determinado período
		* 
		* @param string $uf sigla do estado
		* @param string $cidade nome da cidade
		* @param int $pageNumber numero da página no qual a pesquisa será feita
		* @param int $pageSize quantidade de registros por página
		* @param string $termoPesquisa termo de pesquisa que será usado para pesquisar
		* @return searchResult	$listaServicosMunicipais retorna uma lista contendo os registros encontrados na pesquisa
		*/
		public function consultar($uf, $cidade, $pageNumber, $pageSize, $termoPesquisa = NULL) {
			return $this->callOperation(array(
				'path' => '/estados/{uf}/cidades/{nome}/servicos',
				'parameters' => array(
					'path' => array(
						'uf' => $uf,
						'nome' => $cidade
					),
					'query' => array(
						'pageNumber' => $pageNumber,
						'pageSize' => $pageSize,
						'filter' => $termoPesquisa != NULL ? "contains(descricao, '{$termoPesquisa}')" : NULL
					)
				)
			));
		}
	}
?>