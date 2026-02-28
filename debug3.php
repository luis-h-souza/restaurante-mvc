<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start(); // Começa buffer de output

require_once dirname(__FILE__) . '/config.php';

echo "Config carregado<br>";

session_start();
echo "Session iniciada<br>";

ob_end_flush(); // Termina buffer
?>