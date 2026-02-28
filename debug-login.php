<?php
// Debug login
ob_start();

require_once 'config.php';
require_once 'helpers.php';

session_start();

echo "<h2>Debug de Login</h2>";
echo "<p><strong>BASE_URL:</strong> " . BASE_URL . "</p>";
echo "<p><strong>Sessão:</strong> " . json_encode($_SESSION) . "</p>";
echo "<p><strong>POST:</strong> " . json_encode($_POST) . "</p>";

require_once 'models/LoginModel.php';

$login = new Login();

// Teste com admin/123456
$resultado = $login->getByUsuarioESenha('admin', '123456', false);

echo "<p><strong>Resultado Login:</strong> " . ($resultado ? "Sucesso" : "Falhou") . "</p>";
echo "<p><strong>Sessão após login:</strong> " . json_encode($_SESSION) . "</p>";

ob_end_flush();
