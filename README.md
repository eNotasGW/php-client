# eNotas GW PHP client

Wrapper em PHP da API do eNotas Gateway, plataforma de emissâo automática de nota fiscal eletrônica de serviço (NFS-e), Produto (NF-e) e Consumidor (NFC-e).

## Documentação

Abaixo disponibilizamos as documentações oficiais do eNotas Gateway para consulta:
* [Documentação de conceitos para utilização da API do eNotas GW](https://docs.enotasgw.com.br/docs)
* [Documentação referencial dos endpoints da API do eNotas GW](https://docs.enotasgw.com.br/v1/reference)
* [Swagger dos endpoints da API do eNotas GW](https://docs.enotasgw.com.br/v1/reference)

## Instalação eNotas GW PHP client

Para instalar manualmente esta biblioteca, basta clonar o repositório GIT para a sua máquina, conforme imagem abaixo:
![alt tag](https://raw.githubusercontent.com/eNotasGW/images-repository/master/php-client/clonando-repositorio.jpg)

Ou através do comando:

	$ git clone https://github.com/eNotasGW/php-client

### Uso básico

Efetue a configuração da sua API Key que pode ser 


```php
eNotasGW::configure(array(
	'apiKey' => '<sua api key>'
));
```

### Emitindo uma nota fiscal
```php

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
```
