<?php
function loadEnv($filePath = null)
{
    if ($filePath === null) {
        $filePath = dirname(__FILE__) . '/.env';
    }

    if (!file_exists($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        if (strpos($line, '=') !== false) {
            list($nome, $valor) = explode('=', $line, 2);
            $nome = trim($nome);
            $valor = trim($valor, ' "\'');

            putenv("$nome=$valor");
            $_ENV[$nome] = $valor;
        }
    }
}

# Carrega automaticamente as variáveis de ambiente ao incluir este arquivo
loadEnv();
