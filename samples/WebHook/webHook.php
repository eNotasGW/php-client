<?php
	header('Content-Type: text/html; charset=utf-8');	
	
	require('..\..\src\eNotasGW.php');
	
	function handleException($ex) {
		//reportar que houve erro no processamento da notificação
		header('HTTP/1.1 500 Internal Server Error');
	}
  
	function handleError($errno, $errstr, $errfile, $errline) {
		//reportar que houve erro no processamento da notificação
		header('HTTP/1.1 500 Internal Server Error');
	}

	set_exception_handler('handleException');
	set_error_handler("handleError");

	eNotasGW::configure(array(
		'apiKey' => '<api key>'
	));
	
	function downloadXml($empresaId, $nfeId, $nfeNumero) {
		$xml = eNotasGW::$NFeApi->downloadXml($empresaId, $nfeId);
		file_put_contents("Notas\Autorizadas\NF-{$nfeNumero}.xml", $xml);
	}
	
	function downloadPdf($empresaId, $nfeId, $nfeNumero) {
		$pdf = eNotasGW::$NFeApi->downloadPdf($empresaId, $nfeId);
		file_put_contents("Notas\Autorizadas\NF-{$nfeNumero}.pdf", $pdf);
	}
	
	function gerarLogNFeNegada($id, $motivoStatus) {
		file_put_contents("Notas\Negadas\NF-{$id}-erros.txt", $motivoStatus);
	}
	
	$postContent = file_get_contents("php://input");
	
	if(!empty($postContent)) {
		$formatter = eNotasGW::getMediaFormatter($_SERVER['CONTENT_TYPE']);
		$webHookData = $formatter->decode($postContent);
		
		switch(strtolower($webHookData->nfeStatus)) {
			case 'autorizada':
				downloadXml($webHookData->empresaId, $webHookData->nfeId, $webHookData->nfeNumero);
				downloadPdf($webHookData->empresaId, $webHookData->nfeId, $webHookData->nfeNumero);
				break;
			case 'negada':
				gerarLogNFeNegada((empty($webHookData->nfeIdExterno) ? $webHookData->nfeId : $webHookData->nfeIdExterno), 
					$webHookData->nfeMotivoStatus);
				break;
			case 'cancelada':
				if(!empty($webHookData->nfeNumero)) {
					//download do pdf atualizado (com carimbo de cancelada)
					downloadPdf($webHookData->empresaId, $webHookData->nfeId, $webHookData->nfeNumero);
				}
				break;
			default:
				break;
		}
	}
?>