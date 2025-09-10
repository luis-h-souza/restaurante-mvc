<?php

class SairController {

  public $baseUrl = "http://localhost:8080";

  public function index() {

    # inicia a sessão para poder destruí-la
    session_start();

    # remove todas as variáveis de sessão
    $_SESSION = array();

    # remove os cookies de autenticação se existirem
    if (isset($_COOKIE['usuario'])) {
      setcookie('usuario', '', time() - 3600, "/");
    }
    if (isset($_COOKIE['nivelAcesso'])) {
      setcookie('nivelAcesso', '', time() - 3600, "/");
    }

    # remove todas as sessões ativas
    session_destroy();

    # redireciona para o login
    header("location:" . $this->baseUrl . "/login");
  }

}