<?php
	header('Content-Type: text/html; charset=utf-8');	
	
	require('../src/eNotasGW.php');
	
	use eNotasGW\Api\Exceptions as Exceptions;

	eNotasGW::configure(array(
		'apiKey' => '<api key>'
	));
	
	$empresaId = 'a9f9d282-fdb9-4259-a7b8-2f19be4da06d';
	
	try
	{
		$nfeId = 'ab765f39-a2e0-4c4b-88b4-4b6b4a2baace';
		$dadosNFe = eNotasGW::$NFeApi->consultar($empresaId, $nfeId);
		
		echo 'Dados da nota (consulta por id único): </br>';
		echo json_encode($dadosNFe);
	  
		$idExterno = '1';
		$dadosNFe2 = eNotasGW::$NFeApi->consultarPorIdExterno($empresaId, $idExterno);
		
		echo '</br></br>';
		echo 'Dados da nota (consulta por id externo): </br>';
		echo json_encode($dadosNFe2);
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