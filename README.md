# eNotas GW PHP client

Client escrito na linguagem PHP da API do eNotas Gateway, plataforma de emissâo automática de nota fiscal eletrônica de serviço (NFS-e), Produto (NF-e) e Consumidor (NFC-e).

**Atenção: Esta biblioteca deve ser utilizada para a emissão de NFS-e (Nota fiscal de Serviço), caso você deseje emitir NF-e (Nota Fiscal de Produto) ou NFC-e (Nota Fiscal ao Consumidor) utilize a**
[bilioteca php-client-v2](https://github.com/eNotasGW/php-client-v2)
<a href="http://example.com/" target="_blank">Hello, world!</a>
## Documentação

Abaixo disponibilizamos as documentações oficiais do eNotas Gateway para consulta:
* [Documentação de conceitos para utilização da API do eNotas GW](https://docs.enotasgw.com.br/docs)
* [Documentação referencial dos endpoints da API do eNotas GW](https://docs.enotasgw.com.br/v1/reference)
* [Swagger dos endpoints da API V1 do eNotas GW](http://app.enotasgw.com.br/docs)

Além disso também consideramos que seja muito importante que você entenda como é o fluxo geral para a emissão de uma nota fiscal, para isso leia a documentação a seguir:
* [Fluxo Geral para a emissão de uma nota fiscal](https://docs.enotasgw.com.br/docs/fluxo-geral)

## Instalação eNotas GW PHP client

Para instalar manualmente esta biblioteca, basta clonar o repositório GIT para a sua máquina, conforme imagem abaixo:
![Clonando um repositório Github](https://raw.githubusercontent.com/eNotasGW/images-repository/master/php-client/clonando-repositorio.jpg)

Ou através do comando:

	$ git clone https://github.com/eNotasGW/php-client


## Para utilizar o nosso cliente é fácil, veja:

Após baixar os arquivos disponibilizados aqui, basta que você copie estes arquivos para a pasta da sua aplicação e faça referência à classe eNotasGW.php e, além disso você também precisará de duas informações:

* [API Key](https://docs.enotasgw.com.br/v1/docs/como-obter-a-sua-api-key)
* [Id da Empresa](https://docs.enotasgw.com.br/v1/docs/como-obter-o-id-da-empresa)



Abaixo um exemplo simples para a emissão de nota fiscal:
```php
<?php
	header('Content-Type: text/html; charset=utf-8');	
	
	require('../src/eNotasGW.php');
	
	eNotasGW::configure(array(
		'apiKey' => '<sua api key>'
	));
	
	$idEmpresa = '484FB0C5-969E-46AD-A047-8A0DB54667B4';

	eNotasGW::$NFeApi->emitir($idEmpresa, array(
		'tipo' => 'NFS-e',
		'idExterno' => '5', //id para mapeamento com sistema de origem (opcional)
		'ambienteEmissao' => 'Homologacao', //'Homologacao' ou 'Producao'
		'cliente' => array(
			'nome' => 'Nome Cliente',
			'email' => 'cliente@mail.com',
			'cpfCnpj' => '23857396237',
			'tipoPessoa' => 'F',
			'endereco' => array(
				'uf' => 'MG', 
				'cidade' => 'Belo Horizonte',
				'logradouro' => 'Rua 01',
				'numero' => '112',
				'bairro' => 'Savassi',
				'cep' => '32323111'
			)
		),
		'servico' => array(
			'descricao' => 'Discriminação do serviço prestado'
		),
		'valorTotal' => 10.05
	));
?>
```

### Precisa de mais exemplos? Sem problemas! ;)

Todos os nossos exemplos podem ser encontrados na pasta "samples":
* [Clique aqui para ir para a pasta de exemplos](samples/)

Ou se preferir, você pode ir diretamente para o arquivo que desejar:
* [Emitindo uma nota fiscal](samples/emissao.php)
* [Cancelando uma nota fiscal emitida](samples/cancelamento.php)
* [Consultando uma nota fiscal](samples/consulta.php)
* [Baixando o PDF de uma nota fiscal emitida](samples/downloadPdf.php)
* [Baixando o XML uma nota fiscal emitida](samples/downloadXml.php)
* [Inserir ou Atualizar uma empresa](samples/inserirAtualizarEmpresa.php)
* [Enviar o certificado de uma empresa](samples/uploadCertificadoEmpresa.php)
* [Enviar o logo de uma empresa](samples/uploadLogoEmpresa.php)
