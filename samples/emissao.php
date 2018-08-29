<?php
	header('Content-Type: text/html; charset=utf-8');
	
	require('../src/eNotasGW.php');
	
	use eNotasGW\Api\Exceptions as Exceptions;

	eNotasGW::configure(array(
		'apiKey' => '<api key>'
	));
	
	$empresaId = '{empresa id}';
	$idExterno = '{id de mapeamento no sistema de origem}';
	
	try
	{
		$nfeId = eNotasGW::$NFeApi->emitir($empresaId, array(
			'tipo' => 'NFS-e',
			'idExterno' => $idExterno,
			'ambienteEmissao' => 'Homologacao', //'Homologacao' ou 'Producao'		
			'cliente' => array(
				'nome' => 'Fulano de Tal',
				'email' => 'fulano@mail.com',
				'cpfCnpj' => '23857396237',
				'tipoPessoa' => 'F', //F - pessoa física | J - pessoa jurídica
				'endereco' => array(
					'uf' => 'MG', 
					'cidade' => 'Belo Horizonte',
					'logradouro' => 'Rua 01',
					'numero' => '112',
					'complemento' => 'AP 402',
					'bairro' => 'Savassi',
					'cep' => '32323111'
				)
			),
			'servico' => array(
				'descricao' => 'Discriminação do Serviço prestado'
			),
			'valorTotal' => 10.05
		));
		
		echo 'Sucesso! </br>';
		echo "ID da NFe: {$nfeId}";
	}
	catch(Exceptions\invalidApiKeyException $ex) {
		echo 'Erro de autenticação: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\unauthorizedException $ex) {
		echo 'Acesso negado: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\apiException $ex) {
		echo 'Erro de validação: </br></br>';
		echo $ex->getMessage();
	}
	catch(Exceptions\requestException $ex) {
		echo 'Erro na requisição web: </br></br>';
		
		echo 'Requested url: ' . $ex->requestedUrl;
		echo '</br>';
		echo 'Response Code: ' . $ex->getCode();
		echo '</br>';
		echo 'Message: ' . $ex->getMessage();
		echo '</br>';
		echo 'Response Body: ' . $ex->responseBody;
	}
?>
