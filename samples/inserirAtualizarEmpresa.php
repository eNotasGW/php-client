<?php
	header('Content-Type: text/html; charset=utf-8');
	
	require('../src/eNotasGW.php');
	
	use eNotasGW\Api\Exceptions as Exceptions;
	use eNotasGW\Api\fileParameter as fileParameter;

	class tipoAutenticacao {
		const Nenhuma = 0;
		const Certificado = 1;
		const UsuarioESenha = 2;
		const Token = 3;
		const FraseSecretaESenha = 4;
	}
	
	class tipoAssinaturaDigital {
		const NaoUtiliza = 0;
                const Opcional = 1;
                const Obrigatorio = 2;
	}
		
	eNotasGW::configure(array(
		'apiKey' => '<api key>'
	));
	
	try
	{
		$codigoIbgeCidade = 3106200;
		$caracteristicasPrefeitura = eNotasGW::$PrefeituraApi->consultar($codigoIbgeCidade);
		
		$dadosEmpresa = array(
			//'id' => 'CB09776E-E954-4D75-BBA6-E7A99FF20100', //informar apenas se quiser atualizar uma empresa existente
			'cnpj' => '56308661000199', //sem formatação
			'inscricaoMunicipal' => '12345',
			'inscricaoEstadual' => null,
			'razaoSocial' => 'Empresa de Teste Ltda',
			'nomeFantasia' => 'Empresa de Teste',
			'optanteSimplesNacional' => true,
			'incentivadorCultural' => false,
			'email' => null,
			'telefoneComercial' => '3132323131',
			'endereco' => array(
				'uf' => 'MG', 
				'cidade' => 'Belo Horizonte',
				'logradouro' => 'Rua 01',
				'numero' => '112',
				'complemento' => 'SL 102',
				'bairro' => 'Savassi',
				'cep' => '32323111'
			),
			'regimeEspecialTributacao' => '0', //A lista de valores possíveis deve ser obtida pela api de caraterísticas da prefeitura
			'codigoServicoMunicipal' => '181309901', //código do serviço municipal padrão para emissão de NFS-e
			'descricaoServico' => 'SERVICO DE SERIGRAFIA / SILK-SCREEN', //Descrição do serviço municipal padrão para emissão de NFS-e (utilizado apenas na impressão da NFS-e) 
			'aliquotaIss' => 2.00,
			'configuracoesNFSeProducao' => array(
				'sequencialNFe' => 1,
				'serieNFe' => '2',
				'sequencialLoteNFe' => 1
			),
			'configuracoesNFSeHomologacao' => array(
				'sequencialNFe' => 1,
				'serieNFe' => '2',
				'sequencialLoteNFe' => 1
			)
		);
		
		if($caracteristicasPrefeitura->usaCNAE) {
			$dadosEmpresa->cnae = '1813099';
		}
		
		if($caracteristicasPrefeitura->usaItemListaServico) {
			$dadosEmpresa->itemListaServicoLC116 = '13.05';
		}
		
		if($caracteristicasPrefeitura->tipoAutenticacao == tipoAutenticacao::UsuarioESenha) {
			$dadosEmpresa['configuracoesNFSeProducao']['usuarioAcessoProvedor'] = '[usuario]';
			$dadosEmpresa['configuracoesNFSeProducao']['senhaAcessoProvedor'] = '[senha]';
			
			//opcional, preencher apenas se for emitir em ambiente de homologação
			$dadosEmpresa['configuracoesNFSeHomologacao']['usuarioAcessoProvedor'] = '[usuario]';
			$dadosEmpresa['configuracoesNFSeHomologacao']['senhaAcessoProvedor'] = '[senha]'; 
		}
		else if($caracteristicasPrefeitura->tipoAutenticacao == tipoAutenticacao::Token) {
			$dadosEmpresa['configuracoesNFSeProducao']['tokenAcessoProvedor'] = '[token]';
			
			//opcional, preencher apenas se for emitir em ambiente de homologação
			$dadosEmpresa['configuracoesNFSeHomologacao']['tokenAcessoProvedor'] = '[token]';
		}
	
		$result = eNotasGW::$EmpresaApi->inserirAtualizar($dadosEmpresa);
		$empresaId = $result->empresaId;
		
		echo 'empresa inserida com sucesso!';
		echo '<br />ID: ' . $empresaId;
		echo '<br />';
		echo '<br />';
		
		//Necessita de certificado digital para autenticação ou assinatura da nota?
		if($caracteristicasPrefeitura->assinaturaDigital == tipoAssinaturaDigital::Obrigatorio
			|| $caracteristicasPrefeitura->tipoAutenticacao == tipoAutenticacao::Certificado) {
			
			echo 'inserindo certificado digital... <br /><br />';
			
			$arquivoPfxOuP12 = fileParameter::fromPath('{certificate file path}', 
			'application/x-pkcs12', '{file name}');
			$senhaDoArquivo = '{senha do arquivo .pfx ou .p12}';
			
			eNotasGW::$EmpresaApi->atualizarCertificado($empresaId, $arquivoPfxOuP12, $senhaDoArquivo);
			echo '<br/> Certificado incluído com sucesso!';
		}
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
