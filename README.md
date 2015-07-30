# eNotas GW PHP client

##Simples de usar! 

##Exemplos:

~~~
eNotasGW::configure(array(
	'apiKey' => 'MWVmOGYzYWQtZjVhMy00YjQ1LWI1ZWEtZWY0YTkxODkwMDAw'
));
~~~

###Emitindo uma nota fiscal
~~~
eNotasGW::$NFeApi->emitir(array(
	'idExterno' => '5', //id para mapeamento com sistema de origem (opcional)
	'cliente' => array(
		'nome' => 'Nome Cliente',
		'email' => 'cliente@mail.com',
		'cpfCpnj' => '23857396237',
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
~~~
