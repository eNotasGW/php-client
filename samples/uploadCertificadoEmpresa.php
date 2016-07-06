<?php
	header('Content-Type: text/html; charset=utf-8');
	
	require('../src/eNotasGW.php');
	
	use eNotasGW\Api\Exceptions as Exceptions;
	use eNotasGW\Api\fileParameter as fileParameter;

	eNotasGW::configure(array(
		'apiKey' => '{api key}',
	));
	
	$empresaId = '{empresa id}';
	
	try
	{
		$file = fileParameter::fromPath('{certificate file path}.pfx', 
			'application/x-pkcs12', '{file name}.pfx');
		$pass = '{your pass}';
		
		eNotasGW::$EmpresaApi->atualizarCertificado($empresaId, $file, $pass);
		echo 'Certificado atualizado com sucesso!';
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
