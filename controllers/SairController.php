<?php

class SairController
{
  public $baseUrl = "http://localhost:8080";

  public function index()
  {

    // Remove todas as variáveis de sessão
    $_SESSION = array();

    // Remove os cookies de autenticação se existirem
    if (isset($_COOKIE['usuario'])) {
      setcookie('usuario', '', time() - 3600, "/");
    }
    if (isset($_COOKIE['nivelAcesso'])) {
      setcookie('nivelAcesso', '', time() - 3600, "/");
    }

    // Remove todas as sessões ativas
    session_destroy();

    // Redireciona para o login
    header("Location: " . $this->baseUrl . "/login");
    exit;
  }
}
