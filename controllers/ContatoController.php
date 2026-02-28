<?php

class ContatoController 
{
  private $baseUrl;

  public function __construct()
  {
    $this->baseUrl = BASE_URL;
  }
  
  # métodd de leitura da API
  public function index() {

    $baseUrl = $this->baseUrl;
    require "views/ContatoView.php";
  }
}
