<?php

/**
 * Obtém a URL base da aplicação.
 *
 * Regra:
 * - Se existir APP_URL no .env, usa ela (produção/HostGator).
 * - Caso contrário, calcula dinamicamente a partir do SCRIPT_NAME (raiz do app).
 */
function getBaseUrl()
{
    // Prioriza APP_URL definida no .env
    $envUrl = $_ENV['APP_URL'] ?? getenv('APP_URL') ?? null;
    if (!empty($envUrl)) {
        return rtrim($envUrl, '/');
    }

    // Fallback dinâmico (ambiente local)
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? 'localhost');

    // Usa o caminho do script (normalmente /index.php ou /subpasta/index.php)
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/';
    $basePath = str_replace('\\', '/', dirname($scriptName));
    $basePath = rtrim($basePath, '/');

    return $protocol . '://' . $host . $basePath;
}

// Define uma constante global
define('BASE_URL', getBaseUrl());
