<?php

class ContatoController 
{
  private $baseUrl = "http://localhost:8080";
  # endereço da API
  private $endpoint = "https://limeiraweb.com.br/api/enderecos/";
  
  # métodd de leitura da API
  public function index() {

    # cURL é uma biblioteca para requisições HTTP
    $curl = curl_init($this->endpoint);

    # informar que ele deverá seguir redirecionamento, caso houver
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    
    # configurar a resposta como string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    # desativar a verificação SSL
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    # executa a requisição e captura a resposta
    $resposta = curl_exec($curl);

    # obter informações da requisição para tratamento de erros
    $informacoes = curl_getinfo($curl);
    $codigo_http = $informacoes['http_code'];

    # Faz o tratamento de erros de acordo com o código da resposta
    if ($codigo_http < 200 || $codigo_http >= 300) {
      $erro = "Não foi possível obter os dados." . "<strong> Código HTTP: {$codigo_http}</strong>";
    } else {
      # converte a resposta JSON em um array associtivo do PHP
      $lista_de_contatos = json_decode($resposta, true);
    }

    # fechar a requisição
    curl_close($curl);

    $baseUrl = $this->baseUrl;
    require "views/ContatoView.php";
  }
}