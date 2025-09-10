<?php

# inicializa a sessão, permitindo que ariáveis de sessão sejam criadas e acessadas
session_start();

# capta a URL redireionada no arquivo .htaccess
# strtolower, converte para letras minúsculas
# trim, limpa os caracteres vazios no início e final
$requisicao = trim(strtolower($_SERVER['REQUEST_URI']));

# substituo parte da URL que não é útil
$requisicao = str_replace("/restaurante-mvc/", "", $requisicao);

# divide em partes, usando a / como separador. Cria um array de índices
$segmentos = explode("/", $requisicao);

# verifica o padrão da rota utilizando o array $segmentos explodido
# Remove elementos vazios do array
$segmentos = array_filter($segmentos, function($value) { return $value !== ''; });
$segmentos = array_values($segmentos); // Reindexa o array

$controlador = isset($segmentos[0]) ? $segmentos[0] : "mesa-adm";
$metodo = isset($segmentos[1]) ? $segmentos[1] : "index";
$identificador = isset($segmentos[2]) ? $segmentos[2] : null;

/* mesa/editar/4
  controller -> mesa
  método -> editar
  identificador -> 4
*/

switch ($controlador) {

  case '':
  case 'mesa-adm':
    validaSessao();
    require "controllers/MesaController.php";
    $controller = new MesaController();
    // $controller -> index();
    break;

  case 'cardapio-adm':
    validaSessao();
    require "controllers/CardapioController.php";
    $controller = new CardapioController();
    // $controller -> index();
    break;

  case 'avaliacoes-adm':
    validaSessao();
    require "controllers/AvaliacaoController.php";
    $controller = new AvaliacaoController();
    // $controller -> index();
    break;

  case 'avaliacoes':
    require "controllers/AvaliacaoController.php";
    $controller = new AvaliacaoController();
    break;

  case 'login':
    require "controllers/LoginController.php";
    $controller = new LoginController();
    break;

  case 'cardapio':
    require "controllers/CardapioController.php";
    $controller = new CardapioController();
    $metodo = "ver_cardapio";
    break;

  case 'reserva':
    require "controllers/ReservaController.php";
    $controller = new ReservaController();
    break;

  case 'pizzas':
    require "controllers/PizzaController.php";
    $controller = new PizzaController();
    break;

  case 'contato':
    require "controllers/ContatoController.php";
    $controller = new ContatoController();
    break;

  case 'sair':
    require "controllers/sairController.php";
    $controller = new SairController();
    break;

  case 'usuario-adm':
    validaSessao();
    require "controllers/UsuarioController.php";
    $controller = new UsuarioController();
    break;

  default:
    $baseUrl = "http://localhost:8080";
    header("location: " . $baseUrl . "/views/templates/html/notfound.html");
    break;
}

# chama o método do controlador com ou sem parâmetro $id
if ($identificador) {
  # usado para os métodos exluir e editar, pois ambos usam o identificador
  $controller->$metodo($identificador);
} else {
  # usado para os métodos index e criar
  $controller->$metodo();
}

function validaSessao()
{
  # Verifica se existe sessão OU cookies válidos
  $temSessao = isset($_SESSION["nome_usuario"]);
  $temCookieUsuario = isset($_COOKIE['usuario']);
  $temCookieNivel = isset($_COOKIE['nivelAcesso']);
  
  # Se não tem nem sessão nem cookies, redireciona para login
  if (!$temSessao && !$temCookieUsuario && !$temCookieNivel) {
    $baseUrl = "http://localhost:8080";
    header("location:" . $baseUrl . "/login");
    exit();
  }
}