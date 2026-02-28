<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "1. Iniciando...<br>";

require_once 'config.php';
require_once 'models/DataBase.php';

echo "2. Arquivos carregados<br>";

session_start();
echo "3. Sessão iniciada<br>";

$requisicao = trim(strtolower($_SERVER['REQUEST_URI']));
echo "4. REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "5. Requisição após trim: " . $requisicao . "<br>";

$requisicao = ltrim($requisicao, '/');
echo "6. Requisição após ltrim: " . $requisicao . "<br>";

$segmentos = explode("/", $requisicao);
echo "7. Segmentos: " . json_encode($segmentos) . "<br>";

$segmentos = array_filter($segmentos, function ($value) {
    return $value !== '';
});
echo "8. Segmentos após filter: " . json_encode($segmentos) . "<br>";

$segmentos = array_values($segmentos);
echo "9. Segmentos após reindex: " . json_encode($segmentos) . "<br>";

$controlador = isset($segmentos[0]) ? $segmentos[0] : "mesa-adm";
$metodo = isset($segmentos[1]) ? $segmentos[1] : "index";

echo "10. Controlador: " . $controlador . "<br>";
echo "11. Método: " . $metodo . "<br>";

echo "Fim do debug2<br>";
